<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PyroCMS
 *
 * An open source CMS based on CodeIgniter
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @license		Apache License v2.0
 * @link		http://pyrocms.com
 * @since		Version 1.0-dev
 * @filesource
 */

// Files

// Titles
$lang['files.files_title']					= 'Archivos';
$lang['files.upload_title']					= 'Subir Archivos';
$lang['files.edit_title']					= 'Edit file "%s"'; #translate

// Labels
$lang['files.actions_label']				= 'Acción';
$lang['files.download_label']				= 'Descargar';
$lang['files.edit_label']					= 'Editar';
$lang['files.delete_label']					= 'Eliminar';
$lang['files.upload_label']					= 'Subir';
$lang['files.description_label']			= 'Descripcioó';
$lang['files.type_label']					= 'Tipo';
$lang['files.file_label']					= 'Archivo';
$lang['files.filename_label']				= 'Nombre';
$lang['files.filter_label']					= 'Filter'; #translate
$lang['files.loading_label']				= 'Cargando...';
$lang['files.name_label']					= 'Name'; #translate

$lang['files.dropdown_no_subfolders']		= '-- Ninguno --';
$lang['files.dropdown_root']				= '-- Raíz --';

$lang['files.type_a']						= 'Audio';
$lang['files.type_v']						= 'Video';
$lang['files.type_d']						= 'Documento';
$lang['files.type_i']						= 'Imagen';
$lang['files.type_o']						= 'Otro';

$lang['files.display_grid']					= 'Cuadrícula';
$lang['files.display_list']					= 'Lista';

// Messages
$lang['files.create_success']				= 'El archivo ha sido guardado.';
$lang['files.create_error']					= 'An error as occourred.'; #translate
$lang['files.edit_success']					= 'The file was successfully saved.'; #translate
$lang['files.edit_error']					= 'An error occurred while trying to save the file.'; #translate
$lang['files.delete_success']				= 'El archivo fue borrado.';
$lang['files.delete_error']					= 'El archivo no pudo ser borrado.';
$lang['files.mass_delete_success']			= '%d of %d files were successfully deleted, they were "%s and %s"'; #translate
$lang['files.mass_delete_error']			= 'An error occurred while trying to delete %d of %d files, they are "%s and %s".'; #translate
$lang['files.upload_error']					= 'A file must be uploaded.'; #translate
$lang['files.invalid_extension']			= 'File must have a valid extension.'; #translate
$lang['files.not_exists']					= 'Se ha seleccionado una carpeta inválida.';
$lang['files.no_files']						= 'No hay archivos.';
$lang['files.no_permissions']				= 'No tienes permiso para ver el módulo de archivos.';
$lang['files.no_select_error'] 				= 'You must select a file first, his request was interrupted.'; #translate

// File folders

// Titles
$lang['file_folders.folders_title']			= 'Carpetas';
$lang['file_folders.manage_title']			= 'Administrar Carpetas';
$lang['file_folders.create_title']			= 'Nueva Carpeta';
$lang['file_folders.delete_title']			= 'Confirmar Eliminación';
$lang['file_folders.edit_title']			= 'Edit folder "%s"'; #translate

// Labels
$lang['file_folders.folders_label']			= 'Carpetas';
$lang['file_folders.folder_label']			= 'Carpeta';
$lang['file_folders.subfolders_label']		= 'Sub-Carpetas';
$lang['file_folders.parent_label']			= 'Padre';
$lang['file_folders.name_label']			= 'Nombre';
$lang['file_folders.slug_label']			= 'Slug URL';
$lang['file_folders.created_label']			= 'Creado en';

// Messages
$lang['file_folders.create_success']		= 'La carpeta ha sido guardada.';
$lang['file_folders.create_error']			= 'An error occurred while attempting to create your folder.'; #translate
$lang['file_folders.duplicate_error']		= 'A folder named "%s" already exists.'; #translate
$lang['file_folders.edit_success']			= 'The folder was successfully saved.'; #translate
$lang['file_folders.edit_error']			= 'An error occurred while trying to save the changes.'; #translate
$lang['file_folders.confirm_delete']		= 'Are you sure you want to delete the folders below, including all files and subfolders inside them?'; #translate
$lang['file_folders.delete_mass_success']	= '%d of %d folders have been successfully deleted, they were "%s and %s.'; #translate
$lang['file_folders.delete_mass_error']		= 'An error occurred while trying to delete %d of %d folders, they are "%s and %s".'; #translate
$lang['file_folders.delete_success']		= 'La carpeta "%s" fue eliminada.';
$lang['file_folders.delete_error']			= 'An error occurred while trying to delete the folder "%s".'; #translate
$lang['file_folders.not_exists']			= 'Se ha seleccionado una carpeta inválida.';
$lang['file_folders.no_subfolders']			= 'Ninguna';
$lang['file_folders.no_folders']			= 'Tus archivos estan ordenados por carpetas. Actualmente no tienes ninguna carpeta.';
$lang['file_folders.mkdir_error']			= 'No se pudo crear el directorio uploads/files';
$lang['file_folders.chmod_error']			= 'No se pudo cambiar el permiso del directorio uploads/files';

/* End of file files_lang.php */
/* Location: ./system/pyrocms/modules/files/language/spanish/files_lang.php */