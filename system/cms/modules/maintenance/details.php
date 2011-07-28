<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 * The Maintenance Module - currently only remove/empty cache folder(s)
 *
 * @author     Donald Myers
 * @package    Maintenance
 * @subpackage Maintenance Module
 * @category   Modules
 */
class Module_Maintenance extends Module {

  public $version = '1.0';

  public function info() {
    return array(
      'name' => array(
        'en' => 'Maintenance'
      ),
      'description' => array(
        'en' => 'Pyro Maintenance Module'
      ),
      'frontend' => false,
      'backend' => true,
      'menu' => 'utilities'
    );
  }

  public function install() {
    return true;
  }

  public function uninstall() {
    return true;
  }

  public function upgrade($old_version) {
    return true;
  }

  public function help() {
    return "This module will clean up and/or remove cache files and folders<br>Other options possible in the future.";
  }
}
/* End of file details.php */
