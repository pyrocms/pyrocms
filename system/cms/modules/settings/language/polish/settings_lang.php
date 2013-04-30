<?php defined('BASEPATH') OR exit('No direct script access allowed');

#section settings
$lang['settings:site_name']					= 'Nazwa serwisu';
$lang['settings:site_name_desc']				= 'Nazwa serwisu dla tytułów stron oraz do użytku w serwisie.';

$lang['settings:site_slogan']					= 'Slogan serwisu';
$lang['settings:site_slogan_desc']				= 'Slogan serwisu dla tytułów stron oraz do użytku w serwisie.';

$lang['settings:site_lang']					= 'Język serwisu';
$lang['settings:site_lang_desc']				= 'Natywny język serwisu, używany przy wyborze skórki powiadomień e-mail, formularza kontaktowego oraz innych funkcji niezależnych od języka użytkownika.';

$lang['settings:contact_email']					= 'E-mail kontaktowy';
$lang['settings:contact_email_desc']				= 'Wszystkie e-maile od użytkowników, gości oraz samej strony internetowej będą kierowane na ten adres.';

$lang['settings:server_email']					= 'E-mail serwera';
$lang['settings:server_email_desc']				= 'Wszystkie e-maile do użytkowników będą pochodziły z tego adresu.';

$lang['settings:meta_topic']					= 'Meta temat';
$lang['settings:meta_topic_desc']				= 'Dwa lub trzy słowa, które będą opisywać tę stronę.';

$lang['settings:currency']					= 'Waluta';
$lang['settings:currency_desc']					= 'Symbol waluty do stosowania przy produktach, usługach, itp.';

$lang['settings:dashboard_rss']					= 'Kanał RSS w kokpicie';
$lang['settings:dashboard_rss_desc']				= 'Link do kanału RSS, który będzie wyświetlany w zakładce Kokpit.';

$lang['settings:dashboard_rss_count']				= 'Ilość blogów RSS';
$lang['settings:dashboard_rss_count_desc']			= 'Ile wpisów z kanału RSS ma być wyświetlane w zakładce Kokpit?';

$lang['settings:date_format'] 					= 'Format daty';
$lang['settings:date_format_desc']				= 'Jak daty powinny być wyświetlane w serwisie i panelu administratora? Używając <a href="http://php.net/manual/pl/function.date.php" target="_black">formatu daty</a> z PHP - czy -  używając formatu <a href="http://php.net/manual/en/function.strftime.php" target="_black">ciągu jako daty</a> z PHP.';

$lang['settings:frontend_enabled']				= 'Status strony';
$lang['settings:frontend_enabled_desc'] 			= 'Opcja ta pozwala na włączanie i wyłączanie strony dla zwykłych użytkowników i gości. Przydatna opcja m.in. podczas prowadzenia prac konserwacyjnych lub wprowadzania usprawnień w serwisie.';

$lang['settings:mail_protocol']					= 'Protokół poczty';
$lang['settings:mail_protocol_desc']				= 'Wybierz protokół pocztowy';

$lang['settings:mail_sendmail_path'] 				= 'Ścieżka do Sendmail';
$lang['settings:mail_sendmail_path_desc']			= 'Podaj ścieżkę do Sendmail na serwerze';

$lang['settings:mail_smtp_host']				= 'Nazwa hosta SMTP';
$lang['settings:mail_smtp_host_desc']				= 'Podaj nazwę serwera SMTP';

$lang['settings:mail_smtp_pass']				= 'Hasło SMTP';
$lang['settings:mail_smtp_pass_desc']				= 'Podaj hasło do SMTP';

$lang['settings:mail_smtp_port']				= 'Port SMTP';
$lang['settings:mail_smtp_port_desc']				= 'Podaj numer portu SMTP';

$lang['settings:mail_smtp_user']				= 'Nazwa użytkownika SMTP';
$lang['settings:mail_smtp_user_desc']				= 'Podaj nazwę użytkownika SMTP';

$lang['settings:unavailable_message']				= 'Wiadomość serwisowa';
$lang['settings:unavailable_message_desc']			= 'Kiedy strona jest wyłączona lub gdy wystąpi jakiś poważny problem, ta wiadomość będzie wyświetlana użytkownikom.';

$lang['settings:default_theme']					= 'Domyślny motyw';
$lang['settings:default_theme_desc']				= 'Wybierz który motyw ma być używany domyślnie.';

$lang['settings:activation_email']				= 'E-mail aktywacyjny';
$lang['settings:activation_email_desc']				= 'Wyślij e-mail do administratora strony, kiedy nowy użytkownik po zarejestrowaniu się aktywuje swoje konto. Wyłączenie tej opcji spowoduje, że tylko administratorzy będą mogli aktywować konta użytkowników.';

$lang['settings:records_per_page']				= 'Rekordów na stronę';
$lang['settings:records_per_page_desc']				= 'Jak wiele rekordów na stronę powinno być pokazywane w sekcji administracyjnej?';

$lang['settings:rss_feed_items']				= 'Ilość blogów RSS';
$lang['settings:rss_feed_items_desc']				= 'Ile elementów należy pokazać w kanale RSS/nowości?';


$lang['settings:enable_profiles']				= 'Włącz profile';
$lang['settings:enable_profiles_desc']				= 'Pozwól użytkownikom na dodawanie i edycję profili.';

$lang['settings:ga_email']					= 'E-mail Google Analytics';
$lang['settings:ga_email_desc']					= 'Podaj adres e-mail, który używasz do logowania się na konto Google Analytics, wymagane do przedstawiania statystyk w Kokpicie';

