<?php defined('BASEPATH') OR exit('No direct script access allowed');

#section settings
$lang['settings:site_name']			= 'Όνομα Ιστοτόπου';
$lang['settings:site_name_desc']		= 'Το όνομα του ιστοτόπου για τους τίτλους των σελίδων και για γενική χρήση ανά τον ιστότοπο.';

$lang['settings:site_slogan']			= 'Ατάκα Ιστοτόπου';
$lang['settings:site_slogan_desc']		= 'Η ατάκα του ιστοτόπου σας για τίτλους σελίδων και για χρήση ανά τον ιστότοπο.';

$lang['settings:site_lang']			= 'Γλώσσα Ιστοτόπου';
$lang['settings:site_lang_desc']		= 'Η φυσική γλώσσα του ιστοτόπου, χρησιμοποιείται στα πρότυπα των email, στα μηνύματα του συστήματος και γενικότερα όπου υπάρχει ανάγκη για κείμενο σε μια γλώσσα οικία προς τους χρήστες.';

$lang['settings:contact_email']			= 'E-mail Επικοινωνίας';
$lang['settings:contact_email_desc']		= 'Όλα τα e-mail από χρήστες, επισκέπτες και τον ιστότοπο, θα στέλνονται σε αυτήν την διεύθυνση.';

$lang['settings:server_email']			= 'E-mail Διακομιστή';
$lang['settings:server_email_desc']		= 'Όλα τα e-mail προς τους χρήστες θα στέλνονται από αυτή την διεύθυνση.';

$lang['settings:meta_topic']			= 'Meta Topic';
$lang['settings:meta_topic_desc']		= 'Δυο ή τρεις λέξεις που να περιγράφουν αυτόν τον τύπο της επιχείρησης/ιστότοπου.';

$lang['settings:currency']			= 'Νόμισμα';
$lang['settings:currency_desc']			= 'Το σύμβολο του νομίσματος για χρήση σε προϊόντα, υπηρεσίες κ.λπ.';

$lang['settings:dashboard_rss']			= 'Τροφοδοσία RSS Επισκόπησης';
$lang['settings:dashboard_rss_desc']		= 'Ο σύνδεσμος σε μια τροφοδοσία RSS που θα προβάλλεται στην επισκόπηση.';

$lang['settings:dashboard_rss_count']		= 'Στοιχεία RSS Επισκόπησης';
$lang['settings:dashboard_rss_count_desc']	= 'Πόσα στοιχεία από την τροφοδοσία RSS να προβάλλονται στην επισκόπηση;';

$lang['settings:date_format']			= 'Μορφή Ημερομηνίας';
$lang['settings:date_format_desc']		= 'Πως να εμφανίζονται οι ημερομηνίες ανά τον ιστότοπο και τον πίνακα διαχείρισης; Χρησιμοποιώντας τις διαθέσιμες <a target="_blank" href="http://php.net/manual/en/function.date.php">μορφές ημερομηνιών</a> από την PHP - ή - Χρησιμοποιώντας την λειτουργία <a target="_blank" href="http://php.net/manual/en/function.strftime.php">κειμένου μορφοποιημένης ημερομηνίας</a> από την PHP.';

$lang['settings:frontend_enabled']		= 'Κατάσταση Ιστότοπου';
$lang['settings:frontend_enabled_desc']		= 'Χρησιμοποιήστε αυτήν την επιλογή για να κλείσετε τον ιστότοπο. Αυτό είναι χρήσιμο όταν θέλετε να κατεβάσετε τον ιστότοπο για συντήρηση';

$lang['settings:mail_protocol']			= 'Πρωτόκολλο Mail';
$lang['settings:mail_protocol_desc']		= 'Επιλέξτε το επιθυμητό πρωτόκολλο για την αποστολή email.';

$lang['settings:mail_sendmail_path']		= 'Φάκελος Sendmail';
$lang['settings:mail_sendmail_path_desc']	= 'Αλληλουχία φακέλων για το εκτελέσιμο του sendmail.';

$lang['settings:mail_smtp_host']		= 'Διακομιστής SMTP';
$lang['settings:mail_smtp_host_desc']		= 'Το hostname του διακομιστή SMTP σας.';

$lang['settings:mail_smtp_pass']		= 'Συνθηματικό SMTP';
$lang['settings:mail_smtp_pass_desc']		= 'Συνθηματικό SMTP.';

$lang['settings:mail_smtp_port']		= 'Θύρα SMTP';
$lang['settings:mail_smtp_port_desc']		= 'Αριθμός θύρας του SMTP.';

$lang['settings:mail_smtp_user']		= 'Όνομα χρήστη SMTP';
$lang['settings:mail_smtp_user_desc']		= 'Όνομα χρήστη του SMTP.';

