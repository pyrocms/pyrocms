<?php defined('BASEPATH') OR exit('No direct script access allowed');

#section settings
$lang['settings_site_name']						= 'Oldal neve';
$lang['settings_site_name_desc']				= 'A weboldal neve, ez jelenik meg a weboldal címsorában és a weboldalon (pl: a fejlécben)';

$lang['settings_site_slogan']					= 'Az oldal mottója';
$lang['settings_site_slogan_desc']				= 'Pár szavas leírás, használatra kerül az oldalon.';

$lang['settings_site_lang']						= 'Az oldal nyelve';
$lang['settings_site_lang_desc']				= 'A natív nyelve a weboldalnak, e-mail sablonokhoz, kapcsolattartási űrlaphoz és más funkcióhoz amiknek nem kéne függeni a felhasználó nyelvétől';

$lang['settings_contact_email']					= 'Kapcsolattartásra szolgáló E-mail cím';
$lang['settings_contact_email_desc']			= 'Az összes felhasználók által küldött email, erre a címre érkezik majd meg.';

$lang['settings_server_email']					= 'Szerver E-mail címe';
$lang['settings_server_email_desc']				= 'Minden e-mail amit a felhasználók kapnak, erről az email címről érkezik majd.';

$lang['settings_meta_topic']					= 'Meta leírás';
$lang['settings_meta_topic_desc']				= 'Két-három szó, ami leírja a vállakozást/weboldalt.';

$lang['settings_currency']						= 'Valuta';
$lang['settings_currency_desc']					= 'A valuta szimbólum, szolgáltatásokhoz stb...';

$lang['settings_dashboard_rss']					= 'Műszerfal RSS csatornája';
$lang['settings_dashboard_rss_desc']			= 'Egy RSS csatornának a linkje.';

$lang['settings_dashboard_rss_count']			= 'Műszerfal RSS cikkjei';
$lang['settings_dashboard_rss_count_desc']		= 'Hány cikk jelenjen meg a műszerfalon ?';

$lang['settings_date_format']					= 'Dátum formátum';
$lang['settings_date_format_desc']				= 'Hogyan jelenjenek meg a dátumok a weboldalon és a vezérlőpultban? A PHP <a target="_blank" href="http://php.net/manual/en/function.date.php">dátum formázási</a> függvényének segítségével illetve <a target="_blank" href="http://php.net/manual/en/function.strftime.php">a szöveges dátumok formázási</a> függvény segítségével lehet megadni';

$lang['settings_frontend_enabled']				= 'Oldal státusz';
$lang['settings_frontend_enabled_desc']			= 'Ezzel a funkcióval ki-be kapcsolhatja a weboldal láthatóságát. Hasznos, hogyha karbantartási munkálatok folynak a weboldalon';

$lang['settings_mail_protocol']					= 'Mail Protokol';
$lang['settings_mail_protocol_desc']			= 'Szabadon kiválasztható a levelező protopol.';

$lang['settings_mail_sendmail_path']			= 'Sendmail útvonal';
$lang['settings_mail_sendmail_path_desc']		= 'A sendmail szerver futtatható állománynak teljes útvonala.';

$lang['settings_mail_smtp_host']				= 'SMTP Hoszt';
$lang['settings_mail_smtp_host_desc']			= 'Az elérési címe az SMTP szervernek.';

$lang['settings_mail_smtp_pass']				= 'SMTP jelszó';
$lang['settings_mail_smtp_pass_desc']			= 'SMTP jelszó.';

$lang['settings_mail_smtp_port'] 				= 'SMTP Port';
$lang['settings_mail_smtp_port_desc'] 			= 'SMTP port száma.';

$lang['settings_mail_smtp_user'] 				= 'SMTP felhasználónév';
$lang['settings_mail_smtp_user_desc'] 			= 'SMTP felhasználónév.';

$lang['settings_unavailable_message']			= '"Nem elérhető" üzenet';
$lang['settings_unavailable_message_desc']		= 'Ha az oldal le van állítva (pl: karbantartási munkálatok alkalmával) illetve hogyha egy nagy jelentőségű hiba lép fel, ez az üzenet jelenik meg a felhasználók számára';

$lang['settings_default_theme']					= 'Alaprételmezett téma';
$lang['settings_default_theme_desc']			= 'Ezt a témát látják majd az oladl felhasználói.';

$lang['settings_activation_email']				= 'Email aktiváció';
$lang['settings_activation_email_desc']			= 'Ha egy felhasználó regisztrál az oldalon, akkor kap egy e-mail üzenetet, egy aktivációs linkkel. A funkció kikapcsolásával, csak adminisztrátorok tudnak új felhasználókat aktiválni.';

$lang['settings_records_per_page']				= 'Oldalankénti bejegyzések';
$lang['settings_records_per_page_desc']			= 'Hány bejegyzés jelenjen meg oldalanként, az admin részlegben?';

$lang['settings_rss_feed_items']				= 'RSS csatorna bejegyzéseinek száma';
$lang['settings_rss_feed_items_desc']			= 'Hány bejegyzés jelenjen meg az RSS csatornában, ileltve a blogban?';

$lang['settings_require_lastname']				= 'Vezetéknév szükséges?';
$lang['settings_require_lastname_desc']			= 'Néhány esetben a vezetékknév kitöltése nem kötelező. A beállítás aktiválásával, rákényszerülnek a felhasználók';

$lang['settings_enable_profiles']				= 'Profilok bekapcsolása';
$lang['settings_enable_profiles_desc']			= 'Saját profil engedélyezése a felhasználók számára.';

$lang['settings_ga_email']						= 'Google Analytics E-mail';
$lang['settings_ga_email_desc']					= 'A Google Analytics fiók, e-mail címe. Ennek segítéségvel jelennek meg a műszerfalon a látogatási statisztikák';

