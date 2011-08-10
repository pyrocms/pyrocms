<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['settings_save_success']					= 'Twoje ustawienia zostały zapisane!';
$lang['settings_edit_title']					= 'Edytuj ustawienia';

#section settings
$lang['settings_site_name']						= 'Nazwa strony';
$lang['settings_site_name_desc']				= 'Nazwa strony dla tytułów stron oraz do użytku na stronie.';

$lang['settings_site_slogan']					= 'Slogan strony';
$lang['settings_site_slogan_desc']				= 'Slogan strony dla tytułów stron oraz do użytku na stronie.';

$lang['settings_site_lang']						= 'Język strony';
$lang['settings_site_lang_desc']				= 'Natywny język strony, używany przy wyborze templet, e-maili wewnętrzych notyfikacji oraz przy otrzymywaniu wiadomości od użytkowników strony oraz innych opcji które nie powinny zmienić języka użytkownika.'; 

$lang['settings_contact_email']					= 'E-mail kontaktowy';
$lang['settings_contact_email_desc']			= 'Wszystkie e-maile od użytkowników, gości oraz samej strony internetowej będą kierowane na ten adres.';

$lang['settings_server_email']					= 'E-mail serwera';
$lang['settings_server_email_desc']				= 'Wszystkie e-maile do użytkowników będą pochodziły z tego adresu.';

$lang['settings_meta_topic']					= 'Meta temat';
$lang['settings_meta_topic_desc']				= 'Dwa lub trzy słowa, które będą opisywać tę stronę.';

$lang['settings_currency']						= 'Waluta';
$lang['settings_currency_desc']					= 'Symbol waluty do stosowania przy produktach, usługach, itp.';

$lang['settings_dashboard_rss']					= 'Kanał RSS na tablicy';
$lang['settings_dashboard_rss_desc']			= 'Link do kanału RSS, który będzie wyświetlany w zakładce Tablica informacyjna.';

$lang['settings_dashboard_rss_count']			= 'Ilość blogów RSS';
$lang['settings_dashboard_rss_count_desc']		= 'Ile wpisów z kanału RSS ma być wyświetlane w zakładce Tablica informacyjna?';

$lang['settings_date_format'] 					= 'Format daty';
$lang['settings_date_format_desc']				= 'How should dates be displayed accross the website and control panel? ' .
													'Using the <a href="http://php.net/manual/en/function.date.php" target="_black">date format</a> from PHP - OR - ' .
													'Używając formatu <a href="http://php.net/manual/en/function.strftime.php" target="_black">ciągu jako daty</a> z PHP.';

$lang['settings_frontend_enabled']				= 'Status strony';
$lang['settings_frontend_enabled_desc'] 		= 'Opcja ta pozwala na włączanie i wyłączanie strony dla zwykłych użytkowników i gości. Przydatna opcja m.in. podczas prowadzenia prac konserwacyjnych lub wprowadzenia usprawnień na stronie.';

$lang['settings_mail_protocol']					= 'Protokół poczty';
$lang['settings_mail_protocol_desc']			= 'Wybierz protokół pocztowy';

$lang['settings_mail_sendmail_path'] 			= 'Ścieżka do Sendmail';
$lang['settings_mail_sendmail_path_desc']		= 'Podaj ścieżkę do Sendmail na serwerze';

$lang['settings_mail_smtp_host']				= 'Nazwa hosta SMTP';
$lang['settings_mail_smtp_host_desc']			= 'Podaj nazwę serwera SMTP';

$lang['settings_mail_smtp_pass']				= 'Hasło SMTP';
$lang['settings_mail_smtp_pass_desc']			= 'Podaj hasło do SMTP';

$lang['settings_mail_smtp_port']				= 'Port SMTP';
$lang['settings_mail_smtp_port_desc']			= 'Podaj numer portu SMTP';

$lang['settings_mail_smtp_user']				= 'Nazwa użytkownika SMTP';
$lang['settings_mail_smtp_user_desc']			= 'Podaj nazwę użytkownika SMTP';

$lang['settings_unavailable_message']			= 'Wiadomość serwisowa';
$lang['settings_unavailable_message_desc']		= 'Kiedy strona jest wyłączona lub gdy wystąpi jakiś poważny problem, ta wiadomość będzie wyświetlana użytkownikom.';

$lang['settings_default_theme']					= 'Domyślny motyw';
$lang['settings_default_theme_desc']			= 'Wybierz który motyw ma być używany domyślnie.';

$lang['settings_activation_email']				= 'E-mail aktywacyjny';
$lang['settings_activation_email_desc']			= 'Wyślij e-mail do administratora strony, kiedy nowy użytkownik po zarejestrowaniu się aktywuje swoje konto. Wyłączenie tej opcji spowoduje, że tylko administratorzy będą mogli aktywować konta użytkowników.';

$lang['settings_records_per_page']				= 'Rekordów na stronę';
$lang['settings_records_per_page_desc']			= 'Jak wiele rekordów na stronę powinno być pokazywane w sekcji administracyjnej?';

