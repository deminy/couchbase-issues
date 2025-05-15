<?php

declare(strict_types=1);

if (explode('.', (phpversion('couchbase') ?: ''))[0] === '4') { // Couchbase 4?
    require_once $_SERVER['HOME'] . '/.composer/vendor/autoload.php';
}

use Couchbase\Cluster;
use Couchbase\ClusterOptions;

$options = new ClusterOptions();
$options->credentials('username', 'password');
$cluster    = new Cluster("couchbase://{$_SERVER['COUCHBASE_HOST']}", $options);
$collection = $cluster->bucket('test')->defaultCollection();

$collection->removeMulti(['foo']); // First, try to remove the item if exists.
$collection->insert('foo', uniqid());
$collection->unlock('foo', $collection->get('foo')->cas());

echo 'Done', PHP_EOL;
