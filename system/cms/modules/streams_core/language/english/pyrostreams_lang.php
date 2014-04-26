<?php defined('BASEPATH') or exit('No direct script access allowed');

/* Messages */

$lang['streams:save_field_error'] 						= "There was a problem saving your field.";
$lang['streams:field_add_success']						= "Field added successfully.";
$lang['streams:field_update_error']						= "There was a problem updating your field.";
$lang['streams:field_update_success']					= "Field updated successfully.";
$lang['streams:field_delete_error']						= "There was a problem deleting this field.";
$lang['streams:field_delete_success']					= "Field deleted successfully.";
$lang['streams:view_options_update_error']				= "There was a problem updating the view options.";
$lang['streams:view_options_update_success']			= "View options successfully updated.";
$lang['streams:remove_field_error']						= "There was a problem removing this field.";
$lang['streams:remove_field_success']					= "Field successfully removed.";
$lang['streams:create_stream_error']					= "There was a problem creating your stream.";
$lang['streams:create_stream_success']					= "Stream created successfully.";
$lang['streams:stream_update_error']					= "There was a problem updating this stream.";
$lang['streams:stream_update_success']					= "Stream updated successfully.";
$lang['streams:stream_delete_error']					= "There was a problem with deleting this stream.";
$lang['streams:stream_delete_success']					= "Stream deleted successfully.";
$lang['streams:stream_field_ass_add_error']				= "There was a problem adding this field to this stream.";
$lang['streams:stream_field_ass_add_success']			= "Field added to stream successfully.";
$lang['streams:stream_field_ass_upd_error']				= "There was a problem updating this field assignment.";
$lang['streams:stream_field_ass_upd_success']			= "Field assignment updated successfully.";
$lang['streams:delete_entry_error']						= "There was a problem deleting this entry.";
$lang['streams:delete_entry_success']					= "Entry deleted successfully.";
$lang['streams:new_entry_error']						= "There was a problem adding this entry.";
$lang['streams:new_entry_success']						= "Entry added successfully.";
$lang['streams:edit_entry_error']						= "There was a problem updating this entry.";
$lang['streams:edit_entry_success']						= "Entry updated successfully.";
$lang['streams:delete_summary']							= "Are you sure you want to delete the <strong>%s</strong> stream? This will <strong>delete %s %s</strong> permanently.";

/* Misc Errors */

$lang['streams:no_stream_provided']						= "No stream was provided.";
$lang['streams:invalid_stream']							= "Invalid stream.";
$lang['streams:not_valid_stream']						= "is not a valid stream.";
$lang['streams:invalid_stream_id']						= "Invalid stream ID.";
$lang['streams:invalid_row']							= "Invalid row.";
$lang['streams:invalid_id']								= "Invalid ID.";
$lang['streams:cannot_find_assign']						= "Cannot find field assignment.";
$lang['streams:cannot_find_pyrostreams']				= "Cannot find PyroStreams.";
$lang['streams:table_exists']							= "A table with the slug %s already exists.";
$lang['streams:no_results']								= "No results";
$lang['streams:no_entry']								= "Unable to find entry.";
$lang['streams:invalid_search_type']					= "is not a valid search type.";
$lang['streams:search_not_found']						= "Search not found.";

/* Validation Messages */

$lang['streams:field_slug_not_unique']					= "This field slug is already in use.";
$lang['streams:not_mysql_safe_word']					= "The %s field is a MySQL reserved word.";
$lang['streams:not_mysql_safe_characters']				= "The %s field contains disallowed characters.";
$lang['streams:type_not_valid']							= "Please select a valid field type.";
$lang['streams:stream_slug_not_unique']					= "This stream slug is already in use.";
$lang['streams:field_unique']							= "The %s field must be unique.";
$lang['streams:field_is_required']						= "The %s field is required.";
$lang['streams:date_out_or_range']						= "The date you have chosen for %s is out of the acceptable range.";

/* Field Labels */

$lang['streams:label.field']							= "Field";
$lang['streams:label.field_required']					= "Field is Required";
$lang['streams:label.field_unique']						= "Field is Unique";
$lang['streams:label.field_instructions']				= "Field Instructions";
$lang['streams:label.make_field_title_column']			= "Make field the title column";
$lang['streams:label.field_name']						= "Field Name";
$lang['streams:label.field_slug']						= "Field Slug";
$lang['streams:label.field_type']						= "Field Type";
$lang['streams:id']										= "ID";
$lang['streams:created_by']								= "Created By";
$lang['streams:created_date']							= "Created Date";
$lang['streams:updated_date']							= "Updated Date";
$lang['streams:value']									= "Value";
$lang['streams:manage']									= "Manage";
$lang['streams:search']									= "Search";
$lang['streams:stream_prefix']							= "Stream Prefix";

/* Field Instructions */

$lang['streams:instr.field_instructions']				= "Displayed on form when entering or editing data.";
$lang['streams:instr.stream_full_name']					= "Full name for your stream.";
$lang['streams:instr.slug']								= "Lowercase, just letters and underscores.";

/* Titles */

