This repository is to report/reproduce Couchbase 3 issues in PHP.

# Setup The Test Environment

Run command `docker-compose up -d` to start the Docker containers. There are three containers included:

1. A `php7` container that has PHP 7.4 installed, with Couchbase 3.2.2 enabled.
2. A `php8` container that has PHP 8.0 installed, with Couchbase 3.2.2 enabled.
3. A `couchbase` container that has Couchbase server 6.6.0 running in it.

# Issues

## Issue #1 (Addressed): Method GetAndLock() Doesn't Work As Expected

Code to reproduce the issue can be found in file _./issue-1.php_. To reproduce it, please run the following command:

```bash
docker-compose exec -T php8 php ./issue-1.php
```

The Couchbase team is aware of this. They have an issue ticket [PCBC-840](https://issues.couchbase.com/browse/PCBC-840) created and will update the documentation accordingly.

## Issue #2: Method GetAndLock() Doesn't Fail As Expected

A locked item can't be locked again when the lock is not released nor expired. Test script _./issue-2-a.php_ works as
expected, however, test script _./issue-2-b.php_ doesn't throw out an exception when locking a locked item.

```bash
docker-compose exec -T php7 sh -c 'php ./issue-2-a.php ; echo $?' # exit code is 255. Expected.
docker-compose exec -T php7 sh -c 'php ./issue-2-b.php ; echo $?' # exit code is 0. Unexpected.
```

The issue has been reported to Couchbase (issue [PCBC-841](https://issues.couchbase.com/browse/PCBC-841)).
