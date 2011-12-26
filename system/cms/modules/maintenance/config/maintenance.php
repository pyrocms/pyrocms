<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * The Maintenance Module - currently only remove/empty cache folder(s)
 *
 * @author		Donald Myers
 * @package		PyroCMS
 * @subpackage	Maintenance Module
 * @category	Modules
 */

$config['maintenance.cache_protected_folders'] 	= array('simplepie');
$config['maintenance.cannot_remove_folders'] 	= array('codeigniter','theme_m');

// An array of database tables that are eligible to be exported.
$config['maintenance.export_tables']	= array('users',
												'contact_log',
												'files',
												'pages',
												'blog',
												'navigation_links',
												'comments'
												);