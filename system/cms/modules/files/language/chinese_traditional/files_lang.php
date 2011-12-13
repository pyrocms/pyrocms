<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PyroCMS
 *
 * An open source CMS based on CodeIgniter
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @license		Apache License v2.0
 * @link		http://pyrocms.com
 * @since		Version 1.0-dev
 * @filesource
 */

// Files

// Titles
$lang['files.files_title']					= '檔案';
$lang['files.upload_title']					= '上傳檔案';
$lang['files.edit_title']					= '編輯檔案 "%s"';

// Labels
$lang['files.download_label']				= '下載';
$lang['files.upload_label']					= '上傳';
$lang['files.description_label']			= '說明';
$lang['files.type_label']					= '種類';
$lang['files.file_label']					= '檔案';
$lang['files.filename_label']				= '檔案名稱';
$lang['files.filter_label']					= '篩選';
$lang['files.loading_label']				= '載入中...';
$lang['files.name_label']					= '名稱';

$lang['files.dropdown_select']				= '-- Select Folder For Upload --'; #translate
$lang['files.dropdown_no_subfolders']		= '-- 無子目錄 --';
$lang['files.dropdown_root']				= '-- 根目錄 --';

$lang['files.type_a']						= '音樂';
$lang['files.type_v']						= '影片';
$lang['files.type_d']						= '文件';
$lang['files.type_i']						= '圖片';
$lang['files.type_o']						= '其他';

$lang['files.display_grid']					= '圖示';
$lang['files.display_list']					= '列表';

// Messages
$lang['files.create_success']				= '此檔案已經儲存';
$lang['files.create_error']					= '有錯誤發生';
$lang['files.edit_success']					= '檔案儲存成功';
$lang['files.edit_error']					= '存檔時有錯誤發生';
$lang['files.delete_success']				= '此檔案已刪除';
$lang['files.delete_error']					= '此檔案無法刪除';
$lang['files.mass_delete_success']			= '%d of %d 檔案已經成功刪除了，他們是 "%s and %s"。';
$lang['files.mass_delete_error']			= '在嘗試刪除 %d of %d 檔案時發生了錯誤，他們是 "%s and %s"。';
$lang['files.upload_error']					= '必須上傳檔案';
$lang['files.invalid_extension']			= '檔案必須有副檔名';
$lang['files.not_exists']					= '已選取了一個不正確的目錄';
$lang['files.no_files']						= '目前沒有檔案';
$lang['files.no_permissions']				= '您沒有瀏覽檔案模組的權限';
$lang['files.no_select_error'] 				= '您必須先選擇一個檔案';

// File folders

// Titles
$lang['file_folders.folders_title']			= '檔案目錄';
$lang['file_folders.manage_title']			= '管理目錄';
$lang['file_folders.create_title']			= '新增目錄';
$lang['file_folders.delete_title']			= '確認刪除';
$lang['file_folders.edit_title']			= '編輯目錄 "%s"';

// Labels
$lang['file_folders.folders_label']			= '目錄';
$lang['file_folders.folder_label']			= '目錄';
$lang['file_folders.subfolders_label']		= '子目錄';
$lang['file_folders.parent_label']			= '上級目錄';
$lang['file_folders.name_label']			= '目錄名稱';
$lang['file_folders.slug_label']			= '網址縮略(URL Slug)';
$lang['file_folders.created_label']			= '建立時間';

// Messages
$lang['file_folders.create_success']		= '目錄已經儲存';
$lang['file_folders.create_error']			= '在準備建立目錄時，發生了錯誤。';
$lang['file_folders.duplicate_error']		= '名稱是 "%s" 的目錄已經存在';
$lang['file_folders.edit_success']			= '目錄儲存成功';
$lang['file_folders.edit_error']			= '在嘗試儲存時，發生了錯誤。';
$lang['file_folders.confirm_delete']		= '確定要刪除這個目錄（包含目錄下的所有檔案與子目錄）？';
$lang['file_folders.delete_mass_success']	= '%d of %d 目錄已經成功刪除，他們是 "%s and %s"。';
$lang['file_folders.delete_mass_error']		= '在嘗試刪除 %d of %d 目錄時發生了錯誤，他們是 "%s 與 %s"。';
$lang['file_folders.delete_success']		= '目錄 "%s" 已經刪除';
$lang['file_folders.delete_error']			= '在嘗試刪除目錄 "%s" 時，發生了問題。';
$lang['file_folders.not_exists']			= '已選取了一個不正確的目錄';
$lang['file_folders.no_subfolders']			= '無';
$lang['file_folders.no_folders']			= '目前沒有目錄';
$lang['file_folders.mkdir_error']			= '無法建立 uploads/files 目錄';
$lang['file_folders.chmod_error']			= '無法 chmod uploads/files 目錄權限';

/* End of file files_lang.php */