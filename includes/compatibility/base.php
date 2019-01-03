<?php
/**
 *
 * @package       Upload Extensions
 * @copyright (c) 2014 - 2019 Igor Lavrov (https://github.com/LavIgor) and John Peskens (http://ForumHulp.com)
 * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace boardtools\upload\includes\compatibility;

interface base
{
	/**
	 * Performs necessary version-specific initializations.
	 */
	public function init();

	/**
	 * Outputs a language string for the exception.
	 *
	 * @param \phpbb\extension\exception $e Extension exception class
	 * @return string
	 */
	public function get_exception_message($e);

	/**
	 * Returns the array of language strings for the FAQ.
	 *
	 * @return array
	 */
	public function get_faq();

	/**
	 * Gets proper upload object.
	 *
	 * @return \phpbb\files\upload|\fileupload
	 */
	public function get_upload_object();

	/**
	 * Performs the form upload process and returns filespec object.
	 *
	 * @param \phpbb\files\upload|\fileupload $upload The upload object
	 * @return \phpbb\files\filespec|\filespec
	 */
	public function form_upload($upload);

	/**
	 * Performs the remote upload process and returns filespec object.
	 *
	 * @param \phpbb\files\upload|\fileupload $upload     The upload object
	 * @param string                          $remote_url File URL address
	 * @return \phpbb\files\filespec|\filespec
	 */
	public function remote_upload($upload, $remote_url);

	/**
	 * Escape a string variable.
	 *
	 * @param mixed	$value		The contents to fill with
	 * @param bool	$multibyte	Indicates whether string values may contain UTF-8 characters.
	 * 							Default is false, causing all bytes outside the ASCII range (0-127) to be replaced with question marks.
	 * @return string|array
	 */
	public function escape($value, $multibyte);

	/**
	 * Gets a parameter of filespec object.
	 *
	 * @param \phpbb\files\filespec|\filespec $file  Filespec object
	 * @param string                          $param 'init_error' for checking if there are any errors,
	 *                                               'filename' or 'destination_file' for getting corresponding values
	 * @return mixed
	 */
	public function filespec_get($file, $param);

	/**
	 * Instantiates the metadata manager for the extension with the given name.
	 *
	 * @param string $name The extension name
	 * @return \phpbb\extension\metadata_manager Instance of the metadata manager
	 */
	public function create_metadata_manager($name);

	/**
	 * Outputs the metadata into the template.
	 *
	 * @param \phpbb\extension\metadata_manager $metadata_manager phpBB extension metadata manager
	 */
	public function output_template_data(\phpbb\extension\metadata_manager $metadata_manager);

	/**
	 * Check the version and return the available updates (for an extension).
	 *
	 * @param \phpbb\extension\metadata_manager $md_manager The metadata manager for the version to check.
	 * @param bool $force_update Ignores cached data. Defaults to false.
	 * @param bool $force_cache Force the use of the cache. Override $force_update.
	 * @param string $stability Force the stability (null by default).
	 * @return array
	 * @throws \phpbb\exception\runtime_exception
	 */
	public function version_check(\phpbb\extension\metadata_manager $md_manager, $force_update = false, $force_cache = false, $stability = null);
}
