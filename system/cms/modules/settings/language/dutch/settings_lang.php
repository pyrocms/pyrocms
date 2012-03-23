<?php defined('BASEPATH') OR exit('No direct script access allowed');

#section settings
$lang['settings_site_name'] 					= 'Websitenaam';
$lang['settings_site_name_desc'] 				= 'De naam van de website voor de paginatitel en voor gebruik binnen de website.';

$lang['settings_site_slogan'] 					= 'Websiteslogan';
$lang['settings_site_slogan_desc'] 				= 'De slogan van de website voor paginatitel en voor gebruik binnen de website.';

$lang['settings_site_lang']						= 'Websitetaal';
$lang['settings_site_lang_desc']				= 'De taal binnen de website die gebruikt wordt om de gebruiker taalspecifieke opties aan te bieden.';

$lang['settings_contact_email'] 				= 'Contact email';
$lang['settings_contact_email_desc'] 			= 'Alle emails van gebruikers, gasten en de website gaan naar dit emailadres.';

$lang['settings_server_email'] 					= 'Server email';
$lang['settings_server_email_desc'] 			= 'Alle emails naar gebruikers komen van dit email adres.';

$lang['settings_meta_topic']					= 'Metatopic';
$lang['settings_meta_topic_desc']				= 'Twee of drie woorden die deze website beschrijven.';

$lang['settings_currency'] 						= 'Valuta';
$lang['settings_currency_desc'] 				= 'Het valuta symbool dat gebruikt wordt bij producten, diensten, etc.';

$lang['settings_dashboard_rss'] 				= 'Dashboard RSS Feed';
$lang['settings_dashboard_rss_desc'] 			= 'Link naar een RSS feed dat getoont wordt op de dashboard.';

$lang['settings_dashboard_rss_count'] 			= 'Dashboard RSS Items';
$lang['settings_dashboard_rss_count_desc'] 		= 'Hoe veel RSS items wilt u tonen op de dashboard ?';

$lang['settings_date_format'] 					= 'Datum formaat';
$lang['settings_date_format_desc']				= 'Hoe moet de datum worden weergegeven op de website en in het bedieningspaneel? Specificeer met behulp van de <a href="http://php.net/manual/en/function.date.php" target="_black">Datum formaat</a> in PHP - of - het formaat van <a href="http://php.net/manual/en/function.strftime.php" target="_black">strings geformatteerd als datum</a> in PHP.';

$lang['settings_frontend_enabled'] 				= 'Websitestatus';
$lang['settings_frontend_enabled_desc'] 		= 'Gebruik deze optie om de gebruikerskant van de website aan of uit te zetten. Handig wanneer u de website offline wilt halen voor onderhoud.';

$lang['settings_mail_protocol'] 				= 'Email protocol';
$lang['settings_mail_protocol_desc'] 			= 'Selecteer het gewenste email protocol.';

$lang['settings_mail_sendmail_path'] 			= 'Sendmail pad';
$lang['settings_mail_sendmail_path_desc']		= 'Pad naar server sendmail binaire.';

$lang['settings_mail_smtp_host'] 				= 'SMTP Host';
$lang['settings_mail_smtp_host_desc'] 			= 'De host naam van uw SMTP-server.';

$lang['settings_mail_smtp_pass'] 				= 'SMTP wachtwoord';
$lang['settings_mail_smtp_pass_desc'] 			= 'SMTP wachtwoord.';

$lang['settings_mail_smtp_port'] 				= 'SMTP poort';
$lang['settings_mail_smtp_port_desc'] 			= 'SMTP poort nummer.';

$lang['settings_mail_smtp_user'] 				= 'SMTP gebruikersnaam';
$lang['settings_mail_smtp_user_desc'] 			= 'SMTP gebruikersnaam.';

$lang['settings_unavailable_message']			= 'Onbeschikbaar Bericht';
$lang['settings_unavailable_message_desc'] 		= 'Wanneer de website uit is of er is een groot probleem, dan wordt dit bericht getoond aan de gebruikers.';

$lang['settings_default_theme'] 				= 'Standaard Thema';
$lang['settings_default_theme_desc'] 			= 'Selecteer het thema dat u standaard wilt tonen aan de gebruikers.';

$lang['settings_activation_email'] 				= 'Activatie E-mail';
$lang['settings_activation_email_desc'] 		= 'Stuur een e-mail met een activatielink wanneer een gebruiker registreert. Schakel dit uit als u alleen administratoren wilt laten activeren.';

$lang['settings_records_per_page'] 				= 'Records Per Pagina';
$lang['settings_records_per_page_desc'] 		= 'Hoeveel records zal de website per pagina tonen in het admin gebied?';

$lang['settings_rss_feed_items'] 				= 'Feed item teller';
$lang['settings_rss_feed_items_desc'] 			= 'Hoeveel items worden er getoond in de RSS/blog feeds?';

$lang['settings_require_lastname'] 				= 'Achternamen verplicht';
$lang['settings_require_lastname_desc'] 		= 'Wilt u een ingevulde achternaam als verplicht veld?';

$lang['settings_enable_profiles'] 				= 'Gebruikersprofielen';
$lang['settings_enable_profiles_desc'] 			= 'Staat gebruikers in staat om een profiel toe te voegen en te bewerken.';

$lang['settings_ga_email'] 						= 'Google Analytics email';
$lang['settings_ga_email_desc']					= 'Email adres welke wordt gebruikt voor Google Analytics, deze is nodig om de grafiek op het dashboard te laten zien.';

$lang['settings_ga_password'] 					= 'Google Analytics wachtwoord';
$lang['settings_ga_password_desc']				= 'Google Analytics wachtwoord. deze is ook nodig om de grafiek op het dashboard te laten zien';

