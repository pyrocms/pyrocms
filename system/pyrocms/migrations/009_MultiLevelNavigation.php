<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Multilevelnavigation extends Migration {
	
	function up() 
	{
		$add = array(
				'parent' => array(
								'type' => 'int',
								'constraint' => 11,
								'null' => FALSE,
								'default' => 0
							),
				'has_kids' => array(
								'type' => 'tinyint',
								'constraint' => 1,
								'null' => FALSE,
								'default' => 0
							)
				);
			
		$this->dbforge->add_column('navigation_links', $add);		
	}
		
	

	function down() 
	{
	}
}
