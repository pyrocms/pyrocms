<?php defined('BASEPATH') OR exit('No direct script access allowed');

#section settings
$lang['settings_site_name'] 					= '网站名称';
$lang['settings_site_name_desc'] 				= '在这里设定的名称會應用在 title 标籤以及整个网站。';

$lang['settings_site_slogan'] 					= '网站标语';
$lang['settings_site_slogan_desc'] 				= '在这里设定的标语會應用在 title 标籤以及整个网站。';

$lang['settings_site_lang']						= '网站语言';
$lang['settings_site_lang_desc']				= '网站的預设母语，用於选择內部通知、电子邮件模板和接受訪客的聯繫和其他功能的语言。';

$lang['settings_contact_email'] 				= '网站預设信箱';
$lang['settings_contact_email_desc'] 			= '所有來自於网站中用戶或訪客的信件，都將會寄到这个信箱里。';

$lang['settings_server_email'] 					= '伺服器信箱';
$lang['settings_server_email_desc'] 			= '所有伺服器寄給用戶的电子邮件，都將來自於这个信箱。';

$lang['settings_meta_topic']					= 'Meta 标題';
$lang['settings_meta_topic_desc']				= '簡述貴 公司/网站 的种类';

$lang['settings_currency'] 						= '货币';
$lang['settings_currency_desc'] 				= '货币符号，这将会应用在产品等相关服务上。';

$lang['settings_dashboard_rss'] 				= '控制台 RSS Feed';
$lang['settings_dashboard_rss_desc'] 			= '連結到会显示在控制台的 RSS feed。';

$lang['settings_dashboard_rss_count'] 			= '控制台 RSS 项目';
$lang['settings_dashboard_rss_count_desc'] 		= '您想要多少 RSS 项目显示在控制台中呢？';

$lang['settings_date_format'] 					= '日期格式';
$lang['settings_date_format_desc']				= '设定网站前后台的日期显示格式。请参考 <a href="http://php.net/manual/en/function.date.php" target="_black">date format</a> from PHP - 或是 - 參考 <a href="http://php.net/manual/en/function.strftime.php" target="_black">strings formated as date</a> from PHP.';

$lang['settings_frontend_enabled'] 				= '网站状态';
$lang['settings_frontend_enabled_desc'] 		= '您可使用这个选项将网站关闭或开放。若您想要暂时关闭网站以进行维护工作，这会非常有用。';

$lang['settings_mail_protocol'] 				= '邮件协议';
$lang['settings_mail_protocol_desc'] 			= '请选择所需的电子邮件协议';

$lang['settings_mail_sendmail_path'] 			= 'Sendmail路径';
$lang['settings_mail_sendmail_path_desc']		= '服务器中sendmail binary的路径。';

$lang['settings_mail_smtp_host'] 				= 'SMTP主机';
$lang['settings_mail_smtp_host_desc'] 			= '您的 smtp 主机名称';

$lang['settings_mail_smtp_pass'] 				= 'SMTP密码';
$lang['settings_mail_smtp_pass_desc'] 			= 'SMTP密码';

$lang['settings_mail_smtp_port'] 				= 'SMTP端口';
$lang['settings_mail_smtp_port_desc'] 			= 'SMTP端口';

$lang['settings_mail_smtp_user'] 				= 'SMTP用户名';
$lang['settings_mail_smtp_user_desc'] 			= 'SMTP用户名';

$lang['settings_unavailable_message']			= '网站关闭讯息';
$lang['settings_unavailable_message_desc'] 		= '当网站关闭或有重大問題时，这段讯息將会显示給前端网站的游览者。';

$lang['settings_default_theme'] 				= '預设布局主题';
$lang['settings_default_theme_desc'] 			= '请选择您希望用戶預设看到的网站佈景主題。';

$lang['settings_activation_email'] 				= '发送激活信件';
$lang['settings_activation_email_desc'] 		= '当用戶註冊会员时，自动发送带激活账号的信件。如果关闭这个項目，那么只有管理員能夠启动使用者账号。';

$lang['settings_records_per_page'] 				= '每頁显示的资料数';
$lang['settings_records_per_page_desc'] 		= '在管理系统中，每页所显示的資料数量。';

$lang['settings_rss_feed_items'] 				= 'Feed项目数量';
$lang['settings_rss_feed_items_desc'] 			= '在 RSS/blog feeds 中所显示的项目数量';

$lang['settings_require_lastname'] 				= '需要輸入姓氏？';
$lang['settings_require_lastname_desc'] 		= '某些情況下，姓氏是不需要輸入的項目。您要強制用戶輸入这項資料嗎？';

$lang['settings_enable_profiles'] 				= '启动个人簡介';
$lang['settings_enable_profiles_desc'] 			= '让用戶能夠编辑自己的个人簡介。';

$lang['settings_ga_email'] 						= 'Google Analytic E-mail';
$lang['settings_ga_email_desc']					= '申請 Google Analytics 的电子邮件，正確设定才能在控制台中顯示分析圖表。';

