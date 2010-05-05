<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['text']	= "<h2>Step 2: Check requirements</h2>
<p>The first step in the installation process is to check whether your server supports PyroCMS. Most servers should be able to run it without any trouble.</p>

<h3>HTTP Server Settings</h3>
</p>";
$lang['serverversion']	=	"Your server software <strong>{serversion}</strong> is ";
$lang['server1']	=	'Your server software';
$lang['server2']	=	'is <span class="green">supported</span>.';
$lang['server_fail']=	'Your server software is <span class="red">not support</span>, therefore PyroCMS may or may not work. As long as your PHP and MySQL installations 
	are up to date PyroCMS should be able to run properly, just without clean URL\'s.';
$lang['phpsettings']	=	'PHP Settings';
$lang['phpversion1']	=	'PyroCMS requires PHP version 5.0 or higher. Your server is currently running version';
$lang['phpversion2']	=	'which is';
$lang['supported'] 		= 	'<span class="green">supported</span>'; 
$lang['not supported']	=	'<span class="red">not support</span>';
$lang['mysqlsettings']	=	'MySQL Settings';
$lang['mysqlversion1']	=	'PyroCMS requires access to a MySQL database running version 5.0 or higher. Your server is currently running';
$lang['mysqlversion2']	=	'and the client library version is';
$lang['mysqlversion3']	=	'which is';
$lang['gdsettings']		=	'GD Settings';
$lang['gdversion1']		= 	'PyroCMS requires GD library 1.0 or higher.';
$lang['gdversion2']		= 	'Your server is currently running version';
$lang['gdversion3']		= 	'which is';
$lang['gdversion_fail']	=	'We cannot determine the version of the GD library.  This usually means that the GD library is not installed.';
$lang['summary_green']	=	'Your server meets all the requirements for PyroCMS to run properly, go to the next step by clicking the button below.';
$lang['summary_orange']	=	'Your server meets <em>most</em> of the requirements for PyroCMS. This means that PyroCMS should be able to run properly but there is a chance that you will experience problems with things such as image resizing and thumbnail creating.';
$lang['summary_red']	=	'It seems that your server failed to meet the requirements to run PyroCMS. Please contact your server administrator or hosting company to get this resolved.';
$lang['next_step']		=	'Proceed to the next step';
$lang['step3']			=	'Step 3';
$lang['retry']			=	'Try again';

// messages
$lang['step1_failure']	=	'Please fill in the required database settings in the form below..';
