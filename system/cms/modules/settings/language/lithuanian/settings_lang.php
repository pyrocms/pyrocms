<?php defined('BASEPATH') OR exit('No direct script access allowed');

#section settings
$lang['settings:site_name']                        = 'Svetainės vardas';
$lang['settings:site_name_desc']                = 'Svetainės pavadinimui ir kitoms reikmėms viduje.';

$lang['settings:site_slogan']                    = 'Svetainės šūkis';
$lang['settings:site_slogan_desc']                = 'Svetainės šūkis pridedamas prie vardo ir kitoms reikmėms svetainės viduje.';

$lang['settings:contact_email']                    = 'Kontaktinis E-paštas';
$lang['settings:contact_email_desc']            = 'Visi laiškai iš vartotojų, svečių ar svetainėje esančių formų siunčiami į šį e-pašto adresą.';

$lang['settings:server_email']                    = 'Serverio E-paštas';
$lang['settings:server_email_desc']                = 'Visi laiškai vartotojui ateis iš šio e-pašto adreso.';

$lang['settings:meta_topic']                    = 'Meta Tema';
$lang['settings:meta_topic_desc']                = 'Du, trys žodžiai apibūdinantys įmonės veiklą/svetainę.';

$lang['settings:currency']                        = 'Currency';
$lang['settings:currency_desc']                    = 'The currency symbol for use on products, services, etc.';

$lang['settings:dashboard_rss']                    = 'Įrankių skydo RSS įrašai';
$lang['settings:dashboard_rss_desc']            = 'Adresas iki RSS įrašų kurie bus rodomi įrankių skyde.';

$lang['settings:dashboard_rss_count']            = 'Įrankių skydo RSS kiekis';
$lang['settings:dashboard_rss_count_desc']        = 'Kiek RSS įrašų rodyti?';

$lang['settings:date_format']                    = 'Datos formatas';
$lang['settings:date_format_desc']                = 'Kaip data turi būti vaizduojama puslapyje ir jo valdyme? ' .
                                                    'Naudojant <a href="http://php.net/manual/en/function.date.php" target="_black">datos formatą</a> iš PHP - ARBA - ' .
                                                    'naudojant formatą <a href="http://php.net/manual/en/function.strftime.php" target="_black">strings formated as date</a> iš PHP.';

$lang['settings:frontend_enabled']                = 'Svetainės statusas';
$lang['settings:frontend_enabled_desc']            = 'Use this option to the user-facing part of the site on or off. Useful when you want to take the site down for maintenence';

$lang['settings:mail_protocol']                    = 'Pašto protokolas';
$lang['settings:mail_protocol_desc']            = 'Pasirinkite norimą pašto protokolą.';

$lang['settings:mail_sendmail_path']            = 'Sendmail kelias';
$lang['settings:mail_sendmail_path_desc']        = 'Kelias iki sendmail.';

$lang['settings:mail_smtp_host']                = 'SMTP adresas';
$lang['settings:mail_smtp_host_desc']            = 'Jūsų SMTP serverio adresas.';

$lang['settings:mail_smtp_pass']                = 'SMTP slaptažodis';
$lang['settings:mail_smtp_pass_desc']            = 'SMTP slaptažodis.';

$lang['settings:mail_smtp_port']                 = 'SMTP Portas';
$lang['settings:mail_smtp_port_desc']             = 'SMTP porto numeris.';

$lang['settings:mail_smtp_user']                 = 'SMTP vartotojas';
$lang['settings:mail_smtp_user_desc']             = 'SMTP vartotojas.';

$lang['settings:unavailable_message']            = 'Nepasiekiamumo žinutė';
$lang['settings:unavailable_message_desc']        = 'Kai svetainė yra išjungta ar yra tam tikru problemų, šis laiškas bus rodomas lankytojams.';

$lang['settings:default_theme']                    = 'Tema pagal nutylejimą';
$lang['settings:default_theme_desc']            = 'Išsirinkite temą kuria jus norite naudoti pagal nutylejimą.';

$lang['settings:activation_email']                = 'Aktivacijos el. paštas';
$lang['settings:activation_email_desc']            = 'Išsiunčia aktivacijos laišką su aktivacijos nuoroda kai lankytos užsiregistruoja. Atjunkite kad tik administratorius galėtu aktyvuoti vartotojus.';

$lang['settings:records_per_page']                = 'Įrašu per puslapį';
$lang['settings:records_per_page_desc']            = 'Kiek irašu turi buti rodomo administravimo paneleje per puslapį?';

$lang['settings:rss_feed_items']                = 'Feed įrašų kiekis';
$lang['settings:rss_feed_items_desc']            = 'Kiek įrašu turime rodyti RSS/blog ';


