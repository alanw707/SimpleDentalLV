#!/usr/bin/env python3
"""
Example FTP deployment configuration.

- Copy this file to `deployconfig.py` and fill in real values for local deployments.
- `deployconfig.py` is in `.gitignore` and must never be committed.
- In GitHub Actions, use `FTP_HOST`, `FTP_USERNAME`, `FTP_PASSWORD`, and
  `FTP_REMOTE_PATH` secrets instead of committing credentials.
"""

FTP_CONFIG = {
    'host': 'ftp.yourdomain.com',
    'username': 'your-ftp-username',
    'password': 'your-ftp-password',
    'remote_path': '/public_html/wp-content/themes/'
}

