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
$lang['files.files_title']					= 'Soubory';
$lang['files.upload_title']					= 'Nahrát soubory';
$lang['files.edit_title']					= 'Upravit soubor "%s"';

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
$lang['files.filter_label']					= 'Filtr'; 
$lang['files.loading_label']				= 'Nahrávám...';
$lang['files.name_label']					= 'Jméno';

$lang['files.dropdown_no_subfolders']		= '-- Nic --';
$lang['files.dropdown_root']				= '-- Kořenový adresář --';

$lang['files.type_a']						= 'Audio';
$lang['files.type_v']						= 'Video';
$lang['files.type_d']						= 'Dokument';
$lang['files.type_i']						= 'Obrázek';
$lang['files.type_o']						= 'Ostatní';

$lang['files.display_grid']					= 'Mřížka';
$lang['files.display_list']					= 'Seznam';

// Messages
$lang['files.create_success']				= 'Soubor byl uložen';
$lang['files.create_error']					= 'Vyskytl se problém.';
$lang['files.edit_success']					= 'Soubor byl uložen.';
$lang['files.edit_error']					= 'Vyskytl se problém při ukládání souboru.';
$lang['files.delete_success']				= 'Soubor byl vymazán.';
$lang['files.delete_error']					= 'Soubor se nepodařilo vymazat.';
$lang['files.mass_delete_success']			= '%d z %d souborů bylo vymazáno, byly to "%s a %s"';
$lang['files.mass_delete_error']			= 'Vyskytl se problém při mazání %d z %d souborů, byly to "%s a %s".';
$lang['files.upload_error']					= 'Musí být nahrán soubor.';
$lang['files.invalid_extension']			= 'Soubor musí mít povolenou příponu.';
$lang['files.not_exists']					= 'Byl zvolen neplatný soubor.';
$lang['files.no_files']						= 'V tuto chvíli tu nejsou žádné soubory.';
$lang['files.no_permissions']				= 'Nemáte oprávnění k modulu souborů.';
$lang['files.no_select_error'] 				= 'Musíte neprve vybrat soubor, požadavek byl přerušen.';

// File folders

// Titles
$lang['file_folders.folders_title']			= 'Složky souborů';
$lang['file_folders.manage_title']			= 'Spravovat složky';
$lang['file_folders.create_title']			= 'Nová složka';
$lang['file_folders.delete_title']			= 'Potvrdit vymazání';
$lang['file_folders.edit_title']			= 'Upravit složku "%s"';

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
$lang['file_folders.create_error']			= 'Vyskytl se problém při vytváření složky.';
$lang['file_folders.duplicate_error']		= 'Složka "%s" již existuje.';
$lang['file_folders.edit_success']			= 'Složka byla uložena.';
$lang['file_folders.edit_error']			= 'Vyskytl se problém při ukládání změn.';
$lang['file_folders.confirm_delete']		= 'Opravdu chcete vymazat tuto složku, včetně obsažených podsložek a souborů?';
$lang['file_folders.delete_mass_success']	= '%d z %d složek bylo vymazáno, byly to "%s a %s"';
$lang['file_folders.delete_mass_error']		= 'Vyskytl se problém při mazání %d z %d složek, byly to "%s a %s".';
$lang['file_folders.delete_success']		= 'Složka "%s" byla vymazána.';
$lang['file_folders.delete_error']			= 'Vyskytl se problém při mazání složky "%s".';
$lang['file_folders.not_exists']			= 'Byla vybrána neplatná složka.';
$lang['file_folders.no_subfolders']			= 'Nic';
$lang['file_folders.no_folders']			= 'Vaše soubory jsou řazeny podle složek, v tuto chvíli nemáte vytvořeny žádné složky.';
$lang['file_folders.mkdir_error']			= 'Nezdařilo se provést příkaz mkdir pro soubory.';
$lang['file_folders.chmod_error']			= 'Nepodařilo se změnit práva ke složkám pomocí příkazu chmod.';

/* End of file files_lang.php */