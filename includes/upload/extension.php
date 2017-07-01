<?php
/**
*
* @package Upload Extensions
* @copyright (c) 2014 - 2017 Igor Lavrov (https://github.com/LavIgor) and John Peskens (http://ForumHulp.com)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace boardtools\upload\includes\upload;

use \boardtools\upload\includes\objects;
use \boardtools\upload\includes\functions\files;
use \boardtools\upload\includes\functions\load;

class extension extends base
{
	/** @var string Extension destination path (vendor/name) */
	protected $destination;

	/** @var string Extension temporary source path */
	protected $source;

	/**
	 * The function that uploads the specified extension.
	 *
	 * @param string $action Requested action.
	 * @return bool
	 */
	public function upload($action)
	{
		$file = $this->proceed_upload($action);
		if (!$file && $action != 'upload_local')
		{
			files::catch_errors(objects::$user->lang['EXT_UPLOAD_ERROR']);
			return false;
		}

		// What is a safe limit of execution time? Half the max execution time should be safe.
		$safe_time_limit = (ini_get('max_execution_time') / 2);
		$start_time = time();
		// We skip working with a zip file if we are enabling/restarting the extension.
		if ($action != 'force_update')
		{
			$dest_file = $this->get_dest_file($action, $file, objects::$zip_dir);
			if (!$dest_file)
			{
				files::catch_errors(objects::$user->lang['EXT_UPLOAD_ERROR']);
				return false;
			}

			if (!$this->set_temp_path())
			{
				if ($action != 'upload_local')
				{
					$file->remove();
				}
				return false;
			}

			$this->extract_zip($dest_file);

			$composery = files::getComposer($this->ext_tmp);
			if (!$composery)
			{
				files::catch_errors(files::rrmdir($this->ext_tmp));
				if ($action != 'upload_local')
				{
					$file->remove();
				}
				files::catch_errors(objects::$user->lang['ACP_UPLOAD_EXT_ERROR_COMP']);
				return false;
			}
			$string = @file_get_contents($composery);
			if ($string === false)
			{
				files::catch_errors(files::rrmdir($this->ext_tmp));
				if ($action != 'upload_local')
				{
					$file->remove();
				}
				files::catch_errors(objects::$user->lang['EXT_UPLOAD_ERROR']);
				return false;
			}
			$json_a = json_decode($string, true);
			$destination = (isset($json_a['name'])) ? $json_a['name'] : '';
			$destination = str_replace('.', '', $destination);
			$ext_version = (isset($json_a['version'])) ? $json_a['version'] : '0.0.0';

			if (!$this->check_ext_name($destination))
			{
				if ($action != 'upload_local')
				{
					$file->remove();
				}
				return false;
			}

			$display_name = (isset($json_a['extra']['display-name'])) ? $json_a['extra']['display-name'] : $destination;
			if (!isset($json_a['type']) || $json_a['type'] != "phpbb-extension")
			{
				files::catch_errors(files::rrmdir($this->ext_tmp));
				if ($action != 'upload_local')
				{
					$file->remove();
				}
				files::catch_errors(objects::$user->lang['NOT_AN_EXTENSION']);
				return false;
			}
			$source = substr($composery, 0, -14);

			// Try to use the extracted path if it contains the necessary directory structure.
			$source_for_check = $this->get_temp_path(true) . '/extracted/' . $destination;

			// At first we need to change the directory structure to something like ext/tmp/vendor/extension.
			// We need it to escape from problems with dots on validation.
			if ($source != objects::$phpbb_root_path . 'ext/' . $source_for_check)
			{
				$source_for_check = $this->get_temp_path(true) . '/uploaded/' . $destination;
				if (!(files::catch_errors(files::rcopy($source, objects::$phpbb_root_path . 'ext/' . $source_for_check))))
				{
					files::catch_errors(files::rrmdir($this->ext_tmp));
					if ($action != 'upload_local')
					{
						$file->remove();
					}
					return false;
				}
				$source = objects::$phpbb_root_path . 'ext/' . $source_for_check;
			}

			// Validate the extension to check if it can be used on the board.
			$md_manager = objects::$compatibility->create_metadata_manager($source_for_check);
			try
			{
				if ($md_manager->get_metadata() === false || $md_manager->validate_require_phpbb() === false || $md_manager->validate_require_php() === false)
				{
					files::catch_errors(files::rrmdir($this->ext_tmp));
					if ($action != 'upload_local')
					{
						$file->remove();
					}
					files::catch_errors(objects::$user->lang['EXTENSION_NOT_AVAILABLE']);
					return false;
				}
			}
			catch (\phpbb\extension\exception $e)
			{
				$message = objects::$compatibility->get_exception_message($e);
				files::catch_errors(files::rrmdir($this->ext_tmp));
				if ($action != 'upload_local')
				{
					$file->remove();
				}
				files::catch_errors($message . ' ' . objects::$user->lang['ACP_UPLOAD_EXT_ERROR_NOT_SAVED']);
				return false;
			}

			// Save/remove the uploaded archive file.
			if ($action != 'upload_local')
			{
				if ((objects::$request->variable('keepext', false)) == false)
				{
					$file->remove();
				}
				else
				{
					$display_name = str_replace(array('/', '\\'), '_', $display_name);
					$ext_version = str_replace(array('/', '\\'), '_', $ext_version);
					$file_base_name = substr($dest_file, 0, strrpos($dest_file, '/') + 1) . $display_name . "_" . $ext_version;
					// Save this file and any other files that were uploaded with the same name.
					if (@file_exists($file_base_name . ".zip"))
					{
						$finder = 1;
						while (@file_exists($file_base_name . "(" . $finder . ").zip"))
						{
							$finder++;
						}
						@rename($dest_file, $file_base_name . "(" . $finder . ").zip");
					}
					else
					{
						@rename($dest_file, $file_base_name . ".zip");
					}
				}
			}
			// Here we can assume that all checks are done.
			// Now we are able to install the uploaded extension to the correct path.
		}
		else
		{
			// All checks were done previously. Now we only need to restore the variables.
			// We try to restore the data of the current upload.
			$this->set_temp_path(false);
			if (!is_dir($this->ext_tmp) || !($composery = files::getComposer($this->ext_tmp)) || !($string = @file_get_contents($composery)))
			{
				files::catch_errors(objects::$user->lang['ACP_UPLOAD_EXT_WRONG_RESTORE']);
				return false;
			}
			$json_a = json_decode($string, true);
			$destination = (isset($json_a['name'])) ? $json_a['name'] : '';
			$destination = str_replace('.', '', $destination);
			if (strpos($destination, '/') === false)
			{
				files::catch_errors(objects::$user->lang['ACP_UPLOAD_EXT_WRONG_RESTORE']);
				return false;
			}
			$source = substr($composery, 0, -14);
		}
		$made_update = false;
		// Delete the previous version of extension files - we're able to update them.
		if (is_dir(objects::$phpbb_root_path . 'ext/' . $destination))
		{
			// At first we need to disable the extension if it is enabled.
			if (objects::$phpbb_extension_manager->is_enabled($destination))
			{
				while (objects::$phpbb_extension_manager->disable_step($destination))
				{
					// Are we approaching the time limit? If so, we want to pause the update and continue after refreshing.
					if ((time() - $start_time) >= $safe_time_limit)
					{
						objects::$template->assign_var('S_NEXT_STEP', objects::$user->lang['EXTENSION_DISABLE_IN_PROGRESS']);

						// No need to specify the name of the extension. We suppose that it is the one in ext/tmp/USER_ID folder.
						if (objects::$request->is_ajax())
						{
							$response_object = new \phpbb\json_response;
							$response_object->send(array("FORCE_UPDATE" => true));
						}
						else
						{
							meta_refresh(0, objects::$u_action . '&amp;action=force_update');
						}
						return false;
					}
				}
				objects::$log->add('admin', objects::$user->data['user_id'], objects::$user->ip, 'LOG_EXT_DISABLE', time(), array($destination));
				$made_update = true;
			}

			$saved_zip_file = $this->save_previous_version($destination);

			$this->check_missing_languages($source, $destination, $saved_zip_file);

			if (!(files::catch_errors(files::rrmdir(objects::$phpbb_root_path . 'ext/' . $destination))))
			{
				return false;
			}
		}
		if (!(files::catch_errors(files::rcopy($source, objects::$phpbb_root_path . 'ext/' . $destination))))
		{
			files::catch_errors(files::rrmdir($this->ext_tmp));
			return false;
		}
		// No enabling at this stage. Admins should have a chance to revise the uploaded scripts.
		if (!(files::catch_errors(files::rrmdir($this->ext_tmp))))
		{
			return false;
		}

		load::details($destination, (($made_update) ? 'updated' : 'uploaded'));

		// Clear phpBB cache after details page did its work.
		// Needed because some files like ext.php can be deleted in the new version.
		// Should be done at last because we need to remove class names from data_global cache file.
		objects::$cache->purge();

		return true;
	}

	protected function check_ext_name($destination)
	{
		if (strpos($destination, '/') === false)
		{
			files::catch_errors(files::rrmdir($this->ext_tmp));
			files::catch_errors(objects::$user->lang['ACP_UPLOAD_EXT_ERROR_DEST']);
			return false;
		}

		if (strpos($destination, objects::$upload_ext_name) !== false)
		{
			files::catch_errors(files::rrmdir($this->ext_tmp));
			files::catch_errors(objects::$user->lang['ACP_UPLOAD_EXT_ERROR_TRY_SELF']);
			return false;
		}

		return true;
	}

	protected function save_previous_version($destination)
	{
		$old_ext_name = $destination;
		if ($old_composery = files::getComposer(objects::$phpbb_root_path . 'ext/' . $destination))
		{
			if (!($old_string = @file_get_contents($old_composery)))
			{
				$old_ext_name = $old_ext_name . '_' . '0.0.0';
			}
			else
			{
				$old_json_a = json_decode($old_string, true);
				$old_display_name = (isset($old_json_a['extra']['display-name'])) ? $old_json_a['extra']['display-name'] : $old_ext_name;
				$old_ext_version = (isset($old_json_a['version'])) ? $old_json_a['version'] : '0.0.0';
				$old_ext_name = $old_display_name . '_' . $old_ext_version;
			}
		}
		$dest_name = str_replace(array('/', '\\'), '_', $old_ext_name) . '_old';
		$file_base_name = objects::$zip_dir . '/' . $dest_name;
		// Save this file and any other files that were uploaded with the same name.
		if (@file_exists($file_base_name . ".zip"))
		{
			$finder = 1;
			while (@file_exists($file_base_name . "(" . $finder . ").zip"))
			{
				$finder++;
			}
			$dest_name .= "(" . $finder . ")";
		}
		// Save the previous version of the extension that is being updated in a zip archive file.
		files::save_zip_archive('ext/' . $destination . '/', $dest_name, objects::$zip_dir);
		$saved_zip_file = $dest_name . ".zip";
		$saved_zip_file = objects::$request->escape($saved_zip_file, true);
		objects::$template->assign_var('EXT_OLD_ZIP_SAVED', objects::$user->lang('EXT_SAVED_OLD_ZIP', $saved_zip_file));

		return $saved_zip_file;
	}

	protected function check_missing_languages($source, $destination, $saved_zip_file)
	{
		// Check languages missing in the new version.
		$old_langs = files::get_languages(objects::$phpbb_root_path . 'ext/' . $destination . '/language');
		$new_langs = files::get_languages($source . '/language');
		$old_langs = array_diff($old_langs, $new_langs);
		if (sizeof($old_langs))
		{
			$last_lang = array_pop($old_langs);
			objects::$template->assign_vars(array(
				'S_EXT_LANGS_RESTORE_ZIP' => urlencode($saved_zip_file),
				'EXT_RESTORE_DIRECTORIES' => (sizeof($old_langs)) ? objects::$user->lang('EXT_RESTORE_LANGUAGES', '<strong>' . implode('</strong>, <strong>', $old_langs) . '</strong>', "<strong>$last_lang</strong>") : objects::$user->lang('EXT_RESTORE_LANGUAGE', "<strong>$last_lang</strong>"),
			));
		}
	}
}
