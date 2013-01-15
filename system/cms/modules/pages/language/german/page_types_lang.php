<?php defined('BASEPATH') or exit('No direct script access allowed');

// tabs
$lang['page_types:html_label']                 = 'HTML';
$lang['page_types:css_label']                  = 'CSS';
$lang['page_types:basic_info']                 = 'Basic Info'; #translate

// labels
$lang['page_types:updated_label']              = 'Aktualisiert';
$lang['page_types:layout']                     = 'Layout'; #translate
$lang['page_types:auto_create_stream']         = 'Create New Stream for this Page Type'; #translate
$lang['page_types:select_stream']              = 'Stream'; #translate
$lang['page_types:theme_layout_label']         = 'Seitenlayout';
$lang['page_types:save_as_files']              = 'Save as Files'; #translate
$lang['page_types:content_label']              = 'Content Tab Label'; #translate
$lang['page_types:title_label']                = 'Title Label'; #translate
$lang['page_types:sync_files']                 = 'Sync Files'; #translate

// titles
$lang['page_types:list_title']                 = 'Seitentypes auflisten';
$lang['page_types:list_title_sing']            = 'Page Type'; #translate
$lang['page_types:create_title']               = 'Seitenlayout hinzuf&uuml;gen';
$lang['page_types:edit_title']                 = 'Seitenlayout "%s" bearbeiten';

// messages
$lang['page_types:no_pages']                   = 'Es existieren noch keine Seitentypes.';
$lang['page_types:create_success_add_fields']  = 'You have created a new page type; now add the fields that you want your page to have.'; #translate
$lang['page_types:create_success']             = 'Seitenlayout wurde erstellt.';
$lang['page_types:success_add_tag']            = 'The page field has been added. However before its data will be output you must insert its tag into the Page Type\'s Layout textarea'; #translate
$lang['page_types:create_error']               = 'Ein Fehler ist aufgetreten. Seitenlayout konnte nicht erstellt werden.';
$lang['page_types:page_type.not_found_error']  = 'Seitenlayout existiert nicht.';
$lang['page_types:edit_success']               = 'Seitenlayout "%s" wurde gesichert.';
$lang['page_types:delete_home_error']          = 'Das Standard Seitenlayout kann nicht gel&ouml;scht werden.';
$lang['page_types:delete_success']             = 'Seitenlayout #%s wurde gel&ouml;scht.';
$lang['page_types:mass_delete_success']        = '%s Seitentypes wurden gel&ouml;scht.';
$lang['page_types:delete_none_notice']         = 'Es wurde(n) kein(e) Seitenlayout(s) gel&ouml;scht.';
$lang['page_types:already_exist_error']        = 'A table with that name already exists. Please choose a different name for this page type.'; #translate# slug = title?
$lang['page_types:_check_pt_slug_msg']         = 'Your page type slug must be unique.'; #translate

$lang['page_types:variable_introduction']      = 'In dieser Eingabebox stehen zwei Variablen zur Auswahl';
$lang['page_types:variable_title']             = 'Enth&auml;lt den Titel der Seite.';
$lang['page_types:variable_body']              = 'Enth&auml;lt den HTML Inhalt der Seite.';
$lang['page_types:sync_notice']                = 'Only able to sync %s from the file system.'; #translate
$lang['page_types:sync_success']               = 'Files synced successfully.'; #translate
$lang['page_types:sync_fail']                  = 'Unable to sync your files.'; #translate

// Instructions
$lang['page_types:stream_instructions']        = 'This stream will hold the custom fields for your page type. You can choose a new stream, or one will be created for you.'; #translate
$lang['page_types:saf_instructions']           = 'Checking this will save your page layout file, as well as any custom CSS and JS as flat files in your assets/page_types folder.'; #translate
$lang['page_types:content_label_instructions'] = 'This renames the tab that holds your page type stream fields.'; #translate
$lang['page_types:title_label_instructions']   = 'This renames the page title field from "Title". This is useful if you are using "Title" as something else, like "Product Name" or "Team Member Name".'; #translate

// Misc
$lang['page_types:delete_message']             = 'Are you sure you want to delete this page type? This will delete <strong>%s</strong> pages using this layout, any page children of these pages, and any stream entries associated with these pages. <strong>This cannot be undone.</strong> '; #translate

$lang['page_types:delete_streams_message']     = 'This will also delete the <strong>%s stream</strong> associated with this page type.'; #translate