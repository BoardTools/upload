<?php
/**
*
* @package Upload Extensions
* @copyright (c) 2014 - 2015 Igor Lavrov (https://github.com/LavIgor) and John Peskens (http://ForumHulp.com)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

// Some characters you may want to copy&paste:
// ’ » “ ” …

$help = array(
	array(
		0 => '--',
		1 => 'General modules'
	),
	array(
		0 => 'What can I do with “Upload an extension” feature?',
		1 => 'You are able to upload extensions from different sources without the necessity of using an FTP client. When you upload an extension that already exists on your board, its old version will be automatically saved in the specified directory on your board - check out “ZIP files management” module. You can also save zip file of currently uploaded version of the extension - tick the flag “Save uploaded zip file” before the upload process. You can make sure that you upload the true extension’s zip package if you specify its checksum in the corresponding form field.'
	),
	array(
		0 => 'What is the difference between “Extensions Manager of Upload Extensions” and standard “Extensions Manager”?',
		1 => 'Just like standard “Extensions Manager”, “Extensions Manager of Upload Extensions” is a tool in your phpBB Board that allows you to manage all of your extensions and view information about them. But it can be determined as an “upgraded version” of the standard module.<br /><br /><strong>Key benefits:</strong><ul><li>All uploaded extensions are sorted alphabetically, no matter if they are enabled, disabled or uninstalled. The exception: broken extensions.</li><li>Broken extensions are shown separately on the same page of “Extensions Manager” below the list of normal extensions. The reasons of unavailability are shown for each broken extension. Detailed warning message is added to those reasons when broken extension is installed or has some data saved in your database. You can click on the row of any broken extension to see its details just in the same way that is applicable for other extensions.</li><li>Any extension (if it is not a broken one) can be enabled with a single click on the toggle shown on the left of its name in the list.</li></ul>'
	),
	array(
		0 => 'Why do I need “ZIP files management” module?',
		1 => 'Sometimes you can find it useful if you can save archives of your extensions or share them. The archives can be old versions of uploaded extensions (that are packaged automatically for data safety), any packages that you have chosen to save by ticking the flag “Save uploaded zip file” before an upload process or any zip files of extensions that are stored in the specified directory (see question “Where can I specify the directory for saving zip files of extensions?” below). You have possibilities to unpack, to download and to delete those packages.'
	),
	array(
		0 => 'How can I use “Delete extensions” module?',
		1 => '“Delete extensions” module lets you remove the files of uninstalled extensions from your server so that you can finish complete uninstallation without using FTP. When you do not need an extension anymore, you can remove it from your board completely. To do that you need to perform the following steps:<ul><li>At first ensure that you really do not need a specific extension. It is recommended that you make some backups of the files and database before any removals.</li><li>Then navigate to “Extensions Manager of Upload Extensions”, find the extension that you want to delete and make sure that it is disabled: click on the toggle of that extension <em>if the toggle is green</em>.</li><li>Make sure that extension’s data is deleted: <em>if the trash bin button of that extension is shown</em>, click on it and confirm your action.</li><li>After that navigate to “Delete extensions” module, click on the link “Delete extension” shown in the row of your extension and confirm your action.</li></ul>'
	),
	array(
		0 => '--',
		1 => 'Uploading process'
	),
	array(
		0 => 'How can I upload validated extensions from the CDB on phpbb.com?',
		1 => 'On the main page of Upload Extensions click on the link “Show validated extensions”. Select the extension that you want to upload and click on the “Download” button in the row of that extension. Note: wordplay here: the extension will be <em>downloaded</em> from the remote resource and <em>uploaded</em> to your server.'
	),
	array(
		0 => 'How can I perform an upload from other remote resources?',
		1 => 'Copy the <strong>direct</strong> link to the extension’s zip package (if the link is not from the phpbb.com website, it should end with <code>.zip</code>) into the dedicated field of the form “Upload an extension” and click the “Upload” button.'
	),
	array(
		0 => 'How can I upload an extension from my local PC?',
		1 => 'To do that click on the “Browse...” button in the form “Upload an extension”, select the extension’s zip file on your computer, then click the “Upload” button.'
	),
	array(
		0 => 'I have copied the link to the extension’s zip package into the field and clicked the “Upload” button, but I see an error. What’s wrong with the link?',
		1 => 'To be able to upload the extension you should make sure that the following conditions are met:<ol><li>The link should be <strong>direct</strong>: for uploads from resources other than phpbb.com it should have <code>.zip</code> at the end.</li><li>The link should lead to the <strong>zip file</strong> of the extension, not to its description page.</li></ol>'
	),
	array(
		0 => 'What is the checksum? Where can I take it?',
		1 => 'Checksum is used to verify the integrity of the uploaded file. It is checked to make sure that the file on the remote server and the file uploaded to your server are the same. Checksum can be usually obtained from the same resource where the original file is stored.'
	),
	array(
		0 => '--',
		1 => 'Extensions Manager of Upload Extensions'
	),
	array(
		0 => 'How to use “Extensions Manager of Upload Extensions”?',
		1 => 'The status of each extension is displayed as a toggle.<ul><li>A green toggle means that the extension is enabled. When you click on a green toggle the extension will be <strong>disabled</strong>.</li><li>A red toggle means that the extension is disabled. When you click on a red toggle the extension will be <strong>enabled</strong>.</li><li>If the extension that has a red toggle is disabled but there is some extension’s data saved in the database, then you will have an option to delete its data by clicking on a trash bin near the toggle.<br /><em>Clicking on a trash bin is a way to uninstall the extension from the database. If you want to delete the files of the extension from the server, you will need to use Extension Cleaner tool.</em></li></ul><br />You can also re-check all versions of the extensions by clicking on the corresponding button or set up version check settings just like in standard “Extensions Manager”.'
	),
	array(
		0 => 'What about broken extensions? Can I uninstall them?',
		1 => 'Yes, sure! Broken extensions are displayed in “Extensions Manager of Upload Extensions” below the list of normal extensions. You can see the reasons why those extensions are broken and whether they have some data saved in your database. Click on a row of a broken extension to see its details and to manage it.'
	),
	array(
		0 => 'The toggle button of an extension is grey. Why?',
		1 => 'The grey toggle button means that you cannot perform any actions with that extension at the moment. Probably another action is already in progress. Also Upload Extensions cannot disable itself - that is why its button is also grey.'
	),
	array(
		0 => '--',
		1 => 'Extension details page'
	),
	array(
		0 => 'What information is shown for my extensions?',
		1 => 'Displayed information depends on several circumstances.<ul><li>General description provided by extension developers in the <code>composer.json</code> file (or warning message if the extension is broken).</li><li>The version number of the extension (if it is not broken).</li><li>The contents of the <code>README.md</code> file (if it exists in the extension’s directory).</li><li>The contents of the <code>CHANGELOG.md</code> file (if it exists in the extension’s directory).</li><li>Uploaded language packages for the extension.</li><li>The file tree for the extension and contents of its files.</li></ul>'
	),
	array(
		0 => 'What can I do with the extension on the details page?',
		1 => 'You are able to:<ul><li>Enable the extension if its toggle is red.</li><li>Disable the extension if its toggle is green.</li><li>Delete extension’s data from the database if the red trash bin button is shown.</li><li>Check out the status of the current version of the extension if the link to the version check file is provided by extension developers. If extension’s version is shown in a green bubble - the extension is up-to-date. If the bubble is red - the extension is not up-to-date. Otherwise - the version check information could not be obtained.</li><li>Receive an update for the extension if you see a cogwheel near the extension’s version bubble. Click on the cogwheel: if an “Update” button is shown - then you can click on it, confirm your action and Upload Extensions will update your extension. You can also see the release announcement by clicking on the corresponding button if the link is provided by extension developers. <strong>NOTE:</strong> if JavaScript is disabled in your browser, those buttons will be located inside the extension details section block.</li><li>Manage extension’s language packages. You can upload a new language package for the extension - see question “What language packages can I upload for an extension?” below. You can also delete some already installed language packages.</li><li>Download the extension’s package (see question “What is the purpose of the feature “Download packaged extension”?” below).</li></ul>'
	),
	array(
		0 => 'What language packages can I upload for an extension?',
		1 => 'You can upload any zip packages that contain language files for the extension if those packages have one of the following structures:<ul><li><code>ZIP_FILE_ROOT/language_files</code>, or</li><li><code>ZIP_FILE_ROOT/single_directory/language_files</code>, or</li><li><code>ZIP_FILE_ROOT/single_directory/language_ISO_code/language_files</code>.</li></ul><br />For more information about the uploading process see section “Uploading process” above.'
	),
	array(
		0 => 'What is the purpose of the feature “Download packaged extension”?',
		1 => 'Upload Extensions lets you download proper zip packages of any uploaded extensions on your board to your local PC. You can also tick a flag to delete the suffix of the development version - this action can help you, for example, to shorten the time for preparing the extension for the CDB. Navigate to the extension details page and click on the “Tools” section button. Then the “Download” button will be shown.'
	),
	array(
		0 => '--',
		1 => 'ZIP files management'
	),
	array(
		0 => 'Where can I specify the directory for saving zip files of extensions?',
		1 => 'Navigate in the ACP to <code>General -> Server configuration -> Server settings -> Path settings -> Extensions’ zip packages storage path</code>.'
	),
	array(
		0 => 'How can I delete several extensions’ zip packages at once?',
		1 => 'At first make sure that you really need to perform such action; it is recommended that you have made necessary backups. Then navigate to “ZIP files management” module, tick the flags in the rows of zip packages that you want to delete, click on the “Delete marked” button and confirm your action.'
	),
	array(
		0 => '--',
		1 => 'Extension Cleaner tool'
	),
	array(
		0 => 'What is “Extension Cleaner tool”?',
		1 => '“Extension Cleaner tool” is the name of “Delete extensions” module of Upload Extensions sometimes used in its documentation.'
	),
	array(
		0 => 'An extension is installed on my board but I cannot delete it. Why?',
		1 => 'The extension that you want to remove should be disabled and its data should be deleted from the database before you use “Extension Cleaner tool”. See question “How can I use “Delete extensions” module?” above.'
	),
	array(
		0 => 'How can I delete several extensions at once?',
		1 => 'At first make sure that you really need to perform such action; it is recommended that you have made necessary backups. Then navigate to “Delete extensions” module, tick the flags in the rows of the extensions that you want to delete, click on the “Delete marked” button and confirm your action. <strong>Those extensions will not be saved as zip files! Their directories will be removed from the server entirely.</strong>'
	),
	array(
		0 => '--',
		1 => 'Interactive interface'
	),
	array(
		0 => 'What are the benefits of the JavaScript functionality?',
		1 => 'Pages are loaded faster, design elements are changed quickly when you interact with them, tooltips are shown to help you. All these features save your time and they are available only if JavaScript is enabled in your browser.'
	),
);
