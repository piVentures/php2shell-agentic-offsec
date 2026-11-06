# PHP CVE Research and Security Assessment

## Overview

This repository documents research and security assessment activities related to PHP vulnerabilities, with a focus on CVE-2026-109618 and CVE-2026-109619.

The project is organized into three main areas:

- **Lab:** Local Docker-based validation of the investigated PHP vulnerabilities.
- **Report:** Consolidated security assessment findings, including the local lab and WRU website assessment.
- **Research:** Background research, technology reconnaissance, and preliminary PHP-version observations involving selected Ethiopian universities.

The project combines controlled vulnerability validation, technology identification, evidence documentation, and remediation recommendations.

> **Important:** Vulnerability validation was conducted within an isolated local lab. Public-facing website reconnaissance was limited to authorized and low-impact activities. The inclusion of a website or institution in the research does not imply that exploitation was performed or that a vulnerability was confirmed.

---

## Repository Structure

```text
.
├── README.md
├── lab/
│   └── README.md
├── report/
│   └── README.md
└── research/
    └── notes.md
```

---

## Directory and File Descriptions

### 1. `lab/`

Contains documentation for the local Docker laboratory used to investigate the behavior of the PHP vulnerabilities.

| File | Description |
|---|---|
| `lab/README.md` | Describes the lab environment, target configurations, validation outcomes reported by PentAGI, evidence files, and the distinction between vulnerable, patched, and mitigated configurations. |

The lab includes:

- A vulnerable PHP configuration.
- A patched PHP configuration.
- A mitigated PHP configuration.
- Documentation of the validation results and supporting evidence.

The lab README references supporting evidence artifacts associated with the individual CVE investigations.

### 2. `report/`

Contains the consolidated security assessment report.

| File | Description |
|---|---|
| `report/README.md` | Summarizes the local lab findings and the WRU website assessment, including identified technologies, observations, severity classifications, limitations, and remediation recommendations. |

The report covers:

- Local validation of CVE-2026-109618 and CVE-2026-109619.
- Preliminary technology identification for `https://wru.edu.et/`.
- PHP version disclosure and security-header observations.
- CVE applicability considerations.
- Recommended remediation and hardening measures.

The report distinguishes between confirmed local lab results and preliminary observations collected from the public-facing website.

### 3. `research/`

Contains the broader research documentation for the investigated PHP vulnerabilities and preliminary reconnaissance.

| File | Description |
|---|---|
| `research/README.md` | Provides vulnerability background, preliminary PHP version research, primary reconnaissance subjects, technology-identification methodology, observations, and research limitations. |

The research documentation includes:

- Background information on the investigated CVEs.
- Relevant PHP version and patch considerations.
- Primary reconnaissance subjects consisting of selected Ethiopian universities.
- Preliminary observations indicating that most reviewed subjects appeared to use patched PHP versions or versions outside the reported affected ranges.
- Technology-identification methodology using BuiltWith, WhatWeb, WebLizzer, and Netcat.
- Research limitations and recommendations for further verification.

The universities are listed as primary reconnaissance subjects, not as a blanket authorization scope for active testing.

---

## Technology and Tools

The following tools were used during the research and assessment activities:

| Tool | Purpose |
|---|---|
| PentAGI | AI-assisted security assessment and lab validation workflow. |
| Docker | Isolation and management of local PHP lab targets. |
| BuiltWith | Website technology profiling. |
| WhatWeb | Web technology fingerprinting. |
| WebLizzer | Technology-stack identification. |
| Netcat (`nc`) | Basic network service interaction and banner inspection. |
| cURL | HTTP request and response inspection. |
| Kali Linux | Security research and testing environment. |

---

## Key Research Findings

- The local Docker lab was used to compare vulnerable, patched, and mitigated PHP configurations.
- PentAGI reported successful validation results for the vulnerable lab targets.
- The WRU website assessment identified PHP version disclosure and several missing security headers.
- CVE-specific applicability to the WRU website was classified as inconclusive based on the available public version information.
- Preliminary reconnaissance indicated that most reviewed university subjects appeared to use patched PHP versions or versions outside the reported affected ranges.
- Technology fingerprinting results are preliminary and do not independently establish a system's complete security posture.

---

## Responsible Research

This project follows a controlled and evidence-based research approach.

- Local exploit validation is confined to the isolated lab environment.
- Public website reconnaissance is restricted to authorized, low-impact techniques.
- No claim of confirmed exploitation is made without supporting evidence.
- Reconnaissance observations are distinguished from verified vulnerability findings.
- Remediation recommendations prioritize supported software versions, security configuration, and reduced technology disclosure.
