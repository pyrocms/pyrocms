<?php defined('BASEPATH') OR exit('No direct script access allowed');

// inline help html. Only 'help_body' is used.
$lang['help_body'] = "
<h4>Overview</h4>
<p>The Addons module allows admins to upload, install, and uninstall third-party modules.</p>

<h4>Uploading</h4>
<p>New modules must be in a zip file and the folder must be named the same as the module.
For example if you are uploading the 'forums' module the folder must be named 'forums' not 'test_forums'.</p>

<h4>Disabling, Uninstalling, or Deleting a module</h4>
<p>If you want to remove a module from the front-end and from the admin menus you may simply Disable the module.
If you are done with the data but may want to re-install the module in the future you may Uninstall it.
<font color=\"red\">Note: this removes all database records.</font> If you are finished with all database records and source files you may Delete it.
<font color=\"red\">This removes all source files, uploaded files, and database records associated with the module.</font></p>
";