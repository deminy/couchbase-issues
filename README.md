This repository is to report/reproduce Couchbase issues in PHP.

# Issues

## Issue #1 (Addressed): Method GetAndLock() Doesn't Work As Expected

Check [README.md](./issue-1/README.md) for more details.

The Couchbase team is aware of this. They have an issue ticket [PCBC-840](https://issues.couchbase.com/browse/PCBC-840) created and will update the documentation accordingly.

## Issue #2: Method GetAndLock() Doesn't Fail As Expected

Check [README.md](./issue-2/README.md) for more details.

The issue has been reported to Couchbase (issue [PCBC-841](https://issues.couchbase.com/browse/PCBC-841)).

## Issue #3: Broken Operations After Connecting to Couchbase Capella via CNAME + AWS PrivateLink

This can be fixed by setting network to `external` when making Couchbase connections. Check [README.md](./issue-3/README.md) for more details.

## Issue #4: Inconsistent Behavior of Unlocking Items

Check [README.md](./issue-4/README.md) for more details.

## Issue #5: Inconsistent Behavior of Couchbase Counters Across PHP SDK Versions

Check [README.md](./issue-5/README.md) for more details.

The issue has been reported to Couchbase (issue [couchbase/couchbase-php-client#212](https://github.com/couchbase/couchbase-php-client/issues/212)).

## Issue #6: Inconsistent Behavior of Default JSON Transcoders Across PHP SDK Versions

Check [README.md](./issue-6/README.md) for more details.

The issue has been reported to Couchbase (issue [couchbase/couchbase-php-client#218](https://github.com/couchbase/couchbase-php-client/issues/218)).

## Issue #7: Unexpected Warning Messages When Using PHP SDK v4

Check [README.md](./issue-7/README.md) for more details.

The issue has been reported to Couchbase (issue [couchbase/couchbase-php-client#220](https://github.com/couchbase/couchbase-php-client/issues/220)).

## Issue #8: Forked Process Hanging Forever When Logging is Enabled

Check [README.md](./issue-8/README.md) for more details.

The issue has been reported to Couchbase (issue [couchbase/couchbase-php-client#221](https://github.com/couchbase/couchbase-php-client/issues/221)).
