<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['settings_save_success'] 					= 'Nastavení bylo uloženo';
$lang['settings_edit_title'] 					= 'Upravit nastavení';

#section settings
$lang['settings_site_name'] 					= 'Jméno webu';
$lang['settings_site_name_desc'] 				= 'Jméno, které se objeví v titulcích stránek a různě po webu.';

$lang['settings_site_slogan'] 					= 'Slogan';
$lang['settings_site_slogan_desc'] 				= 'Slogan se objeví v titulcích stránek a různě po webu.';

$lang['settings_site_lang']						= 'jazyk stránek';
$lang['settings_site_lang_desc']				= 'The native language of the website, used to choose templates of e-mail internal notifications and receiving visitors contact and other features that should not bend the language of a user.'; 

$lang['settings_contact_email'] 				= 'Kontaktní e-mail';
$lang['settings_contact_email_desc'] 			= 'Všechny e-maily od uživatelů a hostů budou odeslány na tuto adresu.';

$lang['settings_server_email'] 					= 'E-mail webu';
$lang['settings_server_email_desc'] 			= 'Všechny e-maily uživatelům od vás budou odeslány z této adresy.';

$lang['settings_meta_topic']					= 'Meta téma webu';
$lang['settings_meta_topic_desc']				= 'Dvě či tři slova popisující zaměření tohoto webu/společnosti.';

$lang['settings_currency'] 						= 'Měna';
$lang['settings_currency_desc'] 				= 'Symbol měny zobrazovaný u produktů, služeb apod.';

$lang['settings_dashboard_rss'] 				= 'RSS zdroj na Nástěnce';
$lang['settings_dashboard_rss_desc'] 			= 'Odkaz na zdroj RSS zobrazovaný na Nástěnce.';

$lang['settings_dashboard_rss_count'] 			= 'Počet RSS položek na Nástěnce';
$lang['settings_dashboard_rss_count_desc'] 		= 'Kolik položek z RSS zdroje zobrazovat na Nástěnce?';

$lang['settings_date_format'] 					= 'Formát data'; 
$lang['settings_date_format_desc']				= 'Jak mají být zobrazována data na webu a v administraci? Pomocí <a href="http://php.net/manual/en/function.date.php" target="_black">date format</a> z PHP - NEBO - Pomocí formátu <a href="http://php.net/manual/en/function.strftime.php" target="_black">řetězců formátovaných jako datum</a> z PHP.'; 

$lang['settings_frontend_enabled'] 				= 'Stav webu';
$lang['settings_frontend_enabled_desc'] 		= 'Tímto nastavení můžete vypnout obsahovou část webu (nikoliv administraci). Užitečné např. při úpravách serveru.';

$lang['settings_mail_protocol'] 				= 'Mail Protokol'; 
$lang['settings_mail_protocol_desc'] 			= 'Vyberte emailový protokol';  

$lang['settings_mail_sendmail_path'] 			= 'Cesta k sendmail';
$lang['settings_mail_sendmail_path_desc']		= 'Cesta k sendmail.';

$lang['settings_mail_smtp_host'] 				= 'Hostitel SMTP';
$lang['settings_mail_smtp_host_desc'] 			= 'Hostitelské jméno vašeho SMTP serveru.';

$lang['settings_mail_smtp_pass'] 				= 'SMTP heslo';
$lang['settings_mail_smtp_pass_desc'] 			= 'SMTP heslo.';

$lang['settings_mail_smtp_port'] 				= 'SMTP Port'; 
$lang['settings_mail_smtp_port_desc'] 			= 'Číslo SMTP portu.';

$lang['settings_mail_smtp_user'] 				= 'SMTP uživatelské jméno';
$lang['settings_mail_smtp_user_desc'] 			= 'SMTP uživatelské jméno.';

$lang['settings_unavailable_message']			= 'Zpráva o nedostupnosti';
$lang['settings_unavailable_message_desc'] 		= 'Pokud je web dočasně vypnut nebo nastane nějaký velký problém, uživatelé uvidí tuto zprávu.';

$lang['settings_default_theme'] 				= 'Výchozí motiv vzhledu';
$lang['settings_default_theme_desc'] 			= 'Vyberte motiv, který chcete nastavit pro své uživatele jako výchozí.';

$lang['settings_activation_email'] 				= 'Aktivační e-mail';
$lang['settings_activation_email_desc'] 		= 'Uživateli bude po registraci odeslán e-mail s odkazem na aktivaci účtu. Pokud tuto možnost vypnete, pouze administrátoři budou moci aktivovat nové účty.';

