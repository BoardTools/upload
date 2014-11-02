<?php
/**
*
* @package Upload Extensions
* @copyright (c) 2014 John Peskens (http://ForumHulp.com) and Igor Lavrov (https://github.com/LavIgor)
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
			array('config.add', array('upload_ext_dir', 'ext')),
		);
	}
}
