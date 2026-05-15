#!/usr/bin/env python3
"""
Robust FTP deployment with reconnection handling.

Supports local `deployconfig.py` usage and `FTP_*` environment variables for CI.
"""

import ftplib
import os
import sys
import time
from pathlib import Path

REQUIRED_FTP_KEYS = ('host', 'username', 'password', 'remote_path')


def load_ftp_config():
    """Load FTP config from environment variables or local deployconfig.py."""
    env_config = {
        'host': os.getenv('FTP_HOST'),
        'username': os.getenv('FTP_USERNAME') or os.getenv('FTP_USER'),
        'password': os.getenv('FTP_PASSWORD'),
        'remote_path': os.getenv('FTP_REMOTE_PATH'),
    }

    file_config = {}
    try:
        from deployconfig import FTP_CONFIG as file_ftp_config
        if isinstance(file_ftp_config, dict):
            file_config = file_ftp_config.copy()
    except ImportError:
        pass

    ftp_config = file_config.copy()
    for key, value in env_config.items():
        if value:
            ftp_config[key] = value

    missing_keys = [key for key in REQUIRED_FTP_KEYS if not ftp_config.get(key)]
    if missing_keys:
        print('❌ Error: FTP deployment configuration is incomplete!')
        print('Set these environment variables or create deployconfig.py:')
        print('  FTP_HOST')
        print('  FTP_USERNAME')
        print('  FTP_PASSWORD')
        print('  FTP_REMOTE_PATH')
        print(f"Missing: {', '.join(missing_keys)}")
        print('\nExample deployconfig.py:')
        print('FTP_CONFIG = {')
        print("    'host': 'your-host.com',")
        print("    'username': 'your-username',")
        print("    'password': 'your-password',")
        print("    'remote_path': '/public_html/wp-content/themes/'")
        print('}')
        sys.exit(1)

    return ftp_config


FTP_CONFIG = load_ftp_config()

def connect_ftp():
    """Create FTP connection with retry"""
    for attempt in range(3):
        try:
            ftp = ftplib.FTP(FTP_CONFIG['host'])
            ftp.login(FTP_CONFIG['username'], FTP_CONFIG['password'])
            ftp.cwd(FTP_CONFIG['remote_path'])
            return ftp
        except Exception as e:
            print(f"Connection attempt {attempt + 1} failed: {e}")
            if attempt < 2:
                time.sleep(2)
            else:
                raise

def upload_file_with_retry(ftp, local_file, remote_file, max_retries=3):
    """Upload a single file with retry logic"""
    for attempt in range(max_retries):
        try:
            with open(local_file, 'rb') as file:
                ftp.storbinary(f'STOR {remote_file}', file)
            return True
        except (ftplib.error_temp, BrokenPipeError, ConnectionResetError) as e:
            print(f"Upload attempt {attempt + 1} failed for {os.path.basename(local_file)}: {e}")
            if attempt < max_retries - 1:
                # Reconnect and try again
                try:
                    ftp.quit()
                except:
                    pass
                ftp = connect_ftp()
                time.sleep(1)
            else:
                print(f"❌ Failed to upload {os.path.basename(local_file)} after {max_retries} attempts")
                return False
    return False

def upload_directory(ftp, local_path, remote_path):
    """Upload directory with robust error handling"""
    local_path = Path(local_path)
    
    for item in local_path.iterdir():
        local_file = str(item)
        remote_file = f"{remote_path}/{item.name}"
        
        if item.is_file():
            print(f"Uploading {item.name}...")
            if upload_file_with_retry(ftp, local_file, remote_file):
                print(f"✅ {item.name}")
            else:
                print(f"❌ {item.name}")
        
        elif item.is_dir():
            print(f"Creating directory: {item.name}")
            try:
                ftp.mkd(remote_file)
            except ftplib.error_perm:
                pass  # Directory might exist
            
            upload_directory(ftp, local_file, remote_file)

def deploy_theme():
    """Main deployment with robust error handling"""
    print("🚀 Simple Dental Theme - Robust Deployment")
    print("=" * 50)
    
    if not os.path.exists('simple-dental-theme'):
        print("❌ Theme directory not found!")
        sys.exit(1)
    
    try:
        # Connect to FTP
        print(f"📡 Connecting to {FTP_CONFIG['host']}...")
        ftp = connect_ftp()
        print("✅ Connected!")
        print(f"📁 In: {FTP_CONFIG['remote_path']}")
        
        # Remove existing theme safely
        try:
            print("🗑️  Checking for existing theme...")
            ftp.cwd('simple-dental-theme')
            ftp.cwd('..')
            print("🗑️  Removing existing theme...")
            remove_directory_safe(ftp, 'simple-dental-theme')
            print("✅ Existing theme removed")
        except ftplib.error_perm:
            print("📁 No existing theme found")
        
        # Create new theme directory
        print("📁 Creating theme directory...")
        try:
            ftp.mkd('simple-dental-theme')
        except ftplib.error_perm:
            pass
        
        # Upload theme files
        print("📤 Uploading theme files...")
        upload_directory(ftp, 'simple-dental-theme', 'simple-dental-theme')
        
        try:
            ftp.quit()
        except:
            pass
        
        print("\n🎉 Deployment completed!")
        print("✅ Theme uploaded successfully")
        print("\nNext steps:")
        print("1. Check your website - homepage should now display correctly")
        print("2. The front-page.php template will handle the homepage layout")
        
    except Exception as e:
        print(f"❌ Error: {e}")

def remove_directory_safe(ftp, path):
    """Safely remove directory"""
    try:
        file_list = []
        ftp.retrlines(f'LIST {path}', file_list.append)
        
        for line in file_list:
            parts = line.split()
            if len(parts) >= 9:
                filename = ' '.join(parts[8:])
                if filename in ['.', '..']:
                    continue
                filepath = f"{path}/{filename}"
                
                if line.startswith('d'):
                    remove_directory_safe(ftp, filepath)
                else:
                    try:
                        ftp.delete(filepath)
                    except:
                        pass
        
        ftp.rmd(path)
    except:
        pass

def deploy_file(filename):
    """Deploy a single file to the remote theme directory"""
    theme_dir = 'simple-dental-theme'
    local_path = os.path.join(theme_dir, filename)
    if not os.path.isfile(local_path):
        print(f"❌ File not found: {local_path}")
        sys.exit(1)
    print(f"🚀 Deploying single file: {filename}")
    try:
        print(f"📡 Connecting to {FTP_CONFIG['host']}...")
        ftp = connect_ftp()
        print("✅ Connected!")
        print(f"📁 In: {FTP_CONFIG['remote_path']}")
        # Ensure remote theme directory exists and change into it
        try:
            ftp.cwd('simple-dental-theme')
        except ftplib.error_perm:
            print("📁 Creating theme directory...")
            ftp.mkd('simple-dental-theme')
            ftp.cwd('simple-dental-theme')
        # Upload the file (just the filename, not with the theme dir prefix)
        remote_file = filename
        if upload_file_with_retry(ftp, local_path, remote_file):
            print(f"✅ Uploaded {filename}")
        else:
            print(f"❌ Failed to upload {filename}")
        try:
            ftp.quit()
        except:
            pass
        print("🎉 File deployment completed!")
    except Exception as e:
        print(f"❌ Error: {e}")

if __name__ == "__main__":
    if len(sys.argv) == 2:
        deploy_file(sys.argv[1])
    else:
        deploy_theme()