# 01 — Scope and Methodology

**Researcher:** Kirubel
**Agent:** PentAGI (Task 02 framework)
**CVEs:** CVE-2026-109619 (stale global state / UAF), CVE-2026-109618 (OOM corruption)

## What this report covers

- **Vulnerability mechanics** for both CVEs — see the shared analysis at
  [`../../../research/cve-analysis.md`](../../../research/cve-analysis.md).
- **Lab PoC** — a deliberately vulnerable PHP application reproduces both
  CVEs; see [03](03-cve-619-results.md) and [04](04-cve-618-results.md).
- **Patched negative control** — the fixed release eliminates both; see
  [05](05-patched-control.md).
- **Agent integration** — how PentAGI executed the lab work; see
  [07](07-agent-observations.md).
- **Final overview** — what was done and achieved; see
  [08](08-achievements.md).

## Methodology

1. Build the lab first, confirm exploitability.
2. Test the patched control with identical payloads.
3. Record every result as a raw HTTP status code plus response body snippet.
4. Where the agent's summary disagrees with the raw output, the raw output
   is the evidence (see [07](07-agent-observations.md) §Failures).

## Scope statement

All testing in this report was performed in an isolated Docker lab on the
researcher's own host. No live third-party system was tested, and no
live-target data is present anywhere in this repository.
