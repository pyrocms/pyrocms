<?php defined('BASEPATH') or exit('No direct script access allowed');

// labels
$lang['header']                  = 'Első lépés: Szerver és adatbázis beállításai';
$lang['intro_text']              = 'A PyroCMS-t nagyon egyszerű telepíteni és csak pár percet vesz igénybe, de az itt feltett kérdések zavarba ejtőek lehetnek, ha nem rendelkezel megfelelő technikai tudásháttérrel. Ha valamelyik pontnál megakadnál, akkor kérdezd meg a tárhelyszolgáltatódat vagy <a href="http://www.pyrocms.com/contact" target="_blank">minket</a>, hogy segíthessünk!';

$lang['db_settings']             = 'Adatbázis beállítások';
$lang['db_text']                 = 'PyroCMS-hez szükség van egy adatbázisra (MySQL), ami tárolja az összes tartalmat és beállítást. Tehát elsőként ezt kell ellenőriznünk, hogy minden adatbázis beállitás rendben van-e. Ha nem tudod, hogy mit kell megadni, akkor kérd el az adatokat a tárhelyszolgáltatódtól vagy a szerver adminisztrátorától!';
$lang['db_missing']              = 'The mysql database driver for PHP were not found, installation cannot continue. Ask your host or server administrator to install it.'; #translate
$lang['db_create']	             = 'Adatbázis létrehozása';
$lang['db_notice']		           = 'Lehet, hogy ezt magadnak kell megtenned a hosting szolgáltatód kezelőfelületén.';
$lang['database']		             = 'MySQL adatbázis';

$lang['server']                  = 'MySQL Szerver név (hostname)';
$lang['username']                = 'MySQL Felhasználónév';
$lang['password']                = 'MySQL Jelszó';
$lang['portnr']                  = 'MySQL Port';
$lang['server_settings']         = 'Szerver Beállítások';
$lang['httpserver']              = 'HTTP Server';

$lang['httpserver_text']         = 'PyroCMS-nek HTTP szerverre van szüksége, hogy az oldal tartalma megjelenjen a látogatóknak. Úgy néz ki, hogy rendelkezel vele, mert látod ezt az oldalt, de azt is tundunk kell mi a típusa, hogy a PyroCMS még jobb legyen. Ha nem tudod, hogy ez mit jelent, akkor hagyd figyelmen kívül és folytasd a telepítést!';
$lang['rewrite_fail']            = 'A következő apache modul került kiválasztásra "(Apache with mod_rewrite)". Sajnos a telepítő nem tudja elldönteni hogy telepítve van-e a szerveren. Nem árt biztosra menni és kapcsolatba lépni a tárhelyszolgáltatóddal vagy kockáztass és telepítsd! ;)';
$lang['mod_rewrite']             = 'A következő apache modul került kiválasztásra "(Apache with mod_rewrite)". Ez a modul nincs engedélyezve a szerveren. Kérd meg a tárhelyszolgáltatódat, hogy engedélyezze vagy telepítsd az "Apache (without mod_rewrite)" beállítással!';
$lang['step2']                   = 'Második lépés';

// messages
$lang['db_success']              = 'Az adatbázis beállítások tesztelve lettek és jól működnek.';
$lang['db_failure']              = 'Nem lehetett csatlakozni az adatbázishoz: ';
