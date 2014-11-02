<?php
/**
*
* @package Upload Extensions
* @copyright (c) 2014 John Peskens (http://ForumHulp.com) and Igor Lavrov (https://github.com/LavIgor)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace boardtools\upload\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	protected $user;

	/**
	* Constructor
	*
	* @param \phpbb\controller\helper    $helper        Controller helper object
	*/
	public function __construct(\phpbb\user $user)
	{
		$this->user = $user;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.acp_board_config_edit_add'	=> 'add_config',
		);
	}

	public function add_config($event)
	{
		if($event['mode'] == 'server')
		{
			$this->user->add_lang_ext('boardtools/upload', 'upload');
			$display_vars = $event['display_vars'];
			$new_vars = array(
				'upload_ext_dir'	=> array('lang' => 'ACP_UPLOAD_EXT_DIR',	'validate' => 'path',	'type' => 'text:20:255', 'explain' => true),
			);
			$display_vars['vars'] = phpbb_insert_config_array($display_vars['vars'], $new_vars, array('after' => 'ranks_path'));
			$event['display_vars'] = $display_vars;
		}
	}
}
