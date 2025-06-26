# Automated FTP Deployment Guide

## Quick Setup

### Option 1: Simple Deployment (credentials in script)
1. Edit `deploy.py` and update the FTP_CONFIG section:
```python
FTP_CONFIG = {
    'host': 'your-actual-hostname.hostinger.com',
    'username': 'your-ftp-username',
    'password': 'your-ftp-password',
    'remote_path': '/public_html/wp-content/themes/'
}
```

2. Run deployment:
```bash
python3 deploy.py
```

### Option 2: Secure Deployment (separate config file)
1. Copy the example config:
```bash
cp deploy-config.example.py ftp_config.py
```

2. Edit `ftp_config.py` with your credentials:
```python
FTP_CONFIG = {
    'host': 'ftp.yourdomain.com',
    'username': 'your-ftp-username',
    'password': 'your-ftp-password',
    'remote_path': '/public_html/wp-content/themes/'
}
```

3. Run secure deployment:
```bash
python3 deploy-secure.py
```

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

- Option 2 (secure deployment) keeps credentials separate
- Add `ftp_config.py` to `.gitignore` if using version control
- Never commit FTP passwords to repositories

## Alternative: SFTP/SSH
If your host supports SFTP, you can modify the script to use `paramiko` library for secure file transfer.