$lang['settings_rss_feed_items']				= 'Ilość blogów RSS';
$lang['settings_rss_feed_items_desc']			= 'Ile elementów należy pokazać w kanale RSS/nowości?';

$lang['settings_require_lastname']				= 'Wymagane nazwisko?';
$lang['settings_require_lastname_desc']			= 'W niektórych sytuacjach nazwisko nie musi być wymagane. Czy chcesz wymusić na użytkownikach jego podawanie?';

$lang['settings_enable_profiles']				= 'Włącz profile';
$lang['settings_enable_profiles_desc']			= 'Pozwól użytkownikom na dodawanie i edycję profili.';

$lang['settings_ga_email']						= 'E-mail Google Analytic';
$lang['settings_ga_email_desc']					= 'Podaj adres e-mail, który używasz do logowania się na konto Google Analytic, wymagane do przedstawiania statystyk na Tablicy informacyjnej';

$lang['settings_ga_password']					= 'Hasło Google Analytic';
$lang['settings_ga_password_desc']				= 'Podaj hasło, które używasz do logowania się na konto Google Analytic, to również jest wymagane do przedstawiania statystyk na Tablicy informacyjnej';

$lang['settings_ga_profile']					= 'Klucz Google Analytic';
$lang['settings_ga_profile_desc']				= 'Podaj klucz śledzenia dla Google Analytic aby aktywować statystyki na stronie. Przykład: UA-19483569-6';

$lang['settings_ga_tracking'] 					= 'Kod śledzenia Google';
$lang['settings_ga_tracking_desc']				= 'Podaj swój kod śledzenia Google Analytic by aktywować Google Analytics widok. E.g: UA-19483569-6';

$lang['settings_twitter_username']				= 'Użytkownik';
$lang['settings_twitter_username_desc']			= 'Twoja nazwa użytkownika w serwisie Twitter.';

$lang['settings_twitter_consumer_key']			= 'Klucz klienta';
$lang['settings_twitter_consumer_key_desc']		= 'Klucz klienta Twitter.';

$lang['settings_twitter_consumer_key_secret']	= 'Prywatny klucz klienta';
$lang['settings_twitter_consumer_key_secret_desc'] = 'Prywatny klucz klienta Twitter.';

$lang['settings_twitter_blog']					= 'Integracja z Twitterem';
$lang['settings_twitter_blog_desc']				= 'Czy chciałbyś publikować linki do nowości i artykułów bezpośrednio w serwisie Twitter?';

$lang['settings_twitter_feed_count']			= 'Ilość wpisów z Twittera';
$lang['settings_twitter_feed_count_desc']		= 'Ile twittów powinno zostać przekazanych do bloku Twittera?';

$lang['settings_twitter_cache']					= 'Cache wpisów z Twittera';
$lang['settings_twitter_cache_desc']			= 'Przez ile minut Twoje twitty powinny być przechowywane?';

$lang['settings_akismet_api_key']				= 'Klucz API Akismet';
$lang['settings_akismet_api_key_desc']			= 'Akismet umożliwia blokowanie spamu - jest to narzędzie twórców systemu blogowego WordPress. Akismet pozwala utrzymać spam pod kontrolą bez zmuszania użytkowników do wypełniania formularzy z kodem CAPTCHA.';

$lang['settings_comment_order']					= 'Sortowanie komentarzy';
$lang['settings_comment_order_desc']			= 'Ustaw w jaki sposób mają być wyświetlane komentarze';

$lang['settings_moderate_comments']				= 'Moderacja komentarzy';
$lang['settings_moderate_comments_desc']		= 'Ustaw czy przed pojawieniem się na stronie, komentarze muszą zostać zatwierdzone przez administratora.';

$lang['settings_version']						= 'Wersja';
$lang['settings_version_desc']					= '';


#section titles
$lang['settings_section_general']				= 'Ogólne';
$lang['settings_section_integration']			= 'Integracja';
$lang['settings_section_comments']				= 'Komentarze';
$lang['settings_section_users']					= 'Użytkownicy';
$lang['settings_section_statistics']			= 'Statystyki';
$lang['settings_section_twitter']				= 'Twitter';

#checkbox and radio options
$lang['settings_form_option_Open']				= 'Otwarta';
$lang['settings_form_option_Closed']			= 'Zamknięta';
$lang['settings_form_option_Enabled']			= 'Włączone';
$lang['settings_form_option_Disabled']			= 'Wyłączone';
$lang['settings_form_option_Required']			= 'Wymagane';
$lang['settings_form_option_Optional']			= 'Opcjonalne';
$lang['settings_form_option_Oldest First']		= 'Najstarsze pierwsze'; 
$lang['settings_form_option_Newest First']		= 'Najnowsze pierwsze'; 

/* End of file settings_lang.php */
/* Location: ./system/cms/modules/settings/language/polish/settings_lang.php */
