<?php 
// ================================================
// SPAW v.2.0
// ================================================
// Slovak language file
// ================================================
// Developed: Alan Mendelevich, alan@solmetra.lt
// Copyright: Solmetra (c)2003 All rights reserved.
// Slovak translation: Martin Švec
//                     shuter@vadium.sk
// ------------------------------------------------
//                                www.solmetra.com
// ================================================
// v.2.0
// ================================================

// charset to be used in dialogs
$spaw_lang_charset = 'utf-8';

// language text data array
// first dimension - block, second - exact phrase
// alternative text for toolbar buttons and title for dropdowns - 'title'

$spaw_lang_data = array(
  'cut' => array(
    'title' => 'Vystrihnúť'
  ),
  'copy' => array(
    'title' => 'Kopírovať'
  ),
  'paste' => array(
    'title' => 'Vložiť'
  ),
  'undo' => array(
    'title' => 'Vrátiť úpravy'
  ),
  'redo' => array(
    'title' => 'Znovu vykonať úpravy'
  ),
  'image' => array(
    'title' => 'Rýchle vloženie obrázka'
  ),
  'image_prop' => array(
    'title' => 'Obrázok',
    'ok' => '   OK   ',
    'cancel' => 'Zrušiť',
    'source' => 'Zdroj',
    'alt' => 'Alternatívny text',
    'align' => 'Zarovnanie',
    'left' => 'vľavo',
    'right' => 'vpravo',
    'top' => 'nahor',
    'middle' => 'nastred',
    'bottom' => 'naspodok',
    'absmiddle' => 'absolútny stred',
    'texttop' => 'text-nahor',
    'baseline' => 'základný riadok',
    'width' => 'Šírka',
    'height' => 'Výška',
    'border' => 'Okraj',
    'hspace' => 'Horiz. medzera',
    'vspace' => 'Vert. medzera',
    'dimensions' => 'Rozmery', // <= new in 2.0.1
    'reset_dimensions' => 'Obnoviť rozmery', // <= new in 2.0.1
    'title_attr' => 'Popis', // <= new in 2.0.1
    'constrain_proportions' => 'Vynútiť proporcie', // <= new in 2.0.1
    'css_class' => 'CSS trieda', // <= new in 2.0.6
    'error' => 'Chyba',
    'error_width_nan' => 'Šírka nie je číslo',
    'error_height_nan' => 'Výška nie je číslo',
    'error_border_nan' => 'Okraj nie je číslo',
    'error_hspace_nan' => 'Horizontálna medzera nie je číslo',
    'error_vspace_nan' => 'Vertikálna medzera nie je číslo',
  ),
  'flash_prop' => array(                // <= new in 2.0
    'title' => 'Flash',
    'ok' => '   OK   ',
    'cancel' => 'Zrušiť',
    'source' => 'Zdroj',
    'width' => 'Šírka',
    'height' => 'Výška',
    'error' => 'Chyba',
    'error_width_nan' => 'Šírka nie je číslo',
    'error_height_nan' => 'Výška nie je číslo',
  ),
  'inserthorizontalrule' => array( // <== v.2.0 changed from hr
    'title' => 'Horizontálna čiara'
  ),
  'table_create' => array(
    'title' => 'Vytvoriť tabuľku'
  ),
  'table_prop' => array(
    'title' => 'Vlastnosti tabuľky',
    'ok' => '   OK   ',
    'cancel' => 'Zrušiť',
    'rows' => 'Riadky',
    'columns' => 'Stĺpce',
    'css_class' => 'CSS trieda',
    'width' => 'Šírka',
    'height' => 'Výška',
    'border' => 'Okraj',
    'pixels' => 'pixlov',
    'cellpadding' => 'Odsadenie v bunke',
    'cellspacing' => 'Vzdialenosť buniek',
    'bg_color' => 'Farba pozadia',
    'background' => 'Obrázok pozadia',
    'error' => 'Chyba',
    'error_rows_nan' => 'Riadky nie sú číslo',
    'error_columns_nan' => 'Stĺpce nie sú číslo',
    'error_width_nan' => 'Šírka nie je číslo',
    'error_height_nan' => 'Výška nie je číslo',
    'error_border_nan' => 'Okraj nie je číslo',
    'error_cellpadding_nan' => 'Odsadenie v bunke nie je číslo',
    'error_cellspacing_nan' => 'Vzdialenosť buniek nie je číslo',
  ),
  'table_cell_prop' => array(
    'title' => 'Vlastnosti bunky',
    'horizontal_align' => 'Horizontálne zarovnanie',
    'vertical_align' => 'Vertikálne zarovnanie',
    'width' => 'Šírka',
    'height' => 'Výška',
    'css_class' => 'CSS trieda',
    'no_wrap' => 'Nezalamovať',
    'bg_color' => 'Farba pozadia',
    'background' => 'Obrázok pozadia',
    'ok' => '   OK   ',
    'cancel' => 'Zrušiť',
    'left' => 'Vľavo',
    'center' => 'Centrovať',
    'right' => 'Vpravo',
    'top' => 'Nahor',
    'middle' => 'Nastred',
    'bottom' => 'Naspodok',
    'baseline' => 'Základný riadok',
    'error' => 'Chyba',
    'error_width_nan' => 'Šírka nie je číslo',
    'error_height_nan' => 'Výška nie je číslo',
  ),
  'table_row_insert' => array(
    'title' => 'Vložiť riadok'
  ),
  'table_column_insert' => array(
    'title' => 'Vložiť stĺpec'
  ),
  'table_row_delete' => array(
    'title' => 'Vymazať riadok'
  ),
  'table_column_delete' => array(
    'title' => 'Vymazať stĺpec'
  ),
  'table_cell_merge_right' => array(
    'title' => 'Zlúčiť vpravo'
  ),
  'table_cell_merge_down' => array(
    'title' => 'Zlúčiť nadol'
  ),
  'table_cell_split_horizontal' => array(
    'title' => 'Rozdeliť bunku horizontálne'
  ),
  'table_cell_split_vertical' => array(
    'title' => 'Rozdeliť bunku vertikálne'
  ),
  'style' => array(
    'title' => 'Štýl'
  ),
  'fontname' => array( // <== v.2.0 changed from font
    'title' => 'Písmo'
  ),
  'fontsize' => array(
    'title' => 'Veľkosť'
  ),
  'formatBlock' => array( // <= v.2.0: changed from paragraph
    'title' => 'Odstavec'
  ),
  'bold' => array(
    'title' => 'Hrubé'
  ),
  'italic' => array(
    'title' => 'Šikmé'
  ),
  'underline' => array(
    'title' => 'Podčiarknuté'
  ),
  'strikethrough' => array(
    'title' => 'Preškrtnuté'
  ),
  'insertorderedlist' => array( // <== v.2.0 changed from ordered_list
    'title' => 'Číslovaný zoznam'
  ),
  'insertunorderedlist' => array( // <== v.2.0 changed from bulleted list
    'title' => 'Nečíslovaný zoznam'
  ),
  'indent' => array(
    'title' => 'Odsadenie'
  ),
  'outdent' => array( // <== v.2.0 changed from unindent
    'title' => 'Zrušiť odsadenie'
  ),
  'justifyleft' => array( // <== v.2.0 changed from left
    'title' => 'Vľavo'
  ),
  'justifycenter' => array( // <== v.2.0 changed from center
    'title' => 'Centrovať'
  ),
  'justifyright' => array( // <== v.2.0 changed from right
    'title' => 'Vpravo'
  ),
  'justifyfull' => array( // <== v.2.0 changed from justify
    'title' => 'Do bloku'
  ),
  'fore_color' => array(
    'title' => 'Farba popredia'
  ),
  'bg_color' => array(
    'title' => 'Farba pozadia'
  ),
  'design' => array( // <== v.2.0 changed from design_tab
    'title' => 'Prepnúť do WYSIWYG (dizajn) módu'
  ),
  'html' => array( // <== v.2.0 changed from html_tab
    'title' => 'Prepnúť do HTML (kód) módu'
  ),
  'colorpicker' => array(
    'title' => 'Paleta farieb',
    'ok' => '   OK   ',
    'cancel' => 'Zrušiť',
  ),
  'cleanup' => array(
    'title' => 'HTML vyčistiť (odstrániť štýly)',
    'confirm' => 'Vykonaním akcie odstránite všetky štýly, fonty a zbytočné tagy z aktuálneho obsahu. Niektoré alebo všetky formátovania budú odstránené.',
    'ok' => '   OK   ',
    'cancel' => 'Zrušiť',
  ),
  'toggle_borders' => array(
    'title' => 'Zapnúť zobrazenie okrajov tabľky',
  ),
  'hyperlink' => array(
    'title' => 'Hypertextový odkaz',
    'url' => 'URL',
    'name' => 'Meno',
    'target' => 'Cieľ',
    'title_attr' => 'Popis',
  	'a_type' => 'Typ',
  	'type_link' => 'Odkaz',
  	'type_anchor' => 'Kotva',
  	'type_link2anchor' => 'Odkaz do Kotvy',
  	'anchors' => 'Kotvy',
  	'quick_links' => "Rýchle odkazy", // <=== new in 2.0.6
    'ok' => '   OK   ',
    'cancel' => 'Zrušiť',
  ),
  'hyperlink_targets' => array(
  	'_self' => 'to isté okno (_self)',
  	'_blank' => 'nové okno (_blank)',
  	'_top' => 'horný rám (_top)',
  	'_parent' => 'rodičovský rám (_parent)'
  ),
  'unlink' => array( // <=== new v.2.0
    'title' => 'Odstrániť hypertextový odkaz'
  ),
  'table_row_prop' => array(
    'title' => 'Vlastnosti riadku tabuľky',
    'horizontal_align' => 'Horizontálne zarovnanie',
    'vertical_align' => 'Vertikálne zarovnanie',
    'css_class' => 'CSS trieda',
    'no_wrap' => 'Nezalamovať',
    'bg_color' => 'Farba pozadia',
    'ok' => '   OK   ',
    'cancel' => 'Zrušiť',
    'left' => 'Vľavo',
    'center' => 'Centrovať',
    'right' => 'Vpravo',
    'top' => 'Nahor',
    'middle' => 'Nastred',
    'bottom' => 'Naspodok',
    'baseline' => 'Základný riadok',
  ),
  'symbols' => array(
    'title' => 'Špeciálne znaky',
    'ok' => '   OK   ',
    'cancel' => 'Zrušiť',
  ),
  'templates' => array(
    'title' => 'šablóny',
  ),
  'page_prop' => array(
    'title' => 'Vlastnosti stránky',
    'title_tag' => 'Názov',
    'charset' => 'Kódovanie',
    'background' => 'Obrázok pozadia',
    'bgcolor' => 'Farba pozadia',
    'text' => 'Farba textu',
    'link' => 'Farba odkazu',
    'vlink' => 'Farba navštíveného odkazu',
    'alink' => 'Farba aktívneho odkazu',
    'leftmargin' => 'Ľavý okraj',
    'topmargin' => 'Horný okraj',
    'css_class' => 'CSS trieda',
    'ok' => '   OK   ',
    'cancel' => 'Zrušiť',
  ),
  'preview' => array(
    'title' => 'Náhľad',
  ),
  'image_popup' => array(
    'title' => 'Rozklikávací obrázok',
  ),
  'zoom' => array(
    'title' => 'Zväčšenie',
  ),
  'subscript' => array(
    'title' => 'Dolný index',
  ),
  'superscript' => array(
    'title' => 'Horný index',
  ),
);
?>