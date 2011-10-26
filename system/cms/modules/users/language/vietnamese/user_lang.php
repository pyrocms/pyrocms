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
$lang['user_register_header']                  = 'Đăng ký';
$lang['user_register_step1']                   = '<strong>Bước 1:</strong> Đăng ký';
$lang['user_register_step2']                   = '<strong>Bước 2:</strong> Kích hoạt';

$lang['user_login_header']                     = 'Đăng nhập';

// titles
$lang['user_add_title']                        = 'Thêm tài khoản';
$lang['user_list_title'] 					   = 'Tài khoản';
$lang['user_inactive_title']                   = 'Tài khoản không hoạt động';
$lang['user_active_title']                     = 'Tài khoản đang hoạt động';
$lang['user_registred_title']                  = 'Tài khoản đã đăng ký';

// labels
$lang['user_edit_title']                       = 'Sửa tài khoản "%s"';
$lang['user_details_label']                    = 'Chi tiết';
$lang['user_first_name_label']                 = 'Tên';
$lang['user_last_name_label']                  = 'Họ';
$lang['user_email_label']                      = 'E-mail';
$lang['user_group_label']                      = 'Nhóm';
$lang['user_activate_label']                   = 'Kích hoạt';
$lang['user_password_label']                   = 'Mật khẩu';
$lang['user_password_confirm_label']           = 'Xác nhận mật khẩu';
$lang['user_name_label']                       = 'Tên';
$lang['user_joined_label']                     = 'đã tham gia';
$lang['user_last_visit_label']                 = 'Lần đăng nhập gần nhất';
$lang['user_never_label']                      = 'Không bao giờ';

$lang['user_no_inactives']                     = 'Không có tài khoản nào ở trạng thái không hoạt động.';
$lang['user_no_registred']                     = 'Không có tài khoản nào được đăng ký.';

$lang['account_changes_saved']                 = 'Các thay đổi thông tin tài khoản của bạn đã được lưu.';

$lang['indicates_required']                    = 'Thể hiện những trường bắt buộc';

// -- Registration / Activation / Reset Password ----------------------------------------------------------

$lang['user_register_title']                   = 'Đăng ký';
$lang['user_activate_account_title']           = 'Kích hoạt tài khoản';
$lang['user_activate_label']                   = 'Kích hoạt';
$lang['user_activated_account_title']          = 'Tài khoản đã kích hoạt';
$lang['user_reset_password_title']             = 'Khởi tạo lại mật khẩu';
$lang['user_password_reset_title']             = 'Mật khẩu khởi tạo lại';


$lang['user_error_username']                   = 'Username bạn chọn đã được sử dụng';
$lang['user_error_email']                      = 'Địa chỉ email bạn chọn đã được sử dụng';

$lang['user_full_name']                        = 'Tên đầy đủ';
$lang['user_first_name']                       = 'Tên';
$lang['user_last_name']                        = 'Họ';
$lang['user_username']                         = 'Username';
$lang['user_display_name']                     = 'Tên hiển thị';
$lang['user_email_use'] 					   = 'được sử dụng để đăng nhập';
$lang['user_email']                            = 'E-mail';
$lang['user_confirm_email']                    = 'Xác nhận E-mail';
$lang['user_password']                         = 'Mật khẩu';
$lang['user_remember']                         = 'Ghi nhớ đăng nhập';
$lang['user_group_id_label']                   = 'ID Nhóm';

$lang['user_level']                            = 'Vai trò người dùng';
$lang['user_active']                           = 'Đang hoạt động';
$lang['user_lang']                             = 'Ngôn ngữ';

$lang['user_activation_code']                  = 'Mã kích hoạt';

$lang['user_reset_instructions']			   = 'Điền địa chỉ email và username';
$lang['user_reset_password_link']              = 'Quên mật khẩu?';

