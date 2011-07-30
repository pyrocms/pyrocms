<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

# labels
$lang['header']          = 'Paso 1: Configurar la Base de datos y el Servidor';
$lang['intro_text']      = 'Antes de configurar la base de datos, es necesario saber donde se ubica y los datos de ingreso.';

$lang['db_settings']     = 'Configuración de la Base de datos';
$lang['db_text']         = 'Para que el instalador compruebe su versión del servidor MySQL necesita que ingrese el nombre de host, nombre de usuario y contraseña en el siguiente formulario. Estos datos serán usados cuando se instale la base de datos.';

$lang['server']          = 'Servidor';
$lang['username']        = 'Usuario';
$lang['password']        = 'Contraseña';
$lang['portnr']          = 'Puerto';
$lang['server_settings'] = 'Configuración del Servidor';
$lang['httpserver']      = 'Servidor HTTP';
$lang['rewrite_fail']	=	'You have selected "(Apache with mod_rewrite)" but we are unable to tell if mod_rewrite is enabled on your server. Ask your host if mod_rewrite is enabled or simply install at your own risk.';
$lang['mod_rewrite']	=	'You have selected "(Apache with mod_rewrite)" but your server does not have the rewrite module enabled. Ask your host to enable it or install PyroCMS using the "Apache (without mod_rewrite)" option.';
$lang['step2']           = 'Paso 2'; # Used?

# messages
$lang['db_success']      = 'La conexión a la base de datos datos es correcta.';
$lang['db_failure']      = 'Hay problemas en la conexión a la base de datos: ';
