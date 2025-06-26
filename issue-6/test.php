<?php

/**
 * This script is to either get or set data in Couchbase using the PHP SDK v3 or v4.
 *
 * When a first argument is provided, it will attempt to get the value for that key. Otherwise, it will set two keys
 * with small and large objects.
 *
 * Usage:
 *     docker compose exec -ti client-v3 php ./test.php      # Set two keys with small and large objects using PHP SDK v3.
 *     docker compose exec -ti client-v3 php ./test.php key1 # Get the value for key1 using PHP SDK v3.
 *     docker compose exec -ti client-v3 php ./test.php key2 # Get the value for key2 using PHP SDK v3.
 *
 *     docker compose exec -ti client-v4 php ./test.php      # Set two keys with small and large objects using PHP SDK v4.
 *     docker compose exec -ti client-v4 php ./test.php key1 # Get the value for key1 using PHP SDK v4.
 *     docker compose exec -ti client-v4 php ./test.php key2 # Get the value for key2 using PHP SDK v4.
 */

declare(strict_types=1);

if (is_readable($_SERVER['HOME'] . '/.composer/vendor/autoload.php')) {
    // Load PHP SDK of Couchbase v4 if available.
    require_once $_SERVER['HOME'] . '/.composer/vendor/autoload.php';
}

use Couchbase\Cluster;
use Couchbase\ClusterOptions;

$options = new ClusterOptions();
$options->credentials('username', 'password');
$cluster    = new Cluster('couchbase://server', $options);
$collection = $cluster->bucket('test')->defaultCollection();

// Check if first argument is provided; if so, use it as the key to get the value.
if (isset($argv[1])) {
    var_dump($collection->get($argv[1])->content());
    exit(0);
}

$key1 = 'key1'; // A key for a small object.
$key2 = 'key2'; // A key for a large object.
$collection->removeMulti([$key1, $key2]); // Remove the items if they exist.
$collection->insert($key1, (object) ['foo' => 'bar']); // A small object with a string 'bar'.
$collection->insert($key2, (object) ['foo' => str_repeat('T', 1_000_000)]); // A large object with a string of 1 million 'T's.
