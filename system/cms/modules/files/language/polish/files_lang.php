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
$lang['files.files_title']					= 'Pliki';
$lang['files.upload_title']					= 'Wgraj pliki';
$lang['files.edit_title']					= 'Edit file "%s"'; #translate

// Labels
$lang['files.actions_label']				= 'Akcja';
$lang['files.download_label']				= 'Download'; #translate
$lang['files.edit_label']					= 'Edytuj';
$lang['files.delete_label']					= 'Usuń';
$lang['files.upload_label']					= 'Wgraj';
$lang['files.description_label']			= 'Opis';
$lang['files.type_label']					= 'Typ';
$lang['files.file_label']					= 'Plik';
$lang['files.filename_label']				= 'Nazwa pliku';
$lang['files.filter_label']					= 'Filter'; #translate
$lang['files.loading_label']				= 'Loading...'; #translate
$lang['files.name_label']					= 'Name'; #translate

$lang['files.dropdown_no_subfolders']		= '-- Brak --';
$lang['files.dropdown_root']				= '-- Root --';

$lang['files.type_a']						= 'Plik audio';
$lang['files.type_v']						= 'Plik video';
$lang['files.type_d']						= 'Dokument';
$lang['files.type_i']						= 'Obraz';
$lang['files.type_o']						= 'Inny';

$lang['files.display_grid']					= 'Grid'; #translate
$lang['files.display_list']					= 'List'; #translate

// Messages
$lang['files.create_success']				= 'Plik został zachowany.';
$lang['files.create_error']					= 'An error as occourred.'; #translate
$lang['files.edit_success']					= 'The file was successfully saved.'; #translate
$lang['files.edit_error']					= 'An error occurred while trying to save the file.'; #translate
$lang['files.delete_success']				= 'Plik został usunięty.';
$lang['files.delete_error']					= 'Plik nie mógł zostać usunięty.';
$lang['files.mass_delete_success']			= '%d of %d files were successfully deleted, they were "%s and %s"'; #translate
$lang['files.mass_delete_error']			= 'An error occurred while trying to delete %d of %d files, they are "%s and %s".'; #translate
$lang['files.upload_error']					= 'A file must be uploaded.'; #translate
$lang['files.invalid_extension']			= 'File must have a valid extension.'; #translate
$lang['files.not_exists']					= 'Wybrano nieprawidłowy katalog.';
$lang['files.no_files']						= 'W tej chwili nie ma żadnych plików.';
$lang['files.no_permissions']				= 'You do not have permissions to see the files module.'; #translate
$lang['files.no_select_error'] 				= 'You must select a file first, his request was interrupted.'; #translate

// File folders

// Titles
$lang['file_folders.folders_title']			= 'Katalogi plików';
$lang['file_folders.manage_title']			= 'Zarządzaj katalogami';
$lang['file_folders.create_title']			= 'Dodaj katalog';
$lang['file_folders.delete_title']			= 'Potwierdź usunięcie';
$lang['file_folders.edit_title']			= 'Edit folder "%s"'; #translate

// Labels
$lang['file_folders.folders_label']			= 'Katalogi';
$lang['file_folders.folder_label']			= 'Katalog';
$lang['file_folders.subfolders_label']		= 'Podkatalog';
$lang['file_folders.parent_label']			= 'Rodzic';
$lang['file_folders.name_label']			= 'Nazwa';
$lang['file_folders.slug_label']			= 'URL Slug';
$lang['file_folders.created_label']			= 'Utworzony';

// Messages
$lang['file_folders.create_success']		= 'Katalog został zachowany.';
$lang['file_folders.create_error']			= 'An error occurred while attempting to create your folder.'; #translate
$lang['file_folders.duplicate_error']		= 'A folder named "%s" already exists.'; #translate
$lang['file_folders.edit_success']			= 'The folder was successfully saved.'; #translate
$lang['file_folders.edit_error']			= 'An error occurred while trying to save the changes.'; #translate
$lang['file_folders.confirm_delete']		= 'Are you sure you want to delete the folders below, including all files and subfolders inside them?'; #translate
$lang['file_folders.delete_mass_success']	= '%d of %d folders have been successfully deleted, they were "%s and %s.'; #translate
$lang['file_folders.delete_mass_error']		= 'An error occurred while trying to delete %d of %d folders, they are "%s and %s".'; #translate
$lang['file_folders.delete_success']		= 'Katalog "%s" został usunięty.';
$lang['file_folders.delete_error']			= 'An error occurred while trying to delete the folder "%s".'; #translate
$lang['file_folders.not_exists']			= 'Wybrany został nieprawidłowy katalog.';
$lang['file_folders.no_subfolders']			= 'Żaden';
$lang['file_folders.no_folders']			= 'Twoje pliki są sortowane wegług katalogów, obecnie nie masz żadnych katalogów.';
$lang['file_folders.mkdir_error']			= 'Nie można utworzyć katalogu uploads/files';
$lang['file_folders.chmod_error']			= 'Nie można zmienić chmod dla katalogu uploads/files';

/* End of file files_lang.php */