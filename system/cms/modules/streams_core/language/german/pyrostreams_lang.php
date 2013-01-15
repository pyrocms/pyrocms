<?php defined('BASEPATH') or exit('No direct script access allowed');

/* Messages */

$lang['streams:save_field_error'] 						= "Beim Speichern des Feldes ist ein Fehler aufgetreten.";
$lang['streams:field_add_success']						= "Feld erfolgreich hinzugefügt.";
$lang['streams:field_update_error']						= "Beim Aktualisieren des Feldes ist ein Fehler aufgetreten.";
$lang['streams:field_update_success']					= "Feld erfolgreich aktualisiert.";
$lang['streams:field_delete_error']						= "Beim Löschen des Feldes ist ein Fehler aufgetreten.";
$lang['streams:field_delete_success']					= "Feld erfolgreich gelöscht.";
$lang['streams:view_options_update_error']				= "Beim Aktualisieren der Anzeigeeinstellungen ist ein Fehler aufgetreten.";
$lang['streams:view_options_update_success']			= "Anzeigeeinstellungen erfolgreich aktualisiert.";
$lang['streams:remove_field_error']						= "Beim Löschen des Feldes ist ein Fehler aufgetreten.";
$lang['streams:remove_field_success']					= "Feld erfolgreich gelöscht.";
$lang['streams:create_stream_error']					= "Beim Erstellen des Streams ist ein Fehler aufgetreten.";
$lang['streams:create_stream_success']					= "Stream erfolgreich erstellt.";
$lang['streams:stream_update_error']					= "Beim Aktualisieren des Streams ist ein Fehler aufgetreten.";
$lang['streams:stream_update_success']					= "Stream erfolgreich aktualisiert.";
$lang['streams:stream_delete_error']					= "Beim Löschen des Streams ist ein Fehler aufgetreten.";
$lang['streams:stream_delete_success']					= "Stream erfolgreich gelöscht.";
$lang['streams:stream_field_ass_add_error']				= "Beim Hinzufügen dieses Feldes zum Stream ist ein Fehler aufgetreten.";
$lang['streams:stream_field_ass_add_success']			= "Das Feld wurde erfolgreich zum Stream hinzugefügt.";
$lang['streams:stream_field_ass_upd_error']				= "Beim Aktualisieren der Feldzuweisung ist ein Fehler aufgetreten.";
$lang['streams:stream_field_ass_upd_success']			= "Feldzuweisung erfolgreich aktualisiert.";
$lang['streams:delete_entry_error']						= "Beim Löschen des Eintrags ist ein Fehler aufgetreten.";
$lang['streams:delete_entry_success']					= "Eintrag erfolgreich gelöscht.";
$lang['streams:new_entry_error']						= "Beim Hinzufügen des Eintrags ist ein Fehler aufgetreten.";
$lang['streams:new_entry_success']						= "Eintrag erfolgreich hinzugefügt.";
$lang['streams:edit_entry_error']						= "Beim Aktualisieren des Eintrags ist ein Fehler aufgetreten.";
$lang['streams:edit_entry_success']					= "Eintrag erfolgreich aktualisiert.";
$lang['streams:delete_summary']							= "Bist du sicher, dass du den Stream <strong>%s</strong> löschen willst? Dadurch werden <strong>%s %s</strong> permanent gelöscht.";

/* Misc Errors */

$lang['streams:no_stream_provided']						= "Es wurde kein Stream ausgewählt.";
$lang['streams:invalid_stream']							= "Ungültiger Stream.";
$lang['streams:not_valid_stream']						= "ist kein gültiger Stream.";
$lang['streams:invalid_stream_id']						= "Ungültige Stream ID.";
$lang['streams:invalid_row']							= "Ungültige Reihe.";
$lang['streams:invalid_id']								= "Ungültige ID.";
$lang['streams:cannot_find_assign']						= "Konnte die Feldzugehörigkeit nicht finden.";
$lang['streams:cannot_find_pyrostreams']				= "Konnte PyroStreams nicht finden.";
$lang['streams:table_exists']							= "Eine Tabelle mit dem Slug %s existiert bereits.";
$lang['streams:no_results']								= "Keine Ergebnisse";
$lang['streams:no_entry']								= "Es konnten keine Einträge gefunden werden.";
$lang['streams:invalid_search_type']					= "ist kein gültiger Suchtyp.";
$lang['streams:search_not_found']						= "Suche nicht gefunden.";

/* Validation Messages */

