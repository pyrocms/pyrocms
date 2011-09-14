<?php defined('BASEPATH') OR exit('No direct script access allowed');

// labels
$lang['header']			=	'Krok 2: Sprawdzanie wymagań';
$lang['intro_text']		= 	'Instalator musi sprawdzić, czy Twój serwer obsługuje PyroCMS. Większość serwerów powinna być w stanie przejść ten test bez problemów.';
$lang['mandatory']		= 	'Wymagane';
$lang['recommended']	= 	'Zalecane';

$lang['server_settings']= 	'Konfiguracja serwera HTTP';
$lang['server_version']	=	'Twój serwer HTTP:';
$lang['server_fail']	=	'Twoja wersja serwera HTTP nie jest wspierana, jednak być może uda się zainstalować PyroCMS. Jeśli nie ma problemów z PHP i MySQL, PyroCMS powinno działać prawidłowo, jednak bez krótkich URL-i.';

$lang['php_settings']	=	'Konfiguracja PHP';
$lang['php_required']	=	'PyroCMS wymaga PHP w wersji %s lub wyższej.';
$lang['php_version']	=	'Twoja wersja PHP:';
$lang['php_fail']		=	'Twoja wersja PHP nie jest wspierana. Uaktualnij PHP na swoim serwerze.';

$lang['mysql_settings']	=	'Konfiguracja MySQL';
$lang['mysql_required']	=	'PyroCMS wymaga serwera MySQL w wersji 5.0 lub wyższej.';
$lang['mysql_version1']	=	'Twoja wersja serwera MySQL:';
$lang['mysql_version2']	=	'Twoja wersja klienta MySQL:';
$lang['mysql_fail']		=	'Twoja wersja MySQL nie jest wspierana. Uaktualnij MySQL na swoim serwerze.';

$lang['gd_settings']	=	'Konfiguracja GD';
$lang['gd_required']	= 	'PyroCMS wymaga biblioteki GD w wersji 1.0 lub wyższej.';
$lang['gd_version']		= 	'Twoja wersja GD:';
$lang['gd_fail']		=	'Nie można określić wersji GD. Najczęściej znaczy to, że biblioteka GD nie jest zainstalowana. PyroCMS będzie działał poprawnie, ale niektóre funkcje obsługi zdjęć mogą nie działać.';

$lang['summary']		=	'Podsumowanie';

$lang['zlib']			=	'Zlib';
$lang['zlib_required']	= 	'PyroCMS wymaga biblioteki Zlib, aby rozpakować i instalować skórki.';
$lang['zlib_fail']		=	'Nie można znaleźć Zlib. Najczęściej znaczy to, że biblioteka Zlib nie jest zainstalowana. PyroCMS będzie działał poprawnie, ale instalacja skórek może nie działać.';

$lang['curl']			=	'Curl';
$lang['curl_required']	=	'PyroCMS wymaga biblioteki Curl w celu wykonania połączeń z innymi stronami.';
$lang['curl_fail']		=	'Nie można znaleźć Curl. Najczęściej znaczy to, że biblioteka Curl nie jest zainstalowana. PyroCMS będzie działał poprawnie, ale niektóre jego funkcje mogą nie działać. Zaleca się, aby włączyć obsługę biblioteki Curl.';

$lang['summary_green']	=	'Twój serwer spełnia wszystkie wymagania dla PyroCMS, przejdź do następnego kroku.';
$lang['summary_orange']	=	'Twój serwer spełnia <em>większość</em> wymagań dla PyroCMS. Powinien on działał prawidłowo, ale niektóre funkcje mogą nie działać.';
$lang['summary_red']	=	'Twój serwer nie spełnia wymagań dla PyroCMS. Skontaktuj się z administratorem lub firmą hostingową.';
$lang['next_step']		=	'Przejdź do następnego kroku';
$lang['step3']			=	'Krok 3';
$lang['retry']			=	'Spróbuj ponownie';

// messages
$lang['step1_failure']	=	'Wypełnij wymagane pola w formularzu poniżej.';

/* End of file step_2_lang.php */
/* Location: ./installer/language/polish/step_2_lang.php */