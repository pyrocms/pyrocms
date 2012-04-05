<?php defined('BASEPATH') OR exit('No direct script access allowed');

#section settings
$lang['settings_site_name'] 					= 'Nome del Sito';
$lang['settings_site_name_desc'] 				= 'Il nome del sito per i titoli della pagina e per essere usato in giro per il sito.';

$lang['settings_site_slogan'] 					= 'Slogan del sito';
$lang['settings_site_slogan_desc'] 				= 'Lo slogan del sito per i titoli della pagina e per essere usato in giro per il sito.';

$lang['settings_site_lang']						= 'Lingua del sito'; 
$lang['settings_site_lang_desc']				= 'Lingua nativa del sito, verrà usata per la scelta dei template email, notifiche interne, contatti con i visitatori e tutte le altre funzionalità che richiedono comunicazioni con gli utenti.'; 

$lang['settings_contact_email'] 				= 'Email per contatti';
$lang['settings_contact_email_desc'] 			= 'Tutte le email dagli utenti, dai visitatori e dal sito saranno dirette a questo indirizzo email.';

$lang['settings_server_email'] 					= 'Server Email';
$lang['settings_server_email_desc'] 			= 'Tutte le email agli utenti arriveranno da questo indirizzo email.';

$lang['settings_meta_topic']					= 'Meta Topic';
$lang['settings_meta_topic_desc']				= 'Due o tre parole che descrivano il tipo di società/sito.';

$lang['settings_currency'] 						= 'Valuta';
$lang['settings_currency_desc'] 				= 'Il simbolo della valuta da usare per prodotti, servizi, ecc.';

$lang['settings_dashboard_rss'] 				= 'Dashboard RSS Feed';
$lang['settings_dashboard_rss_desc'] 			= 'Collegamento ad un feed RSS che verrà mostrato nella dashboard.';

$lang['settings_dashboard_rss_count'] 			= 'Post RSS della Dashboard';
$lang['settings_dashboard_rss_count_desc'] 		= 'Quanti post RSS vuoi mostrare nella dashboard ?';

$lang['settings_date_format'] 					= 'Formato data';
$lang['settings_date_format_desc']				= 'Come devono essere mostrate le date nel sito e nel pannello di controllo? ' .
													'Devi utilizzare il <a href="http://php.net/manual/en/function.date.php" target="_black">formato data</a> del PHP - oppure - ' .
													'Utilizza il formato <a href="http://php.net/manual/en/function.strftime.php" target="_black">stringa al posto della data</a> del PHP.'; 

$lang['settings_frontend_enabled'] 				= 'Stato del Sito';
$lang['settings_frontend_enabled_desc'] 		= 'Usa questa opzione per rendere o meno visibile il frontend del sito. Utile quando vuoi mettere offline il sito per manutenzione';

$lang['settings_mail_protocol'] 				= 'Protocollo email'; 
$lang['settings_mail_protocol_desc'] 			= 'Seleziona il protocollo di invio email che preferisci.';

$lang['settings_mail_sendmail_path'] 			= 'Sendmail Path';
$lang['settings_mail_sendmail_path_desc']		= 'Path sul server per il file binario sendmail.';

$lang['settings_mail_smtp_host'] 				= 'SMTP Host'; 
$lang['settings_mail_smtp_host_desc'] 			= 'Il nome del tuo server smtp.';

$lang['settings_mail_smtp_pass'] 				= 'SMTP password'; 
$lang['settings_mail_smtp_pass_desc'] 			= 'SMTP password.'; 

$lang['settings_mail_smtp_port'] 				= 'Porta SMTP'; 
$lang['settings_mail_smtp_port_desc'] 			= 'Numero porta SMTP.';

$lang['settings_mail_smtp_user'] 				= 'SMTP User Name';
$lang['settings_mail_smtp_user_desc'] 			= 'SMTP user name.';

$lang['settings_unavailable_message']			= 'Avviso di Non Disponibile';
$lang['settings_unavailable_message_desc'] 		= 'Quando il sito è messo offline o c\'è un grave problema, agli utenti verrà mostrato questo avviso.';

$lang['settings_default_theme'] 				= 'Tema predefinito';
$lang['settings_default_theme_desc'] 			= 'Seleziona il tema che vuoi sia il predefinito per gli utenti.';

$lang['settings_activation_email'] 				= 'Attivazione tramite Email';
$lang['settings_activation_email_desc'] 		= 'Invia un email con un collegamento per l\' attivazione quando un utente si iscrive. Disabilitandolo solo gli amministratori potranno attivare i profili.';

