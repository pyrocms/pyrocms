<?php defined('BASEPATH') or exit('No direct script access allowed');
// TODO: Nothing translated, can be removed.
/* Messages */

$lang['streams:save_field_error'] 						= "There was a problem saving your field."; #translate
$lang['streams:field_add_success']						= "Field added successfully."; #translate
$lang['streams:field_update_error']						= "There was a problem updating your field."; #translate
$lang['streams:field_update_success']					= "Field updated successfully."; #translate
$lang['streams:field_delete_error']						= "There was a problem deleting this field."; #translate
$lang['streams:field_delete_success']					= "Field deleted successfully."; #translate
$lang['streams:view_options_update_error']				= "There was a problem updating the view options."; #translate
$lang['streams:view_options_update_success']			= "View options successfully updated."; #translate
$lang['streams:remove_field_error']						= "There was a problem removing this field."; #translate
$lang['streams:remove_field_success']					= "Field successfully removed."; #translate
$lang['streams:create_stream_error']					= "There was a problem creating your stream."; #translate
$lang['streams:create_stream_success']					= "Stream created successfully."; #translate
$lang['streams:stream_update_error']					= "There was a problem updating this stream."; #translate
$lang['streams:stream_update_success']					= "Stream updated successfully."; #translate
$lang['streams:stream_delete_error']					= "There was a problem with deleting this stream."; #translate
$lang['streams:stream_delete_success']					= "Stream deleted successfully."; #translate
$lang['streams:stream_field_ass_add_error']				= "There was a problem adding this field to this stream."; #translate
$lang['streams:stream_field_ass_add_success']			= "Field added to stream successfully."; #translate
$lang['streams:stream_field_ass_upd_error']				= "There was a problem updating this field assignment."; #translate
$lang['streams:stream_field_ass_upd_success']			= "Field assignment updated successfully."; #translate
$lang['streams:delete_entry_error']						= "There was a problem deleting this entry."; #translate
$lang['streams:delete_entry_success']					= "Entry deleted successfully."; #translate
$lang['streams:new_entry_error']						= "There was a problem adding this entry."; #translate
$lang['streams:new_entry_success']						= "Entry added successfully."; #translate
$lang['streams:edit_entry_error']						= "There was a problem updating this entry."; #translate
$lang['streams:edit_entry_success']						= "Entry updated successfully."; #translate
$lang['streams:delete_summary']							= "Are you sure you want to delete the <strong>%s</strong> stream? This will <strong>delete %s %s</strong> permanently."; #translate

/* Misc Errors */

$lang['streams:no_stream_provided']						= "No stream was provided."; #translate
$lang['streams:invalid_stream']							= "Invalid stream."; #translate
$lang['streams:not_valid_stream']						= "is not a valid stream."; #translate
$lang['streams:invalid_stream_id']						= "Invalid stream ID."; #translate
$lang['streams:invalid_row']							= "Invalid row."; #translate
$lang['streams:invalid_id']								= "Invalid ID."; #translate
$lang['streams:cannot_find_assign']						= "Cannot find field assignment."; #translate
$lang['streams:cannot_find_pyrostreams']				= "Cannot find PyroStreams."; #translate
$lang['streams:table_exists']							= "A table with the slug %s already exists."; #translate
$lang['streams:no_results']								= "No results"; #translate
$lang['streams:no_entry']								= "Unable to find entry."; #translate
$lang['streams:invalid_search_type']					= "is not a valid search type."; #translate
$lang['streams:search_not_found']						= "Search not found."; #translate

/* Validation Messages */

$lang['streams:field_slug_not_unique']					= "This field slug is already in use."; #translate
$lang['streams:not_mysql_safe_word']					= "The %s field is a MySQL reserved word."; #translate
$lang['streams:not_mysql_safe_characters']				= "The %s field contains disallowed characters."; #translate
$lang['streams:type_not_valid']							= "Please select a valid field type."; #translate
$lang['streams:stream_slug_not_unique']					= "This stream slug is already in use."; #translate
$lang['streams:field_unique']							= "The %s field must be unique."; #translate
$lang['streams:field_is_required']						= "The %s field is required."; #translate

/* Field Labels */

