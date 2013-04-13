<?php defined('BASEPATH') OR exit('No direct script access allowed');

#section settings
$lang['settings:site_name']                         = 'Oldal neve';
$lang['settings:site_name_desc']                    = 'A weboldal neve - ez jelenik meg a weboldal címsorában és a weboldalon (pl: a fejlécben)';

$lang['settings:site_slogan']                       = 'Az oldal mottója';
$lang['settings:site_slogan_desc']                  = 'Pár szavas leírás, használatra kerül az oldalon.';

$lang['settings:site_lang']                         = 'Az oldal nyelve';
$lang['settings:site_lang_desc']                    = 'A weboldal natív nyelve, e-mail sablonokhoz, kapcsolattartási űrlaphoz és más funkcióhoz, amiknek nem kell függenie a felhasználó nyelvétől';

$lang['settings:contact_email']                     = 'Kapcsolattartásra szolgáló E-mail cím';
$lang['settings:contact_email_desc']                = 'Az összes, felhasználók által küldött e-mail erre a címre érkezik majd meg.';

$lang['settings:server_email']                      = 'Szerver E-mail címe';
$lang['settings:server_email_desc']                 = 'Minden e-mail, amit a felhasználók kapnak, erről az e-mail címről érkezik majd.';

$lang['settings:meta_topic']                        = 'Meta leírás';
$lang['settings:meta_topic_desc']                   = 'Két-három szó, ami leírja a vállakozást/weboldalt.';

$lang['settings:currency']                          = 'Valuta';
$lang['settings:currency_desc']                     = 'A valuta szimbóluma pl. szolgáltatásokhoz...';

$lang['settings:dashboard_rss']                     = 'Műszerfal RSS csatornája';
$lang['settings:dashboard_rss_desc']                = 'Egy RSS csatornának a linkje.';

$lang['settings:dashboard_rss_count']               = 'Műszerfal RSS cikkjei';
$lang['settings:dashboard_rss_count_desc']          = 'Hány cikk jelenjen meg a műszerfalon?';

$lang['settings:date_format']                       = 'Dátum formátum';
$lang['settings:date_format_desc']                  = 'Hogyan jelenjenek meg a dátumok a weboldalon és a vezérlőpultban? A PHP <a target="_blank" href="http://php.net/manual/en/function.date.php">dátum formázási</a> függvényének segítségével illetve <a target="_blank" href="http://php.net/manual/en/function.strftime.php">a szöveges dátumok formázási</a> függvény segítségével lehet megadni';

$lang['settings:frontend_enabled']                  = 'Oldal státusz';
$lang['settings:frontend_enabled_desc']             = 'Ezzel a funkcióval ki-be kapcsolhatod a weboldal láthatóságát. Hasznos, hogyha karbantartási munkálatok folynak a weboldalon';

$lang['settings:mail_protocol']                     = 'Levelező Protokoll';
$lang['settings:mail_protocol_desc']                = 'Szabadon kiválasztható a levelező protokoll.';

$lang['settings:mail_sendmail_path']                = 'Sendmail útvonal';
$lang['settings:mail_sendmail_path_desc']           = 'A sendmail szerverprogram futtatható állományának teljes útvonala.';

$lang['settings:mail_smtp_host']                    = 'SMTP hoszt';
$lang['settings:mail_smtp_host_desc']               = 'Az SMTP szerver elérési címe.';

$lang['settings:mail_smtp_pass']                    = 'SMTP jelszó';
$lang['settings:mail_smtp_pass_desc']               = 'SMTP jelszó.';

$lang['settings:mail_smtp_port']                    = 'SMTP Port';
$lang['settings:mail_smtp_port_desc']               = 'SMTP port száma.';

$lang['settings:mail_smtp_user']                    = 'SMTP felhasználónév';
$lang['settings:mail_smtp_user_desc']               = 'SMTP felhasználónév.';

