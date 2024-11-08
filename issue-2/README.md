## Issue #2: Method GetAndLock() Doesn't Fail As Expected

A locked item can't be locked again when the lock is not released nor expired. Test script _./issue-2-a.php_ works as
expected, however, test script _./issue-2-b.php_ doesn't throw out an exception when locking a locked item.

```bash
# Start a Couchbase container.
docker run --rm -d --name couchbase -e CB_ADMIN=username -e CB_ADMIN_PASSWORD=password -e CB_BUCKET=test -t deminy/couchbase:7.6.3

# Change working directory to the issue-2 folder.
cd ./issue-2

# Run the test scripts to reproduce the issue.
docker run --rm --platform=linux/amd64 \
    -v ".:/var/www" \
    -e COUCHBASE_HOST=$(docker inspect -f '{{range.NetworkSettings.Networks}}{{.IPAddress}}{{end}}' couchbase) \
    -ti deminy/php-couchbase:3.2.2-php8.1 \
    sh -c 'php ./issue-2-a.php ; echo $?' # exit code is 255. Expected.
docker run --rm --platform=linux/amd64 \
    -v ".:/var/www" \
    -e COUCHBASE_HOST=$(docker inspect -f '{{range.NetworkSettings.Networks}}{{.IPAddress}}{{end}}' couchbase) \
    -ti deminy/php-couchbase:3.2.2-php8.1 \
    sh -c 'php ./issue-2-b.php ; echo $?' # exit code is 0. Unexpected.

# Stop the Couchbase container.
docker stop couchbase
```

The issue has been reported to Couchbase (issue [PCBC-841](https://issues.couchbase.com/browse/PCBC-841)).
