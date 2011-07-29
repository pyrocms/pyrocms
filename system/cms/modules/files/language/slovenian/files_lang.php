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
 * @translation IMAMO, Danijel Ocepek s.p.
 * @filesource
 */

// Files

// Titles
$lang['files.files_title']					= 'Datoteke';
$lang['files.upload_title']					= 'Naloži datoteke';
$lang['files.edit_title']					= 'Uredi datoteko "%s"';

// Labels
$lang['files.actions_label']				= 'Akcija';
$lang['files.download_label']				= 'Prenosi na računalnik';
$lang['files.edit_label']					= 'Uredi';
$lang['files.delete_label']					= 'Izbriši';
$lang['files.upload_label']					= 'Naloži';
$lang['files.description_label']			= 'Opis';
$lang['files.type_label']					= 'Tip';
$lang['files.file_label']					= 'Datoteka';
$lang['files.filename_label']				= 'Naziv datoteke';
$lang['files.filter_label']					= 'Razvrstitev';
$lang['files.loading_label']				= 'Nalagam...';
$lang['files.name_label']					= 'Ime';

$lang['files.dropdown_no_subfolders']		= '-- Brez --';
$lang['files.dropdown_root']				= '-- Root --';

$lang['files.type_a']						= 'Glasba';
$lang['files.type_v']						= 'Video';
$lang['files.type_d']						= 'Dokument';
$lang['files.type_i']						= 'Slika';
$lang['files.type_o']						= 'Ostalo';

$lang['files.display_grid']					= 'Mreža';
$lang['files.display_list']					= 'Seznam';

// Messages
$lang['files.create_success']				= 'Datoteka je bila shranjena.';
$lang['files.create_error']					= 'Prišlo je do napake.';
$lang['files.edit_success']					= 'Datoteka je bila uspešno shranjena';
$lang['files.edit_error']					= 'Prišlo je do napake pri shranjevanju datoteke';
$lang['files.delete_success']				= 'Datoteka je bila izbrisana';
$lang['files.delete_error']					= 'Datoteko ni možno izbrisati.';
$lang['files.mass_delete_success']			= '%d od %d datotek je bilo uspešno odstranjenih, bile so od "%s in %s"';
$lang['files.mass_delete_error']			= 'Prišlo je do napake med poizkusom izbrisa %d od %d datotek, v "%s in %s".';
$lang['files.upload_error']					= 'Datoteka mora biti naložena.';
$lang['files.invalid_extension']			= 'Datoteka mora imeti končnico.';
$lang['files.not_exists']					= 'Izbrana je bila neveljavna mapa';
$lang['files.no_files']						= 'Trenutno ni datotek.';
$lang['files.no_permissions']				= 'Nimate dovolj dovoljen za ogled tega modula.';
$lang['files.no_select_error'] 				= 'Najprej morate izbrati datoteko, zahteva je bila prekinjena';

// File folders

// Titles
$lang['file_folders.folders_title']			= 'Mape datotek';
$lang['file_folders.manage_title']			= 'Uredi mape';
$lang['file_folders.create_title']			= 'Nova mapa';
$lang['file_folders.delete_title']			= 'Potrdi izbris';
$lang['file_folders.edit_title']			= 'Uredi mapo "%s"';

// Labels
$lang['file_folders.folders_label']			= 'Mape';
$lang['file_folders.folder_label']			= 'Mapa';
$lang['file_folders.subfolders_label']		= 'Pod-Mapa';
$lang['file_folders.parent_label']			= 'Starš';
$lang['file_folders.name_label']			= 'Naziv';
$lang['file_folders.slug_label']			= 'URL pot';
$lang['file_folders.created_label']			= 'Ustvarjeno';

// Messages
$lang['file_folders.create_success']		= 'Mapa je bila shranjena.';
$lang['file_folders.duplicate_error']		= 'Mapa z imenom "%s" že obstaja.';
$lang['file_folders.create_error']			= 'Prišlo je do napake pri ustvarjanju vaše mape.';
$lang['file_folders.edit_success']			= 'Mapa je bila uspešno shranjena';
$lang['file_folders.edit_error']			= 'Prišlo je do napake pri shranjevanju sprememb.';
$lang['file_folders.confirm_delete']		= 'Ali ste prepričani da želite odstraniti spodnje mape, skupaj s vsemi datotekam in podmapami v njih?';
$lang['file_folders.delete_mass_success']	= '%d od %d map je bilo uspešno odstranjenih v "%s in %s.';
$lang['file_folders.delete_mass_error']		= 'Prišlo je do napake pri izbrisu  %d od %d map v "%s in %s".';
$lang['file_folders.delete_success']		= 'Mapa "%s" je bila izbrisana';
$lang['file_folders.delete_error']			= 'Prišlo je do napake pri poizkusu izbrisa mape "%s".';
$lang['file_folders.not_exists']			= 'Izbrana je bila neveljavna mapa.';
$lang['file_folders.no_subfolders']			= 'Brez';
$lang['file_folders.no_folders']			= 'Vaše datoteke so razvrščene po mapah, trenutno nimate usvarjene nobene mape.';
$lang['file_folders.mkdir_error']			= 'Naložitev datotek v mapo ni možno';
$lang['file_folders.chmod_error']			= 'Sprememba lastništva pri naloženih datotekah ni možno';

/* End of file files_lang.php */