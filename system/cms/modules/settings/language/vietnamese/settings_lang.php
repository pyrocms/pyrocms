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
#section settings
$lang['settings:site_name']						= 'Tên site';
$lang['settings:site_name_desc']				= 'Tên của website sử dụng cho tiêu đề trang và trong các thành phần khác.';

$lang['settings:site_slogan']					= 'Khẩu hiệu';
$lang['settings:site_slogan_desc']				= 'Khẩu hiệu của website sử dụng cho tiều đề trang và trong các thành phần khác.';

$lang['settings:site_lang']						= 'Ngôn ngữ site';
$lang['settings:site_lang_desc']				= 'Ngôn ngữ bản địa cửa website, sử dụng để chọn mẫu thông báo email, biểu mẫu liên hệ, và các tính năng khác không phụ thuộc ngôn ngữ của người dùng.';

$lang['settings:contact_email']					= 'E-mail liên hệ';
$lang['settings:contact_email_desc']			= 'Tất cả email của người dùng, khách và site sẽ được gửi về địa chỉ này.';

$lang['settings:server_email']					= 'E-mail hệ thống';
$lang['settings:server_email_desc']				= 'Tất cả email đến người dùng sẽ được gửi từ địa chỉ email này.';

$lang['settings:meta_topic']					= 'Chủ đề site';
$lang['settings:meta_topic_desc']				= 'Một vài từ mô tả về website này.';

$lang['settings:currency']						= 'Tiền tệ';
$lang['settings:currency_desc']					= 'Biểu tượng tiền tệ sử dụng cho sản phẩm, dịch vụ v.v..';

$lang['settings:dashboard_rss']					= 'RSS Feed';
$lang['settings:dashboard_rss_desc']			= 'Liên kết đến một RSS được hiển thị trong Bảng thông tin (Dashboard).';

$lang['settings:dashboard_rss_count']			= 'Bài viết RSS';
$lang['settings:dashboard_rss_count_desc']		= 'Bao nhiêu bài viết RSS bạn muốn hiển thị trên bảng thông tin (Dashboard) ?';

$lang['settings:date_format']					= 'Định dạng ngày';
$lang['settings:date_format_desc']				= 'Hiển thị trên website và trang quản trị. Sử dụng <a target="_blank" href="http://php.net/manual/en/function.date.php">định dàng ngày</a> từ PHP - hoặc - sử dụng định dạng <a target="_blank" href="http://php.net/manual/en/function.strftime.php">chuỗi định dạng ngày</a> từ PHP.';

$lang['settings:frontend_enabled']				= 'Trạng thái site';
$lang['settings:frontend_enabled_desc']			= 'Sử dụng tùy chọn này khi bạn cần bảo trì website, hiển thị thông báo tới người dùng';

$lang['settings:mail_protocol']					= 'Giao thức Mail';
$lang['settings:mail_protocol_desc']			= 'Chọn giao thức mail.';

$lang['settings:mail_sendmail_path']			= 'Đướng dẫn Sendmail';
$lang['settings:mail_sendmail_path_desc']		= 'Đường dẫn đến sendmail.';

$lang['settings:mail_smtp_host']				= 'Máy chủ SMTP';
$lang['settings:mail_smtp_host_desc']			= 'Địa chỉ máy chủ smtp.';

$lang['settings:mail_smtp_pass']				= 'Mật khẩu SMTP';
$lang['settings:mail_smtp_pass_desc']			= 'Mật khẩu SMTP.';

$lang['settings:mail_smtp_port'] 				= 'Cổng SMTP';
$lang['settings:mail_smtp_port_desc'] 			= 'Cổng SMTP.';

$lang['settings:mail_smtp_user'] 				= 'Người dùng SMTP';
$lang['settings:mail_smtp_user_desc'] 			= 'Tên người dùng SMTP.';

$lang['settings:unavailable_message']			= 'Thông điệp khi site ngừng hoạt động';
$lang['settings:unavailable_message_desc']		= 'Khi site không hoạt động hoặc khi có vấn đề lớn, thông điệp này sẽ được hiển thị tới người dùng.';

$lang['settings:default_theme']					= 'Theme mặc định';
$lang['settings:default_theme_desc']			= 'Lựa chọn theme mặc định cho người dùng.';

$lang['settings:activation_email']				= 'Email kích hoạt';
$lang['settings:activation_email_desc']			= 'Gửi email kèm liên kết kích hoạt khi một người dùng đăng ký. Vô hiệu hóa tính năng này nếu bạn muốn chỉ Quản trị viên mới được quyền kích hoạt người dùng.';

$lang['settings:records_per_page']				= 'Số bản ghi trên một trang';
$lang['settings:records_per_page_desc']			= 'Bao nhiêu bản ghi hiển thị trên một trang trong phần quản trị?';

