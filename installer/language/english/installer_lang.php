<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

$lang['intro']  =   'Intro';
$lang['step1']	=	'Step #1';
$lang['step2']	=	'Step #2';
$lang['step3']	=	'Step #3';
$lang['step4']	=	'Step #4';
$lang['final']	=	'Final Step';

$lang['installer.passwords_match']		= "Passwords Match.";
$lang['installer.passwords_dont_match']	= "Passwords Don\'t Match.";

// labels
$lang['step1_header']			=	'Step 1: Configure Database and Server';
$lang['step1_intro_text']		=	'PyroCMS is very easy to install and should only take a few minutes, but there are a few questions that may appear confusing if you do not have a technical background. If at any point you get stuck please ask your web hosting provider or <a href="http://www.pyrocms.com/contact" target="_blank">contact us</a> for support.';

$lang['db_driver']		=	 'Database Driver';
$lang['mysql_about']    =    'MySQL is the world\'s most used open-source database. It is fast, popular and installed on the majority of web servers.';
$lang['use_mysql']		= 	 'Use MySQL';
$lang['pgsql_about'] 	=    'PostgreSQL is a popular alternative to MySQL. It is often slightly quicker but is installed on less servers by default.';
$lang['use_pgsql']		= 	 'Use PostgreSQL';
$lang['sqlite_about']   =    'SQLite is a lightweight file-based SQL engine, which installed on many servers and part of PHP as of PHP 5.3.';
$lang['use_sqlite']		= 	 'Use SQLite';

$lang['not_available']		= 	 'Not Available';

$lang['db_settings']		=	'Settings';
$lang['db_server']			=	'Hostname';
$lang['db_location']		=	'Location';
$lang['db_username']		=	'Username';
$lang['db_password']		=	'Password';
$lang['db_portnr']			=	'Port';
$lang['db_database']		=	'Database Name';
$lang['db_create']			=	'Create Database';
$lang['db_notice']			=	'You might need to do this yourself';

$lang['server_settings']	=	'Server Settings';
$lang['httpserver']			=	'HTTP Server';

$lang['httpserver_text']	=	'PyroCMS requires a HTTP Server to display dynamic content when a user goes to your website. It looks like you already have one by the fact that you can see this page, but if we know exactly which type then PyroCMS can configure itself even better. If you do not know what any of this means just ignore it and carry on with the installation.';
$lang['rewrite_fail']		=	'You have selected "(Apache with mod_rewrite)" but we are unable to tell if mod_rewrite is enabled on your server. Ask your host if mod_rewrite is enabled or simply install at your own risk.';
$lang['mod_rewrite']		=	'You have selected "(Apache with mod_rewrite)" but your server does not have the rewrite module enabled. Ask your host to enable it or install PyroCMS using the "Apache (without mod_rewrite)" option.';
$lang['step2']				=	'Step 2';

// messages
$lang['db_success']			=	'The database settings are tested and working fine.';
$lang['db_failure']			=	'Problem connecting to the database: ';

// labels
$lang['step2_header']			=	'Step 2: Check Requirements';
$lang['step2_intro_text']		= 	'The second step in the installation process is to check whether your server supports PyroCMS. Most servers should be able to run it without any trouble.';
$lang['mandatory']		= 	'Mandatory';
$lang['recommended']	= 	'Recommended';

$lang['server_settings']= 	'HTTP Server Settings';
$lang['server_version']	=	'Your server software:';
$lang['server_fail']	=	'Your server software is not supported, therefore PyroCMS may or may not work. As long as your PHP and MySQL installations are up to date PyroCMS should be able to run properly, just without clean URL\'s.';

$lang['php_settings']	=	'PHP Settings';
$lang['php_required']	=	'PyroCMS requires PHP version %s or higher.';
$lang['php_version']	=	'Your server is currently running version';
$lang['php_fail']		=	'Your PHP version is not supported. PyroCMS requires PHP version %s or higher to run properly.';

$lang['mysql_settings']	=	'MySQL Settings';
$lang['mysql_required']	=	'PyroCMS requires access to a MySQL database running version 5.0 or higher.';
$lang['mysql_version1']	=	'Your server is currently running';
$lang['mysql_version2']	=	'Your client is currently running';
$lang['mysql_fail']		=	'Your MySQL version is not supported. PyroCMS requires MySQL version 5.0 or higher to run properly.';

