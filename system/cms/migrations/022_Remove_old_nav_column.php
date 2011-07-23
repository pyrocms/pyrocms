<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Remove_old_nav_column extends Migration {
	
	function up() 
	{
		$this->dbforge->drop_column('navigation_links', 'has_kids');	
	}
		
	

	function down() 
	{
	}
}
