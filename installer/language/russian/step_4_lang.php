<?php defined('BASEPATH') or exit('No direct script access allowed');

// labels
$lang['header']					= 'Шаг 4: Создание базы данных'; #translate
$lang['intro_text']			= 'Заполните форму ниже и нажмите кнопку "Установить", для установки PyroCMS. Убедитесь, что устанавливаете PyroCMS в правильную базу данных - все имеющиеся данные в этой базе данных будут удалены!'; #translate

$lang['default_user']		= 'Пользователь по-умолчанию';
$lang['database']				= 'Имя базы данных'; 
$lang['site_settings']	= 'Настройки сайта';
$lang['site_ref']				= 'Site Ref'; #translate, but how? what does this mean?
$lang['user_name']			= 'Логин';
$lang['first_name']			= 'Имя';
$lang['last_name']			= 'Фамилия';
$lang['email']					= 'Email';
$lang['password']				= 'Пароль';
$lang['conf_password']	= 'Ещё раз пароль';
$lang['finish']					= 'Установить';

$lang['invalid_db_name'] = 'The database name you entered is invalid. Please use only alphanumeric characters and underscores.'; #translate
$lang['error_101']			= 'База данных не найдена. Если вы нажали галочку "Создать БД" - возможно эта операция не удалась из-за ограничений в правах доступа.';
$lang['error_102']			= 'Установщику не хватает прав для добавления таблиц в базу данных.';
$lang['error_103']			= 'Установщику не хватает прав для добавления данных в базу данных.';
$lang['error_104']			= 'Установщику не удалось создать пользователя по-умолчанию.';
$lang['error_105']			= 'Файл конфигурации базы данных не может быть перезаписан, вы обманули установщик пропустив 3-ий шаг?';
$lang['error_106']			= 'Файл конфигурации не может быть перезаписан, вы уверены, что у этого файла установлены корректные разрешения на доступ?';
$lang['success']				= 'PyroCMS успешно установлена.';