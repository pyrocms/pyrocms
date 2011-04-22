<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fizzle extends CI_Controller {

	/**
	 * Fizzle
	 *
	 */
	public function _remap()
	{
		$this->load->library('Simpletags');
	
		// So... does this file exist?
		$segments = $this->uri->segment_array();
		
		// Blank mean index, ya hurd?
		if(empty($segments)):
		
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
		
		// Set headers.
		switch($file_elems[1]):
		
			case 'html':
				$this->output->set_content_type('text/html');
				break;
			default:
				$this->output->set_content_type('text/html');						
		
		endswitch;
		
		$this->load->helper('file');
		
		$content = read_file($file_path);

		// -------------------------------------
		// Parse Embeds	
		// -------------------------------------
			
		$this->simpletags->set_trigger('embed');
		
		$compiled = $this->simpletags->parse($content, array(), array($this, 'embed_callback'));
		
		// -------------------------------------
		// Return Content	
		// -------------------------------------
		
		echo $compiled['content'];
	}
	
	public function embed_callback($tag_data)
	{
		print_r($tag_data);
		
		if(!isset($tag_data['attributes']['file'])) return;
		
		// Load the file. Always an .html
		$embed_content = read_file('embed/'.$tag_data['attributes']['file'].'.html');
		
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