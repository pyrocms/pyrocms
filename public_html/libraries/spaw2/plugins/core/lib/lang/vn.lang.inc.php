<?php 
// ================================================
// SPAW PHP WYSIWYG editor control
// ================================================
// English language file
// ================================================
// Developed: Alan Mendelevich, alan@solmetra.lt
// Copyright: Solmetra (c)2003 All rights reserved.
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
    'title' => 'C&#7855;t'
  ),
  'copy' => array(
    'title' => 'Sao ch&#233;p'
  ),
  'paste' => array(
    'title' => 'D&#225;n'
  ),
  'undo' => array(
    'title' => 'H&#7911;y thao t&#225;c'
  ),
  'redo' => array(
    'title' => 'L&#224;m l&#7841;i thao t&#225;c'
  ),
  'image_insert' => array(
    'title' => 'Ch&#232;n th&#234;m &#7843;nh',
    'select' => 'Ch&#7885;n',
	'delete' => 'X&#243;a', // new 1.0.5
    'cancel' => 'H&#7911;y b&#7887;',
    'library' => 'Th&#432; vi&#7879;n',
    'preview' => 'Xem tr&#432;&#7899;c',
    'images' => '&#7842;nh',
    'upload' => 'T&#7843;i &#7843;nh l&#234;n',
    'upload_button' => 'T&#7843;i l&#234;n',
    'error' => 'L&#7895;i',
    'error_no_image' => 'H&#227;y ch&#7885;n m&#7897;t &#7843;nh',
    'error_uploading' => 'C&#243; l&#7895;i trong khi qu&#7843;n l&#253; t&#7879;p t&#7843;i l&#234;n.Xin th&#7917; l&#7841;i sau',
    'error_wrong_type' => 'T&#7879;p &#7843;nh kh&#244;ng &#273;&#250;ng ki&#7875;u',
    'error_no_dir' => 'Th&#432; vi&#7879;n kh&#244;ng t&#7891;n t&#7841;i',
	'error_cant_delete' => 'L&#7895;i x&#243;a t&#7879;p', // new 1.0.5
  ),
  'image_prop' => array(
    'title' => 'Thu&#7897;c t&#237;nh &#7843;nh',
    'ok' => '   Ch&#7845;p nh&#7853;n   ',
    'cancel' => 'H&#7911;y b&#7887;',
    'source' => 'Ngu&#7891;n',
    'alt' => 'Ti&#234;u &#273;&#7873; &#7843;nh',
    'align' => 'C&#259;n l&#7873;',
    'justifyleft' => 'tr&#225;i',
    'justifyright' => 'ph&#7843;i',
    'top' => 'tr&#234;n',
    'middle' => 'gi&#7919;a',
    'bottom' => 'd&#432;&#7899;i',
    'absmiddle' => 'ch&#237;nh gi&#7919;a',
    'texttop' => 'ph&#237;a tr&#234;n ch&#7919;',
    'baseline' => 'ph&#237;a tr&#234;n d&#242;ng',
    'width' => 'R&#7897;ng',
    'height' => 'Cao',
    'border' => 'Vi&#7873;n',
    'hspace' => 'kho&#7843;ng tr&#7855;ng ngang',
    'vspace' => 'kho&#7843;ng tr&#7855;ng d&#7885;c',
    'error' => 'L&#7895;i',
    'error_width_nan' => '&#272;&#7897; r&#7897;ng kh&#244;ng ph&#7843;i s&#7889;',
    'error_height_nan' => 'Chi&#7873;u cao kh&#244;ng ph&#7843;i s&#7889;',
    'error_border_nan' => 'Vi&#7873;n kh&#244;ng ph&#7843;i s&#7889;',
    'error_hspace_nan' => 'Kho&#7843;ng tr&#7855;ng ngang kh&#244;ng ph&#7843;i s&#7889;',
    'error_vspace_nan' => 'Kho&#7843;ng tr&#7855;ng d&#7885;c kh&#244;ng ph&#7843;i s&#7889;',
  ),
  'inserthorizontalrule' => array(
    'title' => 'Thanh ngang'
  ),
  'table_create' => array(
    'title' => 'T&#7841;o b&#7843;ng'
  ),
  'table_prop' => array(
    'title' => 'Thu&#7897;c t&#237;nh b&#7843;ng',
    'ok' => '   Ch&#7845;p nh&#7853;n   ',
    'cancel' => 'H&#7911;y b&#7887;',
    'rows' => 'D&#242;ng',
    'columns' => 'C&#7897;t',
    'css_class' => 'l&#7899;i CSS', // <=== new 1.0.6
    'width' => 'R&#7897;ng',
    'height' => 'Cao',
    'border' => 'Vi&#7873;n',
    'pixels' => '&#273;i&#7875;m &#7843;nh',
    'cellpadding' => '&#272;&#7879;m &#244;',
    'cellspacing' => 'Kho&#7843;ng tr&#7889;ng c&#7911;a &#244;',
    'bg_color' => 'M&#224;u n&#7873;n',
    'background' => '&#7842;nh n&#7873;n', // <=== new 1.0.6
    'error' => 'L&#7895;i',
    'error_rows_nan' => 'D&#242;ng kh&#244;ng ph&#7843;i l&#224; m&#7897;t s&#7889;',
    'error_columns_nan' => 'C&#7897;t kh&#244;ng ph&#7843;i l&#224; m&#7897;t s&#7889;',
    'error_width_nan' => '&#272;&#7897; r&#7897;ng kh&#244;ng ph&#7843;i l&#224; m&#7897;t s&#7889;',
    'error_height_nan' => 'Chi&#7875;u cao kh&#244;ng ph&#7843;i l&#224; m&#7897;t s&#7889;',
    'error_border_nan' => '&#272;&#432;&#7901;ng vi&#7873;n kh&#244;ng ph&#7843;i l&#224; m&#7897;t s&#7889;',
    'error_cellpadding_nan' => 'Kho&#7843;ng &#273;&#7879;m &#244; kh&#244;ng ph&#7843;i l&#224; m&#7897;t s&#7889;',
    'error_cellspacing_nan' => 'Kho&#7843;ng tr&#7855;ng &#244; kh&#244;ng ph&#7843;i l&#224; m&#7897;t s&#7889;',
  ),
  'table_cell_prop' => array(
    'title' => 'Thu&#7897;c t&#237;nh &#244;',
    'horizontal_align' => 'C&#259;n ngang',
    'vertical_align' => 'C&#259;n d&#7885;c',
    'width' => 'R&#7897;ng',
    'height' => 'Cao',
    'css_class' => 'l&#7899;p CSS',
    'no_wrap' => 'Kh&#244;ng bao ch&#7919;',
    'bg_color' => 'M&#224;u n&#7873;n',
    'background' => '&#7842;nh n&#7873;n', // <=== new 1.0.6
    'ok' => '   Ch&#7845;p nh&#7853;n   ',
    'cancel' => 'H&#7911;y b&#7887;',
    'justifyleft' => 'Tr&#225;i',
    'justifycenter' => 'Gi&#7919;a',
    'justifyright' => 'Ph&#7843;i',
    'top' => 'Tr&#234;n',
    'middle' => 'Gi&#7919;a',
    'bottom' => 'D&#432;&#7899;i',
    'baseline' => 'Tr&#234;n d&#242;ng',
    'error' => 'L&#7895;i',
    'error_width_nan' => '&#272;&#7897; r&#7897;ng kh&#244;ng ph&#7843;i l&#224; m&#7897;t s&#7889;',
    'error_height_nan' => 'Chi&#7875;u cao kh&#244;ng ph&#7843;i l&#224; m&#7897;t s&#7889;',
  ),
  'table_row_insert' => array(
    'title' => 'Th&#234;m d&#242;ng'
  ),
  'table_column_insert' => array(
    'title' => 'Th&#234;m c&#7897;t'
  ),
  'table_row_delete' => array(
    'title' => 'X&#243;a d&#242;ng'
  ),
  'table_column_delete' => array(
    'title' => 'X&#243;a c&#7897;t'
  ),
  'table_cell_merge_right' => array(
    'title' => 'K&#7871;t h&#7907;p b&#234;n ph&#7843;i'
  ),
  'table_cell_merge_down' => array(
    'title' => 'K&#7871;t h&#7907;p d&#432;&#7899;i'
  ),
  'table_cell_split_horizontal' => array(
    'title' => 'Chia &#244; ngang'
  ),
  'table_cell_split_vertical' => array(
    'title' => 'Chia &#244; d&#7885;c'
  ),
  'style' => array(
    'title' => 'Ki&#7875;u'
  ),
  'fontname' => array(
    'title' => 'Ph&#244;ng ch&#7919;'
  ),
  'fontsize' => array(
    'title' => 'K&#237;ch th&#432;&#7899;c'
  ),
  'formatBlock' => array(
    'title' => '&#272;o&#7841;n'
  ),
  'bold' => array(
    'title' => '&#272;&#7853;m'
  ),
  'italic' => array(
    'title' => 'Nghi&#234;ng'
  ),
  'underline' => array(
    'title' => 'G&#7841;ch ch&#226;n'
  ),
  'insertorderedlist' => array(
    'title' => 'Li&#7879;t k&#234; th&#7913; t&#7921;'
  ),
  'insertunorderedlist' => array(
    'title' => 'Li&#7879;t k&#234; d&#7845;u'
  ),
  'indent' => array(
    'title' => 'Th&#7909;t v&#224;o'
  ),
  'outdent' => array(
    'title' => 'L&#249;i ra'
  ),
  'justifyleft' => array(
    'title' => 'Tr&#225;i'
  ),
  'justifycenter' => array(
    'title' => 'Gi&#7919;a'
  ),
  'justifyright' => array(
    'title' => 'Ph&#7843;i'
  ),
  'fore_color' => array(
    'title' => 'M&#224;u ch&#7919;'
  ),
  'bg_color' => array(
    'title' => 'M&#224;u n&#7873;n'
  ),
  'design' => array(
    'title' => 'Chuy&#7875;n sang ch&#7871; &#273;&#7897; thi&#7871;t k&#7871;'
  ),
  'html' => array(
    'title' => 'Chuy&#7875;n sang ch&#7871; &#273;&#7897; m&#227; HTML'
  ),
  'colorpicker' => array(
    'title' => 'B&#7843;ng m&#224;u',
    'ok' => '   Ch&#7885;n   ',
    'cancel' => 'H&#7911;y b&#7887;',
  ),
  'cleanup' => array(
    'title' => 'L&#224;m s&#7841;ch m&#227; HTML',
    'confirm' => 'Khi th&#7921;c hi&#7879;n thao t&#225;c n&#224;y, c&#225;c &#273;&#7883;nh d&#7841;ng c&#7911;a v&#259;n b&#7843;n s&#7869; m&#7845;t.',
    'ok' => '   Ch&#7845;p nh&#7853;n   ',
    'cancel' => 'H&#7911;y b&#7887;',
  ),
  'toggle_borders' => array(
    'title' => 'C&#259;n vi&#7873;n',
  ),
  'hyperlink' => array(
    'title' => 'Si&#234;u li&#234;n k&#7871;t',
    'url' => 'URL',
    'name' => 'T&#234;n',
    'target' => '&#272;&#237;ch',
    'title_attr' => 'Ti&#234;u &#273;&#7873;',
	'a_type' => 'Ki&#7875;u', // <=== new 1.0.6
	'type_link' => 'Li&#234;n k&#7871;t', // <=== new 1.0.6
	'type_anchor' => 'Neo', // <=== new 1.0.6
	'type_link2anchor' => 'Li&#234;n k&#7871;t t&#7899;i neo', // <=== new 1.0.6
	'anchors' => 'Neo', // <=== new 1.0.6
    'ok' => '   &#272;&#7891;ng &#253;   ',
    'cancel' => 'H&#7911;y b&#7887;',
  ),
  'hyperlink_targets' => array( // <=== new 1.0.5
  	'_self' => 'c&#249;ng m&#7897;t frame (_self)',
	'_blank' => 'c&#7917;a s&#7893; m&#7899;i (_blank)',
	'_top' => 'Frame tr&#234;n c&#249;ng (_top)',
	'_parent' => 'Frame g&#7889;c (_parent)'
  ),
  'table_row_prop' => array(
    'title' => 'Thu&#7897;c t&#237;nh d&#242;ng',
    'horizontal_align' => 'C&#259;n ngang',
    'vertical_align' => 'C&#259;n d&#7885;c',
    'css_class' => 'l&#7899;p CSS',
    'no_wrap' => 'Kh&#244;ng bao ch&#7919;',
    'bg_color' => 'M&#224;u n&#7873;n',
    'ok' => '   &#272;&#7891;ng &#253;   ',
    'cancel' => 'H&#7911;y b&#7887;',
    'justifyleft' => 'Tr&#225;i',
    'justifycenter' => 'Gi&#7919;a',
    'justifyright' => 'Ph&#7843;i',
    'top' => 'Tr&#234;n',
    'middle' => 'Gi&#7919;a',
    'bottom' => 'D&#432;&#7899;i',
    'baseline' => 'Tr&#234;n d&#242;ng',
  ),
  'symbols' => array(
    'title' => 'K&#253; t&#7921; &#273;&#7863;c bi&#7879;t',
    'ok' => '   &#272;&#7891;ng &#253;   ',
    'cancel' => 'H&#7911;y b&#7887;',
  ),
  'templates' => array(
    'title' => 'M&#7851;u',
  ),
  'page_prop' => array(
    'title' => 'Thu&#7897;c t&#237;nh trang',
    'title_tag' => 'Ti&#234;u &#273;&#7873;',
    'charset' => 'Charset',
    'background' => '&#7842;nh n&#7873;n',
    'bgcolor' => 'M&#224;u n&#7873;n',
    'text' => 'M&#224;u ch&#7919;',
    'link' => 'M&#224;u li&#234;n k&#7871;t',
    'vlink' => 'M&#224;u li&#234;n k&#7871;t &#273;&#227; th&#259;m',
    'alink' => 'M&#224;u li&#234;n k&#7871;t k&#237;ch ho&#7841;t',
    'leftmargin' => 'M&#233;p tr&#225;i',
    'topmargin' => 'M&#233;p tr&#234;n',
    'css_class' => 'l&#7899;p CSS',
    'ok' => '   &#272;&#7891;ng &#253;   ',
    'cancel' => 'H&#7911;y b&#7887;',
  ),
  'preview' => array(
    'title' => 'Xem tr&#432;&#7899;c',
  ),
  'image_popup' => array(
    'title' => 'Popup &#7843;nh',
  ),
  'zoom' => array(
    'title' => 'Zoom',
  ),
  'subscript' => array( // <=== new 1.0.7
    'title' => 'ch&#7919; nh&#7887; ph&#237;a d&#432;&#7899;i',
  ),
  'superscript' => array( // <=== new 1.0.7
    'title' => 'ch&#7919; nh&#7887; ph&#237;a tr&#234;n',
  ),
);
?>