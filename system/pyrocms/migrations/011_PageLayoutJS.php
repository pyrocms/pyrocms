<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Pagelayoutjs extends Migration {
	
	function up() 
	{
		$add = array(
				'js' => array(
								'type' => 'text',
								'null' => FALSE,
								'collation' => 'utf8_unicode_ci'
							)
				);
			
		$this->dbforge->add_column('page_layouts', $add);		
	}
		
	

	function down() 
	{
	}
}
