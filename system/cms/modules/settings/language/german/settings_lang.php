<?php defined('BASEPATH') OR exit('No direct script access allowed');

#section settings
$lang['settings_site_name']                        = 'Name der Seite';
$lang['settings_site_name_desc']                = 'Der Name der Seite zur Anzeige auf der kompletten Web-Pr&auml;senz.';

$lang['settings_site_slogan']                    = 'Slogan der Seite';
$lang['settings_site_slogan_desc']                = 'Der Sloagen der Seite zur Anzeige auf der kompletten Web-Pr&auml;senz.';

$lang['settings_site_lang']                        = 'Sprache der Seite';
$lang['settings_site_lang_desc']                = 'Die Muttersprache der Seite. Wird verwendet um Templates f&uuml;r interne E-mail Benachrichtungen zu w&auml;hlen, Besucher Kontakte zu empfangen und andere Features die nicht von der Sprache des Benutzers beeinflusst werden sollen.';
#The native language of the website, used to choose templates of e-mail internal notifications and receiving visitors contact and other features that should not bend the language of a user.';#tricky one

$lang['settings_contact_email']                    = 'Kontakt-Email';
$lang['settings_contact_email_desc']            = 'S&auml;mtliche E-Mail von Benutzern und G&auml;sten, sowie von der Seite allgemein werden an diese E-Mail-Adresse versendet.';

$lang['settings_server_email']                    = 'Server-Email';
$lang['settings_server_email_desc']                = 'S&auml;mtliche E-Mails, die an Benutzer der Seite versendet werden, nutzen diese E-Mail als Absender.';

$lang['settings_meta_topic']                    = 'Meta-Beschreibung';
$lang['settings_meta_topic_desc']                = 'Zwei oder drei W&ouml;rter, welche die Seite oder das Unternehmen kurz beschreiben.';

$lang['settings_currency']                        = 'W&auml;hrung';
$lang['settings_currency_desc']                    = 'Das Symbol der W&auml;hrung, welches auf der Seite genutzt werden soll.';

$lang['settings_dashboard_rss']                    = 'RRS-Feed der Admin-Oberfl&auml;che';
$lang['settings_dashboard_rss_desc']            = 'Link zu einem RSS-Feed, welches auf der Admin-Oberfl&auml;che angezeigt werden soll.';

$lang['settings_dashboard_rss_count']            = 'Anzahl der RRS-Feeds';
$lang['settings_dashboard_rss_count_desc']        = 'Wie viele Feeds sollen auf der Admin-Oberfl&auml;che maximal angezeigt werden?';

$lang['settings_date_format']                    = 'Datumsformat';
$lang['settings_date_format_desc']                = 'Wie sollen Daten/Termine auf der Seite und auf der Admin-Oberfl&auml;che angezeigt werden? ' .
'Mit dem <a href="http://php.net/manual/de/function.date.php" target="_black">Datumsformat</a> von PHP - ODER - ' .
'Mit der Formatierung von <a href="http://php.net/manual/de/function.strftime.php" target="_black">Strings als Datum</a> von PHP.';

$lang['settings_frontend_enabled']                = 'Status der Seite';
$lang['settings_frontend_enabled_desc']            = 'Nutze diese Option um die Seite f&uuml;r Nutzer unerreichbar zu machen. N&uuml;tzlich f&uuml;r Wartungen der Seite.';

$lang['settings_mail_protocol']                    = 'E-mail Protokoll';
$lang['settings_mail_protocol_desc']            = 'Gew&uuml;nschtes E-mail Protokoll w&auml;hlen.';

$lang['settings_mail_sendmail_path']            = 'Sendmail Pfad';
$lang['settings_mail_sendmail_path_desc']        = 'Pfad zur ausf&uuml;hrbaren "sendmail" Datei auf dem Server.';

$lang['settings_mail_smtp_host']                = 'SMTP Host';
$lang['settings_mail_smtp_host_desc']            = 'Der Hostname deines SMTP Servers.';

$lang['settings_mail_smtp_pass']                = 'SMTP Passwort';
$lang['settings_mail_smtp_pass_desc']            = 'SMTP Passwort.';

$lang['settings_mail_smtp_port']                = 'SMTP Port';
$lang['settings_mail_smtp_port_desc']            = 'SMTP Portnummer.';

$lang['settings_mail_smtp_user']                = 'SMTP Benutzername';
$lang['settings_mail_smtp_user_desc']            = 'SMTP Benutzername.';

$lang['settings_unavailable_message']            = 'Nachricht bei Unerreichbarkeit';
$lang['settings_unavailable_message_desc']        = 'Diese Nachricht wird den Benutzern angezeigt, sollte die Seite deaktiviert sein oder ein bedeutendes Problem vorliegen.';

$lang['settings_default_theme']                    = 'Standart Design';
$lang['settings_default_theme_desc']            = 'W&auml;hle das Design, welches dem Benutzer standartm&auml;ßig angezeigt wird.';

