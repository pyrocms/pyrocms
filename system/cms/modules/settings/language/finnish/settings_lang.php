<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Finnish translation.
 *
 * @author Mikael Kundert
 */

#section settings
$lang['settings:site_name']						= 'Sivuston nimi';
$lang['settings:site_name_desc']				= 'Sivuston nimi, jota näytetään ympäri sivustoa.';

$lang['settings:site_slogan']					= 'Sivuston iskulause';
$lang['settings:site_slogan_desc']				= 'Sivuston iskulause, jota käytetään ympäri sivustoa.';

$lang['settings:site_lang']						= 'Sivuston kieli';
$lang['settings:site_lang_desc']				= 'Sivuston natiivinen kieli, jota käytetään sähköposiviestien mallipohjissa, sisäisissä ilmoituksissa, vastaanotettujen vieraiden yhteydenottoja ja muut ominaisuudet, jotka eivät ole riippuvaisia kävijän kielivalinnasta.';

$lang['settings:contact_email']					= 'Yhteydenotto sähköpostiosoite';
$lang['settings:contact_email_desc']			= 'Kaikki yhteydenotot lähetetään tähän osoitteeseen.';

$lang['settings:server_email']					= 'Palvelimen sähköpostiosoite';
$lang['settings:server_email_desc']				= 'Sivuston lähettämät sähköpostit lähetetään tästä osoitteesta.';

$lang['settings:meta_topic']					= 'Meta aihe';
$lang['settings:meta_topic_desc']				= 'Muutama sana, joka kertoo yrityksestäsi/sivustostasi.';

$lang['settings:currency']						= 'Valuutta';
$lang['settings:currency_desc']					= 'Valuutta symboli, jota käytetään tuotteiden hinnoissa, palveluissa jne.';

$lang['settings:dashboard_rss']					= 'Dashboard RSS syöte';
$lang['settings:dashboard_rss_desc']			= 'Linkki RSS syötteeseen, joka näytetään dashboardissa.';

$lang['settings:dashboard_rss_count']			= 'Dashboard RSS syötteitä';
$lang['settings:dashboard_rss_count_desc']		= 'Kuinka monta syötettä haluat listaa dashboardissa?';

$lang['settings:date_format']					= 'Päiväyksen muoto';
$lang['settings:date_format_desc']				= 'Miten päiväyksen muoto tulisi olla sivustolla ja hallintapaneelissa? ' .
													'Käyttämällä PHP:n <a href="http://php.net/manual/en/function.date.php" target="_black">date muotoa</a> - TAI - ' .
													'Käyttämällä PHP:n <a href="http://php.net/manual/en/function.strftime.php" target="_black">strftime muotoa</a>.';

$lang['settings:frontend_enabled']				= 'Sivuston status';
$lang['settings:frontend_enabled_desc']			= 'Käytä tätä asetusta kun et halua näyttää sivuja käyttäjille. Käytetään yleensä sivuston ylläpidon yhteydessä.';

$lang['settings:mail_protocol']					= 'Sähköpostin protokolla';
$lang['settings:mail_protocol_desc']			= 'Valitse sähköpostin protokolla.';

$lang['settings:mail_sendmail_path']			= 'Sendmail polku';
$lang['settings:mail_sendmail_path_desc']		= 'Polku sendmailin binääiin.';

$lang['settings:mail_smtp_host']				= 'SMTP isäntä';
$lang['settings:mail_smtp_host_desc']			= 'Kirjoita isäntäpalvelimen osoite SMTP:lle.';

$lang['settings:mail_smtp_pass']				= 'SMTP salasana';
$lang['settings:mail_smtp_pass_desc']			= 'SMTP salasana.';

$lang['settings:mail_smtp_port'] 				= 'SMTP portti';
$lang['settings:mail_smtp_port_desc'] 			= 'SMTP palvelimen portin numero.';

$lang['settings:mail_smtp_user'] 				= 'SMTP käyttäjätunnus';
$lang['settings:mail_smtp_user_desc'] 			= 'SMTP käyttäjätunnus.';

