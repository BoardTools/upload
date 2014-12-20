<?php
/**
*
* @package Upload Extensions
* @copyright (c) 2014 John Peskens (http://ForumHulp.com) and Igor Lavrov (https://github.com/LavIgor)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
* Translated By : Basil Taha Alhitary - www.alhitary.net
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
	'ACP_UPLOAD_EXT_TITLE'				=> 'رفع الإضافات',
	'ACP_UPLOAD_EXT_CONFIG_TITLE'		=> 'رفع الإضافات',
	'ACP_UPLOAD_EXT_TITLE_EXPLAIN'		=> 'تستطيع من هنا رفع الإضافات المضغوطة بصيغة zip أو حذفها من السيرفر.<br />تستطيع أيضاً تنصيب / تحديث / حذف الإضافات بدون استخدام برنامج الFTP. ويتم تحديث الإضافة القديمة عندما تقوم برفع الإضافة الجديدة المُحدثة.',
	'UPLOAD'							=> 'رفع الإضافة',
	'BROWSE'							=> 'استعراض...',
	'EXTENSION_UPLOAD'					=> 'رفع الإضافة',
	'EXTENSION_UPLOAD_EXPLAIN'			=> 'من هنا تستطيع رفع ملف الإضافة المضغوط بصيغة zip من جهازك المحلي أو من سيرفر بعيد. وسيتم بعد ذلك فك ملف الإضافة المضغوط والتجهيز لعملية التنصيب.<br />اختار الملف المطلوب أو أكتب الرابط في الحقل أدناه.',
	'EXT_UPLOAD_INIT_FAIL'				=> 'هناك خطأ أثناء عملية رفع الإضافة.',
	'EXT_NOT_WRITABLE'					=> 'لا يمتلك المسار ext/ تراخيص الكتابة. نرجوا ضبط التراخيص أو الإعدادات لكي تعمل هذه الإضافة بصورة صحيحة والمحاولة مرة أخرى.',
	'EXT_UPLOAD_ERROR'					=> 'لم يتم رفع الإضافة. نرجوا التأكد من صحة الملف المضغوط والمحاولة مرة أخرى.',
	'NO_UPLOAD_FILE'					=> 'لم يتم تحديد أي ملف أو هناك خطأ أثناء عملية رفع الإضافة.',
	'NOT_AN_EXTENSION'					=> 'لم يتم التعرف على الملف المضغوط الذي رفعته. لم يتم حفظ هذا الملف على سيرفرك.',

	'EXTENSION_UPLOADED'				=> 'تم رفع الإضافة “%s” بنجاح.',
	'EXTENSIONS_AVAILABLE'				=> 'الإضافات المتوفرة',
	'EXTENSION_INVALID_LIST'			=> 'قائمة الإضافة',
	'EXTENSION_UPLOADED_ENABLE'			=> 'تفعيل هذه الإضافة',
	'ACP_UPLOAD_EXT_UNPACK'				=> 'فك الضغط',
	'ACP_UPLOAD_EXT_CONT'				=> 'محتوى المجلد: %s',

	'EXTENSION_DELETE'					=> 'حذف الإضافة',
	'EXTENSION_DELETE_CONFIRM'			=> 'هل تريد بالفعل حذف الإضافة “%s” ?',
	'EXT_DELETE_SUCCESS'				=> 'تم حذف الإضافة بنجاح.',
	'EXT_DELETE_ERROR'					=> 'لم يتم تحديد الملف أو حدثت مشكلة أثناء عملية الحذف.',

	'EXTENSION_ZIP_DELETE'				=> 'حذف الملف المضغوط',
	'EXTENSION_ZIP_DELETE_CONFIRM'		=> 'هل تريد بالفعل حذف الملف المضغوط للإضافة “%s” ?',
	'EXT_ZIP_DELETE_SUCCESS'			=> 'تم حذف ملف الإضافة المضغوط بنجاح.',
	'EXT_ZIP_DELETE_ERROR'				=> 'لم يتم تحديد أي ملف أو هناك خطأ أثناء عملية الحذف.',

	'ACP_UPLOAD_EXT_ERROR_DEST'			=> 'مجلد ال vendor أو مسار المجلد غير موجود في الملف المضغوط الذي رفعته. لم يتم حفظ هذا الملف على سيرفرك.',
	'ACP_UPLOAD_EXT_ERROR_COMP'			=> 'الملف composer.json غير موجود في الملف المضغوط الذي رفعته. لم يتم حفظ هذا الملف على سيرفرك.',
	'ACP_UPLOAD_EXT_ERROR_NOT_SAVED'	=> 'لم يتم حفظ الملف على سيرفرك.',
	'ACP_UPLOAD_EXT_WRONG_RESTORE'		=> 'حدثت مشكلة أثناء عملية تحديث الإضافة. نرجوا المحاولة مرة أخرى.',

	'UPLOAD_EXTENSIONS_DEVELOPERS'		=> 'المطورين',

	'SHOW_FILETREE'						=> '<< إظهار محتوى الملف >>',
	'HIDE_FILETREE'						=> '>> إخفاء محتوى الملف <<',

	'EXT_UPLOAD_SAVE_ZIP'				=> 'حفظ هذا الملف المضغوط',
	'ZIP_UPLOADED'						=> 'الإضافات المضغوطة',
	'EXT_ENABLE'						=> 'تفعيل',
	'EXT_UPLOADED'						=> 'تم الرفع',
	'EXT_UPDATED'						=> 'تم التحديث',
	'EXT_UPDATED_LATEST_VERSION'		=> 'مُحدث إلى آخر إصدار',
	'EXT_UPLOAD_BACK'					=> '« العودة إلى الصفحة الرئيسية',

	'ACP_UPLOAD_EXT_DIR'				=> 'مسار تخزين الإضافات المضغوطة',
	'ACP_UPLOAD_EXT_DIR_EXPLAIN'		=> 'المسار الموجود في مجلد المنتدى , على سبيل المثال : <samp>ext</samp>.<br />تستطيع تغيير هذا المسار إلى مجلد خاص لحفظ الملفات المضغوطة ( مثال : اذا تريد اتاحة تحميل هذه الملفات للأعضاء , تستطيع تغيير المسار إلى <em>downloads</em>, واذا تريد منعها , تستطيع تغييرها إلى المسار الذي يكون أعلى بمستوى واحد عن المسار الرئيسي http لموقعك ( أو تستطيع انشاء مجلد يحتوى على الملف .htaccess )).',

	'ACP_UPLOAD_EXT_UPDATED'			=> 'تم تحديث الإضافة بنجاح.',
	'ACP_UPLOAD_EXT_UPDATED_EXPLAIN'	=> 'لقد قمت برفع ملف مضغوط لإضافة موجودة مُسبقاً. <strong>تم تعطيل</strong> تلك الإضافة <strong>تلقائياً</strong> لتنفيذ عملية التحديث بصورة آمنة. نرجوا الآن <strong>التأكد</strong> من صحة عمل الإضافة و <strong>تفعيلها</strong> اذا تريد ذلك.',

	'VALID_PHPBB_EXTENSIONS'			=> 'الإضافات المُعتمدة',
));
