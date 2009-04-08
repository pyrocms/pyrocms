<?php 
// ================================================
// SPAW v.2.0
// ================================================
// English language file
// ================================================
// Author: Alan Mendelevich, UAB Solmetra
// Translated: Szentgyörgyi János, info@dynamicart.hu
// ------------------------------------------------
//                                www.solmetra.com
// ================================================
// v.2.0
// ================================================

// charset to be used in dialogs
$spaw_lang_charset = 'iso-8859-2';

// language text data array
// first dimension - block, second - exact phrase
// alternative text for toolbar buttons and title for dropdowns - 'title'

$spaw_lang_data = array(
  'cut' => array(
    'title' => 'Kivágás'
  ),
  'copy' => array(
    'title' => 'Másol'
  ),
  'paste' => array(
    'title' => 'Beilleszt'
  ),
  'undo' => array(
    'title' => 'Visszavonás'
  ),
  'redo' => array(
    'title' => 'Mégis'
  ),
  'image_prop' => array(
    'title' => 'Kép',
    'ok' => '   OK   ',
    'cancel' => 'Mégsem',
    'source' => 'Forrás',
    'alt' => 'Alternatív szöveg',
    'align' => 'Igazítás',
    'left' => 'Balra',
    'right' => 'Jobbra',
    'top' => 'Fentre',
    'middle' => 'Középre',
    'bottom' => 'Lentre',
    'absmiddle' => 'Teljesen középre',
    'texttop' => 'Szövegtetejére',
    'baseline' => 'Alapvonalra',
    'width' => 'Szélesség',
    'height' => 'Magasság',
    'border' => 'Keret',
    'hspace' => 'Vízszintes hely',
    'vspace' => 'Függõleges hely',
    'dimensions' => 'Nézetek', // <= new in 2.0.1
    'reset_dimensions' => 'Nézetek alaphelyzetbe', // <= new in 2.0.1
    'title_attr' => 'Cím', // <= new in 2.0.1
    'constrain_proportions' => 'Kényszerített méretek', // <= new in 2.0.1
    'error' => 'Hiba',
    'error_width_nan' => 'Szélesség nem egy szám',
    'error_height_nan' => 'Magasság nem egy szám',
    'error_border_nan' => 'Keret nem egy szám',
    'error_hspace_nan' => 'Vízszintes hely nem egy szám',
    'error_vspace_nan' => 'Függõleges hely nem egy szám',
  ),
  'flash_prop' => array(                // <= new in 2.0
    'title' => 'Flash',
    'ok' => '   OK   ',
    'cancel' => 'Mégse',
    'source' => 'Forrás',
    'width' => 'Szélesség',
    'height' => 'Magasság',
    'error' => 'Hiba',
    'error_width_nan' => 'Szélesség nem egy szám',
    'error_height_nan' => 'Magasság nem egy szám',
  ),
  'inserthorizontalrule' => array( // <== v.2.0 changed from hr
    'title' => 'Vízszintes elválasztó'
  ),
  'table_create' => array(
    'title' => 'Tábla készítés'
  ),
  'table_prop' => array(
    'title' => 'Tábla tulajdonságok',
    'ok' => '   OK   ',
    'cancel' => 'Mégse',
    'rows' => 'Sorok',
    'columns' => 'Oszlopok',
    'css_class' => 'CSS osztály',
    'width' => 'Szélesség',
    'height' => 'Magasság',
    'border' => 'Keret',
    'pixels' => 'Pixelek',
    'cellpadding' => 'Cella kitöltése',
    'cellspacing' => 'Cellák közötti hely',
    'bg_color' => 'Háttérszín',
    'background' => 'Háttérkép',
    'error' => 'Hiba',
    'error_rows_nan' => 'Sorok nem egy szám',
    'error_columns_nan' => 'Oszlopok nem egy szám',
    'error_width_nan' => 'Szélesség nem egy szám',
    'error_height_nan' => 'Magasság nem egy szám',
    'error_border_nan' => 'Keret nem egy szám',
    'error_cellpadding_nan' => 'Cella kitöltés nem egy szám',
    'error_cellspacing_nan' => 'Cellák közötti hely nem egy szám',
  ),
  'table_cell_prop' => array(
    'title' => 'Cella tulajdonságok',
    'horizontal_align' => 'Vízszintes igazítás',
    'vertical_align' => 'Függõleges igazítás',
    'width' => 'Szélesség',
    'height' => 'Magasság',
    'css_class' => 'CSS osztály',
    'no_wrap' => 'Nincs törés',
    'bg_color' => 'Háttérszín',
    'background' => 'Háttérkép',
    'ok' => '   OK   ',
    'cancel' => 'Mégse',
    'left' => 'Balra',
    'center' => 'Középre',
    'right' => 'Jobbra',
    'top' => 'Fentre',
    'middle' => 'Középre',
    'bottom' => 'Lentre',
    'baseline' => 'Alapvonalra',
    'error' => 'Hiba',
    'error_width_nan' => 'Szélesség nem egy szám',
    'error_height_nan' => 'Magasság nem egy szám',
  ),
  'table_row_insert' => array(
    'title' => 'Sor beszúrása'
  ),
  'table_column_insert' => array(
    'title' => 'Oszlop beszúrása'
  ),
  'table_row_delete' => array(
    'title' => 'Sor törlése'
  ),
  'table_column_delete' => array(
    'title' => 'Oszlop törlése'
  ),
  'table_cell_merge_right' => array(
    'title' => 'Cellák egyesítése jobbra'
  ),
  'table_cell_merge_down' => array(
    'title' => 'Cellák egyesítése lefele'
  ),
  'table_cell_split_horizontal' => array(
    'title' => 'Cellák vízszintes szétszakítása'
  ),
  'table_cell_split_vertical' => array(
    'title' => 'Cellák függõleges szétkaszítása'
  ),
  'style' => array(
    'title' => 'Stílus'
  ),
  'fontname' => array( // <== v.2.0 changed from font
    'title' => 'Betû'
  ),
  'fontsize' => array(
    'title' => 'Méret'
  ),
  'formatBlock' => array( // <= v.2.0: changed from paragraph
    'title' => 'Bekezdés'
  ),
  'bold' => array(
    'title' => 'Félkövér'
  ),
  'italic' => array(
    'title' => 'Dõlt'
  ),
  'underline' => array(
    'title' => 'Aláhúzás'
  ),
  'strikethrough' => array(
    'title' => 'Áthúzás'
  ),
  'insertorderedlist' => array( // <== v.2.0 changed from ordered_list
    'title' => 'Számozás'
  ),
  'insertunorderedlist' => array( // <== v.2.0 changed from bulleted list
    'title' => 'Felsorolás'
  ),
  'indent' => array(
    'title' => 'Behúzás növelése'
  ),
  'outdent' => array( // <== v.2.0 changed from unindent
    'title' => 'Behúzás csökkentése'
  ),
  'justifyleft' => array( // <== v.2.0 changed from left
    'title' => 'Balra'
  ),
  'justifycenter' => array( // <== v.2.0 changed from center
    'title' => 'Középre'
  ),
  'justifyright' => array( // <== v.2.0 changed from right
    'title' => 'Jobbra'
  ),
  'justifyfull' => array( // <== v.2.0 changed from justify
    'title' => 'Sorkizárás'
  ),
  'fore_color' => array(
    'title' => 'Szín'
  ),
  'bg_color' => array(
    'title' => 'Háttérszín'
  ),
  'design' => array( // <== v.2.0 changed from design_tab
    'title' => 'Váltás a WYSWYG (design) módra'
  ),
  'html' => array( // <== v.2.0 changed from html_tab
    'title' => 'Váltás a HTML (kód) módra'
  ),
  'colorpicker' => array(
    'title' => 'Színválasztó',
    'ok' => '   OK   ',
    'cancel' => 'Mégse',
  ),
  'cleanup' => array(
    'title' => 'HTML tisztítás (stílusokat megszüntet)',
    'confirm' => 'Ezzel a cselekedettel törli az alkalmazott stílusokat, betûtípusokat és a fölösleges adatokat a jelen dokumentumban. Valamennyi vagy minden formázás el fog veszni.',
    'ok' => '   OK   ',
    'cancel' => 'Mégse',
  ),
  'toggle_borders' => array(
    'title' => 'Szegély megmutatása',
  ),
  'hyperlink' => array(
    'title' => 'Hiperhivatkozás',
    'url' => 'Hivatkozott cím (URL)',
    'name' => 'Név',
    'target' => 'Cél',
    'title_attr' => 'Cím',
  	'a_type' => 'Tipus',
  	'type_link' => 'Link',
  	'type_anchor' => 'Könyvjelzõ',
  	'type_link2anchor' => 'Link a könyvjelzõhöz',
  	'anchors' => 'Könyvjelzõk',
    'ok' => '   OK   ',
    'cancel' => 'Mégse',
  ),
  'hyperlink_targets' => array( // <=== new 1.0.5
  	'_self' => 'saját keret (_self)',
	'_blank' => 'új keret (_blank)',
	'_top' => 'legfelsõ keret (_top)',
	'_parent' => 'fõ keret (_parent)'
  ),
  'unlink' => array( // <=== new v.2.0
    'title' => 'Hiperhivatkozás eltávolítása'
  ),
  'table_row_prop' => array(
    'title' => 'Sor tulajdonságai',
    'horizontal_align' => 'Vízszintes igazítás',
    'vertical_align' => 'Függõeges igazítás',
    'css_class' => 'CSS osztály',
    'no_wrap' => 'Nincs csomagolás',
    'bg_color' => 'Háttérszín',
    'ok' => '   OK   ',
    'cancel' => 'Mégse',
    'left' => 'Balra',
    'center' => 'Középre',
    'right' => 'Jobbra',
    'top' => 'Tetejére',
    'middle' => 'Középre',
    'bottom' => 'Aljára',
    'baseline' => 'Alapvonalra',
  ),
  'symbols' => array(
    'title' => 'Speciális karakterek',
    'ok' => '   OK   ',
    'cancel' => 'Mégse',
  ),
  'templates' => array(
    'title' => 'Sablonok',
  ),
  'page_prop' => array(
    'title' => 'Oldal tulajdonságok',
    'title_tag' => 'Címe',
    'charset' => 'Karakter típus',
    'background' => 'Háttérkép',
    'bgcolor' => 'Háttérszín',
    'text' => 'Szöveg színe',
    'link' => 'Hivatkozás színe',
    'vlink' => 'Látogatott hivatkozás színe',
    'alink' => 'Aktív hivatkozás színe',
    'leftmargin' => 'Bal margó',
    'topmargin' => 'Tetõ margó',
    'css_class' => 'CSS osztály',
    'ok' => '   OK   ',
    'cancel' => 'Mégse',
  ),
  'preview' => array(
    'title' => 'Elõnézet',
  ),
  'image_popup' => array(
    'title' => 'Elõugró kép',
  ),
  'zoom' => array(
    'title' => 'Nagyítás',
  ),
  'subscript' => array(
    'title' => 'Alsóindex',
  ),
  'superscript' => array(
    'title' => 'Felsõindex',
  ),
);
?>