$lang['settings:rss_feed_items']				= 'Đếm bài Feed';
$lang['settings:rss_feed_items_desc']			= 'Bao nhiêu bài viết hiển thị trong RSS/blog feeds?';


$lang['settings:enable_profiles']				= 'Kích hoạt hồ sơ cá nhân';
$lang['settings:enable_profiles_desc']			= 'Cho phép người dùng thêm và sửa hồ sơ cá nhân.';

$lang['settings:ga_email']						= 'Google Analytic E-mail';
$lang['settings:ga_email_desc']					= 'Địa chỉ E-mail sử dụng cho Google Analytics, cần thiết để hiện biểu đồ trên site.';

$lang['settings:ga_password']					= 'Google Analytic Password';
$lang['settings:ga_password_desc']				= 'Mật khẩu Google Analytics, cần thiết để hiện biểu đồ trên site.';

$lang['settings:ga_profile']					= 'Google Analytic Profile';
$lang['settings:ga_profile_desc']				= 'Profile ID cho website này trong Google Analytics.';

$lang['settings:ga_tracking']					= 'Google Tracking Code';
$lang['settings:ga_tracking_desc']				= 'Điền Google Analytic Tracking Code để kích hoạt  Google Analytics thu thập dữ liệu. E.g: UA-19483569-6';

$lang['settings:twitter_username']				= 'Tên đăng nhập';
$lang['settings:twitter_username_desc']			= 'Tên đăng nhập Twitter.';

$lang['settings:twitter_feed_count']			= 'Đếm Feed';
$lang['settings:twitter_feed_count_desc']		= 'Bao nhiêu tweets hiển thị trên ô Twitter feed?';

$lang['settings:twitter_cache']					= 'Thời gian lưu cache';
$lang['settings:twitter_cache_desc']			= 'Tweets sẽ được lưu trong bao nhiêu phút?';

$lang['settings:akismet_api_key']				= 'Akismet API Key';
$lang['settings:akismet_api_key_desc']			= 'Akismet là chương trình ngăn spam phát triển bởi WordPress. Chúng giúp chặn spam mà không yêu cầu người dùng sử dụng CAPTCHA.';

$lang['settings:comment_order']					= 'Sắp xếp phản hồi';
$lang['settings:comment_order_desc']			= 'Thứ tự sắp xếp hiển thị phản hồi.';
	
$lang['settings:moderate_comments']				= 'Xét duyệt phản hồi';
$lang['settings:moderate_comments_desc']		= 'Xét duyệt phản hồi trước khi hiển thị trên site.';

$lang['settings:version']						= 'Phiên bản';
$lang['settings:version_desc']					= '';

$lang['settings:ckeditor_config']               = 'CKEditor Config'; #translate
$lang['settings:ckeditor_config_desc']          = 'You can find a list of valid configuration items in <a target="_blank" href="http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html">CKEditor\'s documentation.</a>'; #translate

$lang['settings:enable_registration']           = 'Enable user registration'; #translate
$lang['settings:enable_registration_desc']      = 'Allow users to register in your site.'; #translate

$lang['settings:profile_visibility']            = 'Profile Visibility'; #translate
$lang['settings:profile_visibility_desc']       = 'Specify who can view user profiles on the public site'; #translate

$lang['settings:cdn_domain']                    = 'CDN Domain'; #translate
$lang['settings:cdn_domain_desc']               = 'CDN domains allow you to offload static content to various edge servers, like Amazon CloudFront or MaxCDN.'; #translate

#section titles
$lang['settings:section_general']				= 'Thông tin chung';
$lang['settings:section_integration']			= 'Tích hợp';
$lang['settings:section_comments']				= 'Phản hồi';
$lang['settings:section_users']					= 'Người dùng';
$lang['settings:section_statistics']			= 'Thống kê';
$lang['settings:section_twitter']				= 'Twitter';

#checkbox and radio options
$lang['settings:form_option_Open']				= 'Mở';
$lang['settings:form_option_Closed']			= 'Đóng';
$lang['settings:form_option_Enabled']			= 'Hoạt động';
$lang['settings:form_option_Disabled']			= 'Ngừng hoạt động';
$lang['settings:form_option_Required']			= 'Bắt buộc';
$lang['settings:form_option_Optional']			= 'Không bắt buộc';
$lang['settings:form_option_Oldest First']		= 'Cũ nhất trước'; #translate
$lang['settings:form_option_Newest First']		= 'Mới nhất trước'; #translate

// titles
$lang['settings:edit_title']					= 'Sửa thiết lập';

// messages
$lang['settings:no_settings']					= 'Không có thiết lập nào.';
$lang['settings:save_success']					= 'Các thiết lập của bạn đã được lưu';

/* End of file settings_lang.php */