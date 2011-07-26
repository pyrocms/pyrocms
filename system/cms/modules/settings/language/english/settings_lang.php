<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['settings_save_success']					= 'Your settings were saved!';
$lang['settings_edit_title']					= 'Edit settings';

#section settings
$lang['settings_site_name']						= 'Site Name';
$lang['settings_site_name_desc']				= 'The name of the website for page titles and for use around the site.';

$lang['settings_site_slogan']					= 'Site Slogan';
$lang['settings_site_slogan_desc']				= 'The slogan of the website for page titles and for use around the site.';

$lang['settings_site_lang']						= 'Site Language';
$lang['settings_site_lang_desc']				= 'The native language of the website, used to choose templates of e-mail notifications, contact form, and other features that should not depend on the language of a user.';

$lang['settings_contact_email']					= 'Contact E-mail';
$lang['settings_contact_email_desc']			= 'All e-mails from users, guests and the site will go to this e-mail address.';

$lang['settings_server_email']					= 'Server E-mail';
$lang['settings_server_email_desc']				= 'All e-mails to users will come from this e-mail address.';

$lang['settings_meta_topic']					= 'Meta Topic';
$lang['settings_meta_topic_desc']				= 'Two or three words describing this type of company/website.';

$lang['settings_currency']						= 'Currency';
$lang['settings_currency_desc']					= 'The currency symbol for use on products, services, etc.';

$lang['settings_dashboard_rss']					= 'Dashboard RSS Feed';
$lang['settings_dashboard_rss_desc']			= 'Link to an RSS feed that will be displayed on the dashboard.';

$lang['settings_dashboard_rss_count']			= 'Dashboard RSS Items';
$lang['settings_dashboard_rss_count_desc']		= 'How many RSS items would you like to display on the dashboard ?';

$lang['settings_date_format']					= 'Date Format';
$lang['settings_date_format_desc']				= 'How should dates be displayed across the website and control panel? Using the <a target="_blank" href="http://php.net/manual/en/function.date.php">date format</a> from PHP - OR - Using the format of <a target="_blank" href="http://php.net/manual/en/function.strftime.php">strings formatted as date</a> from PHP.';

$lang['settings_frontend_enabled']				= 'Site Status';
$lang['settings_frontend_enabled_desc']			= 'Use this option to the user-facing part of the site on or off. Useful when you want to take the site down for maintenence';

$lang['settings_mail_protocol']					= 'Mail Protocol';
$lang['settings_mail_protocol_desc']			= 'Select desired email protocol.';

$lang['settings_mail_sendmail_path']			= 'Sendmail Path';
$lang['settings_mail_sendmail_path_desc']		= 'Path to server sendmail binary.';

$lang['settings_mail_smtp_host']				= 'SMTP Host';
$lang['settings_mail_smtp_host_desc']			= 'The host name of your smtp server.';

$lang['settings_mail_smtp_pass']				= 'SMTP password';
$lang['settings_mail_smtp_pass_desc']			= 'SMTP password.';

$lang['settings_mail_smtp_port'] 				= 'SMTP Port';
$lang['settings_mail_smtp_port_desc'] 			= 'SMTP port number.';

$lang['settings_mail_smtp_user'] 				= 'SMTP User Name';
$lang['settings_mail_smtp_user_desc'] 			= 'SMTP user name.';

$lang['settings_unavailable_message']			= 'Unavailable Message';
$lang['settings_unavailable_message_desc']		= 'When the site is turned off or there is a major problem, this message will show to users.';

$lang['settings_default_theme']					= 'Default Theme';
$lang['settings_default_theme_desc']			= 'Select the theme you want users to see by default.';

$lang['settings_activation_email']				= 'Activation Email';
$lang['settings_activation_email_desc']			= 'Send out an e-mail when a user signs up with an activation link. Disable this to let only admins activate accounts.';

$lang['settings_records_per_page']				= 'Records Per Page';
$lang['settings_records_per_page_desc']			= 'How many records should we show per page in the admin section?';

