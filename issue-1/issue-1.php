<?php

declare(strict_types=1);

use Couchbase\Cluster;
use Couchbase\ClusterOptions;

$options = new ClusterOptions();
$options->credentials('username', 'password');
$cluster = new Cluster('couchbase://couchbase', $options);
$collection = $cluster->bucket('test')->defaultCollection();

$key = uniqid('key');
$lockTime = 5000; // To lock the item for 5 seconds.

$collection->removeMulti([$key]); // First, remove the item if exists.

$collection->insert($key, 'dummy'); // Now, insert a new item.

$doc = $collection->getAndLock($key, $lockTime); // Lock the item for 5 seconds.
$collection->unlock($key, $doc->cas()); // // Unlock the item manually.

$collection->getAndLock($key, $lockTime); // Lock the item for 5 seconds.
sleep(7); // Sleep for 7 seconds.
$collection->getAndLock($key, $lockTime); // Error happens here: LCB_ERR_DOCUMENT_LOCKED.
