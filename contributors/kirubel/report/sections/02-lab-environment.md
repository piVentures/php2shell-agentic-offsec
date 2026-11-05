# 02 — Lab Environment

## Architecture

| Component | Value |
|---|---|
| Vulnerable container | `php:8.3.35-apache` (last vulnerable 8.3 release) |
| Patched container | `php:8.3.36-apache` (first fixed 8.3 release) |
| SAPI | Apache 2.0 Handler (`mod_php`, prefork MPM) |
| Application | Custom `index.php` — see [`../../lab/`](../../lab/) |
| Vulnerable host port | 8080 |
| Patched host port | 8081 |

## Application source

`index.php` contains three deliberate components required for the exploit:

- **`session_start()`** — registers the `session.upload_progress` handler
- **Multipart upload form** (`profile_pic` field) — the payload delivery mechanism
- **LFI sink** — `include($_GET['page'])` — turns session-file poisoning into RCE

## PHP configuration

```ini
memory_limit = 8M
post_max_size = 64M
max_input_vars = 1000
session.upload_progress.enabled = On
The post_max_size > memory_limit ratio is the specific misconfiguration
that makes CVE-618 reachable: PHP accepts the oversized body at the door,
then exhausts memory while parsing it.

Evidence
The lab consists of two Docker containers running side-by-side. The terminal output confirms both are up: the vulnerable target on port 8080 and the patched control on port 8081.

https://../screenshots/s02-lab-setup.png

Reproducibility
bash
Copy
Download
cd lab/
docker compose up -d
docker compose ps
curl -s -o /dev/null -w "vulnerable 8080 -> %{http_code}\n" http://localhost:8080/index.php
curl -s -o /dev/null -w "patched    8081 -> %{http_code}\n" http://localhost:8081/index.php
Both should return 200.
