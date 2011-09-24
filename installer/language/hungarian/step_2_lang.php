<?php defined('BASEPATH') OR exit('No direct script access allowed');

// labels
$lang['header']			=	'Második lépés: követelmények ellenőrzése';
$lang['intro_text']		= 	'Ebben a lépésben a telepítő azt ellenőrzi hogy alkalmas egyáltalán a szerver környezete a PyroCMS futtatására. A legtöbb szerver számára nem okoz gondot a PyroCMS működtetése.';
$lang['mandatory']		= 	'Kötelező';
$lang['recommended']	= 	'Ajánlott';

$lang['server_settings']= 	'HTTP Szerver beállítások';
$lang['server_version']	=	'Web-szerver szoftver:';
$lang['server_fail']	=	'A megadott szerver nem támogatott, ezért a PyroCMS lehet hogy nem fog működni. Amíg a PHP és a MySQL naprakész, a PyroCMS számára nem okoz gondot, csupán a beszédes URL-ek hiányoznak majd';

$lang['php_settings']	=	'PHP Beállítások';
$lang['php_required']	=	'A PyroCMS futtatásához javasolt a PHP %s verziónak a használata.';
$lang['php_version']	=	'A szerveren jelenleg a következő verziójú php fut ';
$lang['php_fail']	=	'Ahhoz hogy a PyroCMS megfelelően fusson, javasolt frissíteni a %s verziójú vagy ennél frissebb PHP verzióra.';

$lang['mysql_settings']	=	'MySQL Beállítások';
$lang['mysql_required']	=	'A PyroCMS futtatáshoz MySQL 5.0 verziójú vagy ennél újabb adatbázis szükséges.';
$lang['mysql_version1']	=	'A szerveren jelenleg a következő verzió fut';
$lang['mysql_version2']	=	'A kliensen jelenleg a következő verzió fut';
$lang['mysql_fail']	=	'A megadott MySQL verzió nem támogatott. A PyroCMS megfelelő futásának érdekében 5.0 vagy ennél frissebb verzióra van szükség';

$lang['gd_settings']	=	'GD Beállítások';
$lang['gd_required']	= 	'Képek módosításához a GD lib 1.0-s vagy ennél újabb verziót használ.';
$lang['gd_version']	= 	'A szerveren jelenleg a következő verzió fut';
$lang['gd_fail']	=	'Nem sikerült megállapítani a GD lib verzióját. Ez a legtöbb esetben azt jelenti, hogy nincs telepítve. A PyroCMS megfelelően fog futni, de képmanikulációkra nem lesz lehetőség.';

$lang['summary']		=	'Összegzés';

$lang['zlib']			=	'Zlib';
$lang['zlib_required']	= 	'PyroCMS Zlib segítségével tömöríti ki és telepíti az új témákat.';
$lang['zlib_fail']		=	'A telepítő nem találta a Zlib-et. Ez átlalában azt jelenti, hogy nincs telepítve. A PyroCMS megfelelően fog működni, de nem lesz lehetőség témák telepítésére. Erősen javasolt a Zlib telepítése.';

$lang['curl']			=	'Curl';
$lang['curl_required']	=	'PyroCMS számára szükséges Curl ahhoz hogy kapcsolatot tudjon teremteni más oldalakkal.';
$lang['curl_fail']	=	'Curl nem található. Ez a legtöbb esetben azt jelenti hogy nincs telepítve. PyroCMS megfelelően fog működni, de néhány funkció nem fog működni. Erősen javasolt a Curl lib telepítése/engedélyezése.';

$lang['summary_success']	=	'A szerver minden elvárásnak megfelelt, így a PyroCMS megfelelően fog futni. Jöhet a következő lépés!';
$lang['summary_partial']	=	'A szerver a <em>legtöbb</em> evárásnak megfelelt, ami azt jelenti hogy a környezet ugyan alkalmas a PyroCMS futtatására, de nagy a valószínűsége, hogy problémák lépnek fel képátméretezésnél, illetve indexképek készítésénél.';
$lang['summary_failure']	=	'Úgy tűnik, hogy a szerver nem alkalmas a PyroCMS futtatására, mivel nem felelt meg a szükséges elvárásoknak. Érdemes lenne kapcsolatba lépni a tárhely szolgáltatójával, a probléma megoldásának érdekében-';
$lang['next_step']		=	'A következő lépéshez';
$lang['step3']			=	'Lépés #3';
$lang['retry']			=	'Újra';

// messages
$lang['step1_failure']	=	'A telepítés folytatásához, szükséges kitölteni az alábbi mezőket';

/* End of file step_2_lang.php */
/* Location: ./installer/language/english/step_2_lang.php */
