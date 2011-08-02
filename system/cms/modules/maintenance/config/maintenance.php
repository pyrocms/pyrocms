<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * The Maintenance Module - currently only remove/empty cache folder(s)
 *
 * @author     Donald Myers
 * @package    Maintenance
 * @subpackage Maintenance Module
 * @category   Modules
 */

/* for phil */
$config['maintenance.cache_protected_folders'] = array('simplepie');
$config['maintenance.cannot_remove_folders'] = array('codeigniter','themes_m');