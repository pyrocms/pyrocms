<?php
// ================================================
// SPAW PHP WYSIWYG editor control
// ================================================
// English language file
// ================================================
// Developed: Alan Mendelevich, alan@solmetra.lt
// Copyright: Solmetra (c)2003 All rights reserved.
// Greek translation: Saxinidis B. Konstantinos
//                    skva@in.gr
// ------------------------------------------------
//                                www.solmetra.com
// ================================================
// v.1.0, 2003-03-20
// ================================================

// charset to be used in dialogs
$spaw_lang_charset = 'utf-8';

// language text data array
// first dimension - block, second - exact phrase
// alternative text for toolbar buttons and title for dropdowns - 'title'

$spaw_lang_data = array(
  'cut' => array(
    'title' => 'Αποκοπή'
  ),
  'copy' => array(
    'title' => 'Αντιγραφή'
  ),
  'paste' => array(
    'title' => 'Επικόλληση'
  ),
  'undo' => array(
    'title' => 'Αναίρεση'
  ),
  'redo' => array(
    'title' => 'Ακύρωση Αναίρεσης'
  ),
  'hyperlink' => array(
    'title' => 'Υπερσύνδεση'
  ),
  'image_insert' => array(
    'title' => 'Εισαγωγή εικόνας',
    'select' => 'Επιλογή',
    'cancel' => '’κυρο',
    'library' => 'Βιβλιοθήκη',
    'preview' => 'Προεπισκόπηση',
    'images' => 'Εικόνες',
    'upload' => 'Φόρτωμα εικόνας',
    'upload_button' => 'Φόρτωμα',
    'error' => 'Λάθος',
    'error_no_image' => 'Παρακαλώ επιλέξτε μια εικόνα',
    'error_uploading' => 'Ένα λάθος ενώ το διαχειριζόμενο αρχείο φορτώνονταν.  Παρακαλώ προσπαθήστε πάλι αργότερα',
    'error_wrong_type' => 'Λανθασμένος τύπος αρχείου εικόνας',
    'error_no_dir' => 'Η βιβλιοθήκη δεν δημιουργήθηκε με φυσικό τροπο ή δεν υπάρχει',
  ),
  'image_prop' => array(
    'title' => 'Ιδιότητες εικόνας',
    'ok' => '   OK   ',
    'cancel' => '’κυρο',
    'source' => 'Προέλευση',
    'alt' => 'Εναλλακτικό κείμενο',
    'align' => 'Ευθυγραμμίση',
    'justifyleft' => 'αριστερά',
    'justifyright' => 'δεξιά',
    'full' => 'justifyfull',
    'top' => 'πάνω',
    'middle' => 'μέση',
    'bottom' => 'κάτω',
    'absmiddle' => 'absμέση',
    'texttop' => 'texttop',
    'baseline' => 'baseline',
    'width' => 'Πλάτος',
    'height' => 'Ύψος',
    'border' => 'Περίγραμμα',
    'hspace' => 'Οριζ. space',
    'vspace' => 'Κάθετ. space',
    'error' => 'Λάθος',
    'error_width_nan' => 'Το πλάτος δεν είναι ένας αριθμός',
    'error_height_nan' => 'Ύψος δεν είναι ένας αριθμός',
    'error_border_nan' => 'Border δεν είναι ένας αριθμός',
    'error_hspace_nan' => 'Το οριζόντιο διάστημα δεν είναι ένας αριθμός',
    'error_vspace_nan' => 'Το κάθετο διάστημα δεν είναι ένας αριθμός',
  ),
  'inserthorizontalrule' => array(
    'title' => 'Οριζόντιος κανόνας'
  ),
  'table_create' => array(
    'title' => 'Δημιουργήστε πίνακα'
  ),
  'table_prop' => array(
    'title' => 'Ιδιότητες πίνακα',
    'ok' => '   OK   ',
    'cancel' => 'Ακυρο',
    'rows' => 'Σειρές',
    'columns' => 'Στήλες',
    'width' => 'Πλάτος',
    'height' => 'Ύψος',
    'border' => 'Περίγραμμα',
    'pixels' => 'pixels',
    'cellpadding' => 'Γέμισμα κελιού',
    'cellspacing' => 'Διάστημα κελιού',
    'bg_color' => 'Background χρώμα',
    'error' => 'Λάθος',
    'error_rows_nan' => 'Οι σειρές δεν είναι ένας αριθμός',
    'error_columns_nan' => 'Οι στήλες δεν είναι ένας αριθμός',
    'error_width_nan' => 'Το πλάτος δεν είναι ένας αριθμός',
    'error_height_nan' => 'Ύψος δεν είναι ένας αριθμός',
    'error_border_nan' => 'Το περίγραμμα δεν είναι ένας αριθμός',
    'error_cellpadding_nan' => 'Το γέμισμα κελιού δεν είναι ένας αριθμός',
    'error_cellspacing_nan' => 'Το διάστημα κελιού δεν είναι ένας αριθμός',
  ),
  'table_cell_prop' => array(
    'title' => ' ιδιότητες Στηλών',
    'horizontal_align' => 'Οριζόντια ευθυγράμμιση',
    'vertical_align' => 'Κάθετη ευθυγράμμιση',
    'width' => 'Πλάτος',
    'height' => 'Ύψος',
    'css_class' => 'CSS class',
    'no_wrap' => 'No wrap',
    'bg_color' => 'Background color',
    'ok' => '   OK   ',
    'cancel' => '’κυρο',
    'justifyleft' => 'Αριστερά',
    'justifycenter' => 'Κέντρο',
    'justifyright' => 'Δεξιά',
    'full' => 'Justify',
    'top' => 'Top',
    'middle' => 'Middle',
    'bottom' => 'Bottom',
    'baseline' => 'Baseline',
    'error' => 'Λάθος',
    'error_width_nan' => 'Το πλάτος δεν είναι ένας αριθμός',
    'error_height_nan' => 'Ύψος δεν είναι ένας αριθμός',
  ),
  'table_row_insert' => array(
    'title' => 'Εισαγωγή σειράς'
  ),
  'table_column_insert' => array(
    'title' => 'Εισαγωγή στήλης'
  ),
  'table_row_delete' => array(
    'title' => 'Διαγραφή σειράς'
  ),
  'table_column_delete' => array(
    'title' => 'Διαγραφή στήλης'
  ),
  'table_cell_merge_right' => array(
    'title' => 'Merge δεξιά'
  ),
  'table_cell_merge_down' => array(
    'title' => 'Merge κάτω'
  ),
  'table_cell_split_horizontal' => array(
    'title' => 'Split κελιού οριζόντια'
  ),
  'table_cell_split_vertical' => array(
    'title' => 'Split κελιού κάθετα'
  ),
  'style' => array(
    'title' => 'Style'
  ),
  'fontname' => array(
    'title' => 'Γραμματοσειρά'
  ),
  'fontsize' => array(
    'title' => 'Μέγεθος'
  ),
  'formatBlock' => array(
    'title' => 'Παράγραφος'
  ),
  'bold' => array(
    'title' => 'Έντονα'
  ),
  'italic' => array(
    'title' => 'Italic'
  ),
  'underline' => array(
    'title' => 'Υπογράμμιση'
  ),
  'insertorderedlist' => array(
    'title' => 'Αρίθμηση'
  ),
  'insertunorderedlist' => array(
    'title' => 'κουκκίδες'
  ),
  'indent' => array(
    'title' => 'Εσοχή'
  ),
  'outdent' => array(
    'title' => 'Χωρίς εσοχή'
  ),
  'justifyleft' => array(
    'title' => 'Αριστερά'
  ),
  'justifycenter' => array(
    'title' => 'Κέντρο'
  ),
  'justifyright' => array(
    'title' => 'Δεξιά'
  ),
  'full' => array(
    'title' => 'Justify'
  ),
  'fore_color' => array(
    'title' => 'Fore color'
  ),
  'bg_color' => array(
    'title' => 'Background color'
  ),
  'design' => array(
    'title' => 'Αλλαγή σε WYSIWYG (design) mode'
  ),
  'html' => array(
    'title' => 'Αλλαγή σε HTML (code) mode'
  ),
  'colorpicker' => array(
    'title' => 'Color picker',
    'ok' => '   OK   ',
    'cancel' => '’κυρο',
  ),
  'cleanup' => array(
    'title' => 'HTML καθαρισμός (απομάκρυνση styles)',
    'confirm' => 'Η εκτέλεση αυτή θα αφαιρέσει όλα τα styles, fonts and useless tags από το συγκεκριμένο content. Κάποια ή και όλες οι  μορφοποιήσεις σου μπορεί να χαθούν.',
    'ok' => '   OK   ',
    'cancel' => '’κυρο',
  ),
  'toggle_borders' => array(
    'title' => 'Όρια περιγραμμάτων',
  ),
  'hyperlink' => array(
    'title' => 'Υπερσύνδεση',
    'url' => 'URL',
    'name' => 'Όνομα',
    'target' => 'Όρια',
    'title_attr' => 'Τίτλος',
    'ok' => '   OK   ',
    'cancel' => '’κυρο',
  ),
  'table_row_prop' => array(
    'title' => 'Ιδιότητες Σειρών',
    'horizontal_align' => 'Οριζόντια ευθυγράμμιση',
    'vertical_align' => 'Κάθετη ευθυγράμμιση',
    'css_class' => 'CSS class',
    'no_wrap' => 'No wrap',
    'bg_color' => 'Background color',
    'ok' => '   OK   ',
    'cancel' => '’κυρο',
    'justifyleft' => 'Αριστερά',
    'justifycenter' => 'Κέντρο',
    'justifyright' => 'Δεξιά',
    'full' => 'Justify',
    'top' => 'Πάνω',
    'middle' => 'Μέση',
    'bottom' => 'Κάτω',
    'baseline' => 'Baseline',
  ),
  'symbols' => array(
    'title' => 'Σπεσιαλ χαρακτήρες',
    'ok' => '   OK   ',
    'cancel' => '’κυρο',
  ),
  'templates' => array(
    'title' => 'Templates',
  ),
  'page_prop' => array(
    'title' => 'Ιδιότητες Σελίδας',
    'title_tag' => 'Τίτλος',
    'charset' => 'Charset',
    'background' => 'Background εικόνα',
    'bgcolor' => 'Background χρώμα',
    'text' => 'Χρώμα κειμένου',
    'link' => 'Χρώμα link',
    'vlink' => 'Χρώμα link που επισκέφτηκαν',
    'alink' => 'Χρώμα Ενεργού link ',
    'leftmargin' => 'Περιθώριο Αριστερό',
    'topmargin' => 'Πάνω Περιθώριο',
    'css_class' => 'CSS class',
    'ok' => '   OK   ',
    'cancel' => '’κυρο',
  ),
  'preview' => array(
    'title' => 'Προεπισκόπηση',
  ),
  'image_popup' => array(
    'title' => 'Image popup',
  ),
  'zoom' => array(
    'title' => 'Zoom',
  ),
);
?>