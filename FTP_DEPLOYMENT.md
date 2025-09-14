# Automated FTP Deployment Guide

## Secure Setup (recommended)

- Credentials live only in `deployconfig.py` (git-ignored).
- Do not place passwords inside docs or scripts committed to git.

1) Create your local config from the example:
```bash
cp deployconfig.example.py deployconfig.py
```

2) Edit `deployconfig.py` with your real credentials:
```python
FTP_CONFIG = {
    'host': 'ftp.yourdomain.com',          # FTP hostname
    'username': 'your-ftp-username',       # FTP username
    'password': 'your-ftp-password',       # FTP password
    'remote_path': '/public_html/wp-content/themes/'
}
```

3) Deploy the entire theme:
```bash
python3 deploy-robust.py
```

4) Deploy a single file (path is relative to `simple-dental-theme/`):
```bash
python3 deploy-robust.py assets/js/navigation.js
```

`deployconfig.py` is already listed in `.gitignore` to prevent accidental commits.

## Finding Your FTP Details

### Hostinger FTP Information
1. Log into Hostinger control panel
2. Go to **Hosting > Manage > File Manager** 
3. Look for FTP credentials or click **FTP Accounts**

**Common Hostinger paths:**
- Main domain: `/public_html/wp-content/themes/`
- Subdomain: `/public_html/subdomain/wp-content/themes/`
- WordPress in folder: `/public_html/folder-name/wp-content/themes/`

### FTP Connection Details
- **Host**: Usually `ftp.yourdomain.com` or `yourdomain.com`
- **Port**: 21 (standard FTP)
- **Username**: Your hosting username or FTP-specific username
- **Password**: Your hosting password or FTP-specific password

## What the Script Does

1. **Connects** to your FTP server
2. **Navigates** to WordPress themes directory
3. **Removes** existing Simple Dental theme (if present)
4. **Uploads** all theme files recursively
5. **Confirms** successful deployment

## After Deployment

1. Log into WordPress admin
2. Go to **Appearance > Themes**
3. Find "Simple Dental" theme
4. Click **Activate**
5. Follow the setup steps in `INSTALLATION_GUIDE.md`

## Troubleshooting

### Common Issues

**"Cannot access remote path"**
- Check if WordPress is installed
- Verify the `/wp-content/themes/` directory exists
- Try different path: `/public_html/wordpress/wp-content/themes/`

**"FTP Permission Error"**
- Check username/password
- Ensure FTP access is enabled in hosting panel
- Try using main hosting credentials

**"Host not found"**
- Try `ftp.yourdomain.com`
- Try just `yourdomain.com`
- Check Hostinger control panel for exact FTP hostname

### Manual Verification
You can verify the upload worked by:
1. Using FTP client (FileZilla) to browse to themes folder
2. Checking if `simple-dental-theme` folder exists
3. Looking for files like `style.css`, `functions.php`

## Security Note

- Credentials belong only in `deployconfig.py` (git-ignored).
- Never commit FTP passwords to repositories or documentation.
- If a password was ever committed, rotate it immediately, then scrub it from git history (see below).

### Scrubbing Secrets from Git History (if needed)
If a credential was committed in the past, remove it from history and force-push:

Option A – git-filter-repo (recommended):
```bash
pipx install git-filter-repo  # or: pip install git-filter-repo
git filter-repo --path FTP_DEPLOYMENT.md --invert-paths
git push --force
```

Option B – BFG Repo-Cleaner:
```bash
java -jar bfg.jar --replace-text replacements.txt  # see BFG docs
git push --force
```

After rewriting history, rotate any exposed passwords with your hosting provider.

## Alternative: SFTP/SSH
If your host supports SFTP, you can modify the script to use `paramiko` library for secure file transfer.
