<?php
/**
*
* @package Upload Extensions
* @copyright (c) 2014 - 2015 Igor Lavrov (https://github.com/LavIgor) and John Peskens (http://ForumHulp.com)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace boardtools\upload\includes\filetree;

class filetree
{
	public static $ext_name;

	public static function get_file($file)
	{
		if ($file != '')
		{
			$string = @file_get_contents($file);
			echo '<div class="filename">' . substr($file, strrpos($file, '/') + 1) . '</div><div class="filecontent">' .  highlight_string($string, true) . '</div>';
			exit();
		}
		return false;
	}

	public static function php_file_tree($directory, $display_name, $uaction, $extensions = array())
	{
		$code = '<div class="filetree_package">' . $display_name . '</div>';
		if (substr($directory, -1) == '/')
		{
			$directory = substr($directory, 0, strlen($directory) - 1);
		}
		$code .= self::php_file_tree_dir($directory, $uaction, $extensions);
		return $code;
	}

	public static function php_file_tree_dir($directory, $uaction, $extensions = array(), $first_call = true)
	{
		$file = @scandir($directory);
		if (!$file)
		{
			return false;
		}
		natcasesort($file);

		// Make directories first
		$files = $dirs = array();
		foreach ($file as $this_file)
		{
			if (is_dir($directory . '/' . $this_file))
			{
				$dirs[] = $this_file;
			}
			else
			{
				$files[] = $this_file;
			}
		}
		$file = array_merge($dirs, $files);

		// Filter unwanted extensions
		if (!empty($extensions))
		{
			foreach (array_keys($file) as $key)
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

		$php_file_tree = '';
		if (count($file) > 2)
		{ // Use 2 instead of 0 to account for . and .. directories
			$php_file_tree = '<ul';
			if ($first_call)
			{
				$php_file_tree .= ' class="php-file-tree"';
				$first_call = false;
			}
			$php_file_tree .= '>';
			foreach ($file as $this_file)
			{
				if ($this_file != '.' && $this_file != '..' )
				{
					if (is_dir($directory . '/' . $this_file))
					{
						// Directory
						$php_file_tree .= '<li class="pft-directory"><span>' . htmlspecialchars($this_file) . '</span>';
						$php_file_tree .= self::php_file_tree_dir($directory . '/' . $this_file, $uaction, $extensions, false);
						$php_file_tree .= '</li>';
					}
					else
					{
						// File
						// Get extension (prepend 'ext-' to prevent invalid classes from extensions that begin with numbers)
						$ext = 'ext-' . substr($this_file, strrpos($this_file, '.') + 1);
						$link = $uaction . '&amp;file=' . urlencode($directory . '/' . $this_file);
						// Noscript support
						$getlink = $uaction . '&amp;action=details&amp;ext_name=' . self::$ext_name . '&amp;ext_show=filetree&amp;ext_file=' . urlencode(substr($directory, strpos($directory, self::$ext_name) + strlen(self::$ext_name)) . '/' . $this_file);
						$show_link = (in_array($ext, array('ext-gif', 'ext-jpg', 'ext-jpeg', 'ext-tif', 'ext-png'))) ? false : true;
						$php_file_tree .= '<li class="pft-file ' . htmlspecialchars(strtolower($ext)) . '"' . (($show_link) ? ' data-file-link="'. $link . '"' : '') . ' title="' . htmlspecialchars($this_file) . '"><a' . (($show_link) ? ' href="' . $getlink . '"' : ' style="cursor: default;"') . '>' . htmlspecialchars($this_file) . '</a></li>';
					}
				}
			}
			$php_file_tree .= '</ul>';
		}
		return $php_file_tree;
	}
}