$lang['settings:unavailable_message']		= 'Μήνυμα Συντήρησης';
$lang['settings:unavailable_message_desc']	= 'Όταν ο ιστότοπός σας είναι κλειστός ή όταν υπάρχει ένα πολύ μεγάλο πρόβλημα, αυτό το μήνυμα θα προβάλεται στους χρήστες.';

$lang['settings:default_theme']			= 'Προεπιλεγμένο Θέμα';
$lang['settings:default_theme_desc']		= 'Επιλέξτε το θέμα εμφάνισης που θέλετε να είναι προεπιλεγμένο για να βλέπουν οι χρήστες σας.';

$lang['settings:activation_email']		= 'Email Ενεργοποίησης';
$lang['settings:activation_email_desc']		= 'Να στέλνεται ένα μήνυμα μέσω e-mail που να περιέχει τον σύνδεσμο ενεργοποίησης λογαριασμού όταν κάποιος χρήστης εγγράφεται. Απενεργοποιώντας αυτήν την ρύθμιση οι λογαριασμοί θα μπορούν να ενεργοποιούνται μόνο από τους διαχειριστές.';

$lang['settings:records_per_page']		= 'Στοιχεία Ανά Σελίδα';
$lang['settings:records_per_page_desc']		= 'Πόσα στοιχεία να προβάλλονται ανά σελίδα στον Πίνακα Διαχείρισης;';

$lang['settings:rss_feed_items']		= 'Αριθμός Στοιχείων Τροφοδοσίας';
$lang['settings:rss_feed_items_desc']		= 'Πόσα στοιχεία πρέπει να περιέχουν οι τροφοδοσίες RSS και Ιστολογίου;';


$lang['settings:enable_profiles']		= 'Ενεργοποίηση των προφίλ';
$lang['settings:enable_profiles_desc']		= 'Να επιτρέπεται στους χρήστες να προσθέτουν και να επεξεργάζονται τα προφίλ τους.';

$lang['settings:ga_email']			= ' E-mail Google Analytic';
$lang['settings:ga_email_desc']			= 'Η διεύθυνση e-mail που χρησιμοποιείτε για το Google Analytics, αυτό χρειάζεται για να εμφανίζεται το γράφημα στην Επισκόπηση.';

$lang['settings:ga_password']			= 'Συνθηματικό Google Analytic';
$lang['settings:ga_password_desc']		= 'Το συνθηματικό του Google Analytics. Και αυτό χρειάζεται για να εμφανίζεται το γράφημα στην Επισκόπηση.';

$lang['settings:ga_profile']			= 'Προφίλ Google Analytic';
$lang['settings:ga_profile_desc']		= 'Το ID του προφίλ του Google Analytics για αυτό τον ιστότοπο.';

$lang['settings:ga_tracking']			= 'Google Tracking Code';
$lang['settings:ga_tracking_desc']		= 'Εισάγεται τον Google Analytic Tracking Code σας για να ενεργοποιήσετε την καταγραφή επισκέψεων μέσω του Google Analytics. Π.χ.: UA-19483569-6';

$lang['settings:akismet_api_key']		= 'Κλειδί API για το Akismet';
$lang['settings:akismet_api_key_desc']		= 'Το Akismet σταματάει το spam και δημιουργήθηκε από τον ομάδα του WordPress. Κρατάει το spam υπό έλεγχο χωρίς να υποχρεώνει τους χρήστες να περάσουν δοκιμασίες για να αποδείξουν ότι είναι άνθρωποι και όχι προγράμματα.';

$lang['settings:comment_order']			= 'Ταξινόμηση Σχολίων';
$lang['settings:comment_order_desc']		= 'Σειρά ταξινόμησης για την προβολή των σχολίων.';

$lang['settings:enable_comments']		= 'Ενεργοποίηση Σχολίων';
$lang['settings:enable_comments_desc']		= 'Να επιτρέπονται τα σχόλια από χρήστες';

$lang['settings:moderate_comments']		= 'Συντονισμός Σχολίων';
$lang['settings:moderate_comments_desc']	= 'Να απαιτείται η έγκριση των σχολίων πριν την δημοσίευσή τους.';

$lang['settings:comment_markdown']		= 'Ενεργοποίηση Markdown';
$lang['settings:comment_markdown_desc']		= 'Να επιτρέπεται οι χρήστες να κάνουν χρήση του Markdown στα σχόλιά τους;';

$lang['settings:version']			= 'Έκδοση';
$lang['settings:version_desc']			= '';

$lang['settings:site_public_lang']		= 'Διαθέσιμες Γλώσσες';
$lang['settings:site_public_lang_desc']		= 'Ποιες γλώσσες υποστηρίζονται πραγματικά και είναι διαθέσιμες στον ιστότοπό σας;';

