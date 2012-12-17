<?php defined('BASEPATH') or exit('No direct script access allowed');

// tabs
$lang['page_types.html_label']                 = 'HTML';
$lang['page_types.css_label']                  = 'CSS';
$lang['page_types.basic_info']                 = 'Basic Info';

// labels
$lang['page_types.updated_label']              = 'Updated';
$lang['page_types.layout']                     = 'Layout';
$lang['page_types:auto_create_stream']         = 'Create New Stream for this Page Type';
$lang['page_types:select_stream']              = 'Stream';
$lang['page_types:theme_layout_label']         = 'Theme Layout';
$lang['page_types:save_as_files']              = 'Save as Files';
$lang['page_types:content_label']              = 'Content Tab Label';
$lang['page_types:title_label']                = 'Title Label';
$lang['page_types:sync_files']                 = 'Sync Files';

// titles
$lang['page_types.list_title']                 = 'Page Types';
$lang['page_types.list_title_sing']            = 'Page Type';
$lang['page_types.create_title']               = 'Add Page Type';
$lang['page_types.edit_title']                 = 'Edit Page Type "%s"';

// messages
$lang['page_types.no_pages']                   = 'There are no page types.';
$lang['page_types.create_success']             = 'The page layout was created.';
$lang['page_types.create_error']               = 'That page layout has not been created.';
$lang['page_types.page_type.not_found_error']  = 'That page layout does not exist.';
$lang['page_types.edit_success']               = 'The page layout "%s" was saved.';
$lang['page_types.delete_home_error']          = 'You can not delete the default layout.';
$lang['page_types.delete_success']             = 'Page layout #%s has been deleted.';
$lang['page_types.mass_delete_success']        = '%s page types have been deleted.';
$lang['page_types.delete_none_notice']         = 'No page types were deleted.';
$lang['page_types.already_exist_error']        = 'A table with that name already exists. Please choose a different name for this page type.';
$lang['page_types._check_pt_slug_msg']         = 'Your page type slug must be unique.';

$lang['page_types.variable_introduction']      = 'In this input box there are two variables available';
$lang['page_types.variable_title']             = 'Contains the title of the page.';
$lang['page_types.variable_body']              = 'Contains the HTML body of the page.';
$lang['page_types.sync_notice']                = 'Only able to sync %s from the file system.';
$lang['page_types.sync_success']               = 'Files synced successfully.';
$lang['page_types.sync_fail']                  = 'Unable to sync your files.';

// Instructions
$lang['page_types.stream_instructions']        = 'This stream will hold the custom fields for your page type. You can choose a new stream, or one will be created for you.';
$lang['page_types.saf_instructions']           = 'Checking this will save your page layout file, as well as any custom CSS and JS as flat files in your assets/page_types folder.';
$lang['page_types:content_label_instructions'] = 'This renames the tab that holds your page type stream fields.';
$lang['page_types:title_label_instructions']   = 'This renames the page title field from "Title". This is useful if you are using "Title" as something else, like "Product Name" or "Team Member Name".';

// Misc
$lang['page_types:delete_message']             = 'Are you sure you want to delete this page type? This will delete <strong>%s</strong> pages using this layout, any page children of these pages, and any stream entries associated with these pages. <strong>This cannot be undone.</strong> ';

$lang['page_types:delete_streams_message']     = 'This will also delete the <strong>%s stream</strong> associated with this page type.';