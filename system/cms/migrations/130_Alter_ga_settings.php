<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Migration 130: Alter GA Settings
 *
 * This will allow us to set use larger option strings
 * 
 * Added April 30th, 2013
 */

class Migration_Alter_ga_settings extends CI_Migration {

  public function up()
  {
    $this->db->update('settings', array('description' => 'E-mail address of the service account used for Google Analytics.'), array('slug' => 'ga_email'));
    $this->db->update('settings', array('type' => 'text', 'description' => 'The path to the .p12 key file of the service account used for Google Analytics', 'default' => 'system/cms/config/ga-key.p12', 'value' => 'system/cms/config/ga-key.p12'), array('slug' => 'ga_password'));
  }

  public function down()
  {
    $this->db->update('settings', array('description' => 'E-mail address used for Google Analytics, we need this to show the graph on the dashboard.'), array('slug' => 'ga_email'));
    $this->db->update('settings', array('type' => 'password', 'description' => 'This is also needed to show the graph on the dashboard. You will need to allow access to Google to get this to work. See <a href="https://accounts.google.com/b/0/IssuedAuthSubTokens?hl=en_US" target="_blank">Authorized Access to your Google Account</a>', 'default' => '', 'value' => ''), array('slug' => 'ga_password'));
  }
}
