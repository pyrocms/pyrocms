<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Updatewidgettitle extends Migration {
	
	function up() 
	{
		$this->migrations->verbose AND print "Update widget title to be not Arabic...";
		
		// Setup Keys
		$this->db
			->set('name', 'a:8:{s:2:"en";s:7:"Widgets";s:2:"de";s:7:"Widgets";s:2:"nl";s:7:"Widgets";s:2:"fr";s:7:"Widgets";s:2:"zh";s:9:"å°çµ„ä»¶";s:2:"it";s:7:"Widgets";s:2:"ru";s:14:"Ð’Ð¸Ð´Ð¶ÐµÑ‚Ñ‹";s:2:"ar";s:12:"Ø§Ù„ÙˆØ¯Ø¬Øª";}')
			->where('slug', 'widgets')
			->update('modules');
	}

	function down() 
	{
	}
}
