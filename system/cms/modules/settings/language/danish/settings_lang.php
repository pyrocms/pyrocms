<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['settings:save_success']					= 'Dine indstillinger er gemt!';
$lang['settings:edit_title']					= 'Redigér indstillinger';

#section settings
$lang['settings:site_name']						= 'Sidenavn';
$lang['settings:site_name_desc']				= 'Navnet på websitet for sidetitler og for brug af siden.';

$lang['settings:site_slogan']					= 'Sideslogan';
$lang['settings:site_slogan_desc']				= 'Sloganet for websitet for sidetitler og for brug af siden.';

$lang['settings:site_lang']						= 'Sidesprog';
$lang['settings:site_lang_desc']				= 'Standardsproget på sitet, som bruges til at vælge skabeloner til e-mail-meddelelser, kontaktformularer og andre funktioner, der afhænger af brugerens sprog.';

$lang['settings:contact_email']					= 'Kontakt e-mail';
$lang['settings:contact_email_desc']			= 'Alle e-mails fra brugere, gæster og websitet vil blive sendt til denne e-mailadresse.';

$lang['settings:server_email']					= 'Server e-mail';
$lang['settings:server_email_desc']				= 'Alle e-mails til brugere vil komme fra denne e-mailadresse.';

$lang['settings:meta_topic']					= 'Meta emne';
$lang['settings:meta_topic_desc']				= 'To eller tre ord beskriver denne type af virksomhed/website.';

$lang['settings:currency']						= 'Valuta';
$lang['settings:currency_desc']					= 'Valutaen som bruges for produkter, services, etc.';

$lang['settings:dashboard_rss']					= 'Panel RSS Feed';
$lang['settings:dashboard_rss_desc']			= 'Link til et RSS feed som vil blive vist på panelet.';

$lang['settings:dashboard_rss_count']			= 'Panel RSS Poster';
$lang['settings:dashboard_rss_count_desc']		= 'Hvor mange RSS poster vil du vise på dit panel ?';

$lang['settings:date_format']					= 'Datoformat';
$lang['settings:date_format_desc']				= 'Hvordan skal datoer vises på på tværs af websiden og kontrolpanelet? Vha. <a target="_blank" href="http://php.net/manual/en/function.date.php">date format</a> funktionen fra PHP - eller - vha. <a target="_blank" href="http://php.net/manual/en/function.strftime.php">strings formatted as date</a> formattering fra PHP.';

$lang['settings:frontend_enabled']				= 'Site Status';
$lang['settings:frontend_enabled_desc']			= 'Dette er hvad brugeren ser. Indstillingen er brugbar når du gerne vil tage sitet ned for vedligeholdelse';

$lang['settings:mail_protocol']					= 'Mailprotokol';
$lang['settings:mail_protocol_desc']			= 'Vælg foretruken mailprotokol.';

$lang['settings:mail_sendmail_path']			= 'Sendmail Sti';
$lang['settings:mail_sendmail_path_desc']		= 'Stien til server sendmail binary.';

$lang['settings:mail_smtp_host']				= 'SMTP Host';
$lang['settings:mail_smtp_host_desc']			= 'Host navnet på din smtp server.';

$lang['settings:mail_smtp_pass']				= 'SMTP kodeord';
$lang['settings:mail_smtp_pass_desc']			= 'SMTP kodeord.';

$lang['settings:mail_smtp_port'] 				= 'SMTP Port';
$lang['settings:mail_smtp_port_desc'] 			= 'SMTP port nummer.';

$lang['settings:mail_smtp_user'] 				= 'SMTP Brugernavn';
$lang['settings:mail_smtp_user_desc'] 			= 'SMTP brugernavn.';

$lang['settings:unavailable_message']			= 'Offline Meddelelse';
$lang['settings:unavailable_message_desc']		= 'Når sitet er taget ned eller der er et stort problem vil denne meddelelse blive vist til brugerne (istedet for sitet).';

$lang['settings:default_theme']					= 'Standardtema';
$lang['settings:default_theme_desc']			= 'Vælg det standardtema du vil have brugerne til at se.';

$lang['settings:activation_email']				= 'Aktiveringsemail';
$lang['settings:activation_email_desc']			= 'Send en e-mail med et aktiveringslink når en bruger registrerer sig. Slå dette fra, for kun at lade administratorer aktivere konti.';

$lang['settings:records_per_page']				= 'Resultater Per Side';
$lang['settings:records_per_page_desc']			= 'Hvor mange resultater skal vises per side i admin sektionen?';

