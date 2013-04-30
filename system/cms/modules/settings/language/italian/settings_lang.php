<?php defined('BASEPATH') OR exit('No direct script access allowed');

#section settings
$lang['settings:site_name'] 					= 'Nome del Sito';
$lang['settings:site_name_desc'] 				= 'Il nome del sito per i titoli della pagina e per essere usato in giro per il sito.';

$lang['settings:site_slogan'] 					= 'Slogan del sito';
$lang['settings:site_slogan_desc'] 				= 'Lo slogan del sito per i titoli della pagina e per essere usato in giro per il sito.';

$lang['settings:site_lang']						= 'Lingua del sito'; 
$lang['settings:site_lang_desc']				= 'Lingua nativa del sito, verrà usata per la scelta dei template email, notifiche interne, contatti con i visitatori e tutte le altre funzionalità che richiedono comunicazioni con gli utenti.'; 

$lang['settings:contact_email'] 				= 'Email per contatti';
$lang['settings:contact_email_desc'] 			= 'Tutte le email dagli utenti, dai visitatori e dal sito saranno dirette a questo indirizzo email.';

$lang['settings:server_email'] 					= 'Server Email';
$lang['settings:server_email_desc'] 			= 'Tutte le email agli utenti arriveranno da questo indirizzo email.';

$lang['settings:meta_topic']					= 'Meta Topic';
$lang['settings:meta_topic_desc']				= 'Due o tre parole che descrivano il tipo di società/sito.';

$lang['settings:currency'] 						= 'Valuta';
$lang['settings:currency_desc'] 				= 'Il simbolo della valuta da usare per prodotti, servizi, ecc.';

$lang['settings:dashboard_rss'] 				= 'Dashboard RSS Feed';
$lang['settings:dashboard_rss_desc'] 			= 'Collegamento ad un feed RSS che verrà mostrato nella dashboard.';

$lang['settings:dashboard_rss_count'] 			= 'Post RSS della Dashboard';
$lang['settings:dashboard_rss_count_desc'] 		= 'Quanti post RSS vuoi mostrare nella dashboard ?';

$lang['settings:date_format'] 					= 'Formato data';
$lang['settings:date_format_desc']				= 'Come devono essere mostrate le date nel sito e nel pannello di controllo? ' .
													'Devi utilizzare il <a href="http://php.net/manual/en/function.date.php" target="_black">formato data</a> del PHP - oppure - ' .
													'Utilizza il formato <a href="http://php.net/manual/en/function.strftime.php" target="_black">stringa al posto della data</a> del PHP.'; 

$lang['settings:frontend_enabled'] 				= 'Stato del Sito';
$lang['settings:frontend_enabled_desc'] 		= 'Usa questa opzione per rendere o meno visibile il frontend del sito. Utile quando vuoi mettere offline il sito per manutenzione';

$lang['settings:mail_protocol'] 				= 'Protocollo email'; 
$lang['settings:mail_protocol_desc'] 			= 'Seleziona il protocollo di invio email che preferisci.';

$lang['settings:mail_sendmail_path'] 			= 'Sendmail Path';
$lang['settings:mail_sendmail_path_desc']		= 'Path sul server per il file binario sendmail.';

$lang['settings:mail_smtp_host'] 				= 'SMTP Host'; 
$lang['settings:mail_smtp_host_desc'] 			= 'Il nome del tuo server smtp.';

$lang['settings:mail_smtp_pass'] 				= 'SMTP password'; 
$lang['settings:mail_smtp_pass_desc'] 			= 'SMTP password.'; 

$lang['settings:mail_smtp_port'] 				= 'Porta SMTP'; 
$lang['settings:mail_smtp_port_desc'] 			= 'Numero porta SMTP.';

$lang['settings:mail_smtp_user'] 				= 'SMTP User Name';
$lang['settings:mail_smtp_user_desc'] 			= 'SMTP user name.';

$lang['settings:unavailable_message']			= 'Avviso di Non Disponibile';
$lang['settings:unavailable_message_desc'] 		= 'Quando il sito è messo offline o c\'è un grave problema, agli utenti verrà mostrato questo avviso.';

$lang['settings:default_theme'] 				= 'Tema predefinito';
$lang['settings:default_theme_desc'] 			= 'Seleziona il tema che vuoi sia il predefinito per gli utenti.';

$lang['settings:activation_email'] 				= 'Attivazione tramite Email';
$lang['settings:activation_email_desc'] 		= 'Invia un email con un collegamento per l\' attivazione quando un utente si iscrive. Disabilitandolo solo gli amministratori potranno attivare i profili.';

$lang['settings:records_per_page'] 				= 'Records Per Pagina';
$lang['settings:records_per_page_desc'] 		= 'Quanti records per pagina dobbiamo mostrare sella sezione di amministrazione ?';

$lang['settings:rss_feed_items'] 				= 'Numero post Feed';
$lang['settings:rss_feed_items_desc'] 			= 'Quanti post dobbiamo mostrare nei feed RSS/Notizie?';


$lang['settings:enable_profiles'] 				= 'Abilita profili';
$lang['settings:enable_profiles_desc'] 			= 'Permetti agli utenti di aggiungere e modificare profili.';

