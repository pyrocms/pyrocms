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
$lang['files.files_title']			= 'Fájlok';
$lang['files.upload_title']			= 'Fájlok feltöltése';
$lang['files.edit_title']			= 'A(z) "%s" fájl szerkesztése';

// Labels
$lang['files.download_label']			= 'Letöltés';
$lang['files.upload_label']			= 'Feltöltés';
$lang['files.description_label']		= 'Leírás';
$lang['files.type_label']			= 'Típus';
$lang['files.file_label']			= 'Fájl';
$lang['files.filename_label']			= 'Fájl neve';
$lang['files.filter_label']			= 'Szűrő';
$lang['files.loading_label']			= 'Töltés...';
$lang['files.name_label']			= 'Név';

$lang['files.dropdown_select']			= '-- Válassz mappát --';
$lang['files.dropdown_no_subfolders']		= '-- Nincs --';
$lang['files.dropdown_root']			= '-- Gyökér --';

$lang['files.type_a']				= 'Hang';
$lang['files.type_v']				= 'Videó';
$lang['files.type_d']				= 'Dokumentum';
$lang['files.type_i']				= 'Kép';
$lang['files.type_o']				= 'Egyéb';

$lang['files.display_grid']			= 'Rács';
$lang['files.display_list']			= 'Lista';

// Messages
$lang['files.create_success']			= 'A(z) "%s" fájl sikeresen feltöltve.';
$lang['files.create_error']			= 'A fájl feltöltése sikertelen.';
$lang['files.edit_success']			= 'A fájl sikeresen módosítva.';
$lang['files.edit_error']			= 'A fájl módosítása sikertelen.';
$lang['files.delete_success']			= 'A fájl sikeresen törölve.';
$lang['files.delete_error']			= 'A fájlt törölése sikertelen.';
$lang['files.mass_delete_success']		= '%d of %d files were successfully deleted. They were "%s and %s"'; #translate
$lang['files.mass_delete_error']		= 'An error occurred while trying to delete %d of %d files, they are "%s and %s".'; #translate
$lang['files.upload_error']			= 'Egy fájlt fel kell tölteni.';
$lang['files.invalid_extension']		= 'A fájlnak érvényes kiterjesztésűnek kell lennie.';
$lang['files.not_exists']			= 'Érvénytelen mappa van kiválasztva.';
$lang['files.no_files']				= 'Jelenleg nincs kép.';
$lang['files.no_permissions']			= 'Nincs jogosultsága megtekinteni a Fájl-modult.';
$lang['files.no_select_error'] 			= 'Ki kell választani egy fájlt. Az első kérés megszakadt.';

// File folders

// Titles
$lang['file_folders.folders_title']		= 'Mappák';
$lang['file_folders.manage_title']		= 'Mappakezelés';
$lang['file_folders.create_title']		= 'Új mappa';
$lang['file_folders.delete_title']		= 'Törlés megerősítése';
$lang['file_folders.edit_title']		= 'A(z) "%s" mappa szerkesztése';

// Labels
$lang['file_folders.folders_label']		= 'Mappák';
$lang['file_folders.folder_label']		= 'Mappa';
$lang['file_folders.subfolders_label']		= 'Al-mappák';
$lang['file_folders.parent_label']		= 'Szülő';
$lang['file_folders.name_label']		= 'Név';
$lang['file_folders.slug_label']		= 'Keresőbarát URL';
$lang['file_folders.created_label']		= 'Létrehozva';

// Messages
$lang['file_folders.create_success']		= 'A mappa sikeresen létrehozva.';
$lang['file_folders.create_error']		= 'Hiba történt a mappa létrehozásakor.';
$lang['file_folders.duplicate_error']		= 'A(z) "%s" mappa már létezik.';
$lang['file_folders.edit_success']		= 'A mappa sikeresen módosítva.';
$lang['file_folders.edit_error']		= 'Hiba történt a mappa mentésekor.';
$lang['file_folders.confirm_delete']		= 'Biztos, hogy törlöd a mappát? A benne lévő összes fájl és mappa is törölve lesz.';
$lang['file_folders.delete_mass_success']	= '%d of %d folders have been successfully deleted, they were "%s and %s.'; #translate
$lang['file_folders.delete_mass_error']		= 'An error occurred while trying to delete %d of %d folders, they are "%s and %s".'; #translate
$lang['file_folders.delete_success']		= 'A(z) "%s" mappa törölve.';
$lang['file_folders.delete_error']		= 'Hiba történt a(z) "%s" mappa törlésekor.';
$lang['file_folders.not_exists']		= 'Érvénytelen mappa van kiválasztva.';
$lang['file_folders.no_subfolders']		= 'Nincs';
$lang['file_folders.no_folders']		= 'A fájlok sorrendje mappák szerint van rendezve, jelenleg nincs mappa-felépítés.';
$lang['file_folders.mkdir_error']		= 'Nem lehet létrehozni az uploads/files könyvtárat';
$lang['file_folders.chmod_error']		= 'Nem lehet chmod-olni az uploads/files könyvtárat';

/* End of file files_lang.php */