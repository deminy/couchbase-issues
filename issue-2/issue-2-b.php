<?php

declare(strict_types=1);

use Couchbase\Cluster;
use Couchbase\ClusterOptions;

$options = new ClusterOptions();
$options->credentials('username', 'password');
$cluster = new Cluster('couchbase://couchbase', $options);
$collection = $cluster->bucket('test')->defaultCollection();

$key1 = uniqid('key');
$key2 = "{$key1}-2";

$collection->removeMulti([$key1, $key2]); // First, try to remove the items if exists.
$collection->upsertMulti([[$key1, 'dummy'], [$key2, 'dummy']]); // Insert the items.

$collection->getAndLock($key1, 0); // Get and lock the 1st item forever.

for ($i = 0; $i < 2; $i++) {
    try {
        $collection->getAndLock($key2, 11); // Get and lock the 2nd item for 11 seconds. (twice!)
    } catch (Exception $e) {
    }
}

sleep(12); // Sleep for 12 seconds.

$collection->getAndLock($key2, 1); // Get and lock the 2nd item for 1 second.

$collection->getAndLock($key1, 0); // Get and lock the 1st item forever. (again!)

/**
 * Here is what we saw in the output when the script was executed:
 *
 * [cb,WARN] (retryq L:164 I:1379915665) Failing command (pkt=0x55a82b36f170, opaque=3, retries=22, now=105683854ms, spent=2502381us, status=0x09) requested error: LCB_ERR_TIMEOUT (201), from retry queue: LCB_ERR_DOCUMENT_LOCKED (303)
 */
