<?php
// ================================================
// SPAW PHP WYSIWYG editor control
// ================================================
// Chinese utf-8 language file 
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
    'title' => '剪切'
  ),
  'copy' => array(
    'title' => '复制'
  ),
  'paste' => array(
    'title' => '粘贴'
  ),
  'undo' => array(
    'title' => '恢复'
  ),
  'redo' => array(
    'title' => '重做'
  ),
  'hyperlink' => array(
    'title' => '超连结'
  ),
  'image_insert' => array(
    'title' => '插入图片',
    'select' => '选取',
	'delete' => '删除', // new 1.0.5
    'cancel' => '取消',
    'library' => '资料夹',
    'preview' => '预览',
    'images' => '图片',
    'upload' => '上传图片',
    'upload_button' => '上传',
    'error' => '错误',
    'error_no_image' => '请选定图片',
    'error_uploading' => '文件上传发生错误. 请稍后重传',
    'error_wrong_type' => '文件格式不符',
    'error_no_dir' => '找不到资料夹',
	'error_cant_delete' => '删除失败', // new 1.0.5
  ),
  'image_prop' => array(
    'title' => '图片属性',
    'ok' => '   确定   ',
    'cancel' => '取消',
    'source' => '来源',
    'alt' => '文字提示',
    'align' => '对齐',
    'justifyleft' => '左',
    'justifyright' => '右',
    'top' => '上',
    'middle' => '中',
    'bottom' => '下',
    'absmiddle' => '绝对中央',
    'texttop' => '文字顶端',
    'baseline' => '基准线',
    'width' => '宽度',
    'height' => '高度',
    'border' => '边框宽度',
    'hspace' => '水平间距',
    'vspace' => '垂直间距',
    'error' => '错误',
    'error_width_nan' => '宽度不是数字',
    'error_height_nan' => '高度不是数字',
    'error_border_nan' => '边框宽度不是数字',
    'error_hspace_nan' => '水平间距不是数字',
    'error_vspace_nan' => '垂直间距不是数字',
  ),
  'inserthorizontalrule' => array(
    'title' => '水平规线'
  ),
  'table_create' => array(
    'title' => '新增表格'
  ),
  'table_prop' => array(
    'title' => '表格属性',
    'ok' => '   确定   ',
    'cancel' => '取消',
    'rows' => '列数',
    'columns' => '行数',
    'css_class' => 'CSS class', // <=== new 1.0.6
    'width' => '宽度',
    'height' => '高度',
    'border' => '边框宽度',
    'pixels' => 'px',
    'cellpadding' => '文框间距',
    'cellspacing' => '框线间距',
    'bg_color' => '背景颜色',
    'background' => '背景图像', // <=== new 1.0.6
    'error' => '错误',
    'error_rows_nan' => '列数不是数字',
    'error_columns_nan' => '行数不是数字',
    'error_width_nan' => '宽度不是数字',
    'error_height_nan' => '高度不是数字',
    'error_border_nan' => '边框宽度不是数字',
    'error_cellpadding_nan' => '文框间距不是数字',
    'error_cellspacing_nan' => '框线间距不是数字',
  ),
  'table_cell_prop' => array(
    'title' => '储存格属性',
    'horizontal_align' => '水平对齐',
    'vertical_align' => '垂直对齐',
    'width' => '宽度',
    'height' => '高度',
    'css_class' => 'CSS class',
    'no_wrap' => '文字不换行',
    'bg_color' => '背景颜色',
    'background' => '背景图像', // <=== new 1.0.6
    'ok' => '   确定   ',
    'cancel' => '取消',
    'justifyleft' => '左',
    'justifycenter' => '中',
    'justifyright' => '右',
    'top' => '顶',
    'middle' => '中央',
    'bottom' => '底',
    'baseline' => '基准线',
    'error' => '错误',
    'error_width_nan' => '宽度不是数字',
    'error_height_nan' => '高度不是数字',
    
  ),
  'table_row_insert' => array(
    'title' => '插入横列'
  ),
  'table_column_insert' => array(
    'title' => '插入直行'
  ),
  'table_row_delete' => array(
    'title' => '删除横列'
  ),
  'table_column_delete' => array(
    'title' => '删除直行'
  ),
  'table_cell_merge_right' => array(
    'title' => '合并右侧'
  ),
  'table_cell_merge_down' => array(
    'title' => '合并下方'
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
    'title' => '字体'
  ),
  'fontsize' => array(
    'title' => '字号'
  ),
  'formatBlock' => array(
    'title' => 'Paragraph'
  ),
  'bold' => array(
    'title' => '粗体'
  ),
  'italic' => array(
    'title' => '斜体'
  ),
  'underline' => array(
    'title' => '加底线'
  ),
  'insertorderedlist' => array(
    'title' => '序号表列'
  ),
  'insertunorderedlist' => array(
    'title' => '点号表列'
  ),
  'indent' => array(
    'title' => '增加缩排'
  ),
  'outdent' => array(
    'title' => '减少缩排'
  ),
  'justifyleft' => array(
    'title' => '靠左切齐'
  ),
  'justifycenter' => array(
    'title' => '置中对齐'
  ),
  'justifyright' => array(
    'title' => '靠右切齐'
  ),
  'fore_color' => array(
    'title' => '字体颜色'
  ),
  'bg_color' => array(
    'title' => '背景颜色'
  ),
  'design' => array(
    'title' => '切换 WYSIWYG (直观) 模式'
  ),
  'html' => array(
    'title' => '切换 HTML (源码) 模式'
  ),
  'colorpicker' => array(
    'title' => '调色盘',
    'ok' => '   确定   ',
    'cancel' => '取消',
  ),
  // <<<<<<<<< NEW >>>>>>>>>
  'cleanup' => array(
    'title' => '清除HTML (移除网页格式)',
    'confirm' => '这个操作将会清除所有的网页格式，请注意.',
    'ok' => '   确定   ',
    'cancel' => '取消',
  ),
  'toggle_borders' => array(
    'title' => '切换边线',
  ),
  'hyperlink' => array(
    'title' => '超链接',
    'url' => '网址',
    'name' => '名称',
    'target' => '目标',
    'title_attr' => '主题',
	'a_type' => '类型', // <=== new 1.0.6
	'type_link' => '链接', // <=== new 1.0.6
	'type_anchor' => '锚点', // <=== new 1.0.6
	'type_link2anchor' => '锚点链接', // <=== new 1.0.6
	'anchors' => '锚点', // <=== new 1.0.6
    'ok' => '   确定   ',
    'cancel' => '取消',
  ),
  'hyperlink_targets' => array( // <=== new 1.0.5
  	'_self' => '同一框架 (_self)',
	'_blank' => '新建窗口 (_blank)',
	'_top' => '整体框架 (_top)',
	'_parent' => '父框架 (_parent)'
  ),
  'table_row_prop' => array(
    'title' => '横列属性',
    'horizontal_align' => '水平对齐',
    'vertical_align' => '垂直对齐',
    'css_class' => 'CSS class',
    'no_wrap' => '不换行',
    'bg_color' => '背景颜色',
    'ok' => '   确定   ',
    'cancel' => '取消',
    'justifyleft' => '左',
    'justifycenter' => '中',
    'justifyright' => '右',
    'top' => '顶',
    'middle' => '中央',
    'bottom' => '底部',
    'baseline' => '基线',
  ),
  'symbols' => array(
    'title' => '特殊符号',
    'ok' => '   确定   ',
    'cancel' => '取消',
  ),
  'symbols' => array(
    'title' => '特殊符号',
    'ok' => '   确定   ',
    'cancel' => '取消',
  ),
  'templates' => array(
    'title' => '模板',
  ),
  'page_prop' => array(
    'title' => '网页属性',
    'title_tag' => '主题',
    'charset' => '文字编码',
    'background' => '背景图片',
    'bgcolor' => '背景颜色',
    'text' => '文字颜色',
    'link' => '连结颜色',
    'vlink' => '参观过的连结颜色',
    'alink' => '正在执行的连结颜色',
    'leftmargin' => '左边界',
    'topmargin' => '上方边界',
    'css_class' => 'CSS class',
    'ok' => '   确定   ',
    'cancel' => '取消',
  ),
  'preview' => array(
    'title' => '预览',
  ),
  'image_popup' => array(
    'title' => '图片弹出',
  ),
  'zoom' => array(
    'title' => 'Zoom',
  ),
  'subscript' => array( // <=== new 1.0.7
    'title' => 'Subscript',
  ),
  'superscript' => array( // <=== new 1.0.7
    'title' => 'Superscript',
  ),
);
?>