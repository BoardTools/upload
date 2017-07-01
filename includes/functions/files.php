<?php
/**
 *
 * @package       Upload Extensions
 * @copyright (c) 2014 - 2017 Igor Lavrov (https://github.com/LavIgor) and John Peskens (http://ForumHulp.com)
 * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace boardtools\upload\includes\functions;

use \boardtools\upload\includes\objects;

class files
{
	public static $catched_errors;
	public static $catched_solutions;

	/**
	 * The function that catches errors of other functions.
	 * USAGE 1: files::catch_errors(my_function()); => If my_function returns true, continue.
	 *          Otherwise the result of my_function() is printed as an error string.
	 * USAGE 2: files::catch_errors('MY_ERROR', my_function()); => If my_function returns true, continue.
	 *          If my_function returns false, print the string MY_ERROR.
	 * USAGE 3: files::catch_errors('MY_ERROR'); => Print the string MY_ERROR.
	 * @param bool|string $error  The text to display in the case of an error. True if there were no errors.
	 * @param bool        $result The result of the function what we need to catch errors of. True if there were no errors.
	 * @return bool            $result
	 */
	public static function catch_errors($error, $result = false)
	{
		if ($error === true)
		{
			return true;
		}
		if (!$result)
		{
			// Catch solutions.
			if (is_array($error) && isset($error['solution']))
			{
				self::$catched_solutions = (isset(self::$catched_solutions)) ? self::$catched_solutions . "<br />" . $error['solution'] : $error['solution'];
				objects::$template->assign_var('UPLOAD_ERROR_SOLUTIONS', self::$catched_solutions);
				$error = $error['error'];
			}
			self::$catched_errors = $error = (isset(self::$catched_errors)) ? self::$catched_errors . "<br />" . $error : $error;
			objects::$template->assign_var('UPLOAD_ERROR', $error);
		}
		return $result;
	}

	/**
	 * The function that searches for composer.json file.
	 * @param string $dir The directory to search in.
	 * @return string/bool The path to composer.json file, false in case of an error.
	 */
	public static function getComposer($dir)
	{
		if (@is_file($dir . '/composer.json'))
		{
			return $dir . '/composer.json';
		}
		$ffs = @scandir($dir);
		if (!$ffs)
		{
			return false;
		}
		$composer = false;
		foreach ($ffs as $ff)
		{
			if ($ff != '.' && $ff != '..')
			{
				if (@is_dir($dir . '/' . $ff))
				{
					$composer = self::getComposer($dir . '/' . $ff);
				}
				if ($composer !== false)
				{
					return $composer;
				}
			}
		}
		return $composer;
	}

	/**
	 * Function to remove folders and files.
	 * @param string $dir       The directory for removal.
	 * @param bool   $no_errors Whether there were errors before.
	 * @return bool|string        True if there are no errors, error string otherwise.
	 */
	public static function rrmdir($dir, $no_errors = true)
	{
		if (@is_dir($dir))
		{
			$files = @scandir($dir);
			if ($files === false)
			{
				return objects::$user->lang('ERROR_REMOVE_DIRECTORY', str_replace(objects::$phpbb_root_path, 'PHPBB_ROOT/', $dir));
			}
			foreach ($files as $file)
			{
				if ($file != '.' && $file != '..')
				{
					$no_errors = self::rrmdir($dir . '/' . $file, $no_errors);
				}
			}
			if (!(@rmdir($dir)))
			{
				return objects::$user->lang('ERROR_REMOVE_DIRECTORY', str_replace(objects::$phpbb_root_path, 'PHPBB_ROOT/', $dir));
			}
		}
		else if (@file_exists($dir))
		{
			if (!(@unlink($dir)))
			{
				return objects::$user->lang('ERROR_REMOVE_DIRECTORY', str_replace(objects::$phpbb_root_path, 'PHPBB_ROOT/', $dir));
			}
		}
		return $no_errors;
	}

	/**
	 * Function to copy folders and files.
	 * @param string $src The path 'from'.
	 * @param string $dst The path 'to'.
	 * @return bool|string    True if there are no errors, error string otherwise.
	 */
	public static function rcopy($src, $dst)
	{
		if (@file_exists($dst))
		{
			if (self::rrmdir($dst) !== true)
			{
				return objects::$user->lang('ERROR_COPY_FILE', str_replace(objects::$phpbb_root_path, 'PHPBB_ROOT/', $src), str_replace(objects::$phpbb_root_path, 'PHPBB_ROOT/', $dst));
			}
		}
		if (@is_dir($src))
		{
			if (self::recursive_mkdir($dst, 0755) !== true)
			{
				return objects::$user->lang('ERROR_COPY_FILE', str_replace(objects::$phpbb_root_path, 'PHPBB_ROOT/', $src), str_replace(objects::$phpbb_root_path, 'PHPBB_ROOT/', $dst));
			}
			$files = @scandir($src);
			if ($files === false)
			{
				return objects::$user->lang('ERROR_COPY_FILE', str_replace(objects::$phpbb_root_path, 'PHPBB_ROOT/', $src), str_replace(objects::$phpbb_root_path, 'PHPBB_ROOT/', $dst));
			}
			foreach ($files as $file)
			{
				if ($file != '.' && $file != '..')
				{
					if (self::rcopy($src . '/' . $file, $dst . '/' . $file) !== true)
					{
						return objects::$user->lang('ERROR_COPY_FILE', str_replace(objects::$phpbb_root_path, 'PHPBB_ROOT/', $src), str_replace(objects::$phpbb_root_path, 'PHPBB_ROOT/', $dst));
					}
				}
			}
		}
		else if (@file_exists($src))
		{
			if (!(@copy($src, $dst)))
			{
				return objects::$user->lang('ERROR_COPY_FILE', str_replace(objects::$phpbb_root_path, 'PHPBB_ROOT/', $src), str_replace(objects::$phpbb_root_path, 'PHPBB_ROOT/', $dst));
			}
		}
		return true;
	}

	/**
	 * Saves the contents of a file or a directory in a zip archive file.
	 * @param string $dest_file The path to the contents for adding to the zip file.
	 * @param string $dest_name The name of the zip file.
	 * @param string $zip_dir   The directory for saving zip files.
	 */
	public static function save_zip_archive($dest_file, $dest_name, $zip_dir)
	{
		if (!class_exists('\compress_zip'))
		{
			include(objects::$phpbb_root_path . 'includes/functions_compress.' . objects::$phpEx);
		}

		// Remove additional ext/ prefix.
		$src_rm_prefix = (strpos($dest_file, 'ext/') === 0) ? substr($dest_file, 0, 4) : '';
		$zip = new \compress_zip('w', $zip_dir . '/' . $dest_name . '.zip');
		$zip->add_file($dest_file, $src_rm_prefix);
		$zip->close();
	}

	/**
	 * @author Michal Nazarewicz (from the php manual)
	 * Creates all non-existant directories in a path
	 * @param $path - path to create
	 * @param $mode - CHMOD the new dir to these permissions
	 * @return bool|string True if there are no errors, error string otherwise.
	 */
	public static function recursive_mkdir($path, $mode = 0755)
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
					return objects::$user->lang('ERROR_CREATE_DIRECTORY', str_replace(objects::$phpbb_root_path, 'PHPBB_ROOT/', $path));
				}
			}
		}
		return true;
	}

	/**
	 * Gets languages in the specified directory.
	 * @param string $path The path to the language directory without slash at the end.
	 * @return array
	 */
	public static function get_languages($path)
	{
		$return = array();
		if (@is_dir($path))
		{
			$files = @scandir($path);
			if ($files === false)
			{
				return $return;
			}
			$type_cast_helper = new \phpbb\request\type_cast_helper();
			foreach ($files as $file)
			{
				if ($file != '.' && $file != '..' && @is_dir($path . '/' . $file))
				{
					$type_cast_helper->set_var($file, $file, gettype($file), true);
					$return[] = $file;
				}
			}
		}
		return $return;
	}

	/**
	 * Check whether acp/ and/or adm/ directories exist in the specified directory.
	 * @param string $path The path to the directory without slash at the end.
	 * @return bool
	 */
	public static function check_acp_and_adm($path)
	{
		if (@is_dir($path))
		{
			$files = @scandir($path);
			if ($files === false)
			{
				return false;
			}
			foreach ($files as $file)
			{
				if (($file == 'acp' || $file == 'adm') && @is_dir($path . '/' . $file))
				{
					return true;
				}
			}
		}
		return false;
	}
}
