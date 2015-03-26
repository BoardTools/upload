Upload Extensions
=================
Upload Extensions enables you to upload extensions' zip files or delete extensions' folders from the server.
With this extension you can install/update/delete extensions without using FTP. If the uploaded extension already exists, it will be updated with the uploaded files.

[![Build Status](https://travis-ci.org/BoardTools/upload.svg?branch=master)](https://travis-ci.org/BoardTools/upload)

## Requirements
* phpBB 3.1.0 or higher
* PHP 5.3.3 or higher

## Installation
You can install this extension on the latest version of [phpBB 3.1](https://www.phpbb.com/downloads/) or on the latest development version of [phpBB 3.1-dev](https://github.com/phpbb/phpbb3) by doing the following:

1. Download the extension. You can do it [directly from phpbb.com](https://www.phpbb.com/customise/db/extension/upload/) or by downloading the [latest ZIP-archive of `master` branch of its GitHub repository](https://github.com/BoardTools/upload/archive/master.zip).
2. Check out the existence of the folder `/ext/boardtools/upload/` in the root of your board folder. Create folders if necessary.
3. Copy the contents of the downloaded `upload-master` folder to `/ext/boardtools/upload/`.
4. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions -> Upload Extensions`.
5. Click `Enable`.

## Usage
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

## Update
### Quick update
1. Navigate in the ACP to `Customise -> Extension Management -> Upload extensions`.
2. When an update is available, you will see an update button on the page.
3. Click on it and also click on other `Update` buttons that will appear on the screen. And the extension will be updated!

### Standard update
1. Download the updated extension. You can do it [directly from phpbb.com](https://www.phpbb.com/customise/db/extension/upload/) or by downloading the [latest ZIP-archive of `master` branch of its GitHub repository](https://github.com/BoardTools/upload/archive/master.zip).
2. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions -> Upload Extensions` and click `Disable`.
3. Copy the contents of the downloaded `upload-master` folder to `/ext/boardtools/upload/`.
4. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions -> Upload Extensions` and click `Enable`.
5. Click `Details` or `Re-Check all versions` link to follow updates.

## Uninstallation
Navigate in the ACP to `Customise -> Extension Management -> Manage extensions -> Upload Extensions` and click `Disable`.

For permanent uninstallation click `Delete Data` and then you can safely delete the `/ext/boardtools/upload/` folder.

## License
[GNU General Public License v2](http://opensource.org/licenses/GPL-2.0)

© 2014 - John Peskens (http://ForumHulp.com) and Igor Lavrov (https://github.com/LavIgor)