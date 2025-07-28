## Issue #7: Unexpected Warning Messages When Using PHP SDK v4

After connecting to Couchbase server using PHP SDK v4, unexpected warning messages are generated when performing an operation.

## Steps to Reproduce

### 1. Start the Docker Containers

```bash
# Change working directory to the "issue-7" folder.
cd ./issue-7

# Use Docker Compose to start the Couchbase containers.
docker compose up -d

# Check Couchbase extension information.
docker compose exec -ti client php --ri couchbase # PHP SDK v4.3.0
```

### 2. Run Test Script with PHP SDK v4

Execute the test script with the logging level set to "warning":

```bash
# Run the test script with logging level set to "warning".
docker compose exec -ti client php -d couchbase.log_level=warning ./test.php
```

This command produces the following two warning messages:

```json
{
  "level": "warning",
  "message": "DNS SRV query returned 0 records for \"server\", assuming that cluster is listening this address",
  "thread_id": 154,
  "time": "2025-07-28 21:18:16.771942837.942837"
}
```

```json
{
  "level": "warning",
  "message": "[4a271e-43b0-ef42-b898-15eb592343bf50/test] unable to find connected session with GCCCP support, retry in 2500ms",
  "thread_id": 154,
  "time": "2025-07-28 21:18:16.783836753.836753"
}
```

### 3. Clean Up

Stop the Docker containers to clean up:

```bash
docker compose down
```
