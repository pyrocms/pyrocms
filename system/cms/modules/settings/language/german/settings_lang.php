<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['settings_save_success']					= 'Deine Einstellungen wurden gesichert!';
$lang['settings_edit_title']					= 'Einstellungen bearbeiten';

#section settings
$lang['settings_site_name']						= 'Name der Seite';
$lang['settings_site_name_desc']				= 'Der Name der Seite zur Anzeige auf der kompletten Web-Präsenz.';

$lang['settings_site_slogan']					= 'Slogan der Seite';
$lang['settings_site_slogan_desc']				= 'Der Sloagen der Seite zur Anzeige auf der kompletten Web-Präsenz.';

$lang['settings_site_lang']						= 'Site Language'; #translate
$lang['settings_site_lang_desc']				= 'The native language of the website, used to choose templates of e-mail internal notifications and receiving visitors contact and other features that should not bend the language of a user.'; #translate

$lang['settings_contact_email']					= 'Kontakt-Email';
$lang['settings_contact_email_desc']			= 'Sämtliche E-Mail von Benutzern und Gästen, sowie von der Seite allgemein werden an diese E-Mail-Adresse versendet.';

$lang['settings_server_email']					= 'Server-Email';
$lang['settings_server_email_desc']				= 'Sämtliche E-Mails, die an Benutzer der Seite versendet werden, nutzen diese E-Mail als Absender.';

$lang['settings_meta_topic']					= 'Meta-Beschreibung';
$lang['settings_meta_topic_desc']				= 'Zwei oder drei Wörter, welche die Seite oder das Unternehmen kurz beschreiben.';

$lang['settings_currency']						= 'Währung';
$lang['settings_currency_desc']					= 'Das Symbol der Währung, welches auf der Seite genutzt werden soll.';

$lang['settings_dashboard_rss']					= 'RRS-Feed der Admin-Oberfläche';
$lang['settings_dashboard_rss_desc']			= 'Link zu einem RSS-Feed, welches auf der Admin-Oberfläche angezeigt werden soll.';

$lang['settings_dashboard_rss_count']			= 'Anzahl der RRS-Feeds';
$lang['settings_dashboard_rss_count_desc']		= 'Wie viele Feeds sollen auf der Admin-Oberfläche maximal angezeigt werden?';

$lang['settings_date_format']					= 'Date Format'; #translate
$lang['settings_date_format_desc']				= 'How should dates be displayed accross the website and control panel? ' .
													'Using the <a href="http://php.net/manual/en/function.date.php" target="_black">date format</a> from PHP - OR - ' .
													'Using the format of <a href="http://php.net/manual/en/function.strftime.php" target="_black">strings formated as date</a> from PHP.'; #translate

$lang['settings_frontend_enabled']				= 'Status der Seite';
$lang['settings_frontend_enabled_desc']			= 'Nutze diese Option um die Seite für Nutzer unerreichbar zu machen. Nützlich für Wartungen der Seite.';

$lang['settings_mail_protocol']					= 'Mail Protocol'; #translate
$lang['settings_mail_protocol_desc']			= 'Select desired email protocol.'; #translate

$lang['settings_mail_sendmail_path']			= 'Sendmail Path'; #translate
$lang['settings_mail_sendmail_path_desc']		= 'Path to server sendmail binary.'; #translate

$lang['settings_mail_smtp_host']				= 'Mail Protocol'; #translate
$lang['settings_mail_smtp_host_desc']			= 'The host name of your smtp server.'; #translate

$lang['settings_mail_smtp_pass']				= 'SMTP password'; #translate
$lang['settings_mail_smtp_pass_desc']			= 'SMTP password.'; #translate

$lang['settings_mail_smtp_port']				= 'SMTP Port'; #translate
$lang['settings_mail_smtp_port_desc']			= 'SMTP port number.'; #translate

$lang['settings_mail_smtp_user']				= 'SMTP User Name'; #translate
$lang['settings_mail_smtp_user_desc']			= 'SMTP user name.'; #translate

$lang['settings_unavailable_message']			= 'Nachricht zur Unerreichbarkeit';
$lang['settings_unavailable_message_desc']		= 'Diese Nachricht wird den Benutzern angezeigt, sollte die Seite deaktiviert sein oder ein bedeutendes Problem vorliegen.';

$lang['settings_default_theme']					= 'Standart Design';
$lang['settings_default_theme_desc']			= 'Wähle das Design, welches dem Benutzer standartmäßig angezeigt wird.';

$lang['settings_activation_email']				= 'E-Mail Aktivierung';
$lang['settings_activation_email_desc']			= 'Verschickt zur Aktivierung des Accounts eine E-Mail an den neu registrierten Benutzer. Deaktiviere diese Option sofern die Accounts der Benutzer manuell von Admins freigeschaltet werden sollen.';

