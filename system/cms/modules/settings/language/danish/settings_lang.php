<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['settings_save_success']					= 'Dine indstillinger er gemt!';
$lang['settings_edit_title']					= 'Redigér indstillinger';

#section settings
$lang['settings_site_name']						= 'Sidenavn';
$lang['settings_site_name_desc']				= 'Navnet på websitet for sidetitler og for brug af siden.';

$lang['settings_site_slogan']					= 'Sideslogan';
$lang['settings_site_slogan_desc']				= 'Sloganet for websitet for sidetitler og for brug af siden.';

$lang['settings_site_lang']						= 'Sidesprog';
$lang['settings_site_lang_desc']				= 'Standardsproget på sitet, som bruges til at vælge skabeloner til e-mail-meddelelser, kontaktformularer og andre funktioner, der afhænger af brugerens sprog.';

$lang['settings_contact_email']					= 'Kontakt e-mail';
$lang['settings_contact_email_desc']			= 'Alle e-mails fra brugere, gæster og websitet vil blive sendt til denne e-mailadresse.';

$lang['settings_server_email']					= 'Server e-mail';
$lang['settings_server_email_desc']				= 'Alle e-mails til brugere vil komme fra denne e-mailadresse.';

$lang['settings_meta_topic']					= 'Meta emne';
$lang['settings_meta_topic_desc']				= 'To eller tre ord beskriver denne type af virksomhed/website.';

$lang['settings_currency']						= 'Valuta';
$lang['settings_currency_desc']					= 'Valutaen som bruges for produkter, services, etc.';

$lang['settings_dashboard_rss']					= 'Panel RSS Feed';
$lang['settings_dashboard_rss_desc']			= 'Link til et RSS feed som vil blive vist på panelet.';

$lang['settings_dashboard_rss_count']			= 'Panel RSS Poster';
$lang['settings_dashboard_rss_count_desc']		= 'Hvor mange RSS poster vil du vise på dit panel ?';

$lang['settings_date_format']					= 'Datoformat';
$lang['settings_date_format_desc']				= 'Hvordan skal datoer vises på på tværs af websiden og kontrolpanelet? Vha. <a target="_blank" href="http://php.net/manual/en/function.date.php">date format</a> funktionen fra PHP - eller - vha. <a target="_blank" href="http://php.net/manual/en/function.strftime.php">strings formatted as date</a> formattering fra PHP.';

$lang['settings_frontend_enabled']				= 'Site Status';
$lang['settings_frontend_enabled_desc']			= 'Dette er hvad brugeren ser. Indstillingen er brugbar når du gerne vil tage sitet ned for vedligeholdelse';

$lang['settings_mail_protocol']					= 'Mailprotokol';
$lang['settings_mail_protocol_desc']			= 'Vælg foretruken mailprotokol.';

$lang['settings_mail_sendmail_path']			= 'Sendmail Sti';
$lang['settings_mail_sendmail_path_desc']		= 'Stien til server sendmail binary.';

$lang['settings_mail_smtp_host']				= 'SMTP Host';
$lang['settings_mail_smtp_host_desc']			= 'Host navnet på din smtp server.';

$lang['settings_mail_smtp_pass']				= 'SMTP kodeord';
$lang['settings_mail_smtp_pass_desc']			= 'SMTP kodeord.';

$lang['settings_mail_smtp_port'] 				= 'SMTP Port';
$lang['settings_mail_smtp_port_desc'] 			= 'SMTP port nummer.';

$lang['settings_mail_smtp_user'] 				= 'SMTP Brugernavn';
$lang['settings_mail_smtp_user_desc'] 			= 'SMTP brugernavn.';

$lang['settings_unavailable_message']			= 'Offline Meddelelse';
$lang['settings_unavailable_message_desc']		= 'Når sitet er taget ned eller der er et stort problem vil denne meddelelse blive vist til brugerne (istedet for sitet).';

$lang['settings_default_theme']					= 'Standardtema';
$lang['settings_default_theme_desc']			= 'Vælg det standardtema du vil have brugerne til at se.';

$lang['settings_activation_email']				= 'Aktiveringsemail';
$lang['settings_activation_email_desc']			= 'Send en e-mail med et aktiveringslink når en bruger registrerer sig. Slå dette fra, for kun at lade administratorer aktivere konti.';

