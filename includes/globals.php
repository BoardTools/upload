<?php
/**
 *
 * @package       Upload Extensions
 * @copyright (c) 2014 - 2015 Igor Lavrov (https://github.com/LavIgor) and John Peskens (http://ForumHulp.com)
 * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace boardtools\upload\includes;

/**
 * The class of objects and global variables.
 */
class globals
{
	/** @var \phpbb\files\upload */
	public $upload;

	public function __construct(\phpbb\files\upload $upload)
	{
		$this->upload = $upload;
	}
}
