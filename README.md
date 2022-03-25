# Verfacto Magento plugin

Verfacto plugin for Magento 2.3.2 - 2.3.7 versions

## Installation Guide
#### For Magento 2.X Verfacto Extensions

There are two possible solutions to install Magento 2.X Extension by Verfacto:

- Extension installation via GitHub
- Extension installation via ZIP upload

## 1. Installing via GitHub

1. Connect to the root directory of your Magento installation with SSH

2. Create a directory called `app/code/Verfacto/` in the root directory (use command *mkdir*)

3. Go to the created directory

4. Run command git clone <URL> with dot at the end, e.g., `git clone git@github.com:Verfacto/verfacto-magento-plugin-2.3.git .` to copy plugin inside the created directory

5. Run the following commands in the root Magento directory:
    * php bin/magento setup:upgrade
    * php bin/magento setup:di:compile
    * php bin/magento setup:static-content:deploy
    * php bin/magento cache:clean

## 2. Extension installation via ZIP upload

1. Unpack the extension ZIP file on your computer

2. Connect to your website source directory with FTP/SFTP/SSH client (we recommend clients: FileZilla, WinSCP)

3. Create a directory called `app/code/Verfacto/` in the root directory of your Magento installation

4. Upload all the files and folders to `app/code/Verfacto/`

5. Connect to the root directory of your Magento installation with SSH

6. Run the following commands, in the root Magento directory:
   * php bin/magento setup:upgrade
   * php bin/magento setup:di:compile
   * php bin/magento setup:static-content:deploy
   * php bin/magento cache:clean

## 3. Uninstall Plugin

1. Connect to the root directory of your Magento installation with SSH

2. Run the following commands in the root Magento directory:
    * php bin/magento module:disable Verfacto_Magento
    * php bin/magento setup:upgrade
    * php bin/magento setup:di:compile
    * php bin/magento setup:static-content:deploy
    * php bin/magento cache:clean