<?php 
// ================================================
// SPAW v.2.0
// ================================================
// Romanian language file
// ================================================
// Author: lc
// ------------------------------------------------
//                                www.lcit.ro
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
    'title' => 'Taie'
  ),
  'copy' => array(
    'title' => 'Copiaza'
  ),
  'paste' => array(
    'title' => 'Lipeste'
  ),
  'undo' => array(
    'title' => 'Inapoi'
  ),
  'redo' => array(
    'title' => 'Inainte'
  ),
  'image' => array(
    'title' => 'Inserare rapida imagine'
  ),
  'image_prop' => array(
    'title' => 'Imagine',
    'ok' => '   OK   ',
    'cancel' => 'Renunta',
    'source' => 'Sursa',
    'alt' => 'Text alternativ',
    'align' => 'Aliniere',
    'left' => 'stanga',
    'right' => 'dreapta',
    'top' => 'sus',
    'middle' => 'mijloc',
    'bottom' => 'jos',
    'absmiddle' => 'absolut mijloc',
    'texttop' => 'text sus',
    'baseline' => 'line baza',
    'width' => 'Latime',
    'height' => 'Inaltime',
    'border' => 'Margine',
    'hspace' => 'Oriz. sptiu',
    'vspace' => 'Vert. sptiu',
    'dimensions' => 'Dimensiuni', // <= new in 2.0.1
    'reset_dimensions' => 'Reset dimensiuni', // <= new in 2.0.1
    'title_attr' => 'Titlu', // <= new in 2.0.1
    'constrain_proportions' => 'pastreaza proportiile', // <= new in 2.0.1
    'error' => 'Eroare',
    'error_width_nan' => 'Latime nu e numar',
    'error_height_nan' => 'Inaltime nu e numar',
    'error_border_nan' => 'Margine nu e numar',
    'error_hspace_nan' => 'Spatiu orizontal nu e numar',
    'error_vspace_nan' => 'Spatiu vertical nu e numar',
  ),
  'flash_prop' => array(                // <= new in 2.0
    'title' => 'Flash',
    'ok' => '   OK   ',
    'cancel' => 'Renunta',
    'source' => 'Sursa',
    'width' => 'Latime',
    'height' => 'Inaltime',
    'error' => 'Eroare',
    'error_width_nan' => 'Latime nu e numar',
    'error_height_nan' => 'Inaltime nu e numar',
  ),
  'inserthorizontalrule' => array( // <== v.2.0 changed from hr
    'title' => 'Linie orizontala rule'
  ),
  'table_create' => array(
    'title' => 'Create table'
  ),
  'table_prop' => array(
    'title' => 'Proprietati tabla',
    'ok' => '   OK   ',
    'cancel' => 'Renunta',
    'rows' => 'Randuri',
    'columns' => 'Coloane',
    'css_class' => 'clasa CSS',
    'width' => 'Latime',
    'height' => 'Inaltime',
    'border' => 'Margine',
    'pixels' => 'pixeli',
    'cellpadding' => 'Margine in celula',
    'cellspacing' => 'Margini intre celule',
    'bg_color' => 'Culoare fond',
    'background' => 'Imagine fond',
    'error' => 'Eroare',
    'error_rows_nan' => 'Rand nu e numar',
    'error_columns_nan' => 'Coloana nu e numar',
    'error_width_nan' => 'Latime nu e numar',
    'error_height_nan' => 'Inaltime nu e numar',
    'error_border_nan' => 'Margine nu e numar',
    'error_cellpadding_nan' => 'Margine in celula nu e numar',
    'error_cellspacing_nan' => 'Margini intre celule nu e numar',
  ),
  'table_cell_prop' => array(
    'title' => 'Proprietati celula',
    'horizontal_align' => 'Aliniere orizontala',
    'vertical_align' => 'Aliniere verticala',
    'width' => 'Latime',
    'height' => 'Inaltime',
    'css_class' => 'clasa CSS',
    'no_wrap' => 'Nu rupe randul',
    'bg_color' => 'Culoare fond',
    'background' => 'Imagine fond',
    'ok' => '   OK   ',
    'cancel' => 'Renunta',
    'left' => 'Stanga',
    'center' => 'Centru',
    'right' => 'Dreapta',
    'top' => 'Sus',
    'middle' => 'Mijloc',
    'bottom' => 'Jos',
    'baseline' => 'Linie baza',
    'error' => 'Eroare',
    'error_width_nan' => 'Latime nu e numar',
    'error_height_nan' => 'Inaltime nu e numar',
  ),
  'table_row_insert' => array(
    'title' => 'Insereaza rand'
  ),
  'table_column_insert' => array(
    'title' => 'Insereaza coloana'
  ),
  'table_row_delete' => array(
    'title' => 'Sterge rand'
  ),
  'table_column_delete' => array(
    'title' => 'Sterge coloana'
  ),
  'table_cell_merge_right' => array(
    'title' => 'Uneste dreapta'
  ),
  'table_cell_merge_down' => array(
    'title' => 'Uneste jos'
  ),
  'table_cell_split_horizontal' => array(
    'title' => 'Sparge celule orizontal'
  ),
  'table_cell_split_vertical' => array(
    'title' => 'Sparge celula vertical'
  ),
  'style' => array(
    'title' => 'Stil'
  ),
  'fontname' => array( // <== v.2.0 changed from font
    'title' => 'Font'
  ),
  'fontsize' => array(
    'title' => 'Marime'
  ),
  'formatBlock' => array( // <= v.2.0: changed from paragraph
    'title' => 'Paragraf'
  ),
  'bold' => array(
    'title' => 'Apasat'
  ),
  'italic' => array(
    'title' => 'Italic'
  ),
  'underline' => array(
    'title' => 'Subliniat'
  ),
  'strikethrough' => array(
    'title' => 'Taiat peste'
  ),
  'insertorderedlist' => array( // <== v.2.0 changed from ordered_list
    'title' => 'Lista numerotata'
  ),
  'insertunorderedlist' => array( // <== v.2.0 changed from bulleted list
    'title' => 'Lista cu buine'
  ),
  'indent' => array(
    'title' => 'Muta in dreapta'
  ),
  'outdent' => array( // <== v.2.0 changed from unindent
    'title' => 'Muta in stanga'
  ),
  'justifyleft' => array( // <== v.2.0 changed from left
    'title' => 'Stanga'
  ),
  'justifycenter' => array( // <== v.2.0 changed from center
    'title' => 'Centru'
  ),
  'justifyright' => array( // <== v.2.0 changed from right
    'title' => 'Dreapta'
  ),
  'justifyfull' => array( // <== v.2.0 changed from justify
    'title' => 'Umple randul'
  ),
  'fore_color' => array(
    'title' => 'Culaore scris'
  ),
  'bg_color' => array(
    'title' => 'Culoare fond'
  ),
  'design' => array( // <== v.2.0 changed from design_tab
    'title' => 'Schimba in mod Vad Ceea Ce Scriu (WYSIWYG)'
  ),
  'html' => array( // <== v.2.0 changed from html_tab
    'title' => 'Schimba in cod sursa (HTML)'
  ),
  'colorpicker' => array(
    'title' => 'Aleg culoare',
    'ok' => '   OK   ',
    'cancel' => 'Renunta',
  ),
  'cleanup' => array(
    'title' => 'Curata codul (sterge toate stilurile aplicate)',
    'confirm' => 'Curatand codurile vor fi sterse toate stilurile, fonturile exceptie tag-urile din continutul pagini curente. Parte din sau toate formatarile vor fi pierdute. NU vei sterge continutul',
    'ok' => '   OK   ',
    'cancel' => 'Renunta',
  ),
  'toggle_borders' => array(
    'title' => 'Ascunde Arata marginile',
  ),
  'hyperlink' => array(
    'title' => 'Legaturi',
    'url' => 'URL',
    'name' => 'Nume',
    'target' => 'Tinta',
    'title_attr' => 'Titlu',
  	'a_type' => 'Tip',
  	'type_link' => 'Legatura externa',
  	'type_anchor' => 'Semn',
  	'type_link2anchor' => 'Legatura la semn',
  	'anchors' => 'Semne',
    'ok' => '   OK   ',
    'cancel' => 'Renunt',
  ),
  'hyperlink_targets' => array(
  	'_self' => 'acelasi cadru (_self)',
  	'_blank' => 'in alta fereastra (_blank)',
  	'_top' => 'cadrul de sus (_top)',
  	'_parent' => 'cadru parinte (_parent)'
  ),
  'unlink' => array( // <=== new v.2.0
    'title' => 'Sterge legatura'
  ),
  'table_row_prop' => array(
    'title' => 'Proprietati rand',
    'horizontal_align' => 'Aliniere pe orizontala',
    'vertical_align' => 'Aliniere pe verticala',
    'css_class' => 'clasa CSS',
    'no_wrap' => 'Nu rupe randul',
    'bg_color' => 'Culoare fond',
    'ok' => '   OK   ',
    'cancel' => 'Renunta',
    'left' => 'Stanga',
    'center' => 'Centru',
    'right' => 'Dreapta',
    'top' => 'Sus',
    'middle' => 'Mijloc',
    'bottom' => 'Jos',
    'baseline' => 'Linie baza',
  ),
  'symbols' => array(
    'title' => 'Caractere Speciale',
    'ok' => '   OK   ',
    'cancel' => 'Renunta',
  ),
  'templates' => array(
    'title' => 'Modele',
  ),
  'page_prop' => array(
    'title' => 'Proprietati pagina',
    'title_tag' => 'Titlu',
    'charset' => 'Set caractere',
    'background' => 'Imagine fond',
    'bgcolor' => 'Culoare fond',
    'text' => 'Culoare texte',
    'link' => 'Culoare legatura',
    'vlink' => 'Culoare legatura vizitata',
    'alink' => 'Culoare legatura activa',
    'leftmargin' => 'Margine stanga',
    'topmargin' => 'Margine sus',
    'css_class' => 'clasa CSS',
    'ok' => '   OK   ',
    'cancel' => 'Renunta',
  ),
  'preview' => array(
    'title' => 'Previzualizare',
  ),
  'image_popup' => array(
    'title' => 'Imagine care apare in fata',
  ),
  'zoom' => array(
    'title' => 'Mareste Micsoreaza',
  ),
  'subscript' => array(
    'title' => 'Scris mic jos',
  ),
  'superscript' => array(
    'title' => 'Scris mic sus',
  ),
);
?>