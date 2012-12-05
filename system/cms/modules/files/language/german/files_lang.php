<?php defined('BASEPATH') OR exit('No direct script access allowed');

// General
$lang['files:files_title']					= 'Dateien';
$lang['files:fetching']						= 'Empfange Daten...';
$lang['files:fetch_completed']				= 'Fertig';
$lang['files:save_failed']					= 'Die Änderungen konnten nicht gespeichert werden';
$lang['files:item_created']					= '"%s" wurde erstellt';
$lang['files:item_updated']					= '"%s" wurde aktualisiert';
$lang['files:item_deleted']					= '"%s" wurde gelöscht';
$lang['files:item_not_deleted']				= '"%s" konnte nicht gelöscht werden';
$lang['files:item_not_found']				= '"%s" konnte nicht gefunden werden';
$lang['files:sort_saved']					= 'Sortierung gespeichert';
$lang['files:no_permissions']				= 'Sie haben nicht genügend Berechtigung.';

// Labels
$lang['files:activity']						= 'Aktivität';
$lang['files:places']						= 'Verzeichnis';
$lang['files:back']							= 'Zurück';
$lang['files:forward']						= 'Vorwärts';
$lang['files:start']						= 'Upload starten';
$lang['files:details']						= 'Details';
$lang['files:id']							= 'ID';
$lang['files:name']							= 'Name';
$lang['files:slug']							= 'Slug';
$lang['files:path']							= 'Pfad';
$lang['files:added']						= 'Hinzugefügt am';
$lang['files:width']						= 'Breite';
$lang['files:height']						= 'Höhe';
$lang['files:ratio']						= 'Verhältnis';
$lang['files:alt_attribute']				= 'Alt Attribut';
$lang['files:full_size']					= 'Volle Grösse';
$lang['files:filename']						= 'Dateiname';
$lang['files:filesize']						= 'Dateigrösse';
$lang['files:download_count']				= 'Anzahl Downloads';
$lang['files:download']						= 'Herunterladen';
$lang['files:location']						= 'Speicher';
$lang['files:keywords']						= 'Keywords';
$lang['files:toggle_data_display']			= 'Detailanzeige wechseln';
$lang['files:description']					= 'Beschreibung';
$lang['files:container']					= 'Container';
$lang['files:bucket']						= 'Bucket';
$lang['files:check_container']				= 'Gültigkeit überprüfen';
$lang['files:search_message']				= 'Eingeben und Enter drücken';
$lang['files:search']						= 'Suchen';
$lang['files:synchronize']					= 'Synchronisieren';
$lang['files:uploader']						= 'Dateien hier ablegen <br />oder<br />Klicken um Dateien auszuwählen';
$lang['files:replace_file']					= 'Datei ersetzen';

// Context Menu
$lang['files:refresh']						= 'Aktualisieren';
$lang['files:open']							= 'Öffnen';
$lang['files:new_folder']					= 'Neuer Ordner';
$lang['files:upload']						= 'Upload';
$lang['files:rename']						= 'Umbenennen';
$lang['files:replace']						= 'Ersetzen';
$lang['files:delete']						= 'Löschen';
$lang['files:edit']							= 'Bearbeiten';
$lang['files:details']						= 'Details';

// Folders

