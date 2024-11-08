<?php

declare(strict_types=1);

require_once $_SERVER['HOME'] . '/.composer/vendor/autoload.php';

use Couchbase\Cluster;
use Couchbase\ClusterOptions;

if (empty($_SERVER['COUCHBASE_CERTIFICATE']) || !is_readable($_SERVER['COUCHBASE_CERTIFICATE'])) {
    exit("Couchbase certificate not found or not readable.");
}

$connectionString = "couchbases://{$_SERVER['COUCHBASE_HOST']}?trust_certificate={$_SERVER['COUCHBASE_CERTIFICATE']}";
echo "Connecting to $connectionString", PHP_EOL;

$options = new ClusterOptions();
$options->credentials($_SERVER['COUCHBASE_USER'], $_SERVER['COUCHBASE_PASS']);
$options->enableTracing(true);
$options->enableDnsSrv(true);
$options->enableTls(true);
// $options->trustCertificate($_SERVER['COUCHBASE_CERTIFICATE']); // TLS certificate can only be set via connection string.
//$options->tlsVerify('peer');
$cluster    = new Cluster($connectionString, $options);
$collection = $cluster->bucket($_SERVER['COUCHBASE_BUCKET'])->defaultCollection();

// We use environment variables to determine if a GET operation should be performed.
if (!empty($_SERVER['COUCHBASE_GET'])) {
    $collection->get('foo');
}

echo 'Done', PHP_EOL;
