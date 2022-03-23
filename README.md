This repository is to report/reproduce Couchbase 3 issues in PHP.

# Setup The Test Environment

Run command `docker-compose up -d` to start the Docker containers. There are three containers included:

1. A `php7` container that has PHP 7.4 installed, with Couchbase 3.2.2 enabled.
2. A `php8` container that has PHP 8.0 installed, with Couchbase 3.2.2 enabled.
3. A `couchbase` container that has Couchbase server 6.6.0 running in it.

# Issues

## Issue #1 (Addressed): Method Getandlock() Doesn't Work As Expected

Code to reproduce the issue can be found in file _./issue-1.php_. To reproduce it, please run the following command:

```bash
docker-compose exec -T php8 php ./issue-1.php
 ```

The Couchbase team is aware of this. They have an issue ticket [PCBC-840](https://issues.couchbase.com/browse/PCBC-840) created and will update the documentation accordingly.