$lang['settings:unavailable_message']			= 'Virheviesti';
$lang['settings:unavailable_message_desc']		= 'Kun palvelimella on teknisiä ongelmia tai jostain tuntemattomasta syystä ei pysty lähettämään, niin tämä viesti näytetään käyttäjälle.';

$lang['settings:default_theme']					= 'Oletus teema';
$lang['settings:default_theme_desc']			= 'Valitse teema, jotka käyttäjän näkevät oletuksena.';

$lang['settings:activation_email']				= 'Sähköpostin aktivoiminen';
$lang['settings:activation_email_desc']			= 'Lähettää rekisteröityneille käyttäjille aktivointi sähköpostiosoitteen. Poista tämä asetus käytöstä, jos haluat järjestelmänvalvojien hyväksyvän uusia käyttäjiä';

$lang['settings:records_per_page']				= 'Riviä per sivu';
$lang['settings:records_per_page_desc']			= 'Monta riviä haluat näytettävän yhdellä sivulla hallintapaneelissa?';

$lang['settings:rss_feed_items']				= 'Syötteen lukumäärä';
$lang['settings:rss_feed_items_desc']			= 'Monta artikkelia haluat näyttää RSS/uutis syötteissä?';


$lang['settings:enable_profiles']				= 'Profiili ominaisuus';
$lang['settings:enable_profiles_desc']			= 'Anna käyttäjille mahdollisuus muokata profiilia.';

$lang['settings:ga_email']						= 'Google Analytic sähköpostiosoite';
$lang['settings:ga_email_desc']					= 'Sähköpostiosoitteesi, jota käytät Google Analyticsissä. Tämä vaaditaan, jos haluat nähdä statistiikat dashboardissa.';

$lang['settings:ga_password']					= 'Google Analytic salasana';
$lang['settings:ga_password_desc']				= 'Google Analytics salasana. Tätä vaaditaan myös jos haluat nähdä statistiikat dashboardissa.';

$lang['settings:ga_profile']					= 'Google Analytic profiili';
$lang['settings:ga_profile_desc']				= 'Google Analyticsin profiilin ID.';

$lang['settings:ga_tracking']					= 'Google Tracking koodi';
$lang['settings:ga_tracking_desc']				= 'Syötä Google Analyticsin seuranta koodi, joka on muotoa: UA-19483569-6';

$lang['settings:twitter_username']				= 'Käyttäjätunnus';
$lang['settings:twitter_username_desc']			= 'Twitterin käyttäjätunnus.';

$lang['settings:twitter_feed_count']			= 'Syöte lukumäärä';
$lang['settings:twitter_feed_count_desc']		= 'Monta Twitterin syötteitä haluat näyttää lohkossa?';

$lang['settings:twitter_cache']					= 'Välimuistin aika';
$lang['settings:twitter_cache_desc']			= 'Monen minuutin välimuistitusta haluat käyttää Twitterin viesteihin?';

$lang['settings:akismet_api_key']				= 'Akismet API avain';
$lang['settings:akismet_api_key_desc']			= 'Akismet on roskapostin suodattaja WordPressin tekjöiltä. Se suojaa roskapostilta ilman, että käyttäjät joutuvat syöttämään kuvatunnisteen kirjaimia.';

$lang['settings:comment_order']					= 'Kommenttien järjestys';
$lang['settings:comment_order_desc']			= 'Määritä kommenttien järjestys.';

$lang['settings:enable_comments'] 				= 'Aktivoi Kommentit';
$lang['settings:enable_comments_desc']			= 'Salli kävijöiden jättää kommentteja?';
	
$lang['settings:moderate_comments']				= 'Moderoi kommentteja';
$lang['settings:moderate_comments_desc']		= 'Valitse tämä, jos haluat takistaa kommentit ennen julkaisua.';

$lang['settings:comment_markdown']				= 'Salli Markdown';
$lang['settings:comment_markdown_desc']			= 'Haluatko sallia käyttien jättää Markdown-muotoiltuja kommentteja?';

$lang['settings:version']						= 'Versio';
$lang['settings:version_desc']					= '';

$lang['settings:site_public_lang']				= 'Julkiset kielet';
$lang['settings:site_public_lang_desc']			= 'Mitkä kielet ovat tuettuna ja tarjotaa kävijöille?';

