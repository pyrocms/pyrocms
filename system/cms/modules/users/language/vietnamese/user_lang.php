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

$lang['user:add_field']                        	= 'Add User Profile Field'; #translate
$lang['user:profile_delete_success']           	= 'User profile field deleted successfully'; #translate
$lang['user:profile_delete_failure']            = 'There was a problem with deleting your user profile field'; #translate
$lang['profile_user_basic_data_label']  		= 'Basic Data'; #translate
$lang['profile_company']         	  			= 'Company'; #translate
$lang['profile_updated_on']           			= 'Updated On'; #translate
$lang['user:profile_fields_label']	 		 	= 'Profile Fields'; #translate`

$lang['user:register_header']                  = 'Đăng ký';
$lang['user:register_step1']                   = '<strong>Bước 1:</strong> Đăng ký';
$lang['user:register_step2']                   = '<strong>Bước 2:</strong> Kích hoạt';

$lang['user:login_header']                     = 'Đăng nhập';

// titles
$lang['user:add_title']                        = 'Thêm tài khoản';
$lang['user:list_title'] 					   = 'Tài khoản';
$lang['user:inactive_title']                   = 'Tài khoản không hoạt động';
$lang['user:active_title']                     = 'Tài khoản đang hoạt động';
$lang['user:registred_title']                  = 'Tài khoản đã đăng ký';

// labels
$lang['user:edit_title']                       = 'Sửa tài khoản "%s"';
$lang['user:details_label']                    = 'Chi tiết';
$lang['user:first_name_label']                 = 'Tên';
$lang['user:last_name_label']                  = 'Họ';
$lang['user:group_label']                      = 'Nhóm';
$lang['user:activate_label']                   = 'Kích hoạt';
$lang['user:password_label']                   = 'Mật khẩu';
$lang['user:password_confirm_label']           = 'Xác nhận mật khẩu';
$lang['user:name_label']                       = 'Tên';
$lang['user:joined_label']                     = 'đã tham gia';
$lang['user:last_visit_label']                 = 'Lần đăng nhập gần nhất';
$lang['user:never_label']                      = 'Không bao giờ';

$lang['user:no_inactives']                     = 'Không có tài khoản nào ở trạng thái không hoạt động.';
$lang['user:no_registred']                     = 'Không có tài khoản nào được đăng ký.';

$lang['account_changes_saved']                 = 'Các thay đổi thông tin tài khoản của bạn đã được lưu.';

$lang['indicates_required']                    = 'Thể hiện những trường bắt buộc';

// -- Registration / Activation / Reset Password ----------------------------------------------------------

$lang['user:send_activation_email']            = 'Send Activation Email'; #translate
$lang['user:do_not_activate']                  = 'Inactive'; #translate
$lang['user:register_title']                   = 'Đăng ký';
$lang['user:activate_account_title']           = 'Kích hoạt tài khoản';
$lang['user:activate_label']                   = 'Kích hoạt';
$lang['user:activated_account_title']          = 'Tài khoản đã kích hoạt';
$lang['user:reset_password_title']             = 'Khởi tạo lại mật khẩu';
$lang['user:password_reset_title']             = 'Mật khẩu khởi tạo lại';


$lang['user:error_username']                   = 'Username bạn chọn đã được sử dụng';
$lang['user:error_email']                      = 'Địa chỉ email bạn chọn đã được sử dụng';

$lang['user:full_name']                        = 'Tên đầy đủ';
$lang['user:first_name']                       = 'Tên';
$lang['user:last_name']                        = 'Họ';
$lang['user:username']                         = 'Username';
$lang['user:display_name']                     = 'Tên hiển thị';
$lang['user:email_use'] 					   = 'được sử dụng để đăng nhập';
$lang['user:remember']                         = 'Ghi nhớ đăng nhập';
$lang['user:group_id_label']                   = 'ID Nhóm';

$lang['user:level']                            = 'Vai trò người dùng';
$lang['user:active']                           = 'Đang hoạt động';
$lang['user:lang']                             = 'Ngôn ngữ';

$lang['user:activation_code']                  = 'Mã kích hoạt';

$lang['user:reset_instructions']			   = 'Điền địa chỉ email và username';
$lang['user:reset_password_link']              = 'Quên mật khẩu?';

$lang['user:activation_code_sent_notice']      = 'Mã kích hoạt đã được gửi tới email của bạn.';
$lang['user:activation_by_admin_notice']       = 'Tài khoản của bạn đang chờ Quản trị phê duyệt.';
$lang['user:registration_disabled']            = 'Sorry, but the user registration is disabled.'; #translate

// -- Settings ---------------------------------------------------------------------------------------------

$lang['user:details_section']                  = 'Tên';
$lang['user:password_section']                 = 'Đổi mật khẩu';
$lang['user:other_settings_section']           = 'Các thiết lập khác';

