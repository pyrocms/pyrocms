<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Chinese Simpplified translation.
 *
 * @author		Kefeng DENG
 * @package		PyroCMS
 * @subpackage 	Settings Module
 * @category	Modules
 * @link		http://pyrocms.com
 * @date		2012-06-27
 * @version		1.1
 */

#section settings
$lang['settings:site_name'] 					= '網站名稱';
$lang['settings:site_name_desc'] 				= '在這裡設定的名稱會應用在 title 標籤以及整個網站。';

$lang['settings:site_slogan'] 					= '網站標語';
$lang['settings:site_slogan_desc'] 				= '在這裡設定的標語會應用在 title 標籤以及整個網站。';

$lang['settings:site_lang']						= '網站語言';
$lang['settings:site_lang_desc']				= '網站的預設母語，用於選擇內部通知、電子郵件模板和接受訪客的聯繫和其他功能的語言。';

$lang['settings:contact_email'] 				= '網站預設信箱';
$lang['settings:contact_email_desc'] 			= '所有來自於網站中用戶或訪客的信件，都將會寄到這個信箱裡。';

$lang['settings:server_email'] 					= '伺服器信箱';
$lang['settings:server_email_desc'] 			= '所有伺服器寄給用戶的電子郵件，都將來自於這個信箱。';

$lang['settings:meta_topic']					= 'Meta 標題';
$lang['settings:meta_topic_desc']				= '簡述貴 公司/網站 的種類';

$lang['settings:currency'] 						= '貨幣';
$lang['settings:currency_desc'] 				= '貨幣符號，這將會應用在產品等相關服務上。';

$lang['settings:dashboard_rss'] 				= '控制台 RSS Feed';
$lang['settings:dashboard_rss_desc'] 			= '連結到會顯示在控制台的 RSS feed。';

$lang['settings:dashboard_rss_count'] 			= '控制台 RSS 項目';
$lang['settings:dashboard_rss_count_desc'] 		= '您想要多少 RSS 項目顯示在控制台中呢？';

$lang['settings:date_format'] 					= '日期格式';
$lang['settings:date_format_desc']				= '設定網站前後台的日期顯示格式。請參考 <a href="http://php.net/manual/en/function.date.php" target="_black">date format</a> from PHP - 或是 - 參考 <a href="http://php.net/manual/en/function.strftime.php" target="_black">strings formated as date</a> from PHP.';

$lang['settings:frontend_enabled'] 				= '網站狀態';
$lang['settings:frontend_enabled_desc'] 		= '您可使用這個選項將網站關閉或開啟。若您想要暫時關閉網站以進行維護工作，這會非常有用。';

$lang['settings:mail_protocol'] 				= 'Mail Protocol';
$lang['settings:mail_protocol_desc'] 			= '請選擇所需的電子郵件溝通協議';

$lang['settings:mail_sendmail_path'] 			= 'Sendmail 路徑';
$lang['settings:mail_sendmail_path_desc']		= '伺服器中 sendmail binary 的路徑。';

$lang['settings:mail_smtp_host'] 				= 'SMTP Host';
$lang['settings:mail_smtp_host_desc'] 			= '您的 smtp 主機名稱';

$lang['settings:mail_smtp_pass'] 				= 'SMTP password';
$lang['settings:mail_smtp_pass_desc'] 			= 'SMTP 密碼';

$lang['settings:mail_smtp_port'] 				= 'SMTP Port';
$lang['settings:mail_smtp_port_desc'] 			= 'SMTP 通訊埠號';

$lang['settings:mail_smtp_user'] 				= 'SMTP User Name';
$lang['settings:mail_smtp_user_desc'] 			= 'SMTP 使用者名稱';

$lang['settings:unavailable_message']			= '網站關閉訊息';
$lang['settings:unavailable_message_desc'] 		= '當網站關閉或有重大問題時，這段訊息將會顯示給前端網站的瀏覽者。';

$lang['settings:default_theme'] 				= '預設佈景主題';
$lang['settings:default_theme_desc'] 			= '請選擇您希望用戶預設看到的網站佈景主題。';

$lang['settings:activation_email'] 				= '發送啟動信件';
$lang['settings:activation_email_desc'] 		= '當用戶註冊會員時，自動發送內含帳號啟動連結的信件。如果關閉這個項目，那麼只有管理員能夠啟動使用者帳戶。';

$lang['settings:records_per_page'] 				= '每頁顯示的資料數';
$lang['settings:records_per_page_desc'] 		= '在管理系統中，每頁所顯示的資料筆數。';

$lang['settings:rss_feed_items'] 				= 'Feed 項目數量';
$lang['settings:rss_feed_items_desc'] 			= '在 RSS/blog feeds 中所顯示的項目數量';


$lang['settings:enable_profiles'] 				= '啟用個人簡介';
$lang['settings:enable_profiles_desc'] 			= '讓用戶能夠編輯自己的個人簡介。';

