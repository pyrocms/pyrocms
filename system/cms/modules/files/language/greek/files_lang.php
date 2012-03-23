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
$lang['files:files_title']					= 'Αρχεία';
$lang['files:fetching']						= 'Ανάκτηση δεδομένων...';
$lang['files:fetch_completed']				= 'Ολοκληρώθηκε';
$lang['files:save_failed']					= 'Οι αλλαγές δεν ήταν δυνατό να αποθηκευτούν';
$lang['files:item_created']					= 'Το "%s" δημιουργήθηκε';
$lang['files:item_updated']					= 'Το "%s" ενημερώθηκε';
$lang['files:item_deleted']					= 'Το "%s" διαγράφηκε';
$lang['files:item_not_deleted']				= 'Το "%s" δεν ήταν δυνατό να διαγραφεί';
$lang['files:item_not_found']				= 'Το "%s" δεν βρέθηκε';
$lang['files:sort_saved']					= 'Η σειρά ταξινόμησης αποθηκεύτηκε';
$lang['files:no_permissions']				= 'Δεν έχετε τα απαραίτητα δικαιώματα';

// Labels
$lang['files:activity']						= 'Ενέργειες';
$lang['files:places']						= 'Τοποθεσίες';
$lang['files:back']							= 'Πίσω';
$lang['files:forward']						= 'Εμπρός';
$lang['files:start']						= 'Εκκίνηση';
$lang['files:details']						= 'Λεπτομέρειες';
$lang['files:name']							= 'Όνομα';
$lang['files:slug']							= 'Σύντομο όνομα';
$lang['files:path']							= 'Διαδρομή';
$lang['files:added']						= 'Ημερομηνία προσθήκης';
$lang['files:width']						= 'Πλάτος';
$lang['files:height']						= 'Ύψος';
$lang['files:ratio']						= 'Αναλογία';
$lang['files:full_size']					= 'Πλήρες Μέγεθος';
$lang['files:filename']						= 'Όνομα αρχείου';
$lang['files:filesize']						= 'Μέγεθος αρχείου';
$lang['files:download_count']				= 'Αριθμός μεταφορτώσεων';
$lang['files:download']						= 'Λήψη';
$lang['files:location']						= 'Τοποθεσία';
$lang['files:description']					= 'Περιγραφή';
$lang['files:container']					= 'Container';
$lang['files:bucket']						= 'Bucket';
$lang['files:check_container']				= 'Έλεγχος Εγκυρότητας';
$lang['files:search_message']				= 'Εισάγετε όρο & Enter';
$lang['files:search']						= 'Αναζήτηση';
$lang['files:synchronize']					= 'Συγχρονισμός';
$lang['files:uploader']						= 'Drop files here <br />or<br />Click to select files'; #translate

// Context Menu
$lang['files:open']							= 'Άνοιγμα';
$lang['files:new_folder']					= 'Νέος Φάκελος';
$lang['files:upload']						= 'Ανέβασμα';
$lang['files:rename']						= 'Μετονομασία';
$lang['files:delete']						= 'Διαγραφή';
$lang['files:edit']							= 'Επεξεργασία';
$lang['files:details']						= 'Λεπτομέρειες';

// Folders