$lang['settings_ga_password']					= 'Google Analytics Jelszó';
$lang['settings_ga_password_desc']				= 'Szükséges megadni ahhoz, hogy megjelenjenek a látogatói statisztikák a weboldalon.';

$lang['settings_ga_profile']					= 'Google Analytic Profil';
$lang['settings_ga_profile_desc']				= 'Profil azonosító a weboldalhoz.';

$lang['settings_ga_tracking']					= 'Google Követési kód';
$lang['settings_ga_tracking_desc']				= 'Itt lehet megadni a Google Analytics követési kódját, aminek segítségével aktiválható az adatok rögzítése. pl: UA-19483569-6';

$lang['settings_twitter_username']				= 'Felhasználónév';
$lang['settings_twitter_username_desc']			= 'Twitter felhasználónév.';

$lang['settings_twitter_consumer_key']			= 'Twitter felhasználói kulcs';
$lang['settings_twitter_consumer_key_desc']		= '<i>(Twitter customer key)</i>'; #translate

$lang['settings_twitter_consumer_key_secret']	= 'Twitter felhasználói kulcs titok';
$lang['settings_twitter_consumer_key_secret_desc'] = 'Twitter consumer key secret.'; #translate

$lang['settings_twitter_blog']					= 'Twitter &amp; Blog integráció.';
$lang['settings_twitter_blog_desc']				= 'Küdjön a PyroCMS új blogbejegyzésekről linket a Twitterre?';

$lang['settings_twitter_feed_count']			= 'Üzenetek száma';
$lang['settings_twitter_feed_count_desc']		= 'Hány twitter üzenet jelenjen meg a twitter blokkban?';

$lang['settings_twitter_cache']					= 'Cache időtartam';
$lang['settings_twitter_cache_desc']			= 'Hány percig legyenek rögzítve a gyorsítótárazott üzenetek?';

$lang['settings_akismet_api_key']				= 'Akismet API kulcs';
$lang['settings_akismet_api_key_desc']			= 'Akismet, a WordPress csapat spam-szűrő alkalmazása. Automatikusan felügyelet alatt tartja a kéretlen üzeneteket, anélkül hogy a felhasználókat emberi ellenőrzéseken küldenék végig.';

$lang['settings_comment_order']					= 'Hozzászólás rendezés';
$lang['settings_comment_order_desc']			= 'Hogyan legyenek rendezve a hozzászólások?';

$lang['settings_enable_comments'] 				= 'Hozzászólások engedélyezése';
$lang['settings_enable_comments_desc']			= 'Engedélyezve legyen a felhasználóknak a hozzászólás?';

$lang['settings_moderate_comments']				= 'Hozzászólások moderálása';
$lang['settings_moderate_comments_desc']		= 'Mielőtt megjelenik egy hozzászólás a weboldalon, várjon visszaigazolásra?';

$lang['settings_comment_markdown']				= 'Allow Markdown'; #translate
$lang['settings_comment_markdown_desc']			= 'Do you want to allow visitors to post comments using Markdown?'; #translate

$lang['settings_version']						= 'Verzió';
$lang['settings_version_desc']					= '';

$lang['settings_site_public_lang']				= 'Nyilvános nyelv';
$lang['settings_site_public_lang_desc']			= 'Melyik nyelv legyen beállítva a weboldalon?';

$lang['settings_admin_force_https']				= 'HTTPS kényszerítése a műszerfal eléréséhez';
$lang['settings_admin_force_https_desc']		= 'Csak HTTPS protokollal lehessen használni a műszerfalat?';

$lang['settings_files_cache']					= 'Files Cache'; #translate
$lang['settings_files_cache_desc']				= 'When outputting an image via site.com/files what shall we set the cache expiration for?'; #translate

$lang['settings_auto_username']					= 'Auto Username'; #translate
$lang['settings_auto_username_desc']			= 'Create the username automatically, meaning users can skip making one on registration.'; #translate

$lang['settings_registered_email']				= 'User Registered Email'; #translate
$lang['settings_registered_email_desc']			= 'Send a notification email to the contact e-mail when someone registers.'; #translate

#section titles
$lang['settings_section_general']				= 'Általános';
$lang['settings_section_integration']			= 'Integriáció';
$lang['settings_section_comments']				= 'Hozzászólások';
$lang['settings_section_users']					= 'Felhasználók';
$lang['settings_section_statistics']			= 'Statisztiák';
$lang['settings_section_twitter']				= 'Twitter';
$lang['settings_section_files']					= 'Fájlok';

#checkbox and radio options
$lang['settings_form_option_Open']				= 'Nyílt';
$lang['settings_form_option_Closed']			= 'Zárt';
$lang['settings_form_option_Enabled']			= 'Bekapcsolt';
$lang['settings_form_option_Disabled']			= 'Kikapcsolt';
$lang['settings_form_option_Required']			= 'Szükséges';
$lang['settings_form_option_Optional']			= 'Egyedi';
$lang['settings_form_option_Oldest First']		= 'Régieket felülre';
$lang['settings_form_option_Newest First']		= 'Újakat felülre';
$lang['settings_form_option_Text Only']			= 'Csak szöveg';
$lang['settings_form_option_Allow Markdown']	= 'Allow Markdown'; #translate
$lang['settings_form_option_Yes']				= 'Igen';
$lang['settings_form_option_No']				= 'Nem';

// titles
$lang['settings_edit_title']					= 'Beállítások szerkesztése';

// messages
$lang['settings_no_settings']					= 'Nincsenek beállítások.';
$lang['settings_save_success']					= 'Beállítások sikeresen elmentve!';

/* End of file settings_lang.php */