$lang['settings:admin_force_https']				= 'Pakota HTTPS salaus päälle?';
$lang['settings:admin_force_https_desc']		= 'Salli vain HTTPS protokollan käyttö ylläpidon puolella?';

$lang['settings:files_cache']					= 'Tiedostojen välimuisti';
$lang['settings:files_cache_desc']				= 'Kun kuva jaetaan site.com/files hakemistosta, kuinka pitkä välimuistin expiroitumis aika asetetaan?';

$lang['settings:auto_username']					= 'Automaattinen käyttäjätunnus';
$lang['settings:auto_username_desc']			= 'Luo käyttäjätunnus automaattiseti, niin että käyttäjät voivat jättää sen kentän täyttämättä.';

$lang['settings:registered_email']				= 'Ilmoitus rekisteröitymisestä';
$lang['settings:registered_email_desc']			= 'Lähetä sähköposti-ilmoitus kun joku rekisteröityy sivustolle.';

$lang['settings:ckeditor_config']               = 'CKEditor Asetukset';
$lang['settings:ckeditor_config_desc']          = 'Löydät listan CKEDitorin kentistä <a target="_blank" href="http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html">CKEditorin ohjeista.</a>';

$lang['settings:enable_registration']           = 'Käyttäjien rekisteröityminen';
$lang['settings:enable_registration_desc']      = 'Salli käyttäjien rekisteröityä sivustolle.';

$lang['settings:profile_visibility']            = 'Profiilin näkyvyys';
$lang['settings:profile_visibility_desc']       = 'Määritä ketkä näkevät profiilit.';

$lang['settings:cdn_domain']                    = 'CDN verkkotunnus';
$lang['settings:cdn_domain_desc']               = 'CDN verkkotunnukset mahdollistaa staattisten tiedostojen ulkoistamisen useisiin palvelimiin, kuten Amazon CloudFront tai MaxCDN.';

#section titles
$lang['settings:section_general']				= 'Yleistä';
$lang['settings:section_integration']			= 'Integrointi';
$lang['settings:section_comments']				= 'Kommentit';
$lang['settings:section_users']					= 'Käyttäjät';
$lang['settings:section_statistics']			= 'Statistiikat';
$lang['settings:section_twitter']				= 'Twitter';
$lang['settings:section_files']					= 'Tiedostot';

#checkbox and radio options
$lang['settings:form_option_Open']				= 'Avaa';
$lang['settings:form_option_Closed']			= 'Sulje';
$lang['settings:form_option_Enabled']			= 'Päällä';
$lang['settings:form_option_Disabled']			= 'Pois päältä';
$lang['settings:form_option_Required']			= 'Pakollinen';
$lang['settings:form_option_Optional']			= 'Vaihtoehtoinen';
$lang['settings:form_option_Oldest First']		= 'Vanhin ensin';
$lang['settings:form_option_Newest First']		= 'Uusin ensin';
$lang['settings:form_option_Text Only']			= 'Vain Teksti';
$lang['settings:form_option_Allow Markdown']	= 'Salli Markdown';
$lang['settings:form_option_Yes']				= 'Kyllä';
$lang['settings:form_option_No']				= 'Ei';
$lang['settings:form_option_profile_public']	= 'Näkyy kaikille';
$lang['settings:form_option_profile_owner']		= 'Näkyy vain profiilin omistajalle';
$lang['settings:form_option_profile_hidden']	= 'Ei näkyvillä';
$lang['settings:form_option_profile_member']	= 'Näkyy kirjautuneille käyttäjille';
$lang['settings:form_option_activate_by_email']	= 'Aktivoi sähköpostitse';
$lang['settings:form_option_activate_by_admin']	= 'Aktivoi ylläpitäjien toimesta';
$lang['settings:form_option_no_activation']		= 'Ei aktivointia';

// titles
$lang['settings:edit_title']					= 'Muokkaa asetuksia';

// messages
$lang['settings:no_settings']					= 'Asetuksia ei ole määritetty.';
$lang['settings:save_success']					= 'Asetukset tallennettiin!';

/* End of file settings_lang.php */