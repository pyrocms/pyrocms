<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * Vietnamese language file
 * Created:  10.26.2011
 *
 * @author Thanh Nguyen <nguyenhuuthanh@gmail.com>
 * @link http://techmix.net
 */
$lang['permissions:group']                  = 'Nhóm';
$lang['permissions:roles']                  = 'Vai trò';
$lang['permissions:module']                      = 'Module'; #translate
$lang['permissions:edit']                   = 'Chỉnh sửa quyền truy cập';

$lang['permissions:introduction']           = 'Bạn có thể tạo các quyền truy cập cho những người dùng khác nhau bằng cách gán vào các Nhóm trong Người dùng > Quản lý người dùng. Sau đó, bạn có thể chỉnh sửa quyền cho mỗi nhóm và cho phép Nhóm đó gán với mô đun hay vai trò nào.';

$lang['permissions:message_group_saved_success']    = 'Quyền truy cập cho Nhóm đã được lưu.';
$lang['permissions:message_group_saved_error']    = 'Sorry, the permissions for this group could not be saved.'; #translate
$lang['permissions:message_no_group_id_provided'] = 'The group id provided was not valid.'; #translate
$lang['permissions:admin_has_all_permissions'] = 'The Admin group has access to everything'; #translate
$lang['permissions:checkbox_tooltip_action_to_all'] = 'Check to give access permission to all modules for this group.'; #translate
$lang['permissions:checkbox_tooltip_give_access_to_module'] = 'Check to give access permission to the &quot;%s&quot; module for this group.'; #translate