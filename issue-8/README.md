## Issue #8: Forked Process Hanging Forever When Logging is Enabled

When logging is enabled in the Couchbase PHP SDK v4, a forked process hangs indefinitely. However, when logging is disabled, the process runs successfully and exits as expected.

## Steps to Reproduce

### 1. Start the Couchbase Containers

```bash
# Change working directory to the "issue-8" folder.
cd ./issue-8

# Use Docker Compose to start the Couchbase containers.
docker compose up -d
```

### 2. Run the Test Script

The test script creates a child process that waits for 5 seconds and then exits.

When logging is disabled, the script runs successfully:

```bash
docker compose exec -ti app php -d couchbase.log_level= ./test.php
```

When logging is enabled, the script hangs indefinitely:

```bash
docker compose exec -ti app php -d couchbase.log_level=warning ./test.php
```

### 3. Clean Up

Stop the Docker containers to clean up:

```bash
docker compose down
```