$lang['files:no_folders']					= 'Η διαχείριση αρχείων και φακέλων γίνεται περίπου όπως και στον υπολογιστή σας. Κάντε δεξί κλικ στην περιοχή κάτω από αυτό το μήνυμα για να δημιουργήσετε τον πρώτο σας φάκελο. Στην συνέχεια μπορείτε να τον μετονομάσετε, αν ανεβάσετε σε αυτόν αρχεία ή και να τροποποιήσετε τις λεπτομέρειές του όπως για παράδειγμα να τον συνδέσετε με μια τοποθεσία στο cloud.';
$lang['files:no_folders_places']			= 'Folders that you create will show up here in a tree that can be expanded and collapsed. Click on "Places" to view the root folder.';
$lang['files:no_folders_places']			= 'Οι φάκελοι που θα δημιουργήσετε θα εμφανίζονται εδώ σε διάταξη δένδρου που μπορείτε να αναπτύξετε ή να συμπτύξετε. Κάντε κλικ στο "Τοποθεσίες" για να δείτε το αρχικό επίπεδο.';
$lang['files:no_folders_wysiwyg']			= 'Δεν έχουν δημιουργηθεί ακόμη φάκελοι';
$lang['files:new_folder_name']				= 'Φάκελος Χωρίς Όνομα';
$lang['files:folder']						= 'Φάκελος';
$lang['files:folders']						= 'Φάκελοι';
$lang['files:select_folder']				= 'Επιλέξτε έναν φάκελο';
$lang['files:subfolders']					= 'Υποφάκελοι';
$lang['files:root']							= 'Αρχικός';
$lang['files:no_subfolders']				= 'Χωρίς υποφακέλους';
$lang['files:folder_not_empty']				= 'Πρέπει πρώτα να διαγράψετε τα περιεχόμενα του "%s"';
$lang['files:mkdir_error']					= 'Δεν ήταν δυνατό να δημιουργηθεί ο φάκελος που θα αποθηκεύονται οι μεταφορτώσεις. Πρέπει να τον δημιουργήσετε χειρονακτικά';
$lang['files:chmod_error']					= 'Ο φάκελος αποθήκευσης των μεταφορτώσεων δεν είναι εγγράψιμος. Πρέπει να έχει δικαιώματα 0777';
$lang['files:location_saved']				= 'Η τοποθεσία του φακέλου σας αποθηκεύτηκε';
$lang['files:container_exists']				= 'Το "%s" υπάρχει. Αποθηκεύστε για να συνδεθούν τα περιεχόμενά του με αυτόν τον φάκελο';
$lang['files:container_not_exists']			= 'Το "%s" δεν υπάρχει στον λογαριασμό σας. Αποθηκεύστε και θα προσπαθήσουμε να το δημιουργήσουμε';
$lang['files:error_container']				= 'Το "%s" δεν ήταν δυνατό να δημιουργηθεί και ο λόγος δεν μπορεί να προσδιοριστεί';
$lang['files:container_created']			= 'Το "%s" δημιουργήθηκε και πλέον είναι συνδεδεμένο με αυτόν τον φάκελο';
$lang['files:unwritable']					= 'Το "%s" δεν είναι εγγράψιμο, ορίστε τα δικαιώματά του σε 0777';
$lang['files:specify_valid_folder']			= 'Πρέπει να ορίσετε έναν έγκυρο φάκελο όπου θα ανέβει και το αρχείο';
$lang['files:enable_cdn']					= 'Πρέπει να ενεργοποιήσετε το CDN για "%s" μέσα από την περιοχή ελέγχου του Rackspace προτού να μπορείτε να συγχρονίσετε';
$lang['files:synchronization_started']		= 'Εκκίνηση συγχρονισμού';
$lang['files:synchronization_complete']		= 'Ο συγχρονισμός του φακέλου "%s" ολοκληρώθηκε';

// Files
$lang['files:no_files']						= 'Δεν βρέθηκαν αρχεία';
$lang['files:file_uploaded']				= 'Το "%s" ανέβηκε';
$lang['files:unsuccessful_fetch']			= 'Δεν ήταν δυνατό να πάρουμε το "%s". Είσαστε σίγουροι ότι είναι ένα δημόσια προσβάσιμο αρχείο;';
$lang['files:invalid_container']			= 'Το "%s" δεν φαίνεται να είναι ένα έγκυρο container.';
$lang['files:no_records_found']				= 'Δεν ήταν δυνατό να βρεθούν εγγραφές';
$lang['files:invalid_extension']			= 'Το "%s" έχει μια μη αποδεκτή επέκταση αρχείου';
$lang['files:upload_error']					= 'Η μεταφόρτωση του αρχείου απέτυχε';
$lang['files:description_saved']			= 'Η περιγραφή του αρχείο αποθηκεύτηκε';
$lang['files:file_moved']					= 'Το "%s" μεταφέρθηκε με επιτυχία';
$lang['files:exceeds_server_setting']		= 'The server cannot handle this large of a file'; #translate
$lang['files:exceeds_allowed']				= 'File exceeds the max size allowed'; #translate
$lang['files:file_type_not_allowed']		= 'This type of file is not allowed'; #translate
$lang['files:type_a']						= 'Ήχος';
$lang['files:type_v']						= 'Video';
$lang['files:type_d']						= 'Έγγραφο';
$lang['files:type_i']						= 'Εικόνα';
$lang['files:type_o']						= 'Άλλο';