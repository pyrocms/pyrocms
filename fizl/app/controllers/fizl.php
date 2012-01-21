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
		$this->load->library('Plugin');
		$this->load->library('Parse');
		
		include(FCPATH.'fizl/app/libraries/Lex/Autoloader.php');
		Lex_Autoloader::register();
		
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
		
		foreach($lines as $line)
		{
			$line = trim($line);

			if ($line == '' OR $line[0] == '#') continue;
			
			$items = explode(':', $line, 2);
			
			if (count($items) != 2) continue;
		
			// Set the var
			$this->vars[trim($items[0])] = trim($items[1]);
			
			// Set configs so eeeeveryone can use them
			$this->config->set_item(trim($items[0]), trim($items[1]));
		}
		
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
		if(count($file_elems) == 1) $file_elems[1] = 'html';
		
		// Turn the URL into a file path
		$file_path = SITE_FOLDER;
		
		if ($segments) $file_path .= '/'.implode('/', $segments);
		
		$file_path .= '/'.implode('.', $file_elems);
		
		// -------------------------------------
		// Set headers
		// -------------------------------------
				
		if ( ! file_exists($file_path))
		{
			// No file for this? Set us a 404
			header('HTTP/1.0 404 Not Found');
						
			$is_404 = true;
		}	
		else
		{
			$is_404 = false;

			switch ($file_elems[1])
			{
				case 'html':
					$this->output->set_content_type('text/html');
					break;
				default:
					$this->output->set_content_type('text/html');						
			}
		}
		
		// -------------------------------------
		// Set Template	
		// -------------------------------------

		$template = FALSE;

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
	
			/*if($template):
	
				$content = $this->parser->parse_string($template, array('content'=>$content), TRUE);
				
			endif;*/
		
		else:
		
			$content = $template;
		
		endif;
				
		// -------------------------------------
		// Return Content	
		// -------------------------------------
		
		$parser = new Lex_Parser();
		$parser->scope_glue(':');
				
		echo $parser->parse($template, $this->vars, array($this->parse, 'callback'));
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Parse Template Embeds
	 *
	 * @access	public
	 * @param	string - file to embed
	 * @param	array - new vars
	 * @return 	string
	 */
	private function embed($file, $attributes)
	{
		// Load the file. Always an .html
		$embed_content = read_file(FCPATH.'fizl/embeds/'.$file.'.html');
		
		if ( ! $embed_content) return NULL;
		
		if ( ! empty($attributes)) return $embed_content;
	
		$parser = new Lex_Parser();
		$parser->scope_glue(':');
		
		$parser->parse_variables($embed_content, $attributes);
	}

}