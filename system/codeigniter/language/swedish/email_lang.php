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

$lang['email_must_be_array'] = 'Valideringen av e-postadresser kräver en matris (array).';
$lang['email_invalid_address'] = 'Du angav inte en korrekt e-postadress: %s';
$lang['email_attachment_missing'] = 'Det gick inte att hitta bilagan: %s';
$lang['email_attachment_unreadable'] = 'Det gick inte att öppna bilagan: %s';
$lang['email_no_recipients'] = 'Du måste ange minst en mottagare: Till, Kopia, eller Hemlig kopia';
$lang['email_send_failure_phpmail'] = 'Det gick inte att skicka e-post med PHP mail(). Servern är kanske inte konfigurerad för att skicka e-post med denna metod.';
$lang['email_send_failure_sendmail'] = 'Det gick inte att skicka e-post med PHP Sendmail. Servern är kanske inte konfigurerad för att skicka e-post med denna metod.';
$lang['email_send_failure_smtp'] = 'Det gick inte att skicka e-post med PHP SMTP. Servern är kanske inte konfigurerad för att skicka e-post med denna metod.';
$lang['email_sent'] = 'Ditt meddelande har skickats med följande protokoll: %s';
$lang['email_no_socket'] = 'Det gick inte att öppna en socket till Sendmail. Kontrollera inställningarna.';
$lang['email_no_hostname'] = 'Fel. Du måste ange ett värdnamn (host) för SMTP.';
$lang['email_smtp_error'] = 'Följande fel uppstod med SMTP: %s';
$lang['email_no_smtp_unpw'] = 'Fel: Du måste ange användarnamn och lösenord för SMTP.';
$lang['email_failed_smtp_login'] = 'Det gick inte att skicka kommandot AUTH LOGIN. Fel: %s';
$lang['email_smtp_auth_un'] = 'Användarnamnet godkändes inte. Fel: %s';
$lang['email_smtp_auth_pw'] = 'Lösenordet godkändes inte. Fel: %s';
$lang['email_smtp_data_failure'] = 'Det gick inte att skicka data: %s';
$lang['email_exit_status'] = 'Avslutande statuskod: %s';


/* End of file email_lang.php */  
/* Location: system/codeigniter/language/swedish/email_lang.php */  