$lang['settings_records_per_page'] 				= 'Počet záznamů na stránku';
$lang['settings_records_per_page_desc'] 		= 'Kolik záznamů si přejete zobrazovat na stránkách v administraci?';

$lang['settings_rss_feed_items'] 				= 'Počet položek v RSS';
$lang['settings_rss_feed_items_desc'] 			= 'Kolik položek se má zobrazovat v RSS zdroji vašeho webu?';

$lang['settings_require_lastname'] 				= 'Požadovat přijmení?';
$lang['settings_require_lastname_desc'] 		= 'V některých situacích může být znalost příjmení uživatelů žádoucí. Chcete je od uživatele požadovat?';

$lang['settings_enable_profiles'] 				= 'Povolit profily';
$lang['settings_enable_profiles_desc'] 			= 'Umožnit uživatelům přidávat a spravovat své profily?';

$lang['settings_ga_email'] 						= 'Google Analytic E-mail'; 
$lang['settings_ga_email_desc']					= 'E-mail pro Google Analytics, pro zobrazení grafu na Nástěnce.';

$lang['settings_ga_password'] 					= 'Google Analytic heslo';
$lang['settings_ga_password_desc']				= 'Heslo pro Google Analytics, pro zobrazení grafu na Nástěnce.';

$lang['settings_ga_profile'] 					= 'Google Analytic profil';
$lang['settings_ga_profile_desc']				= 'ID rpofilu pro tento web v Google Analytics.';

$lang['settings_ga_tracking'] 					= 'Google Tracking Code'; 
$lang['settings_ga_tracking_desc']				= 'Vložte svůj Google Analytic Tracking Code pro aktivaci snímání dat Google Analytics, např: UA-19483569-6';

$lang['settings_twitter_username'] 				= 'Uživatelské jméno';
$lang['settings_twitter_username_desc'] 		= 'Uživatelské jméno na Twitteru.';

$lang['settings_twitter_consumer_key'] 			= 'Consumer Key';
$lang['settings_twitter_consumer_key_desc'] 	= 'Consumer Key pro Twitter.';

$lang['settings_twitter_consumer_key_secret'] 	= 'Consumer Key Secret';
$lang['settings_twitter_consumer_key_secret_desc'] = 'Consumer Key Secret pro Twitter.';

$lang['settings_twitter_blog']					= 'Integrace novinek s Twitterem.';
$lang['settings_twitter_blog_desc'] 			= 'Chcete odesílat zprávy o nivinkách na Twitter?';

$lang['settings_twitter_feed_count'] 			= 'Počet příspěvků';
$lang['settings_twitter_feed_count_desc'] 		= 'Kolik tweetů se má zobrazit v sekci Twitteru?';

$lang['settings_twitter_cache'] 				= 'Doba cache';
$lang['settings_twitter_cache_desc'] 			= 'Kolik minut by měly být tweety dočasně uloženy u nás?';

$lang['settings_akismet_api_key'] 				= 'API klíč pro Akismet';
$lang['settings_akismet_api_key_desc'] 			= 'Akismet je služba blokující spam. Blokuje ho a při tom neobtěžuje uživatele nutností vyplňovat captcha.';

$lang['settings_comment_order'] 				= 'Pořadí komentářů';
$lang['settings_comment_order_desc']			= 'Způsob řazení komentářů.';

$lang['settings_moderate_comments'] 			= 'Moderovat komentáře';
$lang['settings_moderate_comments_desc']		= 'Zapnout nutnost schválení komentáře před tím, než se objeví na webu.';

$lang['settings_version'] 						= 'Verze';
$lang['settings_version_desc'] 					= '';

#section titles
$lang['settings_section_general']				= 'Obecné';
$lang['settings_section_integration']			= 'Integrace';
$lang['settings_section_comments']				= 'Komentáře';
$lang['settings_section_users']					= 'Uživatelé';
$lang['settings_section_statistics']			= 'Statistiky';
$lang['settings_section_twitter']				= 'Twitter';

#checkbox and radio options
$lang['settings_form_option_Open']				= 'Otevřeno';
$lang['settings_form_option_Closed']			= 'Zavřeno';
$lang['settings_form_option_Enabled']			= 'Povoleno';
$lang['settings_form_option_Disabled']			= 'Zakázáno';
$lang['settings_form_option_Required']			= 'Povinné';
$lang['settings_form_option_Optional']			= 'Volitelné';
$lang['settings_form_option_Oldest First']		= 'Od nejstarších';
$lang['settings_form_option_Newest First']		= 'Od nejnovějších';

/* End of file settings_lang.php */
/* Location: ./system/cms/modules/settings/language/czech/settings_lang.php */
