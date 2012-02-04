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
class Plugin_nav extends Plugin {

	public $level;

	/**
	 * Nav
	 *
	 * Parse a manual nav list
	 *
	 * The auto function is much better now, but this
	 * can still be useful if you want to use it.
	 *
	 * @access	public
	 * @return	string
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

	// --------------------------------------------------------------------------   

	/**
	 * Auto Nav
	 *
	 * Attempts to create a nav from
	 * the directory tree.
	 *
	 * @access	public
	 * @return	string
	 */
	public function auto()
	{
		$this->CI = get_instance();

		$start = $this->get_param('start', '/');
		$depth = $this->get_param('depth', 2);
		$remove_index = $this->get_param('remove_index', 'yes');
		
		$this->remove_index = ($remove_index == 'yes') ? TRUE : FALSE;
		
		// We need a start
		if ( ! $start) return NULL;
		
		if ($start == '/')
		{
			$segs = array();
		}
		else
		{
			$segs = explode('/', $start);
		}
		
		$this->CI->load->helper(array('file', 'directory'));
		
		$this->start = $start;
						
		$map = directory_map(FCPATH.$this->CI->vars['site_folder'].'/'.$start, $depth);
		
		if( ! $map) return NULL;

		// ----------------------------------
		// Parse Directory Map into array
		// ----------------------------------
				
		$this->stack = $segs;
		$new_map = $this->_parse_map_row($map);
		
		// ----------------------------------
		// Create the UL from the array
		// ----------------------------------
		
		$this->depth = 0;
		$this->stack = $segs;
		
		$this->html = '';
		$this->create_ul($new_map);
		
		return $this->html;
	}

	// --------------------------------------------------------------------------   
	
	/**
	 * Parse Map Row
	 *
	 * Parse a directory map row into
	 * a tree structure for the UL function.
	 *
	 * @access	private
	 * @param	array - directory map
	 * @return	array
	 */
	private function _parse_map_row($map)
	{
		$new_map = array();
		$order = FALSE;
		
		// First, do we have an order.txt? If so, let's load
		// it up into an array.
		if (in_array('order.txt', $map))
		{					
			$path = implode('/', array_merge(array(FCPATH.$this->CI->vars['site_folder']), $this->stack));
			
			if (is_file($path.'/order.txt'))
			{
				$order = trim(read_file($path.'/order.txt'));
				
				// chop it up
				$ord = explode("\n", $order);
								
				foreach ($ord as $order_string)
				{
					$pieces = explode('|', $order_string);
					
					if (count($pieces) == 2)
					{
						$file = trim($pieces[0]);
						$name = trim($pieces[1]);
					}
					else
					{
						$file = $order_string;
						$name = $this->guess_name($file);
					}
					
					// Find the map item. If it is an array key,
					// that means it s a folder.
					if (array_key_exists($file, $map))
					{
	        			$this->stack[] = $file;
						
						$new_map[$file] = array_merge(array('_title' => $name), $this->_parse_map_row($map[$file]));
						
						array_pop($this->stack);
					}
					else
					{
						$new_map[$file] = $name;
					}
				}
			}
		}
		else
		{
			foreach($map as $key => $file)
			{
				if (is_array($file))
				{
					$this->stack[] = $key;
				
					$new_map[$key] = array_merge(array('_title' => $this->guess_name($key)), $this->_parse_map_row($map[$key]));
					
					array_pop($this->stack);
				}
				else
				{
					$new_map[$this->remove_extension($file)] = $this->guess_name($file);
				}
			}
			
			if ($this->remove_index === TRUE AND isset($new_map['index']))
			{
				unset($new_map['index']);
			}
		}

		return $new_map;		
	}

	// --------------------------------------------------------------------------   

	/**
	 * Create HTML UL from tree array
	 *
	 * @access	public
	 * @param	array - special tree array
	 * @return	void
	 */
	public function create_ul($tree)
	{
		$this->depth++;
	
		$this->html .= '<ul class="depth_'.$this->depth.'">'."\n";
		
	    foreach($tree as $key => $item)
	    {
	    	if ($key == '_title') continue;
	    
	        if (is_array($item))
	        {
	        	$this->stack[] = $key;

	            $this->html .= '<li><a href="'.site_url(implode('/', $this->stack)).'">'.$item['_title']."</a>\n";
	        	
	            $this->create_ul($item);
	            
	            $this->html .= '</li>';
	            
	        	array_pop($this->stack);
			}
	        else
	       	{
	    		$this->stack[] = $key;
	        
	            $this->html .= "\t".'<li><a href="'.site_url(implode('/', $this->stack)).'">'.$item.'</a></li>'."\n";

	        	array_pop($this->stack);
	        }
		}	        

		$this->html .= '</ul>'."\n\n";

		$this->depth--;
	}

	// --------------------------------------------------------------------------   
	
	/**
	 * Guess Name
	 *
	 * Takes a file name and attempts to generate
	 * a human-readble name from it.
	 *
	 * @access	public
	 * @param	string - file name
	 * @retrun 	string
	 */
	public function guess_name($name)
	{
		$name = $this->remove_extension($name);
	
		$name = str_replace('-', ' ', $name);
		$name = str_replace('_', ' ', $name);
		
		return ucwords($name);
	}

	// --------------------------------------------------------------------------   
	
	/**
	 * Remove the extension from a file
	 *
	 * @access	public
	 * @param	string - file name
	 * @return	string- the extension
	 */
	public function remove_extension($file)
	{
		$segs = explode('.', $file, 2);
		
		if(count($segs) > 1)
		{
			array_pop($segs);
			$file = implode('.', $segs);
		}
		
		return $file;
	}
		
}