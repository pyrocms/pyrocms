<?php defined('BASEPATH') OR exit('No direct script access allowed');

#section settings
$lang['settings:site_name']						= 'שם האתר';
$lang['settings:site_name_desc']				= 'השם של האתר עבור כותרות הדף לשימוש ברחבי האתר.';

$lang['settings:site_slogan']					= 'סלוגן האתר';
$lang['settings:site_slogan_desc']				= 'הסלוגן של האתר עבור כותרות הדף לשימוש בסביבה והאתר.';

$lang['settings:contact_email']					= 'דואר אלקטרוני ליצירת קשר';
$lang['settings:contact_email_desc']			= 'כל הודעות דואר אלקטרוני של משתמשים, אורחים והאתר יעבור לכתובת דואר אלקטרוני זו.';

$lang['settings:server_email']					= 'Server E-mail';
$lang['settings:server_email_desc']				= 'כל הדואר האלקטרוני למשתמשים יישלח מכאן.';

$lang['settings:meta_topic']					= 'Meta Topic';
$lang['settings:meta_topic_desc']				= 'שתיים או שלוש מילים לתאר את סוג של חברה / אתר אינטרנט.';

$lang['settings:currency']						= 'מטבע';
$lang['settings:currency_desc']					= 'The currency symbol for use on products, services, etc.';

$lang['settings:dashboard_rss']					= 'לוח המחוונים RSS Feed';
$lang['settings:dashboard_rss_desc']			= 'הקישור להזנת RSS, אשר יוצגו על לוח המחוונים.';

$lang['settings:dashboard_rss_count']			= 'RSS פריטים';
$lang['settings:dashboard_rss_count_desc']		= 'כמה פריטים RSS ברצונכם להציג על לוח המחוונים?';

$lang['settings:date_format']					= 'תבנית תאריך';
$lang['settings:date_format_desc']				= 'כיצד התאריכים אמורה להיות מוצגת על פני האתר בלוח הבקרה?' .
													'Using the <a href="http://php.net/manual/en/function.date.php" target="_black">date format</a> from PHP - OR - ' .
													'Using the format of <a href="http://php.net/manual/en/function.strftime.php" target="_black">strings formated as date</a> from PHP.';

$lang['settings:frontend_enabled']				= 'סטטוס האתר';
$lang['settings:frontend_enabled_desc']			= 'השתמש באפשרות זו כדי לחלק הפונים למשתמש באתר או לבטל. שימושי כאשר אתה רוצה לקחת האתר השבתה לצורכי תחזוקה';

$lang['settings:mail_protocol']					= 'Mail Protocol';
$lang['settings:mail_protocol_desc']			= 'Select desired email protocol.';

$lang['settings:mail_sendmail_path']			= 'Sendmail Path';
$lang['settings:mail_sendmail_path_desc']		= 'Path to server sendmail binary.';

$lang['settings:mail_smtp_host']				= 'SMTP Host';
$lang['settings:mail_smtp_host_desc']			= 'The host name of your smtp server.';

$lang['settings:mail_smtp_pass']				= 'SMTP password';
$lang['settings:mail_smtp_pass_desc']			= 'SMTP password.';

$lang['settings:mail_smtp_port'] 				= 'SMTP Port';
$lang['settings:mail_smtp_port_desc'] 			= 'SMTP port number.';

$lang['settings:mail_smtp_user'] 				= 'SMTP User Name';
$lang['settings:mail_smtp_user_desc'] 			= 'SMTP user name.';

$lang['settings:unavailable_message']			= 'הודעת כיבוי';
$lang['settings:unavailable_message_desc']		= 'כאשר האתר הוא כבוי או שיש בעיה רצינית, הודעה תוצג בפני משתמשים.';

$lang['settings:default_theme']					= 'סגנון ברירת מחדל';
$lang['settings:default_theme_desc']			= 'בחר את הנושא הרצוי למשתמשים לראות כברירת מחדל.';

$lang['settings:activation_email']				= 'Activation Email';
$lang['settings:activation_email_desc']			= 'שלח את הודעת דואר אלקטרוני כאשר משתמש מצטרף עם הקישור הפעלה. השבת כדי לתת מנהלים רק להפעיל את החשבונות.';

$lang['settings:records_per_page']				= 'רשומות לעמוד.';
$lang['settings:records_per_page_desc']			= 'כמה שיאים אנחנו צריכים להראות בכל עמוד באיזור הניהול?';

$lang['settings:rss_feed_items']				= 'מספר פריטי RSS';
$lang['settings:rss_feed_items_desc']			= 'כמה פריטי RSS או בלוג להראות?';


$lang['settings:enable_profiles']				= 'אפשר פרופילים';
$lang['settings:enable_profiles_desc']			= 'לאפשר למשתמשים להוסיף ולערוך פרופילים.';

$lang['settings:ga_email']						= 'Google Analytic E-mail';
$lang['settings:ga_email_desc']					= 'כתובת דואר אלקטרוני השתמשת ב-Google Analytics, אנחנו צריכים את זה כדי להראות את הגרף על לוח המחוונים.';

$lang['settings:ga_password']					= 'Google Analytic Password';
$lang['settings:ga_password_desc']				= 'Google Analytics הסיסמה. זה נדרש גם כדי להראות את הגרף על לוח המחוונים.';

$lang['settings:ga_profile']					= 'Google Analytic Profile';
$lang['settings:ga_profile_desc']				= 'פרופיל מזהה באתר אינטרנט זה ב-Google Analytics.';

$lang['settings:ga_tracking']					= 'Google Tracking Code';
$lang['settings:ga_tracking_desc']				= 'טראקינג קוד של גוגל אנליטיקס. E.g: UA-19483569-6';

$lang['settings:akismet_api_key']				= 'Akismet API Key';
$lang['settings:akismet_api_key_desc']			= 'Akismet is a spam-blocker from the WordPress team. It keeps spam under control without forcing users to get past human-checking CAPTCHA forms.';

$lang['settings:comment_order']					= 'סדר תגובות';
$lang['settings:comment_order_desc']			= 'סדר הצגת תגובות.';
	
$lang['settings:moderate_comments']				= 'נהל תגובות';
$lang['settings:moderate_comments_desc']		= 'תגובות קודם עוברות מודרציה ורק לאחר מכן מופיעות באתר.';

$lang['settings:version']						= 'גירסה';
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
$lang['settings:section_general']				= 'כללי';
$lang['settings:section_integration']			= 'השתלבות';
$lang['settings:section_comments']				= 'תגובות';
$lang['settings:section_users']					= 'משתמשים';
$lang['settings:section_statistics']			= 'סטטיסטיקה';

#checkbox and radio options
$lang['settings:form_option_Open']				= 'פתוח';
$lang['settings:form_option_Closed']			= 'סגור';
$lang['settings:form_option_Enabled']			= 'פעול';
$lang['settings:form_option_Disabled']			= 'לא פועל';
$lang['settings:form_option_Required']			= 'חובה';
$lang['settings:form_option_Optional']			= 'רשות';
$lang['settings:form_option_Oldest First']		= 'קודם ישנים'; #translate
$lang['settings:form_option_Newest First']		= 'קודם חדשים'; #translate

// titles
$lang['settings:edit_title']					= 'ערוך הגדרות';

// messages
$lang['settings:no_settings']					= 'There are currently no settings.'; #translate
$lang['settings:save_success']					= 'ההגדרות שלך נשמרו בהצלחה!';

/* End of file settings_lang.php */