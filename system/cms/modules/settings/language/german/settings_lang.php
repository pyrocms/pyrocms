<?php defined('BASEPATH') OR exit('No direct script access allowed');

#section settings
$lang['settings:site_name']                        = 'Name der Seite';
$lang['settings:site_name_desc']                = 'Der Name der Seite zur Anzeige auf der kompletten Web-Pr&auml;senz.';

$lang['settings:site_slogan']                    = 'Slogan der Seite';
$lang['settings:site_slogan_desc']                = 'Der Sloagen der Seite zur Anzeige auf der kompletten Web-Pr&auml;senz.';

$lang['settings:site_lang']                        = 'Sprache der Seite';
$lang['settings:site_lang_desc']                = 'Die Muttersprache der Seite. Wird verwendet um Templates f&uuml;r interne E-mail Benachrichtungen zu w&auml;hlen, Besucher Kontakte zu empfangen und andere Features die nicht von der Sprache des Benutzers beeinflusst werden sollen.';
#The native language of the website, used to choose templates of e-mail internal notifications and receiving visitors contact and other features that should not bend the language of a user.';#tricky one

$lang['settings:contact_email']                    = 'Kontakt-Email';
$lang['settings:contact_email_desc']            = 'S&auml;mtliche E-Mail von Benutzern und G&auml;sten, sowie von der Seite allgemein werden an diese E-Mail-Adresse versendet.';

$lang['settings:server_email']                    = 'Server-Email';
$lang['settings:server_email_desc']                = 'S&auml;mtliche E-Mails, die an Benutzer der Seite versendet werden, nutzen diese E-Mail als Absender.';

$lang['settings:meta_topic']                    = 'Meta-Beschreibung';
$lang['settings:meta_topic_desc']                = 'Zwei oder drei W&ouml;rter, welche die Seite oder das Unternehmen kurz beschreiben.';

$lang['settings:currency']                        = 'W&auml;hrung';
$lang['settings:currency_desc']                    = 'Das Symbol der W&auml;hrung, welches auf der Seite genutzt werden soll.';

$lang['settings:dashboard_rss']                    = 'RRS-Feed der Admin-Oberfl&auml;che';
$lang['settings:dashboard_rss_desc']            = 'Link zu einem RSS-Feed, welches auf der Admin-Oberfl&auml;che angezeigt werden soll.';

$lang['settings:dashboard_rss_count']            = 'Anzahl der RRS-Feeds';
$lang['settings:dashboard_rss_count_desc']        = 'Wie viele Feeds sollen auf der Admin-Oberfl&auml;che maximal angezeigt werden?';

$lang['settings:date_format']                    = 'Datumsformat';
$lang['settings:date_format_desc']                = 'Wie sollen Daten/Termine auf der Seite und auf der Admin-Oberfl&auml;che angezeigt werden? ' .
'Mit dem <a href="http://php.net/manual/de/function.date.php" target="_black">Datumsformat</a> von PHP - ODER - ' .
'Mit der Formatierung von <a href="http://php.net/manual/de/function.strftime.php" target="_black">Strings als Datum</a> von PHP.';

$lang['settings:frontend_enabled']                = 'Status der Seite';
$lang['settings:frontend_enabled_desc']            = 'Nutze diese Option um die Seite f&uuml;r Nutzer unerreichbar zu machen. N&uuml;tzlich f&uuml;r Wartungen der Seite.';

$lang['settings:mail_protocol']                    = 'E-mail Protokoll';
$lang['settings:mail_protocol_desc']            = 'Gew&uuml;nschtes E-mail Protokoll w&auml;hlen.';

$lang['settings:mail_sendmail_path']            = 'Sendmail Pfad';
$lang['settings:mail_sendmail_path_desc']        = 'Pfad zur ausf&uuml;hrbaren "sendmail" Datei auf dem Server.';

$lang['settings:mail_smtp_host']                = 'SMTP Host';
$lang['settings:mail_smtp_host_desc']            = 'Der Hostname deines SMTP Servers.';

$lang['settings:mail_smtp_pass']                = 'SMTP Passwort';
$lang['settings:mail_smtp_pass_desc']            = 'SMTP Passwort.';

$lang['settings:mail_smtp_port']                = 'SMTP Port';
$lang['settings:mail_smtp_port_desc']            = 'SMTP Portnummer.';

$lang['settings:mail_smtp_user']                = 'SMTP Benutzername';
$lang['settings:mail_smtp_user_desc']            = 'SMTP Benutzername.';

$lang['settings:unavailable_message']            = 'Nachricht bei Unerreichbarkeit';
$lang['settings:unavailable_message_desc']        = 'Diese Nachricht wird den Benutzern angezeigt, sollte die Seite deaktiviert sein oder ein bedeutendes Problem vorliegen.';

$lang['settings:default_theme']                    = 'Standart Design';
$lang['settings:default_theme_desc']            = 'W&auml;hle das Design, welches dem Benutzer standartm&auml;ßig angezeigt wird.';

$lang['settings:activation_email']                = 'E-Mail Aktivierung';
$lang['settings:activation_email_desc']            = 'Verschickt zur Aktivierung des Accounts eine E-Mail an den neu registrierten Benutzer. Deaktiviere diese Option sofern die Accounts der Benutzer manuell von Admins freigeschaltet werden sollen.';

$lang['settings:records_per_page']                = 'Eintr&auml;ge per Seite';
$lang['settings:records_per_page_desc']            = 'Wie viele Eintr&auml;ge sollen auf der Admin-Oberfl&auml;che per Seite angezeigt werden?';

$lang['settings:rss_feed_items']                = 'RSS-Feed Anzahl';
$lang['settings:rss_feed_items_desc']            = 'Wie viele Eintr&auml;ge sollen im RSS/News-Bereich der Seite angezeigt werden?';


