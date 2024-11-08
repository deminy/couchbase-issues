## Issue #3: Broken Operations After Connecting to Couchbase Capella via CNAME + AWS PrivateLink

When connecting to a Couchbase Capella via CNAME + AWS PrivateLink, the PHP Couchbase SDK can't perform any operations
after successfully connected to the server.

The issue has been reported to Couchbase (Couchbase Support ticket #65012).

The issue is reproducible with [the Couchbase extension v3.2.2] (v3) and [the Couchbase extension v4.2.4] (v4).

## Reproduce the Issue

Please run the following Docker commands in your VPC to reproduce the issue. Note that before running the
following commands, you need to

1. manually update the environment variables _COUCHBASE_HOST_, _COUCHBASE_USER_, _COUCHBASE_PASS_, and _COUCHBASE_BUCKET_.
2. put the Couchbase certificate file _couchbase.pem_ in the same folder as the test script _couchbase3.php_. If you put the
   certificate file differently, you need to update the Docker environment variable _COUCHBASE_CERTIFICATE_.

### Reproduce the Issue With Couchbase 3

The issue is reproducible with [the Couchbase extension v3.2.2] (v3).

```bash
# Change working directory to the issue-3 folder.
cd ./issue-3

# The following command will run the test script to connect to a Couchbase server, without
# performing any get operations. It always succeeds.
docker run --rm --platform=linux/amd64 \
    -e COUCHBASE_GET=0 \
    -e COUCHBASE_CERTIFICATE=/var/www/couchbase.pem \
    -e COUCHBASE_HOST= \
    -e COUCHBASE_USER= \
    -e COUCHBASE_PASS= \
    -e COUCHBASE_BUCKET= \
    -v ".:/var/www" \
    -ti deminy/php-couchbase:3.2.2-php8.1 \
    php ./couchbase3.php

# The following command will run the test script to connect to a Couchbase server and perform
# a get operation. It runs forever and never succeeds.
docker run --rm --platform=linux/amd64 \
    -e COUCHBASE_GET=1 \
    -e COUCHBASE_CERTIFICATE=/var/www/couchbase.pem \
    -e COUCHBASE_HOST= \
    -e COUCHBASE_USER= \
    -e COUCHBASE_PASS= \
    -e COUCHBASE_BUCKET= \
    -v ".:/var/www" \
    -ti deminy/php-couchbase:3.2.2-php8.1 \
    php ./couchbase3.php
```

### Reproduce the Issue With Couchbase 4

The issue is reproducible with [the Couchbase extension v4.2.4] (v4).

```bash
# Change working directory to the issue-3 folder.
cd ./issue-3

# Start the Docker container with PHP Couchbase v4.2.4 installed.
docker run --rm --platform=linux/amd64 \
    -e COUCHBASE_CERTIFICATE=/var/www/couchbase.pem \
    -e COUCHBASE_HOST= \
    -e COUCHBASE_USER= \
    -e COUCHBASE_PASS= \
    -e COUCHBASE_BUCKET= \
    -v ".:/var/www" \
    -ti deminy/php-couchbase:4.2.4-php8.1 \
    bash

   # NOTE: run the following commands inside the Docker container:
   composer global require --no-progress --prefer-dist couchbase/couchbase:~4.2.4 # To install the Couchbase library v4.2.4.
   COUCHBASE_GET=0 php -d couchbase.log_path=/var/www/couchbase.log -d couchbase.log_level=trace ./couchbase4.php # It always succeeds.
   COUCHBASE_GET=1 php -d couchbase.log_path=/var/www/couchbase.log -d couchbase.log_level=trace ./couchbase4.php # It runs forever and never succeeds.
```

[the Couchbase extension v3.2.2]: https://github.com/couchbase/php-couchbase/releases/tag/v3.2.2
[the Couchbase extension v4.2.4]: https://github.com/couchbase/couchbase-php-client/releases/tag/4.2.4
