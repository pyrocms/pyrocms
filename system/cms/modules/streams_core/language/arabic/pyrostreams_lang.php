<?php defined('BASEPATH') or exit('No direct script access allowed');

/* Messages */

$lang['streams.save_field_error'] 						= "حدث خطأ اثناء حفظ الحقل.";
$lang['streams.field_add_success']						= "أضيف الحقل بنجاح.";
$lang['streams.field_update_error']						= "حدث خطأ أثناء تعديل الحقل.";
$lang['streams.field_update_success']					= "تم تعديل الحقل بنجاح.";
$lang['streams.field_delete_error']						= "حدث خطأ أثناء حذف هذا الحقل.";
$lang['streams.field_delete_success']					= "تم حذف الحقل بنجاح.";
$lang['streams.view_options_update_error']				= "حدث خطأ أثناء تحديث خيارات العرض.";
$lang['streams.view_options_update_success']			= "تم تعديل خيارات العرض بنجاح.";
$lang['streams.remove_field_error']						= "حدث خطأ أثناء إزالة هذا الحقل.";
$lang['streams.remove_field_success']					= "تم إزالة الحقل بنجاح.";
$lang['streams.create_stream_error']					= "There was a problem creating your stream.";
$lang['streams.create_stream_success']					= "Stream created successfully.";
$lang['streams.stream_update_error']					= "There was a problem updating this stream.";
$lang['streams.stream_update_success']					= "Stream updated successfully.";
$lang['streams.stream_delete_error']					= "There was a problem with deleting this stream.";
$lang['streams.stream_delete_success']					= "Stream deleted successfully.";
$lang['streams.stream_field_ass_add_error']				= "There was a problem adding this field to this stream.";
$lang['streams.stream_field_ass_add_success']			= "Field added to stream successfully.";
$lang['streams.stream_field_ass_upd_error']				= "There was a problem updating this field assignment.";
$lang['streams.stream_field_ass_upd_success']			= "Field assignment updated successfully.";
$lang['streams.delete_entry_error']						= "There was a problem deleting this entry.";
$lang['streams.delete_entry_success']					= "Entry deleted successfully.";
$lang['streams.new_entry_error']						= "There was a problem adding this entry.";
$lang['streams.new_entry_success']						= "Entry added successfully.";
$lang['streams.edit_entry_error']						= "There was a problem updating this entry.";
$lang['streams.edit_entry_success']						= "Entry updated successfully.";
$lang['streams.delete_summary']							= "Are you sure you want to delete the <strong>%s</strong> stream? This will <strong>delete %s %s</strong> permanently.";

/* Misc Errors */

$lang['streams.no_stream_provided']						= "No stream was provided.";
$lang['streams.invalid_stream']							= "Invalid stream.";
$lang['streams.not_valid_stream']						= "is not a valid stream.";
$lang['streams.invalid_stream_id']						= "Invalid stream ID.";
$lang['streams.invalid_row']							= "Invalid row.";
$lang['streams.invalid_id']								= "مُعرّف ID غير صالح.";
$lang['streams.cannot_find_assign']						= "Cannot find field assignment.";
$lang['streams.cannot_find_pyrostreams']				= "Cannot find PyroStreams.";
$lang['streams.table_exists']							= "A table with the slug %s already exists.";
$lang['streams.no_results']								= "لا يوجد نتائج";
$lang['streams.no_entry']								= "تعذر العثور على ما تبحث عنه";
$lang['streams.invalid_search_type']					= "is not a valid search type.";
$lang['streams.search_not_found']						= "Search not found.";

/* Validation Messages */

$lang['streams.field_slug_not_unique']					= "مختصر هذا الحقل مستخدم مسبقاً.";
$lang['streams.not_mysql_safe_word']					= "اسم الحقل %s هو كلمة محفوظة لخدمة MySQL";
$lang['streams.not_mysql_safe_characters']				= "الحقل %s يحتوي حروفاً ممنوعة.";
$lang['streams.type_not_valid']							= "رجاءً اختر نوع حقل صحيح.";
$lang['streams.stream_slug_not_unique']					= "This stream slug is already in use.";
$lang['streams.field_unique']							= "قيمة الحقل %s يجب أن تكون مميّزة.";
$lang['streams.field_is_required']						= "الحقل %s مطلوب.";

/* Field Labels */

$lang['streams.label.field']							= "الحقل";
$lang['streams.label.field_required']					= "الحقل مطلوب";
$lang['streams.label.field_unique']						= "الحقل مُميّر";
$lang['streams.label.field_instructions']				= "تعليمات الحقل";
$lang['streams.label.make_field_title_column']			= "Make field the title column";
$lang['streams.label.field_name']						= "اسم الحقل";
$lang['streams.label.field_slug']						= "Field Slug";
$lang['streams.label.field_type']						= "نوع الحقل";
$lang['streams.id']										= "مُعرّف ID";
$lang['streams.created_by']								= "أنشأه";
$lang['streams.created_date']							= "تاريخ الإنشاء";
$lang['streams.updated_date']							= "آخر تعديل";
$lang['streams.value']									= "القيمة";
$lang['streams.manage']									= "إدارة";
$lang['streams.search']									= "بحث";
$lang['streams:stream_prefix']							= "Stream Prefix";

/* Field Instructions */

$lang['streams.instr.field_instructions']				= "Displayed on form when entering or editing data.";
$lang['streams.instr.stream_full_name']					= "Full name for your stream.";
$lang['streams.instr.slug']								= "Lowercase, just letters and underscores.";

/* Titles */

