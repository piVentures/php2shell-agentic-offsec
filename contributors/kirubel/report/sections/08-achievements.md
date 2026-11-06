# 08 — Final Overview: What Was Done and Achieved

## Summary

Over the research window, the Task 02 agent (PentAGI) was directed to
reproduce the PHP2Shell vulnerability family in an isolated lab environment,
verify the upstream patch, and document the agent's behaviour throughout.
Both CVEs were successfully exploited, and both were confirmed mitigated by
the patch.

## What was achieved

### 1. Confirmed remote code execution on CVE-2026-109619
- **Environment:** `php:8.3.35-apache` (`mod_php`, prefork MPM)
- **Attack:** Multipart POST with `PHP_SESSION_UPLOAD_PROGRESS` payload, followed by an LFI GET to include the poisoned session file.
- **Evidence:** `uid=33(www-data)` returned in the LFI response body.

### 2. Confirmed remote code execution on CVE-2026-109618
- **Environment:** Same as above, with `memory_limit=8M` and `post_max_size=64M`
- **Attack:** ~8.25 MB multipart body to exhaust `memory_limit`, followed by an LFI GET.
- **Evidence:** `500` on the POST with `Allowed memory size exhausted`, then `uid=33(www-data)` in the LFI response.

### 3. Confirmed the patch mitigates both CVEs
- **Environment:** `php:8.3.36-apache` with identical `index.php` and `php.ini`.
- **Same payloads sent:** both returned `200 OK` on the POST, and `Page not found` on the LFI.

### 4. Documented agent behaviour under constraint
- The sandbox was intentionally air-gapped and lacked `curl` and `python3`.
- The agent adapted by writing raw-socket Perl, and correctly distinguished between application-layer rejections and engine-level crashes.
- The agent's false starts are documented honestly per Task 03 §Rules and conditions.

## What was learned

### About PHP2Shell
1. **The SAPI is the gatekeeper.** Both CVEs are only reachable under `mod_php` with persistent prefork workers.
2. **The LFI sink is mandatory.** Without an application-level `include(user_input)`, the poisoned session file is inert.
3. **`post_max_size > memory_limit` is the OOM trigger.** Any configuration where `post_max_size < memory_limit` prevents the OOM path entirely.
4. **Disabling `session.upload_progress` removes the attack surface.** Setting `session.upload_progress.enabled=Off` closes CVE-619's confirmed path even on unpatched PHP.

### About agentic AI in security research
1. **Adaptation is real.** The agent's pivot to raw-socket Perl is a genuine capability.
2. **Verification is not optional.** The agent's summary of a run can disagree with the raw HTTP evidence. A researcher must read the raw output to trust the conclusion.
3. **Bounded execution is essential.** The agent escalated to concurrency levels that would constitute a DoS if directed at a live host. The brief's "bounded execution" rule is not ceremonial.
4. **Prompt-level constraints are insufficient.** The agent once accessed an external domain and once scanned its own Docker bridge, both against prompt instructions. These controls must be enforced at the network layer.

## Deliverables completed

| # | Deliverable | Status | Location |
|---|---|---|---|
| 1 | Technical research report | ✅ | [`../../research/cve-analysis.md`](../../research/cve-analysis.md) + sections 01–08 |
| 2 | PoC and controlled lab | ✅ | [02](02-lab-environment.md), [03](03-cve-619-results.md), [04](04-cve-618-results.md), [05](05-patched-control.md) |
| 3 | Agent-driven workflow | ✅ | [07](07-agent-observations.md) + [`../../logs/`](../../logs/) |
| 4 | Authorized-target assessment | ⏳ | Pending evaluator-designated target with written scope |
| 5 | Results and comparison | ✅ | [06](06-comparison.md) + [07](07-agent-observations.md) |
| 6 | Presentation and video | ⏳ | Separate artefact, produced before in-person evaluation |
| 7 | AI usage and individual work | ✅ | [07](07-agent-observations.md), Individual contribution below |

## Individual contribution
**Kirubel:**
- Lab design and build: `docker-compose.yml`, `index.php`, `php.ini`, patched pairing.
- PoC authoring and execution: CVE-619 and CVE-618 against the vulnerable container, both achieving RCE.
- Patched negative control: Executed both payloads against `php:8.3.36-apache`; confirmed both CVEs are mitigated.
- Agent prompt engineering, flow supervision, and raw-output verification against agent summaries.
- Report writing: sections 01–08 of this report.
- Cross-review of the shared CVE analysis in [`../../research/cve-analysis.md`](../../research/cve-analysis.md) with Abraham.

## Closing statement
The PHP2Shell vulnerability family is real, exploitable in a correctly configured `mod_php` environment, and cleanly mitigated by the upstream patch. The Task 02 agent demonstrated genuine adaptive capability during this research — including the ability to construct raw multipart HTTP requests from scratch when standard tooling was unavailable — while also exposing the limits of unmonitored autonomy.

The most useful operational takeaway from this work is architectural:
**patch, disable `session.upload_progress`, and prefer PHP-FPM over `mod_php`.** Any one of those three controls closes the attack path.
