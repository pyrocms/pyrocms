<?php defined('BASEPATH') OR exit('No direct script access allowed');

#section settings
$lang['settings:site_name'] 					= 'Jméno webu';
$lang['settings:site_name_desc'] 				= 'Jméno, které se objeví v titulcích stránek a různě po webu.';

$lang['settings:site_slogan'] 					= 'Slogan';
$lang['settings:site_slogan_desc'] 				= 'Slogan se objeví v titulcích stránek a různě po webu.';

$lang['settings:site_lang']						= 'jazyk stránek';
$lang['settings:site_lang_desc']				= 'The native language of the website, used to choose templates of e-mail internal notifications and receiving visitors contact and other features that should not bend the language of a user.';

$lang['settings:contact_email'] 				= 'Kontaktní e-mail';
$lang['settings:contact_email_desc'] 			= 'Všechny e-maily od uživatelů a hostů budou odeslány na tuto adresu.';

$lang['settings:server_email'] 					= 'E-mail webu';
$lang['settings:server_email_desc'] 			= 'Všechny e-maily uživatelům od vás budou odeslány z této adresy.';

$lang['settings:meta_topic']					= 'Meta téma webu';
$lang['settings:meta_topic_desc']				= 'Dvě či tři slova popisující zaměření tohoto webu/společnosti.';

$lang['settings:currency'] 						= 'Měna';
$lang['settings:currency_desc'] 				= 'Symbol měny zobrazovaný u produktů, služeb apod.';

$lang['settings:dashboard_rss'] 				= 'RSS zdroj na Nástěnce';
$lang['settings:dashboard_rss_desc'] 			= 'Odkaz na zdroj RSS zobrazovaný na Nástěnce.';

$lang['settings:dashboard_rss_count'] 			= 'Počet RSS položek na Nástěnce';
$lang['settings:dashboard_rss_count_desc'] 		= 'Kolik položek z RSS zdroje zobrazovat na Nástěnce?';

$lang['settings:date_format'] 					= 'Formát data';
$lang['settings:date_format_desc']				= 'Jak mají být zobrazována data na webu a v administraci? Pomocí <a href="http://php.net/manual/en/function.date.php" target="_black">date format</a> z PHP - NEBO - Pomocí formátu <a href="http://php.net/manual/en/function.strftime.php" target="_black">řetězců formátovaných jako datum</a> z PHP.';

$lang['settings:frontend_enabled'] 				= 'Stav webu';
$lang['settings:frontend_enabled_desc'] 		= 'Tímto nastavení můžete vypnout obsahovou část webu (nikoliv administraci). Užitečné např. při úpravách serveru.';

$lang['settings:mail_protocol'] 				= 'Mail Protokol';
$lang['settings:mail_protocol_desc'] 			= 'Vyberte emailový protokol';

$lang['settings:mail_sendmail_path'] 			= 'Cesta k sendmail';
$lang['settings:mail_sendmail_path_desc']		= 'Cesta k sendmail.';

$lang['settings:mail_smtp_host'] 				= 'Hostitel SMTP';
$lang['settings:mail_smtp_host_desc'] 			= 'Hostitelské jméno vašeho SMTP serveru.';

$lang['settings:mail_smtp_pass'] 				= 'SMTP heslo';
$lang['settings:mail_smtp_pass_desc'] 			= 'SMTP heslo.';

$lang['settings:mail_smtp_port'] 				= 'SMTP Port';
$lang['settings:mail_smtp_port_desc'] 			= 'Číslo SMTP portu.';

$lang['settings:mail_smtp_user'] 				= 'SMTP uživatelské jméno';
$lang['settings:mail_smtp_user_desc'] 			= 'SMTP uživatelské jméno.';

$lang['settings:unavailable_message']			= 'Zpráva o nedostupnosti';
$lang['settings:unavailable_message_desc'] 		= 'Pokud je web dočasně vypnut nebo nastane nějaký velký problém, uživatelé uvidí tuto zprávu.';

$lang['settings:default_theme'] 				= 'Výchozí motiv vzhledu';
$lang['settings:default_theme_desc'] 			= 'Vyberte motiv, který chcete nastavit pro své uživatele jako výchozí.';

$lang['settings:activation_email'] 				= 'Aktivační e-mail';
$lang['settings:activation_email_desc'] 		= 'Uživateli bude po registraci odeslán e-mail s odkazem na aktivaci účtu. Pokud tuto možnost vypnete, pouze administrátoři budou moci aktivovat nové účty.';

$lang['settings:records_per_page'] 				= 'Počet záznamů na stránku';
$lang['settings:records_per_page_desc'] 		= 'Kolik záznamů si přejete zobrazovat na stránkách v administraci?';

$lang['settings:rss_feed_items'] 				= 'Počet položek v RSS';
$lang['settings:rss_feed_items_desc'] 			= 'Kolik položek se má zobrazovat v RSS zdroji vašeho webu?';

$lang['settings:require_lastname'] 				= 'Požadovat přijmení?';
$lang['settings:require_lastname_desc'] 		= 'V některých situacích může být znalost příjmení uživatelů žádoucí. Chcete je od uživatele požadovat?';

