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
/* Translation made Nicola Tudino */
/* Date 04/11/2010 */

// Files

// Titles
$lang['files.files_title']					= 'File';
$lang['files.upload_title']					= 'Carica File';
$lang['files.edit_title']					= 'Edit file "%s"'; #translate

// Labels
$lang['files.actions_label']				= 'Azione';
$lang['files.download_label']				= 'Download'; #translate
$lang['files.edit_label']					= 'Modifica';
$lang['files.delete_label']					= 'Elimina';
$lang['files.upload_label']					= 'Carica';
$lang['files.description_label']			= 'Descrizione';
$lang['files.type_label']					= 'Tipo';
$lang['files.file_label']					= 'File';
$lang['files.filename_label']				= 'Nome del File';
$lang['files.filter_label']					= 'Filter'; #translate
$lang['files.loading_label']				= 'Loading...'; #translate
$lang['files.name_label']					= 'Name'; #translate

$lang['files.dropdown_no_subfolders']		= '-- Nessuna --';
$lang['files.dropdown_root']				= '-- Radice --';

$lang['files.type_a']						= 'Audio';
$lang['files.type_v']						= 'Video';
$lang['files.type_d']						= 'Documento';
$lang['files.type_i']						= 'Immagine';
$lang['files.type_o']						= 'Altro';

$lang['files.display_grid']					= 'Grid'; #translate
$lang['files.display_list']					= 'List'; #translate

// Messages
$lang['files.create_success']				= 'Il file è stato salvato.';
$lang['files.create_error']					= 'An error as occourred.'; #translate
$lang['files.edit_success']					= 'The file was successfully saved.'; #translate
$lang['files.edit_error']					= 'An error occurred while trying to save the file.'; #translate
$lang['files.delete_success']				= 'Il file è stato eliminato.';
$lang['files.delete_error']					= 'Il file non può essere eliminato.';
$lang['files.mass_delete_success']			= '%d of %d files were successfully deleted, they were "%s and %s"'; #translate
$lang['files.mass_delete_error']			= 'An error occurred while trying to delete %d of %d files, they are "%s and %s".'; #translate
$lang['files.upload_error']					= 'A file must be uploaded.'; #translate
$lang['files.invalid_extension']			= 'File must have a valid extension.'; #translate
$lang['files.not_exists']					= 'E\' stata selezionata una cartella non valida.';
$lang['files.no_files']						= 'Attualmente non ci sono files.';
$lang['files.no_permissions']				= 'You do not have permissions to see the files module.'; #translate
$lang['files.no_select_error'] 				= 'You must select a file first, his request was interrupted.'; #translate

// File folders

// Titles
$lang['file_folders.folders_title']			= 'Cartelle &amp; File';
$lang['file_folders.manage_title']			= 'Gestisci Cartelle';
$lang['file_folders.create_title']			= 'Nuova Cartella';
$lang['file_folders.delete_title']			= 'Conferma l\' eliminazione';
$lang['file_folders.edit_title']			= 'Edit folder "%s"'; #translate

// Labels
$lang['file_folders.folders_label']			= 'Cartelle';
$lang['file_folders.folder_label']			= 'Cartella';
$lang['file_folders.subfolders_label']		= 'Sotto-Cartelle';
$lang['file_folders.parent_label']			= 'Livello superiore';
$lang['file_folders.name_label']			= 'Nome';
$lang['file_folders.slug_label']			= 'URL Slug (Friendly URL)';
$lang['file_folders.created_label']			= 'Creata il';

// Messages
$lang['file_folders.create_success']		= 'La cartella è stata salvata.';
$lang['file_folders.create_error']			= 'An error occurred while attempting to create your folder.'; #translate
$lang['file_folders.duplicate_error']		= 'A folder named "%s" already exists.'; #translate
$lang['file_folders.edit_success']			= 'The folder was successfully saved.'; #translate
$lang['file_folders.edit_error']			= 'An error occurred while trying to save the changes.'; #translate
$lang['file_folders.confirm_delete']		= 'Are you sure you want to delete the folders below, including all files and subfolders inside them?'; #translate
$lang['file_folders.delete_mass_success']	= '%d of %d folders have been successfully deleted, they were "%s and %s.'; #translate
$lang['file_folders.delete_mass_error']		= 'An error occurred while trying to delete %d of %d folders, they are "%s and %s".'; #translate
$lang['file_folders.delete_success']		= 'La cartella "%s" è stata eliminata.';
$lang['file_folders.delete_error']			= 'An error occurred while trying to delete the folder "%s".'; #translate
$lang['file_folders.not_exists']			= 'E\' stata selezionata una cartella non valida.';
$lang['file_folders.no_subfolders']			= 'Nessuna';
$lang['file_folders.no_folders']			= 'I tuoi file sono ordinati per cartelle, attualmente non hai configurato nessuna cartella.';
$lang['file_folders.mkdir_error']			= 'Impossibile creare la cartella uploads/files';
$lang['file_folders.chmod_error']			= 'Impossibile effettuare il chmod della cartella uploads/files';

/* End of file files_lang.php */