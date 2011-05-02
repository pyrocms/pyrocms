<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PyroCMS
 *
 * An open source CMS based on CodeIgniter
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @license		Apache License v2.0
 * @link		http://pyrocms.com
 * @since		Version 1.0-dev
 * @filesource
 */

// Files

// Titles
$lang['files.files_title']					= 'الملفات';
$lang['files.upload_title']					= 'رفع الملفات';
$lang['files.edit_title']					= 'تعديل الملف "%s"';

// Labels
$lang['files.actions_label']				= 'الإجراء';
$lang['files.download_label']				= 'تنزيل';
$lang['files.edit_label']					= 'تعديل';
$lang['files.delete_label']					= 'حذف';
$lang['files.upload_label']					= 'رفع';
$lang['files.description_label']			= 'الوصف';
$lang['files.type_label']					= 'النوع';
$lang['files.file_label']					= 'الملف';
$lang['files.filename_label']				= 'إسم الملف';
$lang['files.filter_label']					= 'انتقاء';
$lang['files.loading_label']				= 'جاري التحميل...';
$lang['files.name_label']					= 'الاسم';

$lang['files.dropdown_no_subfolders']		= '-- لاشيء --';
$lang['files.dropdown_root']				= '-- رئيسي --';

$lang['files.type_a']						= 'صوت';
$lang['files.type_v']						= 'فيديو';
$lang['files.type_d']						= 'مستند';
$lang['files.type_i']						= 'صورة';
$lang['files.type_o']						= 'آخر';

$lang['files.display_grid']					= 'شبكي';
$lang['files.display_list']					= 'سرد';

// Messages
$lang['files.create_success']				= 'تم حفظ الملف.';
$lang['files.create_error']					= 'حدث خطأ ما.';
$lang['files.edit_success']					= 'تم حفظ الملف بنجاح.';
$lang['files.edit_error']					= 'حدث خطأ أثناء محاولة حفظ الملف.';
$lang['files.delete_success']				= 'تم حذف الملف';
$lang['files.delete_error']					= 'تعذر حذف الملف.';
$lang['files.mass_delete_success']			= '%d من %d ملفات تم حذفها بنجاح، وهي "%s و %s"';
$lang['files.mass_delete_error']			= 'حدث خطأ أثناء محاولة حذف %d من %d ملفات، والتي هي "%s و %s".';
$lang['files.upload_error']					= 'يجب رفع ملف.';
$lang['files.invalid_extension']			= 'يجب أن يكون للملف امتداد صحيحة.';
$lang['files.not_exists']					= 'تم اختيار مجلد غير صالح.';
$lang['files.no_files']						= 'لا يوجد أية ملفات.';
$lang['files.no_permissions']				= 'ليست لديك صلاحية الوصول إلى وحدة الملفات.';
$lang['files.no_select_error'] 				= 'يجب أن تختار ملفاً أولاً. تم إيقاف هذا الطلب.';

// File folders

// Titles
$lang['file_folders.folders_title']			= 'مجلدات الملفات';
$lang['file_folders.manage_title']			= 'إدارة المجلدات';
$lang['file_folders.create_title']			= 'مجلد جديد';
$lang['file_folders.delete_title']			= 'تأكيد الحذف';
$lang['file_folders.edit_title']			= 'تعديل المجلد "%s"';

// Labels
$lang['file_folders.folders_label']			= 'مجلدات';
$lang['file_folders.folder_label']			= 'مجلد';
$lang['file_folders.subfolders_label']		= 'مجلدات فرعية';
$lang['file_folders.parent_label']			= 'المحتوي';
$lang['file_folders.name_label']			= 'الإسم';
$lang['file_folders.slug_label']			= 'مختصر URL';
$lang['file_folders.created_label']			= 'أنشئ في';

// Messages
$lang['file_folders.create_success']		= 'تم حفظ المجلد.';
$lang['file_folders.create_error']			= 'حدث خطأ اثناء محاولة إنشاء المجلد.';
$lang['file_folders.duplicate_error']		= 'هناك مجلد مسمى "%s" موجود مسبقاً.';
$lang['file_folders.edit_success']			= 'تم حفظ المجلد بنجاح.';
$lang['file_folders.edit_error']			= 'حدث خطأ أثناء محاولة حفظ التغييرات.';
$lang['file_folders.confirm_delete']		= 'متأكد أنك تريد حذف المجلدات أدناه، بما فيها من ملفات ومجلدات فرعية؟';
$lang['file_folders.delete_mass_success']	= '%d من %d مجلدات تم حذفها بنجاح، وهي "%s و %s.';
$lang['file_folders.delete_mass_error']		= 'حدث خطأ أثناء محاولة حذف المجلدات %d من %d، وهي "%s و %s".';
$lang['file_folders.delete_success']		= 'تم حذف المجلد "%s".';
$lang['file_folders.delete_error']			= 'حدث خطأ أثناء محاولة حذف المجلد "%s".';
$lang['file_folders.not_exists']			= 'تم اختيار مجلد غير صالح.';
$lang['file_folders.no_subfolders']			= 'لاشيء';
$lang['file_folders.no_folders']			= 'ملفاتك مرتبة ضمن مجلدات، وليس لديك حالياً أية مجلدات مُعدّة.';
$lang['file_folders.mkdir_error']			= 'تعذر إنشاء دليل الملفات المرفوعة';
$lang['file_folders.chmod_error']			= 'تعذر تنفيذ chmod على دليل الملفات المرفوعة';

/* End of file files_lang.php */
