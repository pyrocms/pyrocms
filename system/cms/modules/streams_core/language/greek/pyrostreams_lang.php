<?php defined('BASEPATH') or exit('No direct script access allowed');

/* Messages */

$lang['streams:save_field_error'] 						= "Υπήρξε κάποιο πρόβλημα κατά την αποθήκευση του πεδίου σας.";
$lang['streams:field_add_success']						= "Το πεδίο προστέθηκε με επιτυχία.";
$lang['streams:field_update_error']						= "Υπήρξε κάποιο πρόβλημα κατά την ενημέρωση του πεδίου σας.";
$lang['streams:field_update_success']					= "Το πεδίο ενημερώθηκε με επιτυχία.";
$lang['streams:field_delete_error']						= "Υπήρξε κάποιο πρόβλημα κατά την διαγραφή αυτού του πεδίου.";
$lang['streams:field_delete_success']					= "Το πεδίο διαγραφηκε με επιτυχία.";
$lang['streams:view_options_update_error']				= "Υπήρξε κάποιο πρόβλημα κατά την ενημέρωση των επιλογών προβολής.";
$lang['streams:view_options_update_success']			= "Οι επιλογές προβολής ενημερώθηκαν με επιτυχία.";
$lang['streams:remove_field_error']						= "Υπήρξε κάποιο πρόβλημα κατά την απομάκρυνση αυτού του πεδίου.";
$lang['streams:remove_field_success']					= "Το πεδίο απομακρύνθηκε με επιτυχία.";
$lang['streams:create_stream_error']					= "Υπήρξε κάποιο πρόβλημα κατά την δημιουργία της ροής σας.";
$lang['streams:create_stream_success']					= "Η ροή δημιουργήθηκε με επιτυχία.";
$lang['streams:stream_update_error']					= "Υπήρξε κάποιο πρόβλημα κατά την ενημέρωση αυτής της ροής.";
$lang['streams:stream_update_success']					= "Η ροή ενημερώθηκε με επιτυχία.";
$lang['streams:stream_delete_error']					= "Υπήρξε κάποιο πρόβλημα κατά την διαγραφή αυτής της ροής.";
$lang['streams:stream_delete_success']					= "Η ροή διαγράφηκε με επιτυχία.";
$lang['streams:stream_field_ass_add_error']				= "Υπήρξε κάποιο πρόβλημα κατά την προσθήκη αυτού του πεδίου σε αυτήν την ροή.";
$lang['streams:stream_field_ass_add_success']			= "Το πεδίο αντιστοιχήθηκε σε αυτήν την ροή με επιτυχία.";
$lang['streams:stream_field_ass_upd_error']				= "Υπήρξε κάποιο πρόβλημα κατά την ενημέρωση της αντιστοιχίας αυτού του πεδίου.";
$lang['streams:stream_field_ass_upd_success']			= "Η αντιστοίχιση του πεδίου ενημερώθηκε με επιτυχία.";
$lang['streams:delete_entry_error']						= "Υπήρξε κάποιο πρόβλημα κατά την διαγραφή αυτής της εγγραφής.";
$lang['streams:delete_entry_success']					= "Η εγγραφή διαγράφηκε με επιτυχία.";
$lang['streams:new_entry_error']						= "Υπήρξε κάποιο πρόβλημα κατά την προσθήκη αυτής της εγγραφής.";
$lang['streams:new_entry_success']						= "Η εγγραφή προστέθηκε με επιτυχία.";
$lang['streams:edit_entry_error']						= "Υπήρξε κάποιο πρόβλημα κατά την ενημέρωση αυτής της εγγραφής.";
$lang['streams:edit_entry_success']					= "Η εγγραφή ενημερώθηκε με επιτυχία.";
$lang['streams:delete_summary']							= "Είσαστε σίγουροι ότι θέλετε να διαγράψετε την ροή <strong>%s</strong>; Αυτό θα <strong>διαγράψει %s %s</strong> για πάντα.";

/* Misc Errors */

