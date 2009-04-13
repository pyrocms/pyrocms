<?php
// ================================================
// SPAW PHP WYSIWYG editor control
// ================================================
// Hebrew language file
// ================================================
// Developed: Alan Mendelevich, alan@solmetra.lt
// Original Translation to Hebrew (v.1.0): Yaron Gonen (lord_gino@yahoo.com)
// Additional Translation to Hebrew (v.1.1): Boris Aranovich (beer_nomaed@hotmail.com)
// Copyright: Solmetra (c)2003 All rights reserved.
// ------------------------------------------------
//                                www.solmetra.com
// ================================================
// v.1.1, 2005-03-20
// ================================================

// charset to be used in dialogs
$spaw_lang_charset = 'utf-8';

// text direction for the language
$spaw_lang_direction = 'rtl';

// language text data array
// first dimension - block, second - exact phrase
// alternative text for toolbar buttons and title for dropdowns - 'title'

$spaw_lang_data = array(
  'cut' => array(
    'title' => 'גזור'
  ),
  'copy' => array(
    'title' => 'העתק'
  ),
  'paste' => array(
    'title' => 'הדבק'
  ),
  'undo' => array(
    'title' => 'בטל'
  ),
  'redo' => array(
    'title' => 'בצע שוב'
  ),
  'hyperlink' => array(
    'title' => 'היפר קישור'
  ),
  'image_insert' => array(
    'title' => 'הכנס תמונה',
    'select' => '   בחר   ',
	'delete' => '  מחיקה  ', // new 1.0.5
    'cancel' => '   בטל   ',
    'library' => 'ספריה',
    'preview' => 'תצוגה מקדימה',
    'images' => 'תמונות',
    'upload' => 'העלה תמונה',
    'upload_button' => 'העלה',
    'error' => 'שגיאה',
    'error_no_image' => 'בחר תמונה',
    'error_uploading' => 'ארעה שגיאה בעת העלאת התמונה. אנא נסה שוב מאוחר יותר.',
    'error_wrong_type' => 'סוג קובץ תמונה שגוי',
    'error_no_dir' => 'הספריה אינה קיימת',
	'error_cant_delete' => 'שגיאה: המחיקה נכשלה!', // new 1.0.5
  ),
  'image_prop' => array(
    'title' => 'אפשרויות תמונה',
    'ok' => '  המשך  ',
    'cancel' => '  בטל  ',
    'source' => 'מקור',
    'alt' => 'טקסט אלטרנטיבי',
    'align' => 'הצמדה',
    'justifyleft' => 'שמאל',
    'justifyright' => 'ימין',
    'top' => 'למעלה',
    'middle' => 'אמצע',
    'bottom' => 'למטה',
    'absmiddle' => 'מרכז',
    'texttop' => 'texttop',
    'baseline' => 'baseline',
    'width' => 'רוחב',
    'height' => 'גובה',
    'border' => 'קו גבול',
    'hspace' => 'מרווח אפקי',
    'vspace' => 'מרווח אנכי',
    'error' => 'שגיאה',
    'error_width_nan' => 'הרוחב אינו מספר',
    'error_height_nan' => 'הגובה אינו מספר',
    'error_border_nan' => 'הגבול אינו מספר',
    'error_hspace_nan' => 'מרווח אפקי אינו מספר',
    'error_vspace_nan' => 'מרווח אנכי אינו מספר',
  ),
  'inserthorizontalrule' => array(
    'title' => 'קו אפקי'
  ),
  'table_create' => array(
    'title' => 'צור טבלה'
  ),
  'table_prop' => array(
    'title' => 'אפשרויות טבלה',
    'ok' => '  המשך  ',
    'cancel' => '  בטל  ',
    'rows' => 'שורות',
    'columns' => 'עמודות',
    'css_class' => 'CSS class', // <=== new 1.0.6
    'width' => 'רוחב',
    'height' => 'גובה',
    'border' => 'גבול',
    'pixels' => 'פיקסלים',
    'cellpadding' => 'דיפון תא',
    'cellspacing' => 'ריווח תא',
    'bg_color' => 'צבע רקע',
    'background' => 'תמונת רקע', // <=== new 1.0.6
    'error' => 'שגיאה',
    'error_rows_nan' => 'השורות אינן מספר',
    'error_columns_nan' => 'העמודות אינן מספר',
    'error_width_nan' => 'הרוחב אינן מספר',
    'error_height_nan' => 'הגובה אינו מספר',
    'error_border_nan' => 'הגבול אינו מספר',
    'error_cellpadding_nan' => 'דיפון התא אינו מספר',
    'error_cellspacing_nan' => 'ריווח התא אינו מספר',
  ),
  'table_cell_prop' => array(
    'title' => 'אפשרויות תא',
    'horizontal_align' => 'הצמדה אפקית',
    'vertical_align' => 'הצמדה אנכית',
    'width' => 'רוחב',
    'height' => 'גובה',
    'css_class' => 'CSS class',
    'no_wrap' => 'ללא שבירת שורות',
    'bg_color' => 'צבע רקע',
    'background' => 'תמונת רקע', // <=== new 1.0.6
    'ok' => '  המשך  ',
    'cancel' => '  בטל  ',
    'justifyleft' => 'שמאל',
    'justifycenter' => 'מרכז',
    'justifyright' => 'ימין',
    'top' => 'למעלה',
    'middle' => 'אמצע',
    'bottom' => 'למטה',
    'baseline' => 'קו התחלה',
    'error' => 'שגיאה',
    'error_width_nan' => 'הרוחב אינו מספר',
    'error_height_nan' => 'גובה אינו מספר',

  ),
  'table_row_insert' => array(
    'title' => 'הכנס רשומה'
  ),
  'table_column_insert' => array(
    'title' => 'הכנס עמודה'
  ),
  'table_row_delete' => array(
    'title' => 'מחק רשומה'
  ),
  'table_column_delete' => array(
    'title' => 'מחק עמודה'
  ),
  'table_cell_merge_right' => array(
    'title' => 'מזג תאים ימינה'
  ),
  'table_cell_merge_down' => array(
    'title' => 'מזג תאים למטה'
  ),
  'table_cell_split_horizontal' => array(
    'title' => 'פצל תא אפקית'
  ),
  'table_cell_split_vertical' => array(
    'title' => 'פצל תא אנכית'
  ),
  'style' => array(
    'title' => 'סגנון'
  ),
  'fontname' => array(
    'title' => 'גופן'
  ),
  'fontsize' => array(
    'title' => 'גודל'
  ),
  'formatBlock' => array(
    'title' => 'פיסקה'
  ),
  'bold' => array(
    'title' => 'מודגש'
  ),
  'italic' => array(
    'title' => 'נטוי'
  ),
  'underline' => array(
    'title' => 'קו תחתי'
  ),
  'insertorderedlist' => array(
    'title' => 'רשימה ממוספרת'
  ),
  'insertunorderedlist' => array(
    'title' => 'רשימה'
  ),
  'indent' => array(
    'title' => 'הכנס פנימה'
  ),
  'outdent' => array(
    'title' => 'הוצא'
  ),
  'justifyleft' => array(
    'title' => 'שמאל'
  ),
  'justifycenter' => array(
    'title' => 'מרכז'
  ),
  'justifyright' => array(
    'title' => 'ימין'
  ),
  'fore_color' => array(
    'title' => 'צבע קדמי'
  ),
  'bg_color' => array(
    'title' => 'צבע רקע'
  ),
  'design' => array(
    'title' => 'עיצוב המסמך'
  ),
  'html' => array(
    'title' => 'ערוך קוד Html'
  ),
  'colorpicker' => array(
    'title' => 'בחר צבע',
    'ok' => '  המשך  ',
    'cancel' => '  בטל  ',
  ),
  // <<<<<<<<< NEW >>>>>>>>>
  'cleanup' => array(
    'title' => 'ניקוי Html (הסר סגנונות)',
    'confirm' => 'ביצוע פעולה זו יסיר את כל הסגנונות, גופנים וכל התאגים הלא שימושיים ממסמך זה. חלק או כל העיצובים יאבדו.',
    'ok' => '  המשך  ',
    'cancel' => '  בטל  ',
  ),
  'toggle_borders' => array(
    'title' => 'חיזוק גבולות',
  ),
  'hyperlink' => array(
    'title' => 'היפר קישור',
    'url' => 'URL',
    'name' => 'שם',
    'target' => 'מטרה',
    'title_attr' => 'כותרת',
	'a_type' => 'סוג', // <=== new 1.0.6
	'type_link' => 'קישור', // <=== new 1.0.6
	'type_anchor' => 'עוגן', // <=== new 1.0.6
	'type_link2anchor' => 'קישור לעוגן', // <=== new 1.0.6
	'anchors' => 'עוגנים', // <=== new 1.0.6
    'ok' => '  המשך  ',
    'cancel' => '  בטל  ',
  ),
  'hyperlink_targets' => array( // <=== new 1.0.5
  	'_self' => 'החלון עצמו (_self)',
	'_blank' => 'חלון חדש (_blank)',
	'_top' => 'פריים עליון (_top)',
	'_parent' => 'פריים אב (_parent)'
  ),
  'table_row_prop' => array(
    'title' => 'תכונות שורה',
    'horizontal_align' => 'הצמדה אופקית',
    'vertical_align' => 'הצמדה אנכית',
    'css_class' => 'CSS class',
    'no_wrap' => 'ללא שבירת שורות',
    'bg_color' => 'צבע רקע',
    'ok' => '  המשך  ',
    'cancel' => '  בטל  ',
    'justifyleft' => 'שמאל',
    'justifycenter' => 'מרכז',
    'justifyright' => 'ימין',
    'top' => 'למעלה',
    'middle' => 'אמצע',
    'bottom' => 'למטה',
    'baseline' => 'קו התחלה',
  ),
  'symbols' => array(
    'title' => 'תווים מיוחדים',
    'ok' => '  המשך  ',
    'cancel' => '  בטל  ',
  ),
  'templates' => array(
    'title' => 'תבניות',
  ),
  'page_prop' => array(
    'title' => 'תכונות דף',
    'title_tag' => 'כותרת',
    'charset' => 'Charset',
    'background' => 'תמונת רקע',
    'bgcolor' => 'צבע רקע',
    'text' => 'צבע טקסט',
    'link' => 'צבע קישור',
    'vlink' => 'צבע קישור שהיו בו כבר',
    'alink' => 'צבע קישור פעיל',
    'leftmargin' => 'שוליים שמאליים',
    'topmargin' => 'שוליים עליונים',
    'css_class' => 'CSS class',
    'ok' => '  המשך  ',
    'cancel' => '  בטל  ',
  ),
  'preview' => array(
    'title' => 'תצוגה מקדימה',
  ),
  'image_popup' => array(
    'title' => 'תמונה קופצת',
  ),
  'zoom' => array(
    'title' => 'זום',
  ),
  /***** New for 1.0.7, added by Boris A. *****/
  'subscript' => array( // <=== new 1.0.7
    'title' => 'כתב תחתון',
  ),
  'superscript' => array( // <=== new 1.0.7
    'title' => 'כתב עליון',
  ),
);
?>