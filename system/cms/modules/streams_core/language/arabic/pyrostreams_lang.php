<?php defined('BASEPATH') or exit('No direct script access allowed');

/* Messages */

$lang['streams:save_field_error'] 						= "حدث خطأ اثناء حفظ الحقل.";
$lang['streams:field_add_success']						= "أضيف الحقل بنجاح.";
$lang['streams:field_update_error']						= "حدث خطأ أثناء تعديل الحقل.";
$lang['streams:field_update_success']					= "تم تعديل الحقل بنجاح.";
$lang['streams:field_delete_error']						= "حدث خطأ أثناء حذف هذا الحقل.";
$lang['streams:field_delete_success']					= "تم حذف الحقل بنجاح.";
$lang['streams:view_options_update_error']				= "حدث خطأ أثناء تحديث خيارات العرض.";
$lang['streams:view_options_update_success']			= "تم تعديل خيارات العرض بنجاح.";
$lang['streams:remove_field_error']						= "حدث خطأ أثناء إزالة هذا الحقل.";
$lang['streams:remove_field_success']					= "تم إزالة الحقل بنجاح.";
$lang['streams:create_stream_error']					= "حدث خطأ أثناء إنشاء الجدول.";
$lang['streams:create_stream_success']					= "تم إنشاء الجدول بنجاح.";
$lang['streams:stream_update_error']					= "حدث خطأ أثناء تحديث الجدول.";
$lang['streams:stream_update_success']					= "تم تحديث الجدول بنجاح.";
$lang['streams:stream_delete_error']					= "حدث خطأ أثناء حذف هذا الجدول.";
$lang['streams:stream_delete_success']					= "تم حذف الجدول بنجاح.";
$lang['streams:stream_field_ass_add_error']				= "حدث خطأ بإضافة هذا الحقل إلى الجدول.";
$lang['streams:stream_field_ass_add_success']			= "تم إضافة الحقل إلى الجدول بنجاح.";
$lang['streams:stream_field_ass_upd_error']				= "حدث خطأ بتحديث ربط هذا الحقل.";
$lang['streams:stream_field_ass_upd_success']			= "تم تحديث ربط الحقل بنجاح.";
$lang['streams:delete_entry_error']						= "حدث خطأ بحذف هذا المُدخل.";
$lang['streams:delete_entry_success']					= "تم حذف المدخل بنجاح.";
$lang['streams:new_entry_error']						= "حدث خطأ بإضافة هذا المُدخل.";
$lang['streams:new_entry_success']						= "تم إضافة المُدخل بنجاح.";
$lang['streams:edit_entry_error']						= "حدث خطأ بتحديث هذا المُدخل.";
$lang['streams:edit_entry_success']						= "تم تحديث المُدخل بنجاح";
$lang['streams:delete_summary']							= "متأكد أنك تريد حذف الجدول <strong>%s</strong>؟ سيتم <strong>حذف %s %s</strong> نهائياً.";

/* Misc Errors */

$lang['streams:no_stream_provided']						= "لم تحدد أي جدول";
$lang['streams:invalid_stream']							= "جدول غير صالح";
$lang['streams:not_valid_stream']						= "ليس اسم جدول صالح.";
$lang['streams:invalid_stream_id']						= "مُعرّف جدول غير صالح.";
$lang['streams:invalid_row']							= "مُدخل غير صالح.";
$lang['streams:invalid_id']								= "مُعرّف ID غير صالح.";
$lang['streams:cannot_find_assign']						= "تعذر العثور على ربط لهذا الحقل.";
$lang['streams:cannot_find_pyrostreams']				= "تعذر العثور على PyroStreams.";
$lang['streams:table_exists']							= "هناك جدول بيانات له مختصر %s موجود مسبقاً.";
$lang['streams:no_results']								= "لا يوجد نتائج";
$lang['streams:no_entry']								= "تعذر العثور على ما تبحث عنه";
$lang['streams:invalid_search_type']					= "ليس نوع بحث صالح";
$lang['streams:search_not_found']						= "تعذر العثور عن البحث";

/* Validation Messages */

$lang['streams:field_slug_not_unique']					= "مختصر هذا الحقل مستخدم مسبقاً.";
$lang['streams:not_mysql_safe_word']					= "اسم الحقل %s هو كلمة محفوظة لخدمة MySQL";
$lang['streams:not_mysql_safe_characters']				= "الحقل %s يحتوي حروفاً ممنوعة.";
$lang['streams:type_not_valid']							= "رجاءً اختر نوع حقل صحيح.";
$lang['streams:stream_slug_not_unique']					= "الاسم المختصر لهذا الجدول مستخدم مسبقاً.";
$lang['streams:field_unique']							= "قيمة الحقل %s يجب أن تكون مميّزة.";
$lang['streams:field_is_required']						= "الحقل %s مطلوب.";
$lang['streams:date_out_or_range']						= "التاريخ الذي أدخلته ليس ضمن النطاق المقبول.";

