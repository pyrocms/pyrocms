<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['crlf'] = '\r\n';
$config['newline'] = '\r\n';

/* -- PHP's mail() function */
$config['protocol'] = 'mail';

/* -- Sendmail --
$config['protocol'] = 'sendmail';
$config['mailpath'] = '/usr/sbin/sendmail';
*/

/* -- SMTP E-mail --
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.example.com';
$config['smtp_user'] = 'username';
$config['smtp_pass'] = 'password';
$config['smtp_port'] = '465';
*/