$lang['settings:admin_force_https']		= 'Πρόσβαση Πίνακα Ελέγχου μόνο μέσω HTTPS;';
$lang['settings:admin_force_https_desc']	= 'Να επιτρέπεται η πρόσβαση στον Πίνακα Ελέγχου μόνο μέσω του πρωτοκόλλου HTTPS;';

$lang['settings:files_cache']			= 'Cache Αρχείων';
$lang['settings:files_cache_desc']		= 'Όταν εξυπηρετείται μια εικόνα μέσω του site.com/files πόσο να είναι η χρονική περίοδος για το cache;';

$lang['settings:auto_username']			= 'Αυτόματα Ονόματα Χρηστών';
$lang['settings:auto_username_desc']		= 'Να δημιουργούνται αυτόματα τα ονόματα χρηστών, με την έννοια ότι οι χρήστες θα μπορούν να μην επιλέγουν ένα κατά την εγγραφή τους.';

$lang['settings:registered_email']		= 'Ειδοποίηση Email Για Νέα Εγγραφή';
$lang['settings:registered_email_desc']		= 'Να αποστέλεται μια ειδοποιήση μέσω email στην διεύθυνση email για επικοινωνία όταν υπάρχει μια νέα εγγραφή χρήστη.';

$lang['settings:ckeditor_config']           = 'Παραμετροποίηση του CKEditor';
$lang['settings:ckeditor_config_desc']      = 'Υπάρχει λίστα με έγκυρα στοιχεία παραμετροποίησης του CKEditor στην <a target="_blank" href="http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html">σελίδα τεκμηριωσής του.</a>';

$lang['settings:enable_registration']           = 'Ενεργοποίηση εγγραφών νέων χρηστών';
$lang['settings:enable_registration_desc']      = 'Να επιτρέπεται η εγγραφή νέων χρηστών στον ιστότοπο.';

//$lang['settings:profile_visibility']        = 'Δυνατότητα προβολής προφίλ χρηστών';
//$lang['settings:profile_visibility_desc']        = 'Προσδιορίστε ποιοι μπορούν να δουν τα προφίλ χρηστών στον ιστότοπο.';

$lang['settings:cdn_domain']                    = 'CDN Domain';
$lang['settings:cdn_domain_desc']               = 'Τα CDN σας επιτρέπουν αποφορτίζετε τον διακομιστή σας από την ευθύνη δεδομένων που είναι δεν είναι δυναμικά αλλά στατικά (εικόνες, αρχεία πολυμέσων, έγγραφα κτλ). Μπορείτε να χρησιμοποιήσετε υπηρεσίες όπως τα Amazon CloudFront ή MaxCDN.';

#section titles
$lang['settings:section_general']		= 'Γενικά';
$lang['settings:section_integration']		= 'Ενσωμάτωση';
$lang['settings:section_comments']		= 'Σχόλια';
$lang['settings:section_users']			= 'Χρήστες';
$lang['settings:section_statistics']		= 'Στατιστικά';
$lang['settings:section_files']			= 'Αρχεία';

#checkbox and radio options
$lang['settings:form_option_Open']		= 'Ανοικτό';
$lang['settings:form_option_Closed']		= 'Κλειστό';
$lang['settings:form_option_Enabled']		= 'Ενεργοποιημένο';
$lang['settings:form_option_Disabled']		= 'Απενεργοποιημένο';
$lang['settings:form_option_Required']		= 'Απαιτούμενο';
$lang['settings:form_option_Optional']		= 'Προαιρετικό';
$lang['settings:form_option_Oldest First']	= 'Τα παλιότερα πρώτα';
$lang['settings:form_option_Newest First']	= 'Τα νεότερα πρώτα';
$lang['settings:form_option_Text Only']		= 'Απλό Κείμενο';
$lang['settings:form_option_Allow Markdown']	= 'Ενεργοποίηση Markdown';
$lang['settings:form_option_Yes']		= 'Ναι';
$lang['settings:form_option_No']		= 'Όχι';
$lang['settings:form_option_profile_public']	= 'Εμφανές σε όλους';
$lang['settings:form_option_profile_owner']		= 'Εμφανές μόνο στον ιδιοκτήτη του προφίλ';
$lang['settings:form_option_profile_hidden']	= 'Μη διαθέσιμο';
$lang['settings:form_option_profile_member']	= 'Εμφανές σε κάθε συνδεδεμένο χρήση';
$lang['settings:form_option_activate_by_email']				= 'Ενεργοποίηση μέσω e-mail';
$lang['settings:form_option_activate_by_admin']				= 'Ενεργοποίηση από τον διαχειριστή';
$lang['settings:form_option_no_activation']				= 'Δεν απαιτείται ενεργοποίηση';

// messages
$lang['settings:no_settings']			= 'Προς το παρόν δεν υπάρχουν ρυθμίσεις.';
$lang['settings:save_success']			= 'Οι ρυθμίσεις σας αποθηκεύτηκαν!';

/* End of file settings_lang.php */