$lang['settings:enable_profiles']                = 'Profile aktivieren';
$lang['settings:enable_profiles_desc']            = 'Erlaubt das Erstellen und Bearbeiten von Benutzer-Profilen.';

$lang['settings:ga_email']                        = 'Google Analytics E-mail';
$lang['settings:ga_email_desc']                    = 'E-mail Adresse die f&uuml;r Google Analytics verwendet wird. Wird ben&ouml;tigt um den Graphen im Dashboard anzuzeigen.';

$lang['settings:ga_password']                    = 'Google Analytics Passwort';
$lang['settings:ga_password_desc']                = 'Google Analytics Passwort. Wird auch f&uuml;r den Graphen im Dashboard ben&ouml;tigt.';

$lang['settings:ga_profile']                     = 'Google Analytics Profile';
$lang['settings:ga_profile_desc']                = 'Profil ID f&uuml;r diese Website in Google Analytics.';

$lang['settings:ga_tracking']                    = 'Google Tracking Code';
$lang['settings:ga_tracking_desc']                = 'Gib deinen Google Analytic Tracking Code ein um Google Analytics\' view data capturing zu aktivieren. z.B: UA-19483569-6';#translate; no idea what view data capturing is...

$lang['settings:twitter_username']                = 'Twitter-Benutzername';
$lang['settings:twitter_username_desc']            = 'Dein Twitter-Benutzername.';

$lang['settings:twitter_feed_count']            = 'Anzahl der Feeds';
$lang['settings:twitter_feed_count_desc']        = 'Wie viele Tweets sollen im Twitter-Block maximal angezeigt werden?';

$lang['settings:twitter_cache']                    = 'Dauer im Cache';
$lang['settings:twitter_cache_desc']            = 'Wie lange sollen deine Tweets tempor&auml;r im Cache gesichert werden?';

$lang['settings:akismet_api_key']                = 'Akismet API Schl&uuml;ssel';
$lang['settings:akismet_api_key_desc']            = 'Akismet ist ein Spam-Blocker der Wordpress-Entwickler. Es h&auml;lt Spam unter Kontrolle ohne das Benutzer Captchas nutzen m&uuml;ssen.';

$lang['settings:comment_order']                    = 'Kommentar Reihenfolge';
$lang['settings:comment_order_desc']            = 'Reihenfolge in der die Kommentare angezeigt werden sollen.';

$lang['settings:moderate_comments']                = 'Kommentare moderieren';
$lang['settings:moderate_comments_desc']        = 'Kommentare m&uuml;ssen vorher von einem Moderator oder Admin &uuml;berpr&uuml;ft werden, bevor sie f&uuml;r alle Benutzer der Seite sichtbar werden.';

$lang['settings:version']                        = 'Version';
$lang['settings:version_desc']                    = 'Versionsbeschreibung';

$lang['settings:ckeditor_config']               = 'CKEditor Konfiguration';
$lang['settings:ckeditor_config_desc']          = 'Eine Liste mit allen Einstellungen finden Sie in <a target="_blank" href="http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html">der Dokumentation des CKEditor\'s.</a> (Seite nur auf englisch verfügbar).';

$lang['settings:enable_registration']           = 'Benutzer-Registrierung aktivieren';
$lang['settings:enable_registration_desc']      = 'Erlaubt es Benutzer sich auf der Seite zu registrieren.';

$lang['settings:profile_visibility']            = 'Profile Visibility'; #translate
$lang['settings:profile_visibility_desc']       = 'Specify who can view user profiles on the public site'; #translate

$lang['settings:cdn_domain']                    = 'CDN Domains';
$lang['settings:cdn_domain_desc']               = 'CDN Domains erlauben es, statische Inhalt auf diverse Edge Server, wie Amazon CloudFront or MaxCDN, auszulagern.';

#section titles
$lang['settings:section_general']                = 'Allgemein';
$lang['settings:section_integration']            = 'Integrierung';
$lang['settings:section_comments']                = 'Kommentare';
$lang['settings:section_users']                    = 'Benutzer';
$lang['settings:section_statistics']            = 'Statistiken';
$lang['settings:section_twitter']                = 'Twitter';

#checkbox and radio options
$lang['settings:form_option_Open']                = 'Ge&ouml;ffnet';
$lang['settings:form_option_Closed']            = 'Geschlossen';
$lang['settings:form_option_Enabled']            = 'Aktiviert';
$lang['settings:form_option_Disabled']            = 'Deaktiviert';
$lang['settings:form_option_Required']            = 'Ben&ouml;tigt';
$lang['settings:form_option_Optional']            = 'Optional';
$lang['settings:form_option_Oldest First']        = '&Auml;lteste Zuerst';
$lang['settings:form_option_Newest First']        = 'Neueste Zuerst';
$lang['settings:form_option_profile_public']	= 'Visible to everybody'; #translate
$lang['settings:form_option_profile_owner']		= 'Only visible to the profile owner'; #translate
$lang['settings:form_option_profile_hidden']	= 'Never visible'; #translate
$lang['settings:form_option_profile_member']	= 'Visible to any logged in user'; #translate
$lang['settings:form_option_activate_by_email']            = 'Activate by email'; #translate
$lang['settings:form_option_activate_by_admin']        	= 'Activate by admin'; #translate
$lang['settings:form_option_no_activation']         	= 'Instant activation'; #translate

// titles
$lang['settings:edit_title']                    = 'Einstellungen bearbeiten';

// messages
$lang['settings:no_settings']                    = 'Es gibt im Moment keine Einstellungen.';
$lang['settings:save_success']                    = 'Deine Einstellungen wurden gesichert!';

/* End of file settings_lang.php */