$lang['settings:unavailable_message']               = '"Nem elérhető" üzenet';
$lang['settings:unavailable_message_desc']          = 'Ha az oldal le van állítva (pl: karbantartási munkálatok alkalmával), illetve ha egy nagy jelentőségű hiba lép fel, akkor ez az üzenet jelenik meg a felhasználók számára';

$lang['settings:default_theme']                     = 'Alaprételmezett sablon';
$lang['settings:default_theme_desc']                = 'Ezt a sablont látják majd az oldal felhasználói.';

$lang['settings:activation_email']                  = 'Email aktiváció';
$lang['settings:activation_email_desc']             = 'Ha egy felhasználó regisztrál az oldalon, akkor kap egy e-mail üzenetet egy aktivációs linkkel. A funkció kikapcsolásával, csak adminisztrátorok tudnak új felhasználókat aktiválni.';

$lang['settings:records_per_page']                  = 'Oldalankénti bejegyzések';
$lang['settings:records_per_page_desc']             = 'Hány bejegyzés jelenjen meg oldalanként, az admin részlegben?';

$lang['settings:rss_feed_items']                    = 'RSS csatorna bejegyzéseinek száma';
$lang['settings:rss_feed_items_desc']               = 'Hány bejegyzés jelenjen meg az RSS csatornában, illetve a blogban?';


$lang['settings:enable_profiles']                   = 'Profilok bekapcsolása';
$lang['settings:enable_profiles_desc']              = 'Saját profil engedélyezése a felhasználók számára.';

$lang['settings:ga_email']                          = 'Google Analytics E-mail';
$lang['settings:ga_email_desc']                     = 'A Google Analytics fiók, e-mail címe. Ennek segítéségvel jelennek meg a műszerfalon a látogatási statisztikák';

$lang['settings:ga_password']                       = 'Google Analytics Jelszó';
$lang['settings:ga_password_desc']                  = 'Szükséges megadni ahhoz, hogy megjelenjenek a látogatói statisztikák a weboldalon.';

$lang['settings:ga_profile']                        = 'Google Analytics Profil';
$lang['settings:ga_profile_desc']                   = 'Profil azonosító a weboldalhoz.';

$lang['settings:ga_tracking']                       = 'Google Követési kód';
$lang['settings:ga_tracking_desc']                  = 'Itt lehet megadni a Google Analytics követési kódját, aminek segítségével aktiválható az adatok rögzítése. pl: UA-19483569-6';

$lang['settings:twitter_username']                  = 'Felhasználónév';
$lang['settings:twitter_username_desc']             = 'Twitter felhasználónév.';

$lang['settings:twitter_feed_count']                = 'Üzenetek száma';
$lang['settings:twitter_feed_count_desc']           = 'Hány twitter üzenet jelenjen meg a twitter blokkban?';

$lang['settings:twitter_cache']                     = 'Cache időtartam';
$lang['settings:twitter_cache_desc']                = 'Mennyi ideig legyenek rögzítve a gyorsítótárazott üzenetek?';

$lang['settings:akismet_api_key']                   = 'Akismet API kulcs';
$lang['settings:akismet_api_key_desc']              = 'Akismet, a WordPress csapat spam-szűrő alkalmazása. Automatikusan felügyelet alatt tartja a kéretlen üzeneteket, anélkül hogy a felhasználókat emberi ellenőrzéseken küldenék végig.';

$lang['settings:comment_order']                     = 'Hozzászólás rendezés';
$lang['settings:comment_order_desc']                = 'Hogyan legyenek rendezve a hozzászólások?';

$lang['settings:enable_comments']                   = 'Hozzászólások engedélyezése';
$lang['settings:enable_comments_desc']              = 'Engedélyezve legyen a felhasználóknak a hozzászólás?';

$lang['settings:moderate_comments']                 = 'Hozzászólások moderálása';
$lang['settings:moderate_comments_desc']            = 'Mielőtt megjelenik egy hozzászólás a weboldalon, várjon a visszaigazolásra?';

