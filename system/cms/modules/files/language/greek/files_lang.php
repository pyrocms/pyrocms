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
$lang['files.files_title']					= 'Αρχεία';
$lang['files.upload_title']					= 'Ανέβασμα Αρχείων';
$lang['files.edit_title']					= 'Επεξεργασία αρχείου "%s"';

// Labels
$lang['files.actions_label']				= 'Ενέργεια';
$lang['files.download_label']				= 'Μεταφόρτωση';
$lang['files.edit_label']					= 'Επεξεργασία';
$lang['files.delete_label']					= 'Διαγραφή';
$lang['files.upload_label']					= 'Ανέβασμα';
$lang['files.description_label']			= 'Περιγραφή';
$lang['files.type_label']					= 'Τύπος';
$lang['files.file_label']					= 'Αρχείο';
$lang['files.filename_label']				= 'Όνομα Αρχείου';
$lang['files.filter_label']					= 'Φίλτρο';
$lang['files.loading_label']				= 'Φορτώνει...';
$lang['files.name_label']					= 'Όνομα';

$lang['files.dropdown_no_subfolders']		= '-- Κανένας --';
$lang['files.dropdown_root']				= '-- Αρχικός --';

$lang['files.type_a']						= 'Ηχητικό';
$lang['files.type_v']						= 'Video';
$lang['files.type_d']						= 'Έγγραφο';
$lang['files.type_i']						= 'Εικόνα';
$lang['files.type_o']						= 'Άλλο';

$lang['files.display_grid']					= 'Κάνναβος';
$lang['files.display_list']					= 'Λίστα';

// Messages
$lang['files.create_success']				= 'Το αρχείο αποθηκεύτηκε.';
$lang['files.create_error']					= 'Συνέβη κάποιο σφάλμα.';
$lang['files.edit_success']					= 'Το αρχείο αποθηκεύτηκε επιτυχώς.';
$lang['files.edit_error']					= 'Συνέβη κάποιο σφάλμα κατά την αποθήκευση του αρχείου.';
$lang['files.delete_success']				= 'Το αρχείο διαγράφηκε.';
$lang['files.delete_error']					= 'Δεν ήταν δυνατό να διαγραφεί το αρχείο.';
$lang['files.mass_delete_success']			= '%d από τα %d αρχεία διαγράφηκαν, ήταν "%s και %s"';
$lang['files.mass_delete_error']			= 'Συνέβη κάποιο σφάλμα κατά την διαγραφή %d από %d αρχείων, είναι "%s και %s".';
$lang['files.upload_error']					= 'Πρέπει να μεταφορτωθεί ένα αρχείο.';
$lang['files.invalid_extension']			= 'Το αρχείο πρέπει να έχει μια επέκταση.';
$lang['files.not_exists']					= 'Επιλέχθηκε μη έγκυρος φάκελος.';
$lang['files.no_files']						= 'Προς το παρόν δεν υπάρχουν αρχεία.';
$lang['files.no_permissions']				= 'Δεν έχετε δικαίωμα να δείτε το πρόσθετο Αρχεία.';
$lang['files.no_select_error'] 				= 'Πρέπει να επιλέξετε ένα αρχείο πρώτα, αυτή η αίτηση διεκόπει.';

// File folders

// Titles
$lang['file_folders.folders_title']			= 'Φάκελοι Αρχείων';
$lang['file_folders.manage_title']			= 'Διαχείριση Φακέλων';
$lang['file_folders.create_title']			= 'Νέος Φάκελος';
$lang['file_folders.delete_title']			= 'Επιβεβαίωση Διαγραφής';
$lang['file_folders.edit_title']			= 'Edit folder "%s"';

// Labels
$lang['file_folders.folders_label']			= 'Φάκελοι';
$lang['file_folders.folder_label']			= 'Φάκελος';
$lang['file_folders.subfolders_label']		= 'Υποφακέλοι';
$lang['file_folders.parent_label']			= 'Γονέας';
$lang['file_folders.name_label']			= 'Όνομα';
$lang['file_folders.slug_label']			= 'Σύντομη ονομασία URL';
$lang['file_folders.created_label']			= 'Δημιουργήθηκε στις';

// Messages
$lang['file_folders.create_success']		= 'Ο φάκελος αποθηκεύτηκε.';
$lang['file_folders.create_error']			= 'Συνέβη κάποιο σφάλμα κατά την προσπάθεια να δημιουργηθεί ο φάκελος.';
$lang['file_folders.edit_success']			= 'Οι αλλαγές στο φάκελο αποθηκεύτηκαν επιτυχώς.';
$lang['file_folders.edit_error']			= 'Συνέβη κάποιο σφάλμα κατά την προσπάθεια να αποθηκευτούν οι αλλαγές.';
$lang['file_folders.confirm_delete']		= 'Είσαστε σίγουροι ότι θέλετε να διαγράψετε τους παρακάτω φακέλους μαζί με τα αρχεία που υπάρχουν μέσα σε αυτούς;';
$lang['file_folders.delete_mass_success']	= '%d από τους %d φακέλους διαγράφηκαν επιτυχώς, ήταν "%s και %s".';
$lang['file_folders.delete_mass_error']		= 'Συνέβη κάποιο σφάλμα κατά την προσπάθεια να διαγραφούν %d από %d φάκελοι, είναι "%s και %s".';
$lang['file_folders.delete_success']		= 'Ο φάκελος "%s" διαγράφηκε.';
$lang['file_folders.delete_error']			= 'Συνέβη κάποιο σφάλμα κατά την πρόσπαθεια διαγραφής του φακέλου "%s".';
$lang['file_folders.not_exists']			= 'Επιλέχθηκε ένας μη έγκυρος φάκελος.';
$lang['file_folders.no_subfolders']			= 'Κανένας';
$lang['file_folders.no_folders']			= 'Τα αρχεία σας ταξινομούνται κατά φακέλους, προς το παρόν δεν έχετε ορίσει κανέναν φάκελο.';
$lang['file_folders.mkdir_error']			= 'Δεν ήταν δυνατό να δημιουργηθεί ο φάκελος uploads/files';
$lang['file_folders.chmod_error']			= 'Δεν ήταν δυνατό να αλλαχτούν τα δικαιώματα (chmod) του φακέλου uploads/files';

/* End of file files_lang.php */