$lang['user_activation_code_sent_notice']      = 'Mã kích hoạt đã được gửi tới email của bạn.';
$lang['user_activation_by_admin_notice']       = 'Tài khoản của bạn đang chờ Quản trị phê duyệt.';

// -- Settings ---------------------------------------------------------------------------------------------

$lang['user_details_section']                  = 'Tên';
$lang['user_password_section']                 = 'Đổi mật khẩu';
$lang['user_other_settings_section']           = 'Các thiết lập khác';

$lang['user_settings_saved_success']           = 'Các thiết lập cho tài khoản của bạn đã được lưu.';
$lang['user_settings_saved_error']             = 'Có lỗi xảy ra.';

// -- Buttons ----------------------------------------------------------------------------------------------

$lang['user_register_btn']                     = 'Đăng ký';
$lang['user_activate_btn']                     = 'Kích hoạt';
$lang['user_reset_pass_btn']                   = 'Khởi tạo lại mật khẩu';
$lang['user_login_btn']                        = 'Đăng nhập';
$lang['user_settings_btn']                     = 'Lưu thiết lập';

// -- Errors & Messages ------------------------------------------------------------------------------------

// Create
$lang['user_added_and_activated_success']      = 'Tài khoản mới đã được tạo và kích hoạt.';
$lang['user_added_not_activated_success']      = 'Tài khoản mới đã được tạo, cần phải kích hoạt.';

// Edit
$lang['user_edit_user_not_found_error']        = 'Không tìm thấy tài khoản.';
$lang['user_edit_success']                     = 'Tài khoản được cập nhật thành công.';
$lang['user_edit_error']                       = 'Lỗi xảy ra khi cập nhật tài khoản.';

// Activate
$lang['user_activate_success']                 = '%s trong tổng số %s tài khoản đã được kích hoạt.';
$lang['user_activate_error']                   = 'Bạn phải chọn tài khoản trước.';

// Delete
$lang['user_delete_self_error']                = 'Bạn không thể xóa tài khoản của chính bạn!';
$lang['user_mass_delete_success']              = '%s trong tổng số %s tài khoản được xóa thành công.';
$lang['user_mass_delete_error']                = 'Bạn cần chọn tài khoản trước.';

// Register
$lang['user_email_pass_missing']               = 'Email hoặc mật khẩu chưa được nhập.';
$lang['user_email_exists']                     = 'Email trùng với email của tài khoản khác.';
$lang['user_register_reasons']                 = 'Join up to access special areas normally restricted. This means your settings will be remembered, more content and less ads.';


// Activation
$lang['user_activation_incorrect']             = 'Lỗi kích hoạt. Vui lòng kiểm tra lại và chắc chắn rằng bạn đã tắt CAPS LOCK.';
$lang['user_activated_message']                = 'Tài khoản của bạn đã được kích hoạt, bạn có thể đăng nhập vào hệ thống.';


// Login
$lang['user_logged_in']                        = 'Bạn đã đăng nhập thành công.';
$lang['user_already_logged_in']                = 'Bạn đã đăng nhập. Hãy đăng xuất trước khi thử lại';
$lang['user_login_incorrect']                  = 'Email hoặc mật khẩu không khớp. Hãy kiểm tra lại và chắc chắn rằng bạn đã tắt CAPS LOCK.';
$lang['user_inactive']                         = 'Tài khoản bạn đang truy cập hiện không hoạt động.<br />Kiểm tra email của bạn để được hướng dẫn kích hoạt - <em>lưu ý kiểm tra cà thư mục junk hoặc spam</em>.';


// Logged Out
$lang['user_logged_out']                       = 'Bạn đã đăng xuất.';

// Forgot Pass
$lang['user_forgot_incorrect']                 = "Không tìm thấy tài khoản phù hợp.";

$lang['user_password_reset_message']           = "Mật khẩu đã được khởi tạo lại. Bạn sẽ nhận được email hướng dẫn trong thời gian sớm nhất. Nếu không, hãy kiểm tra thư mục junk hoặc spam của bạn.";

