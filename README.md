Upload Extensions
=================

Upload Extensions enables you to upload extensions' zip files or delete extensions' folders from the server.
With this extension you can install/update/delete extensions without using FTP. If the uploaded extension already exists, it will be updated with the uploaded files.

## Requirements
* phpBB 3.1.0-dev or higher
* PHP 5.3.3 or higher

## Installation
You can install this extension on the latest copy of the develop branch ([phpBB 3.1-dev](https://github.com/phpbb/phpbb3)) by doing the following:

1. Copy the [entire contents of this repo](https://github.com/BoardTools/upload/archive/master.zip) to `FORUM_DIRECTORY/ext/boardtools/upload/`.
2. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions`.
3. Click Upload Extensions => `Enable`.

Note: This extension is in development. Installation is only recommended for testing purposes and is not supported on live boards. This extension will be officially released following phpBB 3.1.0.

## Usage
### Upload extensions
To upload extensions navigate in the ACP to `Customise -> Extension Management -> Upload extensions`.
Choose your extension zip file and click upload. The extension will unpack your file in the folder mentioned in composer.json. After that you can enable the uploaded extension in `Manage extensions` page (or simply click the link `Enable the uploaded extension`).

### Delete extensions
To delete extensions' folders from the server (to perform complete uninstallation) make sure that your extension is disabled and its data is deleted in `Manage extensions`.
Then navigate in the ACP to `Customise -> Extension Management -> Upload extensions`.
Choose the extension that you want to delete and click `Delete extension`.

## Update
1. Download the [latest ZIP-archive of `master` branch of this repository](https://github.com/BoardTools/upload/archive/master.zip).
2. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click Upload Extensions => `Disable`.
3. Copy the contents of `upload-master` folder to `FORUM_DIRECTORY/ext/boardtools/upload/`.
4. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click Upload Extensions => `Enable`.
5. Click `Details` or `Re-Check all versions` link to follow updates.

## Uninstallation
Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click Upload Extensions => `Disable`.

To permanently uninstall, click `Delete Data` and then you can safely delete the `/ext/boardtools/upload/` folder.

## License
[GNU General Public License v2](http://opensource.org/licenses/GPL-2.0)

© 2014 - John Peskens (http://ForumHulp.com) and Igor Lavrov (https://github.com/LavIgor)