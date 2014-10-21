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
2. Check out the existing of the folder `/ext/boardtools/upload/` in the root of your board folder. Create folders if necessary.
3. Copy the contents of the downloaded `upload-master` folder to `/ext/boardtools/upload/`.
4. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions -> Upload Extensions`.
5. Click `Enable`.

## Usage
### Upload extensions
To upload extensions navigate in the ACP to `Customise -> Extension Management -> Upload extensions`.
Choose your extension zip file and click upload. The extension will unpack your file in the folder mentioned in composer.json. After that you can enable the uploaded extension in `Manage extensions` page (or simply click the link `Enable the uploaded extension`).

### Delete extensions
To delete extensions' folders from the server (to perform complete uninstallation) make sure that your extension is disabled and its data is deleted in `Manage extensions`.
Then navigate in the ACP to `Customise -> Extension Management -> Upload extensions`.
Choose the extension that you want to delete and click `Delete extension`.

## Update
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