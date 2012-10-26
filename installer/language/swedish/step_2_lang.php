<?php defined('BASEPATH') or exit('No direct script access allowed');


/**
 * Swedish translation.
 *
 * @author		marcus@incore.se
 * @package		PyroCMS  
 * @link		http://pyrocms.com
 * @date		2012-03-13
 * @version		1.0.0
 */


$lang['header']		= 'Steg 2: Kontrollera krav';
$lang['intro_text']		= 'Det andra steget i installationsprocessen är att kontrollera om din server stöder PyroCMS. De flesta servrar ska kunna köra det utan några problem.';
$lang['mandatory']		= 'Obligatorisk';
$lang['recommended']		= 'Rekommenderad';
$lang['server_settings']		= 'HTTP Server inställningar';
$lang['server_version']		= 'Din servermjukvara:';
$lang['server_fail']		= 'Din server programvara stöds inte PyroCMS kommer inte att fungera. Om PHP och MySQL installationerna är uppdaterade kommer PyroCMS att fungera korrekt.';
$lang['php_settings']		= 'PHP inställningar';
$lang['php_required']		= 'PyroCMS kräver PHP version %s eller högre.';
$lang['php_version']		= 'Din server kör just nu version';
$lang['php_fail']		= 'Din PHP version stöds inte. PyroCMS kräver PHP version %s eller högre för att kunna köras.';
$lang['mysql_settings']		= 'MySQL inställningar';
$lang['mysql_required']		= 'PyroCMS kräver en en MySQL-databas som kör version 5.0 eller högre.';
$lang['mysql_version1']		= 'Din server kör för närvarande';
$lang['mysql_version2']		= 'Din klient kör för närvarande';
$lang['mysql_fail']		= 'Din MySQL version stöds inte. PyroCMS kräver MySQL version 5.0 eller senare.';
$lang['gd_settings']		= 'GD Inställningar';
$lang['gd_required']		= 'PyroCMS kräver GD biblioteket 1.0 eller högre för att hantera bilder.';
$lang['gd_version']		= 'Servernkör för närvarande version';
$lang['gd_fail']		= 'Vi kan inte bestämma version av GD biblioteket. Detta innebär vanligtvis att GD biblioteket inte är installerat. PyroCMS kommer fortfarande fungera korrekt, men en del av bildfunktionaliteten kanske inte fungerar. Det rekommenderas att du aktiverar/installerar GD biblioteket.';
$lang['summary']		= 'Summering';
$lang['zlib']		= 'Zlib';
$lang['zlib_required']		= 'PyroCMS kräver Zlib för att göra unzip på och installera teman.';
$lang['zlib_fail']		= 'Zlib kan inte hittas. Detta innebär oftast att Zlib inte är installerat. PyroCMS kommer fortfarande fungera korrekt, men installation av teman kommer inte att fungera. Det rekommenderas starkt att du installerar zlib.';
$lang['curl']		= 'Curl';
$lang['curl_required']		= 'PyroCMS kräver Curl för att göra anslutningar till andra webbplatser.';
$lang['curl_fail']		= 'Curl kan inte hittas. Detta innebär oftast att Curl inte är installerat. PyroCMS kommer fortfarande fungera korrekt, men vissa funktioner kommer att saknas eller inte fungera korrekt. Det rekommenderas starkt att du aktiverar/installerar Curl-biblioteket.';
$lang['summary_success']		= 'Servern uppfyller alla krav för PyroCMS, gå till nästa steg genom att klicka på knappen nedan.';
$lang['summary_partial']		= 'Servern uppfyller <em> de flesta </ em> av kraven för PyroCMS. Detta innebär att PyroCMS ska kunna fungera korrekt, men det finns en chans att du kommer att uppleva problem med saker som bildstorleksändring etc.';
$lang['summary_failure']		= 'Det verkar som om din server inte uppfyllde kraven för att köra PyroCMS. Kontakta din serveradministratör eller webbhotell för att få detta löst.';
$lang['next_step']		= 'Fortsätt till nästa steg';
$lang['step3']		= 'Steg 3';
$lang['retry']		= 'Försök igen';
$lang['step1_failure']		= 'Fyll i databasinställningarna i formuläret nedan...';



/* End of file step_2_lang.php */  
/* Location: ./installer/language/swedish */ 