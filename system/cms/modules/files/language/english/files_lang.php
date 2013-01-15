<?php defined('BASEPATH') OR exit('No direct script access allowed');

// General
$lang['files:files_title']					= 'Files';
$lang['files:fetching']						= 'Retrieving data...';
$lang['files:fetch_completed']				= 'Completed';
$lang['files:save_failed']					= 'Sorry. The changes could not be saved';
$lang['files:item_created']					= '"%s" was created';
$lang['files:item_updated']					= '"%s" was updated';
$lang['files:item_deleted']					= '"%s" was deleted';
$lang['files:item_not_deleted']				= '"%s" could not be deleted';
$lang['files:item_not_found']				= 'Sorry. "%s" could not be found';
$lang['files:sort_saved']					= 'Sort order saved';
$lang['files:no_permissions']				= 'You do not have sufficient permissions';

// Labels
$lang['files:activity']						= 'Activity';
$lang['files:places']						= 'Places';
$lang['files:back']							= 'Back';
$lang['files:forward']						= 'Forward';
$lang['files:start']						= 'Start Upload';
$lang['files:details']						= 'Details';
$lang['files:id']							= 'ID';
$lang['files:name']							= 'Name';
$lang['files:slug']							= 'Slug';
$lang['files:path']							= 'Path';
$lang['files:added']						= 'Date Added';
$lang['files:width']						= 'Width';
$lang['files:height']						= 'Height';
$lang['files:ratio']						= 'Ratio';
$lang['files:alt_attribute']				= 'Alt Attribute';
$lang['files:full_size']					= 'Full Size';
$lang['files:filename']						= 'Filename';
$lang['files:filesize']						= 'Filesize';
$lang['files:download_count']				= 'Download Count';
$lang['files:download']						= 'Download';
$lang['files:location']						= 'Location';
$lang['files:keywords']						= 'Keywords';
$lang['files:toggle_data_display']			= 'Toggle Data Display'; #translate
$lang['files:description']					= 'Description';
$lang['files:container']					= 'Container';
$lang['files:bucket']						= 'Bucket';
$lang['files:check_container']				= 'Check Validity';
$lang['files:search_message']				= 'Type and hit Enter';
$lang['files:search']						= 'Search';
$lang['files:synchronize']					= 'Synchronize';
$lang['files:uploader']						= 'Drop files here <br />or<br />Click to select files';
$lang['files:replace_file']					= 'Replace file';

// Context Menu
$lang['files:refresh']						= 'Refresh'; #translate
$lang['files:open']							= 'Open';
$lang['files:new_folder']					= 'New Folder';
$lang['files:upload']						= 'Upload';
$lang['files:rename']						= 'Rename';
$lang['files:replace']						= 'Replace';
$lang['files:delete']						= 'Delete';
$lang['files:edit']							= 'Edit';
$lang['files:details']						= 'Details';

// Folders

$lang['files:no_folders']					= 'Files and folders are managed much like they would be on your desktop. Right click in the area below this message to create your first folder. Then right click on the folder to rename, delete, upload files to it, or change details such as linking it to a cloud location.';
$lang['files:no_folders_places']			= 'Folders that you create will show up here in a tree that can be expanded and collapsed. Click on "Places" to view the root folder.';
$lang['files:no_folders_wysiwyg']			= 'No folders have been created yet';
$lang['files:new_folder_name']				= 'Untitled Folder';
$lang['files:folder']						= 'Folder';
$lang['files:folders']						= 'Folders';
$lang['files:select_folder']				= 'Select a Folder';
$lang['files:subfolders']					= 'Subfolders';
$lang['files:root']							= 'Root';
$lang['files:no_subfolders']				= 'No Subfolders';
$lang['files:folder_not_empty']				= 'You must delete the contents of "%s" first';
$lang['files:mkdir_error']					= 'We are unable to create %s. You must create it manually';
$lang['files:chmod_error']					= 'The upload directory is unwriteable. It must be 0777';
$lang['files:location_saved']				= 'The folder location has been saved';
$lang['files:container_exists']				= '"%s" exists. Save to link its contents to this folder';
$lang['files:container_not_exists']			= '"%s" does not exist in your account. Save and we will try to create it';
$lang['files:error_container']				= '"%s" could not be created and we could not determine the reason';
$lang['files:container_created']			= '"%s" has been created and is now linked to this folder';
$lang['files:unwritable']					= '"%s" is unwritable, please set its permissions to 0777';
$lang['files:specify_valid_folder']			= 'You must specify a valid folder to upload the file to';
$lang['files:enable_cdn']					= 'You must enable CDN for "%s" via your Rackspace control panel before we can synchronize';
$lang['files:synchronization_started']		= 'Starting synchronization';
$lang['files:synchronization_complete']		= 'Synchronization for "%s" has been completed';
$lang['files:untitled_folder']				= 'Untitled Folder';

// Files
$lang['files:no_files']						= 'No files found';
$lang['files:file_uploaded']				= '"%s" has been uploaded';
$lang['files:unsuccessful_fetch']			= 'We were unable to fetch "%s". Are you sure it is a public file?';
$lang['files:invalid_container']			= '"%s" does not appear to be a valid container.';
$lang['files:no_records_found']				= 'No records could be found';
$lang['files:invalid_extension']			= '"%s" has a file extension that is not allowed';
$lang['files:upload_error']					= 'The file upload failed';
$lang['files:description_saved']			= 'The file details have been saved';
$lang['files:alt_saved']					= 'The image alt attribute has been saved';
$lang['files:file_moved']					= '"%s" has been moved successfully';
$lang['files:exceeds_server_setting']		= 'The server cannot handle this large of a file';
$lang['files:exceeds_allowed']				= 'File exceeds the max size allowed';
$lang['files:file_type_not_allowed']		= 'This type of file is not allowed';
$lang['files:replace_warning']				= 'Warning: Do not replace a file with a file of a different type (e.g. .jpg with .png)';
$lang['files:type_a']						= 'Audio';
$lang['files:type_v']						= 'Video';
$lang['files:type_d']						= 'Document';
$lang['files:type_i']						= 'Image';
$lang['files:type_o']						= 'Other';

/* End of file files_lang.php */