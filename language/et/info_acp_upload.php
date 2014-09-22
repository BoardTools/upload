<?php
/**
* info_acp_upload.php [Estonian]
* @package Upload Extensions
* @copyright (c) 2014 John Peskens (http://ForumHulp.com) and Igor Lavrov (https://github.com/LavIgor)
* @copyright (c) 2014 Upload Extensions Estonian language pack version 0.1 by http://www.phpbbeesti.com/
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
	'ACP_UPLOAD_EXT_TITLE'				=> 'Lae üles laiendusi',
	'ACP_UPLOAD_EXT_CONFIG_TITLE'		=> 'Lae üles laiendusi',
));