/* Field Labels */

$lang['streams:label.field']							= "الحقل";
$lang['streams:label.field_required']					= "الحقل مطلوب";
$lang['streams:label.field_unique']						= "الحقل مُميّر";
$lang['streams:label.field_instructions']				= "تعليمات الحقل";
$lang['streams:label.make_field_title_column']			= "تعيين الحقل كعنوان";
$lang['streams:label.field_name']						= "اسم الحقل";
$lang['streams:label.field_slug']						= "اسم الحقل المختصر";
$lang['streams:label.field_type']						= "نوع الحقل";
$lang['streams:id']										= "مُعرّف ID";
$lang['streams:created_by']								= "أنشأه";
$lang['streams:created_date']							= "تاريخ الإنشاء";
$lang['streams:updated_date']							= "آخر تعديل";
$lang['streams:value']									= "القيمة";
$lang['streams:manage']									= "إدارة";
$lang['streams:search']									= "بحث";
$lang['streams:stream_prefix']							= "سابقة الجدول";

/* Field Instructions */

$lang['streams:instr.field_instructions']				= "تظهر على استمارة إدخال وتعديل البيانات.";
$lang['streams:instr.stream_full_name']					= "الاسم الكامل للجدول.";
$lang['streams:instr.slug']								= "أحرف لاتينية صغيرة، فقط أحرف وعلامة الشرطة السفلية.";

/* Titles */

$lang['streams:assign_field']							= "ربط الحقل بجدول";
$lang['streams:edit_assign']							= "تعديل ربط الجدول";
$lang['streams:add_field']								= "إنشاء الحقل";
$lang['streams:edit_field']								= "تعديل الحقل";
$lang['streams:fields']									= "الحقول";
$lang['streams:streams']								= "الجداول";
$lang['streams:list_fields']							= "سرد الحقول";
$lang['streams:new_entry']								= "مُدخل جديد";
$lang['streams:stream_entries']							= "مُدخلات الجداول";
$lang['streams:entries']								= "المُدخلات";
$lang['streams:stream_admin']							= "إدارة الجداول";
$lang['streams:list_streams']							= "سرد الجداول";
$lang['streams:sure']									= "متأكد؟";
$lang['streams:field_assignments'] 						= "ربط الحقول الجديدة";
$lang['streams:new_field_assign']						= "ربط الحقل الجديد";
$lang['streams:stream_name']							= "اسم الدول";
$lang['streams:stream_slug']							= "مختصر اسم الجدول";
$lang['streams:about']									= "نبذة";
$lang['streams:total_entries']							= "مجموع المُدخلات";
$lang['streams:add_stream']								= "جدول جديد";
$lang['streams:edit_stream']							= "تعديل الجدول";
$lang['streams:about_stream']							= "حول هذا الجدول";
$lang['streams:title_column']							= "عمود العنوان";
$lang['streams:sort_method']							= "طريقة الترتيب";
$lang['streams:add_entry']								= "إضافة مُدخل";
$lang['streams:edit_entry']								= "تعديل المُدخل";
$lang['streams:view_options']							= "عرض الخيارات";
$lang['streams:stream_view_options']					= "خيارات عرض الجدول";
$lang['streams:backup_table']							= "نسخ بيانات الجدول احتياطياً";
$lang['streams:delete_stream']							= "حذف الجدول";
$lang['streams:entry']									= "مُدخل";
$lang['streams:field_types']							= "أنواع الحقول";
$lang['streams:field_type']								= "نوع الحقل";
$lang['streams:database_table']							= "جدول قاعدة البيانات";
$lang['streams:size']									= "الحجم";
$lang['streams:num_of_entries']							= "عدد المُدخلات";
$lang['streams:num_of_fields']							= "عدد الحقول";
$lang['streams:last_updated']							= "آخر تحديث";
$lang['streams:export_schema']							= "تصدير المخطط";

/* Startup */

