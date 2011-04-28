<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_RemoveOldNavColumn extends Migration {
	
	function up() 
	{
		$this->dbforge->drop_column('navigation_links', 'has_kids');	
	}
		
	

	function down() 
	{
	}
}
