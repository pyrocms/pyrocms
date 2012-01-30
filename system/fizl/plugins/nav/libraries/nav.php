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

	/**
	 * Attempts to create a nav from
	 * the directory tree.
	 */
	function auto()
	{
		$this->CI = get_instance();

		$start = $this->get_param('start');
		$depth = $this->get_param('depth', 2);
		
		// We need a start
		if(!$start) return;
		
		$segs = explode('/', $start);
		$first = $segs[0];
				
		$this->CI->load->helper('directory');
		
		$this->start = $start;
						
		$map = directory_map(FCPATH.$this->CI->vars['site_folder'].'/'.$start);
		
		if(!$map) return;
		
		// See if we have an order.txt
		if(in_array('order.txt', $map)):
		
			// get the order
			$this->CI->load->helper('file');
			$order = trim(read_file(FCPATH.$this->CI->vars['site_folder'].'/order.txt'));
			
			// chop it up
			$ord = explode("\n", $order);
			
			// Go through and create a new array
			$new_map = array();
			
			foreach($ord as $k => $o):
			
				// Go through, see if the old map value
				// was an array, and if so pass it through
				if(isset($map[$o])):
				
					$new_map[$o] = $map[$o];
					
				else:
				
					$new_map[] = $o;
				
				endif;
			
			endforeach;
			
		else:
		
			$new_map = $map;
					
		endif;
		
		$this->depth = 0;
		$this->stack = $segs;
		
		$this->html = '';
		$this->create_ul($new_map);
		
		return $this->html;
	}

	function create_ul($tree)
	{
		$this->depth++;
	
		$this->html .= '<ul class="depth_'.$this->depth.'">'."\n";
		
	    foreach($tree as $key => $item):
	    
	        if (is_array($item)):
	        	
	        	$this->stack[] = $key;

	        	$item = $this->order_items($item);	        	
	        
	        	$this->html .= '<li>'.$this->guess_name($key)."\n";
	        
	            	$this->create_ul($item);
	            
	            $this->html .= '</li>';
	            
	        	array_pop($this->stack);
	            
	        else:

	    		$this->stack[] = $this->remove_extension($item);
	        
	            $this->html .= "\t".'<li><a href="'.site_url(implode('/', $this->stack)).'">'.$this->guess_name($item).'</a></li>'."\n";

	        	array_pop($this->stack);
	        
	        endif;
	        
	    endforeach;

		$this->html .= '</ul>'."\n\n";

		$this->depth--;
	}
	
	function guess_name($name)
	{
		$name = $this->remove_extension($name);
	
		$name = str_replace('-', ' ', $name);
		$name = str_replace('_', ' ', $name);
		$name = str_replace('.', ' ', $name);
		
		return ucwords($name);
	}
	
	function remove_extension($file)
	{
		$segs = explode('.', $file);
		
		if(count($segs) > 1):
			array_pop($segs);
			$file = implode('.', $segs);
		endif;
		
		return $file;
	}
	
	function order_items($arr)
	{
		// Do we have an order txt file?
		if(!in_array('order.txt', $arr)):
		
			return $arr;
		
		endif;
		
		// If so, remove it and break it down into an array.
		$key = array_search('order.txt', $arr);
		unset($arr[$key]);
		
		$loc = array_merge(array(FCPATH.$this->CI->vars['site_folder'].'/'.$this->start), $this->stack);
		
		$path = implode('/', $loc);
		
		if(!is_file($path.'/order.txt')) return $arr;
		
		$this->CI->load->helper('file');
		
		$order = trim(read_file($path.'/order.txt'));
		
		if(!$order) return $arr;
		
		// Break it down
		$ord = explode("\n", $order);
		
		// Go through and create a new array
		$new_arr = array();
		
		foreach($ord as $o):
		
			$new_arr[] = $o.'.html';
		
		endforeach;
		
		return $new_arr;
	}
		
}

/* End of file nav.php */