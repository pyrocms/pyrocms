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
$lang['files.edit_title']					= 'Edit file "%s"'; #translate

// Labels
$lang['files.actions_label']				= '操作';
$lang['files.download_label']				= '下載';
$lang['files.edit_label']					= '編輯';
$lang['files.delete_label']					= '刪除';
$lang['files.upload_label']					= '上傳';
$lang['files.description_label']			= '說明';
$lang['files.type_label']					= '種類';
$lang['files.file_label']					= '檔案';
$lang['files.filename_label']				= '檔案名稱';
$lang['files.filter_label']					= 'Filter'; #translate
$lang['files.loading_label']				= 'Loading...'; #translate
$lang['files.name_label']					= 'Name'; #translate

$lang['files.dropdown_no_subfolders']		= '-- 無子目錄 --';
$lang['files.dropdown_root']				= '-- 根目錄 --';

$lang['files.type_a']						= '音樂';
$lang['files.type_v']						= '影片';
$lang['files.type_d']						= '文件';
$lang['files.type_i']						= '圖片';
$lang['files.type_o']						= '其他';

$lang['files.display_grid']					= 'Grid'; #translate
$lang['files.display_list']					= 'List'; #translate

// Messages
$lang['files.create_success']				= '此檔案已經儲存';
$lang['files.create_error']					= 'An error as occourred.'; #translate
$lang['files.edit_success']					= 'The file was successfully saved.'; #translate
$lang['files.edit_error']					= 'An error occurred while trying to save the file.'; #translate
$lang['files.delete_success']				= '此檔案已刪除';
$lang['files.delete_error']					= '此檔案無法刪除';
$lang['files.mass_delete_success']			= '%d of %d files were successfully deleted, they were "%s and %s"'; #translate
$lang['files.mass_delete_error']			= 'An error occurred while trying to delete %d of %d files, they are "%s and %s".'; #translate
$lang['files.upload_error']					= '必須上傳檔案';
$lang['files.invalid_extension']			= '檔案必須有副檔名';
$lang['files.not_exists']					= '已選取了一個不正確的目錄';
$lang['files.no_files']						= '目前沒有檔案';
$lang['files.no_permissions']				= 'You do not have permissions to see the files module.'; #translate
$lang['files.no_select_error'] 				= 'You must select a file first, his request was interrupted.'; #translate

// File folders

// Titles
$lang['file_folders.folders_title']			= '檔案目錄';
$lang['file_folders.manage_title']			= '管理目錄';
$lang['file_folders.create_title']			= '新增目錄';
$lang['file_folders.delete_title']			= '確認刪除';
$lang['file_folders.edit_title']			= 'Edit folder "%s"'; #translate

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
$lang['file_folders.create_error']			= 'An error occurred while attempting to create your folder.'; #translate
$lang['file_folders.duplicate_error']		= 'A folder named "%s" already exists.'; #translate
$lang['file_folders.edit_success']			= 'The folder was successfully saved.'; #translate
$lang['file_folders.edit_error']			= 'An error occurred while trying to save the changes.'; #translate
$lang['file_folders.confirm_delete']		= 'Are you sure you want to delete the folders below, including all files and subfolders inside them?'; #translate
$lang['file_folders.delete_mass_success']	= '%d of %d folders have been successfully deleted, they were "%s and %s.'; #translate
$lang['file_folders.delete_mass_error']		= 'An error occurred while trying to delete %d of %d folders, they are "%s and %s".'; #translate
$lang['file_folders.delete_success']		= '目錄 "%s" 已經刪除';
$lang['file_folders.delete_error']			= 'An error occurred while trying to delete the folder "%s".'; #translate
$lang['file_folders.not_exists']			= '已選取了一個不正確的目錄';
$lang['file_folders.no_subfolders']			= '無';
$lang['file_folders.no_folders']			= '目前沒有目錄';
$lang['file_folders.mkdir_error']			= '無法建立 uploads/files 目錄';
$lang['file_folders.chmod_error']			= '無法 chmod uploads/files 目錄權限';

/* End of file files_lang.php */