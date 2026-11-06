# Task 4 — PHP2Shell Vulnerability Research and Reconnaissance

## 1. Overview

This research investigates the PHP2Shell vulnerabilities CVE-2026-109618 and CVE-2026-109619 and examines potential exposure across selected Ethiopian university websites under the `*.edu.et` domain.

The research combines:

- Public vulnerability analysis.
- PHP security release comparison.
- Passive reconnaissance.
- Public technology fingerprinting.
- HTTP response and security header analysis.
- Preliminary vulnerability exposure assessment.
- An authorized non-destructive assessment of Werabe University.

The objective is to identify outdated technology, understand the potential relevance of the vulnerabilities, and document security findings without performing unauthorized exploitation.

## 2. Research Objectives

- Understand the technical mechanisms behind both PHP2Shell vulnerabilities.
- Identify PHP-based web technologies across selected university websites.
- Collect publicly disclosed runtime version information.
- Compare observed PHP versions against upstream security release boundaries.
- Identify potentially exposed systems requiring further verification.
- Assess publicly visible web server security configurations.
- Document limitations of external version-based assessments.
- Provide actionable security recommendations.

## 3. Vulnerability Background

### 3.1 CVE-2026-109618 — RCE via OOM Corruption

The vulnerability involves PHP's handling of out-of-memory conditions during request processing.

PHP may use `longjmp()` to exit request processing after memory exhaustion. In certain contexts, request memory may be temporarily reachable before it has been fully initialized.

An allocation failure can cause PHP to exit without correctly accounting for the incomplete state. Subsequent request shutdown handling may consume invalid memory state, potentially resulting in remote code execution.

The affected behavior is associated with specific PHP versions and server configurations.

### 3.2 CVE-2026-109619 — RCE via Stale Global State

The vulnerability involves request-owned memory retained through persistent global state.

Some PHP workers retain global state between requests. If request-owned memory is released while a persistent global reference remains, a later request may consume a stale reference before normal initialization resets it.

This can result in use-after-free conditions and potentially remote code execution.

Successful exploitation requires an applicable producer and consumer sequence, together with the relevant PHP runtime, SAPI, configuration, and worker lifecycle.

## 4. Affected and Fixed Versions

The upstream version boundaries supplied for the vulnerabilities are:

| PHP Branch | Affected Upstream Versions | First Fixed Release |
|---|---|---|
| PHP 8.2 | Below 8.2.35 | 8.2.35 |
| PHP 8.3 | Below 8.3.36 | 8.3.36 |
| PHP 8.4 | Below 8.4.27 | 8.4.27 |
| PHP 8.5 | Below 8.5.12 | 8.5.12 |

PHP 8.1 and older are outside normal upstream support. PHP published source backports for certain legacy branches, including PHP 7.4, 8.0, and 8.1, while operating system and LTS vendors may maintain additional backports.

An older PHP version should not automatically be classified as affected by these specific CVEs based solely on its age.

Assessment must consider:

- Applicable upstream vulnerability boundaries.
- Vendor-specific backports.
- Effective web SAPI.
- PHP source modifications.
- Installed package provenance.
- Relevant security advisories.

## 5. PHP CVE Research — Primary Reconnaissance Subjects

## 5.1 Primary Reconnaissance Subjects

The following Ethiopian universities were selected as primary subjects for technology reconnaissance and preliminary PHP-version research. Their inclusion does not, by itself, indicate authorization for active vulnerability testing.

- Adama Science and Technology University
- Addis Ababa Science and Technology University
- Addis Ababa University
- Adigrat University
- Aksum University
- Arsi University
- Assosa University
- Bahir Dar University
- Bule Hora University
- Haramaya University
- Hawassa University
- Jimma University
- Jinka University
- Samara University
- Wolaita Sodo University
- Woldia University
- Wolkite University
- Wollega University
- Wollo University

## 5.2 Technology Identification

The following tools were used during preliminary reconnaissance to identify technologies and collect publicly observable server information:

- **BuiltWith** — Website technology profiling and technology-stack identification.
- **WhatWeb** — Web technology fingerprinting, including server and application components.
- **WebLizzer** — Website technology and framework identification.
- **Netcat (nc)** — Basic network service interaction and banner inspection where appropriate.

