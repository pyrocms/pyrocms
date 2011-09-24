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
$lang['files.files_title']					= 'Fájlok';
$lang['files.upload_title']					= 'Fájlok feltöltése';
$lang['files.edit_title']					= 'Fájl módosítása: "%s"';

// Labels
$lang['files.actions_label']				= 'Műveletek';
$lang['files.download_label']				= 'Letöltések';
$lang['files.edit_label']					= 'Módosítás';
$lang['files.delete_label']					= 'Törlés';
$lang['files.upload_label']					= 'Feltöltés';
$lang['files.description_label']			= 'Leírás';
$lang['files.type_label']					= 'Típus';
$lang['files.file_label']					= 'Fájl';
$lang['files.filename_label']				= 'Fájl név';
$lang['files.filter_label']					= 'Szűrő';
$lang['files.loading_label']				= 'Töltés...';
$lang['files.name_label']					= 'Név';

$lang['files.dropdown_no_subfolders']		= '-- Nincs --';
$lang['files.dropdown_root']				= '-- Gyökér --';

$lang['files.type_a']						= 'Hang';
$lang['files.type_v']						= 'Videó';
$lang['files.type_d']						= 'Dokumentum';
$lang['files.type_i']						= 'Kép';
$lang['files.type_o']						= 'Egyéb';

$lang['files.display_grid']					= 'Tábla';
$lang['files.display_list']					= 'Lista';

// Messages
$lang['files.create_success']				= 'A fájl sikeresen el lett mentve.';
$lang['files.create_error']					= 'Egy hiba lépett fel.';
$lang['files.edit_success']					= 'A fájl sikeresen el lett mentve.';
$lang['files.edit_error']					= 'Egy hiba lépett efl a fájl létrehozásakor.';
$lang['files.delete_success']				= 'A fálj sikeresen törölve lett.';
$lang['files.delete_error']					= 'Nem lehetett törölni a fájlt.';
$lang['files.mass_delete_success']			= '%d fájl %d fájlból sikeresen törlésre kerültek. "%s és %s".';
$lang['files.mass_delete_error']			= '%d/%d fájl nem került törlésre egy hiba okából kifolyólag. Csupán a következőket lehetett törölni: "%s és %s".';
$lang['files.upload_error']					= 'Egy fájlt kell feltötlteni.';
$lang['files.invalid_extension']			= 'A fájlnak nincs valós kiterjesztése.';
$lang['files.not_exists']					= 'Egy érvénytelen fájl került kiválasztásra.';
$lang['files.no_files']						= 'Jelenleg nincsenek fájlok.';
$lang['files.no_permissions']				= 'Nincsenek jogosultságok a fájlok, illetve ennek am odulnak a megtekintéséhez.';
$lang['files.no_select_error'] 				= 'Előbb ki kell választani egy fájlt, ez a mávelet meg lett szakítva.';

// File folders

// Titles
$lang['file_folders.folders_title']			= 'Fájl könyvtárak';
$lang['file_folders.manage_title']			= 'Könyvtárak kezelése';
$lang['file_folders.create_title']			= 'Új könyvtár';
$lang['file_folders.delete_title']			= 'Törlés megerősítése';
$lang['file_folders.edit_title']			= 'Könyvtár módosítása: "%s"';

// Labels
$lang['file_folders.folders_label']			= 'Könyvtárak';
$lang['file_folders.folder_label']			= 'Könyvtár';
$lang['file_folders.subfolders_label']		= 'Alkönyvtárak';
$lang['file_folders.parent_label']			= 'Szülő';
$lang['file_folders.name_label']			= 'Név';
$lang['file_folders.slug_label']			= 'Beszédes URL';
$lang['file_folders.created_label']			= 'Készítve';

// Messages
$lang['file_folders.create_success']		= 'The folder has now been saved.';
$lang['file_folders.create_error']			= 'An error occurred while attempting to create your folder.';
$lang['file_folders.duplicate_error']		= 'A folder named "%s" already exists.';
$lang['file_folders.edit_success']			= 'The folder was successfully saved.';
$lang['file_folders.edit_error']			= 'An error occurred while trying to save the changes.';
$lang['file_folders.confirm_delete']		= 'Are you sure you want to delete the folders below, including all files and subfolders inside them?';
$lang['file_folders.delete_mass_success']	= '%d of %d folders have been successfully deleted, they were "%s and %s.';
$lang['file_folders.delete_mass_error']		= 'An error occurred while trying to delete %d of %d folders, they are "%s and %s".';
$lang['file_folders.delete_success']		= 'The folder "%s" was deleted.';
$lang['file_folders.delete_error']			= 'An error occurred while trying to delete the folder "%s".';
$lang['file_folders.not_exists']			= 'An invalid folder has been selected.';
$lang['file_folders.no_subfolders']			= 'None';
$lang['file_folders.no_folders']			= 'Your files are sorted by folders, currently you do not have any folders setup.';
$lang['file_folders.mkdir_error']			= 'Could not make the uploads/files directory';
$lang['file_folders.chmod_error']			= 'Could not chmod the uploads/files directory';

/* End of file files_lang.php */
