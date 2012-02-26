<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PyroCMS
 *
 * An open source CMS based on CodeIgniter
 *
 * @package		PyroCMS
 * @author		Jerel Unruh - PyroCMS Dev Team
 * @license		Apache License v2.0
 * @link		http://pyrocms.com
 * @since		Version 1.0-dev
 * @filesource
 */

// General
$lang['files:fetching']						= 'Retrieving data...';
$lang['files:fetch_completed']				= 'Completed';
$lang['files:save_failed']					= 'Sorry. The changes could not be saved';
$lang['files:item_created']					= '"%s" was created';
$lang['files:item_updated']					= '"%s" was updated';
$lang['files:item_deleted']					= '"%s" was deleted';
$lang['files:item_not_deleted']				= '"%s" could not be deleted';
$lang['files:item_not_found']				= 'Sorry. "%s" could not be found';
$lang['files:sort_saved']					= 'Sort order saved';

// Labels
$lang['files:activity']						= 'Activity';
$lang['files:places']						= 'Places';
$lang['files:back']							= 'Back';
$lang['files:forward']						= 'Forward';
$lang['files:start']						= 'Start';

// Context Menu
$lang['files:open']							= 'Open';
$lang['files:new_folder']					= 'New Folder';
$lang['files:upload']						= 'Upload';
$lang['files:rename']						= 'Rename';
$lang['files:delete']						= 'Delete';
$lang['files:edit']							= 'Edit';
$lang['files:details']						= 'Details';

// Folders

$lang['files:no_folders']					= 'Your files are sorted by folders, currently you do not have any folders set up.<br />Files and folders are managed much like they would be on your desktop. Use your mouse\'s right click to create, edit, and delete files and folders.';
$lang['files:new_folder_name']				= 'Untitled Folder';
$lang['files:folder_not_empty']				= 'You must delete the contents of "%s" first';
$lang['files:mkdir_error']					= 'We are unable to create the upload folder. You must create it manually';
$lang['files:chmod_error']					= 'The upload directory is unwriteable. It must be 0777';

// Files
$lang['files:file_uploaded']				= '"%s" has been uploaded';
$lang['files:unsuccessful_fetch']			= 'We were unable to fetch "%s". Are you sure it is a public file?';
$lang['files:invalid_container']			= '"%s" does not appear to be a valid container.';
$lang['files:no_records_found']				= 'No records could be found';
$lang['files:invalid_extension']			= '"%s" has a file extension that is not allowed';
$lang['files:upload_error']					= 'The file upload failed';

/* End of file files_lang.php */