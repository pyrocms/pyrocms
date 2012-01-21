<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Files Plugin
 *
 * Allows you to list files.
 *
 * @package		Fizl
 * @author		Adam Fairholm (@adamfairholm)
 * @copyright	Copyright (c) 2011-2012, Parse19
 * @license		http://parse19.com/fizl/docs/license.html
 * @link		http://parse19.com/fizl
 */
class Files extends Plugin {

	public $vars = array();

	/**
	 * List pages in a folder
	 */
	public function pages()
	{
		$this->CI = get_instance();
		
		$this->CI->load->helper('file');
	
		// Get the folder
		if(!$url = $this->get_param('url', FALSE)):
		
			return;
		
		endif;
		
		$url = ltrim($url, '/');

		// Check this out.
		if(!is_dir('site/'.$url)) return;
	
		$map = get_dir_file_info('site/'.$url, true);
		
		// Do we want to remove the index file?
		if($this->get_param('include_index', 'no') == 'no'):
	
			if(isset($map['index.html'])) unset($map['index.html']);
			
		endif;
				
		$vars = array();
		$count = 0;
		$this->CI->simpletags->set_trigger('var');

		// Run through each page and get some info
		foreach($map as $file_name => $file_info):
		
			// Create guessed name
			$name = str_replace('.html', '', $file_name);
			$name = str_replace(array('-', '.', '_'), ' ', $name);
			
			// Guess the name
			$vars['pages'][$count]['guessed_name'] = ucwords($name);
			$vars['pages'][$count]['uri'] = $url.'/'.str_replace('.html', '', $file_name);
			$vars['pages'][$count]['url'] = site_url($url.'/'.str_replace('.html', '', $file_name));

			// Get the date
			$vars['pages'][$count]['date'] = date($this->CI->config->item('fizl_date_format'), $file_info['date']);
			
			// Get any vars from the item
			if($file_content = read_file($file_info['server_path'])):
			
				if(strpos($file_content, '{var ') !== FALSE):
				
					// Grab them vars
					$this->CI->simpletags->parse($file_content, array(), array($this, 'var_callback'));
					
					$vars['pages'][$count] = array_merge($vars['pages'][$count], $this->vars);
					
					// Clear it
					$this->vars = array();
				
				endif;
			
			endif;
			
			$count++;
		
		endforeach;
		
		// Total
		$vars['total'] = count($map);
		
		return $this->CI->parser->parse_string($this->tag_content, $vars, TRUE);	
	}
	
	function var_callback($tag_data)
	{
		if(isset($tag_data['attributes']['name']) and isset($tag_data['attributes']['val'])):
		
			$this->vars[$tag_data['attributes']['name']] = $tag_data['attributes']['val'];
		
		endif;
	
	}
			
}

/* End of file pages.php */