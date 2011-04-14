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
$lang['files.files_title']					= 'Bestanden';
$lang['files.upload_title']					= 'Upload Bestanden';
$lang['files.edit_title']					= 'Edit file "%s"'; #translate

// Labels
$lang['files.actions_label']				= 'Actie';
$lang['files.download_label']				= 'Download'; #translate
$lang['files.edit_label']					= 'Wijzig';
$lang['files.delete_label']					= 'Verwijderen';
$lang['files.upload_label']					= 'Upload';
$lang['files.description_label']			= 'Beschrijving';
$lang['files.type_label']					= 'Type';
$lang['files.file_label']					= 'Bestand';
$lang['files.filename_label']				= 'Bestandsnaam';
$lang['files.filter_label']					= 'Filter'; #translate
$lang['files.loading_label']				= 'Loading...'; #translate
$lang['files.name_label']					= 'Name'; #translate

$lang['files.dropdown_no_subfolders']		= '-- Geen --';
$lang['files.dropdown_root']				= '-- Root --';

$lang['files.type_a']						= 'Audio';
$lang['files.type_v']						= 'Video';
$lang['files.type_d']						= 'Document';
$lang['files.type_i']						= 'Afbeelding';
$lang['files.type_o']						= 'Anders';

$lang['files.display_grid']					= 'Grid'; #translate
$lang['files.display_list']					= 'List'; #translate

// Messages
$lang['files.create_success']				= 'Het bestand is nu opgeslagen.';
$lang['files.create_error']					= 'An error as occourred.'; #translate
$lang['files.edit_success']					= 'The file was successfully saved.'; #translate
$lang['files.edit_error']					= 'An error occurred while trying to save the file.'; #translate
$lang['files.delete_success']				= 'Het bestand is verwijderd.';
$lang['files.delete_error']					= 'Het bestand kon niet worden verwijderd.';
$lang['files.mass_delete_success']			= '%d of %d files were successfully deleted, they were "%s and %s"'; #translate
$lang['files.mass_delete_error']			= 'An error occurred while trying to delete %d of %d files, they are "%s and %s".'; #translate
$lang['files.upload_error']					= 'A file must be uploaded.'; #translate
$lang['files.invalid_extension']			= 'File must have a valid extension.'; #translate
$lang['files.not_exists']					= 'Een ongeldige folder is geselecteerd.';
$lang['files.no_files']						= 'Er zijn momenteel geen bestanden.';
$lang['files.no_permissions']				= 'You do not have permissions to see the files module.'; #translate
$lang['files.no_select_error'] 				= 'You must select a file first, his request was interrupted.'; #translate

// File folders

// Titles
$lang['file_folders.folders_title']			= 'Bestand folders';
$lang['file_folders.manage_title']			= 'Beheer folders';
$lang['file_folders.create_title']			= 'Nieuwe Folder';
$lang['file_folders.delete_title']			= 'Bevestig Verwijderen';
$lang['file_folders.edit_title']			= 'Edit folder "%s"'; #translate

// Labels
$lang['file_folders.folders_label']			= 'Folders';
$lang['file_folders.folder_label']			= 'Folder';
$lang['file_folders.subfolders_label']		= 'Sub-Folders';
$lang['file_folders.parent_label']			= 'Bovenliggend';
$lang['file_folders.name_label']			= 'Naam';
$lang['file_folders.slug_label']			= 'URI';
$lang['file_folders.created_label']			= 'Gemaakt Op';

// Messages
$lang['file_folders.create_success']		= 'De folder is opgeslagen.';
$lang['file_folders.create_error']			= 'An error occurred while attempting to create your folder.'; #translate
$lang['file_folders.edit_success']			= 'The folder was successfully saved.'; #translate
$lang['file_folders.edit_error']			= 'An error occurred while trying to save the changes.'; #translate
$lang['file_folders.confirm_delete']		= 'Are you sure you want to delete the folders below, including all files and subfolders inside them?'; #translate
$lang['file_folders.delete_mass_success']	= '%d of %d folders have been successfully deleted, they were "%s and %s.'; #translate
$lang['file_folders.delete_mass_error']		= 'An error occurred while trying to delete %d of %d folders, they are "%s and %s".'; #translate
$lang['file_folders.delete_success']		= 'De folder"%s" is verwijderd.';
$lang['file_folders.delete_error']			= 'An error occurred while trying to delete the folder "%s".'; #translate
$lang['file_folders.not_exists']			= 'Een ongeldige folder is geselecteerd.';
$lang['file_folders.no_subfolders']			= 'Geen';
$lang['file_folders.no_folders']			= 'Er zijn momenteel geen folders.';
$lang['file_folders.mkdir_error']			= 'Kon geen upload/bestand map aanmaken';
$lang['file_folders.chmod_error']			= 'Kon niet chmod op de upload/bestand map toepassen';

/* End of file files_lang.php */