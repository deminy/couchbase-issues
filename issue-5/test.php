<?php

/**
 * This script tests inconsistent behavior of counter operations across PHP SDK v3 and v4.
 *
 * Usage:
 *     docker compose exec -ti client-v3 php ./test.php # for PHP SDK v3
 *     docker compose exec -ti client-v4 php ./test.php # for PHP SDK v4
 */

declare(strict_types=1);

if (is_readable($_SERVER['HOME'] . '/.composer/vendor/autoload.php')) {
    // Load PHP SDK of Couchbase v4 if available.
    require_once $_SERVER['HOME'] . '/.composer/vendor/autoload.php';
}

use Couchbase\Cluster;
use Couchbase\ClusterOptions;
use Couchbase\IncrementOptions;

$options = new ClusterOptions();
$options->credentials('username', 'password');
$cluster    = new Cluster('couchbase://server', $options);
$collection = $cluster->bucket('test')->defaultCollection();
$key        = 'counter';

// First, try to remove the counter if exists.
$collection->removeMulti([$key]);

// Second, insert the counter with a STRING value but not an INTEGER value.
$collection->insert($key, '3');
var_dump($collection->get($key)->content());

// Now, try to increment the counter.
//
// It works fine in PHP SDK v3, but fails in PHP SDK v4 with the following exception thrown out:
//   Couchbase\Exception\DeltaInvalidException: delta_invalid (122): "unable to execute increment"
$collection->binary()->increment($key, new IncrementOptions());
var_dump($collection->get($key)->content());
