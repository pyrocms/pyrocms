<?php defined('BASEPATH') OR exit('No direct script access allowed');

// labels
$lang['header']			=	'Korak 2: Preveritev strežnika';
$lang['intro_text']		= 	'Prvi korak pri namestitvenem postopku je da preverimo ali vas strežnik lahko poganja PyroCMS. Večina strežnikov s tem nima težav.';
$lang['mandatory']		= 	'Obvezno';
$lang['recommended']	= 	'Priporočeno';

$lang['server_settings']= 	'HTTP nastavitve strežnika';
$lang['server_version']	=	'Programska oprema strežnika:';
$lang['server_fail']	=	'Programska oprema strežnika ni podprta, zato PyroCMS bo ali pa ne bo deloval. Če sta PHP in MySQL nameščena in posodobljena naj bi PyroCMS deloval pravilno, razen brez skrajšanih URL-jev.';

$lang['php_settings']	=	'PHP nastavitve';
$lang['php_required']	=	'PyroCMS za delovanje potrebuje PHP %s ali več.';
$lang['php_version']	=	'Vaš strežnik trenutno poganja verzijo:';
$lang['php_fail']		=	'Vaša PHP verzija ni podprta, PyroCMS potrebuje verzijo PHP %s ali več za pravilno delovanje.';

$lang['mysql_settings']	=	'MySQL Nastavitev';
$lang['mysql_required']	=	'PyroCMS potrebuje dostop do MySQL podatkovne baze verzije 5.0 ali več.';
$lang['mysql_version1']	=	'Vaš strežnik trenutno deluje';
$lang['mysql_version2']	=	'Vaš klient trenutno deluje.';
$lang['mysql_fail']		=	'Vaša verzija MYSQL ni podprta. PyroCMS potrebuje verzijo 5.0 ali več za pravilno delovanje.';

$lang['gd_settings']	=	'GD nastavitev';
$lang['gd_required']	= 	'PyroCMS potrebuje GD knjižnico 1.0 ali več za obdelavo slik.';
$lang['gd_version']		= 	'Vaš strežnik ima trenutno verzijo';
$lang['gd_fail']		=	'Ne moremo določiti verzije GD knjižnice. To ponavadi pomeni da GD knjžnica ni nameščena. PyroCMS bo vseeno deloval vendar nekaterih funkcij slik ne bo mogoče uporabljati. Toplo vam priporočamo omogočitev uporabe GD knjižnice.';

$lang['summary']		=	'Povzetek';

$lang['zlib']			=	'Zlib';
$lang['zlib_required']	= 	'PyroCMS potrebuje Zlib da bo lahko razširil in namestil predloge.';
$lang['zlib_fail']		=	'Zlib ni mogoče najti. To ponavadi pomeni da Zlib ni namešen na strežnik. PyroCMS bo vseeno deloval pravilno vendar ne boste mogli namestiti predlog spletne strani. Priporočamo vam namestitev Zlib knjižnice.';

$lang['curl']			=	'Curl';
$lang['curl_required']	=	'PyroCMS potrebuje Curl da se lahko povezuje na druge spletne strani.';
$lang['curl_fail']		=	'Curl ni mogoče najti. To ponavadi pomeni da Curl ni nameščen. PyroCMS bo vseeno deloval pravilno vendar ne bo možno uporabljati določenih funkcij. Priporočamo vam namestitev Curl knjižnice.';

$lang['summary_success']	=	'Vaš strežnik ustreza vsem zahtevam za delovanje PyroCMS-ja. Kliknite spodaj na naslednji korak.';
$lang['summary_partial']	=	'Vaš strežnik ustreza v <em>večini</em> od zahtevanega za delovanje PyroCMS-ja.To pomeni da bo PyroCMS deoval pravilno vendar pa je verjetnost da boste imeli težave s spreminjanjem velikost slik in ustvarjanjem malih slik.';
$lang['summary_failure']	=	'Izgleda da je vaš strežnik ne ustreza zahtevam za delovanje PyroCMS-ja. Predlagamo vam da kontaktirate administratorja strežnika oz. ponudnika gostovanja za razrešitev težav';
$lang['next_step']		=	'Pojdite na naslednji korak';
$lang['step3']			=	'korak 3';
$lang['retry']			=	'Poizkusite znova';

// messages
$lang['step1_failure']	=	'Prosimo izpolnite zahtevane podatke za podatkovno bazo v obrazcu spodaj..';

/* End of file step_2_lang.php */
/* Location: ./installer/language/slovenian/step_2_lang.php */