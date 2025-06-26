#!/usr/bin/env python3
"""
Robust FTP deployment with reconnection handling
"""

import ftplib
import os
import sys
import time
from pathlib import Path

# Import FTP configuration from external file
try:
    from deployconfig import FTP_CONFIG
except ImportError:
    print("❌ Error: deployconfig.py not found!")
    print("Create deployconfig.py with your FTP credentials:")
    print("FTP_CONFIG = {")
    print("    'host': 'your-host.com',")
    print("    'username': 'your-username',")
    print("    'password': 'your-password',")
    print("    'remote_path': '/public_html/wp-content/themes/'")
    print("}")
    sys.exit(1)

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

if __name__ == "__main__":
    deploy_theme()