$lang['settings_records_per_page'] 				= 'Records Per Pagina';
$lang['settings_records_per_page_desc'] 		= 'Quanti records per pagina dobbiamo mostrare sella sezione di amministrazione ?';

$lang['settings_rss_feed_items'] 				= 'Numero post Feed';
$lang['settings_rss_feed_items_desc'] 			= 'Quanti post dobbiamo mostrare nei feed RSS/Notizie?';

$lang['settings_require_lastname'] 				= 'Cognome richiesto?';
$lang['settings_require_lastname_desc'] 		= 'In alcune situazioni il cognome potrebbe non servire. Vuoi forzare gli utenti ad inserirlo o no?';

$lang['settings_enable_profiles'] 				= 'Abilita profili';
$lang['settings_enable_profiles_desc'] 			= 'Permetti agli utenti di aggiungere e modificare profili.';

$lang['settings_ga_email'] 						= 'Google Analytic E-mail';
$lang['settings_ga_email_desc']					= 'Indirizzo email da utilizzare per le statistiche di Google Analytics, necessario per mostrare nella dashbord un grafico di monitoraggio.';

$lang['settings_ga_password'] 					= 'Google Analytic Password';
$lang['settings_ga_password_desc']				= 'Google Analytics password. Anche la password è necessaria per mostrare il grafico nella dashbord.';

$lang['settings_ga_profile'] 					= 'Google Analytic Profile';
$lang['settings_ga_profile_desc']				= 'ID del profilo di questo sito in Google Analytics.'; 

$lang['settings_ga_tracking'] 					= 'Google Tracking Code'; 
$lang['settings_ga_tracking_desc']				= 'Inserisci il codice di tracciamento (Google Analytic Tracking Code) per attivare la possibilità di salvare i dati per Google Analytic. Es: UA-19483569-6';

$lang['settings_twitter_username'] 				= 'Username';
$lang['settings_twitter_username_desc'] 		= 'Twitter username.';

$lang['settings_twitter_feed_count'] 			= 'Numero dei Feed';
$lang['settings_twitter_feed_count_desc'] 		= 'Quanti tweets devono essere restituiti blocco dei feed di Twitter?';

$lang['settings_twitter_cache'] 				= 'Tempo di caching';
$lang['settings_twitter_cache_desc'] 			= 'Per quanti minuti devono essere conservati temporaneamente i tuoi Tweets?';

$lang['settings_akismet_api_key'] 				= 'Akismet API Key';
$lang['settings_akismet_api_key_desc'] 			= 'Akismet è uno spam-blocker prodotto dal team di WordPress. Tiene sotto controllo lo spam senza obbligare gli utenti a superare i moduli CAPTCHA.';

$lang['settings_comment_order'] 				= 'Ordine commenti';
$lang['settings_comment_order_desc']			= 'Orndine in cui mostrare i commenti.';

$lang['settings_moderate_comments'] 			= 'Moderazione dei Commenti';
$lang['settings_moderate_comments_desc']		= 'Obbliga che i commenti siano approvati prima di comparire sul sito.';

$lang['settings_version'] 						= 'Versione';
$lang['settings_version_desc'] 					= '';

$lang['settings_ckeditor_config']               = 'Configurazione CKEditor';
$lang['settings_ckeditor_config_desc']          = 'Puoi trovare una lista di configurazioni corrette nella <a target="_blank" href="http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html">documentazione ufficiale.</a>'; #translate

$lang['settings_enable_registration']           = 'Abilita registrazioni';
$lang['settings_enable_registration_desc']      = 'Permetti agli utenti di registrarti al tuo sito.'; 

$lang['settings_cdn_domain']                    = 'Dominio CDN'; 
$lang['settings_cdn_domain_desc']               = 'il dominio CDN ti consente di scaricare contenuti da diversi server come Amazon CloudFront o MaxCDN.'; 

#section titles
$lang['settings_section_general']				= 'Generale';
$lang['settings_section_integration']			= 'Integrazione';
$lang['settings_section_comments']				= 'Commenti';
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
$lang['settings_form_option_Oldest First']		= 'Prima i più vecchi';
$lang['settings_form_option_Newest First']		= 'Prima i più nuovi';

// titles
$lang['settings_edit_title'] 					= 'Modifica impostazioni';

// messages
$lang['settings_no_settings']					= 'Non ci sono impostazioni.';
$lang['settings_save_success'] 					= 'Le tue impostazioni sono state salvate!';

/* End of file settings_lang.php */