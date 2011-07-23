<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['settings_save_success'] 					= '您的設定已經儲存';
$lang['settings_edit_title'] 					= '編輯設定';

#section settings
$lang['settings_site_name'] 					= '網站名稱';
$lang['settings_site_name_desc'] 				= '在這裡設定的名稱會應用在 title 標籤以及整個網站。';

$lang['settings_site_slogan'] 					= '網站標語';
$lang['settings_site_slogan_desc'] 				= '在這裡設定的標語會應用在 title 標籤以及整個網站。';

$lang['settings_site_lang']						= 'Site Language'; #translate
$lang['settings_site_lang_desc']				= 'The native language of the website, used to choose templates of e-mail internal notifications and receiving visitors contact and other features that should not bend the language of a user.'; #translate

$lang['settings_contact_email'] 				= '收件者信箱';
$lang['settings_contact_email_desc'] 			= '所有來自於網站中用戶或訪客的信件，都將會寄到這個信箱裡。';

$lang['settings_server_email'] 					= '伺服器信箱';
$lang['settings_server_email_desc'] 			= '所有伺服器寄給用戶的電子郵件，都將來自於這個信箱。';

$lang['settings_meta_topic']					= 'Meta 標題';
$lang['settings_meta_topic_desc']				= '簡述貴 公司/網站 的種類';

$lang['settings_currency'] 						= '貨幣';
$lang['settings_currency_desc'] 				= '貨幣符號，這將會應用在產品等相關服務上。';

$lang['settings_dashboard_rss'] 				= '控制台 RSS Feed';
$lang['settings_dashboard_rss_desc'] 			= '連結到會顯示在控制台的 RSS feed。';

$lang['settings_dashboard_rss_count'] 			= '控制台 RSS 項目';
$lang['settings_dashboard_rss_count_desc'] 		= '您想要多少 RSS 項目顯示在控制台中呢？';

$lang['settings_date_format'] 					= 'Date Format'; #translate
$lang['settings_date_format_desc']				= 'How should dates be displayed accross the website and control panel? ' .
													'Using the <a href="http://php.net/manual/en/function.date.php" target="_black">date format</a> from PHP - OR - ' .
													'Using the format of <a href="http://php.net/manual/en/function.strftime.php" target="_black">strings formated as date</a> from PHP.'; #translate

$lang['settings_frontend_enabled'] 				= '網站狀態';
$lang['settings_frontend_enabled_desc'] 		= '您可使用這個選項將網站關閉或開啟。若您想要暫時關閉網站以進行維護工作，這會非常有用。';

$lang['settings_mail_protocol'] 				= 'Mail Protocol'; #translate
$lang['settings_mail_protocol_desc'] 			= 'Select desired email protocol.'; #translate

$lang['settings_mail_sendmail_path'] 			= 'Sendmail Path'; #translate
$lang['settings_mail_sendmail_path_desc']		= 'Path to server sendmail binary.'; #translate

$lang['settings_mail_smtp_host'] 				= 'SMTP Host'; #translate
$lang['settings_mail_smtp_host_desc'] 			= 'The host name of your smtp server.'; #translate

$lang['settings_mail_smtp_pass'] 				= 'SMTP password'; #translate
$lang['settings_mail_smtp_pass_desc'] 			= 'SMTP password.'; #translate

$lang['settings_mail_smtp_port'] 				= 'SMTP Port'; #translate
$lang['settings_mail_smtp_port_desc'] 			= 'SMTP port number.'; #translate

$lang['settings_mail_smtp_user'] 				= 'SMTP User Name'; #translate
$lang['settings_mail_smtp_user_desc'] 			= 'SMTP user name.'; #translate

$lang['settings_unavailable_message']			= '網站關閉訊息';
$lang['settings_unavailable_message_desc'] 		= '當網站關閉或有重大問題時，這段訊息將會顯示給前端網站的瀏覽者。';

$lang['settings_default_theme'] 				= '預設佈景主題';
$lang['settings_default_theme_desc'] 			= '請選擇您希望用戶預設看到的網站佈景主題。';

$lang['settings_activation_email'] 				= '發送啟動信件';
$lang['settings_activation_email_desc'] 		= '當用戶註冊會員時，自動發送內含帳號啟動連結的信件。如果關閉這個項目，那麼只有管理員能夠啟動使用者帳戶。';

$lang['settings_records_per_page'] 				= '每頁顯示的資料數';
$lang['settings_records_per_page_desc'] 		= '在管理系統中，每頁所顯示的資料筆數。';

