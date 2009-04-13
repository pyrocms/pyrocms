<?php 
// ================================================
// SPAW v.2.0
// ================================================
//
//
// Arabic language file
// Traslated: Mohammed Ahmed
// Gaza, Palestine
// http://www.maaking.com
// Email/MSN: m@maaking.com
//
// last update: 18-oct-2007
//
// ================================================
// Author: Alan Mendelevich, UAB Solmetra
// ------------------------------------------------
// www.solmetra.com
// ================================================
// v.2.0
// ================================================

// charset to be used in dialogs
$spaw_lang_charset = 'windows-1256';


// text direction for the language
$spaw_lang_direction = 'rtl';

// language text data array
// first dimension - block, second - exact phrase
// alternative text for toolbar buttons and title for dropdowns - 'title'

$spaw_lang_data = array(
  'cut' => array(
    'title' => 'ŞÕ'
  ),
  'copy' => array(
    'title' => 'äÓÎ'
  ),
  'paste' => array(
    'title' => 'áÕŞ'
  ),
  'undo' => array(
    'title' => 'ÊÑÇÌÚ'
  ),
  'redo' => array(
    'title' => 'ÅÚÇÏÉ ÇáÊÑÇÌÚ'
  ),
  'image' => array(
    'title' => 'ÅÏÑÇÌ ÕæÑÉ'
  ),
  'image_prop' => array(
    'title' => 'ÕæÑÉ',
    'ok' => '   ãæÇİŞ   ',
    'cancel' => 'ÅáÛÇÁ',
    'source' => 'ÇáãÕÏÑ',
    'alt' => 'äÕ ÈÏíá',
    'align' => 'ÇáãÍÇĞÇå',
    'left' => 'íÓÇÑ',
    'right' => 'íãíä',
    'top' => 'ÃÚáì',
    'middle' => 'æÓØ',
    'bottom' => 'ÃÓİá',
    'absmiddle' => 'äÕ İí ÇáãäÊÕİ',
    'texttop' => 'äÕ İí ÇáÃÚáì',
    'baseline' => 'ÎØ ÃÓÇÓí',
    'width' => 'ÇáÚÑÖ',
    'height' => 'ÇáÅÑÊİÇÚ',
    'border' => 'ÇáÍÏ',
    'hspace' => 'ãÓÇİÉ ÃİŞíÉ',
    'vspace' => 'ãÓÇİÉ ÚãæÏíÉ',
    'dimensions' => 'ÇáÃÈÚÇÏ', // <= new in 2.0.1
    'reset_dimensions' => 'ÅÚÇÏÉ ÖÈØ ÇáÃÈÚÇÏ', // <= new in 2.0.1
    'title_attr' => 'ÇáÚäæÇä', // <= new in 2.0.1
    'constrain_proportions' => 'ÎíÇÑÇÊ ãŞíÏÉ', // <= new in 2.0.1
    'error' => 'ÎØÃ',
    'error_width_nan' => 'ÇáÚÑÖ áíÓ ÑŞã',
    'error_height_nan' => 'ÇáÅÑÊİÇÚ áíÓ ÑŞã',
    'error_border_nan' => 'ÇáÍÏ áíÓ ÑŞã',
    'error_hspace_nan' => 'ÇáŞíãÉ ÇáãÏÎáÉ áíÓ ÑŞã',
    'error_vspace_nan' => 'ÇáŞíãÉ ÇáãÏÎáÉ áíÓ ÑŞã',
  ),
  'flash_prop' => array(                // <= new in 2.0
    'title' => 'İáÇÔ',
    'ok' => '   ãæÇİŞ   ',
    'cancel' => 'ÅáİÇÁ',
    'source' => 'ÇáãÕÏÑ',
    'width' => 'ÇáÚÑÖ',
    'height' => 'ÇáÅÑÊİÇÚ',
    'error' => 'ÎØÃ',
    'error_width_nan' => 'ÇáŞíãÉ ÇáãÏÎáÉ áíÓ ÑŞã',
    'error_height_nan' => 'ÇáŞíãÉ ÇáãÏÎáÉ áíÓ ÑŞã',
  ),
  'inserthorizontalrule' => array( // <== v.2.0 changed from hr
    'title' => 'ÅÏÑÇÌ ÎØ ÃİŞí'
  ),
  'table_create' => array(
    'title' => 'ÅäÔÇÁ ÌÏæá'
  ),
  'table_prop' => array(
    'title' => 'ÎÕÇÆÕ ÇáÌÏæá',
    'ok' => '   ãæÇİŞ   ',
    'cancel' => 'ÅáÛÇÁ',
    'rows' => 'ÇáÕİæİ',
    'columns' => 'ÇáÃÚãÏÉ',
    'css_class' => 'CSS ÊäÓíŞ',
    'width' => 'ÇáÚÑÖ',
    'height' => 'ÇáÅÑÊİÇÚ',
    'border' => 'ÇáÍÏ',
    'pixels' => 'ÈßÓá',
    'cellpadding' => 'äØÇŞ ÇáÎáíÉ',
    'cellspacing' => 'ÇáãÓÇİÉ Èíä ÇáÎáÇíÇ',
    'bg_color' => 'áæä ÇáÎáİíÉ',
    'background' => 'ÕæÑÉ ááÎáİíÉ',
    'error' => 'ÎØÃ',
    'error_rows_nan' => 'ÇáŞíãÉ ÇáãÏÎáÉ áíÓ ÑŞã',
    'error_columns_nan' => 'ÇáŞíãÉ ÇáãÏÎáÉ áíÓ ÑŞã',
    'error_width_nan' => 'ÇáŞíãÉ ÇáãÏÎáÉ áíÓ ÑŞã',
    'error_height_nan' => 'ÇáŞíãÉ ÇáãÏÎáÉ áíÓ ÑŞã',
    'error_border_nan' => 'ÇáŞíãÉ ÇáãÏÎáÉ áíÓ ÑŞã',
    'error_cellpadding_nan' => 'ÇáŞíãÉ ÇáãÏÎáÉ áíÓ ÑŞã',
    'error_cellspacing_nan' => 'ÇáŞíãÉ ÇáãÏÎáÉ áíÓ ÑŞã',
  ),
  'table_cell_prop' => array(
    'title' => 'ÎÕÇÆÕ ÇáÎáíÉ',
    'horizontal_align' => 'ãÍÇĞÇÉ ÃİŞíÉ',
    'vertical_align' => 'ãÍÇĞÇÉ ÚãæÏíÉ',
    'width' => 'ÇáÚÑÖ',
    'height' => 'ÇáÇÑÊİÇÚ',
    'css_class' => 'CSS äãØ',
    'no_wrap' => 'ÈáÇ áİ',
    'bg_color' => 'áæä ÇáÎáİíÉ',
    'background' => 'ÕæÑÉ ÇáÎáİíÉ',
    'ok' => '   ãæÇİŞ   ',
    'cancel' => 'ÅáÛÇÁ',
    'left' => 'íÓÇÑ',
    'center' => 'æÓØ',
    'right' => 'íãíä',
    'top' => 'ÃÚáì',
    'middle' => 'æÓØ',
    'bottom' => 'ÃÓİá',
    'baseline' => 'ÎØ ÃÓÇÓí',
    'error' => 'ÎØÃ',
    'error_width_nan' => 'ÇáŞíãÉ ÇáãÏÎáÉ áíÓ ÑŞã',
    'error_height_nan' => 'ÇáŞíãÉ ÇáãÏÎáÉ áíÓ ÑŞã',
  ),
  'table_row_insert' => array(
    'title' => 'ÅÏÑÇÌ Õİ'
  ),
  'table_column_insert' => array(
    'title' => 'ÅÏÇÑÌ ÚãæÏ'
  ),
  'table_row_delete' => array(
    'title' => 'ÍĞİ Õİ'
  ),
  'table_column_delete' => array(
    'title' => 'ÍĞİ ÚãæÏ'
  ),
  'table_cell_merge_right' => array(
    'title' => 'ÏãÌ Åáì Çáíãíä'
  ),
  'table_cell_merge_down' => array(
    'title' => 'ÏãÌ Åáì ÇáÃÓİá'
  ),
  'table_cell_split_horizontal' => array(
    'title' => 'ŞÓã ÇáÎáÇíÇ ÈÔßá ÃİŞí'
  ),
  'table_cell_split_vertical' => array(
    'title' => 'ÊŞÓíã ÇáÎáÇíÇ ÈÔßá ÚãæÏí'
  ),
  'style' => array(
    'title' => 'ÇáäãØ'
  ),
  'fontname' => array( // <== v.2.0 changed from font
    'title' => 'ÇáÎØ'
  ),
  'fontsize' => array(
    'title' => 'ÇáÍÌã'
  ),
  'formatBlock' => array( // <= v.2.0: changed from paragraph
    'title' => 'ÇáİŞÑÉ'
  ),
  'bold' => array(
    'title' => 'ÚÑíÖ'
  ),
  'italic' => array(
    'title' => 'ãÇÆá'
  ),
  'underline' => array(
    'title' => 'ÊÍÊå ÎØ'
  ),
  'strikethrough' => array(
    'title' => 'æÓØå ÎØ'
  ),
  'insertorderedlist' => array( // <== v.2.0 changed from ordered_list
    'title' => 'äÚÏÇÏ ÑŞãí'
  ),
  'insertunorderedlist' => array( // <== v.2.0 changed from bulleted list
    'title' => 'ÊÚÏÇÏ äŞØí'
  ),
  'indent' => array(
    'title' => 'ÒíÇÏÉ ÇáãÓÇİÉ ÇáÈÇÏÆÉ'
  ),
  'outdent' => array( // <== v.2.0 changed from unindent
    'title' => 'ÇäŞÇÕ ÇáãÓÇİÉ ÇáÈÇÏÆÉ'
  ),
  'justifyleft' => array( // <== v.2.0 changed from left
    'title' => 'íÓÇÑ'
  ),
  'justifycenter' => array( // <== v.2.0 changed from center
    'title' => 'ÊæÓíØ'
  ),
  'justifyright' => array( // <== v.2.0 changed from right
    'title' => 'íãíä'
  ),
  'justifyfull' => array( // <== v.2.0 changed from justify
    'title' => 'ÖÈØ'
  ),
  'fore_color' => array(
    'title' => 'áæä ÇáÎØ'
  ),
  'bg_color' => array(
    'title' => 'áæä ÎáİíÉ ÇáÎØ'
  ),
  'design' => array( // <== v.2.0 changed from design_tab
    'title' => 'æÖÚ ÇáÊäÓíŞ'
  ),
  'html' => array( // <== v.2.0 changed from html_tab
    'title' => 'ÚÑÖ ÇáãÕÏÑ'
  ),
  'colorpicker' => array(
    'title' => 'ÇäÊŞÇÁ áæä',
    'ok' => '   ãæÇİŞ   ',
    'cancel' => 'ÅáÛÇÁ',
  ),
  'cleanup' => array(
    'title' => 'ãÓÍ ßÇİÉ ÇáÊäÓíŞÇÊ',
    'confirm' => ' ÊäİíĞ åĞÇ ÇáÃãÑ ÓíãÓÍ ßÇİÉ ÇáÊäÓíŞÇÊ ÇáÊí ŞãÊ ÈÚãáåÇ. ',
    'ok' => '   ãæÇİŞ   ',
    'cancel' => 'ÅáÛÇÁ',
  ),
  'toggle_borders' => array(
    'title' => 'ÒíÇÏÉ ÇáÍÏæÏ',
  ),
  'hyperlink' => array(
    'title' => 'ÑÇÈØ ÊÔÚÈí',
    'url' => 'ÇáÇÑÈØ URL',
    'name' => 'ÇÓã',
    'target' => 'ÇáÅØÇÑ ÇáåÏİ',
    'title_attr' => 'ÇáÚäæÇä',
  	'a_type' => 'ÇáäæÚ',
  	'type_link' => 'ÇáÑÇÈØ',
  	'type_anchor' => 'æÕáÉ',
  	'type_link2anchor' => 'ÑÈØ Çáì æÕáÉ',
  	'anchors' => 'æÕáÇÊ',
    'ok' => '   ãæÇİŞ   ',
    'cancel' => 'ÅáÛÇÁ',
  ),
  'hyperlink_targets' => array(
  	'_self' => 'äİÓ ÇáÇØÇÑ (_self)',
  	'_blank' => 'ÕİÍÉ ÌÏíÏÉ (_blank)',
  	'_top' => 'ÇØÇÑ ÇáÚáæí (_top)',
  	'_parent' => 'ÇáÃÈ (_parent)'
  ),
  'unlink' => array( // <=== new v.2.0
    'title' => 'ÅÒÇáÉ ÇáÑÇÈØ ÇáÊÔÚÈí'
  ),
  'table_row_prop' => array(
    'title' => 'ÎÕÇÆÕ ÇáÕİ',
    'horizontal_align' => 'ãÍÇĞÇÉ ÃİŞíÉ',
    'vertical_align' => 'ãÍÇĞÇÉ ÚãæÏíÉ',
    'css_class' => 'CSS äãØ',
    'no_wrap' => 'ÈáÇ áİ',
    'bg_color' => 'áæä ÇáÎáİíÉ',
    'ok' => '   ãæÇİŞ   ',
    'cancel' => 'ÇáÛÇÁ',
    'left' => 'íÓÇÑ',
    'center' => 'æÓØ',
    'right' => 'íãíä',
    'top' => 'ÃÚáì',
    'middle' => 'æÓØ',
    'bottom' => 'ÃÓİá',
    'baseline' => 'ÎØ ÃÓÇÓí',
  ),
  'symbols' => array(
    'title' => 'ÃÍÑİ ÎÇÕÉ',
    'ok' => '   ãæÇİŞ   ',
    'cancel' => 'ÅáÛÇÁ',
  ),
  'templates' => array(
    'title' => 'ŞæÇáÈ',
  ),
  'page_prop' => array(
    'title' => 'ÎÕÇÆÕ ÇáÕİÍÉ',
    'title_tag' => 'ÇáÚäæÇä',
    'charset' => 'ÇáÊÑãíÒ',
    'background' => 'ÕæÑÉ ÇáÎáİíÉ',
    'bgcolor' => 'áæä ÇáÎáİíÉ',
    'text' => 'áæä ÇáäÕ',
    'link' => 'áæä ÇáÑÇÈØ',
    'vlink' => 'áæä ÇáÑÇÈØ Êã ÒíÇÑÊå',
    'alink' => 'áæä ÇáÑÇÈØ ÇáÍí',
    'leftmargin' => 'ÇáÍÏ ÇáÃíÓÑ',
    'topmargin' => 'ÇáÍÏ ÇáÚáæí',
    'css_class' => 'CSS ÊäÓíŞ',
    'ok' => '   ãæÇİŞ   ',
    'cancel' => 'ÅáÛÇÁ',
  ),
  'preview' => array(
    'title' => 'ãÚÇíäÉ',
  ),
  'image_popup' => array(
    'title' => 'ÕæÑÉ İí äÇİĞÉ',
  ),
  'zoom' => array(
    'title' => 'ÊßÈíÑ',
  ),
  'subscript' => array(
    'title' => 'äÕ Óİáí',
  ),
  'superscript' => array(
    'title' => 'äÕ Úáæí',
  ),
);
?>
