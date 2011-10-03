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

$config['maintenance.cache_protected_folders'] = array('simplepie');
$config['maintenance.cannot_remove_folders'] = array('codeigniter','themes_m');