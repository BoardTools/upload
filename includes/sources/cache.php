<?php
/**
 *
 * @package       Upload Extensions
 * @copyright (c) 2014 - 2015 Igor Lavrov (https://github.com/LavIgor) and John Peskens (http://ForumHulp.com)
 * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace boardtools\upload\includes\sources;

use \boardtools\upload\includes\objects;

class cache
{
	private static $enabled = false;
	private static $whitelist = 'a-z0-9.';
	private static $cache_prefix = '/upload/';
	private static $cache_dir = '';

	public static function is_enabled()
	{
		if (self::$enabled)
		{
			return self::$enabled;
		}
		self::$enabled = true;
		if (
			(!is_dir(self::get_root()) && !@mkdir(self::get_root(), 0777, true))
			|| !is_writable(self::get_root())
		)
		{
			self::$enabled = false;
		}
		return self::$enabled;
	}

	public static function get_root()
	{
		if (self::$cache_dir)
		{
			return self::$cache_dir;
		}
		return self::$cache_dir = objects::$cache->get_driver()->cache_dir . self::$cache_prefix;
	}

	public static function read($file)
	{
		$file = self::get_root() . preg_replace('{[^' . self::$whitelist . ']}i', '-', $file);
		if (self::is_enabled() && file_exists($file))
		{
			return file_get_contents($file);
		}

		return false;
	}

	public static function write($file, $data)
	{
		if (self::is_enabled())
		{
			$file = self::get_root() . preg_replace('{[^' . self::$whitelist . ']}i', '-', $file);

			$lock = new \phpbb\lock\flock($file);
			$lock->acquire();

			if ($handle = @fopen($file, 'wb'))
			{
				fwrite($handle, $data);
				fclose($handle);

				phpbb_chmod($file, CHMOD_READ | CHMOD_WRITE);

				$return_value = true;
			}
			else
			{
				$return_value = false;
			}

			$lock->release();

			return $return_value;
		}

		return false;
	}

	public static function sha1($file)
	{
		$file = self::get_root() . preg_replace('{[^' . self::$whitelist . ']}i', '-', $file);
		if (self::is_enabled() && file_exists($file))
		{
			return sha1_file($file);
		}

		return false;
	}

	public static function sha256($file)
	{
		$file = self::get_root() . preg_replace('{[^' . self::$whitelist . ']}i', '-', $file);
		if (self::is_enabled() && file_exists($file))
		{
			return hash_file('sha256', $file);
		}

		return false;
	}
}
