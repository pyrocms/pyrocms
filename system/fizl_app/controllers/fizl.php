<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Fizzle
 *
 * Simple tool for making simple sites.
 *
 * @package		Fizl
 * @author		Adam Fairholm (@adamfairholm)
 * @copyright	Copyright (c) 2011, 1bit
 * @license		http://1bitapps.com/fizl/license.html
 * @link		http://1bitapps.com/fizl
 */
class Fizl extends CI_Controller {

	public $vars = array();

	/**
	 * Main Fizl Function
	 *
	 * Routes and processes all page requests
	 *
	 * @access	public
	 * @return	void
	 */
	public function _remap()
	{
		$this->load->library('Simpletags');
		$this->load->library('Parser');
		$this->load->library('Plugin');

		$this->load->helper(array('file', 'url'));

		// -------------------------------------
		// Configs
		// -------------------------------------
		// We do this first since we need this
		// data
		// -------------------------------------
		
		$this->vars = array(
			'segment_1'		=> $this->uri->segment(1),
			'segment_2'		=> $this->uri->segment(2),
			'segment_3'		=> $this->uri->segment(3),
			'segment_4'		=> $this->uri->segment(4),
			'segment_5'		=> $this->uri->segment(5),
			'segment_6'		=> $this->uri->segment(6),
			'segment_7'		=> $this->uri->segment(7),
			'current_year'	=> date('Y'),
			'current_url'	=> current_url(),
			'site_url'		=> site_url(),
			'base_url'		=> $this->config->item('base_url')
		);

		// Get them configs
		$raw_configs = read_file(FCPATH.'fizl/config.txt');
		
		// Parse the configs
		$lines = explode("\n", $raw_configs);
		
		foreach($lines as $line):
		
			$line = trim($line);

			if($line == '' or $line[0] == '#') continue;
			
			$items = explode(':', $line, 2);
			
			if(count($items) != 2) continue;
		
			// Set the var
			$this->vars[trim($items[0])] = trim($items[1]);
			
			// Set configs so eeeeveryone can use them
			$this->config->set_item(trim($items[0]), trim($items[1]));
		
		endforeach;
		
		// Set the site folder as a constant
		define('SITE_FOLDER', $this->vars['site_folder']);

		// -------------------------------------
		// Look for page
		// -------------------------------------
	
		// So... does this file exist?
		$segments = $this->uri->segment_array();
		
		$is_home = FALSE;
		
		// Blank mean it's the home page, ya hurd?
		if(empty($segments)):
		
			$is_home = TRUE;
		
			$segments = array('index');
			
		endif;

		// Is this a folder? If so we are looking for the index
		// file in the folder.
		if(is_dir(SITE_FOLDER.'/'.implode('/', $segments))):
		
			$segments[] = 'index';
		
		endif;
		
		// Okay let's take a look at the last element
		$file = array_pop($segments);
				
		// We just want two things
		$file_elems = array_slice(explode('.', $file), 0, 2);
		
		// No file ext is an html
		if(count($file_elems) == 1):
		
			$file_elems[1] = 'html';
		
		endif;
		
		// Turn the URL into a file path
		$file_path = SITE_FOLDER;
		
		if($segments) $file_path .= '/'.implode('/', $segments);
		
		$file_path .= '/'.implode('.', $file_elems);
		
		// -------------------------------------
		// Set headers
		// -------------------------------------
				
		if(!file_exists($file_path)):
		
			// No file for this? Set us a 404
			header('HTTP/1.0 404 Not Found');
						
			$is_404 = true;
			
		else:

			$is_404 = false;

			switch($file_elems[1]):
			
				case 'html':
					$this->output->set_content_type('text/html');
					break;
				default:
					$this->output->set_content_type('text/html');						
			
			endswitch;
		
		endif;
		
		// -------------------------------------
		// Set Template	
		// -------------------------------------

		$template = false;

		$template_path = 'fizl/templates';

		if($is_home and is_file($template_path.'/home.html')):
		
			$template = read_file($template_path.'/home.html');
			
		elseif($is_404):
		
			$template = read_file('fizl/standards/404.html');
			
		// Do we have a template for this folder?
		elseif(is_file($template_path.'/'.implode('_', $segments).'.html')):
		
			$template = read_file($template_path.'/'.implode('_', $segments).'.html');
			
		elseif(is_file($template_path.'/sub.html')):
		
			$template = read_file($template_path.'/sub.html');
		
		endif;
		
		// -------------------------------------
		// Get Content	
		// -------------------------------------
		
		if(!$is_404):
				
			$content = read_file($file_path);
	
			if($template):
	
				$content = $this->parser->parse_string($template, array('content'=>$content), TRUE);
				
			endif;
		
		else:
		
			$content = $template;
		
		endif;

		// -------------------------------------
		// Parse Embeds	
		// -------------------------------------
			
		$this->simpletags->set_trigger('embed');
		
		$compiled = $this->simpletags->parse($content, array(), array($this, 'embed_callback'));

		// -------------------------------------
		// Parse Variables	
		// -------------------------------------
			
		$this->simpletags->set_trigger('var');
		
		$compiled = $this->simpletags->parse($compiled['content'], array(), array($this, 'var_callback'));

		// -------------------------------------
		// Parse Links	
		// -------------------------------------
			
		$this->simpletags->set_trigger('link');
		
		$compiled = $this->simpletags->parse($compiled['content'], array(), array($this, 'link_callback'));

		// -------------------------------------
		// Parse Plugins	
		// -------------------------------------

		$this->simpletags->set_trigger('fiz');
		
		$compiled = $this->simpletags->parse($compiled['content'], array(), array($this, 'plugin_callback'));
				
		// -------------------------------------
		// Return Content	
		// -------------------------------------

		echo $this->parser->parse_string($compiled['content'], $this->vars, TRUE);
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Parse embeds
	 *
	 * @access	public
	 * @param	array
	 * @return 	string
	 */
	public function embed_callback($tag_data)
	{
		if(!isset($tag_data['attributes']['file'])) return;
		
		// Load the file. Always an .html
		$embed_content = read_file(FCPATH.'fizl/embeds/'.$tag_data['attributes']['file'].'.html');
		
		// Parse passed variables
		// We want all of them except 'file'
		unset($tag_data['attributes']['file']);
		
		foreach($tag_data['attributes'] as $key => $val):
		
			$embed_content = str_replace('{'.$key.'}', $val, $embed_content);
		
		endforeach;
		
		return $embed_content;
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Parse Links
	 *
	 * @access	public
	 * @param	array
	 * @return 	string
	 */
	public function link_callback($tag_data)
	{
		if(!isset($tag_data['attributes']['path'])) return;
		
		return site_url($tag_data['attributes']['path']);
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Parse Vars
	 *
	 * All we really do is just get rid of them and put them ino
	 *
	 * @access	public
	 * @param	array
	 * @return 	string
	 */
	public function var_callback($tag_data)
	{
		if(isset($tag_data['attributes']['name']) and isset($tag_data['attributes']['val'])):
		
			$this->vars[trim($tag_data['attributes']['name'])] = trim($tag_data['attributes']['val']);

			$this->config->set_item(trim($tag_data['attributes']['name']), trim($tag_data['attributes']['val']));
		
		endif;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Parse Plugin
	 *
	 * @access	public
	 * @param	array
	 * @return 	string
	 */
	function plugin_callback($tag_data)
	{
		$plugin = $tag_data['segments'][1];

		$call = false;

		if(isset($tag_data['segments'][2])):
		
			$call = $tag_data['segments'][2];
		
		endif;
		
		// We'll use a function with the same name as the
		// call if one is not specified
		if(!$call) $call = $plugin;
		
		// Look for the plugin file
		if(is_dir(APPPATH.'third_party/'.$plugin)):
		
			$this->load->add_package_path(APPPATH.'third_party/'.$plugin);
			
		elseif(is_dir(FCPATH.'fizl/plugins/'.$plugin)):
			
			$this->load->add_package_path(FCPATH.'fizl/plugins/'.$plugin);
			
		else:
		
			return;
		
		endif;
		
		$this->load->library($plugin);
		
		// Add our params to the lib
		foreach($tag_data['attributes'] as $key => $val):
		
			$this->$plugin->$key = $val;
		
		endforeach;
		
		// Add content to the lib
		$this->$plugin->tag_content = $tag_data['content'];
		
		return $this->$plugin->$call();
	}
}

/* End of file fizl.php */