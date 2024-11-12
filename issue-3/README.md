## Issue #3: Broken Operations After Connecting to Couchbase Capella via CNAME + AWS PrivateLink

PHP Couchbase SDKs don't work directly when connecting to Couchbase Capella via CNAME + AWS PrivateLink.

* In PHP SDK v3, it can't perform any operations after successfully connected to the server.
* In PHP SDK v4, it can't even connect to the server.

**This can be fixed by setting network to `external` when making Couchbase connections.**
