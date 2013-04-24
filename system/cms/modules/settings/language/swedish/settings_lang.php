<?php defined('BASEPATH') or exit('No direct script access allowed');

 /**
 * Swedish translation.
 *
 * @author		marcus@incore.se
 * @package		PyroCMS  
 * @link		http://pyrocms.com
 * @date		2012-10-22
 * @version		1.1.0
 */

$lang['settings:site_name'] = 'Webbplatsens namn';
$lang['settings:site_name_desc'] = 'Webbplatsens namn för sidtitlar och annat.';
$lang['settings:site_slogan'] = 'Webbplatsens slogan';
$lang['settings:site_slogan_desc'] = 'Webbplatsens slogan för sidtitlar och annat.';
$lang['settings:site_lang'] = 'Webbplatsspråk';
$lang['settings:site_lang_desc'] = 'Grundspråk på webbplatsen, används för att välja mallar för e-postmeddelanden, kontakt formulär, och andra funktioner som inte bör vara beroende av vilket språk en användare valt.';
$lang['settings:contact_email'] = 'Kontakt e-post';
$lang['settings:contact_email_desc'] = 'All e-post från användare, gäster och webbplatsen kommer att gå till denna e-postadress.';
$lang['settings:server_email'] = 'Server e-post';
$lang['settings:server_email_desc'] = 'Alla e-post till användarna kommer från den här e-postadressen.';
$lang['settings:meta_topic'] = 'Metadata, ämne';
$lang['settings:meta_topic_desc'] = 'Två eller tre ord som beskriver denna typ av företag / webbplats.';
$lang['settings:currency'] = 'Valuta';
$lang['settings:currency_desc'] = 'Valutasymbol';
$lang['settings:dashboard_rss'] = 'Kontrollpanel RSS källa';
$lang['settings:dashboard_rss_desc'] = 'Länk till RSS källa som ska vara synlig i kontrollpanelen';
$lang['settings:dashboard_rss_count'] = 'Antal RSS meddelanden';
$lang['settings:dashboard_rss_count_desc'] = 'Antal RSS meddelanden som ska vara synliga i kontrollpanelen';
$lang['settings:date_format'] = 'Datumformat';
$lang['settings:date_format_desc'] = 'Hur ska datum visas över webbplatsen och i kontrollpanelen? Använd <a target="_blank" href="http://php.net/manual/en/function.date.php">date format</a> via PHP - eller - vill du använda <a target="_blank" href="http://php.net/manual/en/function.strftime.php">strängar formaterade som datum</a> via PHP.';
$lang['settings:frontend_enabled'] = 'Webbplatsstatus';
$lang['settings:frontend_enabled_desc'] = 'Använd denna funktion när du vill meddelan att webbplatsen ligger nere för underhåll.';
$lang['settings:mail_protocol'] = 'Protokoll för e-post';
$lang['settings:mail_protocol_desc'] = 'Välj e-post protokoll';
$lang['settings:mail_sendmail_path'] = 'Sökväg till Sendmail';
$lang['settings:mail_sendmail_path_desc'] = 'Sökväg till serverns sendmail-binärfil';
$lang['settings:mail_smtp_host'] = 'SMTP-Värd';
$lang['settings:mail_smtp_host_desc'] = 'Värdnamn för din SMTP-server';
$lang['settings:mail_smtp_pass'] = 'SMTP Lösenord';
$lang['settings:mail_smtp_pass_desc'] = 'SMTP lösenord.';
$lang['settings:mail_smtp_port'] = 'SMTP Port';
$lang['settings:mail_smtp_port_desc'] = 'SMTP portnummer';
$lang['settings:mail_smtp_user'] = 'SMTP Användarnamn';
$lang['settings:mail_smtp_user_desc'] = 'SMTP Användarnamn.';
$lang['settings:unavailable_message'] = 'Webbplatsen nere, meddelande';
$lang['settings:unavailable_message_desc'] = 'När webbplatsen ligger nere eller om det är problem med webbplatsen visas detta meddelande.';
$lang['settings:default_theme'] = 'Grundtema';
$lang['settings:default_theme_desc'] = 'Välj vilket tema användarna ska se som grundtema.';
$lang['settings:activation_email'] = 'Aktivering e-post';
$lang['settings:activation_email_desc'] = 'Skicka e-post med en aktiveringslänk när en besökare registrerat sig. Med detta avaktiverat kan endast administratörer aktivera användarkonton.';
$lang['settings:records_per_page'] = 'Poster per sida';
$lang['settings:records_per_page_desc'] = 'Hur många poster ska visas på varje sida i kontrollpanelen.';
$lang['settings:rss_feed_items'] = 'Antal RSS objekt';
$lang['settings:rss_feed_items_desc'] = 'Hur många objekt ska visas i RSS/blogg.';
$lang['settings:enable_profiles'] = 'Aktivera användardata';
$lang['settings:enable_profiles_desc'] = 'Tillåt användare att lägga till och ändra sina uppgifter.';
$lang['settings:ga_email'] = 'Google Analytic e-post';
$lang['settings:ga_email_desc'] = 'E-post som används av Google Analytics, detta behövs för att visa statistik på förstasidan i kontrollpanelen.';
$lang['settings:ga_password'] = 'Google Analytic lösenord';
$lang['settings:ga_password_desc'] = 'Google Analytic lösenord behövs för att visa statistik på förstasidan i kontrollpanelen.';
$lang['settings:ga_profile'] = 'Google Analytic Profil';
$lang['settings:ga_profile_desc'] = 'Profil ID för webbplatsen i Google Analytics.';
$lang['settings:ga_tracking'] = 'Google Tracking Code';
$lang['settings:ga_tracking_desc'] = 'Ange din "Google Analytic Tracking Code" för att aktivera Google Analytics åtkomst. Ex.: UA-19483569-6';
$lang['settings:twitter_username'] = 'Användarnamn';
$lang['settings:twitter_username_desc'] = 'Twitter användarnamn';
$lang['settings:twitter_feed_count'] = 'Antal Twitterinlägg';
$lang['settings:twitter_feed_count_desc'] = 'Hur många twitterinlägg ska visas i Twitterarean';
$lang['settings:twitter_cache'] = 'Cache-tid';
$lang['settings:twitter_cache_desc'] = 'Hur många minuter ska twitterinläggen cacheas';
$lang['settings:akismet_api_key'] = 'Akismet API Nyckel';
$lang['settings:akismet_api_key_desc'] = 'Akismet är en skräppost-blockerare från WordPress teamet. Det håller skräppost borta utan att använda CAPTCHA validering.';
$lang['settings:comment_order'] = 'Kommentarer, sortering';
$lang['settings:comment_order_desc'] = 'Välj i vilken ordning du vill visa kommentarer.';
$lang['settings:enable_comments'] = 'Aktivera kommentarer';
$lang['settings:enable_comments_desc'] = 'Tillåt användare att posta kommentarer?';
$lang['settings:moderate_comments'] = 'Moderera kommentarer';
$lang['settings:moderate_comments_desc'] = 'Godkänn kommentarer innan de visas på webbplatsen.';
$lang['settings:comment_markdown'] = 'Tillåt taggar';
$lang['settings:comment_markdown_desc'] = 'Vill du tillåta taggar i kommentarer?';
$lang['settings:version'] = 'Version';
$lang['settings:version_desc'] = 'Fallande';
$lang['settings:site_public_lang'] = 'Publikt språk';
$lang['settings:site_public_lang_desc'] = 'Vilka språk finns tillgängliga på webbplatsen?';
$lang['settings:admin_force_https'] = 'Tvinga kontrollpanelen att använda HTTPS';
$lang['settings:admin_force_https_desc'] = 'Tillåter endast HTTPS-access till kontrollpanelen.';
$lang['settings:files_cache'] = 'Fil-cache';
$lang['settings:files_cache_desc'] = 'Hur länge ska en bild cacheas när den hämtas via webbplatsen.com/files?';
$lang['settings:auto_username'] = 'Automatiskt användarnamn';
$lang['settings:auto_username_desc'] = 'Skapa ett användarnamn automatiskt, innebär att besökarna inte behöver ange detta vid registreringen. ';
$lang['settings:registered_email'] = 'E-post vid användarregistrering';
$lang['settings:registered_email_desc'] = 'Skickar automatiskt en notifiering via e-post när en besökare registrerar sig.';
$lang['settings:ckeditor_config'] = 'CKEditor konfigurering';
$lang['settings:ckeditor_config_desc'] = 'Du hittar en lista på giltiga konfigurationer här: <a target="_blank" href="http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html">CKEditor\'s documentation</a>.';
$lang['settings:enable_registration'] = 'Aktivera registrering';
$lang['settings:enable_registration_desc'] = 'tillåter att besökare registrerar sig via webbplatsen.';
$lang['settings:profile_visibility']            = 'Profile Visibility'; #translate
$lang['settings:profile_visibility_desc']       = 'Specify who can view user profiles on the public site'; #translate
$lang['settings:cdn_domain'] = 'CDN Domän';
$lang['settings:cdn_domain_desc'] = 'CDN domän tillåter att du kan använda statiskt innehåll från olika servertjänster som Amazon CloudFront eller MaxCDN.';
$lang['settings:section_general'] = 'Allmän';
$lang['settings:section_integration'] = 'Integration';
$lang['settings:section_comments'] = 'Kommentarer';
$lang['settings:section_users'] = 'Användare';
$lang['settings:section_statistics'] = 'Statistik';
$lang['settings:section_twitter'] = 'Twitter';
$lang['settings:section_files'] = 'Filer';
$lang['settings:form_option_Open'] = 'Öppen';
$lang['settings:form_option_Closed'] = 'Stängd';
$lang['settings:form_option_Enabled'] = 'Aktiverad';
$lang['settings:form_option_Disabled'] = 'Inaktiverad';
$lang['settings:form_option_Required'] = 'Obligatorisk';
$lang['settings:form_option_Optional'] = 'Valfri';
$lang['settings:form_option_Oldest First'] = 'Äldsta först';
$lang['settings:form_option_Newest First'] = 'Senaste först';
$lang['settings:form_option_Text Only'] = 'Endast text';
$lang['settings:form_option_Allow Markdown'] = 'Tillåt taggar';
$lang['settings:form_option_Yes'] = 'Ja';
$lang['settings:form_option_No'] = 'Nej';
$lang['settings:no_settings'] = 'Det finns inga inställningar';
$lang['settings:save_success'] = 'Inställningarna är sparade!';


/* End of file settings_lang.php */  
/* Location: system/cms/modules/settings/language/swedish/settings_lang.php */  
