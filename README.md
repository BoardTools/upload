Upload Extensions
=================
Upload Extensions enables you to upload extensions' zip files or delete extensions' folders from the server.
With this extension you can install/update/delete extensions without using FTP. If the uploaded extension already exists, it will be updated with the uploaded files.

[![Build Status](https://travis-ci.org/BoardTools/upload.svg?branch=master)](https://travis-ci.org/BoardTools/upload)

## Requirements
* phpBB 3.1.0 or higher
* PHP 5.3.3 or higher

## Sources
You can get Upload Extensions from one of the following sources:
* phpbb.com: https://www.phpbb.com/customise/db/extension/upload/
* github.com: https://github.com/BoardTools/upload

The support from the authors is given only for the packages uploaded from the sources listed above.

## Website
Find the information about Upload Extensions and its features on the special website:
http://boardtools.github.io/upload/

## Installation, update, uninstallation
The information about the installation/update/uninstallation process can be found in FAQ and Wiki:
* For the packages uploaded from phpbb.com: https://www.phpbb.com/customise/db/extension/upload/faq.
* For the packages uploaded from github.com: https://github.com/BoardTools/upload/wiki.

### General installation information (for the case if you don't have access to the resources listed above)
In general you'll need to copy the contents of the uploaded zip package to `ext/boardtools/upload`.
As a result the path to the `composer.json` file should become `ext/boardtools/upload/composer.json`.
Then navigate in the ACP to `Customise -> Extension Management -> Manage extensions -> Upload Extensions` and click `Enable`.

### General information about standard updates
To update Upload Extensions in standard way navigate in the ACP to `Customise -> Extension Management -> Manage extensions -> Upload Extensions` and click `Disable`.
Then you can install the updated version of the extension.

### General uninstallation information
Navigate in the ACP to `Customise -> Extension Management -> Manage extensions -> Upload Extensions` and click `Disable`.
For permanent uninstallation click also `Delete data` and then you can safely remove the `ext/boardtools/upload` folder.

## Usage

Information about usage of the new features (such as built-in Extensions Manager) will be added soon.

### Upload extensions
To upload extensions navigate in the ACP to `Customise -> Extension Management -> Upload extensions`.
Choose your extension zip file and click upload. The extension will unpack your file in the folder mentioned in composer.json. After that you can enable the uploaded extension in `Manage extensions` page (or simply click the link `Enable the uploaded extension`).

#### Supported sources
You can upload extensions from different types of sources:

* Customisation database on phpbb.com: copy the download link of the extension that you want to install on your board and paste it into the upload extension field in Upload Extensions.
* Remote sources: you can do the same action for links on other resources, e.g. GitHub. The link from those resources (not from phpbb.com database) should end with `.zip`.
* Local PC: simply click `Browse...` button in Upload Extensions and choose a file to upload.

**You can upload only `zip` formatted files of extensions.**

### Update extensions
You can update any of already installed extensions by uploading a zip file with the new version of the extension that you want to update.
Note: that extension will be disabled automatically. The previous version will be saved in a zip file.

**You need to revise the uploaded files and manually enable the updated extension if you still want to use it on your board.**

### Delete extensions
To delete extensions' folders from the server (to perform complete uninstallation) make sure that your extension is disabled and its data is deleted in `Manage extensions`.
Then navigate in the ACP to `Customise -> Extension Management -> Upload extensions`.
Choose the extension that you want to delete and click `Delete extension`.

### Managing zip files
You can do the following actions with zip files uploaded with Upload Extensions:

* Save them in the directory of your choise. To do that tick the flag `Save uploaded zip file` near the upload button.
* To change the directory for saving zip files of uploaded extensions navigate in the ACP to `General -> Server configuration -> Server settings -> Path settings -> Extensions' zip packages storage path`.
* Unpack previously saved zip files of extensions. The unpacked extension will be ready for installation immediately.
* Download saved zip files of extensions on your PC.
* Delete zip files of extensions.

All uploaded zip files will contain the version numbers of the uploaded extensions.
If you have uploaded different zip files with the same name, they will be renamed properly so that they all will be saved.

## License
[GNU General Public License v2](http://opensource.org/licenses/GPL-2.0)

© 2014 - 2015 John Peskens (http://ForumHulp.com) and Igor Lavrov (https://github.com/LavIgor)