$lang['settings_activation_email']                = 'E-Mail Aktivierung';
$lang['settings_activation_email_desc']            = 'Verschickt zur Aktivierung des Accounts eine E-Mail an den neu registrierten Benutzer. Deaktiviere diese Option sofern die Accounts der Benutzer manuell von Admins freigeschaltet werden sollen.';

$lang['settings_records_per_page']                = 'Eintr&auml;ge per Seite';
$lang['settings_records_per_page_desc']            = 'Wie viele Eintr&auml;ge sollen auf der Admin-Oberfl&auml;che per Seite angezeigt werden?';

$lang['settings_rss_feed_items']                = 'RSS-Feed Anzahl';
$lang['settings_rss_feed_items_desc']            = 'Wie viele Eintr&auml;ge sollen im RSS/News-Bereich der Seite angezeigt werden?';

$lang['settings_require_lastname']                = 'Nachnamen sind Pflicht?';
$lang['settings_require_lastname_desc']            = 'In manchen Sitationen werden Nachnamen der Benutzer nicht ben&ouml;tigt. M&ouml;chtest du die Angabe der Nachnamen der Benutzer erzwingen?';

$lang['settings_enable_profiles']                = 'Profile aktivieren';
$lang['settings_enable_profiles_desc']            = 'Erlaubt das Erstellen und Bearbeiten von Benutzer-Profilen.';

$lang['settings_ga_email']                        = 'Google Analytics E-mail';
$lang['settings_ga_email_desc']                    = 'E-mail Adresse die f&uuml;r Google Analytics verwendet wird. Wird ben&ouml;tigt um den Graphen im Dashboard anzuzeigen.';

$lang['settings_ga_password']                    = 'Google Analytics Passwort';
$lang['settings_ga_password_desc']                = 'Google Analytics Passwort. Wird auch f&uuml;r den Graphen im Dashboard ben&ouml;tigt.';

$lang['settings_ga_profile']                     = 'Google Analytics Profile';
$lang['settings_ga_profile_desc']                = 'Profil ID f&uuml;r diese Website in Google Analytics.';

$lang['settings_ga_tracking']                    = 'Google Tracking Code';
$lang['settings_ga_tracking_desc']                = 'Gib deinen Google Analytic Tracking Code ein um Google Analytics\' view data capturing zu aktivieren. z.B: UA-19483569-6';#translate; no idea what view data capturing is...

$lang['settings_twitter_username']                = 'Twitter-Benutzername';
$lang['settings_twitter_username_desc']            = 'Dein Twitter-Benutzername.';
    
$lang['settings_twitter_feed_count']            = 'Anzahl der Feeds';
$lang['settings_twitter_feed_count_desc']        = 'Wie viele Tweets sollen im Twitter-Block maximal angezeigt werden?';

$lang['settings_twitter_cache']                    = 'Dauer im Cache';
$lang['settings_twitter_cache_desc']            = 'Wie lange sollen deine Tweets tempor&auml;r im Cache gesichert werden?';

$lang['settings_akismet_api_key']                = 'Akismet API Schl&uuml;ssel';
$lang['settings_akismet_api_key_desc']            = 'Akismet ist ein Spam-Blocker der Wordpress-Entwickler. Es h&auml;lt Spam unter Kontrolle ohne das Benutzer Captchas nutzen m&uuml;ssen.';

$lang['settings_comment_order']                    = 'Kommentar Reihenfolge';
$lang['settings_comment_order_desc']            = 'Reihenfolge in der die Kommentare angezeigt werden sollen.';

$lang['settings_moderate_comments']                = 'Kommentare moderieren';
$lang['settings_moderate_comments_desc']        = 'Kommentare m&uuml;ssen vorher von einem Moderator oder Admin &uuml;berpr&uuml;ft werden, bevor sie f&uuml;r alle Benutzer der Seite sichtbar werden.';

$lang['settings_version']                        = 'Version';
$lang['settings_version_desc']                    = 'Versionsbeschreibung';

#section titles
$lang['settings_section_general']                = 'Allgemein';
$lang['settings_section_integration']            = 'Integrierung';
$lang['settings_section_comments']                = 'Kommentare';
$lang['settings_section_users']                    = 'Benutzer';
$lang['settings_section_statistics']            = 'Statistiken';
$lang['settings_section_twitter']                = 'Twitter';

#checkbox and radio options
$lang['settings_form_option_Open']                = 'Ge&ouml;ffnet';
$lang['settings_form_option_Closed']            = 'Geschlossen';
$lang['settings_form_option_Enabled']            = 'Aktiviert';
$lang['settings_form_option_Disabled']            = 'Deaktiviert';
$lang['settings_form_option_Required']            = 'Ben&ouml;tigt';
$lang['settings_form_option_Optional']            = 'Optional';
$lang['settings_form_option_Oldest First']        = '&Auml;lteste Zuerst';
$lang['settings_form_option_Newest First']        = 'Neueste Zuerst';

// titles
$lang['settings_edit_title']                    = 'Einstellungen bearbeiten';

// messages
$lang['settings_no_settings']                    = 'Es gibt im Moment keine Einstellungen.';
$lang['settings_save_success']                    = 'Deine Einstellungen wurden gesichert!';

/* End of file settings_lang.php */