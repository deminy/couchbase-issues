<?php

declare(strict_types=1);

require_once $_SERVER['HOME'] . '/.composer/vendor/autoload.php';

use Couchbase\Cluster;
use Couchbase\ClusterOptions;

# @see https://github.com/couchbase/couchbase-php-client/blob/4.2.4/90-couchbase.ini#L10
ini_set('couchbase.log_level', 'trace');

if (empty($_SERVER['COUCHBASE_CERTIFICATE']) || !is_readable($_SERVER['COUCHBASE_CERTIFICATE'])) {
    exit("Couchbase certificate not found or not readable.");
}

$connectionString = "couchbase://{$_SERVER['COUCHBASE_HOST']}";
echo "Connecting to $connectionString", PHP_EOL;

$options = new ClusterOptions();
$options->credentials($_SERVER['COUCHBASE_USER'], $_SERVER['COUCHBASE_PASS']);
$options->enableTracing(true);
//$options->trustCertificate($_SERVER['COUCHBASE_CERTIFICATE']);
//$options->tlsVerify('peer');
//$options->enableTls(true);
$cluster    = new Cluster($connectionString, $options);
$collection = $cluster->bucket($_SERVER['COUCHBASE_BUCKET'])->defaultCollection();

// We use environment variables to determine if a GET operation should be performed.
if (!empty($_SERVER['COUCHBASE_GET'])) {
    $collection->get('foo');
}

echo 'Done', PHP_EOL;
