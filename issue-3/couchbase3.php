<?php

declare(strict_types=1);

use Couchbase\Cluster;
use Couchbase\ClusterOptions;

# @see https://github.com/couchbase/php-couchbase/blob/v3.2.2/api/couchbase.php#L5
ini_set('couchbase.log_level', 'TRACE');

if (empty($_SERVER['COUCHBASE_CERTIFICATE']) || !is_readable($_SERVER['COUCHBASE_CERTIFICATE'])) {
    exit("Couchbase certificate not found or not readable.");
}

$connectionString = "couchbases://{$_SERVER['COUCHBASE_HOST']}?network=external&detailed_errcodes=1&operation_timeout=8&wait_for_config=true&truststorepath={$_SERVER['COUCHBASE_CERTIFICATE']}";
echo "Connecting to $connectionString", PHP_EOL;

$options = new ClusterOptions();
$options->credentials($_SERVER['COUCHBASE_USER'], $_SERVER['COUCHBASE_PASS']);
$cluster    = new Cluster($connectionString, $options);
$collection = $cluster->bucket($_SERVER['COUCHBASE_BUCKET'])->defaultCollection();

$collection->set('foo', random_bytes(12));
echo $collection->get('foo'), PHP_EOL;

echo 'Done', PHP_EOL;
