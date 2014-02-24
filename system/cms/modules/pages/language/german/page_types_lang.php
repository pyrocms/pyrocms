<?php defined('BASEPATH') or exit('No direct script access allowed');

// tabs
$lang['page_types:html_label']                 = 'HTML';
$lang['page_types:css_label']                  = 'CSS';
$lang['page_types:basic_info']                 = 'Informationen';

// labels
$lang['page_types:updated_label']              = 'Aktualisiert';
$lang['page_types:layout']                     = 'Layout';
$lang['page_types:auto_create_stream']         = 'Neuen Stream für diesen Seitentyp erstellen';
$lang['page_types:select_stream']              = 'Stream';
$lang['page_types:theme_layout_label']         = 'Seitenlayout';
$lang['page_types:save_as_files']              = 'Als Datei speichern';
$lang['page_types:content_label']              = 'Beschriftung des Inhalte-Tabs';
$lang['page_types:title_label']                = 'Beschriftung des Titels';
$lang['page_types:sync_files']                 = 'Dateien synchronisieren';

// titles
$lang['page_types:list_title']                 = 'Seitentypen auflisten';
$lang['page_types:list_title_sing']            = 'Seitentyp';
$lang['page_types:create_title']               = 'Seitentyp hinzuf&uuml;gen';
$lang['page_types:edit_title']                 = 'Seitentyp "%s" bearbeiten';

// messages
$lang['page_types:no_pages']                   = 'Es existieren noch keine Seitentypes.';
$lang['page_types:create_success_add_fields']  = 'Ein neuer Seitentyp wurde erstellt; es k&ouml;nnen nun Felder hinzugef&uuml;gt werden.';
$lang['page_types:create_success']             = 'Seitenlayout wurde erstellt.';
$lang['page_types:success_add_tag']            = 'Das Feld wurde erstellt. Bevor die Daten dieses Feldes angezeigt werden k&ouml;nnen, muss der Tag des Feldes zum Layout des Seitentyps hinzugefügt werden.';
$lang['page_types:create_error']               = 'Ein Fehler ist aufgetreten. Seitenlayout konnte nicht erstellt werden.';
$lang['page_types:page_type.not_found_error']  = 'Seitenlayout existiert nicht.';
$lang['page_types:edit_success']               = 'Seitenlayout "%s" wurde gesichert.';
$lang['page_types:delete_home_error']          = 'Das Standard Seitenlayout kann nicht gel&ouml;scht werden.';
$lang['page_types:delete_success']             = 'Seitenlayout #%s wurde gel&ouml;scht.';
$lang['page_types:mass_delete_success']        = '%s Seitentypes wurden gel&ouml;scht.';
$lang['page_types:delete_none_notice']         = 'Es wurde(n) kein(e) Seitenlayout(s) gel&ouml;scht.';
$lang['page_types:already_exist_error']        = 'Ein Eintrag mit diesem Namen existiert bereits. Bitte gib diesem Seitentyp einen anderen Namen.';
$lang['page_types:_check_pt_slug_msg']         = 'Der Seitentyp-Slug muss einzigartig sein.';

$lang['page_types:variable_introduction']      = 'In dieser Eingabebox stehen zwei Variablen zur Auswahl';
$lang['page_types:variable_title']             = 'Enth&auml;lt den Titel der Seite.';
$lang['page_types:variable_body']              = 'Enth&auml;lt den HTML Inhalt der Seite.';
$lang['page_types:sync_notice']                = 'Es konnten nur %s aus dem Dateisystem synchronisiert werden.';
$lang['page_types:sync_success']               = 'Dateien erfolgreich synchronisiert.';
$lang['page_types:sync_fail']                  = 'Dateien konnten nicht synchronisiert werden.';

// Instructions
$lang['page_types:stream_instructions']        = 'Dieser Stream beinhaltet die Daten des Seitentyps. Du kannst einen Stream ausw&auml;hlen, oder es wird ein neuer Stream angelegt.';
$lang['page_types:saf_instructions']           = 'Wenn du diese Option anw&auml;hlst, wird das Layout dieses Seitentyps als Datei gespeichert.';
$lang['page_types:content_label_instructions'] = 'Dieser Name wird für die Beschriftung des Inhalte-Tab verwendet.';
$lang['page_types:title_label_instructions']   = 'Dieser Name wird anstelle des "Titels" verwendet. Dies ist nütlich für Seitentypen wie "Produkte", wo anstatt eines Titel der "Produktname" angebrachter ist.';

// Misc
$lang['page_types:delete_message']             = 'Bist du sicher, dass du diesen Seitentyp löschen möchtest? Diese Aktion wird <strong>%s</strong> Seiten, all ihre Unterseiten und Stream-Einträge löschen. <strong>Diese Aktion kann nicht rückgängig gemacht werden!</strong>';

$lang['page_types:delete_streams_message']     = 'Diese Aktion löscht auch den <strong>%s Stream</strong> dieses Seitentyps.';
