<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Finnish translation.
 * 
 * @author Mikael Kundert <mikael@kundert.fi>
 * @date 07.02.2011
 * @version 1.0.3
 */

$lang['settings_save_success']					= 'Asetukset tallennettiin!';
$lang['settings_edit_title']					= 'Muokkaa asetuksia';

#section settings
$lang['settings_site_name']						= 'Sivuston nimi';
$lang['settings_site_name_desc']				= 'Sivuston nimi, jota näytetään ympäri sivustoa.';

$lang['settings_site_slogan']					= 'Sivuston iskulause';
$lang['settings_site_slogan_desc']				= 'Sivuston iskulause, jota käytetään ympäri sivustoa.';

$lang['settings_site_lang']						= 'Sivuston kieli';
$lang['settings_site_lang_desc']				= 'Sivuston natiivinen kieli, jota käytetään sähköposiviestien mallipohjissa, sisäisissä ilmoituksissa, vastaanotettujen vieraiden yhteydenottoja ja muut ominaisuudet, jotka eivät ole riippuvaisia kävijän kielivalinnasta.';

$lang['settings_contact_email']					= 'Yhteydenotto sähköpostiosoite';
$lang['settings_contact_email_desc']			= 'Kaikki yhteydenotot lähetetään tähän osoitteeseen.';

$lang['settings_server_email']					= 'Palvelimen sähköpostiosoite';
$lang['settings_server_email_desc']				= 'Sivuston lähettämät sähköpostit lähetetään tästä osoitteesta.';

$lang['settings_meta_topic']					= 'Meta aihe';
$lang['settings_meta_topic_desc']				= 'Muutama sana, joka kertoo yrityksestäsi/sivustostasi.';

$lang['settings_currency']						= 'Valuutta';
$lang['settings_currency_desc']					= 'Valuutta symboli, jota käytetään tuotteiden hinnoissa, palveluissa jne.';

$lang['settings_dashboard_rss']					= 'Dashboard RSS syöte';
$lang['settings_dashboard_rss_desc']			= 'Linkki RSS syötteeseen, joka näytetään dashboardissa.';

$lang['settings_dashboard_rss_count']			= 'Dashboard RSS syötteitä';
$lang['settings_dashboard_rss_count_desc']		= 'Kuinka monta syötettä haluat listaa dashboardissa?';

$lang['settings_date_format']					= 'Päiväyksen muoto';
$lang['settings_date_format_desc']				= 'Miten päiväyksen muoto tulisi olla sivustolla ja hallintapaneelissa? ' .
													'Käyttämällä PHP:n <a href="http://php.net/manual/en/function.date.php" target="_black">date muotoa</a> - TAI - ' .
													'Käyttämällä PHP:n <a href="http://php.net/manual/en/function.strftime.php" target="_black">strftime muotoa</a>.';

$lang['settings_frontend_enabled']				= 'Sivuston status';
$lang['settings_frontend_enabled_desc']			= 'Käytä tätä asetusta kun et halua näyttää sivuja käyttäjille. Käytetään yleensä sivuston ylläpidon yhteydessä.';

$lang['settings_mail_protocol']					= 'Sähköpostin protokolla';
$lang['settings_mail_protocol_desc']			= 'Valitse sähköpostin protokolla.';

$lang['settings_mail_sendmail_path']			= 'Sendmail polku';
$lang['settings_mail_sendmail_path_desc']		= 'Polku sendmailin binääiin.';

$lang['settings_mail_smtp_host']				= 'SMTP isäntä';
$lang['settings_mail_smtp_host_desc']			= 'Kirjoita isäntäpalvelimen osoite SMTP:lle.';

$lang['settings_mail_smtp_pass']				= 'SMTP salasana';
$lang['settings_mail_smtp_pass_desc']			= 'SMTP salasana.';

$lang['settings_mail_smtp_port'] 				= 'SMTP portti';
$lang['settings_mail_smtp_port_desc'] 			= 'SMTP palvelimen portin numero.';

$lang['settings_mail_smtp_user'] 				= 'SMTP käyttäjätunnus';
$lang['settings_mail_smtp_user_desc'] 			= 'SMTP käyttäjätunnus.';

$lang['settings_unavailable_message']			= 'Virheviesti';
$lang['settings_unavailable_message_desc']		= 'Kun palvelimella on teknisiä ongelmia tai jostain tuntemattomasta syystä ei pysty lähettämään, niin tämä viesti näytetään käyttäjälle.';

$lang['settings_default_theme']					= 'Oletus teema';
$lang['settings_default_theme_desc']			= 'Valitse teema, jotka käyttäjän näkevät oletuksena.';

$lang['settings_activation_email']				= 'Sähköpostin aktivoiminen';
$lang['settings_activation_email_desc']			= 'Lähettää rekisteröityneille käyttäjille aktivointi sähköpostiosoitteen. Poista tämä asetus käytöstä, jos haluat järjestelmänvalvojien hyväksyvän uusia käyttäjiä';

