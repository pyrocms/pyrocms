<?php defined('BASEPATH') or exit('No direct script access allowed');

// tabs
$lang['page_types.html_label']                 = 'HTML';
$lang['page_types.css_label']                  = 'CSS';
$lang['page_types.basic_info']                 = 'Basic Info'; #translate

// labels
$lang['page_types.updated_label']              = 'Posodobljeno';
$lang['page_types.layout']                     = 'Layout'; #translate
$lang['page_types:auto_create_stream']         = 'Create New Stream for this Page Type'; #translate
$lang['page_types:select_stream']              = 'Stream'; #translate
$lang['page_types:theme_layout_label']         = 'Izgled postavitve';
$lang['page_types:save_as_files']              = 'Save as Files'; #translate
$lang['page_types:content_label']              = 'Content Tab Label'; #translate
$lang['page_types:title_label']                = 'Title Label'; #translate
$lang['page_types:sync_files']                 = 'Sync Files'; #translate

// titles
$lang['page_types.list_title']                 = 'Seznam postavitev strani';
$lang['page_types.list_title_sing']            = 'Page Type'; #translate
$lang['page_types.create_title']               = 'Dodaj postavitev stani';
$lang['page_types.edit_title']                 = 'Uredi postavitev strani "%s"';

// messages
$lang['page_types.no_pages']                   = 'Ni še nobene postavitve strani.';
$lang['page_types.create_success']             = 'Postavitev strani je bila ustvarjena.';
$lang['page_types.create_error']               = 'Ta postavitev strani je bila ustvarjena.';
$lang['page_types.page_type.not_found_error']  = 'Ta postavitev strani ne obstaja.';
$lang['page_types.edit_success']               = 'Postavitev strani "%s" je bila shranjena.';
$lang['page_types.delete_home_error']          = 'Prednastavljene postavitve strani ni mogoče odstraniti.';
$lang['page_types.delete_success']             = 'Postavitev strani #%s je bila odstranjena.';
$lang['page_types.mass_delete_success']        = '%s postavitve strani so bile odstranjene.';
$lang['page_types.delete_none_notice']         = 'Nobena postavitev strani ni bila odstranjena.';
$lang['page_types.already_exist_error']        = 'A table with that name already exists. Please choose a different name for this page type.'; #translate
$lang['page_types._check_pt_slug_msg']         = 'Your page type slug must be unique.'; #translate

$lang['page_types.variable_introduction']      = 'V tem polju za vnos so na voljo dve možnosti.';
$lang['page_types.variable_title']             = 'Vsebuje naslov strani.';
$lang['page_types.variable_body']              = 'Vsebuje HTML vsebino strani.';
$lang['page_types.sync_notice']                = 'Only able to sync %s from the file system.'; #translate
$lang['page_types.sync_success']               = 'Files synced successfully.'; #translate
$lang['page_types.sync_fail']                  = 'Unable to sync your files.'; #translate

// Instructions
$lang['page_types.stream_instructions']        = 'This stream will hold the custom fields for your page type. You can choose a new stream, or one will be created for you.'; #translate
$lang['page_types.saf_instructions']           = 'Checking this will save your page layout file, as well as any custom CSS and JS as flat files in your assets/page_types folder.'; #translate
$lang['page_types:content_label_instructions'] = 'This renames the tab that holds your page type stream fields.'; #translate
$lang['page_types:title_label_instructions']   = 'This renames the page title field from "Title". This is useful if you are using "Title" as something else, like "Product Name" or "Team Member Name".'; #translate

// Misc
$lang['page_types:delete_message']             = 'Are you sure you want to delete this page type? This will delete <strong>%s</strong> pages using this layout, any page children of these pages, and any stream entries associated with these pages. <strong>This cannot be undone.</strong> '; #translate

$lang['page_types:delete_streams_message']     = 'This will also delete the <strong>%s stream</strong> associated with this page type.'; #translate