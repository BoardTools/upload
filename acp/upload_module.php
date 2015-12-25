<?php
/**
 *
 * @package       Upload Extensions
 * @copyright (c) 2014 - 2015 Igor Lavrov (https://github.com/LavIgor) and John Peskens (http://ForumHulp.com)
 * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace boardtools\upload\acp;

use \boardtools\upload\includes\objects;
use \boardtools\upload\includes\functions\files;
use \boardtools\upload\includes\functions\extensions;
use \boardtools\upload\includes\functions\load;
use \boardtools\upload\includes\functions\updater;
use \boardtools\upload\includes\filetree\filetree;
use \boardtools\upload\includes\filetree\filedownload;
use \boardtools\upload\includes\sources\extensions_list;

class upload_module
{
	public $u_action;
	public $tpl_name;
	public $main_link;
	public $back_link;
	public $zip_dir = '';

	function main($id, $mode)
	{
		global $config, $user, $cache, $template, $request, $phpbb_root_path, $phpEx, $phpbb_log, $phpbb_extension_manager, $phpbb_container;

		// General settings for displaying the page.
		$this->page_title = $user->lang['ACP_UPLOAD_EXT_TITLE'];
		$this->tpl_name = 'acp_upload';
		$user->add_lang(array('install', 'acp/extensions', 'migrator'));
		$user->add_lang_ext('boardtools/upload', 'upload');

		// Instead of using new pages we do it here.
		$file = $request->variable('file', '');
		if ($file != '')
		{
			filetree::get_file($file);
		}

		// This is the dir where we will store zip files of extensions.
		$this->zip_dir = $phpbb_root_path . $config['upload_ext_dir'];

		// get any url vars
		$action = $request->variable('action', 'main');

		$this->main_link = $this->u_action;
		$this->back_link = ($request->is_ajax()) ? '' : adm_back_link($this->u_action);
		$template->assign_var('U_ACTION', $this->u_action);

		// The links from phpbb.com does not contain .zip suffix. We need to handle this case.
		$phpbb_link_template = '#^(https://)www.phpbb.com/customise/db/download/([0-9]*?)(/composer|/manual)?/?(\?sid\=[a-zA-Z0-9]*?)?$#i';

		// Work with objects class instead of $this.
		objects::$cache = &$cache;
		objects::$config = &$config;
		objects::$log = &$phpbb_log;
		objects::$phpEx = $phpEx;
		objects::$phpbb_container = &$phpbb_container;
		objects::$phpbb_extension_manager = &$phpbb_extension_manager;
		objects::$phpbb_link_template = $phpbb_link_template;
		objects::$phpbb_root_path = $phpbb_root_path;
		objects::$request = &$request;
		objects::$template = &$template;
		objects::$tpl_name = &$this->tpl_name;
		objects::$u_action = $this->u_action;
		objects::$user = &$user;
		objects::$zip_dir = &$this->zip_dir;

		// Get the information about Upload Extensions - START
		objects::$upload_ext_name = 'boardtools/upload';
		updater::get_manager();
		// Get the information about Upload Extensions - END

		// Detect whether this is an Ajax request - START
		$ajax_action = $request->variable('ajax_action', '');
		objects::$is_ajax = false;
		if ($request->is_ajax() && !empty($ajax_action))
		{
			$template->assign_vars(array(
				'HAS_AJAX' => true,
				'IS_AJAX'  => true,
			));
			objects::$is_ajax = true;
			switch ($ajax_action)
			{
				case 'list_from_cdb':
				case 'main':
					$this->tpl_name = 'acp_upload_main';
				break;
				case 'set_config_force_unstable':
					$ajax_action = 'set_config_version_check_force_unstable';
				// no break
				case 'list':
					$this->tpl_name = 'acp_upload_list';
				break;
				case 'local_upload':
					$ajax_action = 'upload';
				// no break
				case 'upload_language':
				case 'upload':
				case 'force_update':
				case 'enable':
				case 'disable':
				case 'purge':
				case 'restore_languages':
				case 'faq':
				case 'details':
					$this->tpl_name = 'acp_upload_details';
				break;
				case 'zip_packages':
					$this->tpl_name = 'acp_upload_zip_packages';
				break;
				case 'uninstalled':
					$this->tpl_name = 'acp_upload_uninstalled';
				break;
				case 'versioncheck_force':
					extensions::ajax_versioncheck($request->variable('ext_name', ''));
				break;
			}
			$action = $ajax_action;

			/*
			 * Do not output anything (including errors) besides the result object.
			 * Errors can still be shown in nice box.
			 * Do it here - page-specific actions go below.
			 */
			ob_start();
		}
		else
		{
			$template->assign_vars(array(
				'S_LOAD_ACTION'   => $action,
				'U_MAIN_PAGE_URL' => build_url(array('action', 'ajax', 'ext_name', 'ext_show')),
			));

			if ($request->variable('ajax', 0) === 1)
			{
				// Only needed to correctly load the template.
				$template->assign_var('HAS_AJAX', true);
			}
		}
		// Detect whether this is an Ajax request - END

		$original_action = $action;

		switch ($action)
		{
			case 'details':
				$ext_name = $request->variable('ext_name', objects::$upload_ext_name);
				$ext_show = $request->variable('ext_show', '');
				load::details($ext_name, $ext_show);
			break;

			case 'faq':
				load::details(objects::$upload_ext_name, 'faq');
			break;

			case 'enable':
				$ext_name = $request->variable('ext_name', '');
				extensions::enable($ext_name);
			break;

			case 'disable':
				$ext_name = $request->variable('ext_name', '');
				extensions::disable($ext_name);
			break;

			case 'purge':
				$ext_name = $request->variable('ext_name', '');
				// Check the link hash for the case of forced updates. An additional safety layer.
				$check_link_hash = check_link_hash($request->variable('hash', ''), 'purge.' . $ext_name);
				if ((objects::$is_ajax && load::ajax_confirm_box(true)) || ($check_link_hash) || confirm_box(true))
				{
					extensions::purge($ext_name);
				}
				else
				{
					if (objects::$is_ajax)
					{
						$md_manager = objects::$phpbb_extension_manager->create_extension_metadata_manager($ext_name, objects::$template);
						load::ajax_confirm_box(false, $user->lang('EXTENSION_DELETE_DATA_CONFIRM', $md_manager->get_metadata('display-name')), build_hidden_fields(array(
							'i'        => $id,
							'mode'     => $mode,
							'action'   => $action,
							'ext_name' => $ext_name,
						)));
					}
					else
					{
						$md_manager = objects::$phpbb_extension_manager->create_extension_metadata_manager($ext_name, objects::$template);
						confirm_box(false, $user->lang('EXTENSION_DELETE_DATA_CONFIRM', $md_manager->get_metadata('display-name')), build_hidden_fields(array(
							'i'        => $id,
							'mode'     => $mode,
							'action'   => $action,
							'ext_name' => $ext_name,
						)));
					}
				}
			break;

			case 'restore_languages':
				$ext_name = $request->variable('ext_name', '');
				$zip_file = $request->variable('archive', '');
				extensions::restore_languages($ext_name, $zip_file);
				load::details($ext_name, 'details');
			break;

			case 'upload_language':
				$lang_action = 'upload';
				/* If we unpack a zip file - ensure that we work locally */
				if (($request->variable('local_upload', '')) != '')
				{
					$lang_action = 'upload_local';
				}
				else
				{
					if (strpos($request->variable('remote_upload', ''), 'http://') === 0 || strpos($request->variable('remote_upload', ''), 'https://') === 0)
					{
						$lang_action = 'upload_remote';
					}
				}
				$ext_name = $request->variable('ext_name', '');
				$lang_name = $request->variable('ext_lang_name', '');
				if ($this->upload_lang($lang_action, $ext_name, $lang_name))
				{
					load::details($ext_name, 'languages');
				}
			break;

			case 'upload':
				/* If we unpack a zip file - ensure that we work locally */
				if (($request->variable('local_upload', '')) != '')
				{
					$action = 'upload_local';
				}
				else
				{
					if (strpos($request->variable('remote_upload', ''), 'http://') === 0 || strpos($request->variable('remote_upload', ''), 'https://') === 0)
					{
						$action = 'upload_remote';
					}
				}
			// no break

			case 'force_update':
				$this->upload_ext($action);
				$template->assign_vars(array(
					'U_UPLOAD'       => $this->main_link . '&amp;action=upload',
					'S_FORM_ENCTYPE' => ' enctype="multipart/form-data"',
				));
			break;

			case 'zip_packages':
				if (($result = $request->variable('result', '')) == 'deleted' || $result == 'deleted1')
				{
					$template->assign_var('EXT_ZIPS_DELETED', $user->lang('EXT_ZIP' . (($result == 'deleted') ? 'S' : '') . '_DELETE_SUCCESS'));
				}
				load::zip_files();
				$template->assign_vars(array(
					'S_ZIP_PACKAGES'  => true,
					'U_DELETE_ACTION' => objects::$u_action . "&amp;action=delete_zip",
				));
			break;

			case 'uninstalled':
				if (($result = $request->variable('result', '')) == 'deleted' || $result == 'deleted1')
				{
					$template->assign_var('EXTS_DELETED', $user->lang('EXT' . (($result == 'deleted') ? 'S' : '') . '_DELETE_SUCCESS'));
				}
				extensions::list_available_exts($phpbb_extension_manager);
				$template->assign_vars(array(
					'S_UNINSTALLED'   => true,
					'U_DELETE_ACTION' => objects::$u_action . "&amp;action=delete_ext",
				));
			break;

			case 'download':
				$zip_name = $request->variable('zip_name', '');
				$ext_name = $request->variable('ext_name', '');
				if ($zip_name != '')
				{
					$download_name = substr($zip_name, 0, -4);
					// Ensure that downloads can be done only from the $zip_dir directory.
					$download_name = str_replace('../', '', $download_name);
					$filename = objects::$zip_dir . '/' . $download_name;

					$mimetype = 'application/zip';

					if (!(filedownload::download_file($filename, $download_name, $mimetype)))
					{
						redirect($this->main_link);
					}
				}
				else
				{
					if ($ext_name != '')
					{
						if (!extensions::download_extension($ext_name))
						{
							files::catch_errors($user->lang('EXT_DOWNLOAD_ERROR', $ext_name));
						}
					}
					else
					{
						redirect($this->main_link);
					}
				}
			break;

			case 'set_config_version_check_force_unstable':
				if ((objects::$is_ajax && load::ajax_confirm_box(true)) || confirm_box(true))
				{
					objects::$config->set('extension_force_unstable', true);
					if (objects::$is_ajax)
					{
						$output = new \phpbb\json_response();
						$output->send(array(
							'status' => 'success'
						));
					}
					else
					{
						objects::$template->assign_var('FORCE_UNSTABLE_UPDATED', true);
					}
				}
				else
				{
					$force_unstable = objects::$request->variable('force_unstable', 0);

					if ($force_unstable)
					{
						$s_hidden_fields = build_hidden_fields(array(
							'i'              => $id,
							'mode'           => $mode,
							'action'         => $action,
							'force_unstable' => $force_unstable,
						));

						if (objects::$is_ajax)
						{
							load::ajax_confirm_box(false, objects::$user->lang('EXTENSION_FORCE_UNSTABLE_CONFIRM'), $s_hidden_fields);
						}
						else
						{
							confirm_box(false, objects::$user->lang('EXTENSION_FORCE_UNSTABLE_CONFIRM'), $s_hidden_fields);
						}
						break;
					}
					else
					{
						objects::$config->set('extension_force_unstable', false);
						if (objects::$is_ajax)
						{
							$output = new \phpbb\json_response();
							$output->send(array(
								'status' => 'success'
							));
						}
						else
						{
							objects::$template->assign_var('FORCE_UNSTABLE_UPDATED', true);
						}
					}
				}
			// no break

			case 'list':
				extensions::list_all_exts();

				objects::$template->assign_vars(array(
					'S_EXT_LIST'           => true,
					'U_VERSIONCHECK_FORCE' => objects::$u_action . '&amp;action=list&amp;versioncheck_force=1',
					'FORCE_UNSTABLE'       => $config['extension_force_unstable'],
					'SET_FORCE_UNSTABLE'   => objects::$request->variable('set_force_unstable', false),
					'U_ACTION_LIST'        => objects::$u_action . '&amp;action=list',
				));

				add_form_key('version_check_settings');
			break;

			case 'delete_ext':
			case 'delete_zip':
				$ext_name = $request->variable('ext_name', '', true);
				$zip_name = $request->variable('zip_name', '', true);
				$marked = $request->variable('mark', array(''), true);
				$deletemark = $request->variable('delmarked', false, false, \phpbb\request\request_interface::POST);

				if ($action == 'delete_ext' && $ext_name != '')
				{
					$marked = array(0 => $ext_name);
				}
				else
				{
					if ($action == 'delete_zip' && $zip_name != '')
					{
						$marked = array(0 => $zip_name);
					}
				}

				if (sizeof($marked))
				{
					if ($action == 'delete_ext')
					{
						if (confirm_box(true))
						{
							$no_errors = true;
							foreach ($marked as $ext_number => $ext_name)
							{
								// Ensure that we can delete extensions only in ext/ directory.
								$ext_name = str_replace('.', '', $ext_name);
								if (substr_count($ext_name, '/') === 1 && is_dir($phpbb_root_path . 'ext/' . $ext_name))
								{
									$dir = substr($ext_name, 0, strpos($ext_name, '/'));
									$extensions = sizeof(glob($phpbb_root_path . 'ext/' . $dir . '/*'));
									$dir = ($extensions === 1) ? $dir : $ext_name;
									$no_errors = files::rrmdir($phpbb_root_path . 'ext/' . $dir, true); // No catching here.
								}
							}
							if ($no_errors)
							{
								if ($request->is_ajax())
								{
									trigger_error($user->lang('EXT' . ((sizeof($marked) > 1) ? 'S' : '') . '_DELETE_SUCCESS'));
								}
								else
								{
									redirect(objects::$u_action . '&amp;action=uninstalled&amp;result=deleted' . ((sizeof($marked) > 1) ? '' : '1'));
								}
							}
							else
							{
								trigger_error($user->lang['EXT_DELETE_ERROR'] . $this->back_link, E_USER_WARNING);
							}
						}
						else
						{
							$confirm_text = (sizeof($marked) > 1) ? $user->lang('EXTENSIONS_DELETE_CONFIRM', sizeof($marked)) : $user->lang('EXTENSION_DELETE_CONFIRM', $marked[0]);
							confirm_box(false, $confirm_text, build_hidden_fields(array(
								'i'         => $id,
								'mode'      => $mode,
								'action'    => $action,
								'mark'      => $marked,
								'delmarked' => $deletemark,
							)));
						}
					}
					else
					{
						if ($action == 'delete_zip')
						{
							if (confirm_box(true))
							{
								$no_errors = true;
								foreach ($marked as $zip_number => $zip_name)
								{
									// No catching here.
									$no_errors = files::rrmdir(objects::$zip_dir . '/' . substr($zip_name, 0, -4) . '.zip', true);
								}
								if ($no_errors)
								{
									if ($request->is_ajax())
									{
										trigger_error($user->lang('EXT_ZIP' . ((sizeof($marked) > 1) ? 'S' : '') . '_DELETE_SUCCESS'));
									}
									else
									{
										redirect(objects::$u_action . '&amp;action=zip_packages&amp;result=deleted' . ((sizeof($marked) > 1) ? '' : '1'));
									}
								}
								else
								{
									trigger_error($user->lang['EXT_ZIP_DELETE_ERROR'] . $this->back_link, E_USER_WARNING);
								}
							}
							else
							{
								$confirm_text = (sizeof($marked) > 1) ? $user->lang('EXTENSIONS_ZIP_DELETE_CONFIRM', sizeof($marked)) : $user->lang('EXTENSION_ZIP_DELETE_CONFIRM', $marked[0]);
								confirm_box(false, $confirm_text, build_hidden_fields(array(
									'i'         => $id,
									'mode'      => $mode,
									'action'    => $action,
									'mark'      => $marked,
									'delmarked' => $deletemark,
								)));
							}
						}
					}
				}
				else
				{
					files::catch_errors($user->lang['EXT_DELETE_NO_FILE']);
				}
			break;

			case 'delete_language':
				$ext_name = $request->variable('ext_name', '', true);
				$marked = $request->variable('mark', array(''), true);
				$deletemark = $request->variable('delmarked', false, false, \phpbb\request\request_interface::POST);

				if (sizeof($marked) && !empty($ext_name))
				{
					if (confirm_box(true))
					{
						$no_errors = false;
						foreach ($marked as $lang_number => $lang_name)
						{
							// Ensure that we can delete extensions only in ext/ directory.
							$ext_name = str_replace('.', '', $ext_name);
							$lang_name = str_replace('.', '', $lang_name);
							$lang_dir = $phpbb_root_path . 'ext/' . $ext_name . '/language/' . $lang_name;
							if (substr_count($ext_name, '/') === 1 && !empty($lang_name) && is_dir($lang_dir))
							{
								$no_errors = files::rrmdir($lang_dir, true); // No catching here.
							}
						}
						if ($no_errors)
						{
							if ($request->is_ajax())
							{
								$result_text = $user->lang('EXT_LANGUAGE' . ((sizeof($marked) > 1) ? 'S' : '') . '_DELETE_SUCCESS');
								if ($ext_name === objects::$upload_ext_name && in_array(objects::$user->lang_name, $marked))
								{
									$json_response = new \phpbb\json_response;
									$json_response->send(array(
										'MESSAGE_TITLE' => $user->lang['INFORMATION'],
										'MESSAGE_TEXT'  => $result_text,
										'REFRESH_DATA'  => array(
											'time' => 3,
											'url'  => redirect(objects::$u_action . '&amp;action=details&amp;ext_show=languages&amp;ajax=1', true)
										)
									));
								}
								else
								{
									trigger_error($result_text);
								}
							}
							else
							{
								redirect(objects::$u_action . '&amp;action=details&amp;ext_name=' . urlencode($ext_name) . '&amp;ext_show=languages&amp;result=deleted' . ((sizeof($marked) > 1) ? '' : '1'));
							}
						}
						else
						{
							trigger_error($user->lang['EXT_LANGUAGE_DELETE_ERROR'] . $this->back_link, E_USER_WARNING);
						}
					}
					else
					{
						$confirm_text = (sizeof($marked) > 1) ? $user->lang('EXT_LANGUAGES_DELETE_CONFIRM', sizeof($marked)) : $user->lang('EXT_LANGUAGE_DELETE_CONFIRM', $marked[0]);
						confirm_box(false, $confirm_text, build_hidden_fields(array(
							'i'         => $id,
							'mode'      => $mode,
							'action'    => $action,
							'ext_name'  => $ext_name,
							'mark'      => $marked,
							'delmarked' => $deletemark,
						)));
					}
				}
				else
				{
					files::catch_errors($user->lang['EXT_DELETE_NO_FILE']);
				}
			break;

			case 'list_from_cdb':
				objects::$template->assign_var('S_SHOW_VALID_PHPBB_EXTENSIONS', true);
				$this->get_valid_extensions();
			// no break

			case 'main':
			default:
				$template->assign_vars(array(
					'U_UPLOAD'       => $this->main_link . '&amp;action=upload',
					'S_FORM_ENCTYPE' => ' enctype="multipart/form-data"',
				));
			break;
		}

		if ($this->catch_errors() && objects::$is_ajax)
		{
			$this->output_response('error', $original_action);
		}
		else
		{
			if (objects::$is_ajax)
			{
				$this->output_response('success', $original_action);
			}
		}
	}

	public function get_valid_extensions()
	{
		$packages = extensions_list::getPackages();
		if (sizeof($packages))
		{
			// Sanitize any data we retrieve from a server
			$packages = objects::$request->escape($packages, true);
			foreach ($packages as $ext => $value)
			{
				$latest_release = reset($value);

				if (isset($latest_release['dist']) && isset($latest_release['dist']['url']))
				{
					$download_link = $latest_release['dist']['url'];
				}
				else
				{
					continue;
				}

				$display_name = $latest_release['display_name'];
				$description = (isset($latest_release['description'])) ? $latest_release['description'] : '';
				$homepage_link = (isset($latest_release['homepage'])) ? $latest_release['homepage'] : '';
				$shasum = (isset($latest_release['dist']['shasum'])) ? $latest_release['dist']['shasum'] : '';

				$require_phpbb = (isset($latest_release['extra']['soft-require']['phpbb/phpbb'])) ? $latest_release['extra']['soft-require']['phpbb/phpbb'] : '';
				$require_php = (isset($latest_release['require']['php'])) ? $latest_release['require']['php'] : '';

				objects::$template->assign_block_vars("phpbb_cdb", array(
					'EXT_NAME'             => $display_name,
					'EXT_VERSION'          => key($value),
					'EXT_DOWNLOAD'         => $download_link,
					'EXT_DOWNLOAD_ENCODED' => urlencode($download_link),
					'EXT_DESCRIPTION'      => $description,
					'EXT_HOMEPAGE'         => $homepage_link,
					'EXT_CHECKSUM'         => $shasum,
					'REQUIRE_PHPBB'        => $require_phpbb,
					'REQUIRE_PHPBB_STATUS' => !empty($require_phpbb),
					'REQUIRE_PHP'          => $require_php,
					'REQUIRE_PHP_STATUS'   => !empty($require_php),
				));
			}
		}
	}

	/**
	 * Displays the special template in a case of errors.
	 *
	 * @return bool Whether there are any errors.
	 */
	protected function catch_errors()
	{
		if (files::$catched_errors)
		{
			if (objects::$request->is_ajax())
			{
				$this->tpl_name = 'acp_upload_error';
			}
			else
			{
				objects::$template->assign_vars(array(
					'S_EXT_ERROR'   => true,
					'S_LOAD_ACTION' => 'error',
				));
			}
			objects::$template->assign_var('S_ACTION_BACK', objects::$u_action);
			return true;
		}
		return false;
	}

	/**
	 * Outputs the page as Ajax response.
	 *
	 * @param string $status Page status.
	 * @param string $action Page action.
	 */
	protected function output_response($status, $action)
	{
		adm_page_header('');
		$output = ob_get_contents();
		@ob_end_clean();
		$json_response = new \phpbb\json_response();
		$json_response->send(array(
			'status' => $status,
			'action' => $action,
			'result' => objects::$template->assign_display($this->tpl_name . '.html', '', true),
			'output' => $output,
		));
	}

	/**
	 * Original copyright information for the function from AutoMOD.
	 * The function was almost totally changed by the authors of Upload Extensions.
	 * @package       automod
	 * @copyright (c) 2008 phpBB Group
	 * @license       http://opensource.org/licenses/gpl-2.0.php GNU Public License
	 *
	 * @param string $action Requested action.
	 * @return \filespec|bool
	 */
	public function proceed_upload($action)
	{
		global $phpbb_root_path, $phpEx, $user, $request;

		//$can_upload = (@ini_get('file_uploads') == '0' || strtolower(@ini_get('file_uploads')) == 'off' || !@extension_loaded('zlib')) ? false : true;

		$user->add_lang('posting');  // For error messages
		if (!class_exists('\fileupload'))
		{
			include($phpbb_root_path . 'includes/functions_upload.' . $phpEx);
		}
		$upload = new \fileupload();
		$upload->set_allowed_extensions(array('zip'));    // Only allow ZIP files

		// Make sure the ext/ directory exists and if it doesn't, create it
		if (!is_dir($phpbb_root_path . 'ext'))
		{
			if (!files::catch_errors(files::recursive_mkdir($phpbb_root_path . 'ext')))
			{
				return false;
			}
		}

		if (!is_writable($phpbb_root_path . 'ext'))
		{
			files::catch_errors($user->lang['EXT_NOT_WRITABLE']);
			return false;
		}

		if (!is_dir(objects::$zip_dir))
		{
			if (!files::catch_errors(files::recursive_mkdir(objects::$zip_dir)))
			{
				return false;
			}
		}

		if (!is_writable($phpbb_root_path . 'ext/' . objects::$upload_ext_name . '/tmp'))
		{
			if (!phpbb_chmod($phpbb_root_path . 'ext/' . objects::$upload_ext_name . '/tmp', CHMOD_READ | CHMOD_WRITE))
			{
				files::catch_errors($user->lang['EXT_TMP_NOT_WRITABLE']);
				return false;
			}
		}

		$file = false;

		// Proceed with the upload
		if ($action == 'upload')
		{
			if (!$request->is_set("extupload", \phpbb\request\request_interface::FILES))
			{
				files::catch_errors($user->lang['NO_UPLOAD_FILE']);
				return false;
			}
			$file = $upload->form_upload('extupload');
		}
		else
		{
			if ($action == 'upload_remote')
			{
				$php_ini = new \phpbb\php\ini();
				if (!$php_ini->get_bool('allow_url_fopen'))
				{
					files::catch_errors($user->lang['EXT_ALLOW_URL_FOPEN_DISABLED']);
					return false;
				}
				$remote_url = $request->variable('remote_upload', '');
				if (!extension_loaded('openssl') && 'https' === substr($remote_url, 0, 5))
				{
					files::catch_errors($user->lang['EXT_OPENSSL_DISABLED']);
					return false;
				}
				$file = files::remote_upload($upload, $user, $remote_url);
			}
		}
		return $file;
	}

	/**
	 * The function that uploads the specified extension.
	 *
	 * @param string    $action     Requested action.
	 * @param \filespec $file       Filespec object.
	 * @param string    $upload_dir The directory for zip files storage.
	 * @return string|bool
	 */
	public function get_dest_file($action, $file, $upload_dir)
	{
		global $phpbb_root_path, $template, $user, $request;
		if ($action != 'upload_local')
		{
			if (empty($file->filename))
			{
				files::catch_errors((sizeof($file->error) ? implode('<br />', $file->error) : $user->lang['NO_UPLOAD_FILE']));
				return false;
			}
			else
			{
				if ($file->init_error || sizeof($file->error))
				{
					$file->remove();
					files::catch_errors((sizeof($file->error) ? implode('<br />', $file->error) : $user->lang['EXT_UPLOAD_INIT_FAIL']));
					return false;
				}
			}

			$file->clean_filename('real');
			$file->move_file(str_replace($phpbb_root_path, '', $upload_dir), true, true);

			if (sizeof($file->error))
			{
				$file->remove();
				files::catch_errors(implode('<br />', $file->error));
				return false;
			}
			$dest_file = $file->destination_file;
		}
		else
		{
			$dest_file = $upload_dir . '/' . $request->variable('local_upload', '');
		}

		if ($action != 'upload_local')
		{
			// Make security checks if checksum is provided.
			$checksum = $request->variable('ext_checksum', '');
			if (!empty($checksum))
			{
				$generated_hash = '';
				$checksum_type = $request->variable('ext_checksum_type', 'md5');
				switch ($checksum_type)
				{
					case 'sha1':
						$generated_hash = sha1_file($dest_file);
					break;
					case 'md5':
						$generated_hash = md5_file($dest_file);
					break;
				}
				if (strtolower($checksum) !== strtolower($generated_hash))
				{
					$file->remove();
					files::catch_errors($user->lang('ERROR_CHECKSUM_MISMATCH', $checksum_type));
					return false;
				}
			}
			$template->assign_var('S_EXTENSION_CHECKSUM_NOT_PROVIDED', empty($checksum));
		}
		return $dest_file;
	}

	/**
	 * The function that uploads the specified extension.
	 *
	 * @param string $action Requested action.
	 * @return bool
	 */
	public function upload_ext($action)
	{
		global $phpbb_root_path, $phpEx, $phpbb_log, $phpbb_extension_manager, $template, $user, $request;

		$file = $this->proceed_upload($action);
		if (!$file && $action != 'upload_local')
		{
			files::catch_errors($user->lang['EXT_UPLOAD_ERROR']);
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
				files::catch_errors($user->lang['EXT_UPLOAD_ERROR']);
				return false;
			}
			// We need to use the user ID and the time to escape from problems with simultaneous uploads.
			// We suppose that one user can upload only one extension per session.
			$ext_tmp = objects::$upload_ext_name . '/tmp/' . (int) $user->data['user_id'];
			// Ensure that we don't have any previous files in the working directory.
			if (is_dir($phpbb_root_path . 'ext/' . $ext_tmp))
			{
				if (!(files::catch_errors(files::rrmdir($phpbb_root_path . 'ext/' . $ext_tmp))))
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
			$zip->extract($phpbb_root_path . 'ext/' . $ext_tmp . '/');
			$zip->close();

			$composery = files::getComposer($phpbb_root_path . 'ext/' . $ext_tmp);
			if (!$composery)
			{
				files::catch_errors(files::rrmdir($phpbb_root_path . 'ext/' . $ext_tmp));
				if ($action != 'upload_local')
				{
					$file->remove();
				}
				files::catch_errors($user->lang['ACP_UPLOAD_EXT_ERROR_COMP']);
				return false;
			}
			$string = @file_get_contents($composery);
			if ($string === false)
			{
				files::catch_errors(files::rrmdir($phpbb_root_path . 'ext/' . $ext_tmp));
				if ($action != 'upload_local')
				{
					$file->remove();
				}
				files::catch_errors($user->lang['EXT_UPLOAD_ERROR']);
				return false;
			}
			$json_a = json_decode($string, true);
			$destination = (isset($json_a['name'])) ? $json_a['name'] : '';
			$destination = str_replace('.', '', $destination);
			$ext_version = (isset($json_a['version'])) ? $json_a['version'] : '0.0.0';
			if (strpos($destination, '/') === false)
			{
				files::catch_errors(files::rrmdir($phpbb_root_path . 'ext/' . $ext_tmp));
				if ($action != 'upload_local')
				{
					$file->remove();
				}
				files::catch_errors($user->lang['ACP_UPLOAD_EXT_ERROR_DEST']);
				return false;
			}
			else
			{
				if (strpos($destination, objects::$upload_ext_name) !== false)
				{
					files::catch_errors(files::rrmdir($phpbb_root_path . 'ext/' . $ext_tmp));
					if ($action != 'upload_local')
					{
						$file->remove();
					}
					files::catch_errors($user->lang['ACP_UPLOAD_EXT_ERROR_TRY_SELF']);
					return false;
				}
			}
			$display_name = (isset($json_a['extra']['display-name'])) ? $json_a['extra']['display-name'] : $destination;
			if (!isset($json_a['type']) || $json_a['type'] != "phpbb-extension")
			{
				files::catch_errors(files::rrmdir($phpbb_root_path . 'ext/' . $ext_tmp));
				if ($action != 'upload_local')
				{
					$file->remove();
				}
				files::catch_errors($user->lang['NOT_AN_EXTENSION']);
				return false;
			}
			$source = substr($composery, 0, -14);
			$source_for_check = $ext_tmp . '/' . $destination;
			// At first we need to change the directory structure to something like ext/tmp/vendor/extension.
			// We need it to escape from problems with dots on validation.
			if ($source != $phpbb_root_path . 'ext/' . $source_for_check)
			{
				if (!(files::catch_errors(files::rcopy($source, $phpbb_root_path . 'ext/' . $source_for_check))))
				{
					files::catch_errors(files::rrmdir($phpbb_root_path . 'ext/' . $ext_tmp));
					if ($action != 'upload_local')
					{
						$file->remove();
					}
					return false;
				}
				$source = $phpbb_root_path . 'ext/' . $source_for_check;
			}
			// Validate the extension to check if it can be used on the board.
			$md_manager = $phpbb_extension_manager->create_extension_metadata_manager($source_for_check, $template);
			try
			{
				if ($md_manager->get_metadata() === false || $md_manager->validate_require_phpbb() === false || $md_manager->validate_require_php() === false)
				{
					files::catch_errors(files::rrmdir($phpbb_root_path . 'ext/' . $ext_tmp));
					if ($action != 'upload_local')
					{
						$file->remove();
					}
					files::catch_errors($user->lang['EXTENSION_NOT_AVAILABLE']);
					return false;
				}
			}
			catch (\phpbb\extension\exception $e)
			{
				files::catch_errors(files::rrmdir($phpbb_root_path . 'ext/' . $ext_tmp));
				if ($action != 'upload_local')
				{
					$file->remove();
				}
				files::catch_errors($e . ' ' . $user->lang['ACP_UPLOAD_EXT_ERROR_NOT_SAVED']);
				return false;
			}

			// Save/remove the uploaded archive file.
			if ($action != 'upload_local')
			{
				if (($request->variable('keepext', false)) == false)
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
			$ext_tmp = objects::$upload_ext_name . '/tmp/' . (int) $user->data['user_id'];
			if (!is_dir($phpbb_root_path . 'ext/' . $ext_tmp) || !($composery = files::getComposer($phpbb_root_path . 'ext/' . $ext_tmp)) || !($string = @file_get_contents($composery)))
			{
				files::catch_errors($user->lang['ACP_UPLOAD_EXT_WRONG_RESTORE']);
				return false;
			}
			$json_a = json_decode($string, true);
			$destination = (isset($json_a['name'])) ? $json_a['name'] : '';
			$destination = str_replace('.', '', $destination);
			if (strpos($destination, '/') === false)
			{
				files::catch_errors($user->lang['ACP_UPLOAD_EXT_WRONG_RESTORE']);
				return false;
			}
			$source = substr($composery, 0, -14);
		}
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
						$template->assign_var('S_NEXT_STEP', objects::$user->lang['EXTENSION_DISABLE_IN_PROGRESS']);

						// No need to specify the name of the extension. We suppose that it is the one in ext/tmp/USER_ID folder.
						if ($request->is_ajax())
						{
							$response_object = new \phpbb\json_response;
							$response_object->send(array("FORCE_UPDATE" => true));
						}
						else
						{
							meta_refresh(0, $this->main_link . '&amp;action=force_update');
						}
						return false;
					}
				}
				$phpbb_log->add('admin', $user->data['user_id'], $user->ip, 'LOG_EXT_DISABLE', time(), array($destination));
				$made_update = true;
			}
			$old_ext_name = $destination;
			if ($old_composery = files::getComposer($phpbb_root_path . 'ext/' . $destination))
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
			$saved_zip_file = $request->escape($saved_zip_file, true);
			$template->assign_var('EXT_OLD_ZIP_SAVED', objects::$user->lang('EXT_SAVED_OLD_ZIP', $saved_zip_file));
			// Check languages missing in the new version.
			$old_langs = files::get_languages($phpbb_root_path . 'ext/' . $destination . '/language');
			$new_langs = files::get_languages($source . '/language');
			$old_langs = array_diff($old_langs, $new_langs);
			if (sizeof($old_langs))
			{
				$last_lang = array_pop($old_langs);
				$template->assign_vars(array(
					'S_EXT_LANGS_RESTORE_ZIP' => urlencode($saved_zip_file),
					'EXT_RESTORE_DIRECTORIES' => (sizeof($old_langs)) ? objects::$user->lang('EXT_RESTORE_LANGUAGES', '<strong>' . implode('</strong>, <strong>', $old_langs) . '</strong>', "<strong>$last_lang</strong>") : objects::$user->lang('EXT_RESTORE_LANGUAGE', "<strong>$last_lang</strong>"),
				));
			}
			if (!(files::catch_errors(files::rrmdir($phpbb_root_path . 'ext/' . $destination))))
			{
				return false;
			}
		}
		if (!(files::catch_errors(files::rcopy($source, $phpbb_root_path . 'ext/' . $destination))))
		{
			files::catch_errors(files::rrmdir($phpbb_root_path . 'ext/' . $ext_tmp));
			return false;
		}
		// No enabling at this stage. Admins should have a chance to revise the uploaded scripts.
		if (!(files::catch_errors(files::rrmdir($phpbb_root_path . 'ext/' . $ext_tmp))))
		{
			return false;
		}

		load::details($destination, (($made_update) ? 'updated' : 'uploaded'));

		return true;
	}

	/**
	 * The function that uploads the specified language package for the extension.
	 *
	 * @param string $action    Requested action.
	 * @param string $ext_name  The name of the extension.
	 * @param string $lang_name The ISO code of the language.
	 * @return bool
	 */
	public function upload_lang($action, $ext_name, $lang_name)
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
