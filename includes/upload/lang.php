<?php
/**
*
* @package Upload Extensions
* @copyright (c) 2014 - 2016 Igor Lavrov (https://github.com/LavIgor) and John Peskens (http://ForumHulp.com)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace boardtools\upload\includes\upload;

use \boardtools\upload\includes\objects;
use \boardtools\upload\includes\functions\files;

class lang extends base
{
	/**
	 * The function that uploads the specified language package for the extension.
	 *
	 * @param string $action    Requested action.
	 * @param string $ext_name  The name of the extension.
	 * @param string $lang_name The ISO code of the language.
	 * @return bool
	 */
	public function upload($action, $ext_name, $lang_name)
	{
		global $phpbb_root_path, $phpEx, $user;

		if (empty($ext_name))
		{
			files::catch_errors(objects::$user->lang('ERROR_LANGUAGE_NO_EXTENSION'));
			return false;
		}

		if (empty($lang_name))
		{
			files::catch_errors(objects::$user->lang('ERROR_LANGUAGE_NOT_DEFINED'));
			return false;
		}

		$file = $this->proceed_upload($action);
		if (!$file)
		{
			return false;
		}

		$dest_file = $this->get_dest_file($action, $file, objects::$zip_dir);
		if (!$dest_file)
		{
			return false;
		}
		// We need to use the user ID and the time to escape from problems with simultaneous uploads.
		// We suppose that one user can upload only one extension per session.
		$ext_tmp = $phpbb_root_path . 'ext/' . objects::$upload_ext_name . '/tmp/' . (int) $user->data['user_id'];
		// Ensure that we don't have any previous files in the working directory.
		if (is_dir($ext_tmp))
		{
			if (!(files::catch_errors(files::rrmdir($ext_tmp))))
			{
				if ($action != 'upload_local')
				{
					$file->remove();
				}
				return false;
			}
		}

		if (!class_exists('\compress_zip'))
		{
			include($phpbb_root_path . 'includes/functions_compress.' . $phpEx);
		}

		$zip = new \compress_zip('r', $dest_file);
		$zip->extract($ext_tmp . '/');
		$zip->close();

		if ($action != 'upload_local')
		{
			$file->remove();
		}

		// The files can be stored inside the $ext_tmp directory or up to two levels lower in the file tree.
		$lang_dir = '';
		// First level (the highest one).
		$files = @scandir($ext_tmp);
		if ($files === false)
		{
			files::catch_errors(objects::$user->lang('ERROR_LANGUAGE_UNKNOWN_STRUCTURE'));
			return false;
		}
		$files = array_diff($files, array('.', '..'));
		$last_file = array_pop($files);
		// Continue searching if we have a single directory.
		if (!sizeof($files) && !is_null($last_file) && @is_dir($ext_tmp . $lang_dir . '/' . $last_file))
		{
			$lang_dir .= '/' . $last_file;
			// Second level.
			$files = @scandir($ext_tmp . $lang_dir);
			if ($files === false)
			{
				files::catch_errors(objects::$user->lang('ERROR_LANGUAGE_UNKNOWN_STRUCTURE'));
				return false;
			}
			$files = array_diff($files, array('.', '..'));
			// Search for a directory with language ISO code (to escape from problems with unnecessary readme files).
			if (array_search($lang_name, $files) !== false && @is_dir($ext_tmp . $lang_dir . '/' . $lang_name))
			{
				$lang_dir .= '/' . $lang_name;
			}
		}
		$source = $ext_tmp . $lang_dir;
		if (!(files::catch_errors(files::rcopy($source, $phpbb_root_path . 'ext/' . $ext_name . '/language/' . $lang_name))))
		{
			files::catch_errors(files::rrmdir($ext_tmp));
			return false;
		}
		if (!(files::catch_errors(files::rrmdir($ext_tmp))))
		{
			return false;
		}
		if (objects::$is_ajax && $ext_name === objects::$upload_ext_name && $lang_name === objects::$user->lang_name)
		{
			/*
			 * Refresh the page if the uploaded language package
			 * is currently used by the user of Upload Extensions.
			 * Only for Ajax requests.
			 */
			$response_object = new \phpbb\json_response;
			$response_object->send(array(
				"LANGUAGE" => urlencode($lang_name),
				"REFRESH"  => true
			));
		}
		objects::$template->assign_var('EXT_LANGUAGE_UPLOADED', objects::$user->lang('EXT_LANGUAGE_UPLOADED', $lang_name));
		return true;
	}
}
