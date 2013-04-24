<?php defined('BASEPATH') OR exit('No direct script access allowed');

#section settings
$lang['settings:site_name']						= 'Site Name';
$lang['settings:site_name_desc']				= 'The name of the website for page titles and for use around the site.';

$lang['settings:site_slogan']					= 'Site Slogan';
$lang['settings:site_slogan_desc']				= 'The slogan of the website for page titles and for use around the site.';

$lang['settings:site_lang']						= 'Site Language';
$lang['settings:site_lang_desc']				= 'The native language of the website, used to choose templates of e-mail notifications, contact form, and other features that should not depend on the language of a user.';

$lang['settings:contact_email']					= 'Contact E-mail';
$lang['settings:contact_email_desc']			= 'All e-mails from users, guests and the site will go to this e-mail address.';

$lang['settings:server_email']					= 'Server E-mail';
$lang['settings:server_email_desc']				= 'All e-mails to users will come from this e-mail address.';

$lang['settings:meta_topic']					= 'Meta Topic';
$lang['settings:meta_topic_desc']				= 'Two or three words describing this type of company/website.';

$lang['settings:currency']						= 'Currency';
$lang['settings:currency_desc']					= 'The currency symbol for use on products, services, etc.';

$lang['settings:dashboard_rss']					= 'Dashboard RSS Feed';
$lang['settings:dashboard_rss_desc']			= 'Link to an RSS feed that will be displayed on the dashboard.';

$lang['settings:dashboard_rss_count']			= 'Dashboard RSS Items';
$lang['settings:dashboard_rss_count_desc']		= 'How many RSS items would you like to display on the dashboard ?';

$lang['settings:date_format']					= 'Date Format';
$lang['settings:date_format_desc']				= 'How should dates be displayed across the website and control panel? Using the <a target="_blank" href="http://php.net/manual/en/function.date.php">date format</a> from PHP - OR - Using the format of <a target="_blank" href="http://php.net/manual/en/function.strftime.php">strings formatted as date</a> from PHP.';

$lang['settings:frontend_enabled']				= 'Site Status';
$lang['settings:frontend_enabled_desc']			= 'Use this option to the user-facing part of the site on or off. Useful when you want to take the site down for maintenence';

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

$lang['settings:unavailable_message']			= 'Unavailable Message';
$lang['settings:unavailable_message_desc']		= 'When the site is turned off or there is a major problem, this message will show to users.';

$lang['settings:default_theme']					= 'Default Theme';
$lang['settings:default_theme_desc']			= 'Select the theme you want users to see by default.';

$lang['settings:activation_email']				= 'Activation Email';
$lang['settings:activation_email_desc']			= 'Send out an e-mail when a user signs up with an activation link. Disable this to let only admins activate accounts.';

$lang['settings:records_per_page']				= 'Records Per Page';
$lang['settings:records_per_page_desc']			= 'How many records should we show per page? (both for frontend and for admin section) e.g.: blog posts, users etc.';

$lang['settings:rss_feed_items']				= 'Feed item count';
$lang['settings:rss_feed_items_desc']			= 'How many items should we show in RSS/blog feeds?';


$lang['settings:enable_profiles']				= 'Enable profiles';
$lang['settings:enable_profiles_desc']			= 'Allow users to add and edit profiles.';

$lang['settings:ga_email']						= 'Google Analytic E-mail';
$lang['settings:ga_email_desc']					= 'E-mail address used for Google Analytics, we need this to show the graph on the dashboard.';

$lang['settings:ga_password']					= 'Google Analytic Password';
$lang['settings:ga_password_desc']				= 'Google Analytics password. This is also needed to show the graph on the dashboard. You will need to allow access to Google to get this to work. See <a href="https://accounts.google.com/b/0/IssuedAuthSubTokens?hl=en_US" target="_blank">Authorized Access to your Google Account</a>';

$lang['settings:ga_profile']					= 'Google Analytic Profile';
$lang['settings:ga_profile_desc']				= 'Profile ID for this website in Google Analytics. Look in the URL when signed into Google Analytics for something that looks like "pXXXXXXXX". The, "<em>XXXXXXXX</em>" is the profile ID. ';

$lang['settings:ga_tracking']					= 'Google Tracking Code';
$lang['settings:ga_tracking_desc']				= 'Enter your Google Analytic Tracking Code to activate Google Analytics view data capturing. E.g: UA-19483569-6';

$lang['settings:twitter_username']				= 'Username';
$lang['settings:twitter_username_desc']			= 'Twitter username.';

$lang['settings:twitter_feed_count']			= 'Feed Count';
$lang['settings:twitter_feed_count_desc']		= 'How many tweets should be returned to the Twitter feed block?';

