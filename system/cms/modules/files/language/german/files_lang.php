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
$lang['files.files_title']					= 'Dateien';
$lang['files.upload_title']					= 'Dateien hochladen';
$lang['files.edit_title']					= 'Datei "%s" bearbeiten';

// Labels
$lang['files.download_label']				= 'Download';
$lang['files.upload_label']					= 'Hochladen';
$lang['files.description_label']			= 'Beschreibung';
$lang['files.type_label']					= 'Typ';
$lang['files.file_label']					= 'Datei';
$lang['files.filename_label']				= 'Dateiname';
$lang['files.filter_label']					= 'Filter';
$lang['files.loading_label']				= 'Wird geladen...';
$lang['files.name_label']					= 'Name';

$lang['files.dropdown_select']				= '-- Ordner f&uuml;r Upload w&auml;hlen --';
$lang['files.dropdown_no_subfolders']		= '-- Keines --';
$lang['files.dropdown_root']				= '-- Root --';

$lang['files.type_a']						= 'Audio';
$lang['files.type_v']						= 'Video';
$lang['files.type_d']						= 'Dokument';
$lang['files.type_i']						= 'Bild';
$lang['files.type_o']						= 'Anderer';

$lang['files.display_grid']					= 'Raster';
$lang['files.display_list']					= 'Liste';

// Messages
$lang['files.create_success']				= 'Die Datei wurde gespeichert.';
$lang['files.create_error']					= 'Ein Fehler ist aufgetreten.';
$lang['files.edit_success']					= 'Die Datei wurde erfolgreich gespeichert.';
$lang['files.edit_error']					= 'Beim Speichern der Datei ist ein Fehler aufgetreten.';
$lang['files.delete_success']				= 'Die Datei wurde gel&ouml;scht.';
$lang['files.delete_error']					= 'Die Datei konnte nicht gel&ouml;scht werden.';
$lang['files.mass_delete_success']			= '%d von %d Dateien wurden erfolgreich gel&ouml;scht, sie waren "%s und %s"'; #not sure about the %s in the end, have to see it in action
$lang['files.mass_delete_error']			= 'Beim Versuch %d von %d Dateien zu l&ouml;schen trat ein Fehler auf, sie sind "%s und %s".'; #not sure about the %s in the end, have to see it in action
$lang['files.upload_error']					= 'Eine Datei muss hochgeladen werden.';
$lang['files.invalid_extension']			= 'Die Datei muss eine g&uuml;ltige Dateieendung haben.';
$lang['files.not_exists']					= 'Es wurde ein ung&uuml;ltiges Verzeichnis ausgew&auml;hlt.';
$lang['files.no_files']						= 'Keine Dateien vorhanden.';
$lang['files.no_permissions']				= 'Du hast nicht die n&ouml;tigen Berechtigungen um das Datei Modul zu betrachten.'; 
$lang['files.no_select_error'] 				= 'Es muss eine Datei ausgew&auml;hlt sein, die Anfrage wurde unterbrochen.';

// File folders

// Titles
$lang['file_folders.folders_title']			= 'Verzeichnisse';
$lang['file_folders.manage_title']			= 'Verzeichnisse verwalten';
$lang['file_folders.create_title']			= 'Neues Verzeichnis';
$lang['file_folders.delete_title']			= 'L&ouml;schen best&auml;tigen';
$lang['file_folders.edit_title']			= 'Verzeichnis "%s" bearbeiten';

// Labels
$lang['file_folders.folders_label']			= 'Verzeichnisse';
$lang['file_folders.folder_label']			= 'Verzeichnis';
$lang['file_folders.subfolders_label']		= 'Unterverzeichnisse';
$lang['file_folders.parent_label']			= 'Vorg&auml;nger';
$lang['file_folders.name_label']			= 'Name';
$lang['file_folders.slug_label']			= 'URL Slug';
$lang['file_folders.created_label']			= 'Erstellt am';

// Messages
$lang['file_folders.create_success']		= 'Das Verzeichnis wurde gespeichert.';
$lang['file_folders.create_error']			= 'Beim Erstellen des Verzeichnisses ist ein Fehler aufgetreten.';
$lang['file_folders.duplicate_error']		= 'Ein Verzeichnis mit dem Namen "%s" existiert bereits.';
$lang['file_folders.edit_success']			= 'Das Verzeichnis wurde erfolgreich gespeichert';
$lang['file_folders.edit_error']			= 'Beim Speichern der &Auml;nderungen ist ein Fehler aufgetreten.';
$lang['file_folders.confirm_delete']		= 'Bist du sicher, dass du folgende Verzeichnisse und alle darin befindlichen Dateien und Unterverzeichnisse l&ouml;schen m&ouml;chtest?';
$lang['file_folders.delete_mass_success']	= '%d von %d Verzeichnissen wurden erfolgreich gel&ouml;scht, sie waren "%s und %s.'; #again not sure about the %s in the end
$lang['file_folders.delete_mass_error']		= 'Beim Versuch %d von %d Verzeichnissen zu l&ouml;schen trat ein Fehler auf, sie sind "%s und %s".'; #again not sure about the %s in the end
$lang['file_folders.delete_success']		= 'Das Verzeichnis "%s" wurde gel&ouml;scht.';
$lang['file_folders.delete_error']			= 'Beim L&ouml;schen des Verzeichnisses "%s" trat ein Fehler auf.';
$lang['file_folders.not_exists']			= 'Es wurde kein g&uuml;ltiges Verzeichnis ausgew&auml;hlt.';
$lang['file_folders.no_subfolders']			= 'Keine';
$lang['file_folders.no_folders']			= 'Es existieren aktuell keine Verzeichnisse.';
$lang['file_folders.mkdir_error']			= 'Das Verzeichnis konnte nicht angelegt werden.';
$lang['file_folders.chmod_error']			= 'Das Zugriffsrechte (chmod) des Verzeichnisses konnten nicht ge&auml;ndert werden.';

/* End of file files_lang.php */