<?php defined('BASEPATH') OR exit('No direct script access allowed');

// labels
$lang['header']			=	'Vaihe 2: Vaatimusten tarkistaminen';
$lang['intro_text']		= 	'Toisessa vaiheessa asennusta tarkistetaan, että PyroCMS on yhteensopiva palvelimen kanssa. Suurin osa palvelimista tulisi tukea ongelmitta.';
$lang['mandatory']		= 	'Pakollinen';
$lang['recommended']	= 	'Suositeltu';

$lang['server_settings']= 	'HTTP palvelin asetukset';
$lang['server_version']	=	'Palvelimen ohjelmisto versio:';
$lang['server_fail']	=	'Palvelimen ohjelmistoa ei tueta. Näin ollen PyroCMS toimii ehkä, mutta sille ei ole takuuta. Niin kauan kun PHP ja MySQL asennukset ovat ajan tasalla, PyroCMS pitäisi toimia.';

$lang['php_settings']	=	'PHP asetukset';
$lang['php_required']	=	'PyroCMS vaatii PHP version %s tai uudemman.';
$lang['php_version']	=	'Palvelin pyörii tällä hetkellä versiolla';
$lang['php_fail']		=	'PHP versiota ei tueta. PyroCMS vaatii PHP version %s tai uudemman, jotta se toimii normaalisti.';

$lang['mysql_settings']	=	'MySQL asetukset';
$lang['mysql_required']	=	'PyroCMS vaatii pääsyn MySQL tietokantaan, joka pyörii versiolla 5.0 tai uudemmalla.';
$lang['mysql_version1']	=	'MySQL palvelin on tällä hetkellä käynnissä';
$lang['mysql_version2']	=	'MySQL asiakas on tällä hetkellä käynnissä';
$lang['mysql_fail']		=	'MySQL versiota ei tueta. PyroCMS vaatii MySQL version 5.0 tai uudemman, jotta se toimii normaalisti.';

$lang['gd_settings']	=	'GD asetukset';
$lang['gd_required']	= 	'PyroCMS vaatii GD kirjaston 1.0 tai uudemman, jotta se voi muokata kuvia.';
$lang['gd_version']		= 	'Palvelimellasi pyörii tällä hetkellä versio';
$lang['gd_fail']		=	'Emme pysty tarkistamaan GD kirjaston versiota. Tämä yleensä tarkoittaa sitä, että GD kirjasto ei ole asennettu. PyroCMS toimii silti normaalisti, mutta jotkut kuvan muokkaus toiminnot eivät toimi. Suosittelemme, että GD kirjasto otetaan käyttöön.';

$lang['summary']		=	'Yhteenveto';

$lang['zlib']			=	'Zlib';
$lang['zlib_required']	= 	'PyroCMS vaatii Zlib, jotta se pystyy purkaa ja asentaa teemoja.';
$lang['zlib_fail']		=	'Zlib kirjastoa ei löydy. Tämä yleensä tarkoittaa sitä, että Zlib kirjastoa ei ole asennettu. PyroCMS toimii silti normaalisti, mutta teemoja ei voida asentaa. Suosittelemme, että Zlib kirjasto otetaan käyttöön.';

$lang['curl']			=	'Curl';
$lang['curl_required']	=	'PyroCMS vaatii Curl kirjaston ottaakseen yhteyttä muihin sivustoihin.';
$lang['curl_fail']		=	'Curl kirjastoa ei löytynyt. Tämä yleensä tarkoittaa sitä, että Curl ei ole asennettu. PyroCMS toimii silti normaalisti, mutta jotkut toiminnallisuudet eivät toimi. Suosittelemme, että Curl kirjasto otetaan käyttöön.';

$lang['summary_success']	=	'Palvelin täyttää kaikki vaatimukset, jotta PyroCMS toimii normaalisti. Voit jatkaa asennusta menemällä seuraavaan vaiheeseen.';
$lang['summary_partial']	=	'Palvelin täyttää <em>suurin osa</em> PyroCMS vaatimuksista. Tämä tarkoittaa sitä, että PyroCMS toimii, mutta siinä saattaa olla puutteita tietyissä toiminnallisuuksissa, kuten esimerkiksi kuvien muokkaamisessa.';
$lang['summary_failure']	=	'Näyttää siltä, että palvelin ei vastaa PyroCMS vaatimuksia. Ota yhteyttä järjestelänvalvojaan tai palveluntarjoajaan asian korjaamiseksi.';
$lang['next_step']		=	'Siirry seuraavaan vaiheeseen';
$lang['step3']			=	'Vaihe 3';
$lang['retry']			=	'Tarkista uudelleen';

// messages
$lang['step1_failure']	=	'Ole hyvä ja täytä pakolliset tietokanta asetukset alla olevasta lomakkeesta..';

/* End of file step_2_lang.php */