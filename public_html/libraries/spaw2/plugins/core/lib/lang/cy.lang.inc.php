<?php 
// ================================================
// SPAW v.2.0
// ================================================
// Welsh language file
// ================================================
// Author: Alan Mendelevich, UAB Solmetra
// ------------------------------------------------
//                                www.solmetra.com
// ================================================
// v.2.0
// ================================================
// translation: Alan Davies alandavies@cymer.org.uk
// charset to be used in dialogs
$spaw_lang_charset = 'utf-8';

// language text data array
// first dimension - block, second - exact phrase
// alternative text for toolbar buttons and title for dropdowns - 'title'

$spaw_lang_data = array(
  'cut' => array(
    'title' => 'Torri'
  ),
  'copy' => array(
    'title' => 'Cop&iuml;o'
  ),
  'paste' => array(
    'title' => 'Gludo'
  ),
  'undo' => array(
    'title' => 'Dadwneud'
  ),
  'redo' => array(
    'title' => 'Ail-adrodd'
  ),
  'image' => array(
    'title' => 'Llwytho llun yn gyflym'
  ),
  'image_prop' => array(
    'title' => 'Llun',
    'ok' => '  Iawn  ',
    'cancel' => 'Canslo',
    'source' => 'Ffynhonnell',
    'alt' => 'Disgrifiad byr',
    'align' => 'Gosod',
    'left' => 'chwith',
    'right' => 'dde',
    'top' => 'top',
    'middle' => 'canol',
    'bottom' => 'gwaelod',
    'absmiddle' => 'abs-canol',
    'texttop' => 'top-testun',
    'baseline' => 'baslinell',
    'width' => 'Lled',
    'height' => 'Uchder',
    'border' => 'Ymyl',
    'hspace' => 'Bwlch llor.',
    'vspace' => 'Bwlch fert.',
    'dimensions' => 'Dimensiynau', // <= new in 2.0.1
    'reset_dimensions' => 'Ail-osod dimensiynau', // <= new in 2.0.1
    'title_attr' => 'Teitl', // <= new in 2.0.1
    'constrain_proportions' => 'cadw cyfrannedd', // <= new in 2.0.1
    'error' => 'Gwall',
    'error_width_nan' => 'Lled ddim yn rhif',
    'error_height_nan' => 'Uchder ddim yn rhif',
    'error_border_nan' => 'Ymyl ddim yn rhif',
    'error_hspace_nan' => 'Bwlch llorweddol ddim yn rhif',
    'error_vspace_nan' => 'Bwlch fertigolis ddim yn rhif',
  ),
  'flash_prop' => array(                // <= new in 2.0
    'title' => 'Flash',
    'ok' => '  Iawn  ',
    'cancel' => 'Canslo',
    'source' => 'Ffynhonnell',
    'width' => 'Lled',
    'height' => 'Uchder',
    'error' => 'Gwall',
    'error_width_nan' => 'Lled ddim yn rhif',
    'error_height_nan' => 'Uchder ddim yn rhif',
  ),
  'inserthorizontalrule' => array( // <== v.2.0 changed from hr
    'title' => 'Riwl llorweddol'
  ),
  'table_create' => array(
    'title' => 'Creu tabl'
  ),
  'table_prop' => array(
    'title' => 'Priodweddau tabl',
    'ok' => '  Iawn  ',
    'cancel' => 'Canslo',
    'rows' => 'Rhesi',
    'columns' => 'Colofnau',
    'css_class' => 'Dosbarth CSS',
    'width' => 'Lled',
    'height' => 'Uchder',
    'border' => 'Ymyl',
    'pixels' => 'picsel',
    'cellpadding' => 'Padio cell',
    'cellspacing' => 'Bylchiad cell',
    'bg_color' => 'Lliw cefndir',
    'background' => 'Delwedd cefndir',
    'error' => 'Gwall',
    'error_rows_nan' => 'Rhesi ddim yn rhif',
    'error_columns_nan' => 'Colofnau ddim yn rhif',
    'error_width_nan' => 'Lled ddim yn rhif',
    'error_height_nan' => 'Uchder ddim yn rhif',
    'error_border_nan' => 'Ymyl ddim yn rhif',
    'error_cellpadding_nan' => 'Padio cell ddim yn rhif',
    'error_cellspacing_nan' => 'Bylchiad cell ddim yn rhif',
  ),
  'table_cell_prop' => array(
    'title' => 'Priodweddau cell',
    'horizontal_align' => 'Alinio llorweddol',
    'vertical_align' => 'Alinio fertigol',
    'width' => 'Lled',
    'height' => 'Uchder',
    'css_class' => 'Dosbarth CSS',
    'no_wrap' => 'Dim lapio',
    'bg_color' => 'Lliw cefndir',
    'background' => 'Delwedd cefndir',
    'ok' => '  Iawn  ',
    'cancel' => 'Canslo',
    'left' => 'Chwith',
    'center' => 'Canol',
    'right' => 'Dde',
    'top' => 'Brig',
    'middle' => 'Canol',
    'bottom' => 'Gwaelod',
    'baseline' => 'Baslinell',
    'error' => 'Gwall',
    'error_width_nan' => 'Lled ddim yn rhif',
    'error_height_nan' => 'Uchder ddim yn rhif',
  ),
  'table_row_insert' => array(
    'title' => 'Mewnosod rhes'
  ),
  'table_column_insert' => array(
    'title' => 'Mewnosod colofn'
  ),
  'table_row_delete' => array(
    'title' => 'Dileu rhes'
  ),
  'table_column_delete' => array(
    'title' => 'Dileu colofn'
  ),
  'table_cell_merge_right' => array(
    'title' => 'Cyfuno i\'r dde'
  ),
  'table_cell_merge_down' => array(
    'title' => 'Cyfuno i lawr'
  ),
  'table_cell_split_horizontal' => array(
    'title' => 'Hollti cell yn lorweddol'
  ),
  'table_cell_split_vertical' => array(
    'title' => 'Hollti cell yn fertigol'
  ),
  'style' => array(
    'title' => 'Steil'
  ),
  'fontname' => array( // <== v.2.0 changed from font
    'title' => 'Ffont'
  ),
  'fontsize' => array(
    'title' => 'Maint'
  ),
  'formatBlock' => array( // <= v.2.0: changed from paragraph
    'title' => 'Paragraff'
  ),
  'bold' => array(
    'title' => 'Bras'
  ),
  'italic' => array(
    'title' => 'Italig'
  ),
  'underline' => array(
    'title' => 'Tanlinellu'
  ),
  'strikethrough' => array(
    'title' => 'Llinell trwyddo'
  ),
  'insertorderedlist' => array( // <== v.2.0 changed from ordered_list
    'title' => 'Rhestr mewn trefn'
  ),
  'insertunorderedlist' => array( // <== v.2.0 changed from bulleted list
    'title' => 'Rhestr bwled'
  ),
  'indent' => array(
    'title' => 'Tabio'
  ),
  'outdent' => array( // <== v.2.0 changed from unindent
    'title' => 'Dad-tabio'
  ),
  'justifyleft' => array( // <== v.2.0 changed from left
    'title' => 'Chwith'
  ),
  'justifycenter' => array( // <== v.2.0 changed from center
    'title' => 'Canoli'
  ),
  'justifyright' => array( // <== v.2.0 changed from right
    'title' => 'Dde'
  ),
  'justifyfull' => array( // <== v.2.0 changed from justify
    'title' => 'Ochrau syth'
  ),
  'fore_color' => array(
    'title' => 'Lliw'
  ),
  'bg_color' => array(
    'title' => 'Lliw cefndir'
  ),
  'design' => array( // <== v.2.0 changed from design_tab
    'title' => 'Newid i olwg WYSIWYG (dylunio)'
  ),
  'html' => array( // <== v.2.0 changed from html_tab
    'title' => 'Newid i olwg HTML (cod)'
  ),
  'colorpicker' => array(
    'title' => 'Dewisydd lliwiau',
    'ok' => '  Iawn  ',
    'cancel' => 'Canslo',
  ),
  'cleanup' => array(
    'title' => 'Glanhau HTML',
    'confirm' => 'Bydd gwneud hyn yn glanhau eich cod.',
    'ok' => '  Iawn  ',
    'cancel' => 'Canslo',
  ),
  'toggle_borders' => array(
    'title' => 'Togl ymylon',
  ),
  'hyperlink' => array(
    'title' => 'Dolen',
    'url' => 'URL',
    'name' => 'Enw',
    'target' => 'Targed',
    'title_attr' => 'Teitl',
  	'a_type' => 'Teip',
  	'type_link' => 'Linc',
  	'type_anchor' => 'Angor',
  	'type_link2anchor' => 'Cysylltu i angor',
  	'anchors' => 'Angor',
    'ok' => '  Iawn  ',
    'cancel' => 'Canslo',
  ),
  'hyperlink_targets' => array(
  	'_self' => 'r\'un ffr&acirc;m (_self)',
  	'_blank' => 'ffenstr newydd gwag (_blank)',
  	'_top' => 'ffr&acirc;m top (_top)',
  	'_parent' => 'ffr&acirc;m uwch (_parent)'
  ),
  'unlink' => array( // <=== new v.2.0
    'title' => 'Diddymu dolen'
  ),
  'table_row_prop' => array(
    'title' => 'Priodweddau rhes',
    'horizontal_align' => 'Alinio llorweddol',
    'vertical_align' => 'Alinio fertigol',
    'css_class' => 'Dosbarth CSS',
    'no_wrap' => 'Dim lapio',
    'bg_color' => 'Lliw cefndir',
    'ok' => '  Iawn  ',
    'cancel' => 'Canslo',
    'left' => 'Chwith',
    'center' => 'Center',
    'right' => 'Dde',
    'top' => 'Top',
    'middle' => 'Canol',
    'bottom' => 'Gwaelod',
    'baseline' => 'Baslinell',
  ),
  'symbols' => array(
    'title' => 'Cymeriadau arbennig',
    'ok' => '  Iawn  ',
    'cancel' => 'Canslo',
  ),
  'templates' => array(
    'title' => 'Templedau',
  ),
  'page_prop' => array(
    'title' => 'Priodweddau tudalen',
    'title_tag' => 'Teitl',
    'charset' => 'Charset',
    'background' => 'Delwedd cefndir',
    'bgcolor' => 'Lliw cefndir',
    'text' => 'lliw testun',
    'link' => 'Lliw dolen',
    'vlink' => 'Lliw dolen a ymwelwyd',
    'alink' => 'lliw dolen actif',
    'leftmargin' => 'Ffin chwith',
    'topmargin' => 'Ffin top',
    'css_class' => 'Dosbarth CSS',
    'ok' => '  Iawn  ',
    'cancel' => 'Canslo',
  ),
  'preview' => array(
    'title' => 'Rhagolwg',
  ),
  'image_popup' => array(
    'title' => 'Popup delwedd',
  ),
  'zoom' => array(
    'title' => 'Chwyddo',
  ),
  'subscript' => array(
    'title' => 'Is-sgript',
  ),
  'superscript' => array(
    'title' => 'Uwch-sgript',
  ),
);
?>