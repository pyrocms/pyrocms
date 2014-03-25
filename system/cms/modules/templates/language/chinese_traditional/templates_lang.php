<?php defined('BASEPATH') or exit('No direct script access allowed');

// Streams
$lang['templates.stream.templates.name']   = 'Templates';
$lang['templates.stream.templates.create'] = 'Create Template';
$lang['templates.stream.templates.edit']   = 'Edit Template';

// Labels
$lang['templates:language_label']			= '語言';
$lang['templates:choose_lang_label']		= '選擇語言';
$lang['templates:subject_label']			= '主旨';
$lang['templates:body_label']				= '內容';
$lang['templates:slug_label']				= '縮略名(slug)';

// Titles
$lang['templates:create_title']				= '建立範本';
$lang['templates:edit_title']				= '編輯範本 "%s"';
$lang['templates:clone_title']				= '複製範本 "%s"';
$lang['templates:list_title']				= '範本列表';
$lang['templates:default_title']			= '預設範本';
$lang['templates:user_defined_title']		= '自定範本';

// Messages
$lang['templates:currently_no_templates']	= 'There are no user defined templates.'; #Translate
$lang['templates:tmpl_create_success']		= '郵件範本 "%s" 已經儲存';
$lang['templates:tmpl_create_error']		= '郵件範本 "%s" 沒有儲存';
$lang['templates:tmpl_edit_success']		= '郵件範本 "%s" 的變更已經儲存。';
$lang['templates:tmpl_edit_error']			= '郵件範本 "%s" 的變更沒有儲存。';
$lang['templates:tmpl_clone_success']		= '"%s" 已經複製。您現在可以開始編輯。';
$lang['templates:tmpl_clone_error']			= '"%s" 無法複製。請再試一次。';
$lang['templates:single_delete_success']	= '這個郵件範本已經刪除。';
$lang['templates:mass_delete_success']		= '%s 個郵件範本已經刪除(共選擇 %s 個範本)。';
$lang['templates:mass_delete_error'] 		= '正當嘗試刪除郵件範本 "%s" 時，有錯誤發生。';
$lang['templates:default_delete_error'] 	= '有錯誤，預設郵件範本不能移除。';
$lang['templates:no_select_error'] 			= '您需要先選取郵件範本。';
$lang['templates:already_exist_error']		= '一個和 "%s" 相同名稱的郵件範本已經存在。';

/* End of file templates_lang.php */
