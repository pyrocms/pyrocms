<?php defined('BASEPATH') or exit('No direct script access allowed');

// tabs
$lang['page_types:html_label']                 = 'HTML';
$lang['page_types:css_label']                  = 'CSS';
$lang['page_types:basic_info']                 = 'Basic Info'; #translate

// labels
$lang['page_types:updated_label']              = 'Gewijzigd';
$lang['page_types:layout']                 = 'Type';
$lang['page_types:auto_create_stream']         = 'Create New Stream for this Page Type'; #translate
$lang['page_types:select_stream']              = 'Stream'; #translate
$lang['page_types:theme_layout_label']         = 'Thema Type';
$lang['page_types:save_as_files']              = 'Save as Files'; #translate
$lang['page_types:content_label']              = 'Content Tab Label'; #translate
$lang['page_types:title_label']                = 'Titellabel';
$lang['page_types:sync_files']                 = 'Synchroniseer bestanden';

// titles
$lang['page_types:list_title']                 = 'Overzicht paginatypes';
$lang['page_types:list_title_sing']            = 'Paginatype';
$lang['page_types:create_title']               = 'Voeg paginalayout toe';
$lang['page_types:edit_title']                 = 'Bewerk paginalayout "%s"';

// messages
$lang['page_types:no_pages']                   = 'Er zijn geen paginatypes.';
$lang['page_types:create_success_add_fields']  = 'You have created a new page type; now add the fields that you want your page to have.'; #translate
$lang['page_types:create_success']             = 'De paginalayout is gemaakt.';
$lang['page_types:success_add_tag']            = 'The page field has been added. However before its data will be output you must insert its tag into the Page Type\'s Layout textarea'; #translate
$lang['page_types:create_error']               = 'De paginalayout kon niet worden gemaakt.';
$lang['page_types:page_type.not_found_error']  = 'Deze paginalayout bestaat niet';
$lang['page_types:edit_success']               = 'De paginalayout "%s" is opgeslagen.';
$lang['page_types:delete_home_error']          = 'U kunt de standaardlayout niet verwijderen.';
$lang['page_types:delete_success']             = 'Paginalayout #%s is verwijderd.';
$lang['page_types:mass_delete_success']        = '%s paginatypes zijn verwijderd.';
$lang['page_types:delete_none_notice']         = 'De paginatypes zijn niet verwijderd.';
$lang['page_types:already_exist_error']        = 'A table with that name already exists. Please choose a different name for this page type.'; #translate
$lang['page_types:_check_pt_slug_msg']         = 'Uw paginatype moet uniek zijn.';

$lang['page_types:variable_introduction']      = 'In deze velden zijn twee variabelen beschikbaar';
$lang['page_types:variable_title']             = 'Bevat de titel van de pagina.';
$lang['page_types:variable_body']              = 'Bevat de HTML body van de pagina.';
$lang['page_types:sync_notice']                = 'Only able to sync %s from the file system.'; #translate
$lang['page_types:sync_success']               = 'Bestanden zijn gesynchroniseerd.';
$lang['page_types:sync_fail']                  = 'Unable to sync your files.'; #translate

// Instructions
$lang['page_types:stream_instructions']        = 'This stream will hold the custom fields for your page type. You can choose a new stream, or one will be created for you.'; #translate
$lang['page_types:saf_instructions']           = 'Checking this will save your page layout file, as well as any custom CSS and JS as flat files in your assets/page_types folder.'; #translate
$lang['page_types:content_label_instructions'] = 'This renames the tab that holds your page type stream fields.'; #translate
$lang['page_types:title_label_instructions']   = 'This renames the page title field from "Title". This is useful if you are using "Title" as something else, like "Product Name" or "Team Member Name".'; #translate

// Misc
$lang['page_types:delete_message']             = 'Are you sure you want to delete this page type? This will delete <strong>%s</strong> pages using this layout, any page children of these pages, and any stream entries associated with these pages. <strong>This cannot be undone.</strong> '; #translate

$lang['page_types:delete_streams_message']     = 'This will also delete the <strong>%s stream</strong> associated with this page type.'; #translate