$lang['settings:enable_profiles'] 				= 'Povolit profily';
$lang['settings:enable_profiles_desc'] 			= 'Umožnit uživatelům přidávat a spravovat své profily?';

$lang['settings:ga_email'] 						= 'Google Analytic E-mail';
$lang['settings:ga_email_desc']					= 'E-mail pro Google Analytics, pro zobrazení grafu na Nástěnce.';

$lang['settings:ga_password'] 					= 'Google Analytic heslo';
$lang['settings:ga_password_desc']				= 'Heslo pro Google Analytics, pro zobrazení grafu na Nástěnce.';

$lang['settings:ga_profile'] 					= 'Google Analytic profil';
$lang['settings:ga_profile_desc']				= 'ID rpofilu pro tento web v Google Analytics.';

$lang['settings:ga_tracking'] 					= 'Google Tracking Code';
$lang['settings:ga_tracking_desc']				= 'Vložte svůj Google Analytic Tracking Code pro aktivaci snímání dat Google Analytics, např: UA-19483569-6';

$lang['settings:twitter_username'] 				= 'Uživatelské jméno';
$lang['settings:twitter_username_desc'] 		= 'Uživatelské jméno na Twitteru.';

$lang['settings:twitter_feed_count'] 			= 'Počet příspěvků';
$lang['settings:twitter_feed_count_desc'] 		= 'Kolik tweetů se má zobrazit v sekci Twitteru?';

$lang['settings:twitter_cache'] 				= 'Doba cache';
$lang['settings:twitter_cache_desc'] 			= 'Kolik minut by měly být tweety dočasně uloženy u nás?';

$lang['settings:akismet_api_key'] 				= 'API klíč pro Akismet';
$lang['settings:akismet_api_key_desc'] 			= 'Akismet je služba blokující spam. Blokuje ho a při tom neobtěžuje uživatele nutností vyplňovat captcha.';

$lang['settings:comment_order'] 				= 'Pořadí komentářů';
$lang['settings:comment_order_desc']			= 'Způsob řazení komentářů.';

$lang['settings:moderate_comments'] 			= 'Moderovat komentáře';
$lang['settings:moderate_comments_desc']		= 'Zapnout nutnost schválení komentáře před tím, než se objeví na webu.';

$lang['settings:version'] 						= 'Verze';
$lang['settings:version_desc'] 					= '';

$lang['settings:ckeditor_config']               = 'CKEditor Config'; #translate
$lang['settings:ckeditor_config_desc']          = 'You can find a list of valid configuration items in <a target="_blank" href="http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html">CKEditor\'s documentation.</a>'; #translate

$lang['settings:enable_registration']           = 'Enable user registration'; #translate
$lang['settings:enable_registration_desc']      = 'Allow users to register in your site.'; #translate

$lang['settings:profile_visibility']            = 'Profile Visibility'; #translate
$lang['settings:profile_visibility_desc']       = 'Specify who can view user profiles on the public site'; #translate

$lang['settings:cdn_domain']                    = 'CDN Domain'; #translate
$lang['settings:cdn_domain_desc']               = 'CDN domains allow you to offload static content to various edge servers, like Amazon CloudFront or MaxCDN.'; #translate

#section titles
$lang['settings:section_general']				= 'Obecné';
$lang['settings:section_integration']			= 'Integrace';
$lang['settings:section_comments']				= 'Komentáře';
$lang['settings:section_users']					= 'Uživatelé';
$lang['settings:section_statistics']			= 'Statistiky';
$lang['settings:section_twitter']				= 'Twitter';

#checkbox and radio options
$lang['settings:form_option_Open']				= 'Otevřeno';
$lang['settings:form_option_Closed']			= 'Zavřeno';
$lang['settings:form_option_Enabled']			= 'Povoleno';
$lang['settings:form_option_Disabled']			= 'Zakázáno';
$lang['settings:form_option_Required']			= 'Povinné';
$lang['settings:form_option_Optional']			= 'Volitelné';
$lang['settings:form_option_Oldest First']		= 'Od nejstarších';
$lang['settings:form_option_Newest First']		= 'Od nejnovějších';
$lang['settings:form_option_profile_public']	= 'Visible to everybody'; #translate
$lang['settings:form_option_profile_owner']		= 'Only visible to the profile owner'; #translate
$lang['settings:form_option_profile_hidden']	= 'Never visible'; #translate
$lang['settings:form_option_profile_member']	= 'Visible to any logged in user'; #translate
$lang['settings:form_option_activate_by_email']          = 'Activate by email'; #translate
$lang['settings:form_option_activate_by_admin']        	= 'Activate by admin'; #translate
$lang['settings:form_option_no_activation']         	= 'Instant activation'; #translate

// titles
$lang['settings:edit_title'] 					= 'Upravit nastavení';

// messages
$lang['settings:no_settings']					= 'There are currently no settings.'; #translate
$lang['settings:save_success'] 					= 'Nastavení bylo uloženo';

/* End of file settings_lang.php */