$lang['settings_records_per_page']				= 'Riviä per sivu';
$lang['settings_records_per_page_desc']			= 'Monta riviä haluat näytettävän yhdellä sivulla hallintapaneelissa?';

$lang['settings_rss_feed_items']				= 'Syötteen lukumäärä';
$lang['settings_rss_feed_items_desc']			= 'Monta artikkelia haluat näyttää RSS/uutis syötteissä?';

$lang['settings_require_lastname']				= 'Vaadi sukunimet?';
$lang['settings_require_lastname_desc']			= 'Tietyissä tilanteissa sukunimi ei ole pakollinen. Haluatko vaatia käyttäjiltä sukunimeä?';

$lang['settings_enable_profiles']				= 'Profiili ominaisuus';
$lang['settings_enable_profiles_desc']			= 'Anna käyttäjille mahdollisuus muokata profiilia.';

$lang['settings_ga_email']						= 'Google Analytic sähköpostiosoite';
$lang['settings_ga_email_desc']					= 'Sähköpostiosoitteesi, jota käytät Google Analyticsissä. Tämä vaaditaan, jos haluat nähdä statistiikat dashboardissa.';

$lang['settings_ga_password']					= 'Google Analytic salasana';
$lang['settings_ga_password_desc']				= 'Google Analytics salasana. Tätä vaaditaan myös jos haluat nähdä statistiikat dashboardissa.';

$lang['settings_ga_profile']					= 'Google Analytic profiili';
$lang['settings_ga_profile_desc']				= 'Google Analyticsin profiilin ID.';

$lang['settings_ga_tracking']					= 'Google Tracking koodi';
$lang['settings_ga_tracking_desc']				= 'Syötä Google Analyticsin seuranta koodi, joka on muotoa: UA-19483569-6';

$lang['settings_twitter_username']				= 'Käyttäjätunnus';
$lang['settings_twitter_username_desc']			= 'Twitterin käyttäjätunnus.';

$lang['settings_twitter_consumer_key']			= 'Kuluttajan avain';
$lang['settings_twitter_consumer_key_desc']		= 'Twitterin kuluttaja avain (consumer key).';

$lang['settings_twitter_consumer_key_secret']		= 'Kuluttajan avaimen salaus';
$lang['settings_twitter_consumer_key_secret_desc']	= 'Twitterin kuluttaja avaimen salaus (consumer key secret).';

$lang['settings_twitter_blog']					= 'Twitter &amp; Uutisten integrointi.';
$lang['settings_twitter_blog_desc']				= 'Haluatko, että uutisartikkelit julkaistaan automaattisesti Twitterissä?';

$lang['settings_twitter_feed_count']			= 'Syöte lukumäärä';
$lang['settings_twitter_feed_count_desc']		= 'Monta Twitterin syötteitä haluat näyttää lohkossa?';

$lang['settings_twitter_cache']					= 'Välimuistin aika';
$lang['settings_twitter_cache_desc']			= 'Monen minuutin välimuistitusta haluat käyttää Twitterin viesteihin?';

$lang['settings_akismet_api_key']				= 'Akismet API avain';
$lang['settings_akismet_api_key_desc']			= 'Akismet on roskapostin suodattaja WordPressin tekjöiltä. Se suojaa roskapostilta ilman, että käyttäjät joutuvat syöttämään kuvatunnisteen kirjaimia.';

$lang['settings_comment_order']					= 'Kommenttien järjestys';
$lang['settings_comment_order_desc']			= 'Määritä kommenttien järjestys.';
	
$lang['settings_moderate_comments']				= 'Moderoi kommentteja';
$lang['settings_moderate_comments_desc']		= 'Valitse tämä, jos haluat takistaa kommentit ennen julkaisua.';

$lang['settings_version']						= 'Versio';
$lang['settings_version_desc']					= '';

#section titles
$lang['settings_section_general']				= 'Yleistä';
$lang['settings_section_integration']			= 'Integrointi';
$lang['settings_section_comments']				= 'Kommentit';
$lang['settings_section_users']					= 'Käyttäjät';
$lang['settings_section_statistics']			= 'Statistiikat';
$lang['settings_section_twitter']				= 'Twitter';

#checkbox and radio options
$lang['settings_form_option_Open']				= 'Avaa';
$lang['settings_form_option_Closed']			= 'Sulje';
$lang['settings_form_option_Enabled']			= 'Päällä';
$lang['settings_form_option_Disabled']			= 'Pois päältä';
$lang['settings_form_option_Required']			= 'Pakollinen';
$lang['settings_form_option_Optional']			= 'Vaihtoehtoinen';
$lang['settings_form_option_Oldest First']		= 'Vanhin ensin';
$lang['settings_form_option_Newest First']		= 'Uusin ensin';

/* End of file settings_lang.php */
/* Location: ./system/cms/modules/settings/language/finnish/settings_lang.php */