$lang['settings:twitter_cache']					= 'Cache time';
$lang['settings:twitter_cache_desc']			= 'How many seconds should your Tweets be stored?';

$lang['settings:akismet_api_key']				= 'Akismet API Key';
$lang['settings:akismet_api_key_desc']			= 'Akismet is a spam-blocker from the WordPress team. It keeps spam under control without forcing users to get past human-checking CAPTCHA forms.';

$lang['settings:comment_order']					= 'Comment Order';
$lang['settings:comment_order_desc']			= 'Sort order in which to display comments:';

$lang['settings:enable_comments'] 				= 'Enable Comments';
$lang['settings:enable_comments_desc']			= 'Allow users to post comments?';
	
$lang['settings:moderate_comments']				= 'Moderate Comments';
$lang['settings:moderate_comments_desc']		= 'Force comments to be approved before they appear on the site.';

$lang['settings:comment_markdown']				= 'Allow Markdown';
$lang['settings:comment_markdown_desc']			= 'Do you want to allow visitors to post comments using Markdown?';

$lang['settings:version']						= 'Version';
$lang['settings:version_desc']					= '';

$lang['settings:site_public_lang']				= 'Public Languages';
$lang['settings:site_public_lang_desc']			= 'Which are the languages really supported and offered on the front-end of your website?';

$lang['settings:admin_force_https']				= 'Force HTTPS for Control Panel?';
$lang['settings:admin_force_https_desc']		= 'Allow only the HTTPS protocol when using the Control Panel?';

$lang['settings:files_cache']					= 'Files Cache';
$lang['settings:files_cache_desc']				= 'When outputting an image via site.com/files what shall we set the cache expiration for?';

$lang['settings:auto_username']					= 'Auto Username';
$lang['settings:auto_username_desc']			= 'Create the username automatically, meaning users can skip making one on registration.';

$lang['settings:registered_email']				= 'User Registered Email';
$lang['settings:registered_email_desc']			= 'Send a notification email to the contact e-mail when someone registers.';

$lang['settings:ckeditor_config']               = 'CKEditor Config';
$lang['settings:ckeditor_config_desc']          = 'You can find a list of valid configuration items in <a target="_blank" href="http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html">CKEditor\'s documentation</a>.';

$lang['settings:enable_registration']           = 'Enable user registration';
$lang['settings:enable_registration_desc']      = 'Allow users to register in your site.';

$lang['settings:profile_visibility']            = 'Profile Visibility'; #translate
$lang['settings:profile_visibility_desc']       = 'Specify who can view user profiles on the public site'; #translate

$lang['settings:cdn_domain']                    = 'CDN Domain';
$lang['settings:cdn_domain_desc']               = 'CDN domains allow you to offload static content to various edge servers, like Amazon CloudFront or MaxCDN.';

# section titles
$lang['settings:section_general']				= 'General';
$lang['settings:section_integration']			= 'Integration';
$lang['settings:section_comments']				= 'Comments';
$lang['settings:section_users']					= 'Users';
$lang['settings:section_statistics']			= 'Statistics';
$lang['settings:section_twitter']				= 'Twitter';
$lang['settings:section_files']					= 'Files';

# checkbox and radio options
$lang['settings:form_option_Open']				= 'Open';
$lang['settings:form_option_Closed']			= 'Closed';
$lang['settings:form_option_Enabled']			= 'Enabled';
$lang['settings:form_option_Disabled']			= 'Disabled';
$lang['settings:form_option_Required']			= 'Required';
$lang['settings:form_option_Optional']			= 'Optional';
$lang['settings:form_option_Oldest First']		= 'Oldest First';
$lang['settings:form_option_Newest First']		= 'Newest First';
$lang['settings:form_option_Text Only']			= 'Text Only';
$lang['settings:form_option_Allow Markdown']	= 'Allow Markdown';
$lang['settings:form_option_Yes']				= 'Yes';
$lang['settings:form_option_No']				= 'No';
$lang['settings:form_option_profile_public']	= 'Visible to everybody';
$lang['settings:form_option_profile_owner']		= 'Only visible to the profile owner';
$lang['settings:form_option_profile_hidden']	= 'Never visible';
$lang['settings:form_option_profile_member']	= 'Visible to any logged in user';
$lang['settings:form_option_activate_by_email']				= 'Activate by email';
$lang['settings:form_option_activate_by_admin']				= 'Activate by admin';
$lang['settings:form_option_no_activation']				= 'Instant activation';

// messages
$lang['settings:no_settings']					= 'There are currently no settings.';
$lang['settings:save_success']					= 'Your settings were saved!';

/* End of file settings_lang.php */