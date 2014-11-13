<?php
/**
*
* @package Upload Extensions
* Persian Translator: Meisam nobari in www.php-bb.ir
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
	'ACP_UPLOAD_EXT_TITLE'				=> 'آپلود افزونه',
	'ACP_UPLOAD_EXT_CONFIG_TITLE'		=> 'آپلود افزونه',
));