$lang['streams:no_stream_provided']						= "Δεν δώθηκε ροή.";
$lang['streams:invalid_stream']							= "Μη έγκυρη ροή.";
$lang['streams:not_valid_stream']						= "δεν είναι έγκυρη ροή.";
$lang['streams:invalid_stream_id']						= "ΜΗ έγκυρο ID ροής.";
$lang['streams:invalid_row']							= "Μη έγκυρη γραμμή.";
$lang['streams:invalid_id']								= "Μη έκγυρο ID.";
$lang['streams:cannot_find_assign']						= "Δεν βρέθηκε η αντιστοίχιση πεδίων.";
$lang['streams:cannot_find_pyrostreams']				= "Δεν βρέθηκε το PyroStreams.";
$lang['streams:table_exists']							= "Υπάρχει ήδη ένας πίνακας με το σύντομο όνομα (slug)  %s.";
$lang['streams:no_results']								= "Δεν υπάρχουν αποτελέσματα";
$lang['streams:no_entry']								= "Δεν ήταν δυνατό να βρεθεί η εγγραφή.";
$lang['streams:invalid_search_type']					= "δεν είναι ένας έγκυρος τύπος αναζήτησης.";
$lang['streams:search_not_found']						= "Η αναζήτηση δεν βρέθηκε.";

/* Validation Messages */

$lang['streams:field_slug_not_unique']					= "Το σύντομο όνομα (slug) για το πεδίο χρησιμοποιείται ήδη.";
$lang['streams:not_mysql_safe_word']					= "Το πεδίο %s είναι μια λέξη που χρησιμοποιεί η MySQL.";
$lang['streams:not_mysql_safe_characters']				= "Το πεδίο %s περιέχει μη αποδεκτούς χαρακτήρες.";
$lang['streams:type_not_valid']							= "Παρακαλούμε επιλέξτε έναν έγκυρο τύπο πεδίου.";
$lang['streams:stream_slug_not_unique']					= "Το σύντομο όνομα (slug) για αυτήν την ροή χρησιμοποιείται ήδη.";
$lang['streams:field_unique']							= "Το πεδίο %s πρέπει να είναι μοναδικό.";
$lang['streams:field_is_required']						= "Το πεδίο %s απαιτείται.";
$lang['streams:date_out_or_range']						= "Η ημερομηνία που επιλέξατε είναι εκτός της αποδεκτής περιόδου.";

/* Field Labels */

$lang['streams:label.field']							= "Πεδίο";
$lang['streams:label.field_required']					= "Το πεδίο να απαιτείται";
$lang['streams:label.field_unique']						= "Οι τιμές του πεδίου είναι μοναδικές";
$lang['streams:label.field_instructions']				= "Οδηγίες Πεδίου";
$lang['streams:label.make_field_title_column']			= "Ορισμός πεδίου ως στήλη τίτλου";
$lang['streams:label.field_name']						= "Όνομα Πεδίου";
$lang['streams:label.field_slug']						= "Σύντομο Όνομα Πεδίου";
$lang['streams:label.field_type']						= "Τύπος Πεδίου";
$lang['streams:id']										= "ID";
$lang['streams:created_by']								= "Δημιουργήθηκε Από";
$lang['streams:created_date']							= "Ημερομηνία Δημιουργίας";
$lang['streams:updated_date']							= "Ημερομηνία Ενημέρωσης";
$lang['streams:value']									= "Τιμή";
$lang['streams:manage']									= "Διαχείριση";
$lang['streams:search']									= "Αναζήτηση";
$lang['streams:stream_prefix']							= "Πρόθεμα Ροής";

/* Field Instructions */

$lang['streams:instr.field_instructions']				= "Προβάλεται στην φόρμα κατά την εισαγωγή ή την επεξεργασία δεδομένων.";
$lang['streams:instr.stream_full_name']					= "Πλήρες όνομα της ροής σας.";
$lang['streams:instr.slug']								= "Πεζά, μόνο γράμματα και κάτω παύλες.";

/* Titles */

