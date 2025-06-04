## Issue #5: Inconsistent Behavior of Couchbase Counters Across PHP SDK Versions

In legacy PHP SDKs (v2 and v3) for Couchbase, counters can be set as string values, which contrasts with
the behavior in PHP SDK v4 where counters must be strictly integers. This discrepancy can cause unexpected
exceptions, such as `DeltaInvalidException`, during migration from older SDK versions to v4.

The issue has been reported to Couchbase (issue [couchbase/couchbase-php-client#212](https://github.com/couchbase/couchbase-php-client/issues/212)).

## Steps to Reproduce

### 1. Start the Couchbase Containers

```bash
# Change working directory to the "issue-5" folder.
cd ./issue-5

# Use Docker Compose to start the Couchbase containers.
docker compose up -d
```

### 2. Run Test Script with PHP SDK v3

Execute the script using PHP SDK v3. This should work without issues:

```bash
docker compose exec -ti client-v3 php --ri couchbase
docker compose exec -ti client-v3 php ./test.php
```

### 3. Run Test Script with PHP SDK v4

Execute the script using PHP SDK v4. This will reproduce the issue, resulting in a `DeltaInvalidException` exception:

```bash
docker compose exec -ti client-v4 php --ri couchbase
docker compose exec -ti client-v4 php ./test.php
```

### 4. Clean Up

Stop the Docker containers to clean up:

```bash
docker compose down
```
