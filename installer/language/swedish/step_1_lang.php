<?php defined('BASEPATH') or exit('No direct script access allowed');
 /**
 * Swedish translation.
 *
 * @author		marcus@incore.se
 * @package		PyroCMS  
 * @link		http://pyrocms.com
 * @date		2012-10-22
 * @version		1.1.0
 */

$lang['header'] = 'Steg 1: Konfigurera Databas';
$lang['intro_text'] = 'PyroCMS är mycket lätt att installera och bör bara ta några minuter, men det finns några frågor som kan verka förvirrande om du inte har en teknisk bakgrund. Om du vid något tillfälle du fastnar vänd dig till din webbhotellsleverantör eller <a href="http://www.pyrocms.com/contact" target="_blank"> kontakta oss </a> för support.';
$lang['db_settings'] = 'Inställningar';
$lang['db_text'] = 'PyroCMS kräver en databas (MySQL) för att lagra sidor och inställningar, det första vi gör är att se till att databaskopplingen fungerar. Ifall du inte förstå vad vi frågar efter så kontakta ditt webbhotell eller serveradministratör.';
$lang['db_missing'] = 'MySql drivrutinen för PHP kunde inte hittas, installationen avbryts. Installera drivrutinen och starta installationen på nytt.';
$lang['db_create']		=	'Create Database'; #translate
$lang['db_notice']		=	'You might need to do this yourself via your hosting control panel'; #translate
$lang['database']		=	'MySQL Database'; #translate

$lang['server'] = 'MySQL Värdnamn';
$lang['username'] = 'MySQL Användarnamn';
$lang['password'] = 'MySQL Lösenord';
$lang['portnr'] = 'MySQL Port';
$lang['server_settings'] = 'Serverinställningar';
$lang['httpserver'] = 'HTTP Server';
$lang['httpserver_text'] = 'PyroCMS kräver en HTTP-server för att visa dynamiskt innehåll när en användare går till din webbplats. Det ser ut som du redan har en sådan av det faktum att du kan se denna sida, men om vi vet exakt vilken typ så kan PyroCMS anpassas. Om du inte vet vad allt detta betyder bara ignorera det och fortsätt med installationen.';
$lang['rewrite_fail'] = 'Du har valt "(Apache with mod_rewrite)" men installationsprogrammet kan inte avgöra om mod_rewrite är aktiverat på din server. Kontrollera om mod_rewrite eller fortsätt installationen på egen risk.';
$lang['mod_rewrite'] = 'Du har valt "(Apache med mod_rewrite)", men din server inte har rewrite-modulen aktiverad. Aktivera denna modul eller installera PyroCMS med hjälp av "Apache (utan mod_rewrite)" alternativet.';
$lang['step2'] = 'Steg 2';
$lang['db_success'] = 'Databaskopplingen fungerar';
$lang['db_failure'] = 'Kan inte kontakta databasen:';