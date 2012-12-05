<?php defined('BASEPATH') OR exit('No direct script access allowed');

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
$lang['files:id']							= 'ID';
$lang['files:name']							= 'الاسم';
$lang['files:slug']							= 'المختصر';
$lang['files:path']							= 'المسار';
$lang['files:added']						= 'تاريخ الإضافة';
$lang['files:width']						= 'العرض';
$lang['files:height']						= 'الطول';
$lang['files:ratio']						= 'نسبة الحجم';
$lang['files:alt_attribute']				= 'خاصية alt';
$lang['files:full_size']					= 'الحجم الكامل';
$lang['files:filename']						= 'اسم الملف';
$lang['files:filesize']						= 'حجم الملف';
$lang['files:download_count']				= 'تعداد التنزيل';
$lang['files:download']						= 'تنزيل';
$lang['files:location']						= 'الموضع';
$lang['files:keywords']						= 'الكلمات المفتاحية';
$lang['files:toggle_data_display']			= 'عكس عرض البيانات';
$lang['files:description']					= 'الوصف';
$lang['files:container']					= 'الحاوية';
$lang['files:bucket']						= 'الحاوية';
$lang['files:check_container']				= 'تحقق من الصحة';
$lang['files:search_message']				= 'اكتب واضغط إدخال';
$lang['files:search']						= 'ابحث';
$lang['files:synchronize']					= 'مزامنة';
$lang['files:uploader']						= 'اسحب الملفات إلى هنا<br />أو<br />اضغط لاختيار الملفات';
$lang['files:replace_file']					= 'استبدل الملف';

// Context Menu
$lang['files:refresh']						= 'إعادة التحميل';
$lang['files:open']							= 'فتح';
$lang['files:new_folder']					= 'مجلد جديد';
$lang['files:upload']						= 'رفع';
$lang['files:rename']						= 'تغيير الاسم';
$lang['files:replace']	  					= 'استبدل';
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
$lang['files:container_exists']				= '"%s" موجود مسبقاً. احفظ التغييرات لربط محتواه بهذا المجلد';
$lang['files:container_not_exists']			= '"%s" غير موجود ضمن حسابك. احفظ التغييرات وسنحاول إنشاءه';
$lang['files:error_container']				= 'لسبب ما تعذر إنشاء "%s"';
$lang['files:container_created']			= 'تم إنشاء "%s" وربطه بهذا المجلد';
$lang['files:unwritable']					= 'مجلد "%s" للقراءة فقط، رجاءً تغيير صلاحياته إلى 0777';
$lang['files:specify_valid_folder']			= 'رجاءً حدد اسم مجلد صحيح لرفع الملف إليه';
$lang['files:enable_cdn']					= 'يجب تمكين خدمة CDN للموضع "%s" عبر لوحة تحكم Rackspace قبل أن تتمكن من مزامنة الملفات';
$lang['files:synchronization_started']		= 'بدء المزامنة';
$lang['files:synchronization_complete']		= 'اكتملت عملية مزامنة "%s"';
$lang['files:untitled_folder']				= 'مجلد بلا عنوان';

// Files
$lang['files:no_files']						= 'لا يوجد ملفات';
$lang['files:file_uploaded']				= 'تم رفع "%s"';
$lang['files:unsuccessful_fetch']			= 'تعذر جلب "%s". هل أنت متأكد أنه ملف عام؟';
$lang['files:invalid_container']			= 'يبدو أن "%s" ليس اسم حاوية صحيح.';
$lang['files:no_records_found']				= 'لا يوجد أية سجلات';
$lang['files:invalid_extension']			= 'لاحقة الملف "%s" ممنوعة';
$lang['files:upload_error']					= 'فشل رفع الملف';
$lang['files:description_saved']			= 'تم حفظ وصف الملف';
$lang['files:alt_saved']					= 'تم حفظ خاصية alt للصورة';
$lang['files:file_moved']					= 'تم نقل "%s" بنجاح';
$lang['files:exceeds_server_setting']		= 'لا يحتمل الخادم ملفاً بهذا الحجم';
$lang['files:exceeds_allowed']				= 'حجم الملف أكبر من أقصى حد مسموح به';
$lang['files:file_type_not_allowed']		= 'نوع الملف هذا غير مسموح';
$lang['files:replace_warning']				= 'Warning: Do not replace a file with a file of a different type (e.g. .jpg with .png)';
$lang['files:type_a']						= 'صوتي';
$lang['files:type_v']						= 'مرئي';
$lang['files:type_d']						= 'مستند';
$lang['files:type_i']						= 'صورة';
$lang['files:type_o']						= 'آخر';

/* End of file files_lang.php */
