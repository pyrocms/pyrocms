<?php defined('BASEPATH') OR exit('No direct script access allowed');

# labels
$lang['header']			= 'Paso 2: Comprobar requisitos';
$lang['intro_text']		= 'El primer paso en el proceso de instalación es la de comprobar si su servidor soporta PyroCMS. Muchos servidores pueden tener la capacidad de ejecutarlo sin ningún problema.';
$lang['mandatory']		= 'Necesario';
$lang['recommended']		= 'Recomendado';

$lang['server_settings']	= 'Configuración del Servidor HTTP';
$lang['server_version']		= 'Su software del servidor:';
$lang['server_fail']		= 'Su software del servidor no está soportado, por lo tanto PyroCMS puede o no puede funcionar. En la medida que su instalación de PHP y MySQL estén actualizados PyroCMS puede ejecutarse apropiadamente, solo sin URL\'s limpios.';

$lang['php_settings']		= 'Configuración PHP';
$lang['php_required']		= 'PyroCMS requiere PHP versión %s o superior.';
$lang['php_version']		= 'Su servidor está actualmente ejecutando versión';
$lang['php_fail']		= 'Su versión de PHP no está soportada. PyroCMS requiere PHP versión %s o superior para ejecutarse apropiadamente.';

$lang['mysql_settings']		= 'Configuración MySQL';
$lang['mysql_required']		= 'PyroCMS requiere la base de datos MySQL ejecutando versión 5.0 o superior.';
$lang['mysql_version1']		= 'Su servidor actualmente está ejecutando';
$lang['mysql_version2']		= 'Su cliente actualmente está ejecutando';
$lang['mysql_fail']		= 'Su versión de MySQL no está soportada. PyroCMS requiere MySQL versión 5.0 o superior para ejecutarse apropiadamente.';

$lang['gd_settings']		= 'Configuración GD';
$lang['gd_required']		= 'PyroCMS requiere la librería GD 1.0 o superior para manipular imágenes.';
$lang['gd_version']		= 'Su servidor actualmente está ejecutando la versión';
$lang['gd_fail']		= 'No se puede determinar la versión de la librería GD. Esto significa que la librería GD no está instalada. PyroCMS aún puede ejecutarse apropiadamente pero algunas de las operaciones con imágenes pueden no funcionar. Es muy recomendable activar la librería GD.';

$lang['summary']		= 'Resumen';

$lang['zlib']			= 'Zlib';
$lang['zlib_required']		= 'PyroCMS requiere la librería Zlib para descromprimir e instalar temas.';
$lang['zlib_fail']		= 'Zlib no puede ser encontrado. Esto generalmente significa que Zlib no está instalado. PyroCMS aún puede ejecutarse apropiadamente pero la instalación de temas no funcionará. Es muy recomendable que instale Zlib.';

$lang['curl']			= 'Curl';
$lang['curl_required']		= 'PyroCMS requiere Curl para hacer conexiones con otros sitios.';
$lang['curl_fail']		= 'Curl no puede ser encontrado. Esto usualmente significa que Curl no está instalado. PyroCMS se ejecutará apropiadamente pero algunas funciones no estarán disponibles. Es altamente recomendado que instale Curl.';

$lang['summary_green']		= 'Su servidor cumple todos los requisitos para que PyroCMS se ejecute apropiadamente, dirígase al próximo paso realizando un click en el siguiente botón.';
$lang['summary_orange']		= 'Su servidor cumple <em>varios</em> de los requisitos para PyroCMS. Esto significa que PyroCMS puede ejecutarse apropiadamente pero existen posibilidades que experimente problemas con cosas tales como redimensionado de imágenes o instalaciones de módulos y temas.';
$lang['summary_red']		= 'Al parecer su servidor falló al cumplir los requisitos para ejecutar PyroCMS. Favor contacte a su administrador del servidor o compañía de hospedaje para resolver este problema.';
$lang['next_step']		= 'Proceder al siguiente paso';
$lang['step3']			= 'Paso 3';
$lang['retry']			= 'Reintentar';

# messages
$lang['step1_failure']		= 'Por favor, completa la configuración de la base de datos requerida en el formulario siguiente...';

/* End of file step_2_lang.php */
/* Location: ./installer/language/spanish/step_2_lang.php */