<?php
/**
*
* @package Upload Extensions
* Persian Translator: Meisam nobari in www.php-bb.ir
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
'ACP_UPLOAD_EXT_TITLE_EXPLAIN'	=> 'با فعال کردن این افزونه شما میتوانید سایر افزونه های دیگر phpBB را به صورت فایل zip از مرکز مدیریت انجمن آپلود و یا به صورت کلی از سرور حذف نمایید.<br />توسط این افزونه شما توانید عملیات نصب ، ارتقا و حذف افزونه ها را بدون نیاز به رفتن به FTP انجام دهید. چنانچه افزونه ای موجود باشد و شما افزونه مشابهی را آپلود نمایید به صورت خودکار ورژن قبلی آپدیت خواهد شد.',
'UPLOAD'	=> 'آپلود',
'BROWSE'	=> 'انتخاب...',
'EXTENSION_UPLOAD'	=> 'آپلود افزونه',
'EXTENSION_UPLOAD_EXPLAIN'	=> 'در این قسمت شما میتوانید پکیج فشرده شده به صورت zip را که حاوی فایل های مورد نیاز جهت نصب افزونه است را از طریق کامپیوتر خود یا یک ریموت سرور آپلود نمایید. "آپلود افزونه" فایل ها را از حالت فشرده خارج میکند و جهت نصب آماده سازی میکند.<br />لطفا فایل خود را انتخاب و یا آدرس لینک افزونه را بنویسید.',
'EXT_UPLOAD_INIT_FAIL'	=> 'خطایی هنگام آپلود افزونه به وجود آمده است.',
'EXT_NOT_WRITABLE'	=> 'پوشه ext در روت انجمن شما قابل خواندن نیست. که این یکی از نیاز های مهم جهت آپلود افزونه ها میباشد. لطفا سطوح دسترسی این پوشه را تنظیم و مجدد تلاش کنید.',
'EXT_UPLOAD_ERROR'	=> 'افزونه آپلود نشد. لطفا فایل صحیح افزونه را وارد کرده و مجدد تلاش کنید.',
'NO_UPLOAD_FILE'	=> 'فایلی انتخاب نشده یا به هنگام بارگزاری مشکلی به وجود آمده است.',
'NOT_AN_EXTENSION'	=> 'فایل آپلود شده یک افزونه phpBB نیست. فایل در سرور شما ذخیره نشد.',
'EXTENSION_UPLOADED'	=> 'افزونه “%s” با موفقیت به روز رسانی شد.',
'EXTENSIONS_AVAILABLE'	=> 'افزونه های در دسترس',
'EXTENSION_INVALID_LIST'	=> 'لیست افزونه',
'EXTENSION_UPLOADED_ENABLE'	=> 'فعال سازی افزونه های آپلود شده',
'ACP_UPLOAD_EXT_UNPACK'	=> 'باز کردن افزونه',
'ACP_UPLOAD_EXT_CONT'	=> 'محتوی افزونه: %s',
'EXTENSION_DELETE'	=> 'حذف افزونه',
'EXTENSION_DELETE_CONFIRM'	=> 'آیا از حذف افزونه “%s” مطمئن هستید؟',
'EXT_DELETE_SUCCESS'	=> 'افزونه با موفقیت حذف شد.',
'EXTENSION_ZIP_DELETE'	=> 'حذف فایل zip',
'EXTENSION_ZIP_DELETE_CONFIRM'	=> 'آیا از حذف فایل zip “%s” مطمئن هستید؟',
'EXT_ZIP_DELETE_SUCCESS'	=> 'فایل zip افزونه مورد نظر با موفقیت حذف گردید.',
'ACP_UPLOAD_EXT_ERROR_DEST'	=> 'فایل vendor و مقصد در فایل zip موجود نیست. فایل در سرور شما ذخیره نشد.',
'ACP_UPLOAD_EXT_ERROR_COMP'	=> 'فایل composer.json در پکیج zip شما یافت نشد. فایل در سرور شما ذخیره نشد.',
'ACP_UPLOAD_EXT_ERROR_NOT_SAVED'	=> 'فایل در سرور شما ذخیره نشد.',
'ACP_UPLOAD_EXT_WRONG_RESTORE'		=> 'خطایی در هنگام به روز رسانی افزونه مورد نظر بوجود آمده است. لطفا مجدد تلاش نمایید.',
'UPLOAD_EXTENSIONS_DEVELOPERS'	=> 'توسعه دهندگان',
'SHOW_FILETREE'	=> '<< نمایش درخت فایل >>',
'HIDE_FILETREE'	=> '>> مخفی کردن درخت فایل <<',
'EXT_UPLOAD_SAVE_ZIP'	=> 'ذخیره سازی فایل zip شده',
'ZIP_UPLOADED'	=> 'فایل zip افزونه بارگزاری شده است.',
'EXT_ENABLE'	=> 'فعال سازی',
'EXT_UPLOADED'	=> 'آپلود شده',
'EXT_UPDATED'						=> 'به روز رسانی شده',
'EXT_UPDATED_LATEST_VERSION'		=> 'به روز رسانی به آخرین نسخه',
'EXT_UPLOAD_BACK'	=> '« بازگشت به آپلود افزونه',
'ACP_UPLOAD_EXT_DIR'				=> 'محل ذخیره سازی پیکج zip افزونه ها',
'ACP_UPLOAD_EXT_DIR_EXPLAIN'		=> 'محل روت phpBB شما به عنوان مثال. <samp>ext</samp>.<br />شما میتوانید محل ذخیره کردن فایل های zip را به پوشه دلخواه خودتان تغییر دهید. (به عنوان مثال, اگر تمایل به دانلود افزونه ها و فایل ها توسط کاربران هستید, میتوانید فایل را مثلا به پوشه روبه رو تغییر دهید <em>downloads</em>, و چنانچه نمی خواهید کاربران فایل های زیپ شده را دانلود نمایند میتوانید پوشه ای با سطح دسترسی های مورد نیاز ایجاد کنید. ضمنا میتوانید از طریق کدهای htaccess این کار را به خوبی انجام دهید.',
'ACP_UPLOAD_EXT_UPDATED'			=> 'افزونه نصب شده به روز رسانی شده است.',
'ACP_UPLOAD_EXT_UPDATED_EXPLAIN'	=> 'شما فایل زیپ شده ای برای به روز رسانی افزونه مورد نظر آپلود کرده اید. افزونه <strong>به صورت خودکار غیر فعال  شده</strong> تا به صورت امن به روز رسانی انجام شود. حالا لطفا <strong>بررسی کنید</strong> فایل آپلود شده صحیح می باشد و <strong>فعال کنید</strong> افزونه مورد نظر را جهت استفاده در انجمن',
));
