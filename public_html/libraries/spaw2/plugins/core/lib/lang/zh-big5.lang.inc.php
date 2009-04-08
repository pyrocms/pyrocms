<?php
// ================================================
// SPAW PHP WYSIWYG editor control
// ================================================
// Chinese Big5 language file 
// ================================================
// Developed: Alan Mendelevich, alan@solmetra.lt
// Chinese translation: aman@wealthgrp.com.tw;aman@516888.com;aman77@pchome.com.tw
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
    'title' => '剪下'
  ),
  'copy' => array(
    'title' => '復制'
  ),
  'paste' => array(
    'title' => '貼上'
  ),
  'undo' => array(
    'title' => '復原'
  ),
  'redo' => array(
    'title' => '反復原'
  ),
  'hyperlink' => array(
    'title' => '超連結'
  ),
  'image_insert' => array(
    'title' => '插入圖片',
    'select' => '選取',
    'cancel' => '取消',
    'library' => '資料夾',
    'preview' => '預覽',
    'images' => '圖片',
    'upload' => '上傳圖片',
    'upload_button' => '上傳',
    'error' => '錯誤',
    'error_no_image' => '請選定圖片',
    'error_uploading' => '檔案上傳發生錯誤. 請稍後重傳',
    'error_wrong_type' => '檔案型態不符',
    'error_no_dir' => '找不到資料夾',
  ),
  'image_prop' => array(
    'title' => '圖檔屬性',
    'ok' => '   確定   ',
    'cancel' => '取消',
    'source' => '來源',
    'alt' => '文字提示',
    'align' => '對齊',
    'justifyleft' => '左',
    'justifyright' => '右',
    'top' => '上',
    'middle' => '中',
    'bottom' => '下',
    'absmiddle' => '絕對中央',
    'texttop' => '文字頂端',
    'baseline' => '基準線',
    'width' => '寬度',
    'height' => '高度',
    'border' => '邊框寬度',
    'hspace' => '水平間距',
    'vspace' => '垂直間距',
    'error' => '錯誤',
    'error_width_nan' => '寬度不是數字',
    'error_height_nan' => '高度不是數字',
    'error_border_nan' => '邊框寬度不是數字',
    'error_hspace_nan' => '水平間距不是數字',
    'error_vspace_nan' => '垂直間距不是數字',
  ),
  'inserthorizontalrule' => array(
    'title' => '水平規線'
  ),
  'table_create' => array(
    'title' => '新增表格'
  ),
  'table_prop' => array(
    'title' => '表格屬性',
    'ok' => '   確定   ',
    'cancel' => '取消',
    'rows' => '列數',
    'columns' => '行數',
    'width' => '寬度',
    'height' => '高度',
    'border' => '邊框寬度',
    'pixels' => 'px',
    'cellpadding' => '文框間距',
    'cellspacing' => '框線間距',
    'bg_color' => '背景顏色',
    'error' => '錯誤',
    'error_rows_nan' => '列數不是數字',
    'error_columns_nan' => '行數不是數字',
    'error_width_nan' => '寬度不是數字',
    'error_height_nan' => '高度不是數字',
    'error_border_nan' => '邊框寬度不是數字',
    'error_cellpadding_nan' => '文框間距不是數字',
    'error_cellspacing_nan' => '框線間距不是數字',
  ),
  'table_cell_prop' => array(
    'title' => '儲存格屬性',
    'horizontal_align' => '水平對齊',
    'vertical_align' => '垂直對齊',
    'width' => '寬度',
    'height' => '高度',
    'css_class' => 'CSS class',
    'no_wrap' => '文字不轉行',
    'bg_color' => '背景顏色',
    'ok' => '   確定   ',
    'cancel' => '取消',
    'justifyleft' => '左',
    'justifycenter' => '中',
    'justifyright' => '右',
    'top' => '頂',
    'middle' => '中央',
    'bottom' => '底',
    'baseline' => '基準線',
    'error' => '錯誤',
    'error_width_nan' => '寬度不是數字',
    'error_height_nan' => '高度不是數字',
    
  ),
  'table_row_insert' => array(
    'title' => '插入橫列'
  ),
  'table_column_insert' => array(
    'title' => '插入直行'
  ),
  'table_row_delete' => array(
    'title' => '刪除橫列'
  ),
  'table_column_delete' => array(
    'title' => '刪除直行'
  ),
  'table_cell_merge_right' => array(
    'title' => '合並右側'
  ),
  'table_cell_merge_down' => array(
    'title' => '合並下方'
  ),
  'table_cell_split_horizontal' => array(
    'title' => '水平分割'
  ),
  'table_cell_split_vertical' => array(
    'title' => '垂直分割'
  ),
  'style' => array(
    'title' => 'Style'
  ),
  'fontname' => array(
    'title' => '字體'
  ),
  'fontsize' => array(
    'title' => '字號'
  ),
  'formatBlock' => array(
    'title' => 'Paragraph'
  ),
  'bold' => array(
    'title' => '粗體'
  ),
  'italic' => array(
    'title' => '斜體'
  ),
  'underline' => array(
    'title' => '加底線'
  ),
  'insertorderedlist' => array(
    'title' => '序號表列'
  ),
  'insertunorderedlist' => array(
    'title' => '點號表列'
  ),
  'indent' => array(
    'title' => '增加縮排'
  ),
  'outdent' => array(
    'title' => '減少縮排'
  ),
  'justifyleft' => array(
    'title' => '靠左切齊'
  ),
  'justifycenter' => array(
    'title' => '置中對齊'
  ),
  'justifyright' => array(
    'title' => '靠右切齊'
  ),
  'fore_color' => array(
    'title' => '字體顏色'
  ),
  'bg_color' => array(
    'title' => '背景顏色'
  ),
  'design' => array(
    'title' => '切換 WYSIWYG (直覺) 模式'
  ),
  'html' => array(
    'title' => '切換 HTML (源碼) 模式'
  ),
  'colorpicker' => array(
    'title' => '調色盤',
    'ok' => '   確定   ',
    'cancel' => '取消',
  ),
  // <<<<<<<<< NEW >>>>>>>>>
  'cleanup' => array(
    'title' => '清除HTML (移除網頁格式)',
    'confirm' => '這個動作將會清除所有的網頁格式，請注意.',
    'ok' => '   確定   ',
    'cancel' => '取消',
  ),
  'toggle_borders' => array(
    'title' => '切換邊線',
  ),
  'hyperlink' => array(
    'title' => '超連結',
    'url' => '網址',
    'name' => '名稱',
    'target' => '目標',
    'title_attr' => '主題',
    'ok' => '   確定   ',
    'cancel' => '取消',
  ),
  'table_row_prop' => array(
    'title' => '橫列屬性',
    'horizontal_align' => '水平對齊',
    'vertical_align' => '垂直對齊',
    'css_class' => 'CSS class',
    'no_wrap' => '不換行',
    'bg_color' => '背景顏色',
    'ok' => '   確定   ',
    'cancel' => '取消',
    'justifyleft' => '左',
    'justifycenter' => '中',
    'justifyright' => '右',
    'top' => '頂',
    'middle' => '中央',
    'bottom' => '底部',
    'baseline' => '基線',
  ),
  'symbols' => array(
    'title' => '特殊符號',
    'ok' => '   確定   ',
    'cancel' => '取消',
  ),
  'symbols' => array(
    'title' => '特殊符號',
    'ok' => '   確定   ',
    'cancel' => '取消',
  ),
  'templates' => array(
    'title' => '模板',
  ),
  'page_prop' => array(
    'title' => '網頁屬性',
    'title_tag' => '主題',
    'charset' => '文字編碼',
    'background' => '背景圖片',
    'bgcolor' => '背景顏色',
    'text' => '文字顏色',
    'link' => '連結顏色',
    'vlink' => '參觀過的連結顏色',
    'alink' => '正在執行的連結顏色',
    'leftmargin' => '左邊界',
    'topmargin' => '上方邊界',
    'css_class' => 'CSS class',
    'ok' => '   確定   ',
    'cancel' => '取消',
  ),
  'preview' => array(
    'title' => '預覽',
  ),
  'image_popup' => array(
    'title' => '圖片彈出',
  ),
  'zoom' => array(
    'title' => 'Zoom',
  ),
);
?>