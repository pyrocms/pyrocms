<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']			=	'Krok 1: Konfiguracja bazy danych i serwera';
$lang['intro_text']		=	'Zanim sprawdzimy bazę danych, musimy wiedzieć gdzie ona się znajduje i jak się do niej zalogować.';

$lang['db_settings']		=	'Konfiguracja bazy danych';
$lang['db_text']		=	'Instalator potrzebuje nazwy serwera bazy danych MySQL, nazwę użytkownika i hasło. Dane te będą wykorzystane do zainstalowania PyroCMS.';
$lang['db_missing']		=	'The mysql database driver for PHP were not found, installation cannot continue. Ask your host or server administrator to install it.'; #translate

$lang['server']			=	'Serwer';
$lang['username']		=	'Użytkownik';
$lang['password']		=	'Hasło';
$lang['portnr']			=	'Port';
$lang['server_settings']	=	'Ustawienia serwera';
$lang['httpserver']		=	'Serwer HTTP';
$lang['httpserver_text']	=	'PyroCMS wymaga serwera HTTP aby wyświetlać dynamiczną treść kiedy użytkownik odwiedzi Twój serwis. Jeśli wiesz dokładnie jakiego typu jest Twój serwer HTTP, PyroCMS będzie mógł skonfigurować się jeszcze lepiej. Jeśli nie wiesz nic na ten temat, po prostu kontynuuj instalację.';
$lang['rewrite_fail']		=	'Wybrałeś opcję "(Apache z mod_rewrite)" ale nie jesteśmy w stanie stwierdzić czy mod_rewrite jest włączony na Twoim serwerze. Zapytaj firmę hostingową czy mod_rewrite jest włączony lub zainstaluj PyroCMS na własne ryzyko.';
$lang['mod_rewrite']		=	'Wybrałeś opcję "(Apache z mod_rewrite)" ale Twój serwer nie ma aktywnego modułu mod_rewrite. Poproś firmę hostingową aby uaktywniła ten moduł albo zainstaluj PyroCMS używajac opcji "Apache (bez mod_rewrite)".';
$lang['step2']			=	'Krok 2';

// messages
$lang['db_success']		=	'Konfiguracja bazy danych została przetestowana i działa w porządku.';
$lang['db_failure']		=	'Nie można połączyć się z bazą danych: ';
