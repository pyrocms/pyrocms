<?php 
// ================================================
// SPAW PHP WYSIWYG editor control
// ================================================
// Swedish language file
// ================================================
// Developed: Alan Mendelevich, alan@solmetra.lt
// Copyright: Solmetra (c)2003 All rights reserved.
// Swedish translation: Tomas Jogin - tomas@jogin.com
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
    'title' => 'Klipp ut'
  ),
  'copy' => array(
    'title' => 'Kopiera'
  ),
  'paste' => array(
    'title' => 'Klistra in'
  ),
  'undo' => array(
    'title' => 'Ångra'
  ),
  'redo' => array(
    'title' => 'Gör om'
  ),
  'hyperlink' => array(
    'title' => 'Länk'
  ),
  'image_insert' => array(
    'title' => 'Infoga bild',
    'select' => 'Infoga',
    'cancel' => 'Avbryt',
    'library' => 'Bildbibliotek',
    'preview' => 'Förhandsgranska',
    'images' => 'Bilder',
    'upload' => 'Ladda upp bild',
    'upload_button' => 'Ladda upp',
    'error' => 'Fel',
    'error_no_image' => 'Välj en bild',
    'error_uploading' => 'Ett fel uppstod vid fil-uppladdningen. Var god försök igen senare.',
    'error_wrong_type' => 'Fel bildtyp',
    'error_no_dir' => 'Bildbiblioteket finns inte',
  ),
  'image_prop' => array(
    'title' => 'Bildegenskaper',
    'ok' => '   OK   ',
    'cancel' => 'Avbryt',
    'source' => 'Källa',
    'alt' => 'Beskrivning',
    'align' => 'Justering',
    'justifyleft' => 'vänster',
    'justifyright' => 'höger',
    'top' => 'toppen',
    'middle' => 'mitten',
    'bottom' => 'botten',
    'absmiddle' => 'absmiddle',
    'texttop' => 'texttop',
    'baseline' => 'baseline',
    'width' => 'Bredd',
    'height' => 'Höjd',
    'border' => 'Kantlinje',
    'hspace' => 'Horisontell marginal',
    'vspace' => 'Vertikal marginal',
    'error' => 'Fel',
    'error_width_nan' => 'Bredd är inte ett nummer',
    'error_height_nan' => 'Höjd är inte ett nummer',
    'error_border_nan' => 'Kantlinje är inte ett nummer',
    'error_hspace_nan' => 'Horisontell marginal är inte ett nummer',
    'error_vspace_nan' => 'Vertikal marginal är inte ett nummer',
  ),
  'inserthorizontalrule' => array(
    'title' => 'Horisontell linje'
  ),
  'table_create' => array(
    'title' => 'Skapa tabell'
  ),
  'table_prop' => array(
    'title' => 'Tabellegenskaper',
    'ok' => '   OK   ',
    'cancel' => 'Avbryt',
    'rows' => 'Rader',
    'columns' => 'Kolumner',
    'width' => 'Bredd',
    'height' => 'Höjd',
    'border' => 'Kantlinje',
    'pixels' => 'pixlar',
    'cellpadding' => 'Fältmarginal',
    'cellspacing' => 'Fältavstånd',
    'bg_color' => 'Bakgrundsfärg',
    'error' => 'Fel',
    'error_rows_nan' => 'Rader är inte ett nummer',
    'error_columns_nan' => 'Kolumner är inte ett nummer',
    'error_width_nan' => 'Bredd är inte ett nummer',
    'error_height_nan' => 'Höjd är inte ett nummer',
    'error_border_nan' => 'Kantlinje är inte ett nummer',
    'error_cellpadding_nan' => 'Fältmarginal är inte ett nummer',
    'error_cellspacing_nan' => 'Fältavstånd är inte ett nummer',
  ),
  'table_cell_prop' => array(
    'title' => 'Fältegenskaper',
    'horizontal_align' => 'Horisontell justering',
    'vertical_align' => 'Vertikal justering',
    'width' => 'Bredd',
    'height' => 'Höjd',
    'css_class' => 'CSS-klass',
    'no_wrap' => 'Ej automatisk radbrytning',
    'bg_color' => 'Bakgrundsfärg',
    'ok' => '   OK   ',
    'cancel' => 'Avbryt',
    'justifyleft' => 'Vänster',
    'justifycenter' => 'Mitten',
    'justifyright' => 'Höger',
    'top' => 'Toppen',
    'middle' => 'Mitten',
    'bottom' => 'Botten',
    'baseline' => 'Baslinje',
    'error' => 'Fel',
    'error_width_nan' => 'Bredd är inte ett nummer',
    'error_height_nan' => 'Höjd är inte ett nummer',
  ),
  'table_row_insert' => array(
    'title' => 'Infoga rad'
  ),
  'table_column_insert' => array(
    'title' => 'Infoga kolumn'
  ),
  'table_row_delete' => array(
    'title' => 'Radera rad'
  ),
  'table_column_delete' => array(
    'title' => 'Radera kolumn'
  ),
  'table_cell_merge_right' => array(
    'title' => 'Sammanfoga till höger'
  ),
  'table_cell_merge_down' => array(
    'title' => 'Sammanfoga nedåt'
  ),
  'table_cell_split_horizontal' => array(
    'title' => 'Dela fält horisontellt'
  ),
  'table_cell_split_vertical' => array(
    'title' => 'Dela fält vertikalt'
  ),
  'style' => array(
    'title' => 'Stilmall'
  ),
  'fontname' => array(
    'title' => 'Teckensnitt'
  ),
  'fontsize' => array(
    'title' => 'Storlek'
  ),
  'formatBlock' => array(
    'title' => 'Stycke'
  ),
  'bold' => array(
    'title' => 'Fetstil'
  ),
  'italic' => array(
    'title' => 'Kursiv'
  ),
  'underline' => array(
    'title' => 'Understruken'
  ),
  'insertorderedlist' => array(
    'title' => 'Sorterad lista'
  ),
  'insertunorderedlist' => array(
    'title' => 'Osorterad lista'
  ),
  'indent' => array(
    'title' => 'Indrag'
  ),
  'outdent' => array(
    'title' => 'Ta bort indrag'
  ),
  'justifyleft' => array(
    'title' => 'Vänster'
  ),
  'justifycenter' => array(
    'title' => 'Mitten'
  ),
  'justifyright' => array(
    'title' => 'Höger'
  ),
  'fore_color' => array(
    'title' => 'Förgrundsfärg'
  ),
  'bg_color' => array(
    'title' => 'Bakgrundsfärg'
  ),
  'design' => array(
    'title' => 'Byt till layout-läge'
  ),
  'html' => array(
    'title' => 'Byt till HTML-läge'
  ),
  'colorpicker' => array(
    'title' => 'Färgväljare',
    'ok' => '   OK   ',
    'cancel' => 'Avbryt',
  ),
  'cleanup' => array(
    'title' => 'Rensa HTML',
    'confirm' => 'Detta rensar dokumentet från överflödiga stilformateringar och uppmärkningar. Vissa eller alla stilformateringar kan försvinna.',
    'ok' => '   OK   ',
    'cancel' => 'Avbryt',
  ),
  'toggle_borders' => array(
    'title' => 'Visa/göm kantlinjer',
  ),
  'hyperlink' => array(
    'title' => 'Infoga länk',
    'url' => 'Adress',
    'name' => 'Namn',
    'target' => 'Fönster',
    'title_attr' => 'Titel',
    'ok' => '   OK   ',
    'cancel' => 'Avbryt',
  ),
  'table_row_prop' => array(
    'title' => 'Radegenskaper',
    'horizontal_align' => 'Horisontell justering',
    'vertical_align' => 'Vertikal justering',
    'css_class' => 'CSS-klass',
    'no_wrap' => 'Ej automatisk radbrytning',
    'bg_color' => 'Bakgrundsfärg',
    'ok' => '   OK   ',
    'cancel' => 'Avbryt',
    'justifyleft' => 'Vänster',
    'justifycenter' => 'Mitten',
    'justifyright' => 'Höger',
    'top' => 'Toppen',
    'middle' => 'Mitten',
    'bottom' => 'Botten',
    'baseline' => 'Baslinje',
  ),
  'symbols' => array(
    'title' => 'Speciella tecken',
    'ok' => '   OK   ',
    'cancel' => 'Avbryt',
  ),
  'templates' => array(
    'title' => 'Mallar',
  ),
  'page_prop' => array(
    'title' => 'Sidegenskaper',
    'title_tag' => 'Titel',
    'charset' => 'Teckenuppsättning',
    'background' => 'Bakgrundsbild',
    'bgcolor' => 'Bakgrundsfärg',
    'text' => 'Textfärg',
    'link' => 'Länkfärg',
    'vlink' => 'Färg på besökta länkar',
    'alink' => 'Färg på markerade länkar',
    'leftmargin' => 'Vänstermarginal',
    'topmargin' => 'Topmarginal',
    'css_class' => 'CSS-klass',
    'ok' => '   OK   ',
    'cancel' => 'Avbryt',
  ),
  'preview' => array(
    'title' => 'Förhandsgranska',
  ),
  'image_popup' => array(
    'title' => 'Bild-popup',
  ),
  'zoom' => array(
    'title' => 'Zoom',
  ),
);
?>