$lang['settings_ga_password'] 					= 'Google Analytic Password';
$lang['settings_ga_password_desc']				= 'Google Analytics 密碼，正確设定才能在控制台中顯示分析圖表。';

$lang['settings_ga_profile'] 					= 'Google Analytic Profile';
$lang['settings_ga_profile_desc']				= 'Google Analytics 中的 Profile ID 代號。';

$lang['settings_ga_tracking'] 					= 'Google 网站追蹤碼';
$lang['settings_ga_tracking_desc']				= '請輸入您的 Tracking Code 來啟用 Google Analytics 的資料讀取。例如：UA-19483569-6';

$lang['settings_twitter_username'] 				= '用戶名称';
$lang['settings_twitter_username_desc'] 		= 'Twitter 的用戶名称(Username)。';

$lang['settings_twitter_feed_count'] 			= 'Feed 數量';
$lang['settings_twitter_feed_count_desc'] 		= '請设定在 Twitter feed 區塊內顯示的 Tweets 訊息數量。';

$lang['settings_twitter_cache'] 				= '暫存時間';
$lang['settings_twitter_cache_desc'] 			= '您的 Tweets 應該暫時保存多少分鐘呢？';

$lang['settings_akismet_api_key'] 				= 'Akismet API Key';
$lang['settings_akismet_api_key_desc'] 			= 'Akismet 是由 WordPress 團隊所提供，一个阻擋垃圾訊息入侵的機制。它會使垃圾訊息受到控制，卻不用一般強制用戶輸入檢查碼的方式。';

$lang['settings_comment_order'] 				= '回应顺序';
$lang['settings_comment_order_desc']			= '显示回应的排序';

$lang['settings_enable_comments'] 				= '允许回應';
$lang['settings_enable_comments_desc']			= '是否允許用戶发表回应？';

$lang['settings_moderate_comments'] 			= '審核回應/評論';
$lang['settings_moderate_comments_desc']		= '強制所有的回應都必須通過審核才會顯示在网站上。';

$lang['settings_comment_markdown']				= '允許 Markdown';
$lang['settings_comment_markdown_desc']			= '您允許訪客使用 Markdown 張貼回應？';

$lang['settings_version'] 						= '版本';
$lang['settings_version_desc'] 					= '';

$lang['settings_site_public_lang']				= '前端的语言';
$lang['settings_site_public_lang_desc']			= '这个网站前端支援什麼语言？';

$lang['settings_admin_force_https']				= '在管理後台強制使用 HTTPS？';
$lang['settings_admin_force_https_desc']		= '只允許使用 HTTPS 協定來使用此管理後台？';

$lang['settings_files_cache']					= '檔案暫存';
$lang['settings_files_cache_desc']				= '當您透過 site.com/files 來輸出圖片時，系統應該设定的暫存時效是？';

$lang['settings_auto_username']					= '自動的 Username';
$lang['settings_auto_username_desc']			= '自動為用戶建立 username，代表使用者可在註冊時略過这个步驟。';

$lang['settings_registered_email']				= '發送註冊通知';
$lang['settings_registered_email_desc']			= '當有人註冊時，寄送通知信到网站預设信箱。';

$lang['settings_ckeditor_config']               = 'CKEditor 设置';
$lang['settings_ckeditor_config_desc']          = '您可以从 <a target="_blank" href="http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html">CKEditor\'s 文档.</a> 找到所有的设置选项';

$lang['settings_enable_registration']           = '启动用户注册功能';
$lang['settings_enable_registration_desc']      = '运行新用户在本网站注册.';

$lang['settings_cdn_domain']                    = 'CDN 域名';
$lang['settings_cdn_domain_desc']               = 'CDN 域名允许你卸载各种边缘服务器的静态内容, 像Amazon CloudFront或 MaxCDN一样.';

#section titles
$lang['settings_section_general']				= '一般';
$lang['settings_section_integration']			= '整合';
$lang['settings_section_comments']				= '回應';
$lang['settings_section_users']					= '用戶';
$lang['settings_section_statistics']			= '統計';
$lang['settings_section_twitter']				= 'Twitter';
$lang['settings_section_files']					= '檔案';

#checkbox and radio options
$lang['settings_form_option_Open']				= '開啟';
$lang['settings_form_option_Closed']			= '關閉';
$lang['settings_form_option_Enabled']			= '啟用';
$lang['settings_form_option_Disabled']			= '禁用';
$lang['settings_form_option_Required']			= '必要';
$lang['settings_form_option_Optional']			= '可选择';
$lang['settings_form_option_Oldest First']		= '最舊優先';
$lang['settings_form_option_Newest First']		= '最新優先';
$lang['settings_form_option_Text Only']			= '僅限純文字';
$lang['settings_form_option_Allow Markdown']	= '允許 Markdown';
$lang['settings_form_option_Yes']				= '是';
$lang['settings_form_option_No']				= '否';

// titles
$lang['settings_edit_title'] 					= '編輯设定';

// messages
$lang['settings_no_settings']					= '目前沒有设定';
$lang['settings_save_success'] 					= '您的设定已經儲存';

/* End of file settings_lang.php */