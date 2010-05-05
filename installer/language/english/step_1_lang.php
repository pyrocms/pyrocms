<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['text']	= "<h2>Step 1: Configure Database and Server</h2>

<p>Before we can check the database, we need to know where it is and what the login details are.</p>

<h3>Database Settings</h3>

<p>
	In order for the installer to check your MySQL server version it requires you to enter the hostname, username and password in the form below.
	These settings will also be used when installing the database.
</p>";
$lang['server']		=	'Server';
$lang['username']	=	'Username';
$lang['password']	=	'Password';
$lang['port']		=	'Port';
$lang['serversettings']	=	'Server Settings';
$lang['httpserver']	=	'HTTP Server';
$lang['step2']		=	'Step 2';

// messages
$lang['db_success']	=	'The database settings are tested and working fine.';
$lang['db_failure']	=	'Problem connecting to the database: ';
