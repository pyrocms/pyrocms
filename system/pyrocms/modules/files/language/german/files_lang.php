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
$lang['files.files_title']					= 'Dateien';
$lang['files.upload_title']					= 'Dateien hochladen';
$lang['files.edit_title']					= 'Edit file "%s"'; #translate

// Labels
$lang['files.actions_label']				= 'Aktionen';
$lang['files.download_label']				= 'Download'; #translate
$lang['files.edit_label']					= 'Bearbeiten';
$lang['files.delete_label']					= 'Löschen';
$lang['files.upload_label']					= 'Hochladen';
$lang['files.description_label']			= 'Beschreibung';
$lang['files.type_label']					= 'Typ';
$lang['files.file_label']					= 'Datei';
$lang['files.filename_label']				= 'Dateiname';
$lang['files.filter_label']					= 'Filter'; #translate
$lang['files.loading_label']				= 'Loading...'; #translate
$lang['files.name_label']					= 'Name'; #translate

$lang['files.dropdown_no_subfolders']		= '-- Keines --';
$lang['files.dropdown_root']				= '-- Root --';

$lang['files.type_a']						= 'Audio';
$lang['files.type_v']						= 'Video';
$lang['files.type_d']						= 'Dokument';
$lang['files.type_i']						= 'Bild';
$lang['files.type_o']						= 'Anderer';

$lang['files.display_grid']					= 'Grid'; #translate
$lang['files.display_list']					= 'List'; #translate

// Messages
$lang['files.create_success']				= 'Die Datei wurde gespeichert.';
$lang['files.create_error']					= 'An error as occourred.'; #translate
$lang['files.edit_success']					= 'The file was successfully saved.'; #translate
$lang['files.edit_error']					= 'An error occurred while trying to save the file.'; #translate
$lang['files.delete_success']				= 'Die Datei wurde gelöscht.';
$lang['files.delete_error']					= 'Die Datei konnte nicht gelöscht werden.';
$lang['files.mass_delete_success']			= '%d of %d files were successfully deleted, they were "%s and %s"'; #translate
$lang['files.mass_delete_error']			= 'An error occurred while trying to delete %d of %d files, they are "%s and %s".'; #translate
$lang['files.upload_error']					= 'A file must be uploaded.'; #translate
$lang['files.invalid_extension']			= 'File must have a valid extension.'; #translate
$lang['files.not_exists']					= 'Es wurde ein ungültiges Verzeichnis ausgewählt.';
$lang['files.no_files']						= 'Keine Dateien vorhanden.';
$lang['files.no_permissions']				= 'You do not have permissions to see the files module.'; #translate
$lang['files.no_select_error'] 				= 'You must select a file first, his request was interrupted.'; #translate

// File folders

// Titles
$lang['file_folders.folders_title']			= 'Verzeichnisse';
$lang['file_folders.manage_title']			= 'Verzeichnisse verwalten';
$lang['file_folders.create_title']			= 'Neues Verzeichnis';
$lang['file_folders.delete_title']			= 'Löschen bestätigen';
$lang['file_folders.edit_title']			= 'Edit folder "%s"'; #translate

// Labels
$lang['file_folders.folders_label']			= 'Verzeichnisse';
$lang['file_folders.folder_label']			= 'Verzeichnis';
$lang['file_folders.subfolders_label']		= 'Unterverzeichnisse';
$lang['file_folders.parent_label']			= 'Vorgänger';
$lang['file_folders.name_label']			= 'Name';
$lang['file_folders.slug_label']			= 'URL Slug';
$lang['file_folders.created_label']			= 'Erstellt am';

// Messages
$lang['file_folders.create_success']		= 'Das Verzeichnis wurde gespeichert.';
$lang['file_folders.create_error']			= 'An error occurred while attempting to create your folder.'; #translate
$lang['file_folders.duplicate_error']		= 'A folder named "%s" already exists.'; #translate
$lang['file_folders.edit_success']			= 'The folder was successfully saved.'; #translate
$lang['file_folders.edit_error']			= 'An error occurred while trying to save the changes.'; #translate
$lang['file_folders.confirm_delete']		= 'Are you sure you want to delete the folders below, including all files and subfolders inside them?'; #translate
$lang['file_folders.delete_mass_success']	= '%d of %d folders have been successfully deleted, they were "%s and %s.'; #translate
$lang['file_folders.delete_mass_error']		= 'An error occurred while trying to delete %d of %d folders, they are "%s and %s".'; #translate
$lang['file_folders.delete_success']		= 'Das Verzeichnis "%s" wurde gelöscht.';
$lang['file_folders.delete_error']			= 'An error occurred while trying to delete the folder "%s".'; #translate
$lang['file_folders.not_exists']			= 'Es wurde ein ungültiges Verzeichnis ausgewählt.';
$lang['file_folders.no_subfolders']			= 'Keine';
$lang['file_folders.no_folders']			= 'Es existieren aktuell keine Verzeichnisse.';
$lang['file_folders.mkdir_error']			= 'Das Verzeichnis konnte nicht angelegt werden.';
$lang['file_folders.chmod_error']			= 'Das Zugriffsrechte (chmod) des Verzeichnisses konnten nicht geändert werden.';

/* End of file files_lang.php */