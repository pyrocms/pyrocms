<?php defined('BASEPATH') OR exit('No direct script access allowed');

// labels
$lang['header']			=	'Step 2: Check Requirements';
$lang['intro_text']		= 	'The second step in the installation process is to check whether your server supports PyroCMS. Most servers should be able to run it without any trouble.';
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

/* End of file step_2_lang.php */
/* Location: ./installer/language/english/step_2_lang.php */