These tools supported the identification of web-server technologies and PHP version disclosures.

## 5.3 Preliminary PHP Version Observations

Reconnaissance indicated that **most of the primary reconnaissance subjects appeared to be running patched PHP versions or versions outside the reported affected ranges** for the CVEs under investigation.

The reviewed observations did not indicate that most subjects were running the vulnerable PHP versions associated with the investigated CVEs.

However, version identification based on public banners and fingerprinting tools is preliminary. It does not establish the presence or absence of vendor backports, hidden services, or application-level vulnerabilities. Therefore, the observations should be treated as preliminary technology findings rather than confirmed security assessments.

A subject should only be classified as confirmed patched or confirmed vulnerable when the version, applicable patch status, and relevant evidence have been independently validated.


## 6. Research Methodology

### 6.1 Passive Reconnaissance

Publicly available information is reviewed to identify:

- Domain and DNS information.
- Publicly disclosed technologies.
- HTTP response headers.
- Public metadata.
- Web server fingerprints.
- Publicly linked resources.
- Technology version disclosures.

### 6.2 Version-Based Exposure Assessment

Observed PHP versions are compared against the published upstream fixed release boundaries.

The following classifications are used:

| Classification | Description |
|---|---|
| Potentially Affected | Observed version is within a documented upstream affected range; vendor patch status requires verification |
| Upstream Fixed Version | Observed version is at or above the published upstream fix boundary |
| Inconclusive | PHP version is not disclosed or cannot be reliably identified |
| Unknown Patch Status | Vendor-specific versioning or patch provenance is unclear |
| Unreachable | No usable response was obtained |

Version-based classification is preliminary. It does not establish whether the relevant SAPI, configuration, or exploit prerequisites are present.

### 6.3 Security Configuration Review

Public HTTP response headers are reviewed for:

- HSTS.
- Content Security Policy.
- X-Frame-Options.
- X-Content-Type-Options.
- Referrer-Policy.
- Permissions-Policy.
- Server and runtime information disclosure.

### 6.4 Responsible Assessment

The research does not include:

- Unauthorized exploitation.
- Memory exhaustion attacks against live targets.
- Credential harvesting.
- Secret extraction.
- Persistence.
- Lateral movement.
- Denial-of-service testing.

Live findings are validated through non-destructive evidence unless additional explicit authorization is provided.

## 7. Preliminary Research Observations

Initial passive reconnaissance suggests that many observed university websites disclose PHP versions that appear to be at or above the upstream fixed boundaries.

However, the current inventory does not provide a complete per-university version and package verification dataset.

Consequently, the following conclusions are appropriate:

- Some observed PHP versions may fall within upstream patched ranges.
- Version disclosure does not prove that the installed package contains the applicable security patch.
- Older PHP branches require separate vulnerability-specific analysis.
- Systems with undisclosed versions remain inconclusive.
- No university in the research inventory is classified as confirmed exploitable based solely on the supplied reconnaissance information.

The Werabe University assessment is documented separately as a detailed case study.

## 8. Case Study — Werabe University (WRU)

### 8.1 Target Overview

| Attribute | Details |
|---|---|
| Organization | Werabe University |
| Primary Website | `https://wru.edu.et/` |
| Reported IP | `185.151.30.180` |
| Web Server | Apache |
| Backend Runtime | PHP 7.0.33 |
| CDN / Proxy | StackCDN |
| Assessment Type | Authorized, non-destructive assessment |

The assessment covered passive reconnaissance, limited active HTTP inspection, security header analysis, technology fingerprinting, and safe vulnerability assessment.

The RIMS test subdomain was identified during reconnaissance. Its inclusion in the assessment scope must be supported by separate authorization.

### 8.2 Passive Reconnaissance and TLS/Domain Analysis

The passive reconnaissance phase identified:

- Primary domain: `wru.edu.et`.
- Reported infrastructure using Apache and StackCDN.
- Publicly linked pages such as `/wru_glance`.
- Publicly linked resources such as `/wru_service_library`.
- A discovered RIMS test subdomain: `test.rims.wru.edu.et`.

TLS was operational for the primary website.

No sensitive configuration or directory disclosures were reported through public search indices.

### 8.3 Active Reconnaissance and HTTP Inspection

