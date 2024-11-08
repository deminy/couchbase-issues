<?php

declare(strict_types=1);

use Couchbase\Cluster;
use Couchbase\ClusterOptions;

$connectionString = "couchbase://{$_SERVER['COUCHBASE_HOST']}?detailed_errcodes=1&operation_timeout=8&ssl=no_verify&wait_for_config=true";
echo "Connecting to $connectionString", PHP_EOL;

$options = new ClusterOptions();
$options->credentials($_SERVER['COUCHBASE_USER'], $_SERVER['COUCHBASE_PASS']);
$cluster    = new Cluster($connectionString, $options);
$collection = $cluster->bucket($_SERVER['COUCHBASE_BUCKET'])->defaultCollection();

// We use environment variables to determine if a GET operation should be performed.
if (!empty($_SERVER['COUCHBASE_GET'])) {
    $collection->get('foo');
}

echo 'Done', PHP_EOL;
