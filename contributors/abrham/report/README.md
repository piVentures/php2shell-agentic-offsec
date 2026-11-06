# Task 4 — PHP2Shell Technical Assessment Report

## 1. Executive Summary

This report documents the investigation of PHP2Shell vulnerabilities CVE-2026-109618 and CVE-2026-109619 through a controlled Docker laboratory assessment and an authorized security assessment of Werabe University's public website.

The assessment consisted of two major activities:

1. Local validation of PHP2Shell PoCs using PentAGI against vulnerable, patched, and mitigated PHP environments.
2. Non-destructive security assessment of Werabe University (`wru.edu.et`), including reconnaissance, HTTP header inspection, TLS review, technology fingerprinting, and preliminary CVE exposure assessment.

The local laboratory results supplied by PentAGI report successful RCE verification against the vulnerable PHP 8.4.26 target.

The live website assessment identified an exposed PHP 7.0.33 version banner, outdated frontend libraries, missing HTTP security headers, and server information disclosure.

The live assessment did not include exploitation or command execution.

## 2. Assessment Scope

### 2.1 Local Laboratory

| Component | Target |
|---|---|
| Vulnerable PHP | `127.0.0.1:8088` |
| Patched PHP | `127.0.0.1:8089` |
| Mitigated PHP | `127.0.0.1:8090` |
| Repository | `~/php2shell` |
| Assessment Agent | PentAGI |
| CVEs | CVE-2026-109618, CVE-2026-109619 |

### 2.2 Live Website

| Attribute | Details |
|---|---|
| Organization | Werabe University |
| Primary Target | `https://wru.edu.et/` |
| Reported IP | `185.151.30.180` |
| Web Server | Apache |
| Backend PHP | PHP 7.0.33 |
| CDN / Proxy | StackCDN |
| Assessment Type | Authorized, non-destructive security assessment |

The RIMS test subdomain was identified during reconnaissance. It is not considered an independently authorized target unless included in the engagement scope.

## 3. Assessment Methodology

The assessment followed a phased approach.

### Local Laboratory Assessment

- Environment readiness and container startup.
- PoC and source code analysis.
- Vulnerability and RCE verification.
- Patched and mitigated control comparison.
- Technical reporting and remediation analysis.

### Werabe University Assessment

- Passive reconnaissance and TLS/domain analysis.
- Limited active reconnaissance and HTTP header inspection.
- Security header and TLS configuration audit.
- Vulnerability assessment and CVE analysis.
- Safe validation of findings.
- Comprehensive reporting.

## 4. Local Laboratory Findings

### 4.1 CVE-2026-109618 — RCE via OOM Corruption

| Attribute | Result |
|---|---|
| Severity | Critical in the validated lab |
| PoC Status | Confirmed, as reported by PentAGI |
| Vulnerable Runtime | PHP 8.4.26 |
| RCE | Reported verified |
| Patched Runtime | PHP 8.4.27 |
| Patched Result | RCE not observed |
| Mitigated Result | RCE not observed |
| Confidence | High, based on supplied lab evidence |

The vulnerability involves unsafe handling of memory allocation failure during PHP request processing. In the vulnerable configuration, invalid request state may be processed during shutdown, leading to memory corruption and potential RCE.

### 4.2 CVE-2026-109619 — RCE via Stale Global State

| Attribute | Result |
|---|---|
| Severity | Critical in the validated lab |
| PoC Status | Confirmed, as reported by PentAGI |
| Vulnerable Runtime | PHP 8.4.26 |
| RCE | Reported verified |
| Patched Runtime | PHP 8.4.27 |
| Patched Result | RCE not observed |
| Mitigated Result | RCE not observed |
| Confidence | High, based on supplied lab evidence |

The vulnerability involves request-owned memory remaining accessible through persistent global state after request cleanup. A subsequent operation may consume a stale reference, resulting in use-after-free and potential RCE.

### 4.3 Control Comparison

| Target | Configuration | Reported Result |
|---|---|---|
| `127.0.0.1:8088` | PHP 8.4.26 vulnerable configuration | RCE demonstrated |
| `127.0.0.1:8089` | PHP 8.4.27 upstream patched configuration | RCE not observed |
| `127.0.0.1:8090` | PHP 8.4.26 mitigated configuration | RCE not observed |

The results indicate that the upstream patch and laboratory mitigations prevented the observed exploitation behavior.

The mitigated environment is not considered fully remediated without the upstream security patch.

## 5. Werabe University Website Assessment

### 5.1 Executive Findings

The non-destructive assessment of `wru.edu.et` identified the following concerns:

| ID | Finding | Severity | Verification |
|---|---|---|---|
| WRU-01 | End-of-Life PHP 7.0.33 Runtime | High | Version banner observed |
| WRU-02 | Missing HTTP Security Headers | Medium | Header inspection |
| WRU-03 | Server and Runtime Information Disclosure | Low | Response headers |
| WRU-04 | Outdated Frontend Libraries | Medium | Technology fingerprinting |
| WRU-05 | Potential PHP2Shell CVE Exposure | Inconclusive | Version-based assessment only |

Severity ratings are preliminary and should be refined following owner-side validation and risk review.

### 5.2 WRU-01 — End-of-Life PHP Runtime

**Severity:** High

**Affected Target:** `https://wru.edu.et/`

