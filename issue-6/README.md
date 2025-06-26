## Issue #6: Inconsistent Behavior of Default JSON Transcoders Across PHP SDK Versions

In legacy PHP SDKs (v2 and v3) of Couchbase, there is a configuration option `couchbase.encoder.compression` that allows
compression of data using a specified algorithm. This option is not forward-compatible with the new PHP SDK v4. When
data is inserted using PHP SDK v3 with compression enabled, it cannot be retrieved using PHP SDK v4.

The issue has been reported to Couchbase (issue [couchbase/couchbase-php-client#218](https://github.com/couchbase/couchbase-php-client/issues/218)).

## Steps to Reproduce

### 1. Start the Couchbase Containers

```bash
# Change working directory to the "issue-6" folder.
cd ./issue-6

# Use Docker Compose to start the Couchbase containers.
docker compose up -d
```

**Note:** The configuration option `couchbase.encoder.compression` is set to `zlib` in the container running PHP SDK v3.

### 2. Run Test Script by Inserting Data with PHP SDK v3

Data inserted with PHP SDK v3 can be retrieved using PHP SDK v3, but not with PHP SDK v4 if compression is enabled and
the data is large enough.

```bash
docker compose exec -ti client-v3 php --ri couchbase

# Insert a small object and a large object using PHP SDK v3.
docker compose exec -ti client-v3 php ./test.php

# Small objects can be retrieved using PHP SDK v3 or v4, without any issues.
docker compose exec -ti client-v3 php ./test.php key1 # Retrieve the small object using PHP SDK v3.
docker compose exec -ti client-v4 php ./test.php key1 # Retrieve the small object using PHP SDK v4.

# Large objects can be retrieved using PHP SDK v3 only.
docker compose exec -ti client-v3 php ./test.php key2 # Retrieve the large object using PHP SDK v3.

# Retrieving large objects will throw exceptions.
docker compose exec -ti client-v4 php ./test.php key2 # Retrieve the large object using PHP SDK v4.
```

### 2. Run Test Script by Inserting Data with PHP SDK v4

Data inserted using PHP SDK v4 can be retrieved without issues, regardless of SDK version or data size.

```bash
docker compose exec -ti client-v4 php --ri couchbase

# Insert a small object and a large object using PHP SDK v4.
docker compose exec -ti client-v4 php ./test.php

docker compose exec -ti client-v4 php ./test.php key1 # Retrieve the small object using PHP SDK v4.
docker compose exec -ti client-v4 php ./test.php key2 # Retrieve the large object using PHP SDK v4.

docker compose exec -ti client-v3 php ./test.php key1 # Retrieve the small object using PHP SDK v3.
docker compose exec -ti client-v3 php ./test.php key2 # Retrieve the large object using PHP SDK v3.
```

### 4. Clean Up

Stop the Docker containers to clean up:

```bash
docker compose down
```
