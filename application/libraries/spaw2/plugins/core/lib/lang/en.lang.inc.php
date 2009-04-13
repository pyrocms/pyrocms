<?php 
// ================================================
// SPAW v.2.0
// ================================================
// English language file
// ================================================
// Author: Alan Mendelevich, UAB Solmetra
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
    'title' => 'Cut'
  ),
  'copy' => array(
    'title' => 'Copy'
  ),
  'paste' => array(
    'title' => 'Paste'
  ),
  'undo' => array(
    'title' => 'Undo'
  ),
  'redo' => array(
    'title' => 'Redo'
  ),
  'image' => array(
    'title' => 'Quick insert image'
  ),
  'image_prop' => array(
    'title' => 'Image',
    'ok' => '   OK   ',
    'cancel' => 'Cancel',
    'source' => 'Source',
    'alt' => 'Alternative text',
    'align' => 'Align',
    'left' => 'left',
    'right' => 'right',
    'top' => 'top',
    'middle' => 'middle',
    'bottom' => 'bottom',
    'absmiddle' => 'absmiddle',
    'texttop' => 'texttop',
    'baseline' => 'baseline',
    'width' => 'Width',
    'height' => 'Height',
    'border' => 'Border',
    'hspace' => 'Hor. space',
    'vspace' => 'Vert. space',
    'dimensions' => 'Dimensions', // <= new in 2.0.1
    'reset_dimensions' => 'Reset dimensions', // <= new in 2.0.1
    'title_attr' => 'Title', // <= new in 2.0.1
    'constrain_proportions' => 'constrain proportions', // <= new in 2.0.1
    'css_class' => 'CSS class', // <= new in 2.0.6
    'error' => 'Error',
    'error_width_nan' => 'Width is not a number',
    'error_height_nan' => 'Height is not a number',
    'error_border_nan' => 'Border is not a number',
    'error_hspace_nan' => 'Horizontal space is not a number',
    'error_vspace_nan' => 'Vertical space is not a number',
  ),
  'flash_prop' => array(                // <= new in 2.0
    'title' => 'Flash',
    'ok' => '   OK   ',
    'cancel' => 'Cancel',
    'source' => 'Source',
    'width' => 'Width',
    'height' => 'Height',
    'error' => 'Error',
    'error_width_nan' => 'Width is not a number',
    'error_height_nan' => 'Height is not a number',
  ),
  'inserthorizontalrule' => array( // <== v.2.0 changed from hr
    'title' => 'Horizontal rule'
  ),
  'table_create' => array(
    'title' => 'Create table'
  ),
  'table_prop' => array(
    'title' => 'Table properties',
    'ok' => '   OK   ',
    'cancel' => 'Cancel',
    'rows' => 'Rows',
    'columns' => 'Columns',
    'css_class' => 'CSS class',
    'width' => 'Width',
    'height' => 'Height',
    'border' => 'Border',
    'pixels' => 'pixels',
    'cellpadding' => 'Cell padding',
    'cellspacing' => 'Cell spacing',
    'bg_color' => 'Background color',
    'background' => 'Background image',
    'error' => 'Error',
    'error_rows_nan' => 'Rows is not a number',
    'error_columns_nan' => 'Columns is not a number',
    'error_width_nan' => 'Width is not a number',
    'error_height_nan' => 'Height is not a number',
    'error_border_nan' => 'Border is not a number',
    'error_cellpadding_nan' => 'Cell padding is not a number',
    'error_cellspacing_nan' => 'Cell spacing is not a number',
  ),
  'table_cell_prop' => array(
    'title' => 'Cell properties',
    'horizontal_align' => 'Horizontal align',
    'vertical_align' => 'Vertical align',
    'width' => 'Width',
    'height' => 'Height',
    'css_class' => 'CSS class',
    'no_wrap' => 'No wrap',
    'bg_color' => 'Background color',
    'background' => 'Background image',
    'ok' => '   OK   ',
    'cancel' => 'Cancel',
    'left' => 'Left',
    'center' => 'Center',
    'right' => 'Right',
    'top' => 'Top',
    'middle' => 'Middle',
    'bottom' => 'Bottom',
    'baseline' => 'Baseline',
    'error' => 'Error',
    'error_width_nan' => 'Width is not a number',
    'error_height_nan' => 'Height is not a number',
  ),
  'table_row_insert' => array(
    'title' => 'Insert row'
  ),
  'table_column_insert' => array(
    'title' => 'Insert column'
  ),
  'table_row_delete' => array(
    'title' => 'Delete row'
  ),
  'table_column_delete' => array(
    'title' => 'Delete column'
  ),
  'table_cell_merge_right' => array(
    'title' => 'Merge right'
  ),
  'table_cell_merge_down' => array(
    'title' => 'Merge down'
  ),
  'table_cell_split_horizontal' => array(
    'title' => 'Split cell horizontally'
  ),
  'table_cell_split_vertical' => array(
    'title' => 'Split cell vertically'
  ),
  'style' => array(
    'title' => 'Style'
  ),
  'fontname' => array( // <== v.2.0 changed from font
    'title' => 'Font'
  ),
  'fontsize' => array(
    'title' => 'Size'
  ),
  'formatBlock' => array( // <= v.2.0: changed from paragraph
    'title' => 'Paragraph'
  ),
  'bold' => array(
    'title' => 'Bold'
  ),
  'italic' => array(
    'title' => 'Italic'
  ),
  'underline' => array(
    'title' => 'Underline'
  ),
  'strikethrough' => array(
    'title' => 'Strikethrough'
  ),
  'insertorderedlist' => array( // <== v.2.0 changed from ordered_list
    'title' => 'Ordered list'
  ),
  'insertunorderedlist' => array( // <== v.2.0 changed from bulleted list
    'title' => 'Bulleted list'
  ),
  'indent' => array(
    'title' => 'Indent'
  ),
  'outdent' => array( // <== v.2.0 changed from unindent
    'title' => 'Unindent'
  ),
  'justifyleft' => array( // <== v.2.0 changed from left
    'title' => 'Left'
  ),
  'justifycenter' => array( // <== v.2.0 changed from center
    'title' => 'Center'
  ),
  'justifyright' => array( // <== v.2.0 changed from right
    'title' => 'Right'
  ),
  'justifyfull' => array( // <== v.2.0 changed from justify
    'title' => 'Justify'
  ),
  'fore_color' => array(
    'title' => 'Fore color'
  ),
  'bg_color' => array(
    'title' => 'Background color'
  ),
  'design' => array( // <== v.2.0 changed from design_tab
    'title' => 'Switch to WYSIWYG (design) mode'
  ),
  'html' => array( // <== v.2.0 changed from html_tab
    'title' => 'Switch to HTML (code) mode'
  ),
  'colorpicker' => array(
    'title' => 'Color picker',
    'ok' => '   OK   ',
    'cancel' => 'Cancel',
  ),
  'cleanup' => array(
    'title' => 'HTML cleanup (remove styles)',
    'confirm' => 'Performing this action will remove all styles, fonts and useless tags from the current content. Some or all your formatting may be lost.',
    'ok' => '   OK   ',
    'cancel' => 'Cancel',
  ),
  'toggle_borders' => array(
    'title' => 'Toggle borders',
  ),
  'hyperlink' => array(
    'title' => 'Hyperlink',
    'url' => 'URL',
    'name' => 'Name',
    'target' => 'Target',
    'title_attr' => 'Title',
  	'a_type' => 'Type',
  	'type_link' => 'Link',
  	'type_anchor' => 'Anchor',
  	'type_link2anchor' => 'Link to anchor',
  	'anchors' => 'Anchors',
  	'quick_links' => "Quick links", // <=== new in 2.0.6
    'ok' => '   OK   ',
    'cancel' => 'Cancel',
  ),
  'hyperlink_targets' => array(
  	'_self' => 'same frame (_self)',
  	'_blank' => 'new empty window (_blank)',
  	'_top' => 'top frame (_top)',
  	'_parent' => 'parent frame (_parent)'
  ),
  'unlink' => array( // <=== new v.2.0
    'title' => 'Remove hyperlink'
  ),
  'table_row_prop' => array(
    'title' => 'Row properties',
    'horizontal_align' => 'Horizontal align',
    'vertical_align' => 'Vertical align',
    'css_class' => 'CSS class',
    'no_wrap' => 'No wrap',
    'bg_color' => 'Background color',
    'ok' => '   OK   ',
    'cancel' => 'Cancel',
    'left' => 'Left',
    'center' => 'Center',
    'right' => 'Right',
    'top' => 'Top',
    'middle' => 'Middle',
    'bottom' => 'Bottom',
    'baseline' => 'Baseline',
  ),
  'symbols' => array(
    'title' => 'Special characters',
    'ok' => '   OK   ',
    'cancel' => 'Cancel',
  ),
  'templates' => array(
    'title' => 'Templates',
  ),
  'page_prop' => array(
    'title' => 'Page properties',
    'title_tag' => 'Title',
    'charset' => 'Charset',
    'background' => 'Background image',
    'bgcolor' => 'Background color',
    'text' => 'Text color',
    'link' => 'Link color',
    'vlink' => 'Visited link color',
    'alink' => 'Active link color',
    'leftmargin' => 'Left margin',
    'topmargin' => 'Top margin',
    'css_class' => 'CSS class',
    'ok' => '   OK   ',
    'cancel' => 'Cancel',
  ),
  'preview' => array(
    'title' => 'Preview',
  ),
  'image_popup' => array(
    'title' => 'Image popup',
  ),
  'zoom' => array(
    'title' => 'Zoom',
  ),
  'subscript' => array(
    'title' => 'Subscript',
  ),
  'superscript' => array(
    'title' => 'Superscript',
  ),
);
?>