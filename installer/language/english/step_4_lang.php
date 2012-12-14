<?php defined('BASEPATH') or exit('No direct script access allowed');

// labels
$lang['header']			=	'Step 4: Create Administrator'; #translate
$lang['intro_text']		=	'Complete the admin user details in the form below and hit the button labeled "Install" to complete the installation of PyroCMS.';

$lang['default_user']		=	'Default User';
$lang['database']		=	'Database';
$lang['site_settings']		= 	'Site Settings';
$lang['site_ref']		=	'Site Ref';
$lang['user_name']		= 	'Username';
$lang['first_name']		= 	'First name';
$lang['last_name']		=	'Last name';
$lang['email']			=	'Email';
$lang['password']		= 	'Password';
$lang['conf_password']		=	'Confirm Password';
$lang['finish']			=	'Install';

$lang['invalid_db_name'] = 'The database name you entered is invalid. Please use only alphanumeric characters and underscores.';
$lang['error_101']		=	'The database could not be found. If you asked the installer to create this database, it probably failed due to insufficient permissions.';
$lang['error_102']		=	'The installer could not add any tables to the Database.';
$lang['error_103']		=	'The installer could not insert the data into the database.';
$lang['error_104']		=	'The installer could not create the default user.';
$lang['error_105']		=	'The database configuration file could not be written, did you cheat on the installer by skipping step 3?';
$lang['error_106']		=	'The config file could not be written, are you sure the file has the correct permissions ?';
$lang['success']		=	'PyroCMS has been installed successfully.';