## Issue #3: Broken Operations After Connecting to Couchbase Capella via CNAME + AWS PrivateLink

When connecting to a Couchbase Capella via CNAME + AWS PrivateLink, the PHP Couchbase SDK can't perform any operations
after successfully connected to the server. The issue is reproducible with [the Couchbase extension v3.2.2].

Please run the following Docker commands in your VPC to reproduce the issue. Note that before running the
following commands, you need to

1. manually update the environment variables _COUCHBASE_HOST_, _COUCHBASE_USER_, _COUCHBASE_PASS_, and _COUCHBASE_BUCKET_.
2. put the Couchbase certificate file _couchbase.pem_ in the same folder as the test script _couchbase3.php_. If you put the
   certificate file differently, you need to update the Docker environment variable _COUCHBASE_CERTIFICATE_.

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

The issue has been reported to Couchbase (Couchbase Support ticket #65012).

[the Couchbase extension v3.2.2]: https://github.com/couchbase/php-couchbase/releases/tag/v3.2.2
