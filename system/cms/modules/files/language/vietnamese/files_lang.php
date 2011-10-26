<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Author: Thanh Nguyen
* 		  nguyenhuuthanh@gmail.com
*
* Location: http://techmix.net
*
* Created:  10.26.2011
*
* Description:  Vietnamese language file
*
*/
// Files

// Titles
$lang['files.files_title']					= 'Files';
$lang['files.upload_title']					= 'Tải lên Files';
$lang['files.edit_title']					= 'Sửa file "%s"';

// Labels
$lang['files.download_label']				= 'Tải về';
$lang['files.upload_label']					= 'Tải lên';
$lang['files.description_label']			= 'Mô tả';
$lang['files.type_label']					= 'Loại';
$lang['files.file_label']					= 'File';
$lang['files.filename_label']				= 'Tên file';
$lang['files.filter_label']					= 'Lọc';
$lang['files.loading_label']				= 'Đang tải...';
$lang['files.name_label']					= 'Tên';

$lang['files.dropdown_no_subfolders']		= '-- None --';
$lang['files.dropdown_root']				= '-- Root --';

$lang['files.type_a']						= 'Audio';
$lang['files.type_v']						= 'Video';
$lang['files.type_d']						= 'Tài liệu';
$lang['files.type_i']						= 'Hình ảnh';
$lang['files.type_o']						= 'Khác';

$lang['files.display_grid']					= 'Kẻ ô';
$lang['files.display_list']					= 'Danh sách';

// Messages
$lang['files.create_success']				= '"%s" đã được tải lên thành công.';
$lang['files.create_error']					= 'Có lỗi xảy ra.';
$lang['files.edit_success']					= 'File đã được lưu.';
$lang['files.edit_error']					= 'Có lỗi xảy ra khi lưu file.';
$lang['files.delete_success']				= 'File đã được xóa.';
$lang['files.delete_error']					= 'Không thể xóa file.';
$lang['files.mass_delete_success']			= 'Đã xóa %d trong tổng số %d files. Bao gồm "%s và %s"';
$lang['files.mass_delete_error']			= 'Có lỗi xảy ra khi xóa %d trong tổng số %d files, bao gồm "%s và %s".';
$lang['files.upload_error']					= 'Cần tải file lên.';
$lang['files.invalid_extension']			= 'File cần phải đúng phần mở rộng.';
$lang['files.not_exists']					= 'Bạn chọn thư mục không đúng.';
$lang['files.no_files']						= 'Không có files nào.';
$lang['files.no_permissions']				= 'Bạn không được cấp quyền xem mô đun file.';
$lang['files.no_select_error'] 				= 'Bạn phải chọn một file trước, không thể tiếp tục thực hiện yêu cầu.';

// File folders

// Titles
$lang['file_folders.folders_title']			= 'Thư mục File';
$lang['file_folders.manage_title']			= 'Quản lý thư mục';
$lang['file_folders.create_title']			= 'Thư mục mới';
$lang['file_folders.delete_title']			= 'Xác nhận xóa';
$lang['file_folders.edit_title']			= 'Sửa thư mục "%s"';

// Labels
$lang['file_folders.folders_label']			= 'Thư mục';
$lang['file_folders.folder_label']			= 'Thư mục';
$lang['file_folders.subfolders_label']		= 'Thư mục con';
$lang['file_folders.parent_label']			= 'Cha';
$lang['file_folders.name_label']			= 'Tên';
$lang['file_folders.slug_label']			= 'URL Slug';
$lang['file_folders.created_label']			= 'Tạo ngày';

// Messages
$lang['file_folders.create_success']		= 'Thư mục đã được lưu.';
$lang['file_folders.create_error']			= 'Có lỗi xảy ra khi tạo thư mục.';
$lang['file_folders.duplicate_error']		= 'Thư mục "%s" đã tồn tại.';
$lang['file_folders.edit_success']			= 'Đã lưu thư mục.';
$lang['file_folders.edit_error']			= 'Có lỗi xảy ra khi lưu thư mục';
$lang['file_folders.confirm_delete']		= 'Bạn có chắc muốn xóa những thư mục dưới đây, bao gồm tất cả files và thư mục con?';
$lang['file_folders.delete_mass_success']	= '%d trong tổng số %d thư mục đã được xóa thành công, bao gồm "%s và %s.';
$lang['file_folders.delete_mass_error']		= 'Có lỗi xảy ra khi xóa %d trong tổng số %d thư mục, bao gồm "%s và %s".';
$lang['file_folders.delete_success']		= 'Đã xóa thư mục "%s".';
$lang['file_folders.delete_error']			= 'Có lỗi xảy ra khi xóa thư mục "%s".';
$lang['file_folders.not_exists']			= 'Bạn chọn thư mục không đúng.';
$lang['file_folders.no_subfolders']			= 'Không';
$lang['file_folders.no_folders']			= 'File được sắp xếp theo thư mục, hiện giờ bạn không có thư mục nào được thiết lập.';
$lang['file_folders.mkdir_error']			= 'Không thể tạo thư mục uploads/files';
$lang['file_folders.chmod_error']			= 'Không thể CHMOD thư mục uploads/files';

/* End of file files_lang.php */