$lang['user:settings_saved_success']           = 'Các thiết lập cho tài khoản của bạn đã được lưu.';
$lang['user:settings_saved_error']             = 'Có lỗi xảy ra.';

// -- Buttons ----------------------------------------------------------------------------------------------

$lang['user:register_btn']                     = 'Đăng ký';
$lang['user:activate_btn']                     = 'Kích hoạt';
$lang['user:reset_pass_btn']                   = 'Khởi tạo lại mật khẩu';
$lang['user:login_btn']                        = 'Đăng nhập';
$lang['user:settings_btn']                     = 'Lưu thiết lập';

// -- Errors & Messages ------------------------------------------------------------------------------------

// Create
$lang['user:added_and_activated_success']      = 'Tài khoản mới đã được tạo và kích hoạt.';
$lang['user:added_not_activated_success']      = 'Tài khoản mới đã được tạo, cần phải kích hoạt.';

// Edit
$lang['user:edit_user_not_found_error']        = 'Không tìm thấy tài khoản.';
$lang['user:edit_success']                     = 'Tài khoản được cập nhật thành công.';
$lang['user:edit_error']                       = 'Lỗi xảy ra khi cập nhật tài khoản.';

// Activate
$lang['user:activate_success']                 = '%s trong tổng số %s tài khoản đã được kích hoạt.';
$lang['user:activate_error']                   = 'Bạn phải chọn tài khoản trước.';

// Delete
$lang['user:delete_self_error']                = 'Bạn không thể xóa tài khoản của chính bạn!';
$lang['user:mass_delete_success']              = '%s trong tổng số %s tài khoản được xóa thành công.';
$lang['user:mass_delete_error']                = 'Bạn cần chọn tài khoản trước.';

// Register
$lang['user:email_pass_missing']               = 'Email hoặc mật khẩu chưa được nhập.';
$lang['user:email_exists']                     = 'Email trùng với email của tài khoản khác.';
$lang['user:register_error']				   = 'We think you are a bot. If we are mistaken please accept our apologies.'; #translate
$lang['user:register_reasons']                 = 'Join up to access special areas normally restricted. This means your settings will be remembered, more content and less ads.';


// Activation
$lang['user:activation_incorrect']             = 'Lỗi kích hoạt. Vui lòng kiểm tra lại và chắc chắn rằng bạn đã tắt CAPS LOCK.';
$lang['user:activated_message']                = 'Tài khoản của bạn đã được kích hoạt, bạn có thể đăng nhập vào hệ thống.';


// Login
$lang['user:logged_in']                        = 'Bạn đã đăng nhập thành công.';
$lang['user:already_logged_in']                = 'Bạn đã đăng nhập. Hãy đăng xuất trước khi thử lại';
$lang['user:login_incorrect']                  = 'Email hoặc mật khẩu không khớp. Hãy kiểm tra lại và chắc chắn rằng bạn đã tắt CAPS LOCK.';
$lang['user:inactive']                         = 'Tài khoản bạn đang truy cập hiện không hoạt động.<br />Kiểm tra email của bạn để được hướng dẫn kích hoạt - <em>lưu ý kiểm tra cà thư mục junk hoặc spam</em>.';


// Logged Out
$lang['user:logged_out']                       = 'Bạn đã đăng xuất.';

// Forgot Pass
$lang['user:forgot_incorrect']                 = "Không tìm thấy tài khoản phù hợp.";

$lang['user:password_reset_message']           = "Mật khẩu đã được khởi tạo lại. Bạn sẽ nhận được email hướng dẫn trong thời gian sớm nhất. Nếu không, hãy kiểm tra thư mục junk hoặc spam của bạn.";

// Emails ----------------------------------------------------------------------------------------------------

// Activation
$lang['user:activation_email_subject']         = 'Yêu cầu kích hoạt';
$lang['user:activation_email_body']            = 'Cám ơn bạn đã kích hoạt tài khoản tại %s. Để đăng nhập, hãy bấm vào liên kết dưới đây:';


$lang['user:activated_email_subject']          = 'Kích hoạt hoàn tất';
$lang['user:activated_email_content_line1']    = 'Cám ơn bạn đã đăng ký tại %s. Trước khi kích hoạt tài khoản của bạn, xin vui lòng hoàn tất quá trình đăng ký bằng cách bấm vào liên kết sau:';
$lang['user:activated_email_content_line2']    = 'Trong trường hợp trình email không nhận diện được liên kết, xin vui lòng sử dụng trình duyệt để truy cập vào URL sau và nhập mã kích hoạt:';

// Reset Pass
$lang['user:reset_pass_email_subject']         = 'Khởi tạo lại mật khẩu';
$lang['user:reset_pass_email_body']            = 'Mật khẩu của bạn đã được khởi tạo lại. Nếu yêu cầu này không phải là của bạn, hãy liên hệ với chúng tôi tại %s chúng tôi sẽ hỗ trợ xử lý.';

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