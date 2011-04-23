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
$lang['files.edit_title']					= 'Edit file "%s"'; #translate

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
$lang['files.loading_label']				= 'Nalagam...'; #translate
$lang['files.name_label']					= 'Name'; #translate

$lang['files.dropdown_no_subfolders']		= '-- Brez --';
$lang['files.dropdown_root']				= '-- Root --';

$lang['files.type_a']						= 'Glasba';
$lang['files.type_v']						= 'Video';
$lang['files.type_d']						= 'Dokument';
$lang['files.type_i']						= 'Slika';
$lang['files.type_o']						= 'Ostalo';

$lang['files.display_grid']					= 'Grid'; #translate
$lang['files.display_list']					= 'List'; #translate

// Messages
$lang['files.create_success']				= 'Datoteka je bila shranjena.';
$lang['files.create_error']					= 'An error as occourred.'; #translate
$lang['files.edit_success']					= 'The file was successfully saved.'; #translate
$lang['files.edit_error']					= 'An error occurred while trying to save the file.'; #translate
$lang['files.delete_success']				= 'Datoteka je bila izbrisana';
$lang['files.delete_error']					= 'Datoteko ni možno izbrisati.';
$lang['files.mass_delete_success']			= '%d of %d files were successfully deleted, they were "%s and %s"'; #translate
$lang['files.mass_delete_error']			= 'An error occurred while trying to delete %d of %d files, they are "%s and %s".'; #translate
$lang['files.upload_error']					= 'Datoteka mora biti naložena.';
$lang['files.invalid_extension']			= 'Datoteka mora imeti končnico.';
$lang['files.not_exists']					= 'Izbrana je bila neveljavna mapa';
$lang['files.no_files']						= 'Trenutno ni datotek.';
$lang['files.no_permissions']				= 'Nimate dovolj dovoljen za ogled tega modula.';
$lang['files.no_select_error'] 				= 'You must select a file first, his request was interrupted.'; #translate

// File folders

// Titles
$lang['file_folders.folders_title']			= 'Mape datotek';
$lang['file_folders.manage_title']			= 'Uredi mape';
$lang['file_folders.create_title']			= 'Nova mapa';
$lang['file_folders.delete_title']			= 'Potrdi izbris';
$lang['file_folders.edit_title']			= 'Edit folder "%s"'; #translate

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
$lang['file_folders.create_error']			= 'An error occurred while attempting to create your folder.'; #translate
$lang['file_folders.duplicate_error']		= 'A folder named "%s" already exists.'; #translate
$lang['file_folders.edit_success']			= 'The folder was successfully saved.'; #translate
$lang['file_folders.edit_error']			= 'An error occurred while trying to save the changes.'; #translate
$lang['file_folders.confirm_delete']		= 'Are you sure you want to delete the folders below, including all files and subfolders inside them?'; #translate
$lang['file_folders.delete_mass_success']	= '%d of %d folders have been successfully deleted, they were "%s and %s.'; #translate
$lang['file_folders.delete_mass_error']		= 'An error occurred while trying to delete %d of %d folders, they are "%s and %s".'; #translate
$lang['file_folders.delete_success']		= 'Mapa "%s" je bila izbrisana';
$lang['file_folders.delete_error']			= 'An error occurred while trying to delete the folder "%s".'; #translate
$lang['file_folders.not_exists']			= 'Izbrana je bila neveljavna mapa.';
$lang['file_folders.no_subfolders']			= 'Brez';
$lang['file_folders.no_folders']			= 'Vaše datoteke so razvrščene po mapah, trenutno nimate usvarjene nobene mape.';
$lang['file_folders.mkdir_error']			= 'Naložitev datotek v mapo ni možno';
$lang['file_folders.chmod_error']			= 'Sprememba lastništva pri naloženih datotekah ni možno';

/* End of file files_lang.php */