<?php
/**
* Author: Thanh Nguyen
* 		  nguyenhuuthanh@gmail.com
* Location: http://techmix.net
* Created:  10.26.2011
* Description:  Vietnamese language file
*
*/

$lang['addons:modules'] 						= 'Mô-đun';
$lang['addons:admin_themes'] 					= 'Admin Themes'; #translate
$lang['addons:themes'] 							= 'Themes'; #translate
$lang['addons:widgets'] 						= 'Widgets'; #translate

$lang['addons:modules:core_list']               = 'Mô đun lõi';
$lang['addons:modules:addon_list']              = 'Mô đun cài đặt thêm';
$lang['addons:modules:introduction']            = 'Dưới đây là danh sách và thông tin (phiên bản, mô tả) của các mô đun đã được cài đặt.';
$lang['addons:modules:core_introduction']		= 'Below is a list of core modules and their information. You may disable them but do so with extreme care. Disabling modules such as Users will render your site inoperable.'; #translate
$lang['addons:modules:disable_error']           = 'Không thể vô hiệu hóa mô đun "%s".';
$lang['addons:modules:disable_success']         = 'Mô đun "%s" đã được vô hiệu hóa.';
$lang['addons:modules:enable_error']            = 'Không thể kích hoạt mô đun "%s".';
$lang['addons:modules:enable_success']          = 'Mô đun "%s" đã được kích hoạt.';
$lang['addons:modules:install_error']           = 'Không thể cài đặt mô đun.';
$lang['addons:modules:install_success']         = 'Mô đun "%s" đã được cài đặt.';

$lang['addons:modules:module_upload_success']   = 'The module "%s" has been uploaded.'; #translate

$lang['addons:modules:delete_success']			= 'Mô đun "%s" đã được xóa.'; #translate
$lang['addons:modules:delete_error']			= 'Không thể xóa mô đun "%s".'; #translate
$lang['addons:modules:uninstall_error']         = 'Không thể gỡ cài đặt mô đun "%s".';
$lang['addons:modules:uninstall_success']       = 'Mô đun "%s" đã được gỡ cài đặt.';
$lang['addons:modules:upgrade_error']           = 'Không thể nâng cấp mô đun "%s".';
$lang['addons:modules:upgrade_success']         = 'Mô đun "%s" đã được nâng cấp.';
$lang['addons:modules:already_exists_error']    = 'Mô đun "%s" đã tồn tại trong hệ thống.';
$lang['addons:modules:module_not_specified']    = 'Bạn phải chỉ rõ mô đun.';
$lang['addons:modules:details_error']           = 'Có lỗi trong file details.php thuộc mô đun %s. Hãy sửa rồi cài đặt lại mô đun.';

$lang['addons:modules:manually_remove']         = 'Bạn phải tự loại bỏ "%s" để có thể hoàn tất việc loại bỏ mô đun.';
$lang['addons:modules:upload_title']            = 'Tải lên';
$lang['addons:modules:upload_desc']             = 'Hãy chọn file và bấm vào Tải lên';

$lang['addons:modules:confirm_enable']          = 'Bạn có chắc muốn kích hoạt mô đun này?';
$lang['addons:modules:confirm_disable']         = 'Bạn có chắc muốn ngừng kích hoạt mô đun này?';
$lang['addons:modules:confirm_install']         = 'Bạn có chắc muốn cài đặt mô đun này?';
$lang['addons:modules:confirm_uninstall']		= 'Tất cả các bản ghi cơ sở dữ liệu của mô đun sẽ bị xóa! Bạn có chắc chắn muốn gỡ cài đặt mô đun này?'; #tranlate
$lang['addons:modules:confirm_delete']       	= 'Tất cả các files và bản ghi cơ sở dữ liệu của mô đun sẽ bị xóa! Bạn có chắc chắn muốn xóa mô đun này?';
$lang['addons:modules:confirm_upgrade'] 		= 'Bạn có chắc muốn nâng cấp mô đun này?';

$lang['addons:themes:save_success']				= 'Các tùy chọn theme đã được lưu thành công.';
$lang['addons:themes:re-index_success']			= 'Các tùy chọn theme đã được đánh chỉ mục thành công';
$lang['addons:themes:no_options']				= 'Không có tùy chọn.';
$lang['addons:themes:set_default_success']		= 'Theme "%s" là theme mặc định từ bây giờ.';
$lang['addons:themes:set_default_error']		= 'Không thể đặt theme "%s" là theme mặc định mới.';
$lang['addons:themes:already_exists_error']		= 'Đã có theme trùng tên với theme này.';
$lang['addons:themes:extract_error']			= 'Không thể giải nén theme.';
$lang['addons:themes:upload_success']			= 'Template được tải lên thành công.';
$lang['addons:themes:default_delete_error']		= 'Bạn không thể xóa theme mặc định.';
$lang['addons:themes:delete_error']				= 'Không thể xóa thư mục "%s".';
$lang['addons:themes:mass_delete_success']		= '%s trong tổng số %s theme đã được xóa thành công.';
$lang['addons:themes:mass_delete_error']		= 'Chỉ %s trong tổng số %s theme được xóa.';
$lang['addons:themes:delete_select_error']		= 'Bạn phải chọn theme cần xóa trước.';
$lang['addons:themes:upload_title']				= 'Tải lên theme';
$lang['addons:themes:admin_list']				= 'Danh sách Theme quản trị';
$lang['addons:themes:list_title']				= 'Theme';
$lang['addons:themes:upload_desc']				= 'Hãy chọn file và bấm nút tải lên (upload)';

$lang['addons:themes:options']					= 'Tùy chọn';
$lang['addons:themes:theme_label']				= 'Theme';
$lang['addons:themes:make_default']				= 'Chọn làm mặc định';
$lang['addons:themes:version_label']			= 'Phiên bản';
$lang['addons:themes:default_theme_label']		= 'Theme mặc định';
$lang['addons:themes:no_themes_installed']		= 'Không có Theme nào được cài đặt.';

/* End of file addons_lang.php */