$lang['streams:field_slug_not_unique']					= "Dieser Feldslug wird bereits verwendet.";
$lang['streams:not_mysql_safe_word']					= "Das %s Feld ist ein MySQL reserviertes Wort.";
$lang['streams:not_mysql_safe_characters']				= "Das %s Feld enthält unerlaubte Zeichen.";
$lang['streams:type_not_valid']							= "Bitte wähle einen gültigen Feldtypen.";
$lang['streams:stream_slug_not_unique']					= "Dieser Streamslug wird bereits verwendet.";
$lang['streams:field_unique']							= "Das %s Feld muss eindeutig sein.";
$lang['streams:field_is_required']						= "Das %s Feld ist erforderlich.";
$lang['streams:date_out_or_range']						= "Das gewählte Datum liegt ausserhalb des akzeptierten Bereiches.";

/* Field Labels */

$lang['streams:label.field']							= "Feld";
$lang['streams:label.field_required']					= "Feld ist erforderlich";
$lang['streams:label.field_unique']						= "Feld ist eindeutig";
$lang['streams:label.field_instructions']				= "Feldbeschreibungen";
$lang['streams:label.make_field_title_column']			= "Mache dieses Feld zur Titelspalte";
$lang['streams:label.field_name']						= "Feldname";
$lang['streams:label.field_slug']						= "Feldslug";
$lang['streams:label.field_type']						= "Feldtyp";
$lang['streams:id']										= "ID";
$lang['streams:created_by']								= "Erstellt von";
$lang['streams:created_date']							= "Erstellungdatum";
$lang['streams:updated_date']							= "Aktualisierungsdatum";
$lang['streams:value']									= "Wert";
$lang['streams:manage']									= "Verwalten";
$lang['streams:search']									= "Suche";
$lang['streams:stream_prefix']							= "Stream Präfix";

/* Field Instructions */

$lang['streams:instr.field_instructions']				= "Wird im Formular zum Erfassen oder Editieren von Daten angezeigt.";
$lang['streams:instr.stream_full_name']					= "Vollständiger Name für den Stream.";
$lang['streams:instr.slug']								= "Kleingeschrieben, nur Buchstaben und Unterstriche.";

/* Titles */

$lang['streams:assign_field']							= "Feld einem Stream zuordnen";
$lang['streams:edit_assign']							= "Streamzugehörigkeit bearbeiten";
$lang['streams:add_field']								= "Feld erstellen";
$lang['streams:edit_field']								= "Feld bearbeiten";
$lang['streams:fields']									= "Felder";
$lang['streams:streams']								= "Streams";
$lang['streams:list_fields']							= "Felder auflisten";
$lang['streams:new_entry']								= "Neuer Eintrag";
$lang['streams:stream_entries']							= "Streameinträge";
$lang['streams:entries']								= "Einträge";
$lang['streams:stream_admin']							= "Stream Admin";
$lang['streams:list_streams']							= "Streams auflisten";
$lang['streams:sure']									= "Bist du sicher?";
$lang['streams:field_assignments'] 						= "Stream Feldzuweisungen";
$lang['streams:new_field_assign']						= "Neue Feldzuweisung";
$lang['streams:stream_name']							= "Streamname";
$lang['streams:stream_slug']							= "Streamslug";
$lang['streams:about']									= "Über";
$lang['streams:total_entries']							= "Total Einträge";
$lang['streams:add_stream']								= "Neuer Stream";
$lang['streams:edit_stream']							= "Stream bearbeiten";
$lang['streams:about_stream']							= "Über diesen Stream";
$lang['streams:title_column']							= "Titelspalte";
$lang['streams:sort_method']							= "Sortiermethode";
$lang['streams:add_entry']								= "Eintrag hinzufügen";
$lang['streams:edit_entry']								= "Eintrag bearbeiten";
$lang['streams:view_options']							= "Anzeigeeinstellungen";
$lang['streams:stream_view_options']					= "Stream Anzeigeeinstellugen";
$lang['streams:backup_table']							= "Streamtabelle sichern";
$lang['streams:delete_stream']							= "Stream löschen";
$lang['streams:entry']									= "Eintrag";
$lang['streams:field_types']							= "Feldtypen";
$lang['streams:field_type']								= "Feldtyp";
$lang['streams:database_table']							= "Datenbanktabelle";
$lang['streams:size']									= "Grösse";
$lang['streams:num_of_entries']							= "Anzahl Einträge";
$lang['streams:num_of_fields']							= "Anzahl Felder";
$lang['streams:last_updated']							= "Zuletzt aktualisiert";
$lang['streams:export_schema']							= "Schema exportieren";

/* Startup */

