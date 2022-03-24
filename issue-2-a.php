<?php

declare(strict_types=1);

use Couchbase\Cluster;
use Couchbase\ClusterOptions;

$options = new ClusterOptions();
$options->credentials('username', 'password');
$cluster = new Cluster('couchbase://couchbase', $options);
$collection = $cluster->bucket('test')->defaultCollection();

$key1 = uniqid('key');

$collection->removeMulti([$key1]); // First, try to remove the item if exists.
$collection->upsert($key1, 'dummy'); // Insert the item.

$collection->getAndLock($key1, 0); // Get and lock the 1st item forever.

sleep(12); // Sleep for 12 seconds.

$collection->getAndLock($key1, 0); // Get and lock the 1st item forever. (again!)

/**
 * Here is what we saw in the output when the script was executed:
 *
 * Fatal error: Uncaught Couchbase\KeyExistsException: LCB_ERR_DOCUMENT_LOCKED (303) in /var/www/issue-2-a.php:22
 * Stack trace:
 * #0 /var/www/issue-2-a.php(22): Couchbase\Collection->getAndLock('key623bface9dc2...', 0)
 * #1 {main}
 * thrown in /var/www/issue-2-a.php on line 22
 * [cb,WARN] (retryq L:164 I:716839824) Failing command (pkt=0x559686b598c0, opaque=3, retries=22, now=105311907ms, spent=2503281us, status=0x09) requested error: LCB_ERR_TIMEOUT (201), from retry queue: LCB_ERR_DOCUMENT_LOCKED (303)
 */
