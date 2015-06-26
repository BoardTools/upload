<?php
/**
*
* @package Upload Extensions
* @copyright (c) 2014 - 2015 Igor Lavrov (https://github.com/LavIgor) and John Peskens (http://ForumHulp.com)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace boardtools\upload\includes;

/**
* The class of objects and global variables.
*/
class objects
{
	/** @var \phpbb\cache\service */
	public static $cache;

	/** @var \phpbb\config\config */
	public static $config;

	/** @var bool is_ajax - whether this is a request from JavaScript load_page() function */
	public static $is_ajax;

	/** @var \phpbb\log\log */
	public static $log;

	/** @var \phpbb\extension\metadata_manager $md_manager The metadata manager object of Upload Extensions. */
	public static $md_manager;

	/** @var string phpEx */
	public static $phpEx;

	/** @var object phpbb_container */
	public static $phpbb_container;

	/** @var \phpbb\extension\manager */
	public static $phpbb_extension_manager;

	/** @var string phpbb_link_template */
	public static $phpbb_link_template;

	/** @var string phpbb_root_path */
	public static $phpbb_root_path;

	/** @var \phpbb\request\request */
	public static $request;

	/** @var string self_update - the link to update Upload Extensions */
	public static $self_update;

	/** @var \phpbb\template\template */
	public static $template;

	/** @var string tpl_name */
	public static $tpl_name;

	/** @var string u_action */
	public static $u_action;

	/** @var string upload_ext_name - the name of Upload Extensions */
	public static $upload_ext_name;

	/** @var \phpbb\user */
	public static $user;

	/** @var string zip_dir - where to store zip files */
	public static $zip_dir;
}