$lang['streams:start.add_one']							= "eines hinzufügen";
$lang['streams:start.no_fields']						= "Du hast noch keine Felder erstellt. Um zu starten, kannst du";
$lang['streams:start.no_assign'] 						= "Es scheint, als hätte dieser Stream noch keine Felder. Um zu starten, kannst du";
$lang['streams:start.add_field_here']					= "hier ein Feld hinzufügen";
$lang['streams:start.create_field_here']				= "hier ein Feld erstellen";
$lang['streams:start.no_streams']						= "Du hast noch keine Streams, aber du kannst damit beginnen indem du";
$lang['streams:start.no_streams_yet']					= "Bisher sind keine Streams vorhanden.";
$lang['streams:start.adding_one']						= "einen hinzufügst";
$lang['streams:start.no_fields_to_add']					= "Keine Felder zum Hinzufügen";
$lang['streams:start.no_fields_msg']					= "Es gibt keine Felder, welche zu diesem Stream hinzugefügt werden müssen. In PyroStreams können Feldtypen zwischen verschiedenen Streams ausgetauscht werden und müssen deshalb vor dem Hinzufügen zu einem Stream erstellt werden. Um zu starten, kannst du";
$lang['streams:start.adding_a_field_here']				= "hier ein Feld hinzufügen";
$lang['streams:start.no_entries']						= "Zur Zeit gibt es noch keine Einträge im Stream '<strong>%s</strong>'. Um zu starten, kannst du diesem Stream";
$lang['streams:add_fields']								= "Felder zuweisen";
$lang['streams:no_entries']								= 'No entries'; #translate
$lang['streams:add_an_entry']							= "hier einen Eintrag erstellen";
$lang['streams:to_this_stream_or']						= "oder";
$lang['streams:no_field_assign']						= "Keine Feldzuweisungen";
$lang['streams:no_fields_msg_first']					= "Es gibt noch keine Felder für diese Stream.";
$lang['streams:no_field_assign_msg']					= "Es scheint, als hätte dieser Stream noch keine Felder. Bevor du Daten erfassen kannst, musst du";
$lang['streams:add_some_fields']						= "einige Felder zuweisen";
$lang['streams:start.before_assign']					= "Bevor du einem Stream Felder zuweisen kannst, musst du diese Erstellen. Du kannst";
$lang['streams:start.no_fields_to_assign']				= "Es scheint, als wären keine Felder zuweisbar. Bevor du ein Feld zuweisen kannst, musst du ";

/* Buttons */

$lang['streams:yes_delete']						= "Ja, löschen";
$lang['streams:no_thanks']						= "Nein danke";
$lang['streams:new_field']						= "Neues Feld";
$lang['streams:edit']									= "Bearbeiten";
$lang['streams:delete']								= "Löschen";
$lang['streams:remove']								= "Entfernen";
$lang['streams:reset']								= "Zurücksetzen";

/* Misc */

$lang['streams:field_singular']						= "Feld";
$lang['streams:field_plural']							= "Felder";
$lang['streams:by_title_column']					= "Nach Titelspalte";
$lang['streams:manual_order']							= "Manuelle Sortierreihenfolge";
$lang['streams:stream_data_line']					= "Grundlegende Streamdaten bearbeiten.";
$lang['streams:view_options_line'] 				= "Wähle welche Spalten in der Datenliste angezeigt werden sollen.";
$lang['streams:backup_line']							= "Streamtabelle sichern und als ZIP herunterladen.";
$lang['streams:permanent_delete_line']		= "Einen Stream und dessen Inhalt permanent löschen.";
$lang['streams:choose_a_field_type']			= "Wählen Sie einen Feldtypen";
$lang['streams:choose_a_field']						= "Wählen Sie ein Feld";

/* reCAPTCHA */

$lang['recaptcha_class_initialized'] 					= "reCaptcha Bibliothek initialisiert";
$lang['recaptcha_no_private_key']						= "Du hast keinen API Schlüssel für Recaptcha definiert";
$lang['recaptcha_no_remoteip'] 							= "Aus Sicherheitsgründen muss reCAPTCHA die IP-Adresse angegeben werden.";
$lang['recaptcha_socket_fail'] 							= "Socket konnte nicht geöffnet werden";
$lang['recaptcha_incorrect_response'] 			= "Falsche Eingabe zum Sicherheitsbild";
$lang['recaptcha_field_name'] 							= "Sicherheitsbild";
$lang['recaptcha_html_error'] 							= "Fehler beim Laden des Sicherheitsbildes.  Bitte versuche es später noch einmal";

/* Default Parameter Fields */

$lang['streams:max_length'] 							= "Maximallänge";
$lang['streams:upload_location'] 					= "Uploadverzeichnis";
$lang['streams:default_value'] 						= "Standardwert";

$lang['streams:menu_path']								= 'Menu Path'; #translate
$lang['streams:about_instructions']						= 'A short description of your stream.'; #translate
$lang['streams:slug_instructions']						= 'This will also be the database table name for your stream.'; #translate
$lang['streams:prefix_instructions']					= 'If used, this will prefix the table in the database. Useful for naming collisons.'; #translate
$lang['streams:menu_path_instructions']					= 'Where you what section and sub section this stream should show up in the menu. Separate by a forward slash. Ex: <strong>Main Section / Sub Section</strong>.'; #translate

/* End of file pyrostreams_lang.php */