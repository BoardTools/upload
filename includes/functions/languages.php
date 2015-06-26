<?php
/**
*
* @package Upload Extensions
* @copyright (c) 2014 - 2015 Igor Lavrov (https://github.com/LavIgor) and John Peskens (http://ForumHulp.com)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace boardtools\upload\includes\functions;

class languages
{
	/**
	* Gets information about the language in the specified directory.
	* @param string $path   The path to the language directory without slash at the end.
	* @param string $lang   The ISO code of the language.
	* @return array
	*/
	public static function details($path, $lang)
	{
		$return = array();
		if (@is_dir($path . '/' . $lang))
		{
			$return['name'] = $lang;
		}
		return $return;
	}
}
