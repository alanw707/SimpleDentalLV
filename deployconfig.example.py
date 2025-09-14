#!/usr/bin/env python3
"""
Example FTP deployment configuration.

- Copy this file to `deployconfig.py` and fill in real values.
- `deployconfig.py` is in .gitignore and must never be committed.
"""

FTP_CONFIG = {
    'host': 'ftp.yourdomain.com',
    'username': 'your-ftp-username',
    'password': 'your-ftp-password',
    'remote_path': '/public_html/wp-content/themes/'
}

