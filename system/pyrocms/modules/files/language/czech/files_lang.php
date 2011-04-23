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
$lang['files.files_title']					= 'Souborz';
$lang['files.upload_title']					= 'Nahrát soubory';
$lang['files.edit_title']					= 'Edit file "%s"'; #translate

// Labels
$lang['files.actions_label']				= 'Akce';
$lang['files.download_label']				= 'Stáhnout';
$lang['files.edit_label']					= 'Upravit';
$lang['files.delete_label']					= 'Vymazat';
$lang['files.upload_label']					= 'Nahrát';
$lang['files.description_label']			= 'Popis';
$lang['files.type_label']					= 'Typ';
$lang['files.file_label']					= 'Soubor';
$lang['files.filename_label']				= 'Jméno souboru';
$lang['files.filter_label']					= 'Filter'; #translate
$lang['files.loading_label']				= 'Loading...'; #translate
$lang['files.name_label']					= 'Name'; #translate

$lang['files.dropdown_no_subfolders']		= '-- Nic --';
$lang['files.dropdown_root']				= '-- Kořenový adresář --';

$lang['files.type_a']						= 'Audio';
$lang['files.type_v']						= 'Video';
$lang['files.type_d']						= 'Dokument';
$lang['files.type_i']						= 'Obrázek';
$lang['files.type_o']						= 'Ostatní';

$lang['files.display_grid']					= 'Grid'; #translate
$lang['files.display_list']					= 'List'; #translate

// Messages
$lang['files.create_success']				= 'Soubor byl uložen';
$lang['files.create_error']					= 'An error as occourred.'; #translate
$lang['files.edit_success']					= 'The file was successfully saved.'; #translate
$lang['files.edit_error']					= 'An error occurred while trying to save the file.'; #translate
$lang['files.delete_success']				= 'Soubor byl vymazán.';
$lang['files.delete_error']					= 'Soubor se nepodařilo vymazat.';
$lang['files.mass_delete_success']			= '%d of %d files were successfully deleted, they were "%s and %s"'; #translate
$lang['files.mass_delete_error']			= 'An error occurred while trying to delete %d of %d files, they are "%s and %s".'; #translate
$lang['files.upload_error']					= 'A file must be uploaded.'; #translate
$lang['files.invalid_extension']			= 'File must have a valid extension.'; #translate
$lang['files.not_exists']					= 'Byl zvolen neplatný soubor.';
$lang['files.no_files']						= 'V tuto chvíli tu nejsou žádné soubory.';
$lang['files.no_permissions']				= 'You do not have permissions to see the files module.'; #translate
$lang['files.no_select_error'] 				= 'You must select a file first, his request was interrupted.'; #translate

// File folders

// Titles
$lang['file_folders.folders_title']			= 'Složky souborů';
$lang['file_folders.manage_title']			= 'Spravovat složky';
$lang['file_folders.create_title']			= 'Nová složka';
$lang['file_folders.delete_title']			= 'Potvrdit vymazání';
$lang['file_folders.edit_title']			= 'Edit folder "%s"'; #translate

// Labels
$lang['file_folders.folders_label']			= 'Složky';
$lang['file_folders.folder_label']			= 'Složky';
$lang['file_folders.subfolders_label']		= 'Podsložky';
$lang['file_folders.parent_label']			= 'Rodič';
$lang['file_folders.name_label']			= 'Jméno';
$lang['file_folders.slug_label']			= 'Čitelné jméno v URL';
$lang['file_folders.created_label']			= 'Vytvořeno';

// Messages
$lang['file_folders.create_success']		= 'Složka byla uložena.';
$lang['file_folders.create_error']			= 'An error occurred while attempting to create your folder.'; #translate
$lang['file_folders.duplicate_error']		= 'A folder named "%s" already exists.'; #translate
$lang['file_folders.edit_success']			= 'The folder was successfully saved.'; #translate
$lang['file_folders.edit_error']			= 'An error occurred while trying to save the changes.'; #translate
$lang['file_folders.confirm_delete']		= 'Are you sure you want to delete the folders below, including all files and subfolders inside them?'; #translate
$lang['file_folders.delete_mass_success']	= '%d of %d folders have been successfully deleted, they were "%s and %s.'; #translate
$lang['file_folders.delete_mass_error']		= 'An error occurred while trying to delete %d of %d folders, they are "%s and %s".'; #translate
$lang['file_folders.delete_success']		= 'Složka "%s" byla vymazána.';
$lang['file_folders.delete_error']			= 'An error occurred while trying to delete the folder "%s".'; #translate
$lang['file_folders.not_exists']			= 'Byla vybrána neplatná složka.';
$lang['file_folders.no_subfolders']			= 'Nic';
$lang['file_folders.no_folders']			= 'Vaše soubory jsou řazeny podle složek, v tuto chvíli nemáte vytvořeny žádné složky.';
$lang['file_folders.mkdir_error']			= 'Nezdařilo se provést příkaz mkdir pro soubory.';
$lang['file_folders.chmod_error']			= 'Nepodařilo se změnit práva ke složkám pomocí příkazu chmod.';

/* End of file files_lang.php */