**Observed Evidence:**

`X-Powered-By: PHP/7.0.33`

The reported PHP version is an unsupported end-of-life runtime. PHP 7.0 reached the end of upstream security support in December 2018.

Running an unsupported PHP version increases the likelihood of exposure to known vulnerabilities and limits access to security updates.

**Potential Impact:**

- Exposure to known vulnerabilities in the PHP 7.0 branch.
- Increased risk of application compromise.
- Reduced access to security patches.
- Compatibility and maintenance risks.

**CVE Relevance:**

CVE-2026-109618 and CVE-2026-109619 have published upstream affected-version ranges beginning at PHP 8.2.

PHP 7.0.33 is outside those explicitly listed ranges. Its vulnerability status for these specific CVEs cannot be determined from the version banner alone.

The possibility of vendor backports, alternative source patches, or related vulnerabilities must be evaluated separately.

**Recommendation:**

Upgrade to a currently supported PHP release and verify that the installed package contains applicable security fixes.

### 5.3 WRU-02 — Missing HTTP Security Headers

**Severity:** Medium

**Affected Target:** `https://wru.edu.et/`

The assessment reported the absence of the following security headers:

- Strict-Transport-Security
- Content-Security-Policy
- X-Frame-Options
- X-Content-Type-Options
- Referrer-Policy
- Permissions-Policy

**Potential Impact:**

The missing headers reduce browser-side security protections and may increase exposure to:

- Clickjacking.
- MIME-type sniffing.
- Content injection and XSS impact.
- Unnecessary referrer information disclosure.
- Browser feature abuse.

**Recommendation:**

Implement and test appropriate security headers at the Apache and/or StackCDN edge configuration.

### 5.4 WRU-03 — Server and Runtime Information Disclosure

**Severity:** Low

The response headers reportedly disclose Apache and PHP runtime information.

**Potential Impact:**

Detailed version disclosure may help attackers identify the technology stack and prioritize reconnaissance.

**Recommendation:**

- Set `expose_php = Off`.
- Configure Apache `ServerTokens Prod`.
- Configure Apache `ServerSignature Off`.
- Remove unnecessary server-identifying headers at the CDN edge.

### 5.5 WRU-04 — Outdated Frontend Libraries

**Severity:** Medium — preliminary

The reported technology fingerprint included:

| Technology | Observed Version |
|---|---|
| jQuery | 1.12.4 |
| Modernizr | 3.5.0 |
| Bootstrap | Version not specified |

Outdated frontend libraries may contain known security weaknesses.

The presence of an old library does not by itself confirm that a specific vulnerability is exploitable.

**Recommendation:**

Inventory the frontend dependencies, identify the exact versions, review their security advisories, and upgrade unsupported components.

### 5.6 WRU-05 — Potential PHP2Shell CVE Exposure

**Severity:** Inconclusive

The reported PHP version is 7.0.33.

The upstream affected ranges supplied for the two PHP2Shell vulnerabilities cover PHP 8.2, 8.3, 8.4, and 8.5 branches. PHP 7.0 is not explicitly included in those ranges.

Therefore:

- The PHP 7.0.33 banner confirms an EOL runtime concern.
- It does not confirm CVE-2026-109618.
- It does not confirm CVE-2026-109619.
- No live RCE testing was performed.
- Vendor-specific patch status remains unverified.

**Recommendation:**

The system owner should review the installed PHP package, source provenance, applicable vendor advisories, and effective web SAPI.

## 6. Remediation Recommendations

### Immediate Priorities

1. Upgrade the PHP 7.0.33 backend to a currently supported PHP branch.
2. Verify the installed PHP package against applicable security advisories.
3. Review Apache and CDN security header configuration.
4. Inventory outdated frontend libraries.
5. Suppress unnecessary server and runtime version disclosures.

### Security Hardening

- Implement an appropriate Content Security Policy.
- Enable HSTS after confirming HTTPS coverage and deployment readiness.
- Configure X-Frame-Options or an equivalent CSP frame-ancestors policy.
- Set X-Content-Type-Options to `nosniff`.
- Configure Referrer-Policy and Permissions-Policy.
- Review TLS protocols and cipher configuration at the CDN edge.
- Monitor application and server logs for abnormal errors.

## 7. Assessment Limitations

- The local lab findings are based on PentAGI's supplied mission results.
- Live website assessment was non-destructive.
- No RCE payloads were sent to Werabe University.
- No sensitive user or staff information was accessed.
- PHP vendor patch status was not verified internally.
- CDN and edge behavior may differ from the backend application.
- Findings are limited to the specified assessment scope.

## 8. Final Assessment

The local laboratory assessment reported successful validation of both PHP2Shell vulnerabilities against the vulnerable PHP 8.4.26 configuration.

The patched PHP 8.4.27 and mitigated PHP 8.4.26 variants did not demonstrate the same execution behavior.

The Werabe University assessment identified an EOL PHP runtime, missing HTTP security headers, information disclosure, and outdated frontend libraries.

The observed PHP 7.0.33 runtime should be prioritized for remediation. However, the specific applicability of CVE-2026-109618 and CVE-2026-109619 to this older branch remains inconclusive without vendor-specific or source-level verification.

The assessment was conducted using non-destructive methods and did not attempt live exploitation.