$lang['settings:ga_email'] 						= 'Google Analytic E-mail';
$lang['settings:ga_email_desc']					= 'Indirizzo email da utilizzare per le statistiche di Google Analytics, necessario per mostrare nella dashbord un grafico di monitoraggio.';

$lang['settings:ga_password'] 					= 'Google Analytic Password';
$lang['settings:ga_password_desc']				= 'Google Analytics password. Anche la password è necessaria per mostrare il grafico nella dashbord.';

$lang['settings:ga_profile'] 					= 'Google Analytic Profile';
$lang['settings:ga_profile_desc']				= 'ID del profilo di questo sito in Google Analytics.'; 

$lang['settings:ga_tracking'] 					= 'Google Tracking Code'; 
$lang['settings:ga_tracking_desc']				= 'Inserisci il codice di tracciamento (Google Analytic Tracking Code) per attivare la possibilità di salvare i dati per Google Analytic. Es: UA-19483569-6';

$lang['settings:akismet_api_key'] 				= 'Akismet API Key';
$lang['settings:akismet_api_key_desc'] 			= 'Akismet è uno spam-blocker prodotto dal team di WordPress. Tiene sotto controllo lo spam senza obbligare gli utenti a superare i moduli CAPTCHA.';

$lang['settings:comment_order'] 				= 'Ordine commenti';
$lang['settings:comment_order_desc']			= 'Orndine in cui mostrare i commenti.';

$lang['settings:moderate_comments'] 			= 'Moderazione dei Commenti';
$lang['settings:moderate_comments_desc']		= 'Obbliga che i commenti siano approvati prima di comparire sul sito.';

$lang['settings:comment_markdown']				= 'Permetti Markdown';
$lang['settings:comment_markdown_desc']			= 'Vuoi permettere ai visitatori di commentare utilizzando il Markdown?';

$lang['settings:version'] 						= 'Versione';
$lang['settings:version_desc'] 					= '';

$lang['settings:site_public_lang']				= 'Lingue Publiche';
$lang['settings:site_public_lang_desc']			= 'Quali solo le lingue realmente supportate nel front-end del tuo sito web?';

$lang['settings:admin_force_https']				= 'Forzare HTTPS per il Pannello di Controllo?';
$lang['settings:admin_force_https_desc']		= 'Permettere solo il protocollo HTTPS quando si utilizza il Pannello di Controllo?';

$lang['settings:files_cache']					= 'Files Cache';
$lang['settings:files_cache_desc']				= 'Quando si mostra una immagine via site.com/files quando deve essere eliminata dalla cache?';

$lang['settings:auto_username']					= 'Auto Username';
$lang['settings:auto_username_desc']			= 'Crea un Username in automatico, vuol dire che gli utenti salteranno questo passaggio durante la registrazione.';

$lang['settings:registered_email']				= 'Email utente registrato';
$lang['settings:registered_email_desc']			= 'Inviare una email all\'indirizzo impostato come contatto quando qualcuno si registra.';

$lang['settings:ckeditor_config']               = 'Configurazione CKEditor';
$lang['settings:ckeditor_config_desc']          = 'Puoi trovare una lista di configurazioni corrette nella <a target="_blank" href="http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html">documentazione ufficiale.</a>'; 

$lang['settings:enable_registration']           = 'Abilita registrazioni';
$lang['settings:enable_registration_desc']      = 'Permetti agli utenti di registrarti al tuo sito.';

$lang['settings:profile_visibility']            = 'Visibilità profilo';
$lang['settings:profile_visibility_desc']       = 'Specifica chi può vedere il profilo di un utente nel sito pubblico'; 

$lang['settings:cdn_domain']                    = 'Dominio CDN'; 
$lang['settings:cdn_domain_desc']               = 'il dominio CDN ti consente di scaricare contenuti da diversi server come Amazon CloudFront o MaxCDN.'; 

#section titles
$lang['settings:section_general']				= 'Generale';
$lang['settings:section_integration']			= 'Integrazione';
$lang['settings:section_comments']				= 'Commenti';
$lang['settings:section_users']					= 'Utenti';
$lang['settings:section_statistics']			= 'Statistiche';
$lang['settings:section_files']					= 'Files';

#checkbox and radio options
$lang['settings:form_option_Open']				= 'Aperto';
$lang['settings:form_option_Closed']			= 'Chiuso';
$lang['settings:form_option_Enabled']			= 'Abilita';
$lang['settings:form_option_Disabled']			= 'Disabilita';
$lang['settings:form_option_Required']			= 'Richiesto';
$lang['settings:form_option_Optional']			= 'Opzionale';
$lang['settings:form_option_Oldest First']		= 'Prima i più vecchi';
$lang['settings:form_option_Newest First']		= 'Prima i più nuovi';
$lang['settings:form_option_Text Only']			= 'Solo testo';
$lang['settings:form_option_Allow Markdown']	= 'Consenti markdown';
$lang['settings:form_option_Yes']				= 'Si';
$lang['settings:form_option_No']				= 'No';

// titles
$lang['settings:edit_title'] 					= 'Modifica impostazioni';

// messages
$lang['settings:no_settings']					= 'Non ci sono impostazioni.';
$lang['settings:save_success'] 					= 'Le tue impostazioni sono state salvate!';

/* End of file settings_lang.php */