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
	var $ext_dir = '';
	var $error = '';
	function main($id, $mode)
	{
		global $db, $config, $user, $cache, $template, $request, $phpbb_root_path, $phpbb_extension_manager, $phpbb_container;

		$this->page_title = $user->lang['ACP_UPLOAD_EXT_TITLE'];
		$this->tpl_name = 'acp_upload';
		$this->ext_dir = $phpbb_root_path . 'ext';

		// get any url vars
		$action = $request->variable('action', '');

		// if 'i' is a number - continue displaying a number
		$mode = $request->variable('mode', $mode);
		$id = $request->variable('i', $id);
		$this->main_link = $phpbb_root_path . 'adm/index.php?i=' . $id . '&amp;sid=' .$user->session_id . '&amp;mode=' . $mode;
		$this->back_link = ($request->is_ajax()) ? adm_back_link($this->u_action) : '';

		$file = request_var('file', '');
		if ($file != '')
		{
			$string = file_get_contents($file);
			echo substr($file, strrpos($file, '/') + 1) . '<br><br>'.  highlight_string($string, true);
			exit;
		}

		switch ($action)
		{
			case 'details':
				$user->add_lang(array('install', 'acp/extensions', 'migrator'));
				$ext_name = 'boardtools/upload';
				$md_manager = new \phpbb\extension\metadata_manager($ext_name, $config, $phpbb_extension_manager, $template, $user, $phpbb_root_path);
				try
				{
					$this->metadata = $md_manager->get_metadata('all');
				}
				catch(\phpbb\extension\exception $e)
				{
					trigger_error($e, E_USER_WARNING);
				}

				$md_manager->output_template_data();

				try
				{
					$updates_available = $this->version_check($md_manager, $request->variable('versioncheck_force', false));

					$template->assign_vars(array(
						'S_UP_TO_DATE'		=> empty($updates_available),
						'S_VERSIONCHECK'	=> true,
						'UP_TO_DATE_MSG'	=> $user->lang(empty($updates_available) ? 'UP_TO_DATE' : 'NOT_UP_TO_DATE', $md_manager->get_metadata('display-name')),
					));

					foreach ($updates_available as $branch => $version_data)
					{
						$template->assign_block_vars('updates_available', $version_data);
					}
				}
				catch (\RuntimeException $e)
				{
					$template->assign_vars(array(
						'S_VERSIONCHECK_STATUS'			=> $e->getCode(),
						'VERSIONCHECK_FAIL_REASON'		=> ($e->getMessage() !== $user->lang('VERSIONCHECK_FAIL')) ? $e->getMessage() : '',
					));
				}

				$template->assign_vars(array(
					'U_BACK'				=> $this->u_action . '&amp;action=list',
				));

				$this->tpl_name = 'acp_ext_details';
				break;

			case 'upload':
				/* We use '!== false' because strpos can return 0 if the needle is found in position 0 */
				/* If we unpack a zip file - ensure that we work locally */
				if (($request->variable('local_upload', '')) != '')
				{
					$action = 'upload_local';
				}
				else if (strpos($request->variable('remote_upload', ''), 'http://') !== false || strpos($request->variable('remote_upload', ''), 'https://') !== false)
				{
					$action = 'upload_remote';
				}

			case 'upload_remote':
				if (!is_writable($this->ext_dir))
				{
					$this->trigger_error($user->lang('EXT_NOT_WRITABLE'));
				}
				else if (!$this->upload_ext($action))
				{
					//$this->trigger_error($user->lang('EXT_UPLOAD_ERROR'));
				}
				$this->list_available_exts($phpbb_extension_manager);
				$template->assign_vars(array(
					'U_ACTION'			=> $this->u_action,
					'U_UPLOAD'			=> $this->main_link . '&amp;action=upload',
					'U_UPLOAD_REMOTE'	=> $this->main_link . '&amp;action=upload_remote',
					'S_FORM_ENCTYPE'	=> ' enctype="multipart/form-data"',
				));
				break;

			case 'delete':
				$ext_name = $request->variable('ext_name', '');
				$zip_name = $request->variable('zip_name', '');
				if ($ext_name != '')
				{
					if (confirm_box(true))
					{
						$dir = substr($ext_name, 0, strpos($ext_name, '/'));
						$extensions = sizeof(array_filter(glob($phpbb_root_path . 'ext/' . $dir . '/*'), 'is_dir'));
						$dir = ($extensions == 1) ? $dir : substr($ext_name, strpos($ext_name, '/') + 1);
						$this->rrmdir($phpbb_root_path . 'ext/' . $dir);
						if($request->is_ajax())
						{
							trigger_error($user->lang('EXT_DELETE_SUCCESS'));
						}
						else
						{
							redirect($phpbb_root_path . 'adm/index.php?i=' . $id . '&amp;sid=' .$user->session_id . '&amp;mode=' . $mode);
						}
					} else {
						confirm_box(false, $user->lang('EXTENSION_DELETE_CONFIRM', $ext_name), build_hidden_fields(array(
							'i'			=> $id,
							'mode'		=> $mode,
							'action'	=> $action,
						)));
					}
				}
				else if ($zip_name != '')
				{
					if (confirm_box(true))
					{
						$this->rrmdir($phpbb_root_path . 'ext/' . $zip_name);
						if($request->is_ajax())
						{
							trigger_error($user->lang('EXT_ZIP_DELETE_SUCCESS'));
						}
						else
						{
							redirect($phpbb_root_path . 'adm/index.php?i=' . $id . '&amp;sid=' .$user->session_id . '&amp;mode=' . $mode);
						}
					} else {
						confirm_box(false, $user->lang('EXTENSION_ZIP_DELETE_CONFIRM', $zip_name), build_hidden_fields(array(
							'i'			=> $id,
							'mode'		=> $mode,
							'action'	=> $action,
						)));
					}
				}
				break;

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
		global $phpbb_root_path, $template, $phpbb_container;
		$zip_aray = array();
		$ffs = scandir($phpbb_root_path . 'ext/');
		foreach($ffs as $ff)
		{
			if ($ff != '.' && $ff != '..')
			{
				if (strpos($ff,'.zip'))
				{
					$zip_aray[] = array(
						'META_DISPLAY_NAME'	=> $ff,
						'U_UPLOAD'			=> $this->main_link . '&amp;action=upload&amp;local_upload=' . urlencode($ff),
						'U_DELETE'			=> $this->main_link . '&amp;action=delete&amp;zip_name=' . urlencode($ff)
					);
				}
			}
		}

		$pagination = $phpbb_container->get('pagination');
		$start		= request_var('start', 0);
		$zip_count = sizeof($zip_aray);
		$per_page = 5;
		$base_url = $this->u_action;
		$pagination->generate_template_pagination($base_url, 'pagination', 'start', $zip_count, $per_page, $start);

		uasort($zip_aray, array($this, 'sort_extension_meta_data_table'));
		for($i = $start; $i < $zip_count && $i < $start + $per_page; $i++)
		{
			$template->assign_block_vars('zip', $zip_aray[$i]);
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
			unlink($dir);
		}
	}

	// Function to Copy folders and files
	function rcopy($src, $dst)
	{
		if (file_exists($dst))
		{
			$this->rrmdir($dst);
		}
		if (is_dir($src))
		{
			mkdir($dst, 0777, true);
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
				$meta = $md_manager->get_metadata('all');
				$available_extension_meta_data[$name] = array(
					'META_DISPLAY_NAME'	=> $md_manager->get_metadata('display-name'),
					'META_VERSION'		=> $meta['version'],
					'U_DELETE'			=> $this->main_link . '&amp;action=delete&amp;ext_name=' . urlencode($name)
				);
			}
			catch(\phpbb\extension\exception $e)
			{
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
		global $phpbb_root_path, $phpEx, $template, $user, $request;

		//$can_upload = (@ini_get('file_uploads') == '0' || strtolower(@ini_get('file_uploads')) == 'off' || !@extension_loaded('zlib')) ? false : true;

		$this->listzip();
		$user->add_lang('posting');  // For error messages
		include($phpbb_root_path . 'includes/functions_upload.' . $phpEx);
		$upload = new \fileupload();
		$upload->set_allowed_extensions(array('zip'));	// Only allow ZIP files

		if (!is_writable($this->ext_dir))
		{
			$this->trigger_error($user->lang['EXT_NOT_WRITABLE'] . $this->back_link, E_USER_WARNING);
			return false;
		}

		$upload_dir = $this->ext_dir;

		// Make sure the ext/ directory exists and if it doesn't, create it
		if (!is_dir($this->ext_dir))
		{
			$this->recursive_mkdir($this->ext_dir);
		}

		// Proceed with the upload
		if ($action == 'upload')
		{
			$file = $upload->form_upload('extupload');
		}
		else if ($action == 'upload_remote')
		{
			$file = $upload->remote_upload($request->variable('remote_upload', ''));
		}

		if($action != 'upload_local')
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
			$dest_file = $phpbb_root_path . 'ext/' . $request->variable('local_upload', '');
		}

		include($phpbb_root_path . 'includes/functions_compress.' . $phpEx);

		$zip = new \ZipArchive;
		$res = $zip->open($dest_file);
		if ($res !== true)
		{
			$this->trigger_error($user->lang['ziperror'][$res] . $this->back_link, E_USER_WARNING);
			return false;
		}
		$zip->extractTo($phpbb_root_path . 'ext/tmp');
		$zip->close();

		$composery = $this->getComposer($phpbb_root_path . 'ext/tmp');
		if (!$composery)
		{
			$this->trigger_error($user->lang['ACP_UPLOAD_EXT_ERROR_COMP'] . $this->back_link, E_USER_WARNING);
			return false;
		}
		$string = file_get_contents($composery);
		$json_a = json_decode($string, true);
		$destination = $json_a['name'];
		if (strpos($destination, '/') === false)
		{
			$this->trigger_error($user->lang['ACP_UPLOAD_EXT_ERROR_DEST'] . $this->back_link, E_USER_WARNING);
			return false;
		}
		$display_name = $json_a['extra']['display-name'];
		if ($json_a['type'] != "phpbb-extension")
		{
			$this->rrmdir($phpbb_root_path . 'ext/tmp');
			if($action != 'upload_local')
			{
				$file->remove();
			}
			$this->trigger_error($user->lang['NOT_AN_EXTENSION'] . $this->back_link, E_USER_WARNING);
			return false;
		}
		$source = substr($composery, 0, -14);
		/* Delete the previous version of extension files - we're able to update them. */
		if (is_dir($phpbb_root_path . 'ext/' . $destination))
		{
			$this->rrmdir($phpbb_root_path . 'ext/' . $destination);
		}
		$this->rcopy($source, $phpbb_root_path . 'ext/' . $destination);
		$this->rrmdir($phpbb_root_path . 'ext/tmp');

		foreach ($json_a['authors'] as $author)
		{
			$template->assign_block_vars('authors', array(
				'AUTHOR'	=> $author['name'],
			));
		}

		$string = @file_get_contents($phpbb_root_path . 'ext/' . $destination . '/README.md');
		if ($string !== false)
		{
			include('../vendor/Markdown/Michelf/MarkdownExtra.inc.php');
			$readme = \Michelf\MarkdownExtra::defaultTransform($string);
		} else {
			$readme = false;
		}
		$template->assign_vars(array(
			'S_UPLOADED'		=> $display_name,
			'FILETREE'			=> $this->php_file_tree($phpbb_root_path . 'ext/' . $destination, $display_name),
			'S_ACTION'			=> $phpbb_root_path . 'adm/index.php?i=acp_extensions&amp;sid=' .$user->session_id . '&amp;mode=main&amp;action=enable_pre&amp;ext_name=' . urlencode($destination),
			'S_ACTION_BACK'		=> $this->main_link,
			'U_ACTION'			=> $this->u_action,
			'README_MARKDOWN'	=> $readme,
			'FILENAME'			=> ($string !== false) ? 'README.md' : '',
			'CONTENT'			=> ($string !== false) ?  highlight_string($string, true): ''
		));

		// Remove the uploaded archive file
		if (($request->variable('keepext', false)) == false && $action != 'upload_local')
		{
			$file->remove();
		}
		return true;
	}

	function php_file_tree($directory, $display_name, $extensions = array())
	{
		global $user;
		$code = $user->lang('ACP_UPLOAD_EXT_CONT', $display_name) . '<br /><br />';
		if(substr($directory, -1) == '/' )
		{
			$directory = substr($directory, 0, strlen($directory) - 1);
		}
		$code .= $this->php_file_tree_dir($directory, $extensions);
		return $code;
	}

	function php_file_tree_dir($directory, $extensions = array(), $first_call = true)
	{
		if (function_exists('scandir'))
		{
			$file = scandir($directory);
		} else {
			$file = php4_scandir($directory);
		}
		natcasesort($file);

		// Make directories first
		$files = $dirs = array();
		foreach($file as $this_file)
		{
			if (is_dir($directory . '/' . $this_file))
			{
				$dirs[] = $this_file;
			} else {
				$files[] = $this_file;
			}
		}
		$file = array_merge($dirs, $files);

		// Filter unwanted extensions
		if (!empty($extensions))
		{
			foreach(array_keys($file) as $key)
			{
				if (!is_dir($directory . '/' . $file[$key]))
				{
					$ext = substr($file[$key], strrpos($file[$key],  '.') + 1);
					if (!in_array($ext, $extensions))
					{
						unset($file[$key]);
					}
				}
			}
		}

		if (count($file) > 2)
		{ // Use 2 instead of 0 to account for . and .. directories
			$php_file_tree = '<ul';
			if ($first_call)
			{
				$php_file_tree .= ' class="php-file-tree"';
				$first_call = false;
			}
			$php_file_tree .= '>';
			foreach($file as $this_file)
			{
				if ($this_file != '.' && $this_file != '..' )
				{
					if (is_dir($directory . '/' . $this_file))
					{
						// Directory
						$php_file_tree .= '<li class="pft-directory"><a href="#">' . htmlspecialchars($this_file) . '</a>';
						$php_file_tree .= $this->php_file_tree_dir($directory . '/' . $this_file, $extensions, false);
						$php_file_tree .= '</li>';
					} else {
						// File
						// Get extension (prepend 'ext-' to prevent invalid classes from extensions that begin with numbers)
						$ext = 'ext-' . substr($this_file, strrpos($this_file, '.') + 1);
						$link = $this->u_action . '&amp;file=' . $directory . '/' . urlencode($this_file);
						$php_file_tree .= '<li class="pft-file ' . strtolower($ext) . '"><a href="javascript:void(0)" onclick="loadXMLDoc(\''. $link . '\')" title="' . $this_file . '">' . htmlspecialchars($this_file) . '</a></li>';
					}
				}
			}
			$php_file_tree .= '</ul>';
		}
		return $php_file_tree;
	}

	/**
	 * @author Michal Nazarewicz (from the php manual)
	 * Creates all non-existant directories in a path
	 * @param $path - path to create
	 * @param $mode - CHMOD the new dir to these permissions
	 * @return bool
	 */
	function recursive_mkdir($path, $mode = false)
	{
		if (!$mode)
		{
			global $config;
			$mode = octdec($config['am_dir_perms']);
		}

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
}