$lang['streams:assign_field']							= "Αντιστοίχιση Πεδίου σε Ροή";
$lang['streams:edit_assign']							= "Επεξεργασία Αντιστοίχισης Πεδίου";
$lang['streams:add_field']								= "Δημιουργία Πεδίου";
$lang['streams:edit_field']								= "Επεξεργασία Πεδίου";
$lang['streams:fields']									= "Πεδία";
$lang['streams:streams']								= "Ροές";
$lang['streams:list_fields']							= "Λίστα Πεδίων";
$lang['streams:new_entry']								= "Νέα Εγγραφή";
$lang['streams:stream_entries']							= "Εγγραφές Ροών";
$lang['streams:entries']								= "Εγγραφές";
$lang['streams:stream_admin']							= "Διαχείριση Ροών";
$lang['streams:list_streams']							= "Λίστα Ροών";
$lang['streams:sure']									= "Είσαστε σίγουροι;";
$lang['streams:field_assignments'] 						= "Αντιστοίχηση Πεδίων Ροών";
$lang['streams:new_field_assign']						= "Νέα Αντιστοίχιση Πεδίου";
$lang['streams:stream_name']							= "Όνομα Ροής";
$lang['streams:stream_slug']							= "Σύντομο Όνομα Ροής";
$lang['streams:about']									= "Περί";
$lang['streams:total_entries']							= "Σύνολο Εγγραφών";
$lang['streams:add_stream']								= "Νέα Ροή";
$lang['streams:edit_stream']							= "Επεξεργασία Ροής";
$lang['streams:about_stream']							= "Περί Της Ροής";
$lang['streams:title_column']							= "Στήλη Τίτλου";
$lang['streams:sort_method']							= "Μέθοδος Ταξινόμησης";
$lang['streams:add_entry']								= "Προσθήκη Εγγραφής";
$lang['streams:edit_entry']								= "Επεξεργασία Εγγραφής";
$lang['streams:view_options']							= "Επιλογές Προβολής";
$lang['streams:stream_view_options']					= "Επιλογής Προβολής Ροής";
$lang['streams:backup_table']							= "Αντίγραφο Ασφαλείας Πίνακα Ροών";
$lang['streams:delete_stream']							= "Διαγραφή Ροής";
$lang['streams:entry']									= "Εγγραφή";
$lang['streams:field_types']							= "Τύποι Πεδίων";
$lang['streams:field_type']								= "Τύπος Πεδίου";
$lang['streams:database_table']							= "Πίνακας Βάσης Δεδομένων";
$lang['streams:size']									= "Μέγεθος";
$lang['streams:num_of_entries']							= "Αριθμός Εγγραφών";
$lang['streams:num_of_fields']							= "Αριθμός Πεδίων";
$lang['streams:last_updated']							= "Τελευταία Ενημέρωση";
$lang['streams:export_schema']							= "Εξαγωγή Schema";

/* Startup */

$lang['streams:start.add_one']							= "προσθέσετε ένα εδώ";
$lang['streams:start.no_fields']						= "Δεν έχετε δημιουργήσει ακόμη κάποιο πεδίο. Για να ξεκινήσετε, μπορείτε να";
$lang['streams:start.no_assign'] 						= "Φαίνεται ότι ακόμα δεν υπάρχουν πεδία για αυτήν την ροή. Για να ξεκινήσετε, μπορείτε να";
$lang['streams:start.add_field_here']					= "προσθέσετε ένα πεδίο εδώ";
$lang['streams:start.create_field_here']				= "δημιουργήσετε ένα πεδίο εδώ";
$lang['streams:start.no_streams']						= "Δεν υπάρχουν ακόμη ροές, αλλά μπορείτε να ξεκινήσετε";
$lang['streams:start.no_streams_yet']					= "Δεν υπαρχουν ακόμη ροές.";
$lang['streams:start.adding_one']						= "προσθέτωντας μια";
$lang['streams:start.no_fields_to_add']					= "Δεν υπάρχουν Πεδία για Προσθήκη";
$lang['streams:start.no_fields_msg']					= "Δεν υπάρχουν πεδία για να προσθέσετε σε αυτήν την ροή. Στο PyroStreams, οι τύποι πεδίων μπορούν να χρησιμοποιούνται από πολλές ροές ταυτόχρονα και πρέπει να δημιουργηθούν προτού χρησιμοποιηθούν. Μπορείτε να ξεκινήσετε";
$lang['streams:start.adding_a_field_here']				= "προσθέτωντας ένα πεδίο εδώ";
$lang['streams:start.no_entries']						= "Δεν υπάρχουν ακόμη εγγραφές για <strong>%s</strong>. Για να ξεκινήσετε μπορείτε να";
$lang['streams:add_fields']								= "αντιστοιχήσετε πεδία";
$lang['streams:no_entries']								= 'No entries'; #translate
$lang['streams:add_an_entry']							= "προσθέσετε μια εγγραφή";
$lang['streams:to_this_stream_or']						= "σε αυτή τη ροή ή";
$lang['streams:no_field_assign']						= "Δεν Υπάρχουν Αντιστοιχίσεις Πεδίων";
$lang['streams:no_fields_msg_first']					= "Φαίνεται να μην υπάρχουν ακόμη πεδία για αυτήν την ροή.";
$lang['streams:no_field_assign_msg']					= "Φαίνεται ότι ακόμα πεδία για αυτήν την ροή. Για να εισάγετε δεδομένα, πρέπει να";
$lang['streams:add_some_fields']						= "αντιστοιχίσετε μερικά πεδία";
$lang['streams:start.before_assign']					= "Πριν να μπορείτε να αντιστοιχισέτε πεδία σε κάποια ροή, πρέπει να τα δημιουργήσετε. Μπορείτε να";
$lang['streams:start.no_fields_to_assign']				= "Φαίνεται ότι δεν υπάρχουν πεδία διαθέσιμα για να γίνει η αντιστοίχηση. Προτού να μπορείτε να αντιστοιχίσετε κάποιο πεδίο πρέπει να ";

