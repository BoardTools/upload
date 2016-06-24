<?php
/**
 *
 * @package       Upload Extensions
 * @copyright (c) 2014 - 2016 Igor Lavrov (https://github.com/LavIgor) and John Peskens (http://ForumHulp.com)
 * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace boardtools\upload\includes\compatibility;

use \boardtools\upload\includes\objects;
use \Symfony\Component\DependencyInjection\Definition;

class v_3_2_x implements base
{
	/**
	 * {@inheritdoc}
	 */
	public function init()
	{
		$definition = new Definition(
			'boardtools\upload\includes\types\zip',
			array(
				'@files.factory',
				'@language',
				'@php_ini',
				'@request',
				'%core.root_path%',
			)
		);
		$definition->setShared(false);
		objects::$phpbb_container->setDefinition('boardtools.upload.files.types.zip', $definition);

		objects::$upload = objects::$phpbb_container->get('files.upload');
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_exception_message($e)
	{
		return call_user_func_array(array(objects::$user, 'lang'), array_merge(array($e->getMessage()), $e->get_parameters()));
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_metadata_manager($e)
	{
		return ;
	}

	/**
	 * The function that loads the FAQ language file.
	 * Should be removed in the final release.
	 * @param array $help Reference to the array of FAQ strings.
	 */
	protected function load_faq(&$help)
	{
		// Determine path to language directory
		$path = objects::$phpbb_extension_manager->get_extension_path('boardtools/upload', true) . 'language/';
		$faq_file = '/help_upload.' . objects::$phpEx;
		if (file_exists($path . objects::$user->data['user_lang'] . $faq_file))
		{
			// Do not suppress error if in DEBUG mode
			if (defined('DEBUG'))
			{
				include $path . objects::$user->data['user_lang'] . $faq_file;
			}
			else
			{
				@include $path . objects::$user->data['user_lang'] . $faq_file;
			}
		}
		else if (file_exists($path . 'en' . $faq_file))
		{
			// Do not suppress error if in DEBUG mode
			if (defined('DEBUG'))
			{
				include $path . 'en' . $faq_file;
			}
			else
			{
				@include $path . 'en' . $faq_file;
			}
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_faq()
	{
		$faq_help = array();
		$this->load_faq($faq_help);
		return $faq_help;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_upload_object()
	{
		return objects::$upload;
	}

	/**
	 * {@inheritdoc}
	 */
	public function form_upload($upload)
	{
		return $upload->handle_upload('files.types.form', 'extupload');
	}

	/**
	 * {@inheritdoc}
	 */
	public function remote_upload($upload, $remote_url)
	{
		return $upload->handle_upload('boardtools.upload.files.types.zip', $remote_url);
	}

	/**
	 * {@inheritdoc}
	 */
	public function filespec_get($file, $param)
	{
		switch ($param)
		{
			case 'init_error':
				return $file->init_error();
			break;
			case 'filename':
			case 'destination_file':
				return $file->get($param);
			break;
		}
		return false;
	}
}
