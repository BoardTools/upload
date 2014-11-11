<?php
/**
*
* @package Upload Extensions
* @copyright (c) 2014 John Peskens (http://ForumHulp.com) and Igor Lavrov (https://github.com/LavIgor)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace boardtools\upload\acp;

class upload_module
{
	public $u_action;
	public $main_link;
	public $back_link;
	private $self_update;
	private $upload_ext_name;
	var $zip_dir = '';
	var $error = '';
	function main($id, $mode)
	{
		global $db, $config, $user, $cache, $template, $request, $phpbb_root_path, $phpEx, $phpbb_log, $phpbb_extension_manager, $phpbb_container;

		$this->page_title = $user->lang['ACP_UPLOAD_EXT_TITLE'];
		$this->tpl_name = 'acp_upload';
		// This is the dir where we will store zip files of extensions.
		$this->zip_dir = $phpbb_root_path . $config['upload_ext_dir'];
		$user->add_lang(array('install', 'acp/extensions', 'migrator'));
		$user->add_lang_ext('boardtools/upload', 'upload');

		// get any url vars
		$action = $request->variable('action', '');

		// if 'i' is a number - continue displaying a number
		$mode = $request->variable('mode', $mode);
		$id = $request->variable('i', $id);
		$this->main_link = $this->u_action;
		//$phpbb_root_path . 'adm/index.php?i=' . $id . '&amp;sid=' .$user->session_id . '&amp;mode=' . $mode;
		$this->back_link = ($request->is_ajax()) ? adm_back_link($this->u_action) : '';

		include($phpbb_root_path . 'ext/boardtools/upload/vendor/filetree/filetree.' . $phpEx);
		$file = $request->variable('file', '');
		if ($file != '')
		{
			\filetree::get_file($file);
		}

		$this->upload_ext_name = 'boardtools/upload';
		$md_manager = new \phpbb\extension\metadata_manager($this->upload_ext_name, $config, $phpbb_extension_manager, $template, $user, $phpbb_root_path);
		try
		{
			$this->metadata = $md_manager->get_metadata('all');
		}
		catch(\phpbb\extension\exception $e)
		{
			$this->trigger_error($e, E_USER_WARNING);
		}

		$upload_extensions_download = false;
		try
		{
			$updates_available = $this->version_check($md_manager, $request->variable('versioncheck_force', false));

			$template->assign_vars(array(
				'UPLOAD_EXT_NEW_UPDATE'	=> !empty($updates_available),
				'S_UP_TO_DATE'			=> empty($updates_available),
				'S_VERSIONCHECK'		=> true,
				'UP_TO_DATE_MSG'		=> $user->lang(empty($updates_available) ? 'UP_TO_DATE' : 'NOT_UP_TO_DATE', $md_manager->get_metadata('display-name')),
			));

			foreach ($updates_available as $branch => $version_data)
			{
				$template->assign_block_vars('updates_available', $version_data);
				$upload_extensions_download = $version_data['download'];
			}
		}
		catch (\RuntimeException $e)
		{
			$template->assign_vars(array(
				'S_VERSIONCHECK_STATUS'			=> $e->getCode(),
				'VERSIONCHECK_FAIL_REASON'		=> ($e->getMessage() !== $user->lang('VERSIONCHECK_FAIL')) ? $e->getMessage() : '',
			));
		}
		$this->self_update = $upload_extensions_download;

		switch ($action)
		{
			case 'details':

				$md_manager->output_template_data();

				if ($this->self_update !== false)
				{
					$template->assign_vars(array(
						'U_UPLOAD_EXT_UPDATE'	=> $this->main_link . '&amp;action=upload_self',
					));
				}

				if ($request->is_ajax())
				{
					$template->assign_vars(array(
						'IS_AJAX'				=> true,
					));
				}
				else
				{
					$template->assign_vars(array(
						'U_BACK'				=> $this->main_link,
					));
				}

				$this->tpl_name = 'acp_ext_details';
				break;

			case 'upload':
				/* If we unpack a zip file - ensure that we work locally */
				if (($request->variable('local_upload', '')) != '')
				{
					$action = 'upload_local';
				}
				/* We use '!== false' because strpos can return 0 if the needle is found in position 0 */
				else if (strpos($request->variable('remote_upload', ''), 'http://') !== false || strpos($request->variable('remote_upload', ''), 'https://') !== false)
				{
					$action = 'upload_remote';
				}

			case 'upload_remote':
			case 'force_update':
			case 'upload_self':
			case 'upload_self_update':
				$this->upload_ext($action);
				$this->listzip();
				$this->list_available_exts($phpbb_extension_manager);
				$template->assign_vars(array(
					'U_ACTION'			=> $this->u_action,
					'U_UPLOAD'			=> $this->main_link . '&amp;action=upload',
					'U_UPLOAD_REMOTE'	=> $this->main_link . '&amp;action=upload_remote',
					'S_FORM_ENCTYPE'	=> ' enctype="multipart/form-data"',
				));
				break;

			case 'download':
				$zip_name = $request->variable('zip_name', '');
				if ($zip_name != '')
				{
					$download_name = substr($zip_name, 0, -4);
					$filename = $this->zip_dir . '/' . $download_name;

					$mimetype = 'application/zip';

					header('Cache-Control: private, no-cache');
					header("Content-Type: $mimetype; name=\"$download_name.zip\"");
					header("Content-disposition: attachment; filename=$download_name.zip");

					$fp = @fopen("$filename.zip", 'rb');
					if ($fp)
					{
						while ($buffer = fread($fp, 1024))
						{
							echo $buffer;
						}
						fclose($fp);
					}
					else
					{
						redirect($this->main_link);
					}
				}
				else
				{
					redirect($this->main_link);
				}
				break;

			case 'delete':
				$ext_name = $request->variable('ext_name', '');
				$zip_name = $request->variable('zip_name', '');
				if ($ext_name != '')
				{
					if (confirm_box(true))
					{
						// Ensure that we can delete extensions only in ext/ directory.
						$ext_name = str_replace('.', '', $ext_name);
						if (substr_count($ext_name, '/') === 1 && is_dir($phpbb_root_path . 'ext/' . $ext_name))
						{
							$dir = substr($ext_name, 0, strpos($ext_name, '/'));
							$extensions = sizeof(glob($phpbb_root_path . 'ext/' . $dir . '/*'));
							$dir = ($extensions === 1) ? $dir : $ext_name;
							$this->rrmdir($phpbb_root_path . 'ext/' . $dir);
						}
						if ($request->is_ajax())
						{
							trigger_error($user->lang('EXT_DELETE_SUCCESS'));
						}
						else
						{
							redirect($this->main_link);
						}
					} else {
						confirm_box(false, $user->lang('EXTENSION_DELETE_CONFIRM', $ext_name), build_hidden_fields(array(
							'i'			=> $id,
							'mode'		=> $mode,
							'action'	=> $action,
							'ext_name'	=> $ext_name,
						)));
					}
				}
				else if ($zip_name != '')
				{
					if (confirm_box(true))
					{
						$this->rrmdir($this->zip_dir . '/' . substr($zip_name, 0, -4) . '.zip');
						if ($request->is_ajax())
						{
							trigger_error($user->lang('EXT_ZIP_DELETE_SUCCESS'));
						}
						else
						{
							redirect($this->main_link);
						}
					} else {
						confirm_box(false, $user->lang('EXTENSION_ZIP_DELETE_CONFIRM', $zip_name), build_hidden_fields(array(
							'i'			=> $id,
							'mode'		=> $mode,
							'action'	=> $action,
							'zip_name'	=> $zip_name,
						)));
					}
				}
				// no break

			default:
				$this->listzip();
				$this->list_available_exts($phpbb_extension_manager);
				$template->assign_vars(array(
					'U_ACTION'			=> $this->u_action,
					'U_UPLOAD'			=> $this->main_link . '&amp;action=upload',
					'U_UPLOAD_REMOTE'	=> $this->main_link . '&amp;action=upload_remote',
					'S_FORM_ENCTYPE'	=> ' enctype="multipart/form-data"',
				));
				break;
		}
	}

	function listzip()
	{
		global $phpbb_root_path, $template, $request, $phpbb_container;
		$zip_array = array();
		$ffs = scandir($this->zip_dir . '/');
		foreach($ffs as $ff)
		{
			if ($ff != '.' && $ff != '..')
			{
				if (strpos($ff,'.zip') == (strlen($ff) - 4))
				{
					$zip_array[] = array(
						'META_DISPLAY_NAME'	=> $ff,
						'U_UPLOAD'			=> $this->main_link . '&amp;action=upload&amp;local_upload=' . urlencode($ff),
						'U_DOWNLOAD'		=> $this->main_link . '&amp;action=download&amp;zip_name=' . urlencode($ff),
						'U_DELETE'			=> $this->main_link . '&amp;action=delete&amp;zip_name=' . urlencode($ff)
					);
				}
			}
		}

		$pagination = $phpbb_container->get('pagination');
		$start		= $request->variable('start', 0);
		$zip_count = sizeof($zip_array);
		$per_page = 5;
		$base_url = $this->u_action;
		$pagination->generate_template_pagination($base_url, 'pagination', 'start', $zip_count, $per_page, $start);

		uasort($zip_array, array($this, 'sort_extension_meta_data_table'));
		for($i = $start; $i < $zip_count && $i < $start + $per_page; $i++)
		{
			$template->assign_block_vars('zip', $zip_array[$i]);
		}
	}

	function getComposer($dir)
	{
		global $composer;
		$ffs = scandir($dir);
		$composer = false;
		foreach($ffs as $ff)
		{
			if ($ff != '.' && $ff != '..')
			{
				if ($ff == 'composer.json')
				{
					$composer = $dir . '/' . $ff;
					break;
				}
				if(is_dir($dir.'/'.$ff))
				{
					$this->getComposer($dir . '/' . $ff);
				}
			}
		}
		return $composer;
	}

	// Function to remove folders and files
	function rrmdir($dir)
	{
		if (is_dir($dir))
		{
			$files = scandir($dir);
			foreach ($files as $file)
			{
				if ($file != '.' && $file != '..')
				{
					$this->rrmdir($dir . '/' . $file);
				}
			}
			rmdir($dir);
		}
		else if (file_exists($dir))
		{
			if (!(@unlink(realpath($dir))))
			{
				$this->trigger_error($user->lang['EXT_UPLOAD_ERROR'] . $this->back_link, E_USER_WARNING);
				return false;
			}
		}
	}

	// Function to copy folders and files
	function rcopy($src, $dst)
	{
		if (file_exists($dst))
		{
			$this->rrmdir($dst);
		}
		if (is_dir($src))
		{
			$this->recursive_mkdir($dst, 0755);
			$files = scandir($src);
			foreach($files as $file)
			{
				if ($file != '.' && $file != '..')
				{
					$this->rcopy($src . '/' . $file, $dst . '/' . $file);
				}
			}
		} else if (file_exists($src))
		{
			copy($src, $dst);
		}
	}

	/**
	 * Lists all the available extensions and dumps to the template
	 *
	 * @param  $phpbb_extension_manager     An instance of the extension manager
	 * @return null
	 */
	public function list_available_exts(\phpbb\extension\manager $phpbb_extension_manager)
	{
		global $template, $request, $user;
		$uninstalled = array_diff_key($phpbb_extension_manager->all_available(), $phpbb_extension_manager->all_configured());

		$available_extension_meta_data = array();

		foreach ($uninstalled as $name => $location)
		{
			$md_manager = $phpbb_extension_manager->create_extension_metadata_manager($name, $template);

			try
			{
				$display_ext_name = $md_manager->get_metadata('display-name');
				$meta = $md_manager->get_metadata('all');
				$available_extension_meta_data[$name] = array(
					'META_DISPLAY_NAME'	=> $display_ext_name,
					'META_VERSION'		=> $meta['version'],
					'U_DELETE'			=> $this->main_link . '&amp;action=delete&amp;ext_name=' . urlencode($name)
				);
			}
			catch(\phpbb\extension\exception $e)
			{
				$available_extension_meta_data[$name] = array(
					'META_DISPLAY_NAME'	=> (isset($display_ext_name)) ? $display_ext_name : 'Broken extension (' . $name . ')',
					'META_VERSION'		=> (isset($meta['version'])) ? $meta['version'] : '0.0.0',
					'U_DELETE'			=> $this->main_link . '&amp;action=delete&amp;ext_name=' . urlencode($name)
				);
			}
		}

		uasort($available_extension_meta_data, array($this, 'sort_extension_meta_data_table'));

		foreach ($available_extension_meta_data as $name => $block_vars)
		{
			$template->assign_block_vars('disabled', $block_vars);
		}
	}

	/**
	 * Sort helper for the table containing the metadata about the extensions.
	 */
	protected function sort_extension_meta_data_table($val1, $val2)
	{
		return strnatcasecmp($val1['META_DISPLAY_NAME'], $val2['META_DISPLAY_NAME']);
	}

	protected function trigger_error($error, $type)
	{
		global $template, $action;
		$action = '';
		$template->assign_vars(array(
			'UPLOAD_ERROR'			=> $error,
		));
		return true;
	}

	/**
	 * Check the version and return the available updates.
	 *
	 * @param \phpbb\extension\metadata_manager $md_manager The metadata manager for the version to check.
	 * @param bool $force_update Ignores cached data. Defaults to false.
	 * @param bool $force_cache Force the use of the cache. Override $force_update.
	 * @return string
	 * @throws RuntimeException
	 */
	protected function version_check(\phpbb\extension\metadata_manager $md_manager, $force_update = false, $force_cache = false)
	{
		global $cache, $config, $user;
		$meta = $md_manager->get_metadata('all');

		if (!isset($meta['extra']['version-check']))
		{
			throw new \RuntimeException($user->lang('NO_VERSIONCHECK'), 1);
		}

		$version_check = $meta['extra']['version-check'];

		$version_helper = new \phpbb\version_helper($cache, $config, $user);
		$version_helper->set_current_version($meta['version']);
		$version_helper->set_file_location($version_check['host'], $version_check['directory'], $version_check['filename']);
		$version_helper->force_stability($config['extension_force_unstable'] ? 'unstable' : null);

		return $updates = $version_helper->get_suggested_updates($force_update, $force_cache);
	}

	/**
	 *
	 * @package automod
	 * @copyright (c) 2008 phpBB Group
	 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
	 *
	 */
	function upload_ext($action)
	{
		global $phpbb_root_path, $phpEx, $phpbb_log, $phpbb_extension_manager, $template, $user, $request;

		//$can_upload = (@ini_get('file_uploads') == '0' || strtolower(@ini_get('file_uploads')) == 'off' || !@extension_loaded('zlib')) ? false : true;

		$user->add_lang('posting');  // For error messages
		include($phpbb_root_path . 'includes/functions_upload.' . $phpEx);
		$upload = new \fileupload();
		$upload->set_allowed_extensions(array('zip'));	// Only allow ZIP files

		$upload_dir = $this->zip_dir;

		// Make sure the ext/ directory exists and if it doesn't, create it
		if (!is_dir($phpbb_root_path . 'ext'))
		{
			$this->recursive_mkdir($phpbb_root_path . 'ext');
		}

		if (!is_writable($phpbb_root_path . 'ext'))
		{
			$this->trigger_error($user->lang['EXT_NOT_WRITABLE'] . $this->back_link, E_USER_WARNING);
			return false;
		}

		if (!is_dir($this->zip_dir))
		{
			$this->recursive_mkdir($this->zip_dir);
		}

		// Proceed with the upload
		if ($action == 'upload')
		{
			$file = $upload->form_upload('extupload');
		}
		else if ($action == 'upload_remote')
		{
			$file = $this->remote_upload($upload, $request->variable('remote_upload', ''));
		}
		else if ($action == 'upload_self')
		{
			if ($this->self_update !== false && (preg_match('#^(https://)www.phpbb.com/customise/db/download/([0-9]*?)$#i', $this->self_update, $match_phpbb)) || (preg_match('#^(https://)github.com/BoardTools/upload/archive/(.*?)\.zip$#i', $this->self_update, $match_phpbb)))
			{
				$file = $this->remote_upload($upload, $this->self_update);
			}
			else
			{
				$this->trigger_error($user->lang['EXT_UPLOAD_ERROR'] . $this->back_link, E_USER_WARNING);
				return false;
			}
		}

		// What is a safe limit of execution time? Half the max execution time should be safe.
		$safe_time_limit = (ini_get('max_execution_time') / 2);
		$start_time = time();
		// We skip working with a zip file if we are enabling/restarting the extension.
		if ($action != 'force_update' && $action != 'upload_self_update')
		{
			if ($action != 'upload_local')
			{
				if (empty($file->filename))
				{
					$this->trigger_error((sizeof($file->error) ? implode('<br />', $file->error) : $user->lang['NO_UPLOAD_FILE']) . $this->back_link, E_USER_WARNING);
					return false;
				}
				else if ($file->init_error || sizeof($file->error))
				{
					$file->remove();
					$this->trigger_error((sizeof($file->error) ? implode('<br />', $file->error) : $user->lang['EXT_UPLOAD_INIT_FAIL']) . $this->back_link, E_USER_WARNING);
					return false;
				}

				$file->clean_filename('real');
				$file->move_file(str_replace($phpbb_root_path, '', $upload_dir), true, true);

				if (sizeof($file->error))
				{
					$file->remove();
					$this->trigger_error(implode('<br />', $file->error) . $this->back_link, E_USER_WARNING);
					return false;
				}
				$dest_file = $file->destination_file;
			}
			else
			{
				$dest_file = $upload_dir . '/' . $request->variable('local_upload', '');
			}

			include_once($phpbb_root_path . 'includes/functions_compress.' . $phpEx);

			// We need to use the user ID and the time to escape from problems with simultaneous uploads.
			// We suppose that one user can upload only one extension per session.
			$ext_tmp = 'tmp/' . (int) $user->data['user_id'];
			// Ensure that we don't have any previous files in the working directory.
			if (is_dir($phpbb_root_path . 'ext/' . $ext_tmp))
			{
				$this->rrmdir($phpbb_root_path . 'ext/' . $ext_tmp);
			}

			$zip = new \compress_zip('r', $dest_file);
			$zip->extract($phpbb_root_path . 'ext/' . $ext_tmp . '/');
			$zip->close();

			$composery = $this->getComposer($phpbb_root_path . 'ext/' . $ext_tmp);
			if (!$composery)
			{
				$this->rrmdir($phpbb_root_path . 'ext/' . $ext_tmp);
				$file->remove();
				$this->trigger_error($user->lang['ACP_UPLOAD_EXT_ERROR_COMP'] . $this->back_link, E_USER_WARNING);
				return false;
			}
			$string = @file_get_contents($composery);
			if ($string === false)
			{
				$this->rrmdir($phpbb_root_path . 'ext/' . $ext_tmp);
				$file->remove();
				$this->trigger_error($user->lang['EXT_UPLOAD_ERROR'] . $this->back_link, E_USER_WARNING);
				return false;
			}
			$json_a = json_decode($string, true);
			$destination = (isset($json_a['name'])) ? $json_a['name'] : '';
			$ext_version = (isset($json_a['version'])) ? $json_a['version'] : '0.0.0';
			if (strpos($destination, '/') === false)
			{
				$this->rrmdir($phpbb_root_path . 'ext/' . $ext_tmp);
				$file->remove();
				$this->trigger_error($user->lang['ACP_UPLOAD_EXT_ERROR_DEST'] . $this->back_link, E_USER_WARNING);
				return false;
			}
			else if (strpos($destination, $this->upload_ext_name) !== false && $action != 'upload_self')
			{
				$this->rrmdir($phpbb_root_path . 'ext/' . $ext_tmp);
				$file->remove();
				$this->trigger_error($user->lang['EXT_UPLOAD_ERROR'] . $this->back_link, E_USER_WARNING);
				return false;
			}
			$display_name = (isset($json_a['extra']['display-name'])) ? $json_a['extra']['display-name'] : 'Unknown extension';
			if (!isset($json_a['type']) || $json_a['type'] != "phpbb-extension")
			{
				$this->rrmdir($phpbb_root_path . 'ext/' . $ext_tmp);
				if($action != 'upload_local')
				{
					$file->remove();
				}
				$this->trigger_error($user->lang['NOT_AN_EXTENSION'] . $this->back_link, E_USER_WARNING);
				return false;
			}
			$source = substr($composery, 0, -14);
			if ($action != 'upload_self')
			{
				$source_for_check = $ext_tmp . '/' . $destination;
			}
			else
			{
				$source_for_check = 'boardtools/new_upload/' . $destination;
			}
			// At first we need to change the directory structure to something like ext/tmp/vendor/extension.
			// We need it to escape from problems with dots on validation.
			if ($source != $phpbb_root_path . 'ext/' . $source_for_check)
			{
				$this->rcopy($source, $phpbb_root_path . 'ext/' . $source_for_check);
				$source = $phpbb_root_path . 'ext/' . $source_for_check;
			}
			// Validate the extension to check if it can be used on the board.
			$md_manager = $phpbb_extension_manager->create_extension_metadata_manager($source_for_check, $template);
			try
			{
				if($md_manager->get_metadata() === false || $md_manager->validate_require_phpbb() === false || $md_manager->validate_require_php() === false)
				{
					$this->rrmdir($phpbb_root_path . 'ext/' . $ext_tmp);
					if($action != 'upload_local')
					{
						$file->remove();
					}
					$this->trigger_error($user->lang['EXTENSION_NOT_AVAILABLE'] . $this->back_link, E_USER_WARNING);
					return false;
				}
			}
			catch(\phpbb\extension\exception $e)
			{
				$this->rrmdir($phpbb_root_path . 'ext/' . $ext_tmp);
				if($action != 'upload_local')
				{
					$file->remove();
				}
				$this->trigger_error($e . ' ' . $user->lang['ACP_UPLOAD_EXT_ERROR_NOT_SAVED'] . $this->back_link, E_USER_WARNING);
				return false;
			}

			// Save/remove the uploaded archive file.
			if($action != 'upload_local')
			{
				if (($request->variable('keepext', false)) == false)
				{
					$file->remove();
				}
				else
				{
					$display_name = str_replace(array('/', '\\'), '_', $display_name);
					$ext_version = str_replace(array('/', '\\'), '_', $ext_version);
					// Save this file and any other files that were uploaded with the same name.
					if(@file_exists(substr($dest_file, 0, strrpos($dest_file, '/') + 1) . $display_name . "_" . $ext_version . ".zip"))
					{
						$finder = 1;
						while(@file_exists(substr($dest_file, 0, strrpos($dest_file, '/') + 1) . $display_name . "_" . $ext_version . "(" . $finder . ").zip"))
						{
							$finder++;
						}
						@rename($dest_file, substr($dest_file, 0, strrpos($dest_file, '/') + 1) . $display_name . "_" . $ext_version . "(" . $finder . ").zip");
					}
					else
					{
						@rename($dest_file, substr($dest_file, 0, strrpos($dest_file, '/') + 1) . $display_name . "_" . $ext_version . ".zip");
					}
				}
			}
			// Here we can assume that all checks are done.
			// Now we are able to install the uploaded extension to the correct path.
		}
		else if ($action != 'upload_self_update')
		{
			// All checks were done previously. Now we only need to restore the variables.
			// We try to restore the data of the current upload.
			$ext_tmp = 'tmp/' . (int) $user->data['user_id'];
			if (!is_dir($phpbb_root_path . 'ext/' . $ext_tmp) || !($composery = $this->getComposer($phpbb_root_path . 'ext/' . $ext_tmp)) || !($string = @file_get_contents($composery)))
			{
				$this->trigger_error($user->lang['ACP_UPLOAD_EXT_WRONG_RESTORE'] . $this->back_link, E_USER_WARNING);
				return false;
			}
			$json_a = json_decode($string, true);
			$destination = (isset($json_a['name'])) ? $json_a['name'] : '';
			if (strpos($destination, '/') === false)
			{
				$this->trigger_error($user->lang['ACP_UPLOAD_EXT_WRONG_RESTORE'] . $this->back_link, E_USER_WARNING);
				return false;
			}
			$source = substr($composery, 0, -14);
			$display_name = (isset($json_a['extra']['display-name'])) ? $json_a['extra']['display-name'] : 'Unknown extension';
		}
		else
		{
			// All checks were done previously. Now we only need to restore the variables.
			// We try to restore the data of the current upload.
			$ext_tmp = 'boardtools/new_upload';
			if (!is_dir($phpbb_root_path . 'ext/' . $ext_tmp) || !($composery = $this->getComposer($phpbb_root_path . 'ext/' . $ext_tmp)) || !($string = @file_get_contents($composery)))
			{
				$this->trigger_error($user->lang['ACP_UPLOAD_EXT_WRONG_RESTORE'] . $this->back_link, E_USER_WARNING);
				return false;
			}
			$json_a = json_decode($string, true);
			$destination = (isset($json_a['name'])) ? $json_a['name'] : '';
			if (strpos($destination, 'boardtools/') === false)
			{
				$this->trigger_error($user->lang['ACP_UPLOAD_EXT_WRONG_RESTORE'] . $this->back_link, E_USER_WARNING);
				return false;
			}
			$source = substr($composery, 0, -14);
			$display_name = (isset($json_a['extra']['display-name'])) ? $json_a['extra']['display-name'] : 'Unknown extension';
		}
		if ($action != 'upload_self' && $action != 'upload_self_update')
		{
			$made_update = false;
			// Delete the previous version of extension files - we're able to update them.
			if (is_dir($phpbb_root_path . 'ext/' . $destination))
			{
				// At first we need to disable the extension if it is enabled.
				if ($phpbb_extension_manager->is_enabled($destination))
				{
					while ($phpbb_extension_manager->disable_step($destination))
					{
						// Are we approaching the time limit? If so, we want to pause the update and continue after refreshing.
						if ((time() - $start_time) >= $safe_time_limit)
						{
							$template->assign_var('S_NEXT_STEP', true);

							// No need to specify the name of the extension. We suppose that it is the one in ext/tmp/USER_ID folder.
							meta_refresh(0, $this->main_link . '&amp;action=force_update');
							return false;
						}
					}
					$phpbb_log->add('admin', $user->data['user_id'], $user->ip, 'LOG_EXT_DISABLE', time(), array($destination));
					$made_update = true;
				}
				$old_ext_name = $destination;
				if($old_composery = $this->getComposer($phpbb_root_path . 'ext/' . $destination))
				{
					$old_string = file_get_contents($old_composery);
					$old_json_a = json_decode($old_string, true);
					$old_display_name = (isset($old_json_a['extra']['display-name'])) ? $old_json_a['extra']['display-name'] : $old_ext_name;
					$old_ext_version = (isset($old_json_a['version'])) ? $old_json_a['version'] : '0.0.0';
					$old_ext_name = $old_display_name . '_' . $old_ext_version;
				}
				$this->save_zip_archive('ext/' . $destination . '/', str_replace(array('/', '\\'), '_', $old_ext_name) . '_old');
				$this->rrmdir($phpbb_root_path . 'ext/' . $destination);
			}
			$this->rcopy($source, $phpbb_root_path . 'ext/' . $destination);
			// No enabling at this stage. Admins should have a chance to revise the uploaded scripts.
			$this->rrmdir($phpbb_root_path . 'ext/' . $ext_tmp);
		}
		else if ($action == 'upload_self')
		{
			// No enabling at this stage. Admins should have a chance to revise the uploaded scripts.
			$this->rrmdir($phpbb_root_path . 'ext/' . $ext_tmp);
			$destination = 'boardtools/new_upload/' . $destination;
		}
		else
		{
			// Now Upload Extensions will update itself. We suppose that it will be fast and without errors.
			// Otherwise users will need to use FTP.
			$phpbb_extension_manager->disable($destination);
			$this->rcopy($source, $phpbb_root_path . 'ext/' . $destination);
			$phpbb_extension_manager->enable($destination);
			$this->rrmdir($phpbb_root_path . 'ext/' . $ext_tmp);
			$template->assign_vars(array(
				'S_UPDATED_SELF'		=> $display_name,
			));
			return true;
		}

		foreach ($json_a['authors'] as $author)
		{
			$template->assign_block_vars('authors', array(
				'AUTHOR'	=> $author['name'],
			));
		}

		$string = @file_get_contents($phpbb_root_path . 'ext/' . $destination . '/README.md');
		if ($string !== false)
		{
			include($phpbb_root_path . 'ext/boardtools/upload/vendor/Markdown/Michelf/MarkdownExtra.inc.' . $phpEx);
			$readme = \Michelf\MarkdownExtra::defaultTransform($string);
		} else {
			$readme = false;
		}

		$template->assign_vars(array(
			'S_UPLOADED'		=> $display_name,
			'S_UPLOADED_SELF'	=> ($action == 'upload_self'),
			'EXT_UPDATED'		=> $made_update,
			'FILETREE'			=> \filetree::php_file_tree($phpbb_root_path . 'ext/' . $destination, $display_name, $this->main_link),
			'S_ACTION'			=> ($action != 'upload_self') ? $phpbb_root_path . 'adm/index.'.$phpEx.'?i=acp_extensions&amp;sid=' .$user->session_id . '&amp;mode=main&amp;action=enable_pre&amp;ext_name=' . urlencode($destination) : $this->main_link . '&amp;action=upload_self_update',
			'S_ACTION_BACK'		=> $this->main_link,
			'U_ACTION'			=> $this->u_action,
			'README_MARKDOWN'	=> $readme,
			'FILENAME'			=> ($string !== false) ? 'README.md' : '',
			'CONTENT'			=> ($string !== false) ?  highlight_string($string, true): ''
		));

		return true;
	}

	/**
	 * Save the previous version of the extension that is being updated in a zip archive file
	 */
	function save_zip_archive($dest_file, $dest_name)
	{
		global $phpbb_root_path, $phpEx;
		include_once($phpbb_root_path . 'includes/functions_compress.' . $phpEx);

		$zip = new \compress_zip('w', $this->zip_dir . '/' . $dest_name . '.zip');
		$zip->add_file($dest_file);
		$zip->close();
	}

	/**
	 * @author Michal Nazarewicz (from the php manual)
	 * Creates all non-existant directories in a path
	 * @param $path - path to create
	 * @param $mode - CHMOD the new dir to these permissions
	 * @return bool
	 */
	function recursive_mkdir($path, $mode = 0755)
	{
		$dirs = explode('/', $path);
		$count = sizeof($dirs);
		$path = '.';
		for ($i = 0; $i < $count; $i++)
		{
			$path .= '/' . $dirs[$i];

			if (!is_dir($path))
			{
				@mkdir($path, $mode);
				@chmod($path, $mode);

				if (!is_dir($path))
				{
					return false;
				}
			}
		}
		return true;
	}

	/**
	 * Remote upload method
	 * Uploads file from given url
	 *
	 * @param string $upload_url URL pointing to file to upload, for example http://www.foobar.com/example.gif
	 * @param \phpbb\mimetype\guesser $mimetype_guesser Mimetype guesser
	 * @return object $file Object "filespec" is returned, all further operations can be done with this object
	 * @access public
	 */
	function remote_upload($files, $upload_url, \phpbb\mimetype\guesser $mimetype_guesser = null)
	{
		global $user, $phpbb_root_path;

		$upload_ary = array();
		$upload_ary['local_mode'] = true;

		$upload_from_phpbb = preg_match('#^(https://)www.phpbb.com/customise/db/download/([0-9]*?)$#i', $upload_url, $match_phpbb);

		if (!preg_match('#^(https?://).*?\.(' . implode('|', $files->allowed_extensions) . ')$#i', $upload_url, $match) && !$upload_from_phpbb)
		{
			$file = new \fileerror($user->lang[$files->error_prefix . 'URL_INVALID']);
			return $file;
		}

		if (empty($match[2]) && empty($match_phpbb[2]))
		{
			$file = new \fileerror($user->lang[$files->error_prefix . 'URL_INVALID']);
			return $file;
		}

		$url = parse_url($upload_url);

		$host = $url['host'];
		$path = $url['path'];
		$port = (!empty($url['port'])) ? (int) $url['port'] : 80;

		$upload_ary['type'] = 'application/octet-stream';

		$url['path'] = explode('.', $url['path']);
		$ext = array_pop($url['path']);

		$url['path'] = implode('', $url['path']);
		$upload_ary['name'] = utf8_basename($url['path']) . (($ext) ? '.' . $ext : '');
		$filename = $url['path'];
		$filesize = 0;

		$remote_max_filesize = $files->max_filesize;
		if (!$remote_max_filesize)
		{
			$max_filesize = @ini_get('upload_max_filesize');

			if (!empty($max_filesize))
			{
				$unit = strtolower(substr($max_filesize, -1, 1));
				$remote_max_filesize = (int) $max_filesize;

				switch ($unit)
				{
					case 'g':
						$remote_max_filesize *= 1024;
					// no break
					case 'm':
						$remote_max_filesize *= 1024;
					// no break
					case 'k':
						$remote_max_filesize *= 1024;
					// no break
				}
			}
		}

		$errno = 0;
		$errstr = '';

		if (!($fsock = @fopen($upload_url, "r")))
		{
			$file = new \fileerror($user->lang[$files->error_prefix . 'NOT_UPLOADED']);
			return $file;
		}

		// Make sure $path not beginning with /
		if (strpos($path, '/') === 0)
		{
			$path = substr($path, 1);
		}

		$get_info = false;
		$data = '';
		$length = false;
		$timer_stop = time() + $files->upload_timeout;

		while (!@feof($fsock))
		{
			if ($length)
			{
				// Don't attempt to read past end of file if server indicated length
				$block = @fread($fsock, min($length - $filesize, 1024));
			}
			else
			{
				$block = @fread($fsock, 1024);
			}

			$filesize += strlen($block);

			if ($remote_max_filesize && $filesize > $remote_max_filesize)
			{
				$max_filesize = get_formatted_filesize($remote_max_filesize, false);

				$file = new \fileerror(sprintf($user->lang[$files->error_prefix . 'WRONG_FILESIZE'], $max_filesize['value'], $max_filesize['unit']));
				return $file;
			}

			$data .= $block;

			// Cancel upload if we exceed timeout
			if (time() >= $timer_stop)
			{
				$file = new \fileerror($user->lang[$files->error_prefix . 'REMOTE_UPLOAD_TIMEOUT']);
				return $file;
			}
		}
		@fclose($fsock);

		if (empty($data))
		{
			$file = new \fileerror($user->lang[$files->error_prefix . 'EMPTY_REMOTE_DATA']);
			return $file;
		}

		$tmp_path = (!@ini_get('safe_mode') || strtolower(@ini_get('safe_mode')) == 'off') ? false : $phpbb_root_path . 'cache';
		$filename = tempnam($tmp_path, unique_id() . '-');

		if (!($fp = @fopen($filename, 'wb')))
		{
			$file = new \fileerror($user->lang[$files->error_prefix . 'NOT_UPLOADED']);
			return $file;
		}

		$upload_ary['size'] = fwrite($fp, $data);
		fclose($fp);
		unset($data);

		$upload_ary['tmp_name'] = $filename;

		$file = new \filespec($upload_ary, $files, $mimetype_guesser);
		if ($upload_from_phpbb)
		{
			$file->extension = 'zip';
		}
		$files->common_checks($file);

		return $file;
	}
}
