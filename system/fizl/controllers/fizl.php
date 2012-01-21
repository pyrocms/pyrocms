<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Fizl
 *
 * Simple tool for making simple sites.
 *
 * @package		Fizl
 * @author		Adam Fairholm (@adamfairholm)
 * @copyright	Copyright (c) 2011-2012, Parse19
 * @license		http://parse19.com/fizl/docs/license.html
 * @link		http://parse19.com/fizl
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
		
		include(APPPATH.'libraries/Lex/Autoloader.php');
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
		$raw_configs = require_once(FCPATH.'config.php');
		
		foreach($config as $key => $var)
		{
			$this->vars[$key] = $var;
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
		if (empty($segments))
		{
			$is_home = TRUE;
			$segments = array('index');
		}	

		// -------------------------------------
		// Find filename
		// -------------------------------------

		// Is this a folder? If so we are looking for the index
		// file in the folder.
		if(is_dir(SITE_FOLDER.'/'.implode('/', $segments)))
		{
			$file = 'index';
		}
		else
		{
			// Okay let's take a look at the last element
			$file = array_pop($segments);
		}
		
		// Turn the URL into a file path
		$file_path = SITE_FOLDER;
		if ($segments) $file_path .= '/'.implode('/', $segments);
								
		// -------------------------------------
		// Find file
		// -------------------------------------

		// We just want two things
		$file_elems = array_slice(explode('.', $file), 0, 2);
				
		$supported_files = array('html', 'md', 'textile');
		$file_ext = NULL;
		
		// If there is a file extenison,
		// we just add it here.
		if(count($file_elems) == 2)
		{
			$file_ext = $file_elems[1];
			$file_path .= '/'.$file;
		}
		else
		{
			// Try and find a file to match
			// our URL
			foreach($supported_files as $ext)
			{
				if (file_exists($file_path.'/'.$file.'.'.$ext))
				{
					$file_ext = $ext;
					$file_path .= '/'.$file.'.'.$ext;
					break;
				}
			}
		}
								
		// -------------------------------------
		// Set headers
		// -------------------------------------
				
		if ( ! $file_ext)
		{
			// No file for this? Set us a 404
			header('HTTP/1.0 404 Not Found');
						
			$is_404 = true;
		}	
		else
		{
			$is_404 = false;

			$this->output->set_content_type('text/html');
		}
		
		// -------------------------------------
		// Set Template	
		// -------------------------------------

		$template = FALSE;

		$template_path = FCPATH.$this->vars['assets_folder'].'/templates/';

		if($is_home and is_file($template_path.'home.html')):
				
			$template = read_file($template_path.'home.html');
			
		elseif($is_404):
		
			$template = read_file($template_path.'404.html');
			
		// Do we have a template for this folder?
		elseif(is_file($template_path.implode('_', $segments).'.html')):
		
			$template = read_file($template_path.implode('_', $segments).'.html');
			
		elseif(is_file($template_path.'sub.html')):
		
			$template = read_file($template_path.'sub.html');
		
		elseif(is_file($template_path.'default.html')):
		
			$template = read_file($template_path.'default.html');
		
		endif;
		
		// -------------------------------------
		// Get Content	
		// -------------------------------------
		
		if ( ! $is_404):
			
			$content = read_file($file_path);
			
			// -------------------------------------
			// Prep content by filetype	
			// -------------------------------------
			// .md and .textile get formatted
			// automatically.
			// -------------------------------------

			if ($file_ext == 'md')
			{
				$content = '{{ format }}'.$content.'{{ /format }}';
			}
			elseif( $file_ext == 'textile')
			{
				$content = '{{ format method="textile" }}'.$content.'{{ /format }}';
			}

			// -------------------------------------
	
			// If we have no template, then
			// we just use the content.
			if ( ! $template)
			{
				$template = $content;
			}
			else
			{
				// If we have a template, let's be
				// sneakty and add in the content
				// variable manually.
				$template = str_replace(array('{{ content }}', '{{content}}'), $content, $template);
			}
			
			// Our content is avialble
			$this->vars['content'] = $content;
		
		endif;
						
		// -------------------------------------
		// Prep and Output Content	
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
		$embed_content = read_file(FCPATH.$this->vars['assets_folder'].'/embeds/'.$file.'.html');
		
		if ( ! $embed_content) return NULL;
		
		if ( ! empty($attributes)) return $embed_content;
	
		$parser = new Lex_Parser();
		$parser->scope_glue(':');
		
		$parser->parse_variables($embed_content, $attributes);
	}

}