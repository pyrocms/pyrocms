<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PyroCMS
 *
 * An open source CMS based on CodeIgniter
 *
 * @package		PyroCMS
 * @author		Jerel Unruh - PyroCMS Dev Team
 * @license		Apache License v2.0
 * @link		http://pyrocms.com
 * @since		Version 1.0-dev
 * @filesource
 */

// General
$lang['files:files_title']					= 'الملفات';
$lang['files:fetching']						= 'جلب البيانات...';
$lang['files:fetch_completed']				= 'اكتمل';
$lang['files:save_failed']					= 'عذراً، تعذر حفظ التغييرات';
$lang['files:item_created']					= 'تم إنشاء "%s"';
$lang['files:item_updated']					= 'تم تحديث "%s"';
$lang['files:item_deleted']					= 'تم حذف "%s"';
$lang['files:item_not_deleted']				= 'تعذر حذف "%s"';
$lang['files:item_not_found']				= 'عذراً، تعذر العثور على "%s"';
$lang['files:sort_saved']					= 'تم حفظ الترتيب';
$lang['files:no_permissions']				= 'ليست لديك صلاحيات كافية';

// Labels
$lang['files:activity']						= 'العمليات';
$lang['files:places']						= 'المواضع';
$lang['files:back']							= 'رجوع';
$lang['files:forward']						= 'تقدم';
$lang['files:start']						= 'ابدأ الرفع';
$lang['files:details']						= 'التفاصيل';
$lang['files:name']							= 'الاسم';
$lang['files:slug']							= 'المختصر';
$lang['files:path']							= 'المسار';
$lang['files:added']						= 'تاريخ الإضافة';
$lang['files:width']						= 'العرض';
$lang['files:height']						= 'الطول';
$lang['files:ratio']						= 'نسبة الحجم';
$lang['files:full_size']					= 'الحجم الكامل';
$lang['files:filename']						= 'اسم الملف';
$lang['files:filesize']						= 'حجم الملف';
$lang['files:download_count']				= 'تعداد التنزيل';
$lang['files:download']						= 'تنزيل';
$lang['files:location']						= 'الموضع';
$lang['files:description']					= 'الوصف';
$lang['files:container']					= 'الحاوية';
$lang['files:bucket']						= 'Bucket';
$lang['files:check_container']				= 'تحقق من الصحة';
$lang['files:search_message']				= 'اكتب واضغط إدخال';
$lang['files:search']						= 'ابحث';
$lang['files:synchronize']					= 'مزامنة';
$lang['files:uploader']						= 'اسحب الملفات إلى هنا<br />أو<br />اضغط لاختيار الملفات';

// Context Menu
$lang['files:open']							= 'فتح';
$lang['files:new_folder']					= 'مجلد جديد';
$lang['files:upload']						= 'رفع';
$lang['files:rename']						= 'تغيير الاسم';
$lang['files:delete']						= 'حذف';
$lang['files:edit']							= 'تعديل';
$lang['files:details']						= 'التفاصيل';

// Folders

$lang['files:no_folders']					= 'تتم إدارة الملفات والمجلدات بطريقة مماثلة لسطح المكتب. اضغط بالزر اليمين في المساحة أدنى هذه الرسالة لإنشاء المجلد الأول. وبعدها اضغط عليه بالزر الأيمن لتغيير اسمه، أو حذفه، أو رفع الملفات إليه، وتغيير بياناته وخياراته كربطه بموضع سحابي.';
$lang['files:no_folders_places']			= 'ستظهر المجلدات التي تنشئها هنا بترتيب شجري يمكن التنقل فيه. اضغط على "المواضع" لعرض المجلد الجذر.';
$lang['files:no_folders_wysiwyg']			= 'لم تنشئ أية مجلدات بعد';
$lang['files:new_folder_name']				= 'مجلد بلا عنوان';
$lang['files:folder']						= 'مجلد';
$lang['files:folders']						= 'مجلدات';
$lang['files:select_folder']				= 'اختر مجلد';
$lang['files:subfolders']					= 'مجلدات فرعية';
$lang['files:root']							= 'الجذر';
$lang['files:no_subfolders']				= 'لا يوجد مجلدات فرعية';
$lang['files:folder_not_empty']				= 'يجب أن تحذف محتوى "%s" أولاً';
$lang['files:mkdir_error']					= 'تعذر إنشاء مجلد upload. يجب أن تنشأه يدوياً';
$lang['files:chmod_error']					= 'مجلد upload للقراءة فقط. يجب تغيير صلاحياته إلى 0777';
$lang['files:location_saved']				= 'تم حفظ موضع المجلد';
$lang['files:container_exists']				= '"%s" exists. Save to link its contents to this folder';
$lang['files:container_not_exists']			= '"%s" does not exist in your account. Save and we will try to create it';
$lang['files:error_container']				= '"%s" could not be created and we could not determine the reason';
$lang['files:container_created']			= '"%s" has been created and is now linked to this folder';
$lang['files:unwritable']					= '"%s" is unwritable, please set its permissions to 0777';
$lang['files:specify_valid_folder']			= 'You must specify a valid folder to upload the file to';
$lang['files:enable_cdn']					= 'You must enable CDN for "%s" via your Rackspace control panel before we can synchronize';
$lang['files:synchronization_started']		= 'بدء المزامنة';
$lang['files:synchronization_complete']		= 'اكتملت عملية مزامنة "%s"';
$lang['files:untitled_folder']				= 'مجلد بلا عنوان';

// Files
$lang['files:no_files']						= 'لا يوجد ملفات';
$lang['files:file_uploaded']				= 'تم رفع "%s"';
$lang['files:unsuccessful_fetch']			= 'We were unable to fetch "%s". Are you sure it is a public file?';
$lang['files:invalid_container']			= '"%s" does not appear to be a valid container.';
$lang['files:no_records_found']				= 'لا يوجد أية سجلات';
$lang['files:invalid_extension']			= 'لاحقة الملف "%s" ممنوعة';
$lang['files:upload_error']					= 'فشل رفع الملف';
$lang['files:description_saved']			= 'تم حفظ وصف الملف';
$lang['files:file_moved']					= 'تم نقل "%s" بنجاح';
$lang['files:exceeds_server_setting']		= 'لا يحتمل الخادم ملفاً بهذا الحجم';
$lang['files:exceeds_allowed']				= 'حجم الملف أكبر من أقصى حد مسموح به';
$lang['files:file_type_not_allowed']		= 'نوع الملف هذا غير مسموح';
$lang['files:type_a']						= 'صوتي';
$lang['files:type_v']						= 'مرئي';
$lang['files:type_d']						= 'مستند';
$lang['files:type_i']						= 'صورة';
$lang['files:type_o']						= 'آخر';

/* End of file files_lang.php */
