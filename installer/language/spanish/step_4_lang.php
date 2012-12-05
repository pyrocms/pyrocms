<?php defined('BASEPATH') or exit('No direct script access allowed');

# labels
$lang['header']        = 'Paso 4: Crear la Base de datos'; #translate
$lang['intro_text']    = 'Complete el formulario siguiente y presione el botón "Instalar" para instalar PyroCMS. Esté seguro de instalar PyroCMS en la base de datos correcta puesto que todos los datos existentes se perderán!'; #translate

$lang['default_user']  = 'Usuario por defecto';
$lang['database']      = 'Base de datos';
$lang['site_settings']		= 	'Site Settings'; #translate
$lang['site_ref']		=	'Site Ref'; #translate
$lang['user_name']     = 'Nombre de usuario';
$lang['first_name']    = 'Nombre';
$lang['last_name']     = 'Apellido';
$lang['email']         = 'Email';
$lang['password']      = 'Contraseña';
$lang['conf_password'] = 'Confirmar contraseña';
$lang['finish']        = 'Instalar';

$lang['invalid_db_name'] = 'The database name you entered is invalid. Please use only alphanumeric characters and underscores.'; #translate
$lang['error_101']     = 'La base de datos no se pudo encontrar. Si solicitó al instalador crear la base de datos entonces pudo haber fallado debido a permisos incorrectos.';
$lang['error_102']     = 'El instalador no pudo agregar las tablas a la base de datos.<br/><br/>';
$lang['error_103']     = 'El instalador no pudo agregar los datos en la base de datos.<br/><br/>';
$lang['error_104']     = 'El instalador no pudo crear el usuario por omisión.<br/><br/>';
$lang['error_105']     = 'La configuración de la base de datos no pudo ser escrita, ¿Ha omitido el paso 3 del instalador?';
$lang['error_106']     = 'El archivo de configuración no pudo ser escrito, ¿está seguro que el archivo tiene permisos correctos?';
$lang['success']       = 'PyroCMS ha sido instalado satisfactoriamente.';