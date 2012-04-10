<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']			=	'Vaihe 1: Konfiguroi tietokanta ja palvelin';
$lang['intro_text']		=	'PyroCMS on helppo asentaa ja sen pitäisi viedä muutaman minuutin, mutta voi olla että herää kysymyksiä, mikäli et ole tekninen henkilö taustaltasi. Jos jäät jumiin johonkin vaiheeseen, niin kysy palveluntarjoajaltasi tai <a href="http://www.pyrocms.com/contact" target="_blank">ota yhteyttä</a> englannin kieliseen tukeen.';

$lang['db_settings']	=	'Tietokanta asetukset';
$lang['db_text']		=	'PyroCMS vaatii tietokannan (MySQL) tallentaakseen kaikki sisällöt ja asetukset, joten tarkistamme nyt että tietokanta yhteys on kunnossa. Jos et ymmärrä mistä on kysymys, niin kysy tiedot palveluntarjoajaltasi.';
$lang['db_missing']		=	'The mysql database driver for PHP were not found, installation cannot continue. Ask your host or server administrator to install it.'; #translate

$lang['server']			=	'MySQL palvelin';
$lang['username']		=	'MySQL käyttäjätunnus';
$lang['password']		=	'MySQL salasana';
$lang['portnr']			=	'MySQL portti';
$lang['server_settings']=	'Palvelin asetukset';
$lang['httpserver']		=	'HTTP Palvelin';

$lang['httpserver_text']=	'PyroCMS vaatii HTTP palvelimen katsellakseen dynaamista sisältöä. Näyttää siltä, että sinulla on se asia jo kunnossa koska näet tämän sivun. Määrittämällä tarkemmin palvelimen tyypin, PyroCMS konfiguroi itsensä paremmin. Jos et tiedä mistä on kysymys, niin jatka vain asennusta.';
$lang['rewrite_fail']	=	'Olet valinnut "(Apache with mod_rewrite)", mutta emme pysty tarkistamaan onko mod_rewrite asetus käytettävissä. Varmista palveluntarjoajaltasi onko mod_rewrite päällä tai jatka asennusta omalla vastuulla.';
$lang['mod_rewrite']	=	'Olet valinnut "(Apache with mod_rewrite)", mutta palvelimellasi ei ole mod_rewrite käytössä. Kysy palveluntarjoajaasi ottamaan se käyttöön tai asenna PyroCMS käyttämällä "Apache (without mod_rewrite)" asetusta.';
$lang['step2']			=	'Vaihe 2';

// messages
$lang['db_success']		=	'Tietokanta asetukset on testattu ja toimii.';
$lang['db_failure']		=	'Tietokannan yhteydessä tapahtui virhe: ';

/* End of file step_1_lang.php */
