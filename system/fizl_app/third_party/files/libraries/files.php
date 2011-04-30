<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Files Plugin
 *
 * Allows you to list files.
 *
 * @package		Fizl
 * @author		Adam Fairholm (@adamfairholm)
 * @copyright	Copyright (c) 2011, 1bit
 * @license		http://1bitapps.com/fizl/license.html
 * @link		http://1bitapps.com/fizl
 */
class Files extends Plugin {

	/**
	 * List pages in a folder
	 */
	public function pages()
	{
		$this->CI = get_instance();
	
		// Get the folder
		if(!$url = $this->get_param('url', FALSE)):
		
			return;
		
		endif;
		
		$url = ltrim($url, '/');

		// Check this out.
		if(!is_dir('site/'.$url)) return;
	
		$this->CI->load->helper('directory');
		
		$map = directory_map('site/'.$url, 1);
				
		// Do we want to remove the index file?
		if($this->get_param('include_index', 'no') == 'no'):
	
			if($key = array_search('index.html', $map)):
			
				unset($map[$key]);
			
			endif;
			
		endif;

		$vars = array();
		$count = 0;
		// Run through each page and get some info
		foreach($map as $file_name):
		
			// Create guessed name
			$name = str_replace('.html', '', $file_name);
			$name = str_replace(array('-', '.', '_'), ' ', $name);
			$vars['pages'][$count]['guessed_name'] = ucwords($name);
			$vars['pages'][$count]['uri'] = $url.'/'.str_replace('.html', '', $file_name);
			$vars['pages'][$count]['url'] = site_url($url.'/'.str_replace('.html', '', $file_name));
		
			$count++;
		
		endforeach;
		
		// Total
		$vars['total'] = count($map);
		
		return $this->CI->parser->parse_string($this->tag_content, $vars, TRUE);	
	}
			
}

/* End of file pages.php */