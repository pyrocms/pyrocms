<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.2.4 or newer
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Open Software License version 3.0
 *
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst.  It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

$lang['email_must_be_array'] 			= 'Емейл валидирането трябва да бъде прехвърлено в масив (array).';
$lang['email_invalid_address'] 			= 'Грешен емайл адрес: %';
$lang['email_attachment_missing'] 		= 'Не може да се намери прикачения файл: %';
$lang['email_attachment_unreadable'] 	= 'Не може да се отвори прикачения файл: %';
$lang['email_no_recipients'] 			= 'Трябва да включите получателите: To, Cc, or Bcc';
$lang['email_send_failure_phpmail'] 	= 'Емайла не може да бъде изпратен чрез PHP mail(). Вашият сървър може да не е конфигуриран да изпраща поща, използвайки този метод.';
$lang['email_send_failure_sendmail'] 	= 'Емайла не може да бъде изпратен чрез PHP Sendmail. Вашият сървър може да не е конфигуриран да изпраща поща, използвайки този метод.';
$lang['email_send_failure_smtp'] 		= 'Емайла не може да бъде изпратен чрез PHP SMTP. Вашият сървър може да не е конфигуриран да изпраща поща, използвайки този метод.';
$lang['email_sent'] 					= 'Вашето съобщение е изпратено успешно и използва следния протокол: %';
$lang['email_no_socket'] 				= 'Не може да се отвори връзка към Sendmail. Моля проверете настройките.';
$lang['email_no_hostname'] 				= 'Не сте посочили SMTP връзка.';
$lang['email_smtp_error'] 				= 'Беше получена следната SMTP грешка: %';
$lang['email_no_smtp_unpw'] 			= 'Грешка: Трябва да посочите име и парола за SMTP.';
$lang['email_failed_smtp_login'] 		= 'Не може да се изпрати AUTH LOGIN. Грешка: %';
$lang['email_smtp_auth_un'] 			= 'Не може да се удостовери потребителското име. Грешка: %';
$lang['email_smtp_auth_pw'] 			= 'Не може да се удостовери паролата. Грешка: %';
$lang['email_smtp_data_failure'] 		= 'Не могат да се изпращат данни: %';
$lang['email_exit_status'] 				= 'Код на завършване: %';

/* End of file email_lang.php */
/* Location: ./system/language/bulgarian/email_lang.php */