$lang['gd_settings']	=	'GD Settings';
$lang['gd_required']	= 	'PyroCMS requires GD library 1.0 or higher to manipulate images.';
$lang['gd_version']		= 	'Your server is currently running version';
$lang['gd_fail']		=	'We cannot determine the version of the GD library. This usually means that the GD library is not installed. PyroCMS will still run properly but some of the image functions might not work. It is highly recommended to enable the GD library.';

$lang['summary']		=	'Summary';

$lang['zlib']			=	'Zlib';
$lang['zlib_required']	= 	'PyroCMS requires Zlib in order to unzip and install themes.';
$lang['zlib_fail']		=	'Zlib can not be found. This usually means that Zlib is not installed. PyroCMS will still run properly but installation of themes will not work. It is highly recommended to install Zlib.';

$lang['curl']			=	'Curl';
$lang['curl_required']	=	'PyroCMS requires Curl in order to make connections to other sites.';
$lang['curl_fail']		=	'Curl can not be found. This usually means that Curl is not installed. PyroCMS will still run properly but some of the functions might not work. It is highly recommended to enable the Curl library.';

$lang['summary_success']	=	'Your server meets all the requirements for PyroCMS to run properly, go to the next step by clicking the button below.';
$lang['summary_partial']	=	'Your server meets <em>most</em> of the requirements for PyroCMS. This means that PyroCMS should be able to run properly but there is a chance that you will experience problems with things such as image resizing and thumbnail creating.';
$lang['summary_failure']	=	'It seems that your server failed to meet the requirements to run PyroCMS. Please contact your server administrator or hosting company to get this resolved.';
$lang['next_step']		=	'Proceed to the next step';
$lang['step3']			=	'Step 3';
$lang['retry']			=	'Try again';

// messages
$lang['step1_failure']	=	'Please fill in the required database settings in the form below..';

// labels
$lang['step3_header']			=	'Step 3: Set Permissions';
$lang['step3_intro_text']		= 	'Before PyroCMS can be installed you need to make sure that certain files and folders are writeable, these files and folders are listed below. Make sure any subfolders have the correct permissions too!';

$lang['folder_perm']		= 'Folder Permissions';
$lang['folder_text']		= 'The CHMOD values of the following folders must be changed to 777 (in some cases 775 works too).';

$lang['file_perm']		= 'File Permissions';
$lang['file_text']		= 'The CHMOD values of the following file must be changed to 666. It\'s very important to change the file permissions of the config file <em>before</em> continuing with the installation.';

$lang['writable']		= 'Writable';
$lang['not_writable']		= 'Not writable';

$lang['show_commands']		= 'Show commands';
$lang['hide_commands']		= 'Hide commands';

$lang['next_step']		= 'Proceed to the next step';
$lang['step4']			= 'Step 4';
$lang['retry']			= 'Try again';

// labels
$lang['step4_header']			=	'Step 4: Create Database';
$lang['step4_intro_text']		=	'Complete the form below and hit the button labelled "Install" to install PyroCMS. Be sure to install PyroCMS into the right database since all existing changes will be lost!';

$lang['default_user']		=	'Default User';
$lang['site_settings']		= 	'Site Settings';
$lang['site_ref']		=	'Site Ref';
$lang['username']		= 	'Username';
$lang['firstname']		= 	'First name';
$lang['lastname']		=	'Last name';
$lang['email']			=	'Email';
$lang['password']		= 	'Password';
$lang['conf_password']		=	'Confirm Password';
$lang['finish']			=	'Install';

$lang['invalid_db_name'] = 'The database name you entered is invalid. Please use only alphanumeric characters and underscores.';
$lang['error_101']		=	'The database could not be found. If you asked the installer to create this database, it could have failed due to bad permissions.';
$lang['error_102']		=	'The installer could not add any tables to the Database.';
$lang['error_103']		=	'The installer could not insert the data into the database.';
$lang['error_104']		=	'The installer could not create the default user.';
$lang['error_105']		=	'The database configuration file could not be written, did you cheat on the installer by skipping step 3?';
$lang['error_106']		=	'The config file could not be written, are you sure the file has the correct permissions ?';
$lang['success']		=	'PyroCMS has been installed successfully.';

// labels
$lang['congrats']			= 'Congratulations';
$lang['intro_text']			= 'PyroCMS is now installed and ready to go! Please log into the admin panel with the following details.';
$lang['email']				= 'E-mail';
$lang['password']			= 'Password';
$lang['show_password']		= 'Show Password?';
$lang['outro_text']			= 'Finally, <strong>delete the installer from your server</strong> as if you leave it here it can be used to hack your website.';

$lang['go_website']			= 'Go to Website';
$lang['go_control_panel']	= 'Go to Control Panel';

/* End of file global_lang.php */
