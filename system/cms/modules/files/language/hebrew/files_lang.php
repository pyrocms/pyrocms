<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PyroCMS
 *
 * Hebrew translation by anatolykhelmer
 *
 * @package		PyroCMS
 * @author		Anatoly Khelmer
 * @license		Apache License v2.0
 * @link		http://pyrocms.com
 * @since		Version 1.0-dev
 * @filesource
 */

// Files

// Titles
$lang['files.files_title']				= 'קבצים';
$lang['files.upload_title']				= 'העלאת קבצים';
$lang['files.edit_title']                               = 'עריכת קובץ "%s"';

// Labels
$lang['files.actions_label']    			= 'פעולות';
$lang['files.download_label']				= 'הורדה';
$lang['files.edit_label']				= 'ערוך';
$lang['files.delete_label']				= 'מחק';
$lang['files.upload_label']				= 'העלא';
$lang['files.description_label']                        = 'תיאור';
$lang['files.type_label']                               = 'סוג';
$lang['files.file_label']                               = 'קובץ';
$lang['files.filename_label']                           = 'שם קובץ';
$lang['files.filter_label']                             = 'מסנן';
$lang['files.loading_label']                            = 'בטעינה...';
$lang['files.name_label']                               = 'שם';

$lang['files.dropdown_no_subfolders']                   = '-- אין --';
$lang['files.dropdown_root']				= '-- שורש --';

// Types
$lang['files.type_i'] = 'תמונה';
$lang['files.type_a'] = 'אודיו';
$lang['files.type_v'] = 'וידיאו';
$lang['files.type_d'] = 'מסמך';
$lang['files.type_o'] = 'אחר';

$lang['files.display_grid'] = 'רשת';
$lang['files.display_list'] = 'רשימה';

// Messages
$lang['files.create_success']				= 'הקובץ נשמר בהצלחה.';
$lang['files.create_error']					= 'התרחשה שגיעה.';
$lang['file_folders.duplicate_error']		= 'A folder named "%s" already exists.'; #translate
$lang['files.edit_success']					= 'הקובץ עודכן בהצלחה.';
$lang['files.edit_error']					= 'התרחשה שגיעה בעת ניסיון לשמור קובץ.';
$lang['files.delete_success']				= 'הקובץ נמחק בהצלחה.';
$lang['files.delete_error']					= 'אין אפשרות למחוק את הקובץ.';
$lang['files.mass_delete_success']			= '%d מתוך %d קבצים נמחקו בהצלחה. הם היו %s ו-%s';
$lang['files.mass_delete_error']			= 'התרחשה שגיעה בעת ניסיון למחוק %d קבצים מתוך %d. הם היו %s ו-%s';
$lang['files.upload_error']					= 'חייבים להעלאות קובץ!';
$lang['files.invalid_extension']			= 'חייבת להיות סיומת חוקית לקובץ!';
$lang['files.not_exists']					= 'התיקיה שנבחרה אינה קיימת!';
$lang['files.no_files']						= 'כעת אין קבצים בכלל!';
$lang['files.no_permissions']				= 'אין לכם הרשאות כדי לראות את המודול!';
$lang['files.no_select_error'] 				= 'עליכם לבחור קובץ קודם כל!';

// File folders

// Titles
$lang['file_folders.folders_title']			= 'תיקיות';
$lang['file_folders.manage_title']			= 'ניהול תיקיות';
$lang['file_folders.create_title']			= 'תיקיה חדשה';
$lang['file_folders.delete_title']			= 'אשר מחיקה';
$lang['file_folders.edit_title']			= 'עריכת תיקיה "%s"';

// Labels
$lang['file_folders.folders_label']			= 'תיקיות';
$lang['file_folders.folder_label']			= 'תיקיה';
$lang['file_folders.subfolders_label']		= 'תת-תיקיה';
$lang['file_folders.parent_label']			= 'אב';
$lang['file_folders.name_label']			= 'שם';
$lang['file_folders.slug_label']			= 'כתובת URL';
$lang['file_folders.created_label']			= 'נוצר ב';

// Messages
$lang['file_folders.create_success']		= 'התיקיה נוצרה בהצלחה.';
$lang['file_folders.create_error']			= 'התרחשה שגיעה בעת ניסיון לשמור תיקיה';
$lang['file_folders.edit_success']			= 'התיקיה עודכנה בהצלחה.';
$lang['file_folders.edit_error']			= 'התרחשה שגיעה בעת ניסיון לעדכן את התיקיה';
$lang['file_folders.confirm_delete']		= 'אתם בטוחים שרוצים למחוק את התיקיה לגמרי יחד עם כל התת-תיקיות וקבצים?'; 
$lang['file_folders.delete_mass_success']	= '%d תיקיות מתוך %d נמחקו בהצלחה. הם היו %s ו-%s';
$lang['file_folders.delete_mass_error']		= 'התרחשה שגיעה בעת ניסיון למחוק %d קבצים מתוך %d. הם היו %s ו-%s';
$lang['file_folders.delete_success']		= 'התיקיה "%s" נמחקה בהצלחה.';
$lang['file_folders.delete_error']			= 'התרחשה שגיעה בעת ניסיון למחוק תיקיה "%s"';
$lang['file_folders.not_exists']			= 'התיקיה שבחרתם אינה קיימת!';
$lang['file_folders.no_subfolders']			= 'אין';
$lang['file_folders.no_folders']			= 'Your files are sorted by folders, currently you do not have any folders setup.';
$lang['file_folders.mkdir_error']			= 'התרחשה שגיעה בעת ביצוע פקודה "make uploads/files"!';
$lang['file_folders.chmod_error']			= 'התרחשהשגיעה בעת ביצוע פקודה "chmod uploads/files"!';

/* End of file files_lang.php */