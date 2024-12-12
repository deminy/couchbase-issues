## Issue #4: Inconsistent Behavior of Unlocking Items

When unlocking an item from different versions of Couchbase servers, the same PHP SDK throws different exceptions.

```bash

# Change working directory to the issue-4 folder.
cd ./issue-4

# Start the Couchbase containers.
docker compose up -d
# Install Composer packages.
docker compose exec -ti app composer global require --no-progress --prefer-dist couchbase/couchbase:4.2.5

# The following Docker command throws out an error when unlocking an item:
#   Fatal error: Uncaught Couchbase\Exception\AmbiguousTimeoutException: ambiguous_timeout (13): "unable to execute KV operation "document_unlock""
docker compose exec -e COUCHBASE_HOST=couchbase-7.2 -ti app php ./test.php

# The following Docker command throws out a different error when unlocking an item:
#   Fatal error: Uncaught Couchbase\Exception\DocumentNotLockedException: document_not_locked (131): "unable to execute KV operation "document_unlock""
docker compose exec -e COUCHBASE_HOST=couchbase-7.6 -ti app php ./test.php

# Shutdown the Couchbase containers.
docker compose down
```
