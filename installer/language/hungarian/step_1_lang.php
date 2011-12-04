<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']			=	'Első lépés: Szerver és adatbázis beállításai';
$lang['intro_text']		=	'Mielőtt ellenőrzésre kerülne az adatbázis, tudnunk kell hogy hol található és miként lehet hozzáférni.';

$lang['db_settings']	=	'Adatbázis beállítások';
$lang['db_text']		=	'Ahhoz hogy a telepítő ellenőrizni tudja a MySQL szerver verzióját, szükség van a szerver címére, a bejelentkezéshez szolgáló felhasználónévre és a hozzá tartozó jelszóra, az alábbi űrlapban. Ezeket az adatokat fogja a telepítő használni a telepítés folyamán.';

$lang['server']			=	'Szerver';
$lang['username']		=	'Felhasználónév';
$lang['password']		=	'Jelszó';
$lang['portnr']			=	'Port';
$lang['server_settings']=	'Szerver Beállítások';
$lang['httpserver']		=	'HTTP Szerver';

$lang['httpserver_text']=	'PyroCMS-hez szükség van HTTP szerverre, hogy a dinamikus tartalom megjelenjen, ha egy felhasználó látogat a honlapra. De úgy tűnik már rendelkezik vele, mert látja ezt az oldalt, de ha tudja, hogy pontosan milyen típusú, akkor a PyroCMS mégjobban beállíthatja önmagát. Ha nem tudja, hogy alábbi beállítások mit jelentenek, akkor csak hagyja figyelmen kívül és folytassa a telepítést.';
$lang['rewrite_fail']	=	'A következő apache modul került kiválasztásra "(Apache with mod_rewrite)". Sajnos a telepítő nem tudja elldönteni hogy telepítve van-e a szerveren. Nem árt biztosra menni és kapcsolatba lépni a tárhely szolgáltatójával';
$lang['mod_rewrite']	=	'A következő apache modul került kiválasztásra: "(Apache with mod_rewrite)". Ez a modul nincs telepítve a szerveren. A tárhely szolgáltatója tudje ezeket aktiválni, nem ártana kapcsolatba lépni vele';
$lang['step2']			=	'Második lépés';

// messages
$lang['db_success']		=	'Az adatbázis beállítások tesztelve lettek és jól működnek.';
$lang['db_failure']		=	'Nem lehetett csatlakozni az adatbázishoz: ';

/* End of file step_1_lang.php */