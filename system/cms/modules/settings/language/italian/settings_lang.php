<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['settings_save_success'] 					= 'Le tue impostazioni sono state salvate!';
$lang['settings_edit_title'] 					= 'Modifica impostazioni';

#section settings
$lang['settings_site_name'] 					= 'Nome del Sito';
$lang['settings_site_name_desc'] 				= 'Il nome del sito per i titoli della pagina e per essere usato in giro per il sito.';

$lang['settings_site_slogan'] 					= 'Slogan del sito';
$lang['settings_site_slogan_desc'] 				= 'Lo slogan del sito per i titoli della pagina e per essere usato in giro per il sito.';

$lang['settings_site_lang']						= 'Site Language'; #translate
$lang['settings_site_lang_desc']				= 'The native language of the website, used to choose templates of e-mail internal notifications and receiving visitors contact and other features that should not bend the language of a user.'; #translate

$lang['settings_contact_email'] 				= 'Email per contatti';
$lang['settings_contact_email_desc'] 			= 'Tuttele email dagli utenti, dai visitatori e dal sito saranno dirette a questo indizzo email.';

$lang['settings_server_email'] 					= 'Server Email';
$lang['settings_server_email_desc'] 			= 'Tutte le email agli utenti arriveranno da questo indizzo email.';

$lang['settings_meta_topic']					= 'Meta Topic';
$lang['settings_meta_topic_desc']				= 'Due o tre parole che descrivano il tipo di società/sito.';

$lang['settings_currency'] 						= 'Valuta';
$lang['settings_currency_desc'] 				= 'Il simbolo della valuta da usare per prodotti, servizi, ecc.';

$lang['settings_dashboard_rss'] 				= 'Dashboard RSS Feed';
$lang['settings_dashboard_rss_desc'] 			= 'Collegamento ad un feed RSS che verrà mostrato nella dashboard.';

$lang['settings_dashboard_rss_count'] 			= 'Post RSS della Dashboard';
$lang['settings_dashboard_rss_count_desc'] 		= 'Quanti post RSS vuoi mostrare nella dashboard ?';

$lang['settings_date_format'] 					= 'Date Format'; #translate
$lang['settings_date_format_desc']				= 'How should dates be displayed accross the website and control panel? ' .
													'Using the <a href="http://php.net/manual/en/function.date.php" target="_black">date format</a> from PHP - OR - ' .
													'Using the format of <a href="http://php.net/manual/en/function.strftime.php" target="_black">strings formated as date</a> from PHP.'; #translate

$lang['settings_frontend_enabled'] 				= 'Stato del Sito';
$lang['settings_frontend_enabled_desc'] 		= 'Usa questa opzione per rendere o meno visibile il frontend del sito. Utile quando vuoi mettere offline il sito per manutenzione';

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

$lang['settings_unavailable_message']			= 'Avviso di Non Disponibile';
$lang['settings_unavailable_message_desc'] 		= 'Quando il sito è messo offline o c\' è un grave problema, agli utenti verrà mostrato questo avviso.';

$lang['settings_default_theme'] 				= 'Tema predefinito';
$lang['settings_default_theme_desc'] 			= 'Seleziona il tema che vuoi sia il predefinito per gli utenti.';

$lang['settings_activation_email'] 				= 'Attivazione tramite Email';
$lang['settings_activation_email_desc'] 		= 'Invia un email con un collegamento per l\' attivazione quando un utente si iscrive. Disabilitandolo solo gli amministratori potranno attivare i profili.';

$lang['settings_records_per_page'] 				= 'Records Per Pagina';
$lang['settings_records_per_page_desc'] 		= 'Quanti records per pagina dobbiamo mostrare sella sezione di amministrazione ?';

$lang['settings_rss_feed_items'] 				= 'Numero post Feed';
$lang['settings_rss_feed_items_desc'] 			= 'Quanti post dobbiamo mostrare nei feed RSS/Notizie?';

$lang['settings_require_lastname'] 				= 'Cognome richiesto?';
$lang['settings_require_lastname_desc'] 		= 'In alcune situazioniil cognome potrebbe non servire. Vuoi forzare gli utenti ad inserirlo o no?';

