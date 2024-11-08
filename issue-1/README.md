## Issue #1 (Addressed): Method GetAndLock() Doesn't Work As Expected

Code to reproduce the issue can be found in file _./issue-1.php_. To reproduce it, please run the following command:

```bash
# Start a Couchbase container.
docker run --rm -d --name couchbase -e CB_ADMIN=username -e CB_ADMIN_PASSWORD=password -e CB_BUCKET=test -t deminy/couchbase:7.6.3

# Change working directory to the issue-1 folder.
cd ./issue-1

# Run the test script to reproduce the issue.
docker run --rm --platform=linux/amd64 \
    -v ".:/var/www" \
    -e COUCHBASE_HOST=$(docker inspect -f '{{range.NetworkSettings.Networks}}{{.IPAddress}}{{end}}' couchbase) \
    -ti deminy/php-couchbase:3.2.2-php8.1 \
    php ./issue-1.php

# Stop the Couchbase container.
docker stop couchbase
```

The Couchbase team is aware of this. They have an issue ticket [PCBC-840](https://issues.couchbase.com/browse/PCBC-840) created and will update the documentation accordingly.
