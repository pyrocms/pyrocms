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
$lang['files.edit_title']					= 'Bewerk bestand "%s"';

// Labels
$lang['files.actions_label']				= 'Actie';
$lang['files.download_label']				= 'Download';
$lang['files.edit_label']					= 'Wijzig';
$lang['files.delete_label']					= 'Verwijderen';
$lang['files.upload_label']					= 'Upload';
$lang['files.description_label']			= 'Beschrijving';
$lang['files.type_label']					= 'Type';
$lang['files.file_label']					= 'Bestand';
$lang['files.filename_label']				= 'Bestandsnaam';
$lang['files.filter_label']					= 'Filter';
$lang['files.loading_label']				= 'Laden...'; 
$lang['files.name_label']					= 'Naam';

$lang['files.dropdown_no_subfolders']		= '-- Geen --';
$lang['files.dropdown_root']				= '-- Root --';

$lang['files.type_a']						= 'Audio';
$lang['files.type_v']						= 'Video';
$lang['files.type_d']						= 'Document';
$lang['files.type_i']						= 'Afbeelding';
$lang['files.type_o']						= 'Anders';

$lang['files.display_grid']					= 'Rooster';
$lang['files.display_list']					= 'Lijst';

// Messages
$lang['files.create_success']				= 'Het bestand is nu opgeslagen.';
$lang['files.create_error']					= 'Een fout is opgetreden.';
$lang['files.edit_success']					= 'Het bestand is opgeslagen.';
$lang['files.edit_error']					= 'Er is een fout opgetreden bij het opslaan van het ​​bestand.';
$lang['files.delete_success']				= 'Het bestand is verwijderd.';
$lang['files.delete_error']					= 'Het bestand kon niet worden verwijderd.';
$lang['files.mass_delete_success']			= '%d van de %d  bestanden werden met succes verwijderd, ze waren "%s en %s"';
$lang['files.mass_delete_error']			= 'Er is een fout opgetreden bij het verwijderen van %d van de %d bestanden, ze waren "%s en %s".';
$lang['files.upload_error']					= 'Een bestand moet worden geüpload.';
$lang['files.invalid_extension']			= 'Bestand moet een geldige extensie hebben.';
$lang['files.not_exists']					= 'Een ongeldige folder is geselecteerd.';
$lang['files.no_files']						= 'Er zijn momenteel geen bestanden.';
$lang['files.no_permissions']				= 'Je hebt geen rechten om de bestanden-module te zien.';
$lang['files.no_select_error'] 				= 'Je moet eerst een bestand selecteren, het verzoek is onderbroken.';

// File folders

// Titles
$lang['file_folders.folders_title']			= 'Bestand folders';
$lang['file_folders.manage_title']			= 'Beheer folders';
$lang['file_folders.create_title']			= 'Nieuwe Folder';
$lang['file_folders.delete_title']			= 'Bevestig Verwijderen';
$lang['file_folders.edit_title']			= 'Bewerk folder "%s"';

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
$lang['file_folders.create_error']			= 'Een fout is opgetreden tijdens een poging om je map te maken.';
$lang['file_folders.duplicate_error']		= 'A folder named "%s" already exists.'; #translate
$lang['file_folders.edit_success']			= 'De map is opgeslagen.';
$lang['file_folders.edit_error']			= 'Er is een fout opgetreden tijdens het proberen om de wijzigingen op te slaan.';
$lang['file_folders.confirm_delete']		= 'Weet u zeker dat u de mappen hieronder wilt verwijderen, inclusief alle bestanden en submappen erin?';
$lang['file_folders.delete_mass_success']	= '%d van de %d mappen zijn verwijderd ze waren "%s en %s.';
$lang['file_folders.delete_mass_error']		= 'Er is een fout opgetreden bij het verwijderen van %d van de %d mappen, ze zijn "%s en %s".';
$lang['file_folders.delete_success']		= 'De map"%s" is verwijderd.';
$lang['file_folders.delete_error']			= 'Er is een fout opgetreden tijdens het proberen om de map "%s" te verwijderen.';
$lang['file_folders.not_exists']			= 'Een ongeldige folder is geselecteerd.';
$lang['file_folders.no_subfolders']			= 'Geen';
$lang['file_folders.no_folders']			= 'Er zijn momenteel geen folders.';
$lang['file_folders.mkdir_error']			= 'Kon geen upload/bestand map aanmaken';
$lang['file_folders.chmod_error']			= 'Kon niet chmod op de upload/bestand map toepassen';

/* End of file files_lang.php */