$lang['settings:rss_feed_items']				= 'Feed poster antal';
$lang['settings:rss_feed_items_desc']			= 'Hvor mange poster skal vi vise i RSS/blog feeds?';


$lang['settings:enable_profiles']				= 'Slå profiler til';
$lang['settings:enable_profiles_desc']			= 'Tillad at brugere tilføjer og redigerer profiler.';

$lang['settings:ga_email']						= 'Google Analytic E-mail';
$lang['settings:ga_email_desc']					= 'E-mail addressen som bruges til  Google Analytics. Nødvendig for at vise en graf på panelet.';

$lang['settings:ga_password']					= 'Google Analytic Kodeord';
$lang['settings:ga_password_desc']				= 'Google Analytics kodeord. Denne er også nødvendig for at vise en graf på panelet.';

$lang['settings:ga_profile']					= 'Google Analytic Profil';
$lang['settings:ga_profile_desc']				= 'Profil-ID for dette website i Google Analytics.';

$lang['settings:ga_tracking']					= 'Google Sporingskode';
$lang['settings:ga_tracking_desc']				= 'Indtast din Google Analytic Sporingskode for at aktivere Google Analytics data indfangelse. F.eks.: UA-19483569-6';

$lang['settings:akismet_api_key']				= 'Akismet API Key';
$lang['settings:akismet_api_key_desc']			= 'Akismet er en spam-blocker fra WordPress teamet. Det holder spam under kontrol uden at tvinge brugere til at udfylde CAPTCHA formularer.';

$lang['settings:comment_order']					= 'Kommentar Rækkefølge';
$lang['settings:comment_order_desc']			= 'Rækkefølgen som kommentarerne vises i.';
	
$lang['settings:moderate_comments']				= 'Moderer Kommentarer';
$lang['settings:moderate_comments_desc']		= 'Tving kommentarer til at blive godkendt før de vises på sitet.';

$lang['settings:version']						= 'Version';
$lang['settings:version_desc']					= '';

$lang['settings:ckeditor_config']               = 'CKEditor Config'; #translate
$lang['settings:ckeditor_config_desc']          = 'You can find a list of valid configuration items in <a target="_blank" href="http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html">CKEditor\'s documentation.</a>'; #translate

$lang['settings:enable_registration']           = 'Enable user registration'; #translate
$lang['settings:enable_registration_desc']      = 'Allow users to register in your site.'; #translate

$lang['settings:profile_visibility']            = 'Profile Visibility'; #translate
$lang['settings:profile_visibility_desc']       = 'Specify who can view user profiles on the public site'; #translate

$lang['settings:cdn_domain']                    = 'CDN Domain'; #translate
$lang['settings:cdn_domain_desc']               = 'CDN domains allow you to offload static content to various edge servers, like Amazon CloudFront or MaxCDN.'; #translate

#section titles
$lang['settings:section_general']				= 'Generelt';
$lang['settings:section_integration']			= 'Integration';
$lang['settings:section_comments']				= 'Kommentarer';
$lang['settings:section_users']					= 'Brugere';
$lang['settings:section_statistics']			= 'Statistik';

#checkbox and radio options
$lang['settings:form_option_Open']				= 'Åben';
$lang['settings:form_option_Closed']			= 'Lukket';
$lang['settings:form_option_Enabled']			= 'Til';
$lang['settings:form_option_Disabled']			= 'Fra';
$lang['settings:form_option_Required']			= 'Påkrævet';
$lang['settings:form_option_Optional']			= 'Frivilligt';
$lang['settings:form_option_Oldest First']		= 'Ældste Først';
$lang['settings:form_option_Newest First']		= 'Nyeste Først';
$lang['settings:form_option_profile_public']	= 'Visible to everybody'; #translate
$lang['settings:form_option_profile_owner']		= 'Only visible to the profile owner'; #translate
$lang['settings:form_option_profile_hidden']	= 'Never visible'; #translate
$lang['settings:form_option_profile_member']	= 'Visible to any logged in user'; #translate
$lang['settings:form_option_activate_by_email']        	= 'Activate by email'; #translate
$lang['settings:form_option_activate_by_admin']        	= 'Activate by admin'; #translate
$lang['settings:form_option_no_activation']         	= 'Instant activation'; #translate

/* End of file settings_lang.php */
/* Location: ./system/cms/modules/settings/language/english/settings_lang.php */