$lang['settings_rss_feed_items']				= 'Feed item count';
$lang['settings_rss_feed_items_desc']			= 'How many items should we show in RSS/blog feeds?';

$lang['settings_require_lastname']				= 'Require last names?';
$lang['settings_require_lastname_desc']			= 'For some situations, a last name may not be required. Do you want to force users to enter one or not?';

$lang['settings_enable_profiles']				= 'Enable profiles';
$lang['settings_enable_profiles_desc']			= 'Allow users to add and edit profiles.';

$lang['settings_ga_email']						= 'Google Analytic E-mail';
$lang['settings_ga_email_desc']					= 'E-mail address used for Google Analytics, we need this to show the graph on the dashboard.';

$lang['settings_ga_password']					= 'Google Analytic Password';
$lang['settings_ga_password_desc']				= 'Google Analytics password. This is also needed this to show the graph on the dashboard.';

$lang['settings_ga_profile']					= 'Google Analytic Profile';
$lang['settings_ga_profile_desc']				= 'Profile ID for this website in Google Analytics.';

$lang['settings_ga_tracking']					= 'Google Tracking Code';
$lang['settings_ga_tracking_desc']				= 'Enter your Google Analytic Tracking Code to activate Google Analytics view data capturing. E.g: UA-19483569-6';

$lang['settings_twitter_username']				= 'Username';
$lang['settings_twitter_username_desc']			= 'Twitter username.';

$lang['settings_twitter_consumer_key']			= 'Consumer Key';
$lang['settings_twitter_consumer_key_desc']		= 'Twitter consumer key.';

$lang['settings_twitter_consumer_key_secret']	= 'Consumer Key Secret';
$lang['settings_twitter_consumer_key_secret_desc'] = 'Twitter consumer key secret.';

$lang['settings_twitter_blog']					= 'Twitter &amp; Blog integration.';
$lang['settings_twitter_blog_desc']				= 'Would you like to post links to new blog articles on Twitter?';

$lang['settings_twitter_feed_count']			= 'Feed Count';
$lang['settings_twitter_feed_count_desc']		= 'How many tweets should be returned to the Twitter feed block?';

$lang['settings_twitter_cache']					= 'Cache time';
$lang['settings_twitter_cache_desc']			= 'How many minutes should your Tweets be stored?';

$lang['settings_akismet_api_key']				= 'Akismet API Key';
$lang['settings_akismet_api_key_desc']			= 'Akismet is a spam-blocker from the WordPress team. It keeps spam under control without forcing users to get past human-checking CAPTCHA forms.';

$lang['settings_comment_order']					= 'Comment Order';
$lang['settings_comment_order_desc']			= 'Sort order in which to display comments.';
	
$lang['settings_moderate_comments']				= 'Moderate Comments';
$lang['settings_moderate_comments_desc']		= 'Force comments to be approved before they appear on the site.';

$lang['settings_version']						= 'Version';
$lang['settings_version_desc']					= '';

#section titles
$lang['settings_section_general']				= 'General';
$lang['settings_section_integration']			= 'Integration';
$lang['settings_section_comments']				= 'Comments';
$lang['settings_section_users']					= 'Users';
$lang['settings_section_statistics']			= 'Statistics';
$lang['settings_section_twitter']				= 'Twitter';

#checkbox and radio options
$lang['settings_form_option_Open']				= 'Open';
$lang['settings_form_option_Closed']			= 'Closed';
$lang['settings_form_option_Enabled']			= 'Enabled';
$lang['settings_form_option_Disabled']			= 'Disabled';
$lang['settings_form_option_Required']			= 'Required';
$lang['settings_form_option_Optional']			= 'Optional';
$lang['settings_form_option_Oldest First']		= 'Oldest First'; #translate
$lang['settings_form_option_Newest First']		= 'Newest First'; #translate

/* End of file settings_lang.php */
/* Location: ./system/cms/modules/settings/language/english/settings_lang.php */
