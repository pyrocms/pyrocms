<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Chinese Simpplified translation.
 *
 * @author		Kefeng DENG
 * @package		PyroCMS
 * @subpackage 	Redirects Module
 * @category	Modules
 * @link		http://pyrocms.com
 * @date		2012-06-27
 * @version		1.0
 */

// labels
$lang['redirects:from'] 				= '來源网址';
$lang['redirects:to']					= '目標网址';
$lang['redirects:edit']					= '編輯';
$lang['redirects:delete']				= '刪除';
$lang['redirects:type']					= '类别';

// redirect types
$lang['redirects:301']					= '301 - 永久的跳转';
$lang['redirects:302']					= '302 - 暂时的跳转';

// titles
$lang['redirects:add_title'] 			= '新增转址';
$lang['redirects:edit_title'] 			= '編輯转址';
$lang['redirects:list_title'] 			= '转址列表';

// messages
$lang['redirects:no_redirects']				= '目前沒有設定转址';
$lang['redirects:add_success'] 				= '新的转址設定已經儲存';
$lang['redirects:add_error'] 				= '新的转址設定無法儲存，請稍後再試。';
$lang['redirects:edit_success'] 			= '这个转址的修改已經儲存。';
$lang['redirects:edit_error'] 				= '这个转址的修改無法儲存，請稍後再試。';
$lang['redirects:mass_delete_error'] 		= '嘗試刪除转址項目 "%s" 時發生了錯誤。';
$lang['redirects:mass_delete_success']		= '%s 個转址設定已經刪除(共選擇 %s 個設定)。';
$lang['redirects:no_select_error'] 			= '請先選取需要刪除的转址項目。';
$lang['redirects:request_conflict_error']	= '"%s" 相同的转址設定已經存在。';