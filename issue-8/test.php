<?php

/**
 * The test script creates a child process that waits for 5 seconds and then exits.
 *
 * Usage:
 *     # When logging is disabled, the script runs successfully:
 *     docker compose exec -ti app php -d couchbase.log_level= ./test.php
 *
 *     # When logging is enabled, the script hangs indefinitely:
 *     docker compose exec -ti app php -d couchbase.log_level=warning ./test.php
 */

declare(strict_types=1);

require_once $_SERVER['HOME'] . '/.composer/vendor/autoload.php';

$pid = pcntl_fork();
if ($pid === -1) {
    echo 'Could not fork.', PHP_EOL;
    exit(1);
}
if ($pid === 0) {
    echo 'I am the child (pid: ' . posix_getpid() . ').', PHP_EOL;
    sleep(5);
    exit(0);
}

echo "I'm the parent.", PHP_EOL;
while (pcntl_wait($status, WNOHANG) === 0) {
    sleep(1);
}
echo "Child process #{$pid} has finished execution.", PHP_EOL;
