<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PyroCMS
 *
 * An open source CMS based on CodeIgniter
 *
 * @package		PyroCMS
 * @author		Jerel Unruh - PyroCMS Dev Team
 * @license		Apache License v2.0
 * @link		http://pyrocms.com
 * @since		Version 1.0-dev
 * @filesource
 */

// General
$lang['files:files_title']					= 'Archivos';
$lang['files:fetching']						= 'Obteniendo datos...';
$lang['files:fetch_completed']				= 'Completado';
$lang['files:save_failed']					= 'Lo sentimos. Los cambios no pueden ser guardados.';
$lang['files:item_created']					= '"%s" ha sido creado';
$lang['files:item_updated']					= '"%s" ha sido actualizado';
$lang['files:item_deleted']					= '"%s" ha sido eliminado';
$lang['files:item_not_deleted']				= '"%s" no puede eliminarse';
$lang['files:item_not_found']				= 'Lo sentimos. "%s" no puede ser encontrado.';
$lang['files:sort_saved']					= 'Orden de la lista guardado';
$lang['files:no_permissions']				= 'Usted no tiene suficiente permisos';

// Labels
$lang['files:activity']						= 'Actividad';
$lang['files:places']						= 'Lugares';
$lang['files:back']							= 'Atrás';
$lang['files:forward']						= 'Adelante';
$lang['files:start']						= 'Iniciar subida';
$lang['files:details']						= 'Detalles';
$lang['files:name']							= 'Nombre';
$lang['files:slug']							= 'Slug';
$lang['files:path']							= 'Directorio';
$lang['files:added']						= 'Agregado el';
$lang['files:width']						= 'Ancho';
$lang['files:height']						= 'Alto';
$lang['files:ratio']						= 'Ratio';
$lang['files:alt_attribute']				= 'alt Attribute'; #translate
$lang['files:full_size']					= 'Tamaño completo';
$lang['files:filename']						= 'Nombre del Archivo';
$lang['files:filesize']						= 'Tamaño del Archivo';
$lang['files:download_count']				= 'Número de descargas';
$lang['files:download']						= 'Descargar';
$lang['files:location']						= 'Lugar';
$lang['files:description']					= 'Descripción';
$lang['files:container']					= 'Contenedor';
$lang['files:bucket']						= 'Bucket'; #translate
$lang['files:check_container']				= 'Comprobar validez';
$lang['files:search_message']				= 'Escribe y presiona Enter';
$lang['files:search']						= 'Buscar';
$lang['files:synchronize']					= 'Sincronizar';
$lang['files:uploader']						= 'Arrastrar los archivos aquí <br />o<br />Hacer clic para seleccionar los archivos';
$lang['files:replace_file']					= 'Replace file'; #translate

// Context Menu
$lang['files:refresh']						= 'Refresh'; #translate
$lang['files:open']							= 'Abrir';
$lang['files:new_folder']					= 'Nueva Carpeta';
$lang['files:upload']						= 'Subir';
$lang['files:rename']						= 'Cambiar nombre';
$lang['files:replace']	  					= 'Replace'; # translate
$lang['files:delete']						= 'Eliminar';
$lang['files:edit']							= 'Editar';
$lang['files:details']						= 'Detalles';

// Folders

$lang['files:no_folders']					= 'Los archivos y carpetas se manejan al igual que lo sería en el escritorio. Haga clic derecho en el área por debajo de este mensaje para crear su primera carpeta. Luego haga clic derecho en la carpeta para renombrar, borrar, cargar archivos en ella, o cambiar detalles como su vinculación a una ubicación de las nubes.';
$lang['files:no_folders_places']			= 'Las carpetas creadas se mostrarán aquí en un árbol que puede expandirse y contraerse. Haga clic en "Lugares" para ver la carpeta raíz.';
$lang['files:no_folders_wysiwyg']			= 'No se ha creado alguna carpeta todavía.';
$lang['files:new_folder_name']				= 'Carpeta sin nombre';
$lang['files:folder']						= 'Carpeta';
$lang['files:folders']						= 'Carpetas';
$lang['files:select_folder']				= 'Selecciona una carpeta';
$lang['files:subfolders']					= 'Sub-carpetas';
$lang['files:root']							= 'Raíz';
$lang['files:no_subfolders']				= 'Sin Sub-carpetas';
$lang['files:folder_not_empty']				= 'Debe eliminar el contenido de "%s" primero';
$lang['files:mkdir_error']					= 'No se ha podido crear %s. Debe crearla manualmente.';
$lang['files:chmod_error']					= 'El directorio de subida está protegido contra escritura. Debe cambiarle los permisos a 0777';
$lang['files:location_saved']				= 'La ubicación de la carpeta se ha guardado';
$lang['files:container_exists']				= '"%s" existe. Guardar para enlazar sus contenidos en esta carpeta';
$lang['files:container_not_exists']			= '"%s" no existe en su cuenta. Guarde y nosotros trataremos de crearlo';
$lang['files:error_container']				= '"%s" no puede ser creado y no podemos determinar la causa';
$lang['files:container_created']			= '"%s" ha sido creado y está vinculado ahora a esta carpeta';
$lang['files:unwritable']					= '"%s" está protegido contra escritura, por favor cambiarle los permisos a 0777';
$lang['files:specify_valid_folder']			= 'Debe especificar una carpeta válida para subir los archivos';
$lang['files:enable_cdn']					= 'Debe habilitar el CDN para "%s" a través de su panel de control Rackspace antes de poder sincronizar';
$lang['files:synchronization_started']		= 'Empezando la sincronización';
$lang['files:synchronization_complete']		= 'La sincronización para "%s" ha finalizado';
$lang['files:untitled_folder']				= 'Carpeta sin nombre';

// Files
$lang['files:no_files']						= 'No se han encontrado archivos';
$lang['files:file_uploaded']				= 'Se ha subido el archivo "%s"';
$lang['files:unsuccessful_fetch']			= 'No hemos podido obtener el archivo "%s". ¿Está seguro de que el archivo es público?';
$lang['files:invalid_container']			= '"%s" no parece ser un contener válido.';
$lang['files:no_records_found']				= 'No se pudo encontrar algún registro';
$lang['files:invalid_extension']			= 'El archivo "%s" tiene una extensión no permitida';
$lang['files:upload_error']					= 'La subida del archivo ha fallado';
$lang['files:description_saved']			= 'La descripción del archivo ha sido guardada';
$lang['files:alt_saved']					= 'The image alt attribute has been saved'; #translate
$lang['files:file_moved']					= 'El archivo "%s" se ha movido exitosamente';
$lang['files:exceeds_server_setting']		= 'El servidor no puede manejar un archivo de un tamaño tan grande como este';
$lang['files:exceeds_allowed']				= 'El archivo supera el tamaño máximo permitido';
$lang['files:file_type_not_allowed']		= 'Este tipo de archivo no está permitido';
$lang['files:replace_warning']				= 'Warning: Do not replace a file with a file of a different type (e.g. .jpg with .png)'; #translate
$lang['files:type_a']						= 'Audio';
$lang['files:type_v']						= 'Video';
$lang['files:type_d']						= 'Documento';
$lang['files:type_i']						= 'Imagen';
$lang['files:type_o']						= 'Otro';

/* End of file files_lang.php */