$lang['settings:enable_profiles']                = 'Ijungti profilius?';
$lang['settings:enable_profiles_desc']            = 'Leidžia vartotojams kurti bei tvarkyti profilius.';

$lang['settings:ga_email']                        = 'Google Analytic el. paštas';
$lang['settings:ga_email_desc']                    = 'El. paštas naudojamas Google Analytics, reikalinga tam kad parodyti grafikėli įrankių skyde.';

$lang['settings:ga_password']                    = 'Google Analytic slaptažodis';
$lang['settings:ga_password_desc']                = 'Google Analytics slaptažodis. Taip pat reikalinga tam kad parodyti grafikėli įrankių skyde.';

$lang['settings:ga_profile']                    = 'Google Analytic profilis';
$lang['settings:ga_profile_desc']                = 'Profilio ID šitam puslapiui Google Analytics.';

$lang['settings:ga_tracking']                    = 'Google Tracking kodas';
$lang['settings:ga_tracking_desc']                = 'Irašykite Google Analytic Tracking Code kad aktyvuotumėte Google Analytics peržiųrų skaičiavima. Pvz: UA-19483569-6';

$lang['settings:twitter_username']                = 'Vartotojas';
$lang['settings:twitter_username_desc']            = 'Twitterio vartotojas.';

$lang['settings:twitter_feed_count']            = 'Parašu kiekis';
$lang['settings:twitter_feed_count_desc']        = 'Kiek įrašų turi būti gražinta į Twitterio bloką?';

$lang['settings:twitter_cache']                    = 'Talpyklos (cache) laikas';
$lang['settings:twitter_cache_desc']            = 'Kiek minučių jūsų Twitterio irašai bus saugomi talpykolje?';

$lang['settings:akismet_api_key']                = 'Akismet API raktas';
$lang['settings:akismet_api_key_desc']            = 'Akismet yra anti-spamas nuo WordPress komandos. Užtikrina spam apsaugą nenaudojant CAPTCHA formų.';

$lang['settings:comment_order']                    = 'Komentaru rušiavimas';
$lang['settings:comment_order_desc']            = 'Rušiavimo tipas, pagal kurį rušiuojami komentarai.';

$lang['settings:moderate_comments']                = 'Moderuoti komentarus';
$lang['settings:moderate_comments_desc']        = 'Priverčia komentarus būti patvirtintiems prieš parodant puslapyje';

$lang['settings:version']                        = 'Versija';
$lang['settings:version_desc']                    = '';

$lang['settings:ckeditor_config']               = 'CKEditor nustatymai';
$lang['settings:ckeditor_config_desc']          = 'Pamatuti ivairius konfiguravimo nustatymus galie pažiūrėti <a target="_blank" href="http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html">CKEditorio dokumentacija.</a>';

$lang['settings:enable_registration']           = 'Įjungti vartotojų registraciją';
$lang['settings:enable_registration_desc']      = 'Leidžia vartotojų registraciją jūsų puslapyje.';

$lang['settings:profile_visibility']            = 'Profile Visibility'; #translate
$lang['settings:profile_visibility_desc']       = 'Specify who can view user profiles on the public site'; #translate

$lang['settings:cdn_domain']                    = 'CDN domenas';
$lang['settings:cdn_domain_desc']               = 'CDN domenas leidžia jums nuimti (statinių nuotraukų, css, js skriptų) apkrovimą nuo pagrindinio serverio. Pvz naudojant providerius tokius kaip Amazon CloudFront arba MaxCDN.';

#section titles
$lang['settings:section_general']                = 'Bendri';
$lang['settings:section_integration']            = 'Integracija';
$lang['settings:section_comments']                = 'Komentarai';
$lang['settings:section_users']                    = 'Vartotojai';
$lang['settings:section_statistics']            = 'Statistika';
$lang['settings:section_twitter']                = 'Twitteris';

#checkbox and radio options
$lang['settings:form_option_Open']                = 'Atidaryta';
$lang['settings:form_option_Closed']            = 'Uždaryta';
$lang['settings:form_option_Enabled']            = 'Įjungta';
$lang['settings:form_option_Disabled']            = 'Atjungta';
$lang['settings:form_option_Required']            = 'Būtina';
$lang['settings:form_option_Optional']            = 'Nebūtina';
$lang['settings:form_option_Oldest First']        = 'Senesni pirmiau';
$lang['settings:form_option_Newest First']        = 'Naujesni pirmiau';

// titles
$lang['settings:edit_title']                    = 'Redaguoti parametrus';

// messages
$lang['settings:no_settings']					= 'Šiuo metu jokių nustatymų nėra.';
$lang['settings:save_success']                    = 'Jūsų parametrai išsaugoti!';

/* End of file settings_lang.php */