<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']			=	'Krok 1: Konfiguracja bazy danych i serwera';
$lang['intro_text']		=	'Zanim sprawdzimy bazę danych, musimy wiedzieć gdzie ona się znajduje i jak się do niej zalogować.';

$lang['db_settings']	=	'Konfiguracja bazy danych';
$lang['db_text']		=	'Instalator potrzebuje nazwy serwera bazy danych MySQL, nazwę użytkownika i hasło. Dane te będą wykorzystane do zainstalowania PyroCMS.';

$lang['server']			=	'Serwer';
$lang['username']		=	'Użytkownik';
$lang['password']		=	'Hasło';
$lang['portnr']			=	'Port';
$lang['server_settings']=	'Ustawienia serwera';
$lang['httpserver']		=	'Serwer HTTP';
$lang['rewrite_fail']	=	'You have selected "(Apache with mod_rewrite)" but we are unable to tell if mod_rewrite is enabled on your server. Ask your host if mod_rewrite is enabled or simply install at your own risk.';
$lang['mod_rewrite']	=	'Zaznczyłes opcję "(Apache z mod_rewrite)" ale twój server nie ma aktywnego modułu rewrite. Zapytaj firmę hostingową by uaktywniła ten moduł albo zainstaluj PyroCMS używajac opcji "Apache (bez mod_rewrite)".';
$lang['step2']			=	'Krok 2';

// messages
$lang['db_success']		=	'Konfiguracja bazy danych została przetestowana i działa w porządku.';
$lang['db_failure']		=	'Nie można połączyć się z bazą danych: ';
