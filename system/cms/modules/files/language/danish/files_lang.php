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
 * @since		Version 1.4
 * @filesource
 */

// Files

// Titles
$lang['files.files_title']					= 'Filer';
$lang['files.upload_title']					= 'Upload filer';
$lang['files.edit_title']					= 'Redigér filen "%s"';

// Labels
$lang['files.download_label']				= 'Download';
$lang['files.upload_label']					= 'Upload';
$lang['files.description_label']			= 'Beskrivelse';
$lang['files.type_label']					= 'Type';
$lang['files.file_label']					= 'Fil';
$lang['files.filename_label']				= 'Filnavn';
$lang['files.filter_label']					= 'Filter';
$lang['files.loading_label']				= 'Indlæser...';
$lang['files.name_label']					= 'Navn';

$lang['files.dropdown_no_subfolders']		= '-- Ingen --';
$lang['files.dropdown_root']				= '-- Root --';

$lang['files.type_a']						= 'Lyd';
$lang['files.type_v']						= 'Video';
$lang['files.type_d']						= 'Dokument';
$lang['files.type_i']						= 'Billede';
$lang['files.type_o']						= 'Andet';

$lang['files.display_grid']					= 'Gitter';
$lang['files.display_list']					= 'List';

// Messages
$lang['files.create_success']				= 'Filen er nu gemt.';
$lang['files.create_error']					= 'Der opstod en fejl.';
$lang['files.edit_success']					= 'Filen er gemt.';
$lang['files.edit_error']					= 'Der opstod en fejl, da filen skulle gemmes .';
$lang['files.delete_success']				= 'Filen er slettet.';
$lang['files.delete_error']					= 'Filen kunne ikke slettes.';
$lang['files.mass_delete_success']			= '%d af %d filer er slettet. De er "%s og %s"';
$lang['files.mass_delete_error']			= 'Der opstod en fejl ved sletningen af %d af %d filer. De er "%s og %s".';
$lang['files.upload_error']					= 'En fil skal uploades.';
$lang['files.invalid_extension']			= 'File must have a valid extension.';
$lang['files.not_exists']					= 'En ugyldig mappe er valgt.';
$lang['files.no_files']						= 'Der er ingen filer i øjeblikket.';
$lang['files.no_permissions']				= 'Du har ikke adgang til at se filmodulerne.';
$lang['files.no_select_error'] 				= 'Du skal vælge en fil først, hans anmodning blev afbrudt.';

// File folders

// Titles
$lang['file_folders.folders_title']			= 'Filmapper';
$lang['file_folders.manage_title']			= 'Administrér mapper';
$lang['file_folders.create_title']			= 'Ny mappe';
$lang['file_folders.delete_title']			= 'Bekræft sletning';
$lang['file_folders.edit_title']			= 'Redigér mappe "%s"';

// Labels
$lang['file_folders.folders_label']			= 'Mapper';
$lang['file_folders.folder_label']			= 'Mappe';
$lang['file_folders.subfolders_label']		= 'Undermapper';
$lang['file_folders.parent_label']			= 'Parent';
$lang['file_folders.name_label']			= 'Navn';
$lang['file_folders.slug_label']			= 'URL Slug';
$lang['file_folders.created_label']			= 'Oprettet d.';

// Messages
$lang['file_folders.create_success']		= 'Mappen er nu gemt.';
$lang['file_folders.create_error']			= 'Der opstod en fejl, da mappen skulle oprettes.';
$lang['file_folders.duplicate_error']		= 'En mappe med navnet "%s" findes allerede.';
$lang['file_folders.edit_success']			= 'Mappen blev gemt.';
$lang['file_folders.edit_error']			= 'Der opstod en fejl da ændringerne skulle gemmes.';
$lang['file_folders.confirm_delete']		= 'Er du sikker på, at du vil slette alle nedenstående mapper, inclusiv alle filer og undermappe i dem?';
$lang['file_folders.delete_mass_success']	= '%d af %d mapper er slettet. Det er "%s og %s.';
$lang['file_folders.delete_mass_error']		= 'Der opstod en fejl i sletningen af %d af %d mapper. De er "%s og %s".';
$lang['file_folders.delete_success']		= 'Mappen "%s" er slettet.';
$lang['file_folders.delete_error']			= 'Der opstod en fejl ved sletningen af mappen "%s".';
$lang['file_folders.not_exists']			= 'En ugyldig mappe er valgt.';
$lang['file_folders.no_subfolders']			= 'Ingen';
$lang['file_folders.no_folders']			= 'Dine filer er sorteret i mapper. Du har ingen mappeindstillinger.';
$lang['file_folders.mkdir_error']			= 'Kunne ikke oprette uploads/fil mappen';
$lang['file_folders.chmod_error']			= 'kunne ikke chmod uploads/files mappen';

/* End of file files_lang.php */