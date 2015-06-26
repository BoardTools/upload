<?php
/**
*
* @package Upload Extensions
* @copyright (c) 2014 - 2015 Igor Lavrov (https://github.com/LavIgor) and John Peskens (http://ForumHulp.com)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace boardtools\upload\includes\filetree;

class filedownload
{
	public static function download_file($filename, $download_name, $mimetype)
	{
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
			return true;
		}
		return false;
	}
}