$lang['settings_enable_profiles'] 				= 'Abilita profili';
$lang['settings_enable_profiles_desc'] 			= 'Permetti agli utenti di aggiungere e modificare profili.';

$lang['settings_ga_email'] 						= 'Google Analytic E-mail'; #translate
$lang['settings_ga_email_desc']					= 'E-mail address used for Google Analytics, we need this to show the graph on the dashboard.'; #translate

$lang['settings_ga_password'] 					= 'Google Analytic Password'; #translate
$lang['settings_ga_password_desc']				= 'Google Analytics password. This is also needed this to show the graph on the dashboard.'; #translate

$lang['settings_ga_profile'] 					= 'Google Analytic Profile'; #translate
$lang['settings_ga_profile_desc']				= 'Profile ID for this website in Google Analytics.'; #translate

$lang['settings_ga_tracking'] 					= 'Google Tracking Code'; #translate
$lang['settings_ga_tracking_desc']				= 'Enter your Google Analytic Tracking Code to activate Google Analytics view data capturing. E.g: UA-19483569-6'; #translate

$lang['settings_twitter_username'] 				= 'Username';
$lang['settings_twitter_username_desc'] 		= 'Twitter username.';

$lang['settings_twitter_consumer_key'] 			= 'Consumer Key';
$lang['settings_twitter_consumer_key_desc'] 	= 'Twitter consumer key.';

$lang['settings_twitter_consumer_key_secret'] 	= 'Consumer Key Secret';
$lang['settings_twitter_consumer_key_secret_desc'] = 'Twitter consumer key secret.';

$lang['settings_twitter_blog']					= 'Integrazione Twitter &amp; Notizie.';
$lang['settings_twitter_blog_desc'] 			= 'Vuoi postare i collegamenti alle nuove notizie su Twitter?';

$lang['settings_twitter_feed_count'] 			= 'Numero dei Feed';
$lang['settings_twitter_feed_count_desc'] 		= 'Quanti tweets devono essere restituiti blocco dei feed di Twitter?';

$lang['settings_twitter_cache'] 				= 'Tempo di caching';
$lang['settings_twitter_cache_desc'] 			= 'Per quanti minuti devono essere conservati temporaneamente i tuoi Tweets?';

$lang['settings_akismet_api_key'] 				= 'Akismet API Key';
$lang['settings_akismet_api_key_desc'] 			= 'Akismet è uno spam-blocker prodotto dal team di WordPress. Tiene sotto controllo lo spam senza obbligare gli utenti a superare i moduli CAPTCHA.';

$lang['settings_comment_order'] 				= 'Comment Order'; #translate
$lang['settings_comment_order_desc']			= 'Sort order in which to display comments.'; #translate

$lang['settings_moderate_comments'] 			= 'Moderazione dei Commenti';
$lang['settings_moderate_comments_desc']		= 'Obbliga che i commenti siano approvati prima di comparire sul sito.';

$lang['settings_version'] 						= 'Versione';
$lang['settings_version_desc'] 					= '';

#section titles
$lang['settings_section_general']				= 'Generale';
$lang['settings_section_integration']			= 'Integrazione';
$lang['settings_section_comments']				= 'Comments'; #translate
$lang['settings_section_users']					= 'Utenti';
$lang['settings_section_statistics']			= 'Statistiche';
$lang['settings_section_twitter']				= 'Twitter';

#checkbox and radio options
$lang['settings_form_option_Open']				= 'Aperto';
$lang['settings_form_option_Closed']			= 'Chiuso';
$lang['settings_form_option_Enabled']			= 'Abilita';
$lang['settings_form_option_Disabled']			= 'Disabilita';
$lang['settings_form_option_Required']			= 'Richiesto';
$lang['settings_form_option_Optional']			= 'Opzionale';
$lang['settings_form_option_Oldest First']		= 'Oldest First'; #translate
$lang['settings_form_option_Newest First']		= 'Newest First'; #translate

/* End of file settings_lang.php */
/* Location: ./system/cms/modules/settings/language/italian/settings_lang.php */