$lang['streams:assign_field']							= "Assign Field to Stream";
$lang['streams:edit_assign']							= "Edit Stream Assignment";
$lang['streams:add_field']								= "Create Field";
$lang['streams:edit_field']								= "Edit Field";
$lang['streams:fields']									= "Fields";
$lang['streams:streams']								= "Streams";
$lang['streams:list_fields']							= "List Fields";
$lang['streams:new_entry']								= "New Entry";
$lang['streams:stream_entries']							= "Stream Entries";
$lang['streams:entries']								= "Entries";
$lang['streams:stream_admin']							= "Stream Admin";
$lang['streams:list_streams']							= "List Streams";
$lang['streams:sure']									= "Are You Sure?";
$lang['streams:field_assignments'] 						= "Stream Field Assignments";
$lang['streams:new_field_assign']						= "New Field Assignment";
$lang['streams:stream_name']							= "Stream Name";
$lang['streams:stream_slug']							= "Stream Slug";
$lang['streams:about']									= "About";
$lang['streams:total_entries']							= "Total Entries";
$lang['streams:add_stream']								= "New Stream";
$lang['streams:edit_stream']							= "Edit Stream";
$lang['streams:about_stream']							= "About This Stream";
$lang['streams:title_column']							= "Title Column";
$lang['streams:sort_method']							= "Sort Method";
$lang['streams:add_entry']								= "Add Entry";
$lang['streams:edit_entry']								= "Edit Entry";
$lang['streams:view_options']							= "View Options";
$lang['streams:stream_view_options']					= "Stream View Options";
$lang['streams:backup_table']							= "Backup Stream Table";
$lang['streams:delete_stream']							= "Delete Stream";
$lang['streams:entry']									= "Entry";
$lang['streams:field_types']							= "Field Types";
$lang['streams:field_type']								= "Field Type";
$lang['streams:database_table']							= "Database Table";
$lang['streams:size']									= "Size";
$lang['streams:num_of_entries']							= "Number of Entries";
$lang['streams:num_of_fields']							= "Number of Fields";
$lang['streams:last_updated']							= "Last Updated";
$lang['streams:export_schema']							= "Export Schema";

/* Startup */

$lang['streams:start.add_one']							= "add one here";
$lang['streams:start.no_fields']						= "You have not created any fields yet. To start, you can";
$lang['streams:start.no_assign'] 						= "Looks like there are no fields yet for this stream. To start, you can";
$lang['streams:start.add_field_here']					= "add a field here";
$lang['streams:start.create_field_here']				= "create a field here";
$lang['streams:start.no_streams']						= "There are no streams yet, but you can start by";
$lang['streams:start.no_streams_yet']					= "There are no streams yet.";
$lang['streams:start.adding_one']						= "adding one";
$lang['streams:start.no_fields_to_add']					= "No Fields to Add";		
$lang['streams:start.no_fields_msg']					= "There are no fields to add to this stream. In PyroStreams, field types can be shared between streams and must be created before being added to a stream. You can start by";
$lang['streams:start.adding_a_field_here']				= "adding a field here";
$lang['streams:start.no_entries']						= "There are no entries yet for <strong>%s</strong>. To start, you can";
$lang['streams:no_entries']								= 'No entries'; #translate
$lang['streams:add_fields']								= "assign fields";
$lang['streams:add_an_entry']							= "add an entry";
$lang['streams:to_this_stream_or']						= "to this stream or";
$lang['streams:no_field_assign']						= "No Field Assignments";
$lang['streams:no_fields_msg_first']					= "Looks like there are no fields yet for this stream.";
$lang['streams:no_field_assign_msg']					= "Before you start entering data, you need to";
$lang['streams:add_some_fields']						= "assign some fields";
$lang['streams:start.before_assign']					= "Before assigning fields to a stream, you need to create a field. You can";
$lang['streams:start.no_fields_to_assign']				= "Looks like there are no fields available to be assigned. Before you can assign a field you must ";

/* Buttons */

$lang['streams:yes_delete']								= "Yes, Delete";
$lang['streams:no_thanks']								= "No Thanks";
$lang['streams:new_field']								= "New Field";
$lang['streams:edit']									= "Edit";
$lang['streams:delete']									= "Delete";
$lang['streams:remove']									= "Remove";
$lang['streams:reset']									= "Reset";

/* Misc */

$lang['streams:field_singular']							= "field";
$lang['streams:field_plural']							= "fields";
$lang['streams:by_title_column']						= "By Title Column";
$lang['streams:manual_order']							= "Manual Order";
$lang['streams:stream_data_line']						= "Edit basic stream data.";
$lang['streams:view_options_line'] 						= "Choose which columns should be visible on the list data page.";
$lang['streams:backup_line']							= "Backup and download stream table into a zip file.";
$lang['streams:permanent_delete_line']					= "Permanently delete a stream and all stream data.";
$lang['streams:choose_a_field_type']					= "Choose a field type";
$lang['streams:choose_a_field']							= "Choose a field";

/* reCAPTCHA */

$lang['recaptcha_class_initialized'] 					= "reCaptcha Library Initialized";
$lang['recaptcha_no_private_key']						= "You did not supply an API key for Recaptcha";
$lang['recaptcha_no_remoteip'] 							= "For security reasons, you must pass the remote ip to reCAPTCHA";
$lang['recaptcha_socket_fail'] 							= "Could not open socket";
$lang['recaptcha_incorrect_response'] 					= "Incorrect Security Image Response";
$lang['recaptcha_field_name'] 							= "Security Image";
$lang['recaptcha_html_error'] 							= "Error loading security image.  Please try again later";

/* Default Parameter Fields */

$lang['streams:max_length'] 							= "Max Length";
$lang['streams:upload_location'] 						= "Upload Location";
$lang['streams:default_value'] 							= "Default Value";

$lang['streams:menu_path']								= 'Menu Path';
$lang['streams:about_instructions']						= 'A short description of your stream.';
$lang['streams:slug_instructions']						= 'This will also be the database table name for your stream.';
$lang['streams:prefix_instructions']					= 'If used, this will prefix the table in the database. Useful for naming collisons.';
$lang['streams:menu_path_instructions']					= 'Where you what section and sub section this stream should show up in the menu. Separate by a forward slash. Ex: <strong>Main Section / Sub Section</strong>.';
/* End of file pyrostreams_lang.php */