$lang['settings_records_per_page']				= 'Resultater Per Side';
$lang['settings_records_per_page_desc']			= 'Hvor mange resultater skal vises per side i admin sektionen?';

$lang['settings_rss_feed_items']				= 'Feed poster antal';
$lang['settings_rss_feed_items_desc']			= 'Hvor mange poster skal vi vise i RSS/blog feeds?';

$lang['settings_require_lastname']				= 'Påkræv efternavn?';
$lang['settings_require_lastname_desc']			= 'I nogle situationer er efternavn ikke påkrævet, vil du tvinge brugerne til at indtaste et eller ej?';

$lang['settings_enable_profiles']				= 'Slå profiler til';
$lang['settings_enable_profiles_desc']			= 'Tillad at brugere tilføjer og redigerer profiler.';

$lang['settings_ga_email']						= 'Google Analytic E-mail';
$lang['settings_ga_email_desc']					= 'E-mail addressen som bruges til  Google Analytics. Nødvendig for at vise en graf på panelet.';

$lang['settings_ga_password']					= 'Google Analytic Kodeord';
$lang['settings_ga_password_desc']				= 'Google Analytics kodeord. Denne er også nødvendig for at vise en graf på panelet.';

$lang['settings_ga_profile']					= 'Google Analytic Profil';
$lang['settings_ga_profile_desc']				= 'Profil-ID for dette website i Google Analytics.';

$lang['settings_ga_tracking']					= 'Google Sporingskode';
$lang['settings_ga_tracking_desc']				= 'Indtast din Google Analytic Sporingskode for at aktivere Google Analytics data indfangelse. F.eks.: UA-19483569-6';

$lang['settings_twitter_username']				= 'Brugernavn';
$lang['settings_twitter_username_desc']			= 'Twitter brugernavn.';

$lang['settings_twitter_consumer_key']			= 'Consumer Key';
$lang['settings_twitter_consumer_key_desc']		= 'Twitter consumer key.';

$lang['settings_twitter_consumer_key_secret']	= 'Consumer Key Secret';
$lang['settings_twitter_consumer_key_secret_desc'] = 'Twitter consumer key secret.';

$lang['settings_twitter_blog']					= 'Twitter &amp; Blog integration.';
$lang['settings_twitter_blog_desc']				= 'Vil du gerne poste links til nye blog-artikler på twitter?';

$lang['settings_twitter_feed_count']			= 'Feed Antal';
$lang['settings_twitter_feed_count_desc']		= 'Hvor mange tweets skal vises i twitter feed blokken?';

$lang['settings_twitter_cache']					= 'Cache tid';
$lang['settings_twitter_cache_desc']			= 'Hvor mange minutter skal dine Tweets gemmes?';

$lang['settings_akismet_api_key']				= 'Akismet API Key';
$lang['settings_akismet_api_key_desc']			= 'Akismet er en spam-blocker fra WordPress teamet. Det holder spam under kontrol uden at tvinge brugere til at udfylde CAPTCHA formularer.';

$lang['settings_comment_order']					= 'Kommentar Rækkefølge';
$lang['settings_comment_order_desc']			= 'Rækkefølgen som kommentarerne vises i.';
	
$lang['settings_moderate_comments']				= 'Moderer Kommentarer';
$lang['settings_moderate_comments_desc']		= 'Tving kommentarer til at blive godkendt før de vises på sitet.';

$lang['settings_version']						= 'Version';
$lang['settings_version_desc']					= '';

#section titles
$lang['settings_section_general']				= 'Generelt';
$lang['settings_section_integration']			= 'Integration';
$lang['settings_section_comments']				= 'Kommentarer';
$lang['settings_section_users']					= 'Brugere';
$lang['settings_section_statistics']			= 'Statistik';
$lang['settings_section_twitter']				= 'Twitter';

#checkbox and radio options
$lang['settings_form_option_Open']				= 'Åben';
$lang['settings_form_option_Closed']			= 'Lukket';
$lang['settings_form_option_Enabled']			= 'Til';
$lang['settings_form_option_Disabled']			= 'Fra';
$lang['settings_form_option_Required']			= 'Påkrævet';
$lang['settings_form_option_Optional']			= 'Frivilligt';
$lang['settings_form_option_Oldest First']		= 'Ældste Først';
$lang['settings_form_option_Newest First']		= 'Nyeste Først';

/* End of file settings_lang.php */
/* Location: ./system/cms/modules/settings/language/english/settings_lang.php */
