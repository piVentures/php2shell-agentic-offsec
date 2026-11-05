# 07 — Agent Integration Findings

## Successes

- **Environment adaptation.** The sandbox lacked `curl` and `python3`. The
  agent selected `perl` + `IO::Socket::INET` and wrote a raw-socket HTTP
  client from scratch, reconstructing the multipart boundary and
  `Content-Length`.
- **Transport adaptation.** When `curl -F` failed with exit code 26 (the `<`
  character in `<?php …` was interpreted as a file redirect), the agent
  diagnosed the error and pivoted to `--form-string`.
- **Network pivoting.** On the patched-lab run, the Docker network wasn't
  routable from the sandbox. The agent found the host-gateway bridge
  (`172.17.0.1:8081`) and re-targeted.
- **Correct interpretation of HTTP status.** The agent did not claim RCE on
  `405` / `400` / `403` responses — it correctly recognized those as
  application-layer rejections, not memory corruption.

## Failures and required interventions

- **Session ID validation.** One attempt used `pentagi_eict` (contains an
  underscore), which PHP's session validator rejects. The agent read the PHP
  warning in the response body and corrected to an alphanumeric ID — but
  only after a wasted round-trip.
- **Provider reliability.** Several flows terminated on LLM provider
  `503` / `429` errors. In one case the agent lost task context and began
  scanning its own Docker bridge network (`172.17.0.0/16`) — an
  out-of-scope action against the control-plane containers. This was caught
  by manual intervention and is documented as a governance finding.

## Evidence

The agent's raw execution is shown in [03](03-cve-619-results.md) and
[04](04-cve-618-results.md). Full logs are in
[`../../logs/`](../../logs/).
