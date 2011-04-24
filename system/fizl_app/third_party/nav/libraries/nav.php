<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Nav Plugin
 *
 * Allows you to easily define a nav list.
 *
 * @package		Fizl
 * @author		Adam Fairholm (@adamfairholm)
 * @copyright	Copyright (c) 2011, 1bit
 * @license		http://1bitapps.com/fizl/license.html
 * @link		http://1bitapps.com/fizl
 */
class Nav extends Plugin {

	public $level;

	/**
	 * Parse the nav list
	 */
	public function nav()
	{
		$this->CI = get_instance();
	
		if(!$content = trim($this->tag_content)) return;
	
		// Break into lines
		$lines = explode("\n", $content);
		
		// We are going to put things into an
		// an array first
		$nav_arr = array();
		
		$this->level = 0;
		
		$html = '<ul class="'.$this->get_param('ul_class', 'nav').'">'."\n";
		
		foreach($lines as $key => $line):

			// Get the data
			$items = explode(" ", trim($line));
			
			// Count the level we're at.
			if(count($items) == 1):
			
				// This is a top level item
				$tmp_level = 0;
				$link_data = $line;
				
			else:
			
				// This has some sort of sub level
				$tmp_level = substr_count(trim($items[0]), '-');
				$link_data = $items[1];
			
			endif;
				
			// Set the level. Has it changed?
			if($this->level < $tmp_level):
			
				// We are stepping into a deeper level.
				// We need to not close off the LI and
				// start a new ul
				$html .= "\n<ul>\n";
								
			endif;
			
			$html .= '<li class="';
			
			// Looks like we just a single item
			$pieces = explode('|', $link_data);
			
			// Is the current link?
			if($pieces[0] == $this->CI->uri->uri_string()):
			
				$html .= trim($this->get_param('current_class', 'current')).' ';
			
			endif;

			$html .= 'level_'.$tmp_level.'"><a href="'.site_url($pieces[0]).'">'.$pieces[1].'</a>';

			if($this->level < $tmp_level):
				
				// We are stepping into a shallower level.
				// Close off the ul and the li and 
				$html .= "</li>\n</ul>\n";
				
			endif;
			
			// Does is the next l
			if(isset($lines[$key+1]) and trim($lines[$key+1][0]) != '-') 
				$html .= "</li>\n";

			$this->level = $tmp_level;
							
		endforeach;
		
		return $html .= "</li>\n</ul>";
	}
		
	function create_link($data)
	{
	}
	
}

/* End of file format.php */