// Emails ----------------------------------------------------------------------------------------------------

// Activation
$lang['user_activation_email_subject']         = 'Yêu cầu kích hoạt';
$lang['user_activation_email_body']            = 'Cám ơn bạn đã kích hoạt tài khoản tại %s. Để đăng nhập, hãy bấm vào liên kết dưới đây:';


$lang['user_activated_email_subject']          = 'Kích hoạt hoàn tất';
$lang['user_activated_email_content_line1']    = 'Cám ơn bạn đã đăng ký tại %s. Trước khi kích hoạt tài khoản của bạn, xin vui lòng hoàn tất quá trình đăng ký bằng cách bấm vào liên kết sau:';
$lang['user_activated_email_content_line2']    = 'Trong trường hợp trình email không nhận diện được liên kết, xin vui lòng sử dụng trình duyệt để truy cập vào URL sau và nhập mã kích hoạt:';

// Reset Pass
$lang['user_reset_pass_email_subject']         = 'Khởi tạo lại mật khẩu';
$lang['user_reset_pass_email_body']            = 'Mật khẩu của bạn đã được khởi tạo lại. Nếu yêu cầu này không phải là của bạn, hãy liên hệ với chúng tôi tại %s chúng tôi sẽ hỗ trợ xử lý.';

// Profile
$lang['profile_of_title']             = 'Hồ sơ %s';

$lang['profile_user_details_label']   = 'Thông tin chi tiết người dùng';
$lang['profile_role_label']           = 'Vai trò';
$lang['profile_registred_on_label']   = 'Đăng ký vào';
$lang['profile_last_login_label']     = 'Lần đăng nhập cuối';
$lang['profile_male_label']           = 'Nam';
$lang['profile_female_label']         = 'Nữ';

$lang['profile_not_set_up']           = 'Tài khoản này chưa được thiết lập hồ sơ.';

$lang['profile_edit']                 = 'Sửa hồ sơ của bạn';

$lang['profile_personal_section']     = 'Cá nhân';

$lang['profile_display_name']         = 'Tên hiển thị';
$lang['profile_dob']                  = 'Ngày sinh';
$lang['profile_dob_day']              = 'Ngày';
$lang['profile_dob_month']            = 'Tháng';
$lang['profile_dob_year']             = 'Năm';
$lang['profile_gender']               = 'Giới tính';
$lang['profile_gender_nt']            = 'Không nói';
$lang['profile_gender_male']          = 'Nam';
$lang['profile_gender_female']        = 'Nữ';
$lang['profile_bio']                  = 'Về bản thân';

$lang['profile_contact_section']      = 'Liên hệ';

$lang['profile_phone']                = 'Điện thoại';
$lang['profile_mobile']               = 'Di động';
$lang['profile_address']              = 'Địa chỉ';
$lang['profile_address_line1']        = 'Dòng #1';
$lang['profile_address_line2']        = 'Dòng #2';
$lang['profile_address_line3']        = 'Dòng #3';
$lang['profile_address_postcode']     = 'Mã bưu điện';
$lang['profile_website']              = 'Website';

$lang['profile_messenger_section']    = 'Hệ thống tin nhắn';

$lang['profile_msn_handle']           = 'MSN';
$lang['profile_aim_handle']           = 'AIM';
$lang['profile_yim_handle']           = 'Yahoo! messenger';
$lang['profile_gtalk_handle']         = 'GTalk';

$lang['profile_avatar_section']       = 'Avatar';
$lang['profile_social_section']       = 'Social';

$lang['profile_gravatar']             = 'Gravatar';
$lang['profile_twitter']              = 'Twitter';

$lang['profile_edit_success']         = 'Hồ sơ của bạn đã được lưu.';
$lang['profile_edit_error']           = 'Có lỗi xảy ra.';

// -- Buttons ------------------------------------------------------------------------------------------------

$lang['profile_save_btn']             = 'Lưu hồ sơ';
/* End of file user_lang.php */