<?php
/**
 *
 * @package       Upload Extensions
 * @copyright (c) 2014 - 2017 Igor Lavrov (https://github.com/LavIgor) and John Peskens (http://ForumHulp.com)
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
		/** @var \boardtools\upload\includes\types\zip */
		$upload_zip = new \boardtools\upload\includes\types\zip(
			objects::$phpbb_container->get('files.factory'),
			objects::$phpbb_container->get('language'),
			objects::$phpbb_container->get('php_ini'),
			objects::$phpbb_container->get('request'),
			objects::$phpbb_container->getParameter('core.root_path')
		);
		$upload_zip->set_upload(objects::$upload);

		return $upload_zip->upload($remote_url);
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

	/**
	 * {@inheritdoc}
	 */
	public function create_metadata_manager($name)
	{
		return objects::$phpbb_extension_manager->create_extension_metadata_manager($name);
	}

	/**
	 * {@inheritdoc}
	 */
	public function output_template_data(\phpbb\extension\metadata_manager $metadata_manager)
	{
		if (phpbb_version_compare(objects::$config['version'], '3.2.0', '>'))
		{
			$metadata = $metadata_manager->get_metadata('all');
			$this->output_metadata_to_template($metadata);
		}
		else
		{
			$metadata_manager->output_template_data(objects::$template);
		}
	}

	/**
	 * Outputs extension metadata into the template
	 *
	 * @param array $metadata Array with all metadata for the extension
	 */
	public function output_metadata_to_template($metadata)
	{
		objects::$template->assign_vars(array(
			'META_NAME'			=> $metadata['name'],
			'META_TYPE'			=> $metadata['type'],
			'META_DESCRIPTION'	=> (isset($metadata['description'])) ? $metadata['description'] : '',
			'META_HOMEPAGE'		=> (isset($metadata['homepage'])) ? $metadata['homepage'] : '',
			'META_VERSION'		=> $metadata['version'],
			'META_TIME'			=> (isset($metadata['time'])) ? $metadata['time'] : '',
			'META_LICENSE'		=> $metadata['license'],

			'META_REQUIRE_PHP'		=> (isset($metadata['require']['php'])) ? $metadata['require']['php'] : '',
			'META_REQUIRE_PHP_FAIL'	=> (isset($metadata['require']['php'])) ? false : true,

			'META_REQUIRE_PHPBB'		=> (isset($metadata['extra']['soft-require']['phpbb/phpbb'])) ? $metadata['extra']['soft-require']['phpbb/phpbb'] : '',
			'META_REQUIRE_PHPBB_FAIL'	=> (isset($metadata['extra']['soft-require']['phpbb/phpbb'])) ? false : true,

			'META_DISPLAY_NAME'	=> (isset($metadata['extra']['display-name'])) ? $metadata['extra']['display-name'] : '',
		));

		foreach ($metadata['authors'] as $author)
		{
			objects::$template->assign_block_vars('meta_authors', array(
				'AUTHOR_NAME'		=> $author['name'],
				'AUTHOR_EMAIL'		=> (isset($author['email'])) ? $author['email'] : '',
				'AUTHOR_HOMEPAGE'	=> (isset($author['homepage'])) ? $author['homepage'] : '',
				'AUTHOR_ROLE'		=> (isset($author['role'])) ? $author['role'] : '',
			));
		}
	}
}
