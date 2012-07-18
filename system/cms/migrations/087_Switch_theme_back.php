<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Switch_theme_back extends CI_Migration {

    public function up()
    {
		$this->db
			->where('slug', 'default_theme')
			->where('value', 'base')
			->set('default', 'default')
			->set('value', 'default')
			->update('settings');
    }

    public function down()
    {
        $this->db
			->where('slug', 'default_theme')
			->where('value', 'default')
			->set('default', 'base')
			->set('value', 'base')
			->update('settings');
    }
}