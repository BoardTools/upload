<?php
/**
*
* @package Upload Extensions
* @copyright (c) 2014 - 2015 Igor Lavrov (https://github.com/LavIgor) and John Peskens (http://ForumHulp.com)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace boardtools\upload\acp;

class upload_info
{
	function module()
	{
		return array(
			'filename'    => 'boardtools\upload\acp\upload_module',
			'title'        => 'ACP_UPLOAD_EXT_TITLE',
			'version'    => '1.0.0',
			'modes'        => array(
				'main'		=> array(
											'title'	=> 'ACP_UPLOAD_EXT_CONFIG_TITLE',
											'auth'	=> 'ext_boardtools/upload && acl_a_extensions',
											'cat'	=> array('ACP_EXTENSION_MANAGEMENT')
									),
			),
		);
	}

	function install()
	{
	}

	function uninstall()
	{
	}
}
