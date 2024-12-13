## Issue #4: Inconsistent Behavior of Unlocking Items

When unlocking an item from different versions of Couchbase servers, the same PHP SDK throws different exceptions.

## Steps to Reproduce

First, let's start the Couchbase containers and install Composer packages:

```bash
# Change working directory to the issue-4 folder.
cd ./issue-4

# Start the Couchbase containers.
docker compose up -d

# Install Composer packages.
docker compose exec -ti client-v4 composer global require --no-progress --prefer-dist couchbase/couchbase:4.2.5
```

Secondly, let's run the test scripts to reproduce the issue with the PHP SDK v3:

```bash
# The following Docker command throws out an error when unlocking an item:
#   Fatal error: Uncaught Couchbase\TempFailException: LCB_ERR_TEMPORARY_FAILURE (207)
docker compose exec -e COUCHBASE_HOST=server-7.2 -ti client-v3 php ./test.php

# The following Docker command throws out a different error when unlocking an item:
#   Fatal error: Uncaught Couchbase\BaseException: LCB_ERR_DOCUMENT_NOT_LOCKED (330)
docker compose exec -e COUCHBASE_HOST=server-7.6 -ti client-v3 php ./test.php
```

Thirdly, let's run the test scripts to reproduce the issue with the PHP SDK v4:

```bash
# The following Docker command throws out an error when unlocking an item:
#   Fatal error: Uncaught Couchbase\Exception\AmbiguousTimeoutException: ambiguous_timeout (13): "unable to execute KV operation "document_unlock""
docker compose exec -e COUCHBASE_HOST=server-7.2 -ti client-v4 php ./test.php

# The following Docker command throws out a different error when unlocking an item:
#   Fatal error: Uncaught Couchbase\Exception\DocumentNotLockedException: document_not_locked (131): "unable to execute KV operation "document_unlock""
docker compose exec -e COUCHBASE_HOST=server-7.6 -ti client-v4 php ./test.php
```

Finally, let's stop the Couchbase containers:

```bash
# Shutdown the Couchbase containers.
docker compose down
```
