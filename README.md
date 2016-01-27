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

## Language packages
Available language packages and the information about translations can be found here:
https://github.com/BoardTools/upload/wiki/Translations

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

### User-friendly interface
The brand new Ajax functionality and colourful design add new improvements to extension's features.
You do not need to refresh the page every time: if you want to return to the main page of Upload Extensions, simply click on its logo on the top of its pages.
You can also read the built-in FAQ if you click on the question mark button hidden behind the logo.
In some places useful tooltips can be found, they can help you in making the right decisions in extension management.
Most actions end with appearance of styled message boxes that tell you the result status.

Even if JavaScript is not enabled in your browser, the extension's features can still be accessed in a slightly different but still effective way.

### Upload extensions
To upload extensions navigate in the ACP to `Customise -> Extension Management -> Upload extensions`.
Choose your extension zip file and click the upload button. The extension will unpack your file in the folder mentioned in composer.json. After that you can enable the uploaded extension by clicking on a red toggle. Some tooltips will help you in this process.

#### Supported sources
You can upload extensions from different types of sources:

* Customisation database on phpbb.com: choose the extension in the special list and click `Upload`.
* Remote sources: you can also perform uploads from other resources, e.g. GitHub. The link from those resources (not from phpbb.com database) should end with `.zip`. Copy the download link of the extension that you want to install on your board and paste it into the text field in the form "Upload an extension".
* Local PC: simply click `Browse...` button in Upload Extensions and choose a file to upload.

**You can upload only `zip` formatted files of extensions.**

### Update extensions
You can update any of already installed extensions by uploading a zip file with the new version of the extension that you want to update.
Note: that extension will be disabled automatically. The previous version will be saved in a zip file.

If the link to the new version of the extension is provided by its developers in the version check file, then you can easily update the extension by clicking on the `Update` button that will appear if you click on a cogwheel near the version number on the extension details page.

**You need to revise the uploaded files and enable the updated extension again if you still want to use it on your board.**

### Extensions management
Now it is possible to do the standard actions with extensions faster than before.

You can perform the following actions using new Extensions Manager:

* Enable uploaded extensions: click on a red toggle; it will be grey during the process and it will turn green after the successful result.
* Disable installed extensions: click on a green toggle; it will be grey during the process and it will turn red after the successful result.
* Delete extensions' data: click on a trash bin button displayed near the red toggle; it will be grey during the process and it will disappear after the successful result.
* Check updates for the current versions of extensions: click `Re-Check all versions` link in Extensions Manager of Upload Extensions.
* View the full list of extensions sorted alphabetically (no matter if they are enabled or disabled): it is displayed in Extensions Manager of Upload Extensions.
* View the details of any uploaded extension: choose the extension in the list and click on its row.

The actions are performed faster because of the new Ajax functionality and improved design.

Upload Extensions broadens the list of possibilities and it has some other features:

* You can view Readme and Changelog files of extensions as well as look at their file trees.
* You can view installed language packages for extensions and delete them.
* You can upload new language packages for each of the uploaded extensions.
* You can disable broken extensions and purge their data.
* You can download proper zip packages of extensions (for example, to prepare them for the CDB on phpbb.com).

Those actions can be done on the details page of your chosen extension.

### Delete extensions
To delete extensions' folders from the server (to perform complete uninstallation) make sure that your extension is disabled and its data is deleted. The toggle of that extension should be red without trash bin button nearby.
Then navigate to Extension Cleaner tool: `Upload Extensions -> Delete extensions (button with a brush)`.
Choose the extension that you want to delete and click `Delete extension`.
If you want to delete several extensions at once, mark those extensions by ticking the flags and click `Delete marked` button.

### Managing zip files
You can do the following actions with zip files uploaded with Upload Extensions:

* Save them in the directory of your choice. To do that tick the flag `Save uploaded zip file` near the upload button.
* To change the directory for saving zip files of uploaded extensions navigate in the ACP to `General -> Server configuration -> Server settings -> Path settings -> Extensions' zip packages storage path`.
* Unpack previously saved zip files of extensions. The unpacked extension will be ready for installation immediately.
* Download saved zip files of extensions on your PC.
* Delete zip files of extensions. You can delete a single zip file or several zip files at once.

All uploaded zip files will contain the version numbers of the uploaded extensions.
If you have uploaded different zip files with the same name, they will be renamed properly so that they all will be saved.

## License
[GNU General Public License v2](http://opensource.org/licenses/GPL-2.0)

© 2014 - 2015 Igor Lavrov (https://github.com/LavIgor) and John Peskens (http://ForumHulp.com)