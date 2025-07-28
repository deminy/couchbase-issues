<?php

/**
 * This script generates unexpected warning messages when Couchbase logging level is set to "warning".
 *
 * After connecting to Couchbase server using PHP SDK v4, unexpected/confusing warning messages are generated when
 * performing an operation.
 *
 * Usage:
 *     docker compose exec -ti client php -d couchbase.log_level=warning ./test.php
 */

declare(strict_types=1);

require_once $_SERVER['HOME'] . '/.composer/vendor/autoload.php';

use Couchbase\Cluster;
use Couchbase\ClusterOptions;

$options = new ClusterOptions();
$options->credentials('username', 'password');
$cluster = new Cluster('couchbase://server?network=default', $options);

$cluster->bucket('test')->defaultCollection()->removeMulti(['foo']);
echo 'Done.', PHP_EOL;