$lang['settings_ga_profile'] 					= 'Google Analytic profiel';
$lang['settings_ga_profile_desc']				= 'Profiel-ID voor deze website in Google Analytics.';

$lang['settings_ga_tracking'] 					= 'Google Tracking Code';
$lang['settings_ga_tracking_desc']				= 'Voer uw Google Analytics Tracking Code in voor het activeren van Google Analytics om datacaptatie te bekijken. E.g: UA-19483569-6';

$lang['settings_twitter_username'] 				= 'Gebruikersnaam';
$lang['settings_twitter_username_desc'] 		= 'Twitter gebruikersnaam.';

$lang['settings_twitter_feed_count'] 			= 'Feed Teller';
$lang['settings_twitter_feed_count_desc'] 		= 'Hoeveel tweets moeten getoond worden in het Twitter feed blok?';

$lang['settings_twitter_cache'] 				= 'Cache tijd';
$lang['settings_twitter_cache_desc'] 			= 'Hoeveel minuten moeten de Tweets tijdelijk bewaard worden?';

$lang['settings_akismet_api_key'] 				= 'Akismet API Sleutel';
$lang['settings_akismet_api_key_desc'] 			= 'Akismet is een spam-blokker van het WordPress team. Het houdt spam onder controle zonder gebruikers te dwingen een mens-checkend CAPTCHA formulier te gebruiken.';

$lang['settings_enable_comments'] 				= 'Reacties';
$lang['settings_enable_comments_desc']			= 'Schakel reactiemogelijkheid voor gebruikers in of uit.';

$lang['settings_comment_order'] 				= 'Volgorde Reactie';
$lang['settings_comment_order_desc']			= 'Sorteervolgorde om reacties te tonen.';

$lang['settings_moderate_comments'] 			= 'Valideer Reacties';
$lang['settings_moderate_comments_desc']		= 'Forceer dat reacties eerst moeten geaccepteerd worden voordat ze worden getoond op de website.';

$lang['settings_comment_markdown']				= 'Markdown toestaan';
$lang['settings_comment_markdown_desc']			= 'Wilt u de bezoekers de mogelijkheid hebben om een ​​reactie te plaatsen met behulp van Markdown?';

$lang['settings_version'] 						= 'Versie';
$lang['settings_version_desc'] 					= '';

$lang['settings_site_public_lang']				= 'Openbare Talen';
$lang['settings_site_public_lang_desc']			= 'Wat zijn de talen die echt ondersteund en worden aangeboden op de front-end van uw website?';

$lang['settings_admin_force_https']				= 'Forceer HTTPS voor het Control Panel?';
$lang['settings_admin_force_https_desc']		= 'Laat alleen het HTTPS-protocol toe bij het gebruik van het Control Panel?';

$lang['settings_files_cache']					= 'Bestanden Cache';
$lang['settings_files_cache_desc']				= 'Wat is de verlooptijd';

$lang['settings_auto_username']         		= "Automatische loginnaam";
$lang['settings_auto_username_desc']    	 	= "Genereer automatisch een gebruikersnaam zodat gebruikers deze stap kunnen overslaan.";

$lang['settings_registered_email']				= 'Geregistreerde gebruikers E-mail';
$lang['settings_registered_email_desc']			= 'Stuur een notificatie e-mail naar het contact e-mail als iemand zich registreert.';

$lang['settings_ckeditor_config']               = 'CKEditor Config'; #translate
$lang['settings_ckeditor_config_desc']          = 'You can find a list of valid configuration items in <a target=\"_blank\" href=\"http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html\">CKEditor\'s documentation.</a>'; #translate

$lang['settings_enable_registration']           = 'Enable user registration'; #translate
$lang['settings_enable_registration_desc']      = 'Allow users to register in your site.'; #translate

$lang['settings_cdn_domain']                    = 'CDN Domain'; #translate
$lang['settings_cdn_domain_desc']               = 'CDN domains allow you to offload static content to various edge servers, like Amazon CloudFront or MaxCDN.'; #translate

#section titles
$lang['settings_section_general']				= 'Algemeen';
$lang['settings_section_integration']			= 'Integratie';
$lang['settings_section_comments']				= 'Reacties';
$lang['settings_section_users']					= 'Gebruikers';
$lang['settings_section_statistics']			= 'Statistieken';
$lang['settings_section_twitter']				= 'Twitter';
$lang['settings_section_files']					= 'Bestanden';

#checkbox and radio options
$lang['settings_form_option_Open']				= 'Online';
$lang['settings_form_option_Closed']			= 'Offline';
$lang['settings_form_option_Enabled']			= 'Ingeschakeld';
$lang['settings_form_option_Disabled']			= 'Uitgeschakeld';
$lang['settings_form_option_Required']			= 'Verplicht';
$lang['settings_form_option_Optional']			= 'Optioneel';
$lang['settings_form_option_Oldest First']		= 'Oudste eerst';
$lang['settings_form_option_Newest First']		= 'Nieuwste eerst';
$lang['settings_form_option_Text Only']			= 'Alleen Text';
$lang['settings_form_option_Allow Markdown']	= 'Markdown Toestaan';
$lang['settings_form_option_Yes']				= 'Ja';
$lang['settings_form_option_No']				= 'Nee';

// titles
$lang['settings_edit_title'] 					= 'Wijzig instellingen';

// messages
$lang['settings_no_settings']					= 'Er zijn op dit moment geen instellingen.';
$lang['settings_save_success'] 					= 'Uw instellingen zijn opgeslagen!';

/* End of file settings_lang.php */