$lang['settings:ga_password']					= 'Hasło Google Analytics';
$lang['settings:ga_password_desc']				= 'Podaj hasło, które używasz do logowania się na konto Google Analytics, również wymagane do przedstawiania statystyk w Kokpicie';

$lang['settings:ga_profile']					= 'Profil Google Analytics';
$lang['settings:ga_profile_desc']				= 'Podaj ID profilu Google Analytics aby aktywować statystyki serwisu. Przykład: UA-19483569-6';

$lang['settings:ga_tracking'] 					= 'Kod śledzenia Google';
$lang['settings:ga_tracking_desc']				= 'Podaj swój kod śledzenia Google Analytics aby aktywować śledzenie odsłon serwisu. Przykład: UA-19483569-6';

$lang['settings:akismet_api_key']				= 'Klucz API Akismet';
$lang['settings:akismet_api_key_desc']				= 'Akismet umożliwia blokowanie spamu - jest to narzędzie twórców systemu blogowego WordPress. Akismet pozwala utrzymać spam pod kontrolą bez zmuszania użytkowników do wypełniania formularzy z kodem CAPTCHA.';

$lang['settings:comment_order']					= 'Sortowanie komentarzy';
$lang['settings:comment_order_desc']				= 'Ustaw w jaki sposób mają być wyświetlane komentarze';

$lang['settings:enable_comments'] 				= 'Włącz komentarze';
$lang['settings:enable_comments_desc']				= 'Czy chcesz pozwolić użytkownikom pisać komentarze?';

$lang['settings:moderate_comments']				= 'Moderacja komentarzy';
$lang['settings:moderate_comments_desc']			= 'Ustaw czy przed pojawieniem się na stronie komentarze muszą zostać zatwierdzone przez administratora.';

$lang['settings:comment_markdown']				= 'Włącz Markdown';
$lang['settings:comment_markdown_desc']				= 'Czy chcesz pozwolić użytkownikom pisać komentarze używając składni Markdown?';

$lang['settings:version']					= 'Wersja';
$lang['settings:version_desc']					= '';

$lang['settings:site_public_lang']				= 'Publiczne języki';
$lang['settings:site_public_lang_desc']				= 'Jakie języki będą oferowane wszystkim odwiedzającym Twój serwis?';

$lang['settings:admin_force_https']				= 'Wymuszać HTTPS dla Panelu administratora?';
$lang['settings:admin_force_https_desc']			= 'Pozwalać jedynie na bezpieczny protokół HTTPS podczas używania Panelu administratora?';

$lang['settings:files_cache']					= 'Pamięć cache dla plików';
$lang['settings:files_cache_desc']				= 'Kiedy wyświetlane są zdjęcia przez serwis.com/files, jaki powinien być czas trwania pamięci cache?';

$lang['settings:auto_username']					= 'Automatyczna nazwa użytkownika';
$lang['settings:auto_username_desc']				= 'Twórz nazwę użytkownika automatycznie, umożliwiając pominięcie jej podczas rejestracji.';

$lang['settings:registered_email']				= 'E-mail po rejestracji';
$lang['settings:registered_email_desc']				= 'Wyślij e-mail z powiadomieniem na adres kontaktowy kiedy ktoś się zarejestruje.';

$lang['settings:ckeditor_config']               = 'CKEditor Config'; #translate
$lang['settings:ckeditor_config_desc']          = 'You can find a list of valid configuration items in <a target="_blank" href="http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html">CKEditor\'s documentation.</a>'; #translate

$lang['settings:enable_registration']           = 'Enable user registration'; #translate
$lang['settings:enable_registration_desc']      = 'Allow users to register in your site.'; #translate

$lang['settings:profile_visibility']            = 'Profile Visibility'; #translate
$lang['settings:profile_visibility_desc']       = 'Specify who can view user profiles on the public site'; #translate

$lang['settings:cdn_domain']                    = 'CDN Domain'; #translate
$lang['settings:cdn_domain_desc']               = 'CDN domains allow you to offload static content to various edge servers, like Amazon CloudFront or MaxCDN.'; #translate

#section titles
$lang['settings:section_general']				= 'Ogólne';
$lang['settings:section_integration']				= 'Integracja';
$lang['settings:section_comments']				= 'Komentarze';
$lang['settings:section_users']					= 'Użytkownicy';
$lang['settings:section_statistics']				= 'Statystyki';
$lang['settings:section_files']					= 'Pliki';

#checkbox and radio options
$lang['settings:form_option_Open']				= 'Otwarta';
$lang['settings:form_option_Closed']				= 'Zamknięta';
$lang['settings:form_option_Enabled']				= 'Włączone';
$lang['settings:form_option_Disabled']				= 'Wyłączone';
$lang['settings:form_option_Required']				= 'Wymagane';
$lang['settings:form_option_Optional']				= 'Opcjonalne';
$lang['settings:form_option_Oldest First']			= 'Najpierw najstarsze';
$lang['settings:form_option_Newest First']			= 'Najpierw najnowsze';
$lang['settings:form_option_Text Only']				= 'Tylko tekst';
$lang['settings:form_option_Allow Markdown']			= 'Włącz Markdown';
$lang['settings:form_option_Yes']				= 'Tak';
$lang['settings:form_option_No']				= 'Nie';

// titles
$lang['settings:edit_title']					= 'Edytuj ustawienia';

// messages
$lang['settings:no_settings']					= 'Aktualnie nie ma żadnych ustawień.';
$lang['settings:save_success']					= 'Twoje ustawienia zostały zapisane!';

/* End of file settings_lang.php */