$lang['settings_rss_feed_items'] 				= 'Feed 項目數量';
$lang['settings_rss_feed_items_desc'] 			= '在 RSS/blog feeds 中所顯示的項目數量';

$lang['settings_require_lastname'] 				= '需要輸入姓氏？';
$lang['settings_require_lastname_desc'] 		= '某些情況下，姓氏是不需要輸入的項目。您要強制用戶輸入這項資料嗎？';

$lang['settings_enable_profiles'] 				= '啟用個人簡介';
$lang['settings_enable_profiles_desc'] 			= '讓用戶能夠編輯自己的個人簡介。';

$lang['settings_ga_email'] 						= 'Google Analytic E-mail'; #translate
$lang['settings_ga_email_desc']					= 'E-mail address used for Google Analytics, we need this to show the graph on the dashboard.'; #translate

$lang['settings_ga_password'] 					= 'Google Analytic Password'; #translate
$lang['settings_ga_password_desc']				= 'Google Analytics password. This is also needed this to show the graph on the dashboard.'; #translate

$lang['settings_ga_profile'] 					= 'Google Analytic Profile'; #translate
$lang['settings_ga_profile_desc']				= 'Profile ID for this website in Google Analytics.'; #translate

$lang['settings_ga_tracking'] 					= 'Google Tracking Code'; #translate
$lang['settings_ga_tracking_desc']				= 'Enter your Google Analytic Tracking Code to activate Google Analytics view data capturing. E.g: UA-19483569-6'; #translate

$lang['settings_twitter_username'] 				= '用戶名稱';
$lang['settings_twitter_username_desc'] 		= 'Twitter 的用戶名稱(Username)。';

$lang['settings_twitter_consumer_key'] 			= '消費者金鑰';
$lang['settings_twitter_consumer_key_desc'] 	= 'Twitter 的消費者金鑰(Consumer Key)。';

$lang['settings_twitter_consumer_key_secret'] 	= '消費者機密';
$lang['settings_twitter_consumer_key_secret_desc'] = 'Twitter 的消費者機密序號(Consumer Key Secret)。';

$lang['settings_twitter_blog']					= 'Twitter &amp; 新聞 整合.';
$lang['settings_twitter_blog_desc'] 			= '您想要自動在 Twitter 上發佈最新文章的連結嗎？';

$lang['settings_twitter_feed_count'] 			= 'Feed 數量';
$lang['settings_twitter_feed_count_desc'] 		= '請設定在 Twitter feed 區塊內顯示的 Tweets 訊息數量。';

$lang['settings_twitter_cache'] 				= '暫存時間';
$lang['settings_twitter_cache_desc'] 			= '您的 Tweets 應該暫時保存多少分鐘呢？';

$lang['settings_akismet_api_key'] 				= 'Akismet API Key';
$lang['settings_akismet_api_key_desc'] 			= 'Akismet 是由 WordPress 團隊所提供，一個阻擋垃圾訊息入侵的機制。它會使垃圾訊息受到控制，卻不用一般強制用戶輸入檢查碼的方式。';

$lang['settings_comment_order'] 				= 'Comment Order'; #translate
$lang['settings_comment_order_desc']			= 'Sort order in which to display comments.'; #translate

$lang['settings_moderate_comments'] 			= '審核回應/評論';
$lang['settings_moderate_comments_desc']		= '強制所有的回應都必須通過審核才會顯示在網站上。';

$lang['settings_version'] 						= '版本';
$lang['settings_version_desc'] 					= '';

#section titles
$lang['settings_section_general']				= '一般';
$lang['settings_section_integration']			= '整合';
$lang['settings_section_comments']				= 'Comments'; #translate
$lang['settings_section_users']					= '用戶';
$lang['settings_section_statistics']			= '統計';
$lang['settings_section_twitter']				= 'Twitter';

#checkbox and radio options
$lang['settings_form_option_Open']				= '開啟';
$lang['settings_form_option_Closed']			= '關閉';
$lang['settings_form_option_Enabled']			= '啟用';
$lang['settings_form_option_Disabled']			= '禁用';
$lang['settings_form_option_Required']			= '必要';
$lang['settings_form_option_Optional']			= '可選擇';
$lang['settings_form_option_Oldest First']		= 'Oldest First'; #translate
$lang['settings_form_option_Newest First']		= 'Newest First'; #translate

/* End of file settings_lang.php */
/* Location: ./system/cms/modules/settings/language/chinese_traditional/settings_lang.php */
