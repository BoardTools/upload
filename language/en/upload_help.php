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
	'UPLOAD_DESCRIPTION_UPLOAD'			=> 'Upload phpBB extensions',
	'UPLOAD_DESCRIPTION_UPLOAD_CDB'		=> 'CDB on phpbb.com',
	'UPLOAD_DESCRIPTION_UPLOAD_LOCAL'	=> 'Local PC',
	'UPLOAD_DESCRIPTION_UPLOAD_REMOTE'	=> 'Remote server',
	'UPLOAD_DESCRIPTION_UPDATE'			=> 'Update phpBB extensions',
	'UPLOAD_DESCRIPTION_UPDATE_ABOUT'	=> 'You can update any of already uploaded extensions. The extension that you want to update will be disabled automatically so that any updates will be safe.',
	'UPLOAD_DESCRIPTION_ZIP'			=> 'ZIP files management',
	'UPLOAD_DESCRIPTION_ZIP_SAVE'		=> 'Save zips in a directory of your choice',
	'UPLOAD_DESCRIPTION_ZIP_UNPACK'		=> 'Unpack a zip file to install an extension',
	'UPLOAD_DESCRIPTION_CLEANER'		=> 'Extension Cleaner tool',
	'UPLOAD_DESCRIPTION_CLEANER_ABOUT'	=> 'You can delete extension directories or zip files of extensions from the server.',

	'ACP_UPLOAD_EXT_HELP'				=> 'Usage guide',
	'ACP_UPLOAD_EXT_MANAGER'			=> 'Extensions Manager',
	'ACP_UPLOAD_EXT_MANAGER_ABOUT'		=> 'The Extensions Manager of Upload Extensions is a tool in your phpBB Board that allows you to manage all of your extensions and view information about them.<br /><br /><strong>How to use the Extensions Manager of Upload Extensions</strong><br />The status of each extension is displayed as a toggle. A green toggle means that the extension is enabled. When you click on a green toggle the extension will be <strong>disabled</strong>. A red toggle means that the extension is disabled. When you click on a red toggle the extension will be <strong>enabled</strong>. If the extension that has a red toggle is disabled but there is some extension’s data saved on the server, then you will have an option to delete its data by clicking on a trash bin near the toggle.<br /><em>Clicking on a trash bin is a way to uninstall the extension from the database on the server. If you want to delete the files of the extension from the server, you will need to use the Extension Cleaner tool.</em>',
));
