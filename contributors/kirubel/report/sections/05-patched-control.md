# 05 — Patched Negative Control (PHP 8.3.36)

The patched container runs the **identical** `index.php` and `php.ini` as the
vulnerable container. The only difference is the PHP patch level (8.3.36 vs
8.3.35). Any difference in exploit behaviour is attributable to the patch.

## Result

| CVE | POST status | LFI status | LFI body | Verdict |
|---|---|---|---|---|
| 619 | `200 OK` | `200 OK` | `<h2>Viewing Page: /tmp/sess_pentagi_patched</h2><p>Page not found.</p>` | **Mitigated** |
| 618 | `200 OK` | `200 OK` | `<h2>Viewing Page: /tmp/sess_pentagi_patched</h2><p>Page not found.</p>` | **Mitigated** |

## Interpretation

Both LFI responses return the `Page not found` branch of `index.php`, which
means **the session file was never created**. The patched binary:

- Nulls the freed pointer on request cleanup → closes CVE-619
- Does not leave a half-initialized hash table after `longjmp()` → closes CVE-618

No file to include, no execution, no RCE.

## Evidence — Agent Execution

The agent was directed to test the same payloads against the patched PHP 8.3.36 container to confirm the mitigation.

![Agent patched control](../screenshots/s05-agent-patched-control.png)

*The screenshot shows the PentAGI UI for the "Verify CVE Patching" flow. The right panel displays the test results for both CVEs. For both Test 1 (CVE-619) and Test 2 (CVE-618), the `RCE Check` explicitly states `uid=33(www-data) was absent`, and the final `Status` is `MITIGATED`.*

Raw log: [`../../logs/lab-patched-control.log`](../../logs/lab-patched-control.log)
