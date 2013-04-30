<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Get rid of Twitter from settings
 */
class Migration_Remove_twitter extends CI_Migration {

    public function up()
    {
	$this->db
	    ->where('module', 'twitter')
	    ->delete('settings');
    }

    public function down()
    {
	
    }
}