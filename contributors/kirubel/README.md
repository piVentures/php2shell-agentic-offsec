# Kirubel — Task 03 Contribution

**Researcher:** Kirubel
**Agent:** PentAGI (Task 02 framework)
**CVEs:** CVE-2026-109619 (UAF), CVE-2026-109618 (OOM corruption)

---

## 1. Executive Summary

Both PHP2Shell CVEs were reproduced in an isolated `mod_php` lab environment and achieved **Remote Code Execution (RCE) as `uid=33(www-data)`**. 

The same payloads were then tested against a patched PHP 8.3.36 container. The patch successfully mitigated both vulnerabilities—no session file was written, and no code execution occurred. 

This is the primary evidence for Deliverables 2 and 3 of Task 03, demonstrating both the exploitability of the vulnerabilities and the autonomous capabilities of the PentAGI agent.

---

## 2. Lab Architecture

The lab consists of two Docker containers running side-by-side to allow direct comparison:
- **Vulnerable Target:** `php:8.3.35-apache` (Port 8080)
- **Patched Control:** `php:8.3.36-apache` (Port 8081)

**SAPI:** Apache 2.0 Handler (`mod_php`, prefork MPM) — required for the UAF to persist across requests.
**Application:** A custom `index.php` with a multipart upload form and an LFI sink (`include($_GET['page'])`).
**PHP Configuration:** `memory_limit = 8M`, `post_max_size = 64M`, `session.upload_progress.enabled = On`. 

![docker compose ps](screenshots/s02-lab-setup.png)
*Evidence: Both the vulnerable and patched containers are running successfully.*

---

## 3. CVE-2026-109619 — Stale Global State (UAF)

**Mechanism:** The `session.upload_progress` handler frees memory at the end of a request but fails to null the pointer. A subsequent request handled by the same worker follows the dangling pointer, allowing an attacker to poison the session file. When the application includes that file via LFI, the payload executes.

**Attack Sequence:**
1. The agent sends a multipart POST with `PHP_SESSION_UPLOAD_PROGRESS=<?php system('id'); ?>` and a file upload.
2. The agent immediately triggers the LFI via `GET /index.php?page=/tmp/sess_pentagi123`.

**Result:**
- **HTTP Response:** `200 OK` on both the POST and the LFI GET.
- **Impact:** `uid=33(www-data) gid=33(www-data) groups=33(www-data)` was returned in the LFI response body.

![Agent CVE-619 RCE](screenshots/s03-agent-cve619-rce.png)
*Evidence: The PentAGI agent executes the exploit and confirms the successful RCE via the right-hand UI panel.*

---

## 4. CVE-2026-109618 — OOM Corruption

**Mechanism:** The agent sends a payload large enough to exhaust the `memory_limit` during parsing. PHP performs a `longjmp()` unwind, leaving a half-initialized hash table. The cleanup routine then processes this corrupted state, serializing the attacker's payload into the session file.

**Attack Sequence:**
1. The agent generates an ~8.25 MB multipart body.
2. The agent sends the POST with `PHP_SESSION_UPLOAD_PROGRESS=<?php system('id'); ?>`.
3. The server OOMs and corrupts the session state.
4. The agent triggers the LFI via `GET /index.php?page=/tmp/sess_pentagi618`.

**Result:**
- **POST Response:** `500 Internal Server Error` (`Allowed memory size of 8388608 bytes exhausted`). *This 500 is the expected signature of the OOM firing.*
- **LFI Response:** `200 OK`.
- **Impact:** `uid=33(www-data)` returned in the LFI response body.

![Agent CVE-618 RCE](screenshots/s04-agent-cve618-rce.png)
*Evidence: The PentAGI agent triggers the OOM fatal error and successfully executes the resulting LFI payload.*

---

## 5. Patched Negative Control (PHP 8.3.36)

To prove that the lab results were genuine and attributable to the PHP version, the agent ran the exact same payloads against the patched container.

**Result:**
- **HTTP Responses:** `200 OK` on both POST and LFI GET.
- **LFI Body:** `<h2>Viewing Page: /tmp/sess_pentagi_patched</h2><p>Page not found.</p>`
- **Impact:** No `uid=` output, meaning the session file was never created. The patched binary correctly cleans up the memory state.

![Agent patched control](screenshots/s05-agent-patched-control.png)
*Evidence: The PentAGI UI shows that both Test 1 and Test 2 were verified as "MITIGATED" with `uid=33(www-data) absent`.*

---

## 6. Agent Integration & Observations

The Task 02 agent (PentAGI) demonstrated significant autonomous capabilities, as well as some limitations that required human oversight.

### Successes
- **Environment Adaptation:** The sandbox lacked `curl` and `python3`. The agent detected this and autonomously wrote a raw-socket HTTP client in Perl (`IO::Socket::INET`).
- **Transport Adaptation:** When `curl -F` failed with exit code 26 (due to the `<` in the payload), the agent diagnosed the error and successfully pivoted.
- **Network Pivoting:** In the patched control run, when the Docker network was unreachable, the agent discovered the host-gateway (`172.17.0.1:8081`) and re-targeted.
- **Correct Reasoning:** It did not hallucinate success on `405`/`403` HTTP errors, correctly distinguishing application-layer rejections from engine-level crashes.

### Failures & Interventions
- **Session ID Validation:** The agent initially used an underscore (`pentagi_eict`) which PHP rejects. It required a wasted round-trip to self-correct to an alphanumeric ID.
- **Provider Reliability:** Multiple flows terminated on LLM provider `503` errors. In one instance, context loss caused the agent to begin scanning its own Docker bridge network—a governance finding that highlights the need for strict network egress controls.

---

## 7. Achievements & Takeaways

**What was achieved:**
1. Confirmed Remote Code Execution on CVE-2026-109619 (`mod_php` UAF).
2. Confirmed Remote Code Execution on CVE-2026-109618 (`mod_php` OOM).
3. Confirmed the patch (PHP 8.3.36) mitigates both paths.
4. Documented the agent's autonomous execution and raw HTTP evidence, distinguishing it from false-positive summaries.

**Key Operational Takeaway:**
The SAPI is the gatekeeper. Both CVEs require `mod_php` with persistent workers. Any deployment using FastCGI, PHP-FPM, or LiteSpeed recycles workers per request, completely neutralizing the UAF window. Furthermore, the OOM variant requires `post_max_size > memory_limit` to be reachable. 

**Remediation Recommendation:** 
Organizations should patch to the fixed versions (8.2.35, 8.3.36, 8.4.27, 8.5.12), explicitly disable `session.upload_progress` if not in use, and ensure web servers enforce strict `client_max_body_size` limits.

---

## 8. Individual Contribution (Kirubel)

- Lab design and build: `docker-compose.yml`, `index.php`, `php.ini`, patched pairing.
- PoC authoring and execution: CVE-619 and CVE-618 against the vulnerable container, both achieving RCE.
- Patched negative control: Executed both payloads against `php:8.3.36-apache` to confirm mitigation.
- Agent prompt engineering and supervision: Designed the lab prompts, verified raw HTTP output against agent summaries, and documented the governance findings.
- Cross-review of the shared CVE analysis in `../research/cve-analysis.md`.
