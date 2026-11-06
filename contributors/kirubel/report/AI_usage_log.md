# Task 03: AI Usage and Intervention Log

This document serves as the official AI Usage and Intervention Log for Task 03 (PHP2Shell Agentic AI Research & PoC). It tracks the interaction between the human researcher (the Engineer) and the Task 02 Agent (PentAGI). It details how the Engineer directed the agent's planning and execution, the tool actions taken, and the critical human interventions required to ensure accurate, evidence-based results.

## 1. Engineer's Role & Contribution

The AI agent was not given a blank canvas; its success was entirely dependent on the Engineer's planning, environment design, and continuous supervision. The Engineer's primary contributions included:

*   **Environment Design:** Authoring the vulnerable `index.php` (including the explicit `include($_GET['page'])` LFI sink), writing the custom `php.ini` to enforce `post_max_size > memory_limit` (a strict prerequisite for CVE-618), and orchestrating the vulnerable and patched Docker containers.
*   **Strategic Planning:** Defining the exact payload structure, selecting the target endpoints (e.g., `/index.php`), and dictating the sequence of the exploit (the initial POST followed by the LFI GET).
*   **Prompt Engineering:** Crafting precise instructions that constrained the agent to an air-gapped environment, preventing it from downloading external tools and forcing it to pivot to local binaries like `perl`.
*   **Verification:** Independently reviewing the agent's raw terminal outputs against the HTTP status codes to prevent the acceptance of hallucinated or false-positive summaries.

---

## 2. Trial Logs

### Trial 1: Local Lab PoC - CVE-2026-109619 (UAF)
*   **Engineer's Plan:** Instruct the agent to send a multipart POST with a `PHP_SESSION_UPLOAD_PROGRESS` payload to `http://172.24.0.2/index.php`. Immediately follow up with an LFI GET request to `/tmp/sess_pentagi123` using the same session cookie to trigger execution.
*   **Agent Tool Actions:**
    1. Attempted to check for `python3` and `curl` (failed due to air-gap).
    2. Followed Engineer's guidance to verify `perl` and `IO::Socket::INET` availability.
    3. Autonomously wrote a complex raw-socket Perl script to construct the multipart boundary and HTTP headers.
    4. Executed the POST and GET sequence.
*   **Observed Results:** The agent captured `uid=33(www-data) gid=33(www-data)` in the LFI response.
*   **Engineer Intervention:** The Engineer read the raw HTTP response in the PentAGI terminal to confirm the `uid=` output was genuine. The AI's claim of success was only accepted after the Engineer visually verified the raw output.

### Trial 2: Local Lab PoC - CVE-2026-109618 (OOM)
*   **Engineer's Plan:** Instruct the agent to generate an ~8.25MB multipart POST to exhaust the 8MB `memory_limit` configured by the Engineer. Follow with the LFI GET.
*   **Agent Tool Actions:**
    1. Wrote a Perl script (`exploit_618.pl`) to generate the massive payload buffer.
    2. Sent the POST request.
    3. Triggered the LFI.
*   **Observed Results:** The agent received a `500 Internal Server Error` (Allowed memory size exhausted) on the POST, and successfully retrieved `uid=33(www-data)` on the LFI.
*   **Engineer Intervention:** The Engineer verified the logs to ensure the 500 error was the expected PHP OOM failure, confirming the memory limit was successfully exhausted rather than the server simply crashing.

### Trial 3: Patched Negative Control
*   **Engineer's Plan:** Direct the agent to send the exact same payloads to the patched container (`php:8.3.36-apache`) to prove the patch mitigates both flaws.
*   **Agent Tool Actions:** Executed the identical UAF and OOM payloads via Perl against port 8081.
*   **Observed Results:** Both POST requests returned `200 OK`. The LFI requests returned `Page not found`.
*   **Engineer Intervention:** The Engineer verified that "Page not found" proved the session file was never created, validating the patch and confirming the agent did not falsely claim success.

---

## 3. Summary of Key Human Interventions

While the agent demonstrated high capability in writing custom Perl tooling and executing complex HTTP sequences, the Engineer's oversight was critical to the integrity of the research:

1.  **Tooling Pivot (Guided Autonomy):** When the agent became stuck trying to install `python3` via `apt-get`, the Engineer intervened and redirected it to use the pre-installed `perl` binary, saving time and API tokens.
2.  **Context Recovery:** During Gemini API rate limits (429/503 errors), the agent lost task context and attempted to scan its own Docker bridge network. The Engineer terminated the runaway process, cleaned up the orphaned containers, and restarted the flow with a fresh prompt.
3.  **Raw Output Verification:** The Engineer explicitly read the raw terminal output (HTTP status codes and response bodies) rather than trusting the agent's summaries. This ensured the findings in the final report were strictly evidence-based and defensible.