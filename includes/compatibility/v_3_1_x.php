<?php
/**
 *
 * @package       Upload Extensions
 * @copyright (c) 2014 - 2017 Igor Lavrov (https://github.com/LavIgor) and John Peskens (http://ForumHulp.com)
 * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace boardtools\upload\includes\compatibility;

use \boardtools\upload\includes\objects;

class v_3_1_x implements base
{
	/**
	 * {@inheritdoc}
	 */
	public function init()
	{
		return;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_exception_message($e)
	{
		return $e;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_faq()
	{
		objects::$user->add_lang_ext('boardtools/upload', 'upload', false, true);
		return objects::$user->help;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_upload_object()
	{
		if (!class_exists('\fileupload'))
		{
			include(objects::$phpbb_root_path . 'includes/functions_upload.' . objects::$phpEx);
		}
		return new \fileupload();
	}

	/**
	 * {@inheritdoc}
	 */
	public function form_upload($upload)
	{
		return $upload->form_upload('extupload');
	}

	/**
	 * Remote upload method
	 * Uploads file from given url
	 *
	 * @param \fileupload             $upload           Files object
	 * @param string                  $remote_url       URL pointing to file to upload, for example http://www.foobar.com/example.gif
	 * @param \phpbb\mimetype\guesser $mimetype_guesser Mimetype guesser
	 * @return object $file Object "filespec" is returned, all further operations can be done with this object
	 */
	public function remote_upload($upload, $remote_url, \phpbb\mimetype\guesser $mimetype_guesser = null)
	{
		$upload_ary = array();
		$upload_ary['local_mode'] = true;

		$upload_from_phpbb = preg_match(objects::$phpbb_link_template, $remote_url, $match_phpbb);

		if (!preg_match('#^(https?://).*?\.(' . implode('|', $upload->allowed_extensions) . ')$#i', $remote_url, $match) && !$upload_from_phpbb)
		{
			$file = new \fileerror(objects::$user->lang[$upload->error_prefix . 'URL_INVALID']);
			return $file;
		}

		if (empty($match[2]) && empty($match_phpbb[2]))
		{
			$file = new \fileerror(objects::$user->lang[$upload->error_prefix . 'URL_INVALID']);
			return $file;
		}

		$url = parse_url($remote_url);

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

		$remote_max_filesize = $upload->max_filesize;
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

		if (!($fsock = @fopen($remote_url, "r")))
		{
			$file = new \fileerror(objects::$user->lang[$upload->error_prefix . 'NOT_UPLOADED']);
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
		$timer_stop = time() + $upload->upload_timeout;

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

				$file = new \fileerror(sprintf(objects::$user->lang[$upload->error_prefix . 'WRONG_FILESIZE'], $max_filesize['value'], $max_filesize['unit']));
				return $file;
			}

			$data .= $block;

			// Cancel upload if we exceed timeout
			if (time() >= $timer_stop)
			{
				$file = new \fileerror(objects::$user->lang[$upload->error_prefix . 'REMOTE_UPLOAD_TIMEOUT']);
				return $file;
			}
		}
		@fclose($fsock);

		if (empty($data))
		{
			$file = new \fileerror(objects::$user->lang[$upload->error_prefix . 'EMPTY_REMOTE_DATA']);
			return $file;
		}

		$tmp_path = (@is_writable('/tmp/')) ? '/tmp/' : objects::$phpbb_root_path . 'cache/';
		$filename = tempnam($tmp_path, unique_id() . '-');

		if (!($fp = @fopen($filename, 'wb')))
		{
			$file = new \fileerror(objects::$user->lang[$upload->error_prefix . 'NOT_UPLOADED']);
			return $file;
		}

		$upload_ary['size'] = fwrite($fp, $data);
		fclose($fp);
		unset($data);

		$upload_ary['tmp_name'] = $filename;

		$file = new \filespec($upload_ary, $upload, $mimetype_guesser);
		if ($upload_from_phpbb)
		{
			$file->extension = 'zip';
		}
		$upload->common_checks($file);

		return $file;
	}

	/**
	 * Gets a parameter of filespec object.
	 *
	 * @param \filespec $file  Filespec object
	 * @param string    $param 'init_error' for checking if there are any errors,
	 *                         'filename' or 'destination_file' for getting corresponding values
	 * @return mixed
	 */
	public function filespec_get($file, $param)
	{
		switch ($param)
		{
			case 'init_error':
				return $file->init_error;
			break;
			case 'filename':
				return $file->filename;
			break;
			case 'destination_file':
				return $file->destination_file;
			break;
		}
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function create_metadata_manager($name)
	{
		return objects::$phpbb_extension_manager->create_extension_metadata_manager($name, objects::$template);
	}

	/**
	 * {@inheritdoc}
	 */
	public function output_template_data(\phpbb\extension\metadata_manager $metadata_manager)
	{
		$metadata_manager->output_template_data();
	}
}
