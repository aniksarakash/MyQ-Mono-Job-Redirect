# Changelog

## 2.0 — server side design

The design that ships in this repository.

**Added**
- `secure_mono` landing queue pattern: clone the live queue, omit the colour device.
- `src/mono-redirect.php` with a five branch decision tree and an `$ENFORCE` test mode.
- Rights pre-check via `canPrintToQueue()` before any move.
- Parser safety branch, so a job with unreadable content is never moved on a guess.
- Optional email notification and job rename snippets.
- Runbook split into six phases, with rollback, limitations, troubleshooting and a references map.

**Changed**
- Jobs are moved rather than blocked or deleted. Users collect from any other printer.
- Rollback reduced to clearing one text field, with no service restart and no queued jobs lost.

**Why the change**
The earlier approach needed a separate mono queue that users printed to directly, which meant a driver and port change on every PC. The customer had too many users for that. Routing on the server side removed the client work entirely.

## 1.0 — client side design (superseded)

Separate mono queue with its own Windows share, pushed to PCs by GPO. Abandoned because the client side rollout was not viable at this site.
