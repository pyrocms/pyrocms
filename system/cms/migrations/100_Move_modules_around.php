<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Move_modules_around extends CI_Migration {
	
	public function up()
	{
		$modules = array(
			'keywords'		=> 'data',
			'maintenance'	=> 'data',
			'navigation'	=> 'structure',
			'redirects'		=> 'structure',
			'templates'		=> 'structure',
			'themes'		=> 'structure',
			'variables'		=> 'data',
		);

		foreach ($modules as $module => $menu)
		{
			$this->db
				->where('slug', $module)
				->set('menu', $menu)
				->update('modules');
		}
	
		$this->db
			->where('menu', 'utilities')
			->set('menu', 'misc')
			->update('modules');

		$this->pyrocache->delete_all('module_m');
	}

	public function down()
	{
		$this->dbforge->drop_table('comment_blacklists');
	}

}
