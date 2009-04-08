<?php 
// ================================================
// SPAW PHP WYSIWYG editor control
// ================================================
// Serbian latin language file
// ================================================
// Developed: Alan Mendelevich, alan@solmetra.lt
// Copyright: Solmetra (c)2003 All rights reserved.
// Serbian translation:  
//                         jbole@neobee.net
// ------------------------------------------------
//                                www.solmetra.com
// ================================================
// v.1.0.6, 2005-11-07
// ================================================

// charset to be used in dialogs
$spaw_lang_charset = 'utf-8';

// language text data array
// first dimension - block, second - exact phrase
// alternative text for toolbar buttons and title for dropdowns - 'title'

$spaw_lang_data = array(
  'cut' => array(
    'title' => 'Iseci'
  ),
  'copy' => array(
    'title' => 'Kopiraj'
  ),
  'paste' => array(
    'title' => 'Zalepi'
  ),
  'undo' => array(
    'title' => 'Poni&#353;ti'
  ),
  'redo' => array(
    'title' => 'Obnovi'
  ),
  'hyperlink' => array(
    'title' => 'Link'
  ),
  'image_insert' => array(
    'title' => 'Unos slike',
    'select' => 'Izbor',
    'delete' => 'Obri&#353;i', // new 1.0.5
    'cancel' => 'Odustani',
    'library' => 'Biblioteka',
    'preview' => 'Pregled',
    'images' => 'Slike',
    'upload' => 'Unos slike',
    'upload_button' => 'Unos',
    'error' => 'Gre&#353;ka',
    'error_no_image' => 'Izaberite sliku',
    'error_uploading' => 'Gre&#353;ka pri unosu slike. Poku&#353;ajte ponovo',
    'error_wrong_type' => 'Datoteka ne sadr&#382;i sliku',
    'error_no_dir' => 'Biblioteka ne postoji / nije dostupna',
    'error_cant_delete' => 'Ne mogu da obri&#353;em', // new 1.0.5
  ),
  'image_prop' => array(
    'title' => 'Naziv slike',
    'ok' => '   OK   ',
    'cancel' => 'Odustani',
    'source' => 'Izvor',
    'alt' => 'Alternativni naziv',
    'align' => 'Poravnaj',
    'justifyleft' => 'lievo',
    'justifyright' => 'desno',
    'top' => 'gore',
    'middle' => 'u sredinu',
    'bottom' => 'dole',
    'absmiddle' => 'apsolutna sredina',
    'texttop' => 'na vrh teksta',
    'baseline' => 'na osnovni red',
    'width' => '&#352;irina',
    'height' => 'Visina',
    'border' => 'Okvir',
    'hspace' => 'Horizontalni razmak',
    'vspace' => 'Vertikalni razmak',
    'error' => 'Gre&#353;ka',
    'error_width_nan' => '&#352;irina mora biti  broj&#269;ana vrednost',
    'error_height_nan' => 'Visina mora biti  broj&#269;ana vrednost',
    'error_border_nan' => 'Okvir mora biti  broj&#269;ana vrednost',
    'error_hspace_nan' => 'Horizontalni razmak  broj&#269;ana vrednost',
    'error_vspace_nan' => 'Vertikalni razmak mora broj&#269;ana vrednost',
  ),
  'inserthorizontalrule' => array(
    'title' => 'Horizontalna crta'
  ),
  'table_create' => array(
    'title' => 'Tabela'
  ),
  'table_prop' => array(
    'title' => 'Naziv tabele',
    'ok' => '   OK   ',
    'cancel' => 'Odustani',
    'rows' => 'redova',
    'columns' => 'kolona',
    'css_class' => 'CSS klasa', // <=== new 1.0.6
    'width' => '&#352;irina',
    'height' => 'Visina',
    'border' => 'Debljina okvira',
    'pixels' => 'pixela',
    'cellpadding' => 'Debljina obloge &#263;elije',
    'cellspacing' => 'Razmak me&#273;u &#263;elijama',
    'background' => 'Pozadinska slika', // <=== new 1.0.6
    'bg_color' => 'Boja pozadine',
    'error' => 'Gre&#353;ka',
    'error_rows_nan' => 'Broj redova mora biti broj&#269;ana vrednost',
    'error_columns_nan' => 'Broj kolona  mora biti broj&#269;ana vrednost',
    'error_width_nan' => '&#352;irina mora biti broj&#269;ana vrednost',
    'error_height_nan' => 'Visina mora biti broj&#269;ana vrednost',
    'error_border_nan' => 'Debljina okvira mora biti broj&#269;ana vrednost',
    'error_cellpadding_nan' => 'Debljina ispune &#263;elije mora biti broj&#269;ana vrednost',
    'error_cellspacing_nan' => 'Razmak me&#273;u &#263;elijama mora biti broj&#269;ana vrednost',
  ),
  'table_cell_prop' => array(
    'title' => 'Osobine &#263;elije',
    'horizontal_align' => 'horizontalno poravnanje',
    'vertical_align' => 'vertikalno poravnanje',
    'width' => '&#352;irina',
    'height' => 'Visina',
    'css_class' => 'CSS klasa',
    'no_wrap' => 'Brez preloma (wrap)',
    'bg_color' => 'Boja pozadine',
    'background' => 'Pozadinska slika', // <=== new 1.0.6
    'ok' => '   OK   ',
    'cancel' => 'Odustani',
    'justifyleft' => 'Levo',
    'justifycenter' => 'Centar',
    'justifyright' => 'Desno',
    'top' => 'Gore',
    'middle' => 'Sredina',
    'bottom' => 'Dole',
    'baseline' => 'Osnovna linija',
    'error' => 'Gre&#353;ka',
    'error_width_nan' => '&#352;irina mora biti broj&#269;ana vrednost',
    'error_height_nan' => 'Visina mora biti broj&#269;ana vrednost',
  ),
  'table_row_insert' => array(
    'title' => 'Unos reda'
  ),
  'table_column_insert' => array(
    'title' => 'Unos kolone'
  ),
  'table_row_delete' => array(
    'title' => 'Brisanje reda'
  ),
  'table_column_delete' => array(
    'title' => 'Brisanje kolone'
  ),
  'table_cell_merge_right' => array(
    'title' => 'Unos na desno'
  ),
  'table_cell_merge_down' => array(
    'title' => 'Unos ispod'
  ),
  'table_cell_split_horizontal' => array(
    'title' => 'Vodoravno podijeli &#263;eliju'
  ),
  'table_cell_split_vertical' => array(
    'title' => 'Okomito podeli &#263;eliju'
  ),
  'style' => array(
    'title' => 'Stil'
  ),
  'fontname' => array(
    'title' => 'Font'
  ),
  'fontsize' => array(
    'title' => 'Veli&#269;ina'
  ),
  'formatBlock' => array(
    'title' => 'Paragraf'
  ),
  'bold' => array(
    'title' => 'Bold'
  ),
  'italic' => array(
    'title' => 'Italic'
  ),
  'underline' => array(
    'title' => 'Podvu&#269;eno'
  ),
  'insertorderedlist' => array(
    'title' => 'Numerisana lista'
  ),
  'insertunorderedlist' => array(
    'title' => 'Lista'
  ),
  'indent' => array(
    'title' => 'Pove&#263;aj uvla&#269;enje'
  ),
  'outdent' => array(
    'title' => 'Smanji uvla&#269;enje'
  ),
  'justifyleft' => array(
    'title' => 'Levo'
  ),
  'justifycenter' => array(
    'title' => 'Centar'
  ),
  'justifyright' => array(
    'title' => 'Desno'
  ),
  'fore_color' => array(
    'title' => 'Boja slova'
  ),
  'bg_color' => array(
    'title' => 'Boja pozadine slova'
  ),
  'design' => array(
    'title' => 'Dizajn'
  ),
  'html' => array(
    'title' => 'HTML kod'
  ),
  'colorpicker' => array(
    'title' => 'Izbor boje',
    'ok' => '   OK   ',
    'cancel' => 'Odustani',
  ),
  'cleanup' => array(
    'title' => '&#268;i&#353;&#269;enje HTML (odstranjivanje stilova)',
    'confirm' => 'Brisanje stilova iz HTML koda. Stilovi su delimi&#269;no ili potpuno izbrisani.',
    'ok' => '   OK   ',
    'cancel' => 'Odustani',
  ),
  'toggle_borders' => array(
    'title' => 'Preklop granica',
  ),
  'hyperlink' => array(
    'title' => 'Link',
    'url' => 'URL ( adresa )',
    'name' => 'Naziv',
    'target' => 'Odredi&#353;te',
    'title_attr' => 'Tekst za prikaz',
    'a_type' => 'Tip', // <=== new 1.0.6
	 'type_link' => 'Link', // <=== new 1.0.6
	 'type_anchor' => 'Lokalni', // <=== new 1.0.6
	 'type_link2anchor' => 'Link ka lokalnom', // <=== new 1.0.6
	 'anchors' => 'Lokalni', // <=== new 1.0.6
      'ok' => '   OK   ',
    'cancel' => 'Odustani',
  ),
  'hyperlink_targets' => array( // <=== new 1.0.5
  	'_self' => 'isti prozor (_self)',
	'_blank' => 'novi prozor (_blank)',
	'_top' => 'gornji okvir (_top)',
	'_parent' => 'roditeljski prozor (_parent)'
  ),
  'table_row_prop' => array(
    'title' => 'Osobine redova',
    'horizontal_align' => 'Horizontalno poravnanje',
    'vertical_align' => 'Vertikalno poravnanje',
    'css_class' => 'CSS klasa',
    'no_wrap' => 'Brez preloma (wrap)',
    'bg_color' => 'Boja pozadine',
    'ok' => '   OK   ',
    'cancel' => 'Odustani',
    'justifyleft' => 'Levo',
    'justifycenter' => 'Centar',
    'justifyright' => 'Desno',
    'top' => 'Gore',
    'middle' => 'Sredina',
    'bottom' => 'Dole',
    'baseline' => 'Osnovna linija',
  ),
  'symbols' => array(
    'title' => 'Simboli',
    'ok' => '   OK   ',
    'cancel' => 'Odustani',
  ),
  'templates' => array(
    'title' => '&#352;abloni',
  ),
  'page_prop' => array(
    'title' => 'Osobine  stranice',
    'title_tag' => 'Naslov',
    'charset' => 'Prikaz slova (charset)',
    'background' => 'Slika u pozadini',
    'bgcolor' => 'Boja pozadine',
    'text' => 'Boja slova teksta',
    'link' => 'Boja linkova',
    'vlink' => 'Boja pose&#263;enog linka',
    'alink' => 'Boja aktivnog linka',
    'leftmargin' => 'Margina levo',
    'topmargin' => 'Margina gore',
    'css_class' => 'CSS klasa',
    'ok' => '   OK   ',
    'cancel' => 'Odustani',
  ),
  'preview' => array(
    'title' => 'Pregled',
  ),
  'image_popup' => array(
    'title' => 'Popup sa slikom',
  ),
  'zoom' => array(
    'title' => 'Pove&#263;aj ( Zoom )',
  ),
  'subscript' => array( // <=== new 1.0.7
    'title' => 'Subskript',
  ),
  'superscript' => array( // <=== new 1.0.7
    'title' => 'Superskript',
  ),
);
?>