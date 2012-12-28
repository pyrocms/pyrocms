<?php defined('BASEPATH') or exit('No direct script access allowed');

// tabs
$lang['page_types:html_label']                 = 'HTML';
$lang['page_types:css_label']                  = 'CSS';
$lang['page_types:basic_info']                 = 'البيانات الأساسية';

// labels
$lang['page_types:updated_label']              = 'آخر تحديث';
$lang['page_types:layout']                     = 'التخطيط';
$lang['page_types:auto_create_stream']         = 'أنشئ جدول بيانات جديد';
$lang['page_types:select_stream']              = 'جدول البيانات';
$lang['page_types:theme_layout_label']         = 'تخطيط السّمة';
$lang['page_types:save_as_files']              = 'حفظ كملفات';
$lang['page_types:content_label']              = 'وسم تبويب المحتوى';
$lang['page_types:title_label']                = 'وسم العنوان';
$lang['page_types:sync_files']                 = 'مُزامنة الملفات';

// titles
$lang['page_types:list_title']                 = 'سرد مُخططات الصفحات';
$lang['page_types:list_title_sing']            = 'نوع الصفحة';
$lang['page_types:create_title']               = 'إضافة تخطيط صفحة';
$lang['page_types:edit_title']                 = 'تعديل تخطيط الصفحة "%s"';

// messages
$lang['page_types:no_pages']                   = 'لا يوجد أي تخطيطات صفحات.';
$lang['page_types:create_success_add_fields']  = 'لقد أنشأت نوع صفحة جديد؛ الآن أضف الحقول التي تريدها لهذه هذا النوع من الصفحات.';
$lang['page_types:create_success']             = 'تم إنشاء تخطيط الصفحة.';
$lang['page_types:success_add_tag']            = 'تم إضافة حقل الصفحة. قبل أن تظهر البيانات من هذا الحقل يجب أن تضيف وسمه في مربع النص الخاص بتخطيط نوع الصفحة هذا.';
$lang['page_types:create_error']               = 'لم يتم إنشاء تخطيط الصفحة.';
$lang['page_types:page_type.not_found_error']  = 'تخطيط الصفحة هذا غير موجود.';
$lang['page_types:edit_success']               = 'تم حفظ تخطيط الصفحة "%s".';
$lang['page_types:delete_home_error']          = 'لا يمكنك حذف التخطيط الإفتراضي.';
$lang['page_types:delete_success']             = 'تم حذف تخطيط الصفحة #%s.';
$lang['page_types:mass_delete_success']        = 'تم حذف %s تخطيط صفحة.';
$lang['page_types:delete_none_notice']         = 'لم يتم حذف أي تخطيط صفحة.';
$lang['page_types:already_exist_error']        = 'هناك جدول بهذا الإسم موجود. رجاءً اختر اسماً مختلفاً لنوع الصفحة هذه.';
$lang['page_types:_check_pt_slug_msg']         = 'مُختصر اسم نوع الصفحة يجب أن يكون مميزاً.';

$lang['page_types:variable_introduction']      = 'في مربّع الإدخال هذا يوجد متغيّران متوفّران.';
$lang['page_types:variable_title']             = 'يحتوي عنوان الصفحة.';
$lang['page_types:variable_body']              = 'يحتوي نص HTML للصفحة.';
$lang['page_types:sync_notice']                = 'تم مزامنة %s فقط من نظام الملفات.';
$lang['page_types:sync_success']               = 'تمت مزامنة الملفات بنجاح.';
$lang['page_types:sync_fail']                  = 'تعذرت مزامنة الملفات.';

// Instructions
$lang['page_types:stream_instructions']        = 'سيخزن هذا الجدول الحقول المخصصة لنوع الصفحة. يمكنك اختيار جدول جديد، وإلا سيتم إنشاء جدول لك.';
$lang['page_types:saf_instructions']           = 'انتقاء هذا الخيار سيقوم بحفظ ملف التخطيط للصفحة، إضافة إلى أي ملفات CSS وJS مخصصة في مجلد assets/page_types.';
$lang['page_types:content_label_instructions'] = 'يمكنك هنا تغيير وسم التبويب لحقول جدول أنواع الصفحات.';
$lang['page_types:title_label_instructions']   = 'يمكنك هنا تغيير حقل عنوان الصفحة عن "عنوان". ويفيد هذا الخيار في حال أردت تغيير العنوان إلى شيء مختلف كـ"إسم المنتج" أو "إسم عضو الفريق" مثلاً.';

// Misc
$lang['page_types:delete_message']             = 'متأكد أنك تريد حذف نوع الصفحة هذا؟ سيقوم هذا بحذف <strong>%s</strong> صفحات تستخدم هذا التخطيط، واي صفحات فرعية منها، وأي جداول مرتبطة بهذه الصفحات. <strong>لا يمكن التراجع عن هذه العملية.</strong> ';

$lang['page_types:delete_streams_message']     = 'سيقوم هذا أيضاً بحذف <strong>جدول %s</strong> المرتبط بنوع الصفحة هذا.';