$lang['streams:label.field']							= "Field"; #translate
$lang['streams:label.field_required']					= "Field is Required"; #translate
$lang['streams:label.field_unique']						= "Field is Unique"; #translate
$lang['streams:label.field_instructions']				= "Field Instructions"; #translate
$lang['streams:label.make_field_title_column']			= "Make field the title column"; #translate
$lang['streams:label.field_name']						= "Field Name"; #translate
$lang['streams:label.field_slug']						= "Field Slug"; #translate
$lang['streams:label.field_type']						= "Field Type"; #translate
$lang['streams:id']										= "ID"; #translate
$lang['streams:created_by']								= "Created By"; #translate
$lang['streams:created_date']							= "Created Date"; #translate
$lang['streams:updated_date']							= "Updated Date"; #translate
$lang['streams:value']									= "Value"; #translate
$lang['streams:manage']									= "Manage"; #translate
$lang['streams:search']									= "Search"; #translate
$lang['streams:stream_prefix']							= "Stream Prefix"; #translate

/* Field Instructions */

$lang['streams:instr.field_instructions']				= "Displayed on form when entering or editing data."; #translate
$lang['streams:instr.stream_full_name']					= "Full name for your stream."; #translate
$lang['streams:instr.slug']								= "Lowercase, just letters and underscores."; #translate

/* Titles */

$lang['streams:assign_field']							= "Assign Field to Stream"; #translate
$lang['streams:edit_assign']							= "Edit Stream Assignment"; #translate
$lang['streams:add_field']								= "Create Field"; #translate
$lang['streams:edit_field']								= "Edit Field"; #translate
$lang['streams:fields']									= "Fields"; #translate
$lang['streams:streams']								= "Streams"; #translate
$lang['streams:list_fields']							= "List Fields"; #translate
$lang['streams:new_entry']								= "New Entry"; #translate
$lang['streams:stream_entries']							= "Stream Entries"; #translate
$lang['streams:entries']								= "Entries"; #translate
$lang['streams:stream_admin']							= "Stream Admin"; #translate
$lang['streams:list_streams']							= "List Streams"; #translate
$lang['streams:sure']									= "Are You Sure?"; #translate
$lang['streams:field_assignments'] 						= "Stream Field Assignments"; #translate
$lang['streams:new_field_assign']						= "New Field Assignment"; #translate
$lang['streams:stream_name']							= "Stream Name"; #translate
$lang['streams:stream_slug']							= "Stream Slug"; #translate
$lang['streams:about']									= "About"; #translate
$lang['streams:total_entries']							= "Total Entries"; #translate
$lang['streams:add_stream']								= "New Stream"; #translate
$lang['streams:edit_stream']							= "Edit Stream"; #translate
$lang['streams:about_stream']							= "About This Stream"; #translate
$lang['streams:title_column']							= "Title Column"; #translate
$lang['streams:sort_method']							= "Sort Method"; #translate
$lang['streams:add_entry']								= "Add Entry"; #translate
$lang['streams:edit_entry']								= "Edit Entry"; #translate
$lang['streams:view_options']							= "View Options"; #translate
$lang['streams:stream_view_options']					= "Stream View Options"; #translate
$lang['streams:backup_table']							= "Backup Stream Table"; #translate
$lang['streams:delete_stream']							= "Delete Stream"; #translate
$lang['streams:entry']									= "Entry"; #translate
$lang['streams:field_types']							= "Field Types"; #translate
$lang['streams:field_type']								= "Field Type"; #translate
$lang['streams:database_table']							= "Database Table"; #translate
$lang['streams:size']									= "Size"; #translate
$lang['streams:num_of_entries']							= "Number of Entries"; #translate
$lang['streams:num_of_fields']							= "Number of Fields"; #translate
$lang['streams:last_updated']							= "Last Updated"; #translate
$lang['streams:export_schema']							= "Export Schema"; #translate

/* Startup */

