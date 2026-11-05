# 06 — Vulnerable vs Patched

## Result matrix

| Environment | Container | PHP | CVE-619 | CVE-618 |
|---|---|---|---|---|
| Vulnerable | `php2shell-target` (`:8080`) | **8.3.35** | **RCE** | **RCE** |
| Patched | `php2shell-patched` (`:8081`) | **8.3.36** | Mitigated | Mitigated |

## What this proves

- Both CVEs are real and exploitable in a correctly configured `mod_php` lab.
- Both CVEs are closed by the upstream patch (8.3.36).
- The lab result is a valid PoC — not a false positive.

## Evidence

- Vulnerable target evidence: [03](03-cve-619-results.md), [04](04-cve-618-results.md)
- Patched target evidence: [05](05-patched-control.md)
