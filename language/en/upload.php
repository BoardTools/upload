<?php
/**
*
* @package Upload Extensions
* @copyright (c) 2014 John Peskens (http://ForumHulp.com) and Igor Lavrov (https://github.com/LavIgor)
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
	'ACP_UPLOAD_EXT_TITLE_EXPLAIN'		=> 'Upload Extensions enables you to upload extensions\' zip files or delete extensions\' folders from the server.<br />With this extension you can install/update/delete extensions without using FTP. If the uploaded extension already exists, it will be updated with the uploaded files.',
	'UPLOAD'							=> 'Upload',
	'BROWSE'							=> 'Browse...',
	'EXTENSION_UPLOAD'					=> 'Upload extension',
	'EXTENSION_UPLOAD_EXPLAIN'			=> 'Here you can upload a zipped extension package containing the necessary files to perform installation from your local computer or a remote server. “Upload Extensions” will then attempt to unzip the file and have it ready for installation.<br />Choose a file or type a link in the fields below.',
	'EXT_UPLOAD_INIT_FAIL'				=> 'There was an error when initialising the extension upload process.',
	'EXT_NOT_WRITABLE'					=> 'The ext/ directory is not writable. This is required for “Upload extension” to work properly. Please adjust your permissions or settings and try again.',
	'EXT_UPLOAD_ERROR'					=> 'The extension wasn\'t uploaded. Please confirm that you upload the true extension zip file and try again.',
	'NO_UPLOAD_FILE'					=> 'No file specified or there was an error during the upload process.',
	'NOT_AN_EXTENSION'					=> 'The uploaded zip file is not a phpBB extension. The file was not saved on the server.',

	'EXTENSION_UPLOADED'				=> 'Extension “%s” was uploaded successfully.',
	'EXTENSIONS_AVAILABLE'				=> 'Available extensions',
	'EXTENSION_INVALID_LIST'			=> 'Extension list',
	'EXTENSION_UPLOADED_ENABLE'			=> 'Enable the uploaded extension',
	'ACP_UPLOAD_EXT_UNPACK'				=> 'Unpack extension',
	'ACP_UPLOAD_EXT_CONT'				=> 'Content of package: %s',

	'EXTENSION_DELETE'					=> 'Delete extension',
	'EXTENSION_DELETE_CONFIRM'			=> 'Are you sure that you want to delete the “%s” extension?',
	'EXT_DELETE_SUCCESS'				=> 'Extension was deleted successfully.',

	'EXTENSION_ZIP_DELETE'				=> 'Delete zip file',
	'EXTENSION_ZIP_DELETE_CONFIRM'		=> 'Are you sure that you want to delete the zip file “%s”?',
	'EXT_ZIP_DELETE_SUCCESS'			=> 'Extension\'s zip file was deleted successfully.',

	'ACP_UPLOAD_EXT_ERROR_DEST'			=> 'No vendor or destination folder in the uploaded zip file. The file was not saved on the server.',
	'ACP_UPLOAD_EXT_ERROR_COMP'			=> 'composer.json wasn\'t found in the uploaded zip file. The file was not saved on the server.',
	'ACP_UPLOAD_EXT_ERROR_NOT_SAVED'	=> 'The file was not saved on the server.',
	'ACP_UPLOAD_EXT_WRONG_RESTORE'		=> 'An error occurred during the update of an installed extension. Try to update it again.',

	'UPLOAD_EXTENSIONS_DEVELOPERS'		=> 'Developers',

	'SHOW_FILETREE'						=> '<< Show file tree >>',
	'HIDE_FILETREE'						=> '>> Hide file tree <<',

	'EXT_UPLOAD_SAVE_ZIP'				=> 'Save uploaded zip file',
	'ZIP_UPLOADED'						=> 'Uploaded zip packages of extensions',
	'EXT_ENABLE'						=> 'Enable',
	'EXT_UPLOADED'						=> 'uploaded',
	'EXT_UPDATED'						=> 'updated',
	'EXT_UPDATED_LATEST_VERSION'		=> 'updated to the latest version',
	'EXT_UPLOAD_BACK'					=> '« Back to Upload Extensions',

	'ACP_UPLOAD_EXT_DIR'				=> 'Extensions\' zip packages storage path',
	'ACP_UPLOAD_EXT_DIR_EXPLAIN'		=> 'Path under your phpBB root directory, e.g. <samp>ext</samp>.<br />You can change this path to store zip packages in a special folder (for example, if you want to let users download those files, you can change it to <em>downloads</em>, and if you want to prohibit those downloads, you can change it to the path that is upper by one level than http root of your website (or you can create a folder with the appropriate .htaccess file)).',

	'ACP_UPLOAD_EXT_UPDATED'			=> 'The installed extension was updated.',
	'ACP_UPLOAD_EXT_UPDATED_EXPLAIN'	=> 'You have uploaded a zip file for an already installed extension. That extension <strong>was disabled automatically</strong> to make the update process safer. Now please <strong>check</strong> whether the uploaded files are correct and <strong>enable</strong> the extension if it still should be used on the board.',
));