$lang['streams:start.add_one']							= "add one here"; #translate
$lang['streams:start.no_fields']						= "You have not created any fields yet. To start, you can"; #translate
$lang['streams:start.no_assign'] 						= "Looks like there are no fields yet for this stream. To start, you can"; #translate
$lang['streams:start.add_field_here']					= "add a field here"; #translate
$lang['streams:start.create_field_here']				= "create a field here"; #translate
$lang['streams:start.no_streams']						= "There are no streams yet, but you can start by"; #translate
$lang['streams:start.no_streams_yet']					= "There are no streams yet."; #translate
$lang['streams:start.adding_one']						= "adding one"; #translate
$lang['streams:start.no_fields_to_add']					= "No Fields to Add";		 #translate
$lang['streams:start.no_fields_msg']					= "There are no fields to add to this stream. In PyroStreams, field types can be shared between streams and must be created before being added to a stream. You can start by"; #translate
$lang['streams:start.adding_a_field_here']				= "adding a field here"; #translate
$lang['streams:start.no_entries']						= "There are no entries yet for <strong>%s</strong>. To start, you can"; #translate
$lang['streams:add_fields']								= "assign fields"; #translate
$lang['streams:no_entries']								= 'No entries'; #translate
$lang['streams:add_an_entry']							= "add an entry"; #translate
$lang['streams:to_this_stream_or']						= "to this stream or"; #translate
$lang['streams:no_field_assign']						= "No Field Assignments"; #translate
$lang['streams:no_fields_msg_first']					= "Looks like there are no fields yet for this stream."; #translate
$lang['streams:no_field_assign_msg']					= "Before you start entering data, you need to"; #translate
$lang['streams:add_some_fields']						= "assign some fields"; #translate
$lang['streams:start.before_assign']					= "Before assigning fields to a stream, you need to create a field. You can"; #translate
$lang['streams:start.no_fields_to_assign']				= "Looks like there are no fields available to be assigned. Before you can assign a field you must "; #translate

/* Buttons */

$lang['streams:yes_delete']								= "Yes, Delete"; #translate
$lang['streams:no_thanks']								= "No Thanks"; #translate
$lang['streams:new_field']								= "New Field"; #translate
$lang['streams:edit']									= "Edit"; #translate
$lang['streams:delete']									= "Delete"; #translate
$lang['streams:remove']									= "Remove"; #translate
$lang['streams:reset']									= "Reset"; #translate

/* Misc */

$lang['streams:field_singular']							= "field"; #translate
$lang['streams:field_plural']							= "fields"; #translate
$lang['streams:by_title_column']						= "By Title Column"; #translate
$lang['streams:manual_order']							= "Manual Order"; #translate
$lang['streams:stream_data_line']						= "Edit basic stream data."; #translate
$lang['streams:view_options_line'] 						= "Choose which columns should be visible on the list data page."; #translate
$lang['streams:backup_line']							= "Backup and download stream table into a zip file."; #translate
$lang['streams:permanent_delete_line']					= "Permanently delete a stream and all stream data."; #translate
$lang['streams:choose_a_field_type']					= "Choose a field type"; #translate
$lang['streams:choose_a_field']							= "Choose a field"; #translate

/* reCAPTCHA */

$lang['recaptcha_class_initialized'] 					= "reCaptcha Library Initialized"; #translate
$lang['recaptcha_no_private_key']						= "You did not supply an API key for Recaptcha"; #translate
$lang['recaptcha_no_remoteip'] 							= "For security reasons, you must pass the remote ip to reCAPTCHA"; #translate
$lang['recaptcha_socket_fail'] 							= "Could not open socket"; #translate
$lang['recaptcha_incorrect_response'] 					= "Incorrect Security Image Response"; #translate
$lang['recaptcha_field_name'] 							= "Security Image"; #translate
$lang['recaptcha_html_error'] 							= "Error loading security image.  Please try again later"; #translate

/* Default Parameter Fields */

$lang['streams:max_length'] 							= "Max Length"; #translate
$lang['streams:upload_location'] 						= "Upload Location"; #translate
$lang['streams:default_value'] 							= "Default Value"; #translate

$lang['streams:menu_path']								= 'Menu Path'; #translate
$lang['streams:about_instructions']						= 'A short description of your stream.'; #translate
$lang['streams:slug_instructions']						= 'This will also be the database table name for your stream.'; #translate
$lang['streams:prefix_instructions']					= 'If used, this will prefix the table in the database. Useful for naming collisons.'; #translate
$lang['streams:menu_path_instructions']					= 'Where you what section and sub section this stream should show up in the menu. Separate by a forward slash. Ex: <strong>Main Section / Sub Section</strong>.'; #translate

/* End of file pyrostreams_lang.php */
