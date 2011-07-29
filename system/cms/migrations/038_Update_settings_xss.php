<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Update_settings_xss extends Migration {

  function up()
  {
		$this->migrations->verbose AND print "Update settings - settings allow skip_xss";

		$this->db
			->set('skip_xss', '1')
			->where('slug', 'settings')
			->update('modules');
  }

  function down()
  {
		$this->db
			->set('skip_xss', '0')
			->where('slug', 'settings')
			->update('modules');
  }
}