$lang['files:no_folders']					= 'Dateien und Ordner werden ähnlich wie auf einem Desktop verwaltet. Mit einem Rechtsklick in den Teil unterhalb dieser Nachricht, können Sie Ihren ersten Ordner erstellen. Danach können Sie mit einem Rechtsklick auf diesen Ordner das Kontextmenü öffnen und den Ordner umbenennen, löschen, Dateien darin hochladen oder weitere Details wie die Zugehörigkeit zu einem Cloud-Speicher anpassen.';
$lang['files:no_folders_places']			= 'Erstellte Ordner werden hier in einer Baumstruktur, die erweitert oder zugeklappt werden kann. Klicken Sie auf on "Ort" um das Root-Ordner anzuzeigen.';
$lang['files:no_folders_wysiwyg']			= 'Bisher wurden keine Ordner erstellt.';
$lang['files:new_folder_name']				= 'Unbenannter Ordner';
$lang['files:folder']						= 'Ordner';
$lang['files:folders']						= 'Ordner';
$lang['files:select_folder']				= 'Ordner auswählen';
$lang['files:subfolders']					= 'Unterordner';
$lang['files:root']							= 'Root';
$lang['files:no_subfolders']				= 'Keine Unterordner';
$lang['files:folder_not_empty']				= 'Sie müssen zuerst den Inhalt von "%s" löschen';
$lang['files:mkdir_error']					= '%s kann nicht erstellt werden. Sie müssen diesen Ordner manuell erstellen';
$lang['files:chmod_error']					= 'Der Upload-Ordner ist nicht beschreibbar. Er muss auf 0777 gesetzt sein';
$lang['files:location_saved']				= 'Der Ordner Speicher wurde gespeichert';
$lang['files:container_exists']				= '"%s" existiert. Speichern Sie um den Inhalt mit diesem Ordner zu verknüpfen';
$lang['files:container_not_exists']			= '"%s" existiert nicht in Ihrem Konto. Speichern Sie und es wird versucht ihn zu erstellen';
$lang['files:error_container']				= '"%s" konnte aus unbekannten Gründen nicht erstellt werden';
$lang['files:container_created']			= '"%s" wurde erstellt und ist nun mit diesem Ordner verknüpft';
$lang['files:unwritable']					= '"%s" ist nicht beschreibbar, bitte setzen Sie die Berechtigung auf 0777';
$lang['files:specify_valid_folder']			= 'Sie müssen einen gültigen Ordner angeben, um die Datei hochzuladen';
$lang['files:enable_cdn']					= 'Sie müssen CDN für "%s" in Ihrem Rackspace Control Panel aktivieren bevor synchronisiert werden kann';
$lang['files:synchronization_started']		= 'Synchronisation wird gestartet';
$lang['files:synchronization_complete']		= 'Synchronisation für "%s" wurde beendet';
$lang['files:untitled_folder']				= 'Unbenannter Ordner';

// Files
$lang['files:no_files']						= 'Keine Dateien gefunden';
$lang['files:file_uploaded']				= '"%s" wurde hochgeladen';
$lang['files:unsuccessful_fetch']			= '"%s" konnte nicht abgerufen werden. Sind Sie sicher dass dies eine öffentliche Datei ist?';
$lang['files:invalid_container']			= '"%s" scheint kein gültiger Container zu sein.';
$lang['files:no_records_found']				= 'Es konnten keine Einträge gefunden werden';
$lang['files:invalid_extension']			= '"%s" hat eine nicht erlaubte Dateiendung';
$lang['files:upload_error']					= 'Der Datei-Upload ist fehlgeschlagen';
$lang['files:description_saved']			= 'Die Datei-Details wurden gespeichert';
$lang['files:file_moved']					= '"%s" wurde erfolgreich verschoben';
$lang['files:exceeds_server_setting']		= 'Der Server kann eine Datei mit dieser Grösse nicht verarbeiten';
$lang['files:exceeds_allowed']				= 'Die Datei überschreitet die maximal erlaubte Grösse';
$lang['files:file_type_not_allowed']		= 'Dieser Dateityp ist nicht erlaubt';
$lang['files:replace_warning']				= 'Achtung: Ersetzen Sie die Datei nicht mit einer Datei mit einer anderen Endung (z. B. .jpg mit .png)';
$lang['files:type_a']						= 'Audio';
$lang['files:type_v']						= 'Video';
$lang['files:type_d']						= 'Dokument';
$lang['files:type_i']						= 'Bild';
$lang['files:type_o']						= 'Anderes';

/* End of file files_lang.php */