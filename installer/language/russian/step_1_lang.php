<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']			=	'Шаг 1: Конфигурация базы данных и сервера';
$lang['intro_text']		=	'Перед проверкой базы данных нам надо знать где она расположена и как к ней подключиться.';

$lang['db_settings']	=	'Настройки базы данных';
$lang['db_text']		=	'Для проверки версии вашего MySQL сервера - установщику нужно знать адрес сервера, имя пользователя и пароль, используемые для подключения к базе данных. Эти данные будут использованы при установке базы данных.';

$lang['server']			=	'Сервер';
$lang['username']		=	'Имя пользователя';
$lang['password']		=	'Пароль';
$lang['portnr']			=	'Порт';
$lang['server_settings']=	'Настройки сервера';
$lang['httpserver']		=	'Сервер HTTP';
$lang['rewrite_fail']	=	'You have selected "(Apache with mod_rewrite)" but we are unable to tell if mod_rewrite is enabled on your server. Ask your host if mod_rewrite is enabled or simply install at your own risk.';
$lang['mod_rewrite']	=	'You have selected "(Apache with mod_rewrite)" but your server does not have the rewrite module enabled. Ask your host to enable it or install PyroCMS using the "Apache (without mod_rewrite)" option.';
$lang['step2']			=	'Шаг 2';

// messages
$lang['db_success']		=	'Настройки базы данных протестированы и работают отлично.';
$lang['db_failure']		=	'Возникла ошибка, при подключении к базе данных: ';
