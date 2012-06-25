<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config['maintenance.cache_protected_folders'] = array('simplepie', 'cloud_cache');
$config['maintenance.cannot_remove_folders'] = array('codeigniter', 'theme_m');

// An array of database tables that are eligible to be exported.
$config['maintenance.export_tables'] = array('users', 'contact_log', 'files', 'pages', 'blog', 'navigation_links', 'comments');