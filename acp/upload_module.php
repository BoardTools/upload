<?php
/**
 *
 * @package       Upload Extensions
 * @copyright (c) 2014 - 2017 Igor Lavrov (https://github.com/LavIgor) and John Peskens (http://ForumHulp.com)
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
use \boardtools\upload\includes\upload\extension;
use \boardtools\upload\includes\upload\lang;

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

		// Add support for different phpBB branches.
		objects::set_compatibility_class();

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
				'U_MAIN_PAGE_URL' => build_url(
					array('action', 'ajax', 'ajax_time', 'archive', 'ext_name', 'ext_show', 'lang', 'local_upload', 'result')
				),
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
						$md_manager = objects::$compatibility->create_metadata_manager($ext_name);
						load::ajax_confirm_box(false, $user->lang('EXTENSION_DELETE_DATA_CONFIRM', $md_manager->get_metadata('display-name')), build_hidden_fields(array(
							'i'        => $id,
							'mode'     => $mode,
							'action'   => $action,
							'ext_name' => $ext_name,
						)));
					}
					else
					{
						$md_manager = objects::$compatibility->create_metadata_manager($ext_name);
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
				$lang = new lang();
				if ($lang->upload($lang_action, $ext_name, $lang_name))
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
				$extension = new extension();
				$extension->upload($action);
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
				extensions::list_uninstalled_exts();
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
}
