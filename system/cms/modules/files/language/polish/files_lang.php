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
$lang['files.edit_title']					= 'Edytuj plik "%s"';

// Labels
$lang['files.actions_label']				= 'Akcja';
$lang['files.download_label']				= 'Pobierz'; 
$lang['files.edit_label']					= 'Edytuj';
$lang['files.delete_label']					= 'Usuń';
$lang['files.upload_label']					= 'Wgraj';
$lang['files.description_label']			= 'Opis';
$lang['files.type_label']					= 'Typ';
$lang['files.file_label']					= 'Plik';
$lang['files.filename_label']				= 'Nazwa pliku';
$lang['files.filter_label']					= 'Sortuj'; 
$lang['files.loading_label']				= 'Ładuję...';
$lang['files.name_label']					= 'Nazwa'; 

$lang['files.dropdown_no_subfolders']		= '-- Brak --';
$lang['files.dropdown_root']				= '-- Root --';

$lang['files.type_a']						= 'Plik audio';
$lang['files.type_v']						= 'Plik video';
$lang['files.type_d']						= 'Dokument';
$lang['files.type_i']						= 'Obraz';
$lang['files.type_o']						= 'Inny';

$lang['files.display_grid']					= 'Kostka';
$lang['files.display_list']					= 'Lista';

// Messages
$lang['files.create_success']				= 'Plik został zachowany.';
$lang['files.create_error']					= 'Wystąpił błąd.';
$lang['files.edit_success']					= 'Plik został pomyślnie zapisany.';
$lang['files.edit_error']					= 'Wystąpił błąd podczas próby zapisania pliku.'; 
$lang['files.delete_success']				= 'Plik został usunięty.';
$lang['files.delete_error']					= 'Plik nie mógł zostać usunięty.';
$lang['files.mass_delete_success']			= '%d z %d zostały pomyślnie usunięte, są to "%s oraz %s"';
$lang['files.mass_delete_error']			= 'Wystąpił błąd poczas próby usunięcia %d z %d plików, są to "%s oraz %s".';
$lang['files.upload_error']					= 'Plik musi zostac wysłany na server.'; 
$lang['files.invalid_extension']			= 'Plik musi mieć prawidłowe rozszerzenie.'; 
$lang['files.not_exists']					= 'Wybrano nieprawidłowy katalog.';
$lang['files.no_files']						= 'W tej chwili nie ma żadnych plików.';
$lang['files.no_permissions']				= 'Nie posiadasz uprawnień by zobaczyć pliki tego modułu.'; 
$lang['files.no_select_error'] 				= 'Musisz napierw zaznaczyc plik.'; 

// File folders

// Titles
$lang['file_folders.folders_title']			= 'Katalogi plików';
$lang['file_folders.manage_title']			= 'Zarządzaj katalogami';
$lang['file_folders.create_title']			= 'Dodaj katalog';
$lang['file_folders.delete_title']			= 'Potwierdź usunięcie';
$lang['file_folders.edit_title']			= 'Edytuj folder "%s"'; 

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
$lang['file_folders.create_error']			= 'Wystąpił błąd poczas próby utworzenia folderu.'; 
$lang['file_folders.duplicate_error']		= 'Folder o nazwie "%s" już istnieje.'; 
$lang['file_folders.edit_success']			= 'Folder pomyślnie zapisany.'; 
$lang['file_folders.edit_error']			= 'Wystąpił błąd podczas próby zapisania zmian.'; 
$lang['file_folders.confirm_delete']		= 'Czy jesteś pewny że chcesz usunąć poniższe foldery, włanczając w to wszystkie podfoldery oraz pliki?';
$lang['file_folders.delete_mass_success']	= '%d z %d folderów zostały pomyślnie usunięte, są one "%s oraz %s.';
$lang['file_folders.delete_mass_error']		= 'Wystąpił błąd podczas próby usunięcia %d z %d folderów, są one "%s oraz %s".'; 
$lang['file_folders.delete_success']		= 'Katalog "%s" został usunięty.';
$lang['file_folders.delete_error']			= 'Wystąpił błąd podczas próby usunięcia folderu "%s".';
$lang['file_folders.not_exists']			= 'Wybrany został nieprawidłowy katalog.';
$lang['file_folders.no_subfolders']			= 'Żaden';
$lang['file_folders.no_folders']			= 'Twoje pliki są sortowane wegług katalogów, obecnie nie masz żadnych katalogów.';
$lang['file_folders.mkdir_error']			= 'Nie można utworzyć katalogu uploads/files';
$lang['file_folders.chmod_error']			= 'Nie można zmienić chmod dla katalogu uploads/files';

/* End of file files_lang.php */