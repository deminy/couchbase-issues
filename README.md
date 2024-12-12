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