$lang['settings_records_per_page']				= 'Einträge per Seite';
$lang['settings_records_per_page_desc']			= 'Wie viele Einträge sollen auf der Admin-Oberfläche per Seite angezeigt werden?';

$lang['settings_rss_feed_items']				= 'RSS-Feed Anzahl';
$lang['settings_rss_feed_items_desc']			= 'Wie viele Einträge sollen im RSS/News-Bereich der Seite angezeigt werden?';

$lang['settings_require_lastname']				= 'Nachnamen sind Pflicht?';
$lang['settings_require_lastname_desc']			= 'In manchen Sitationen werden Nachnamen der Benutzer nicht benötigt. Möchtest du die Angabe der Nachnamen der Benutzer erzwingen?';

$lang['settings_enable_profiles']				= 'Profile aktivieren';
$lang['settings_enable_profiles_desc']			= 'Erlaubt das Erstellen und Bearbeiten von Benutzer-Profilen.';

$lang['settings_ga_email']						= 'Google Analytic E-mail'; #translate
$lang['settings_ga_email_desc']					= 'E-mail address used for Google Analytics, we need this to show the graph on the dashboard.'; #translate

$lang['settings_ga_password']					= 'Google Analytic Password'; #translate
$lang['settings_ga_password_desc']				= 'Google Analytics password. This is also needed this to show the graph on the dashboard.'; #translate

$lang['settings_ga_profile'] 					= 'Google Analytic Profile'; #translate
$lang['settings_ga_profile_desc']				= 'Profile ID for this website in Google Analytics.'; #translate

$lang['settings_ga_tracking']					= 'Google Tracking Code'; #translate
$lang['settings_ga_tracking_desc']				= 'Enter your Google Analytic Tracking Code to activate Google Analytics view data capturing. E.g: UA-19483569-6'; #translate

$lang['settings_twitter_username']				= 'Twitter-Benutzername';
$lang['settings_twitter_username_desc']			= 'Dein Twitter-Benutzername.';

$lang['settings_twitter_consumer_key']			= 'Nutzungsschlüssel';
$lang['settings_twitter_consumer_key_desc']		= 'Dein Nutzungsschlüssel.';

$lang['settings_twitter_consumer_key_secret']	= 'Sicherer Nutzungsschlüssel';
$lang['settings_twitter_consumer_key_secret_desc'] = 'Dein sicherer Nutzungsschlüssel.';

$lang['settings_twitter_blog']					= 'Twitter &amp; News-Intigrierung.';
$lang['settings_twitter_blog_desc']				= 'Möchtest du Links zu neuen News auf Twitter posten?';
	
$lang['settings_twitter_feed_count']			= 'Anzahl der Feeds';
$lang['settings_twitter_feed_count_desc']		= 'Wie viele Tweets sollen im Twitter-Block maximal angezeigt werden?';

$lang['settings_twitter_cache']					= 'Dauer im Cache';
$lang['settings_twitter_cache_desc']			= 'Wie lange sollen deine Tweets temporär im Cache gesichert werden?';

$lang['settings_akismet_api_key']				= 'Akismet API Schlüssel';
$lang['settings_akismet_api_key_desc']			= 'Akismet ist ein Spam-Blocker der Wordpress-Entwickler. Es hält Spam unter Kontrolle ohne das Benutzer Captchas nutzen müssen.';

$lang['settings_comment_order']					= 'Comment Order'; #translate
$lang['settings_comment_order_desc']			= 'Sort order in which to display comments.'; #translate

$lang['settings_moderate_comments']				= 'Kommentare moderieren';
$lang['settings_moderate_comments_desc']		= 'Kommentare müssen vorher von einem Moderator oder Admin überprüft werden, bevor sie für alle Benutzer der Seite sichtbar werden.';

$lang['settings_version']						= 'Version';
$lang['settings_version_desc']					= '';

#section titles
$lang['settings_section_general']				= 'Allgemein';
$lang['settings_section_integration']			= 'Integrierung';
$lang['settings_section_comments']				= 'Comments'; #translate
$lang['settings_section_users']					= 'Benutzer';
$lang['settings_section_statistics']			= 'Statistiken';
$lang['settings_section_twitter']				= 'Twitter';

#checkbox and radio options
$lang['settings_form_option_Open']				= 'Geöffnet';
$lang['settings_form_option_Closed']			= 'Geschlossen';
$lang['settings_form_option_Enabled']			= 'Aktiviert';
$lang['settings_form_option_Disabled']			= 'Deaktiviert';
$lang['settings_form_option_Required']			= 'Benötigt';
$lang['settings_form_option_Optional']			= 'Optional';
$lang['settings_form_option_Oldest First']		= 'Oldest First'; #translate
$lang['settings_form_option_Newest First']		= 'Newest First'; #translate

/* End of file settings_lang.php */
/* Location: ./system/cms/modules/settings/language/german/settings_lang.php */