The limited HTTP inspection reported:

| Attribute | Observation |
|---|---|
| HTTP Status | 200 OK |
| Protocol | HTTP/2 |
| Web Server | Apache |
| PHP Version | 7.0.33 |
| CDN / Proxy | StackCDN |
| Frontend | Bootstrap, jQuery, Modernizr |

The response reportedly disclosed:

`X-Powered-By: PHP/7.0.33`

The reported frontend libraries included jQuery 1.12.4 and Modernizr 3.5.0.

The observed PHP version is end-of-life and presents a significant maintenance and security concern.

### 8.4 Security Headers and TLS Configuration

The assessment reported the absence of:

- Strict-Transport-Security.
- Content-Security-Policy.
- X-Frame-Options.
- X-Content-Type-Options.
- Referrer-Policy.
- Permissions-Policy.

HTTPS was operational through the CDN edge.

The absence of HSTS reduces browser-enforced transport security for subsequent visits. TLS protocol and cipher configuration at the edge require independent verification.

### 8.5 PHP2Shell CVE Assessment

The observed PHP runtime was PHP 7.0.33.

The two PHP2Shell CVEs have upstream affected-version ranges beginning with PHP 8.2.

PHP 7.0.33 is not included in those explicitly listed ranges.

Therefore:

| CVE | Assessment |
|---|---|
| CVE-2026-109618 | Specific applicability to PHP 7.0.33 is inconclusive |
| CVE-2026-109619 | Specific applicability to PHP 7.0.33 is inconclusive |

The EOL runtime is a verified concern, but it is not sufficient evidence of applicability to these two CVEs.

No live exploit payloads were executed.

### 8.6 WRU Findings Summary

| ID | Finding | Severity | Status |
|---|---|---|---|
| WRU-01 | End-of-Life PHP 7.0.33 Runtime | High | Version banner observed |
| WRU-02 | Missing HTTP Security Headers | Medium | Header inspection |
| WRU-03 | Server and Runtime Information Disclosure | Low | Header inspection |
| WRU-04 | Outdated Frontend Libraries | Medium, preliminary | Fingerprinting |
| WRU-05 | PHP2Shell CVE Exposure | Inconclusive | Version-based assessment |

### 8.7 Remediation Recommendations

#### PHP Runtime

Upgrade the backend PHP runtime to a currently supported, security-patched version.

Verify the installed package against applicable vendor advisories and confirm the effective web SAPI.

#### HTTP Security Headers

Implement appropriate policies for:

- Strict-Transport-Security.
- Content-Security-Policy.
- X-Frame-Options or CSP `frame-ancestors`.
- X-Content-Type-Options.
- Referrer-Policy.
- Permissions-Policy.

#### Information Disclosure

Suppress unnecessary server and runtime version information through PHP, Apache, and StackCDN configuration.

#### Frontend Libraries

Inventory frontend dependencies and upgrade unsupported libraries after reviewing compatibility and security advisories.

#### TLS

Review the CDN edge configuration for supported TLS protocols and cipher suites.

## 9. Research Limitations

- Version banners may be inaccurate or incomplete.
- Vendor-specific backports cannot always be verified externally.
- Effective PHP SAPI and internal configuration may not be publicly observable.
- The university inventory does not contain complete version results for every target.
- The WRU assessment did not include live RCE validation.
- Results are limited to publicly accessible information and authorized assessment scope.

## 10. Conclusion

This research examines PHP2Shell vulnerabilities and their potential relevance to selected Ethiopian university websites.

The local laboratory provides a controlled environment for investigating both vulnerabilities and evaluating security patches.

Passive reconnaissance suggests that many university websites may already disclose PHP versions within upstream fixed ranges, although the complete patch status remains unverified.

The Werabe University assessment identified an EOL PHP runtime, missing HTTP security headers, server information disclosure, and outdated frontend libraries.

The EOL PHP 7.0.33 runtime should be prioritized for remediation. However, the specific applicability of CVE-2026-109618 and CVE-2026-109619 to PHP 7.0.33 remains inconclusive without additional vendor-specific or source-level verification.

The research emphasizes evidence-based vulnerability classification, responsible reconnaissance, and the importance of maintaining supported software.

