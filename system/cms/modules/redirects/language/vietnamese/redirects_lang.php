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
// labels
$lang['redirects:from']                      = 'Từ';
$lang['redirects:to']                        = 'Đến';
$lang['redirects:edit']                      = 'Sửa';
$lang['redirects:delete']                    = 'Xóa';
$lang['redirects:type']						= 'Type'; #translate

// redirect types
$lang['redirects:301']						= '301 - Moved Permanently'; #translate
$lang['redirects:302']						= '302 - Moved Temporarily'; #translate

// titles
$lang['redirects:add_title']                 = 'Thêm Redirect';
$lang['redirects:edit_title']                = 'Edit Redirect';
$lang['redirects:list_title']                = 'Redirects';

// messages
$lang['redirects:no_redirects']              = 'Không có redirects nào.';
$lang['redirects:add_success']               = 'redirect mới đã được lưu.';
$lang['redirects:add_error']                 = 'redirect mới chưa được lưu, vui lòng thử lại.';
$lang['redirects:edit_success']              = 'Các thay đổi của redirect này đã được lưu.';
$lang['redirects:edit_error']                = 'Các thay đổi của redirect này chưa được lưu, vui lòng thử lại';
$lang['redirects:mass_delete_error']         = 'Lỗi xảy ra khi xóa redirect "%s".';
$lang['redirects:mass_delete_success']       = '%s trong tổng số %s redirect được xóa thành công.';
$lang['redirects:no_select_error']           = 'Bạn cần chọn ít nhất một redirect để xóa.';
$lang['redirects:request_conflict_error']    = 'Redirect "%s" đã tồn tại trong hệ thống.';