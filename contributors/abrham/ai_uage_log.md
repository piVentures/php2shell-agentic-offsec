# Agentic AI Workflow Configuration and AI Usage & Intervention Log

## Project: Task 03 — PHP2Shell Agentic AI Research & PoC

**Client:** Ethiopian Higher Education Office  
**Agentic AI Framework:** PentAGI  
**Framework Version:** v2.2.0-ce  
**Repository:** [PHP2Shell Research Repository](https://github.com/zake1god/php2shell.git)  
**Primary AI Models:**
- Gemini 3.1 Flash Lite
- Gemini 3.5 Flash Lite

**AI Assistant Used for Research Support:** GPT-6 Instant

---

# Agentic AI Workflow Configuration

## 1. Overview

PentAGI v2.2.0-ce was selected as the primary agentic AI framework for the Task 03 PHP2Shell research and security assessment.

The framework was used to assist with source-code investigation, vulnerability analysis, PoC assessment, laboratory execution, controlled validation, reconnaissance, and technical reporting.

The workflow was divided into two major assessment tracks:

1. Local PHP2Shell laboratory validation.
2. Authorized live-target security assessment.

The laboratory workflow focused on the reproducibility of CVE-2026-109618 and CVE-2026-109619 against vulnerable, patched, and mitigated PHP configurations.

The live-target workflow focused on passive and low-impact reconnaissance, technology identification, configuration assessment, CVE applicability analysis, safe validation, and reporting.

The agent was used as an investigation and execution assistant. Researchers remained responsible for scope enforcement, configuration changes, result verification, and final conclusions.

## 2. Agent Configuration and Environment

| Configuration Item | Details |
|---|---|
| Framework | PentAGI |
| Version | v2.2.0-ce |
| Framework repository | https://github.com/zake1god/php2shell.git |
| Research repository | https://github.com/zake1god/php2shell.git |
| Model 1 | Gemini 3.1 Flash Lite |
| Model 2 | Gemini 3.5 Flash Lite |
| Agent execution environment | Self-hosted Kali Linux environment |
| Local test environment | Docker-based PHP2Shell laboratory |
| Lab repository path | `~/php2shell` |
| Lab orchestration file | `~/php2shell/lab/compose.yaml` |
| Agent workstation connectivity | Docker-based connectivity between PentAGI and the authorized laboratory |
| Live assessment target | Werabe University website, subject to explicit authorization and approved scope |

The framework was deployed in a self-hosted environment. Docker configuration and network connectivity were established to allow PentAGI to interact with the local laboratory.

Environment configuration, Docker connectivity, and service readiness were important prerequisites before conducting laboratory experiments.

## 3. Workflow A — Local PHP2Shell Laboratory

### Workflow Stages

1. Environment Readiness and Container Startup
2. PoC and Source Code Analysis for CVEs
3. Vulnerability and RCE Verification on Vulnerable Target
4. Control Variant Comparison (Patched and Mitigated)
5. Final Assessment and Technical Reporting

### 3.1 Environment Readiness and Container Startup

**Objective:** Establish a working and isolated laboratory before beginning vulnerability validation.

The agent was instructed to:

- Check the availability of the authorized laboratory endpoints.
- Check Docker availability and container status.
- Start only the authorized containers defined in the lab Compose configuration if they were stopped.
- Avoid starting unrelated laboratory containers.
- Verify the endpoints before proceeding.
- Record HTTP status, PHP version indicators, and container state.
- Stop testing an endpoint if activation failed and document the error.

### 3.2 PoC and Source Code Analysis for CVEs

**Objective:** Evaluate the existing PoCs and understand the relevant vulnerability prerequisites.

The agent was instructed to:

- Investigate CVE-2026-109618 and CVE-2026-109619 independently.
- Review the existing PoC implementations and related source code.
- Identify expected vulnerability prerequisites.
- Determine whether the vulnerable target met the required conditions.
- Assess whether the observed behavior was attributable to the specific CVE.
- Distinguish direct evidence from theoretical exploitability.

### 3.3 Vulnerability and RCE Verification on Vulnerable Target

**Objective:** Verify the behavior of the existing PoCs against the authorized vulnerable laboratory target.

The workflow required:

- Controlled execution of the existing laboratory PoCs.
- Use of a benign, non-sensitive proof-of-impact marker.
- Verification of expected behavior.
- Documentation of reproducibility.
- Stopping after sufficient proof was obtained.

No unrestricted shell, persistence, credential collection, secret extraction, or lateral movement was permitted.

### 3.4 Control Variant Comparison

**Objective:** Compare the vulnerable configuration with patched and mitigated laboratory variants.

The agent was instructed to:

- Evaluate the patched and mitigated configurations.
- Determine whether the observed vulnerability behavior was absent or reduced.
- Record the results and supporting evidence.
- Avoid attempting to bypass the patch or mitigation.

### 3.5 Final Assessment and Technical Reporting

**Objective:** Produce evidence-based technical findings for each CVE.

The agent was instructed to document:

- PoC status.
- Target readiness.
- Vulnerable target result.
- RCE verification status.
- Patched target result.
- Mitigated target result.
- Evidence.
- Reproducibility.
- Confidence level.

The final report was required to distinguish direct proof from theoretical exploitability.

## 4. Workflow B — Authorized Live-Target Assessment

### Workflow Stages

1. Passive Reconnaissance and TLS/Domain Analysis
2. Active Reconnaissance & Header Inspection
3. Security Headers and TLS Configuration Audit
4. Vulnerability Assessment & CVE Analysis
5. Safe Validation of Findings
6. Comprehensive Reporting and Documentation

### 4.1 Passive Reconnaissance and TLS/Domain Analysis

**Objective:** Collect publicly observable information about the authorized website.

The workflow included:

- Reviewing publicly accessible website content.
- Identifying publicly disclosed technologies and frameworks.
- Collecting domain and TLS information.
- Reviewing public metadata.
- Identifying publicly linked pages and resources.

### 4.2 Active Reconnaissance and Header Inspection

**Objective:** Perform limited, non-disruptive checks against the authorized target.

The workflow included:

- Low-rate web reconnaissance.
- Inspection of accessible paths and HTTP responses.
- HTTP header inspection.
- Identification of potentially exposed files without downloading sensitive content.
- Avoidance of aggressive crawling or excessive requests.

### 4.3 Security Headers and TLS Configuration Audit

**Objective:** Evaluate observable security configuration weaknesses.

The assessment focused on:

- HTTP security headers.
- HTTPS configuration.
- TLS-related observations.
- Server and technology disclosure.
- Relevant configuration weaknesses.

### 4.4 Vulnerability Assessment and CVE Analysis

**Objective:** Evaluate whether observed technologies and configurations presented potential security risks.

The agent was instructed to:

- Assess identified technologies against known vulnerabilities.
- Review configuration and exposure indicators.
- Evaluate potential applicability of CVE-2026-109618 and CVE-2026-109619.
- Distinguish suspected vulnerabilities from confirmed findings.
- Avoid inferring exploitability from a PHP banner alone.

### 4.5 Safe Validation of Findings

**Objective:** Validate identified findings through non-destructive methods within the authorized scope.

The workflow required:

- Benign markers or non-sensitive output only, where explicitly approved.
- Avoidance of real user or staff information.
- No modification of university data.
- Immediate stopping if a test could disrupt the website or affect users.
- Documentation of unconfirmed findings and limitations.

### 4.6 Comprehensive Reporting and Documentation

**Objective:** Produce a structured assessment report.

The report was required to include:

- Executive Summary.
- Target and Scope.
- Assessment Methodology.
- Technologies Identified.
- Findings Summary.
- Detailed Findings.
- Severity Ratings.
- Evidence and Verification Status.
- Potential Impact.
- Remediation Recommendations.
- CVE References, where applicable.
- Limitations.
- Final Security Posture Summary.

## 5. Agent Prompts and Objectives

### 5.1 Local Laboratory Mission

**Mission Title:** PHP2Shell CVE PoC Verification — Environment Readiness and RCE Validation

**Primary Objective:**

Validate the existing PoCs for CVE-2026-109618 and CVE-2026-109619 against the authorized local PHP2Shell laboratory.

The previous assessment was inconclusive because the target services were inactive. The mission therefore required environment readiness to be addressed before concluding that a PoC was not testable.

**Authorized Local Scope:**

| Endpoint | Configuration |
|---|---|
| `127.0.0.1:8088` | PHP 8.4.26 vulnerable variant |
| `127.0.0.1:8089` | PHP 8.4.27 patched variant |
| `127.0.0.1:8090` | PHP 8.4.26 mitigated variant |

**Repository:** `~/php2shell`

**Primary Target:** `127.0.0.1:8088`

No external targets were authorized under this mission.

The complete mission prompt is maintained as part of the laboratory execution records.

### 5.2 Live-Target Mission

**Mission Title:** Authorized Security Assessment of Werabe University Website

**Primary Target:**

`https://wru.edu.et/`

**Target Organization:** Werabe University, Ethiopia.

**Primary Objective:**

Conduct a controlled, evidence-based assessment of the public-facing website, focusing on:

- Web application security.
- PHP and CMS technology exposure.
- Web server configuration.
- TLS and HTTPS configuration.
- HTTP security headers.
- Publicly accessible files and directories.
- Common web application weaknesses.
- Potential applicability of CVE-2026-109618 and CVE-2026-109619.

**Scope Restrictions:**

- Testing restricted to the authorized domain and approved assets.
- Subdomains and related systems were not assumed to be in scope.
- External partner systems were excluded.
- Ambiguous scope required clarification.
- Exploitability was not inferred solely from technology identification.

**Proof of Impact:**

An agreed benign marker or non-sensitive command output only; no persistence, credential harvesting, secret extraction, or lateral movement.

The complete mission prompt is maintained as part of the live assessment execution records.

## 6. Tools Used by the Agent

| Tool | Workflow | Purpose |
|---|---|---|
| PentAGI | Both | Primary agentic AI framework |
| Docker | Laboratory | Container management and environment readiness |
| Metasploit | Laboratory | Supporting security testing tool used during laboratory investigation |
| WhatWeb | Live assessment | Web technology fingerprinting |
| ffuf | Live assessment | Web path and resource reconnaissance |
| cURL | Supporting investigation | HTTP request and response inspection |
| Netcat | Technology reconnaissance | Basic network service interaction and banner inspection |

Tool usage was constrained by the applicable laboratory or live-target scope.

## 7. Checkpoints and Stop Conditions

### Laboratory Checkpoints

- Verify the authorized endpoints are active or document activation failure.
- Verify target configuration and PHP version indicators.
- Review the existing PoC and identify prerequisites.
- Confirm the target meets the expected prerequisites before validation.
- Verify the vulnerable target behavior.
- Compare the patched and mitigated variants.
- Collect evidence and assess reproducibility.
- Complete the final technical report.

### Live-Target Checkpoints

- Verify the authorized domain and approved assets.
- Establish the exposure and prerequisites using non-invasive methods.
- Conduct only low-impact reconnaissance and assessment.
- Validate findings only through explicitly approved safe methods.
- Document findings and evidence.
- Produce the comprehensive report.

### Stop Conditions

The agent must stop or skip testing when:

- Scope is ambiguous or would expand beyond authorization.
- An endpoint cannot be activated safely.
- Unexpected sensitive data access occurs.
- A test may cause service instability or availability impact.
- A destructive action is requested.
- Exploit prerequisites cannot be established safely.
- The approved proof-of-impact objective has been achieved.

## 8. Scope Restrictions and Execution Limits

### Laboratory Restrictions

- Only the three specified local endpoints are authorized.
- Only containers defined in `~/php2shell/lab/compose.yaml` may be started for the mission.
- Unrelated lab containers must not be started.
- Use only the existing lab PoC and a benign proof of impact.
- No unrestricted shell, persistence, credential harvesting, secret extraction, or lateral movement.
- Do not attempt to bypass the patched or mitigated configurations.

### Live-Target Restrictions

- Only the authorized target and explicitly approved assets may be assessed.
- No testing of unapproved subdomains, student systems, staff portals, APIs, e-learning platforms, SIMS, or third-party integrations.
- No denial-of-service testing.
- No brute-force attacks or password spraying.
- No uncontrolled automated scanning.
- No credential harvesting, secret extraction, persistence, lateral movement, or data exfiltration.
- No destructive testing or unauthorized data modification.
- No reverse shells or interactive shells.
- No access to private student, staff, financial, or academic records.
- No live exploitation unless the exact technique and proof-of-impact objective are explicitly authorized.
- Use conservative request rates and minimize unnecessary traffic.
- Stop immediately if the website becomes unstable.

---

# AI Usage and Intervention Log

## 1. Overview

GPT-6 Instant was used as a supporting AI assistant throughout the research and implementation process.

Its role was to assist with PentAGI environment configuration, Docker connectivity, prompt preparation, troubleshooting, documentation, and general technology reconnaissance.

PentAGI remained the primary agentic AI framework for the investigation and execution workflows.

The human researchers retained responsibility for environment configuration, authorization, technical guidance, corrections, evidence verification, and final reporting.

## 2. AI Usage Summary

| Item | Details |
|---|---|
| Supporting AI assistant | GPT-6 Instant |
| Primary agentic framework | PentAGI v2.2.0-ce |
| Agent models/providers | Gemini 3.1 Flash Lite and Gemini 3.5 Flash Lite |
| Main objective | Support the PHP2Shell research, laboratory validation, authorized assessment, and documentation workflow |
| Main environment | Self-hosted Kali Linux and Docker laboratory |
| Research repository | https://github.com/php/php-src/security/advisories/GHSA-w8hw-w9fx-j79w, https://github.com/php/php-src/security/advisories/GHSA-6wmf-4rv5-p3rp |

## 3. AI-Assisted Activities

### 3.1 PentAGI Environment Configuration

GPT-6 Instant assisted with:

- Docker configuration analysis.
- PentAGI-to-laboratory connectivity troubleshooting.
- Laboratory container startup and network configuration guidance.
- Debugging environment readiness issues.
- Identifying configuration inconsistencies.
- Supporting the establishment of connectivity between PentAGI and the local lab.

### 3.2 Prompt Preparation and Mission Definition

GPT-6 Instant assisted in preparing and refining the PentAGI mission prompts for:

- Local PHP2Shell laboratory validation.
- CVE-specific PoC assessment.
- Vulnerable, patched, and mitigated target comparison.
- Authorized live-target security assessment.
- Evidence collection and reporting.
- Scope restrictions and stop conditions.

The prompts were designed to make the agent's objectives, authorized assets, execution boundaries, and reporting requirements explicit.

### 3.3 Troubleshooting and Human-Guided Corrections

GPT-6 Instant was used to assist with troubleshooting when PentAGI or the laboratory environment encountered configuration-related issues.

Human interventions included:

- Docker environment configuration.
- Debugging connectivity and environment readiness problems.
- Correcting configuration settings.
- Correcting file paths and repository references.
- Providing additional mission guidance.
- Clarifying the authorized scope and expected outcomes.

These interventions were necessary to establish the environment and ensure that agent execution remained aligned with the intended research objectives.

### 3.4 Documentation and Reporting

GPT-6 Instant assisted with:

- Drafting laboratory documentation.
- Preparing research README files.
- Structuring technical reports.
- Summarizing observed findings.
- Organizing evidence and deliverable requirements.
- Preparing the root repository README.
- Identifying missing Task 03 deliverables.
- Preparing documentation for the agentic workflow and AI usage record.

Generated documentation was subject to researcher review and correction.

### 3.5 General Reconnaissance Support

GPT-6 Instant provided supporting guidance for general technology enumeration and interpretation of publicly observable information.

The supporting activities included:

- Reviewing technology fingerprinting outputs.
- Assisting with the interpretation of HTTP headers.
- Supporting the analysis of PHP version disclosures.
- Helping distinguish technology observations from confirmed vulnerability findings.
- Organizing reconnaissance results for documentation.

Live-target reconnaissance was conducted using the tools and restrictions defined in the applicable PentAGI mission.

## 4. Human Intervention and Correction Log

| Intervention Category | Description | Purpose |
|---|---|---|
| Docker configuration | Human-assisted adjustment and troubleshooting of Docker configuration | Establish the intended isolated lab environment |
| Connectivity debugging | Human guidance for PentAGI-to-lab communication issues | Restore connectivity to authorized test endpoints |
| Environment readiness | Human intervention when services or containers were not available | Prevent incorrect conclusions caused by inactive targets |
| Path correction | Correction of file paths and repository references | Ensure the agent operated on the intended configuration and files |
| Prompt preparation | Human review and refinement of mission prompts | Define precise objectives and safety restrictions |
| Scope guidance | Clarification of authorized targets and execution limits | Prevent scope expansion |
| Documentation review | Human review and correction of AI-assisted documentation | Improve technical accuracy and reporting integrity |

Human interventions were recorded as part of the overall research process. The researchers remained accountable for all final technical conclusions.

## 5. Agent Claims and Independent Verification

The project distinguishes between agent-generated claims and independently verified results.

For each significant result, the research record should identify:

- The agent's reported outcome.
- The relevant tool action and output.
- Supporting evidence.
- The human verification method.
- Any corrections or discrepancies.
- The final verification status.

Agent-generated statements were not automatically treated as confirmed findings.

## 6. AI Usage Record

| Activity | AI Used | Human Role | Output |
|---|---|---|---|
| PentAGI environment setup | GPT-6 Instant | Configuration and debugging | Environment setup guidance |
| Docker connectivity troubleshooting | GPT-6 Instant | Connection and configuration corrections | Connectivity troubleshooting record |
| Local lab mission prompt | GPT-6 Instant | Prompt review and scope definition | Laboratory mission prompt |
| Live-target mission prompt | GPT-6 Instant | Authorization and safety guidance | Live assessment mission prompt |
| Laboratory investigation | PentAGI with Gemini models | Oversight and result verification | Lab execution traces and findings |
| Live reconnaissance | PentAGI with Gemini models | Scope enforcement and review | Reconnaissance outputs |
| Technical documentation | GPT-6 Instant | Review and correction | README files and report drafts |
| Research planning | GPT-6 Instant | Research direction and prioritization | Task 03 deliverable checklist |

## 7. Research Integrity and Accountability

The AI systems were used as research and execution assistants, not as independent authorities.

The researchers were responsible for:

- Ensuring that all activities were within the authorized scope.
- Reviewing agent-generated prompts and actions.
- Correcting configuration and execution issues.
- Verifying technical evidence.
- Distinguishing observed behavior from inferred vulnerability.
- Reporting failed, inconclusive, and successful tests accurately.
- Ensuring that no confidential information or credentials were included in public repository artifacts.

The final findings and conclusions were subject to human review.

## 8. Summary

PentAGI v2.2.0-ce was the primary agentic framework used for the PHP2Shell investigation. Gemini 3.1 Flash Lite and Gemini 3.5 Flash Lite were used as the framework's AI models.

GPT-6 Instant supported the workflow through environment troubleshooting, Docker configuration guidance, mission prompt preparation, documentation, and research planning.

The workflow combined autonomous agent investigation with human intervention and independent verification. This approach was intended to improve reproducibility, maintain scope control, and ensure that the final findings were supported by technical evidence rather than agent-generated claims alone.