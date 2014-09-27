<?php
/**
*
* @package Upload Extensions
* Persian Translator: Meisam nobari
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
if (!defined('IN_PHPBB'))
{
exit;
}
if (empty($lang) || !is_array($lang))
{
$lang = array();
}
$lang = array_merge($lang, array(
'ACP_UPLOAD_EXT_TITLE'	=> 'آپلود افزونه',
'ACP_UPLOAD_EXT_CONFIG_TITLE'	=> 'آپلود افزونه',
'ACP_UPLOAD_EXT_TITLE_EXPLAIN'	=> 'Upload Extensions enables you to upload extensions\' zip files or delete extensions\' folders from the server.<br />With this extension you can install/update/delete extensions without using FTP. If the uploaded extension already exists, it will be updated with the uploaded files.',
'UPLOAD'	=> 'آپلود',
'BROWSE'	=> 'انتخاب...',
'EXTENSION_UPLOAD'	=> 'آپلود افزونه',
'EXTENSION_UPLOAD_EXPLAIN'	=> 'Here you can upload a zipped extension package containing the necessary files to perform installation from your local computer or a remote server. “Upload Extensions” will then attempt to unzip the file and have it ready for installation.<br />Choose a file or type a link in the fields below.<br />NOTE: Some servers (for example, github.com) don\'t support remote uploads.',
'EXT_UPLOAD_INIT_FAIL'	=> 'There was an error when initialising the extension upload process.',
'EXT_NOT_WRITABLE'	=> 'The ext/ directory is not writable. This is required for “Upload extension” to work properly. Please adjust your permissions or settings and try again.',
'EXT_UPLOAD_ERROR'	=> 'The extension wasn\'t uploaded. Please confirm that you upload the true extension zip file and try again.',
'NO_UPLOAD_FILE'	=> 'فایلی انتخاب نشده یا به هنگام بارگزاری مشکلی به وجود آمده است.',
'NOT_AN_EXTENSION'	=> 'فایل آپلود شده یک افزونه phpBB نیست. فایل در سرور شما ذخیره نشد.',
'EXTENSION_UPLOADED'	=> 'افزونه “%s” با موفقیت به روز رسانی شد.',
'EXTENSIONS_AVAILABLE'	=> 'افزونه های در دسترس',
'EXTENSION_INVALID_LIST'	=> 'لیست افزونه',
'EXTENSION_UPLOADED_ENABLE'	=> 'فعال سازی افزونه های اپلود شده',
'ACP_UPLOAD_EXT_UNPACK'	=> 'Unpack extension',
'ACP_UPLOAD_EXT_CONT'	=> 'Content of package: %s',
'EXTENSION_DELETE'	=> 'حذف افزونه',
'EXTENSION_DELETE_CONFIRM'	=> 'آیا از حذف افزونه “%s” مطمئن هستید؟',
'EXT_DELETE_SUCCESS'	=> 'افزونه با موفقیت حذف شد.',
'EXTENSION_ZIP_DELETE'	=> 'حذف فایل zip',
'EXTENSION_ZIP_DELETE_CONFIRM'	=> 'آیا از حذف فایل zip “%s” مطمئن هستید؟',
'EXT_ZIP_DELETE_SUCCESS'	=> 'فایل zip افزونه مورد نظر با موفقیت حذف گردید.',
'ACP_UPLOAD_EXT_ERROR_DEST'	=> 'No vendor or destination folder in the uploaded zip file. The file was not saved on the server.',
'ACP_UPLOAD_EXT_ERROR_COMP'	=> 'composer.json wasn\'t found in the uploaded zip file. The file was not saved on the server.',
'UPLOAD_EXTENSIONS_DEVELOPERS'	=> 'توسعه دهندگان',
'SHOW_FILETREE'	=> '<< Show file tree >>',
'HIDE_FILETREE'	=> '>> Hide file tree <<',
'ziperror'	=> array(
'10'	=> 'فایل از قبل موجود بوده.',
'21'	=> 'Zip archive inconsistent.',
'18'	=> 'Invalid argument.',
'14'	=> 'Malloc failure.',
'9'	=> 'فایلی موجود نیست',
'19'	=> 'Not a zip archive.',
'11'	=> 'نمیتوان فایل را باز کرد.',
'5'	=> 'خطا در خواندن ',
'4'	=> 'خطا در جستجو'
),
'EXT_UPLOAD_SAVE_ZIP'	=> 'Save uploaded zip file',
'ZIP_UPLOADED'	=> 'Uploaded zip packages of extensions',
'EXT_ENABLE'	=> 'فعال سازی',
'EXT_UPLOADED'	=> 'آپلود شده',
'EXT_UPLOAD_BACK'	=> '« بازگشت به آپلود افزونه',
));
