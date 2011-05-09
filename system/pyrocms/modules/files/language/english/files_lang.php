<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PyroCMS
 *
 * An open source CMS based on CodeIgniter
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @license		Apache License v2.0
 * @link		http://pyrocms.com
 * @since		Version 1.0-dev
 * @filesource
 */

// Files

// Titles
$lang['files.files_title']					= 'Files';
$lang['files.upload_title']					= 'Upload Files';
$lang['files.edit_title']					= 'Edit file "%s"';

// Labels
$lang['files.actions_label']				= 'Actions';
$lang['files.download_label']				= 'Download';
$lang['files.edit_label']					= 'Edit';
$lang['files.delete_label']					= 'Delete';
$lang['files.upload_label']					= 'Upload';
$lang['files.description_label']			= 'Description';
$lang['files.type_label']					= 'Type';
$lang['files.file_label']					= 'File';
$lang['files.filename_label']				= 'File Name';
$lang['files.filter_label']					= 'Filter';
$lang['files.loading_label']				= 'Loading...';
$lang['files.name_label']					= 'Name';

$lang['files.dropdown_no_subfolders']		= '-- None --';
$lang['files.dropdown_root']				= '-- Root --';

$lang['files.type_a']						= 'Audio';
$lang['files.type_v']						= 'Video';
$lang['files.type_d']						= 'Document';
$lang['files.type_i']						= 'Image';
$lang['files.type_o']						= 'Other';

$lang['files.display_grid']					= 'Grid';
$lang['files.display_list']					= 'List';

// Messages
$lang['files.create_success']				= 'The file has now been saved.';
$lang['files.create_error']					= 'An error as occourred.';
$lang['files.edit_success']					= 'The file was successfully saved.';
$lang['files.edit_error']					= 'An error occurred while trying to save the file.';
$lang['files.delete_success']				= 'The file was deleted.';
$lang['files.delete_error']					= 'The file could not be deleted.';
$lang['files.mass_delete_success']			= '%d of %d files were successfully deleted, they were "%s and %s"';
$lang['files.mass_delete_error']			= 'An error occurred while trying to delete %d of %d files, they are "%s and %s".';
$lang['files.upload_error']					= 'A file must be uploaded.';
$lang['files.invalid_extension']			= 'File must have a valid extension.';
$lang['files.not_exists']					= 'An invalid folder has been selected.';
$lang['files.no_files']						= 'There are currently no files.';
$lang['files.no_permissions']				= 'You do not have permissions to see the files module.';
$lang['files.no_select_error'] 				= 'You must select a file first, his request was interrupted.';

// File folders

// Titles
$lang['file_folders.folders_title']			= 'File Folders';
$lang['file_folders.manage_title']			= 'Manage Folders';
$lang['file_folders.create_title']			= 'New Folder';
$lang['file_folders.delete_title']			= 'Confirm Delete';
$lang['file_folders.edit_title']			= 'Edit folder "%s"';

// Labels
$lang['file_folders.folders_label']			= 'Folders';
$lang['file_folders.folder_label']			= 'Folder';
$lang['file_folders.subfolders_label']		= 'Sub-Folders';
$lang['file_folders.parent_label']			= 'Parent';
$lang['file_folders.name_label']			= 'Name';
$lang['file_folders.slug_label']			= 'URL Slug';
$lang['file_folders.created_label']			= 'Created On';

// Messages
$lang['file_folders.create_success']		= 'The folder has now been saved.';
$lang['file_folders.create_error']			= 'An error occurred while attempting to create your folder.';
$lang['file_folders.duplicate_error']		= 'A folder named "%s" already exists.';
$lang['file_folders.edit_success']			= 'The folder was successfully saved.';
$lang['file_folders.edit_error']			= 'An error occurred while trying to save the changes.';
$lang['file_folders.confirm_delete']		= 'Are you sure you want to delete the folders below, including all files and subfolders inside them?';
$lang['file_folders.delete_mass_success']	= '%d of %d folders have been successfully deleted, they were "%s and %s.';
$lang['file_folders.delete_mass_error']		= 'An error occurred while trying to delete %d of %d folders, they are "%s and %s".';
$lang['file_folders.delete_success']		= 'The folder "%s" was deleted.';
$lang['file_folders.delete_error']			= 'An error occurred while trying to delete the folder "%s".';
$lang['file_folders.not_exists']			= 'An invalid folder has been selected.';
$lang['file_folders.no_subfolders']			= 'None';
$lang['file_folders.no_folders']			= 'Your files are sorted by folders, currently you do not have any folders setup.';
$lang['file_folders.mkdir_error']			= 'Could not make the uploads/files directory';
$lang['file_folders.chmod_error']			= 'Could not chmod the uploads/files directory';

/* End of file files_lang.php */