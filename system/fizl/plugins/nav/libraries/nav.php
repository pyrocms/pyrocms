<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Nav Plugin
 *
 * Allows you to easily define a nav list.
 *
 * @package		Fizl
 * @author		Adam Fairholm (@adamfairholm)
 * @copyright	Copyright (c) 2011-2012, Parse19
 * @license		http://parse19.com/fizl/docs/license.html
 * @link		http://parse19.com/fizl
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

			$line = trim($line);

			if($line[0] == '-'):
	
				// Get the data
				$items = explode(" ", trim($line), 2);
				
				// This has some sort of sub level
				$tmp_level = substr_count(trim($items[0]), '-');
				$link_data = $items[1];
				
			else:
			
				// This is a top level item
				$tmp_level = 0;
				$link_data = $line;
			
			endif;
							
			// Set the level. Has it changed?
			if($this->level < $tmp_level):
			
				// We are stepping into a deeper level.
				// We need to not close off the LI and
				// start a new ul
				$html .= "\n<ul>\n";
								
			endif;

			if($this->level > $tmp_level):
				
				// We are stepping into a shallower level.
				// Close off the ul and the li and 
				$html .= "</li>\n</ul>\n";
				
			endif;
			
			$html .= '<li class="';
			
			// Looks like we just a single item
			$pieces = explode('|', trim($link_data), 2);
			
			// Get the current string
			$uri_segs = explode('/', $pieces[0]);
			
			$popped_uri = array_slice($this->CI->uri->segment_array(), 0, count($uri_segs));
			
			// Is the current link?
			if($pieces[0] == implode('/', $popped_uri)):
			
				$html .= trim($this->get_param('current_class', 'current')).' ';
			
			endif;
			
			// Creat link
			$html .= 'level_'.$tmp_level.'"><a href="';
						
			if(strpos($pieces[0], 'http://')!==FALSE or strpos($pieces[0], 'https://')!==FALSE):
			
				$html .= $pieces[0];
			
			else:
			
				$html .= site_url($pieces[0]);
			
			endif;

			$html .= '">'.$pieces[1].'</a>';
			
			// Does is the next l
			if(isset($lines[$key+1]) and trim($lines[$key+1][0]) != '-') 
				$html .= "</li>\n";

			$this->level = $tmp_level;
							
		endforeach;
		
		return $html .= "</li>\n</ul>";
	}
		
}

/* End of file nav.php */