/* Buttons */

$lang['streams:yes_delete']								= "Ναι, Διαγραφή";
$lang['streams:no_thanks']								= "Όχι Ευχαριστώ";
$lang['streams:new_field']								= "Νέο Πεδίο";
$lang['streams:edit']									= "Επεξεργασία";
$lang['streams:delete']									= "Διαγραφή";
$lang['streams:remove']									= "Απομάκρυνση";
$lang['streams:reset']									= "Επαναφορά";

/* Misc */

$lang['streams:field_singular']							= "πεδίο";
$lang['streams:field_plural']							= "πεδία";
$lang['streams:by_title_column']						= "Κατά Τίτλο Στήλης";
$lang['streams:manual_order']							= "Χειροκίνητη Ταξινόμηση";
$lang['streams:stream_data_line']						= "Επεξεργασία βασικών δεδομένων ροής.";
$lang['streams:view_options_line'] 						= "Επιλογή στηλών που θα πρέπει να προβάλονται στην σελίδα προβολής δεδομένων.";
$lang['streams:backup_line']							= "Δημιουργία και κατέβασμα ενός αντιγράφου ασφαλείας για τον πίνακα ροών σε μορφή zip.";
$lang['streams:permanent_delete_line']					= "Μόνιμη διαγραφή μιας ροής και όλων των δεδομένων της.";
$lang['streams:choose_a_field_type']					= "Επιλέξτε έναν τύπο πεδίου";
$lang['streams:choose_a_field']							= "Επιλέξτε ένα πεδίο";

/* reCAPTCHA */

$lang['recaptcha_class_initialized'] 					= "Η Βιβλιοθήκη reCaptcha Εκκινήθηκε";
$lang['recaptcha_no_private_key']						= "Δεν έχετε δώσει ένα API key για το Recaptcha";
$lang['recaptcha_no_remoteip'] 							= "Για λόγους ασφαλείας πρέπει να μεταβιβάσετε το remote ip στο reCAPTCHA";
$lang['recaptcha_socket_fail'] 							= "Δεν ήταν δυνατό να ανοιχτεί το socket";
$lang['recaptcha_incorrect_response'] 					= "Μη Έγκυρη Απόκριση Εικόνας Ασφαλείας";
$lang['recaptcha_field_name'] 							= "Εικόνα Ασφαλείας";
$lang['recaptcha_html_error'] 							= "Σφάλμα κατά το φόρτωμα της εικόνας ασφαλείας. Παρακαλούμε δοκιμάστε ξανά αργότερα";

/* Default Parameter Fields */

$lang['streams:max_length'] 							= "Μέγιστο Μήκος";
$lang['streams:upload_location'] 						= "Τοποθεσία Μεταφόρτωσης";
$lang['streams:default_value'] 							= "Αρχική Τιμή";

$lang['streams:menu_path']								= 'Menu Path'; #translate
$lang['streams:about_instructions']						= 'A short description of your stream.'; #translate
$lang['streams:slug_instructions']						= 'This will also be the database table name for your stream.'; #translate
$lang['streams:prefix_instructions']					= 'If used, this will prefix the table in the database. Useful for naming collisons.'; #translate
$lang['streams:menu_path_instructions']					= 'Where you what section and sub section this stream should show up in the menu. Separate by a forward slash. Ex: <strong>Main Section / Sub Section</strong>.'; #translate

/* End of file pyrostreams_lang.php */