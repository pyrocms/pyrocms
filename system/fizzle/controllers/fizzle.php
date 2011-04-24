<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fizzle extends CI_Controller {

	/**
	 * Fizzle
	 *
	 */
	public function _remap()
	{
		$this->load->library('Simpletags');
		$this->load->library('Parser');

		$this->load->helper(array('file', 'url'));
	
		// So... does this file exist?
		$segments = $this->uri->segment_array();
		
		$is_home = FALSE;
		
		// Blank mean it's the home page, ya hurd?
		if(empty($segments)):
		
			$is_home = TRUE;
		
			$segments = array('index');
			
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
		$file_path = 'site/'.implode('/', $segments).'/'.implode('.', $file_elems);
		
		// Does this exist?
		if(!file_exists($file_path)):
		
			show_404();
		
		endif;
		
		// -------------------------------------
		// Set Headers	
		// -------------------------------------

		switch($file_elems[1]):
		
			case 'html':
				$this->output->set_content_type('text/html');
				break;
			default:
				$this->output->set_content_type('text/html');						
		
		endswitch;

		// -------------------------------------
		// Set Template	
		// -------------------------------------

		$template = false;

		$template_path = 'fizzle/templates';

		if($is_home and is_file($template_path.'/home.html')):
		
			$template = read_file($template_path.'/home.html');
			
		elseif(is_file($template_path.'/sub.html')):
		
			$template = read_file($template_path.'/sub.html');
		
		endif;
		
		// -------------------------------------
		// Get Content	
		// -------------------------------------
				
		$content = read_file($file_path);

		if($template):

			$content = $this->parser->parse_string($template, array('content'=>$content), TRUE);
			
		endif;

		// -------------------------------------
		// Parse Embeds	
		// -------------------------------------
			
		$this->simpletags->set_trigger('embed');
		
		$compiled = $this->simpletags->parse($content, array(), array($this, 'embed_callback'));

		// -------------------------------------
		// Parse Template	
		// -------------------------------------
		
		// Standards
		$vars = array(
			'segment_1'		=> $this->uri->segment(1),
			'segment_2'		=> $this->uri->segment(2),
			'segment_3'		=> $this->uri->segment(3),
			'segment_4'		=> $this->uri->segment(4),
			'segment_5'		=> $this->uri->segment(5),
			'segment_6'		=> $this->uri->segment(6),
			'segment_7'		=> $this->uri->segment(7),
			'current_url'	=> current_url(),
			'site_url'		=> site_url()
		);

		// Get them configs
		$raw_configs = read_file(FCPATH.'fizzle/config.txt');
		
		// Parse the configs
		$lines = explode("\n", $raw_configs);
		
		foreach($lines as $line):
		
			$line = trim($line);
			
			$items = explode(':', $line);
			
			if(count($items) != 2) continue;
		
			$vars[trim($items[0])] = trim($items[1]);
		
		endforeach;
				
		$page = $this->parser->parse_string($compiled['content'], $vars, TRUE);
		
		// -------------------------------------
		// Return Content	
		// -------------------------------------
		
		echo $page;
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
		$embed_content = read_file(FCPATH.'fizzle/embeds/'.$tag_data['attributes']['file'].'.html');
		
		// Parse passed variables
		// We want all of them except 'file'
		unset($tag_data['attributes']['file']);
		
		foreach($tag_data['attributes'] as $key => $val):
		
			$embed_content = str_replace('{'.$key.'}', $val, $embed_content);
		
		endforeach;
		
		return $embed_content;
	}
}

/* End of file fizzle.php */
/* Location: ./application/controllers/fizzle.php */