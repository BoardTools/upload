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

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'ACP_UPLOAD_EXT_TITLE'				=> 'Upload Extensions',
	'ACP_UPLOAD_EXT_CONFIG_TITLE'		=> 'Upload extensions',
	'ACP_UPLOAD_EXT_DESCRIPTION'		=> 'Install/update/delete extensions, manage their ZIP files and more without using FTP.',
	'ACP_UPLOAD_EXT_TITLE_EXPLAIN'		=> 'Upload Extensions enables you to upload extensions’ zip files or delete extensions’ folders from the server.<br />With this extension you can install/update/delete extensions without using FTP. If the uploaded extension already exists, it will be updated with the uploaded files.',
	'ACP_UPLOAD_EXT_HELP'				=> 'Upload Extensions: Usage guide',
	'UPLOAD'							=> 'Upload',
	'BROWSE'							=> 'Browse...',
	'EXTENSION_UPLOAD'					=> 'Upload an extension',
	'EXTENSION_UPLOAD_EXPLAIN'			=> 'Here you can upload a zipped extension package containing the necessary files to perform installation from your local computer or a remote server. “Upload Extensions” will then attempt to unzip the file and have it ready for installation.<br />Choose a file or type a link in the fields below.',
	'EXT_UPLOAD_ERROR'					=> 'The extension wasn’t uploaded.',
	'EXT_UPLOAD_INIT_FAIL'				=> 'There was an error when initialising the extension upload process.',
	'EXT_NOT_WRITABLE'					=> array(
		'error'		=> 'The ext/ directory is not writable. This is required for “Upload Extensions” to work properly.',
		'solution'	=> 'Please adjust your permissions or settings and try again.',
	),
	'EXT_TMP_NOT_WRITABLE'				=> array(
		'error'		=> 'The ext/boardtools/upload/tmp/ directory is not writable. This is required for “Upload Extensions” to work properly.',
		'solution'	=> 'Please adjust your permissions or settings and try again.',
	),
	'EXT_ALLOW_URL_FOPEN_DISABLED'		=> array(
			'error'		=> 'The allow_url_fopen setting should be enabled in order to load information from a remote resource.',
			'solution'	=> 'Please confirm that the allow_url_fopen setting is enabled in your php.ini and try again.',
	),
	'EXT_OPENSSL_DISABLED'				=> array(
			'error'		=> 'The openssl extension should be enabled in order to load information from an https resource.',
			'solution'	=> 'Please confirm that the openssl extension is enabled in your php.ini and try again.',
	),
	'NO_UPLOAD_FILE'					=> array(
		'error'		=> 'No file specified or there was an error during the upload process.',
		'solution'	=> 'Please confirm that you upload the true extension zip file and try again.',
	),
	'NOT_AN_EXTENSION'					=> 'The uploaded zip file is not a phpBB extension. The file was not saved on the server.',
	'EXT_ACTION_ERROR'					=> 'The requested action cannot be performed for the selected phpBB extension.<br />Note: “Upload Extensions” can be managed only through the standard Extensions Manager.',

	'SOURCE'							=> 'Source',
	'EXTENSION_UPDATE_NO_LINK'			=> 'Download link is not provided.',
	'EXTENSION_TO_BE_ENABLED'			=> 'Upload Extensions will be disabled during the update process and enabled again after the update.',
	'EXTENSION_UPLOAD_UPDATE'			=> 'Update the extension',
	'EXTENSION_UPLOAD_UPDATE_EXPLAIN'	=> '“Upload Extensions” will perform the upload from the link shown below.',

	'EXTENSION_UPLOADED'				=> 'Extension “%s” was uploaded successfully.',
	'EXTENSIONS_AVAILABLE'				=> 'Uninstalled extensions',
	'EXTENSIONS_UPLOADED'				=> 'Uploaded extensions',
	'EXTENSIONS_UNAVAILABLE'			=> 'Broken extensions',
	'EXTENSIONS_UNAVAILABLE_EXPLAIN'	=> 'The extensions listed below are uploaded to your board but they are broken due to some reasons and that’s why they are unavailable and cannot be enabled on your board. Please check out the correct files and use Extension Cleaner tool if you want to delete the files of broken extensions from the server.',
	'EXTENSION_BROKEN'					=> 'Broken extension',
	'EXTENSION_BROKEN_ENABLED'			=> 'This broken extension is enabled!',
	'EXTENSION_BROKEN_DISABLED'			=> 'This broken extension is disabled!',
	'EXTENSION_BROKEN_TITLE'			=> 'This extension is broken!',
	'EXTENSION_BROKEN_DETAILS'			=> 'Click here to view the details.',
	'EXTENSION_BROKEN_EXPLAIN'			=> '<strong>Some data of this extension is still saved on the server.</strong> Please check out why this extension is broken. You may need to ask the extension developers for help and use FTP to change some files (or you can upload a version with fixes). Then you will be able to manage the extension again.<br /><h3>What you can do:</h3><br /><strong>Update the broken extension.</strong><br /><ul><li>Make sure that the extension is disabled (click on the toggle if needed).</li><li>Find out whether a new version of the extension is available. Try to upload it.</li><li>If the problem is not solved, you can ask the developers of the extension for help.</ul><strong>or</strong><br /><br /><strong>Remove the broken extension entirely.</strong><br /><ul><li>Make sure that the extension is disabled (click on the toggle if needed).</li><li>Make sure that the extension’s data is deleted (click on the trash bin button if needed).</li><li>Remove the files of the extension by using Extension Cleaner tool.</ul>',

	'EXTENSION_UPLOADED_ENABLE'			=> 'Enable the uploaded extension',
	'ACP_UPLOAD_EXT_UNPACK'				=> 'Unpack extension',
	'ACP_UPLOAD_EXT_CONT'				=> 'Content of the package “%s”',

	'EXT_LIST_DOWNLOAD'					=> 'Download full list',
	'EXT_LIST_DOWNLOAD_ENGLISH'			=> 'Use English status names',
	'EXT_LIST_DOWNLOAD_GROUP'			=> 'Group by',
	'EXT_LIST_DOWNLOAD_GROUP_STANDARD'	=> 'uploaded/broken',
	'EXT_LIST_DOWNLOAD_GROUP_DISABLED'	=> 'enabled/disabled/broken',
	'EXT_LIST_DOWNLOAD_GROUP_PURGED'	=> 'enabled/disabled/uninstalled/broken',
	'EXT_LIST_DOWNLOAD_SHOW'			=> 'Include names',
	'EXT_LIST_DOWNLOAD_SHOW_FULL'		=> 'display names and clean names',
	'EXT_LIST_DOWNLOAD_SHOW_CLEAN'		=> 'only clean names',
	'EXT_LIST_DOWNLOAD_SHOW_NAME'		=> 'only display names',
	'EXT_LIST_DOWNLOAD_TITLE'			=> 'Full list of uploaded extensions',
	'EXT_LIST_DOWNLOAD_FOOTER'			=> 'Generated by Upload Extensions',

	'EXT_ROW_ENABLED'					=> 'enabled',
	'EXT_ROW_DISABLED'					=> 'disabled',
	'EXT_ROW_UNINSTALLED'				=> 'uninstalled',
	'EXT_ROWS_ENABLED'					=> 'Enabled:',
	'EXT_ROWS_DISABLED'					=> 'Disabled:',
	'EXT_ROWS_UNINSTALLED'				=> 'Uninstalled:',
	'EXT_ROWS_UPLOADED'					=> 'Uploaded:',
	'EXT_ROWS_BROKEN'					=> 'Broken:',

	'EXTENSION_DELETE'					=> 'Delete extension',
	'EXTENSION_DELETE_CONFIRM'			=> 'Are you sure that you want to delete the “%s” extension?',
	'EXTENSIONS_DELETE_CONFIRM'			=> array(
		2	=> 'Are you sure that you want to delete <strong>%1$s</strong> extensions?',
	),
	'EXT_DELETE_SUCCESS'				=> 'Extension was deleted successfully.',
	'EXTS_DELETE_SUCCESS'				=> 'Extensions were deleted successfully.',
	'EXT_DELETE_ERROR'					=> 'No file specified or there was an error during the deletion.',
	'EXT_DELETE_NO_FILE'				=> 'No file was specified for the deletion.',
	'EXT_CANNOT_BE_PURGED'				=> 'The data of the enabled extension cannot be purged. Disable the extension to be able to purge its data.',

	'EXTENSION_ZIP_DELETE'				=> 'Delete zip file',
	'EXTENSION_ZIP_DELETE_CONFIRM'		=> 'Are you sure that you want to delete the zip file “%s”?',
	'EXTENSIONS_ZIP_DELETE_CONFIRM'		=> array(
		2	=> 'Are you sure that you want to delete <strong>%1$s</strong> zip files?',
	),
	'EXT_ZIP_DELETE_SUCCESS'			=> 'Extension’s zip file was deleted successfully.',
	'EXT_ZIPS_DELETE_SUCCESS'			=> 'Extensions’ zip files were deleted successfully.',
	'EXT_ZIP_DELETE_ERROR'				=> 'No file specified or there was an error during the deletion.',

	'ACP_UPLOAD_EXT_ERROR_DEST'			=> 'No vendor or destination folder in the uploaded zip file. The file was not saved on the server.',
	'ACP_UPLOAD_EXT_ERROR_COMP'			=> 'composer.json wasn’t found in the uploaded zip file. The file was not saved on the server.',
	'ACP_UPLOAD_EXT_ERROR_NOT_SAVED'	=> 'The file was not saved on the server.',
	'ACP_UPLOAD_EXT_ERROR_TRY_SELF'		=> '“Upload Extensions” can be updated only by the special Updater or through FTP.',
	'ACP_UPLOAD_EXT_WRONG_RESTORE'		=> 'An error occurred during the update of an installed extension. Try to update it again.',

	'DEVELOPER'							=> 'Developer',
	'DEVELOPERS'						=> 'Developers',

	'EXT_UPLOAD_SAVE_ZIP'				=> 'Save uploaded zip file',
	'CHECKSUM'							=> 'Checksum',
	'RESTORE'							=> 'Restore',
	'ZIP_UPLOADED'						=> 'Uploaded zip packages of extensions',
	'EXT_ENABLE'						=> 'Enable',
	'EXT_ENABLE_DISABLE'				=> 'Enable/Disable the extension',
	'EXT_ENABLED'						=> 'The extension was enabled successfully.',
	'EXT_DISABLED'						=> 'The extension was disabled successfully.',
	'EXT_PURGE'							=> 'Purge extension’s data',
	'EXT_PURGED'						=> 'The extension’s data was purged successfully.',
	'EXT_UPLOADED'						=> 'The upload was successful.',
	'EXT_UPDATE_ENABLE'					=> 'Click on the toggle to enable the extension.',
	'EXT_UPDATE_CHECK_FILETREE'			=> 'Please verify the file tree of the extension.',
	'EXT_UPDATE_ERROR'					=> 'The update process errored.',
	'EXT_UPDATE_TIMEOUT'				=> 'The update process timed out.',
	'EXT_UPDATES_AVAILABLE'				=> 'Updates are available',
	'EXT_UPDATE_METHODS_TITLE'			=> 'Available update methods',
	'EXT_UPLOAD_UPDATE_METHODS'			=> 'You can update the extension by taking one of the possible actions:<ul><li><strong>Updater method.</strong> Upload Extensions can be updated with Upload Extensions Updater. Check out whether this tool is already available. Unless you have this tool, you will need to use the second method.</li><li><strong>FTP method.</strong> Upload Extensions can be updated in a standard way. Download new files to your PC (click on the button below), disable the extension in standard Extensions Manager, copy new files using an FTP client and enable the extension in standard Extensions Manager.</li></ul>',
	'EXT_UPDATED'						=> 'The update was successful.',
	'EXT_UPDATED_LATEST_VERSION'		=> 'updated to the latest version',
	'EXT_SAVED_OLD_ZIP'					=> '<strong>NOTE:</strong> the previous version of the extension was saved in the file <strong>%s</strong> on your server. Check out “ZIP files management” module.',
	'EXT_RESTORE_LANGUAGE'				=> '<strong>One language directory is absent in the uploaded version of the extension.</strong> You can restore the directory %s from the saved zip archive of the previous version. Then you may need to update the files of that directory for compatibility with the uploaded version of the extension.',
	'EXT_RESTORE_LANGUAGES'				=> '<strong>Some language directories are absent in the uploaded version of the extension.</strong> You can restore the directories %1$s and %2$s from the saved zip archive of the previous version. Then you may need to update the files of those directories for compatibility with the uploaded version of the extension.',
	'EXT_LANGUAGES_RESTORED'			=> 'The restore process was completed successfully.',
	'EXT_SHOW_DESCRIPTION'				=> 'Show description of the extension',
	'EXT_UPLOAD_BACK'					=> '« Back to Upload Extensions',
	'EXT_RELOAD_PAGE'					=> 'Reload the page',
	'EXT_REFRESH_PAGE'					=> 'Refresh the page',
	'EXT_REFRESH_NOTICE'				=> 'Navigation menu can be outdated.',

	'ERROR_COPY_FILE'					=> 'The attempt to copy the file “%1$s” to the location “%2$s” failed.',
	'ERROR_CREATE_DIRECTORY'			=> 'The attempt to create the directory “%s” failed.',
	'ERROR_REMOVE_DIRECTORY'			=> 'The attempt to remove the directory “%s” failed.',
	'ERROR_CHECKSUM_MISMATCH'			=> 'The %s-hash of the uploaded file differs from the provided checksum. The file was not saved on the server.',
	'ERROR_ZIP_NO_COMPOSER'				=> 'composer.json was not found in the requested zip package.',
	'ERROR_DIRECTORIES_NOT_RESTORED'	=> 'The restore process could not be completed due to errors.',
	'ERROR_LANGUAGE_UNKNOWN_STRUCTURE'	=> 'The structure of the uploaded language package is unrecognised. The file was not saved on the server.',
	'ERROR_LANGUAGE_NO_EXTENSION'		=> 'The name of the extension is not specified for the language package.',
	'ERROR_LANGUAGE_NOT_DEFINED'		=> 'The ISO code of the language should be defined for the proper upload of the language package. Please fill in the required field of the form and try again.',

	'ACP_UPLOAD_EXT_DIR'				=> 'Extensions’ zip packages storage path',
	'ACP_UPLOAD_EXT_DIR_EXPLAIN'		=> 'Path under your phpBB root directory, e.g. <samp>ext</samp>.<br />You can change this path to store zip packages in a special folder (for example, if you want to let users download those files, you can change it to <em>downloads</em>, and if you want to prohibit those downloads, you can change it to the path that is upper by one level than http root of your website (or you can create a folder with the appropriate .htaccess file)).',

	'ACP_UPLOAD_EXT_UPDATED'			=> 'The installed extension was updated.',
	'ACP_UPLOAD_EXT_UPDATED_EXPLAIN'	=> 'You have uploaded a zip file for an already installed extension. That extension <strong>was disabled automatically</strong> to make the update process safer. Now please <strong>check</strong> whether the uploaded files are correct and <strong>enable</strong> the extension if it still should be used on the board.',

	'ACP_UPLOAD_EXT_NO_CHECKSUM_TITLE'	=> 'No checksum was provided for the uploaded file.',
	'ACP_UPLOAD_EXT_NO_CHECKSUM'		=> 'Upload Extensions was unable to perform security checks because the <strong>checksum was not provided</strong> for the uploaded zip file. Checksum is used to make sure that the uploaded file is not corrupted and not compromised.',

	'VALID_PHPBB_EXTENSIONS'			=> 'Validated extensions',
	'SHOW_VALID_PHPBB_EXTENSIONS'		=> 'Show validated extensions',
	'VALID_PHPBB_EXTENSIONS_TITLE'		=> 'You can download validated extensions from the CDB on phpbb.com or check out their homepages.',
	'VALID_PHPBB_EXTENSIONS_EMPTY_LIST'	=> 'No extensions are being suggested at the moment. Please check out the updates for Upload Extensions.',
	'POSSIBLE_SOLUTIONS'				=> 'Possible solutions',

	'ACP_UPLOAD_EXT_MANAGER_EXPLAIN'	=> 'The Extensions Manager of Upload Extensions is a tool in your phpBB Board that allows you to manage all of your extensions and view information about them.',
	'ACP_UPLOAD_ZIP_TITLE'				=> 'ZIP files management',
	'ACP_UPLOAD_UNINSTALLED_TITLE'		=> 'Delete extensions',

	'EXT_DETAILS_README'				=> 'Readme',
	'EXT_DETAILS_CHANGELOG'				=> 'Changelog',
	'EXT_DETAILS_LANGUAGES'				=> 'Languages',
	'EXT_DETAILS_FILETREE'				=> 'File tree',
	'EXT_DETAILS_TOOLS'					=> 'Tools',

	'DEFAULT'							=> 'default',
	'EXT_LANGUAGE_ISO_CODE'				=> 'ISO code',
	'EXT_LANGUAGES'						=> 'Uploaded language packages',
	'EXT_LANGUAGES_UPLOAD'				=> 'Upload a language package',
	'EXT_LANGUAGES_UPLOAD_EXPLAIN'		=> 'Here you can upload a zipped package containing the necessary language files for this extension from your local computer or a remote server. “Upload Extensions” will then attempt to unzip the files and move them to the right location.<br />Choose a file or type a link in the fields below.<br />Don’t forget to specify the language ISO code in the corresponding field below (example: <strong>en</strong>).<br /><strong>IMPORTANT!</strong> Your current extension’s language directory with that ISO code will be deleted if it exists, <strong>no zip archive will be made for it</strong>.',
	'EXT_LANGUAGE_UPLOADED'				=> 'The language package “%s” was uploaded successfully.',
	'EXT_LANGUAGE_DELETE_CONFIRM'		=> 'Are you sure that you want to delete the language package “%s”?',
	'EXT_LANGUAGES_DELETE_CONFIRM'		=> array(
		2	=> 'Are you sure that you want to delete <strong>%1$s</strong> language packages?',
	),
	'EXT_LANGUAGE_DELETE_SUCCESS'		=> 'Extension’s language package was deleted successfully.',
	'EXT_LANGUAGES_DELETE_SUCCESS'		=> 'Extension’s language packages were deleted successfully.',
	'EXT_LANGUAGE_DELETE_ERROR'			=> 'No file specified or there was an error during the deletion.',

	'EXT_TOOLS_DOWNLOAD_TITLE'			=> 'Download packaged extension',
	'EXT_TOOLS_DOWNLOAD'				=> 'You can download a properly packaged ZIP file of the extension to your PC. You can also choose to delete the suffix of the development version (e.g. to shorten the time for preparing the extension for the CDB).',
	'EXT_TOOLS_DOWNLOAD_DELETE_SUFFIX'	=> 'Delete the development suffix if it does exist',
	'EXT_DOWNLOAD_ERROR'				=> 'The attempt to download the extension “%s” failed.',

	'EXT_LOAD_ERROR'					=> 'Loading errored',
	'EXT_LOAD_TIMEOUT'					=> 'Loading timed out',
	'EXT_LOAD_ERROR_EXPLAIN'			=> 'An error occurred during the loading process.',
	'EXT_LOAD_ERROR_SHOW'				=> 'Show occurred errors',
	'EXT_LOAD_SOLUTIONS'				=> 'Please check out the error log files on your server, eliminate the problem and try again.',

	'UPLOAD_DESCRIPTION_UPLOAD'			=> 'Upload phpBB extensions',
	'UPLOAD_DESCRIPTION_UPLOAD_CDB'		=> 'CDB on phpbb.com',
	'UPLOAD_DESCRIPTION_UPLOAD_LOCAL'	=> 'Local PC',
	'UPLOAD_DESCRIPTION_UPLOAD_REMOTE'	=> 'Remote server',
	'UPLOAD_DESCRIPTION_UPDATE'			=> 'Update phpBB extensions',
	'UPLOAD_DESCRIPTION_UPDATE_ABOUT'	=> 'You can update any of already uploaded extensions. The extension that you want to update will be disabled automatically so that any updates will be safe.',
	'UPLOAD_DESCRIPTION_MANAGE'			=> 'Manage phpBB extensions',
	'UPLOAD_DESCRIPTION_MANAGE_ACTIONS'	=> 'Install/uninstall any extensions',
	'UPLOAD_DESCRIPTION_MANAGE_LANG'	=> 'Upload and manage extensions’ language packages',
	'UPLOAD_DESCRIPTION_MANAGE_DETAILS'	=> 'View the details and file trees',
	'UPLOAD_DESCRIPTION_DESIGN'			=> 'Interactive interface',
	'UPLOAD_DESCRIPTION_DESIGN_ABOUT'	=> 'You can perform actions more quickly because of JavaScript functionality. Colourful messages and tooltips will help you in making right decisions.',
	'UPLOAD_DESCRIPTION_ZIP'			=> 'ZIP files management',
	'UPLOAD_DESCRIPTION_ZIP_SAVE'		=> 'Save zips in a directory of your choice',
	'UPLOAD_DESCRIPTION_ZIP_UNPACK'		=> 'Unpack a zip file to install an extension',
	'UPLOAD_DESCRIPTION_ZIP_DOWNLOAD'	=> 'Download proper zip packages of extensions',
	'UPLOAD_DESCRIPTION_CLEANER'		=> 'Extension Cleaner tool',
	'UPLOAD_DESCRIPTION_CLEANER_ABOUT'	=> 'You can delete extension directories or zip files of extensions from the server.',
));
