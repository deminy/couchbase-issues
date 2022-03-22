This repository is to report/reproduce Couchbase 3 issues in PHP.

# Setup The Test Environment

Run command `docker-compose up -d` to start the Docker containers. There are two containers included:

1. An `app` container that has PHP 8 installed, with Couchbase 3.2.2 enabled.
2. A `couchbase` container that has Couchbase server 6.6.0 running in it.

# Issues

## Issue #1: Method Getandlock() Doesn't Work As Expected

Code to reproduce the issue can be found in file _./issue-1.php_. To reproduce it, please run the following command:

```bash
docker-compose exec -T app php ./issue-1.php
 ```