$lang['settings:comment_markdown']                  = 'Markdown engedélyezése'; #magyarosítani  #nem célszerű
$lang['settings:comment_markdown_desc']             = 'Akarod a látogatóknak engedélyezni, hogy a hozzászólásokban Markdown-t használjanak?';

$lang['settings:version']                           = 'Verzió';
$lang['settings:version_desc']                      = 'Verziószám';

$lang['settings:site_public_lang']                  = 'Nyilvános nyelv';
$lang['settings:site_public_lang_desc']             = 'Melyik nyelv legyen beállítva a weboldalon?';

$lang['settings:admin_force_https']                 = 'HTTPS kényszerítése a műszerfal eléréséhez';
$lang['settings:admin_force_https_desc']            = 'Csak HTTPS protokollal lehessen használni a műszerfalat?';

$lang['settings:files_cache']                       = 'Fájlok gyorsítótárazása';
$lang['settings:files_cache_desc']                  = 'Mikor egy képet megjelenítünk a Fájlok-modulon keresztül, akkor mennyi ideig tároljuk a gyorsítótárban.';

$lang['settings:auto_username']                     = 'Automata felhasználónév';
$lang['settings:auto_username_desc']                = 'Létrehozhatunk automata felhasználóneveket, ha mondjuk a regisztráció során a felhasználó kihagyná.';

$lang['settings:registered_email']                  = 'Felhásználó regisztráció jelzése';
$lang['settings:registered_email_desc']             = 'Emlékeztető e-mail küldése a kapcsolati címre, mikor valaki regisztrál.';

$lang['settings:ckeditor_config']                   = 'CKEditor konfiguráció';
$lang['settings:ckeditor_config_desc']              = 'Az érvényes koncigurációs paraméterekről a <a target="_blank" href="http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html">CKEditor dokumentációjában</a> találhatsz egy listát.';

$lang['settings:enable_registration']               = 'Felhasználói regisztráció engefélyezése';
$lang['settings:enable_registration_desc']          = 'Engedélyezi a felhasználóknak hogy regisztráljanak a weboldaladra.';

$lang['settings:profile_visibility']            = 'Profile Visibility'; #translate
$lang['settings:profile_visibility_desc']       = 'Specify who can view user profiles on the public site'; #translate

$lang['settings:cdn_domain']                        = 'CDN domain';
$lang['settings:cdn_domain_desc']                   = 'A CDN domainek lehetővé teszik hogy kiszervezz statikus tartalmakat különböző "edge" szerverekre mint pl. Amazon, Cloudfront vagy MaxCDN.';

# section titles
$lang['settings:section_general']                   = 'Általános';
$lang['settings:section_integration']               = 'Integriáció';
$lang['settings:section_comments']                  = 'Hozzászólások';
$lang['settings:section_users']                     = 'Felhasználók';
$lang['settings:section_statistics']                = 'Statisztiák';
$lang['settings:section_twitter']                   = 'Twitter';
$lang['settings:section_files']                     = 'Fájlok';

# checkbox and radio options
$lang['settings:form_option_Open']                  = 'Nyílt';
$lang['settings:form_option_Closed']                = 'Zárt';
$lang['settings:form_option_Enabled']               = 'Bekapcsolva';
$lang['settings:form_option_Disabled']              = 'Kikapcsolva';
$lang['settings:form_option_Required']              = 'Szükséges';
$lang['settings:form_option_Optional']              = 'Egyedi';
$lang['settings:form_option_Oldest First']          = 'Régieket felülre';
$lang['settings:form_option_Newest First']          = 'Újakat felülre';
$lang['settings:form_option_Text Only']             = 'Csak szöveg';
$lang['settings:form_option_Allow Markdown']        = 'Markdown engedélyezése';
$lang['settings:form_option_Yes']                   = 'Igen';
$lang['settings:form_option_No']                    = 'Nem';

// messages
$lang['settings:no_settings']                       = 'Nincsenek beállítások.';
$lang['settings:save_success']                      = 'Beállítások sikeresen elmentve!';

/* End of file settings_lang.php */