$lang['settings:ga_email'] 						= 'Google Analytic E-mail';
$lang['settings:ga_email_desc']					= '申請 Google Analytics 的電子郵件，正確設定才能在控制台中顯示分析圖表。';

$lang['settings:ga_password'] 					= 'Google Analytic Password';
$lang['settings:ga_password_desc']				= 'Google Analytics 密碼，正確設定才能在控制台中顯示分析圖表。';

$lang['settings:ga_profile'] 					= 'Google Analytic Profile';
$lang['settings:ga_profile_desc']				= 'Google Analytics 中的 Profile ID 代號。';

$lang['settings:ga_tracking'] 					= 'Google 網站追蹤碼';
$lang['settings:ga_tracking_desc']				= '請輸入您的 Tracking Code 來啟用 Google Analytics 的資料讀取。例如：UA-19483569-6';

$lang['settings:akismet_api_key'] 				= 'Akismet API Key';
$lang['settings:akismet_api_key_desc'] 			= 'Akismet 是由 WordPress 團隊所提供，一個阻擋垃圾訊息入侵的機制。它會使垃圾訊息受到控制，卻不用一般強制用戶輸入檢查碼的方式。';

$lang['settings:comment_order'] 				= '回應順序';
$lang['settings:comment_order_desc']			= '顯示回應的排序';

$lang['settings:enable_comments'] 				= '請用回應';
$lang['settings:enable_comments_desc']			= '是否允許用戶張貼回應？';

$lang['settings:moderate_comments'] 			= '審核回應/評論';
$lang['settings:moderate_comments_desc']		= '強制所有的回應都必須通過審核才會顯示在網站上。';

$lang['settings:comment_markdown']				= '允許 Markdown';
$lang['settings:comment_markdown_desc']			= '您允許訪客使用 Markdown 張貼回應？';

$lang['settings:version'] 						= '版本';
$lang['settings:version_desc'] 					= '';

$lang['settings:site_public_lang']				= '前端的語言';
$lang['settings:site_public_lang_desc']			= '這個網站前端支援什麼語言？';

$lang['settings:admin_force_https']				= '在管理後台強制使用 HTTPS？';
$lang['settings:admin_force_https_desc']		= '只允許使用 HTTPS 協定來使用此管理後台？';

$lang['settings:files_cache']					= '檔案暫存';
$lang['settings:files_cache_desc']				= '當您透過 site.com/files 來輸出圖片時，系統應該設定的暫存時效是？';

$lang['settings:auto_username']					= '自動的 Username';
$lang['settings:auto_username_desc']			= '自動為用戶建立 username，代表使用者可在註冊時略過這個步驟。';

$lang['settings:registered_email']				= '發送註冊通知';
$lang['settings:registered_email_desc']			= '當有人註冊時，寄送通知信到網站預設信箱。';

$lang['settings:ckeditor_config']               = 'CKEditor 设置';
$lang['settings:ckeditor_config_desc']          = '您可以从 <a target="_blank" href="http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html">CKEditor\'s 文档.</a> 找到所有的设置选项'; #translate

$lang['settings:enable_registration']           = '启动用户注册功能';
$lang['settings:enable_registration_desc']      = '运行新用户在本网站注册.';

$lang['settings:profile_visibility']            = 'Profile Visibility'; #translate
$lang['settings:profile_visibility_desc']       = 'Specify who can view user profiles on the public site'; #translate

$lang['settings:cdn_domain']                    = 'CDN 域名'; 
$lang['settings:cdn_domain_desc']               = 'CDN 域名允许你卸载各种边缘服务器的静态内容, 像Amazon CloudFront或 MaxCDN一样.';

#section titles
$lang['settings:section_general']				= '一般';
$lang['settings:section_integration']			= '整合';
$lang['settings:section_comments']				= '回應';
$lang['settings:section_users']					= '用戶';
$lang['settings:section_statistics']			= '統計';
$lang['settings:section_files']					= '檔案';

#checkbox and radio options
$lang['settings:form_option_Open']				= '開啟';
$lang['settings:form_option_Closed']			= '關閉';
$lang['settings:form_option_Enabled']			= '啟用';
$lang['settings:form_option_Disabled']			= '禁用';
$lang['settings:form_option_Required']			= '必要';
$lang['settings:form_option_Optional']			= '可選擇';
$lang['settings:form_option_Oldest First']		= '最舊優先';
$lang['settings:form_option_Newest First']		= '最新優先';
$lang['settings:form_option_Text Only']			= '僅限純文字';
$lang['settings:form_option_Allow Markdown']	= '允許 Markdown';
$lang['settings:form_option_Yes']				= '是';
$lang['settings:form_option_No']				= '否';

// titles
$lang['settings:edit_title'] 					= '編輯設定';

// messages
$lang['settings:no_settings']					= '目前沒有設定';
$lang['settings:save_success'] 					= '您的設定已經儲存';

/* End of file settings_lang.php */