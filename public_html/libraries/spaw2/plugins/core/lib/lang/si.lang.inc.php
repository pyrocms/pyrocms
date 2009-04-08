<?php 
// ================================================
// SPAW PHP WYSIWYG editor control
// ================================================
// Slovenian language file
// ================================================
// Developed: Alan Mendelevich, alan@solmetra.lt
// Copyright: Solmetra (c)2003 All rights reserved.
// Sloveniain translation: Vladimir Ota
//                         lado@prim-nov.si
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
    'title' => 'Odreži'
  ),
  'copy' => array(
    'title' => 'Kopiraj'
  ),
  'paste' => array(
    'title' => 'Prilepi'
  ),
  'undo' => array(
    'title' => 'Razveljavi'
  ),
  'redo' => array(
    'title' => 'Ponovno uveljavi'
  ),
  'hyperlink' => array(
    'title' => 'Povezava'
  ),
  'image_insert' => array(
    'title' => 'Vrini sliko',
    'select' => 'Izberi',
    'cancel' => 'Prekini',
    'library' => 'Knjižnjica',
    'preview' => 'Predogled',
    'images' => 'Slike',
    'upload' => 'Pošlji sliko',
    'upload_button' => 'Pošlji',
    'error' => 'Napaka',
    'error_no_image' => 'Izberite sliko, prosim',
    'error_uploading' => 'Napaka pri pošiljanju datoteke. Poskusite ponovno',
    'error_wrong_type' => 'Napačna vrsta datoteke s sliko',
    'error_no_dir' => 'Knjižnjica ne obstaja / ni dostopna',
  ),
  'image_prop' => array(
    'title' => 'Lastnosti slike',
    'ok' => '   OK   ',
    'cancel' => 'Prekini',
    'source' => 'Source',
    'alt' => 'Alternativno besedilo',
    'align' => 'Poravnaj',
    'justifyleft' => 'levo',
    'justifyright' => 'desno',
    'top' => 'zgoraj',
    'middle' => 'na sredino',
    'bottom' => 'spodaj',
    'absmiddle' => 'absolutno sredino',
    'texttop' => 'na vrh teksta',
    'baseline' => 'baseline',
    'width' => 'Širina',
    'height' => 'Višina',
    'border' => 'Obroba',
    'hspace' => 'Horiz. razmik',
    'vspace' => 'Vert. razmik',
    'error' => 'Napaka',
    'error_width_nan' => 'Širina mora biti podana s številom',
    'error_height_nan' => 'Višina mora biti podana s številom',
    'error_border_nan' => 'Obroba mora biti podana s številom',
    'error_hspace_nan' => 'Horiz. razmik mora biti podan s številom',
    'error_vspace_nan' => 'Vert. razmik mora biti podan številom',
  ),
  'inserthorizontalrule' => array(
    'title' => 'Horizontalna črta'
  ),
  'table_create' => array(
    'title' => 'Naredi tabelo'
  ),
  'table_prop' => array(
    'title' => 'Lastnosti tabele',
    'ok' => '   OK   ',
    'cancel' => 'Prekini',
    'rows' => 'Vrstic',
    'columns' => 'Kolon',
    'width' => 'Širina',
    'height' => 'Višina',
    'border' => 'Debelina obrobe',
    'pixels' => 'pixlov',
    'cellpadding' => 'Debelina obloge celic',
    'cellspacing' => 'Razmik med celicami',
    'bg_color' => 'Barva ozadja',
    'error' => 'Napaka',
    'error_rows_nan' => 'Število vrstic mora biti podano s številom',
    'error_columns_nan' => 'Število kolon mora biti podano s številom',
    'error_width_nan' => 'Širina mora biti podana s številom',
    'error_height_nan' => 'Višina mora biti podana s številom',
    'error_border_nan' => 'Debelina obrobe mora biti podana s številom',
    'error_cellpadding_nan' => 'Debelina obloge celic mora biti podana s številom',
    'error_cellspacing_nan' => 'Razmik med celicami mora biti podan s številom',
  ),
  'table_cell_prop' => array(
    'title' => 'Lastnosti celic',
    'horizontal_align' => 'Horiz. poravnava',
    'vertical_align' => 'Vert. poravnava',
    'width' => 'Širina',
    'height' => 'Višina',
    'css_class' => 'CSS class',
    'no_wrap' => 'Brez preloma (wrap)',
    'bg_color' => 'Barva ozadja',
    'ok' => '   OK   ',
    'cancel' => 'Prekini',
    'justifyleft' => 'Levo',
    'justifycenter' => 'Center',
    'justifyright' => 'Desno',
    'top' => 'Zgoraj',
    'middle' => 'Sredina',
    'bottom' => 'Spodaj',
    'baseline' => 'Baseline',
    'error' => 'Napaka',
    'error_width_nan' => 'Višina mora biti podana s številom',
    'error_height_nan' => 'Višina mora biti podana s številom',
  ),
  'table_row_insert' => array(
    'title' => 'Vrini vrstico'
  ),
  'table_column_insert' => array(
    'title' => 'Vrini kolono'
  ),
  'table_row_delete' => array(
    'title' => 'Briši vrstico'
  ),
  'table_column_delete' => array(
    'title' => 'Briši kolono'
  ),
  'table_cell_merge_right' => array(
    'title' => 'Vrini na desni'
  ),
  'table_cell_merge_down' => array(
    'title' => 'Vrini spodaj'
  ),
  'table_cell_split_horizontal' => array(
    'title' => 'Horizontalno Razdeli celico'
  ),
  'table_cell_split_vertical' => array(
    'title' => 'Vretikalno razdeli celico'
  ),
  'style' => array(
    'title' => 'Stil'
  ),
  'fontname' => array(
    'title' => 'Font'
  ),
  'fontsize' => array(
    'title' => 'Velikost'
  ),
  'formatBlock' => array(
    'title' => 'Odstavek'
  ),
  'bold' => array(
    'title' => 'Krepko'
  ),
  'italic' => array(
    'title' => 'Kurzivno'
  ),
  'underline' => array(
    'title' => 'Podčrtano'
  ),
  'insertorderedlist' => array(
    'title' => 'Oštevilčen seznam'
  ),
  'insertunorderedlist' => array(
    'title' => '"Bulleted" seznam'
  ),
  'indent' => array(
    'title' => 'Odmik'
  ),
  'outdent' => array(
    'title' => 'Izmik'
  ),
  'justifyleft' => array(
    'title' => 'Levo'
  ),
  'justifycenter' => array(
    'title' => 'Center'
  ),
  'justifyright' => array(
    'title' => 'Desno'
  ),
  'fore_color' => array(
    'title' => 'Barva ospredja'
  ),
  'bg_color' => array(
    'title' => 'Barva ozadjar'
  ),
  'design' => array(
    'title' => 'Preklopi v WYSIWYG (design) način dela'
  ),
  'html' => array(
    'title' => 'Preklopi na HTML (koda) način dela'
  ),
  'colorpicker' => array(
    'title' => 'Izbira barve',
    'ok' => '   OK   ',
    'cancel' => 'Prekini',
  ),
  'cleanup' => array(
    'title' => 'Čiščenje HTML (odstranjevanje stilov)',
    'confirm' => 'S tem boste odstranili stile, fonte in neuporabne HTML tage iz trenutnega besedila. Oblika bo deloma ali povsem izgubljena.',
    'ok' => '   OK   ',
    'cancel' => 'Prekini',
  ),
  'toggle_borders' => array(
    'title' => 'Preklopi obrobe',
  ),
  'hyperlink' => array(
    'title' => 'Povezava',
    'url' => 'URL',
    'name' => 'Ime',
    'target' => 'Tarča',
    'title_attr' => 'Naslov',
    'ok' => '   OK   ',
    'cancel' => 'Prekini',
  ),
  'table_row_prop' => array(
    'title' => 'Lastnosti vrstic',
    'horizontal_align' => 'Horizontalna poravnava',
    'vertical_align' => 'Vertikana poravnava',
    'css_class' => 'CSS class',
    'no_wrap' => 'Brez preloma (wrap)',
    'bg_color' => 'Barva ozadja',
    'ok' => '   OK   ',
    'cancel' => 'Prekini',
    'justifyleft' => 'Levo',
    'justifycenter' => 'Center',
    'justifyright' => 'Desno',
    'top' => 'Zgoraj',
    'middle' => 'Sredina',
    'bottom' => 'Spodaj',
    'baseline' => 'Baseline',
  ),
  'symbols' => array(
    'title' => 'Posebni znaki',
    'ok' => '   OK   ',
    'cancel' => 'Prekini',
  ),
  'templates' => array(
    'title' => 'Predloge',
  ),
  'page_prop' => array(
    'title' => 'Lastnosti strani',
    'title_tag' => 'Naslov',
    'charset' => 'Nabor znakov',
    'background' => 'Slika v ozadju',
    'bgcolor' => 'Barva ozadja',
    'text' => 'Barva teksta',
    'link' => 'Barva povezav',
    'vlink' => 'Barva že obiskane povezave',
    'alink' => 'Barva aktivne povezave',
    'leftmargin' => 'Meja levo',
    'topmargin' => 'Meja zgoraj',
    'css_class' => 'CSS class',
    'ok' => '   OK   ',
    'cancel' => 'Prekini',
  ),
  'preview' => array(
    'title' => 'Predogled',
  ),
  'image_popup' => array(
    'title' => 'Popup s sliko',
  ),
  'zoom' => array(
    'title' => 'Zoom',
  ),
);
?>