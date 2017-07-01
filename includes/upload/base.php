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

abstract class base
{
	/** @var string Temporary storage path */
	protected $ext_tmp;

	/**
	 * Returns the path to the temporary storage directory.
	 *
	 * @param bool $ext_relative Whether the path should be relative to ext/ directory
	 * @return string
	 */
	protected function get_temp_path($ext_relative = false)
	{
		$ext_path = ($ext_relative) ? '' : objects::$phpbb_root_path . 'ext/';
		return $ext_path . objects::$upload_ext_name . '/tmp/' . (int) objects::$user->data['user_id'];
	}

	/**
	 * Sets the path to the temporary storage directory.
	 *
	 * @param bool $clean Whether we need to delete any previous contents of temporary directory
	 * @return bool Whether the path has been set correctly with no errors
	 */
	protected function set_temp_path($clean = true)
	{
		// We need to use the user ID and the time to escape from problems with simultaneous uploads.
		// We suppose that one user can upload only one extension per session.
		$this->ext_tmp = $this->get_temp_path();

		// Ensure that we don't have any previous files in the working directory.
		if ($clean && is_dir($this->ext_tmp))
		{
			if (!(files::catch_errors(files::rrmdir($this->ext_tmp))))
			{
				return false;
			}
		}

		return true;
	}

	/**
	 * Extracts the specified ZIP file to the temporary storage directory.
	 *
	 * @param string $dest_file Path to ZIP file that we need to extract
	 */
	protected function extract_zip($dest_file)
	{
		if (!class_exists('\compress_zip'))
		{
			include(objects::$phpbb_root_path . 'includes/functions_compress.' . objects::$phpEx);
		}

		$zip = new \compress_zip('r', $dest_file);
		$zip->extract($this->ext_tmp . '/extracted/');
		$zip->close();
	}

	/**
	 * Original copyright information for the function from AutoMOD.
	 * The function was almost totally changed by the authors of Upload Extensions.
	 * @package       automod
	 * @copyright (c) 2008 phpBB Group
	 * @license       http://opensource.org/licenses/gpl-2.0.php GNU Public License
	 *
	 * @param string $action Requested action.
	 * @return \phpbb\files\filespec|\filespec|bool
	 */
	public function proceed_upload($action)
	{
		//$can_upload = (@ini_get('file_uploads') == '0' || strtolower(@ini_get('file_uploads')) == 'off' || !@extension_loaded('zlib')) ? false : true;

		objects::$user->add_lang('posting');  // For error messages
		$upload = objects::$compatibility->get_upload_object();
		$upload->set_allowed_extensions(array('zip'));    // Only allow ZIP files

		// Make sure the ext/ directory exists and if it doesn't, create it
		if (!is_dir(objects::$phpbb_root_path . 'ext'))
		{
			if (!files::catch_errors(files::recursive_mkdir(objects::$phpbb_root_path . 'ext')))
			{
				return false;
			}
		}

		if (!is_writable(objects::$phpbb_root_path . 'ext'))
		{
			files::catch_errors(objects::$user->lang['EXT_NOT_WRITABLE']);
			return false;
		}

		if (!is_dir(objects::$zip_dir))
		{
			if (!files::catch_errors(files::recursive_mkdir(objects::$zip_dir)))
			{
				return false;
			}
		}

		$tmp_dir = objects::$phpbb_root_path . 'ext/' . objects::$upload_ext_name . '/tmp';
		if (!is_writable($tmp_dir))
		{
			if (!phpbb_chmod($tmp_dir, CHMOD_READ | CHMOD_WRITE))
			{
				files::catch_errors(objects::$user->lang['EXT_TMP_NOT_WRITABLE']);
				return false;
			}
		}

		$file = false;

		// Proceed with the upload
		switch ($action)
		{
			case 'upload':
				if (!objects::$request->is_set("extupload", \phpbb\request\request_interface::FILES))
				{
					files::catch_errors(objects::$user->lang['NO_UPLOAD_FILE']);
					return false;
				}
				$file = objects::$compatibility->form_upload($upload);
			break;
			case 'upload_remote':
				$php_ini = new \phpbb\php\ini();
				if (!$php_ini->get_bool('allow_url_fopen'))
				{
					files::catch_errors(objects::$user->lang['EXT_ALLOW_URL_FOPEN_DISABLED']);
					return false;
				}
				$remote_url = objects::$request->variable('remote_upload', '');
				if (!extension_loaded('openssl') && 'https' === substr($remote_url, 0, 5))
				{
					files::catch_errors(objects::$user->lang['EXT_OPENSSL_DISABLED']);
					return false;
				}
				$file = objects::$compatibility->remote_upload($upload, $remote_url);
			break;
		}

		return $file;
	}

	/**
	 * The function that uploads the specified extension.
	 *
	 * @param string                          $action     Requested action.
	 * @param \phpbb\files\filespec|\filespec $file       Filespec object.
	 * @param string                          $upload_dir The directory for zip files storage.
	 * @return string|bool
	 */
	public function get_dest_file($action, $file, $upload_dir)
	{
		if ($action == 'upload_local')
		{
			return $upload_dir . '/' . objects::$request->variable('local_upload', '');
		}

		if (!objects::$compatibility->filespec_get($file, 'filename'))
		{
			files::catch_errors((sizeof($file->error) ? implode('<br />', $file->error) : objects::$user->lang['NO_UPLOAD_FILE']));
			return false;
		}

		if (objects::$compatibility->filespec_get($file, 'init_error') || sizeof($file->error))
		{
			$file->remove();
			files::catch_errors((sizeof($file->error) ? implode('<br />', $file->error) : objects::$user->lang['EXT_UPLOAD_INIT_FAIL']));
			return false;
		}

		$file->clean_filename('real');
		$file->move_file(str_replace(objects::$phpbb_root_path, '', $upload_dir), true, true);

		if (sizeof($file->error))
		{
			$file->remove();
			files::catch_errors(implode('<br />', $file->error));
			return false;
		}
		$dest_file = objects::$compatibility->filespec_get($file, 'destination_file');

		// Make security checks if checksum is provided.
		$checksum = objects::$request->variable('ext_checksum', '');
		if (!empty($checksum))
		{
			$generated_hash = '';
			$checksum_type = objects::$request->variable('ext_checksum_type', 'md5');
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
				files::catch_errors(objects::$user->lang('ERROR_CHECKSUM_MISMATCH', $checksum_type));
				return false;
			}
		}
		objects::$template->assign_var('S_EXTENSION_CHECKSUM_NOT_PROVIDED', empty($checksum));

		return $dest_file;
	}
}