$lang['streams.assign_field']							= "Assign Field to Stream";
$lang['streams.edit_assign']							= "Edit Stream Assignment";
$lang['streams.add_field']								= "إنشاء الحقل";
$lang['streams.edit_field']								= "تعديل الحقل";
$lang['streams.fields']									= "الحقول";
$lang['streams.streams']								= "Streams";
$lang['streams.list_fields']							= "سرد الحقول";
$lang['streams.new_entry']								= "New Entry";
$lang['streams.stream_entries']							= "Stream Entries";
$lang['streams.entries']								= "Entries";
$lang['streams.stream_admin']							= "Stream Admin";
$lang['streams.list_streams']							= "List Streams";
$lang['streams.sure']									= "Are You Sure?";
$lang['streams.field_assignments'] 						= "Stream Field Assignments";
$lang['streams.new_field_assign']						= "New Field Assignment";
$lang['streams.stream_name']							= "Stream Name";
$lang['streams.stream_slug']							= "Stream Slug";
$lang['streams.about']									= "نبذرة";
$lang['streams.total_entries']							= "Total Entries";
$lang['streams.add_stream']								= "New Stream";
$lang['streams.edit_stream']							= "Edit Stream";
$lang['streams.about_stream']							= "About This Stream";
$lang['streams.title_column']							= "Title Column";
$lang['streams.sort_method']							= "Sort Method";
$lang['streams.add_entry']								= "Add Entry";
$lang['streams.edit_entry']								= "Edit Entry";
$lang['streams.view_options']							= "View Options";
$lang['streams.stream_view_options']					= "Stream View Options";
$lang['streams.backup_table']							= "Backup Stream Table";
$lang['streams.delete_stream']							= "Delete Stream";
$lang['streams.entry']									= "مُدخل";
$lang['streams.field_types']							= "أنواع الحقول";
$lang['streams.field_type']								= "نوع الحقل";
$lang['streams.database_table']							= "جدول قاعدة البيانات";
$lang['streams.size']									= "الحجم";
$lang['streams.num_of_entries']							= "عدد المُدخلات";
$lang['streams.num_of_fields']							= "عدد الحقول";
$lang['streams.last_updated']							= "آخر تحديث";

/* Startup */

$lang['streams.start.add_one']							= "أضف قيمة هنا";
$lang['streams.start.no_fields']						= "You have not created any fields yet. To start, you can";
$lang['streams.start.no_assign'] 						= "Looks like there are no fields yet for this stream. To start, you can";
$lang['streams.start.add_field_here']					= "add a field here";
$lang['streams.start.create_field_here']				= "create a field here";
$lang['streams.start.no_streams']						= "There are no streams yet, but can start by";
$lang['streams.start.no_streams_yet']					= "There are no streams yet.";
$lang['streams.start.adding_one']						= "adding one";
$lang['streams.start.no_fields_to_add']					= "No Fields to Add";		
$lang['streams.start.no_fields_msg']					= "There are no fields to add to this stream. In PyroStreams, field types can be shared between streams and must be created before being added to a stream. You can start by";
$lang['streams.start.adding_a_field_here']				= "adding a field here";
$lang['streams.start.no_entries']						= "There are no entries yet for <strong>%s</strong>. To start, you can";
$lang['streams.add_fields']								= "assign fields";
$lang['streams.add_an_entry']							= "add an entry";
$lang['streams.to_this_stream_or']						= "to this stream or";
$lang['streams.no_field_assign']						= "No Field Assignments";
$lang['streams.no_fields_msg_first']					= "Looks like there are no fields yet for this stream.";
$lang['streams.no_field_assign_msg']					= "Before you start entering data, you need to";
$lang['streams.add_some_fields']						= "assign some fields";
$lang['streams.start.before_assign']					= "Before assigning fields to a stream, you need to create a field. You can";
$lang['streams.start.no_fields_to_assign']				= "Looks like there are no fields available to be assigned. Before you can assign a field you must ";

/* Buttons */

$lang['streams.yes_delete']								= "نعم، احذفه";
$lang['streams.no_thanks']								= "لا شكراً";
$lang['streams.new_field']								= "حقل جديد";
$lang['streams.edit']									= "تعديل";
$lang['streams.delete']									= "حذف";
$lang['streams.remove']									= "إزالة";
$lang['streams.reset']									= "استرجاع";

/* Misc */

$lang['streams.field_singular']							= "حقل";
$lang['streams.field_plural']							= "حقول";
$lang['streams.by_title_column']						= "بحسب عمود العنوان";
$lang['streams.manual_order']							= "ترتيب يدوي";
$lang['streams.stream_data_line']						= "Edit basic stream data.";
$lang['streams.view_options_line'] 						= "Choose which columns should be visible on the list data page.";
$lang['streams.backup_line']							= "Backup and download stream table into a zip file.";
$lang['streams.permanent_delete_line']					= "Permanently delete a stream and all stream data.";
$lang['streams.choose_a_field_type']					= "اختر نوع الحقل";
$lang['streams.choose_a_field']							= "اختر الحقل";

/* reCAPTCHA */

$lang['recaptcha_class_initialized'] 					= "reCaptcha Library Initialized";
$lang['recaptcha_no_private_key']						= "You did not supply an API key for Recaptcha";
$lang['recaptcha_no_remoteip'] 							= "For security reasons, you must pass the remote ip to reCAPTCHA";
$lang['recaptcha_socket_fail'] 							= "Could not open socket";
$lang['recaptcha_incorrect_response'] 					= "Incorrect Security Image Response";
$lang['recaptcha_field_name'] 							= "Security Image";
$lang['recaptcha_html_error'] 							= "Error loading security image.  Please try again later";

/* Default Parameter Fields */

$lang['streams.max_length'] 							= "أقصى طول";
$lang['streams.upload_location'] 						= "موضع الرفع";
$lang['streams.default_value'] 							= "القيمة الافتراضية";

/* End of file pyrostreams_lang.php */
