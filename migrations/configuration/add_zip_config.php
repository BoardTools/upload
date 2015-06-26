<?php
/**
*
* @package Upload Extensions
* @copyright (c) 2014 - 2015 Igor Lavrov (https://github.com/LavIgor) and John Peskens (http://ForumHulp.com)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace boardtools\upload\migrations\configuration;

class add_zip_config extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['upload_ext_dir']);
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\dev');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('upload_ext_dir', $this->upload_directory())),
		);
	}

	private function upload_directory()
	{
		$directory = 'store/ext';

		if (!is_dir($this->phpbb_root_path . $directory))
		{
			@mkdir($this->phpbb_root_path . $directory, 0755);
			@chmod($this->phpbb_root_path . $directory, 0755);

			if (!is_dir($this->phpbb_root_path . $directory))
			{
				$directory = 'ext';
			}
		}
		else if (!is_writable($this->phpbb_root_path . $directory))
		{
			@chmod($this->phpbb_root_path . $directory, 0755);
		}

		return $directory;
	}
}