$lang['streams:start.add_one']							= "أضف قيمة هنا";
$lang['streams:start.no_fields']						= "لم تُضف أي حقول بعد. لتبدأ، يمكنك";
$lang['streams:start.no_assign'] 						= "يبدو أن هذا الجدول لا يحتوي أي حقول بعد. لتبدأ، يمكنك";
$lang['streams:start.add_field_here']					= "إضافة حقل هنا";
$lang['streams:start.create_field_here']				= "إنشاء حقل هنا";
$lang['streams:start.no_streams']						= "ليس هناك أي جداول بعد، لتبدأ، يمكنك";
$lang['streams:start.no_streams_yet']					= "لا يوجد أي جداول بعد.";
$lang['streams:start.adding_one']						= "إضافة جدول";
$lang['streams:start.no_fields_to_add']					= "لا يوجد حقول لإضافتها";
$lang['streams:start.no_fields_msg']					= "لا يوجد أي حقول لإضافتها إلى هذا الجدول. لاستخدام PyroStreams، يمكن مشاركة أنواع الحقول بين الجداول ويجب إنشاءها قبل إضافتها إلى أي جدول. لتبدأ، يمكنك";
$lang['streams:start.adding_a_field_here']				= "إضافة حقل هنا";
$lang['streams:start.no_entries']						= "لا يوجد أي مُدخلات لـ<strong>%s</strong>. كي تبدأ، يمكنك";
$lang['streams:add_fields']								= "ربط الحقول";
$lang['streams:no_entries']								= 'لا يوجد أية بيانات';
$lang['streams:add_an_entry']							= "أضف مُدخل";
$lang['streams:to_this_stream_or']						= "بهذا الجدول أو";
$lang['streams:no_field_assign']						= "الحقل غير مرتبط";
$lang['streams:no_fields_msg_first']					= "يبدو أنه ليس هناك أي حقول بعد في هذا الجدول.";
$lang['streams:no_field_assign_msg']					= "قبل أن تتمكن من إضافة البيانات، يجب أن";
$lang['streams:add_some_fields']						= "تربط بعض الحقول";
$lang['streams:start.before_assign']					= "قبل ربط الحقول بالجداول، يجب أن تنشئ الحقول أولاً. يمكنك";
$lang['streams:start.no_fields_to_assign']				= "يبدو أنه ليس هناك أي حقول يمكن ربطها. قبل أن تستطيع ربط حقل يجب أن  ";

/* Buttons */

$lang['streams:yes_delete']								= "نعم، احذفه";
$lang['streams:no_thanks']								= "لا شكراً";
$lang['streams:new_field']								= "حقل جديد";
$lang['streams:edit']									= "تعديل";
$lang['streams:delete']									= "حذف";
$lang['streams:remove']									= "إزالة";
$lang['streams:reset']									= "استرجاع";

/* Misc */

$lang['streams:field_singular']							= "حقل";
$lang['streams:field_plural']							= "حقول";
$lang['streams:by_title_column']						= "بحسب عمود العنوان";
$lang['streams:manual_order']							= "ترتيب يدوي";
$lang['streams:stream_data_line']						= "عدّل بينات الجدول الأساسية.";
$lang['streams:view_options_line'] 						= "اختر الأعمدة التي يجب أن تظهر في قائمة سرد البيانات.";
$lang['streams:backup_line']							= "انسخ بيانات الجدول وحملها بنسق ملف مضغوط.";
$lang['streams:permanent_delete_line']					= "احذف الجدول وجميع بياناته نهائياً.";
$lang['streams:choose_a_field_type']					= "اختر نوع الحقل";
$lang['streams:choose_a_field']							= "اختر الحقل";

/* reCAPTCHA */

$lang['recaptcha_class_initialized'] 					= "تم بدء تشغيل مكتبة ريكابتشا";
$lang['recaptcha_no_private_key']						= "لم تحدد رمز واجهة التطبيق البرمجية لريكابتشا";
$lang['recaptcha_no_remoteip'] 							= "لأسباب أمنية، يجب أن تمرر رقم IP البعيد لريكابتشا";
$lang['recaptcha_socket_fail'] 							= "تعذر فتح المنفذ";
$lang['recaptcha_incorrect_response'] 					= "جواب صورة الأمان غير صحيح";
$lang['recaptcha_field_name'] 							= "صورة الأمان";
$lang['recaptcha_html_error'] 							= "تعذر تحميل صورة الأمان. رجاءً حاول لاحقاً";

/* Default Parameter Fields */

$lang['streams:max_length'] 							= "أقصى طول";
$lang['streams:upload_location'] 						= "موضع الرفع";
$lang['streams:default_value'] 							= "القيمة الافتراضية";

$lang['streams:menu_path']								= 'مسار القائمة';
$lang['streams:about_instructions']						= 'وصف مختصر للجدول.';
$lang['streams:slug_instructions']						= 'سيكون هذا أيضاً أسم الجدول في قاعدة البيانات.';
$lang['streams:prefix_instructions']					= 'إن استخدمته، سيكون هذا الاسم السابق لأسماء الجداول في قاعدة بياناتك. وهذا مفيد لتجنب تعارض الأسماء.';
$lang['streams:menu_path_instructions']					= 'موضع القسم والقسم الفرعي الذي يجب أن يظهر فيه هذا الجدول في القائمة. افصل بينها بشرطة مائلة - /. مثال <strong>القسم الرئيسي / القسم الفرعي</strong>.';


/* End of file pyrostreams_lang.php */
