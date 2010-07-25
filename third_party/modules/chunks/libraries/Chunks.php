<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PyroChunks Chunks Library
 *
 * @package  	PyroCMS
 * @subpackage  PyroChunks
 * @category  	Libraries
 * @author  	Adam Fairholm
 */ 

class Chunks
{
	private $var_chunks = array();

	function __construct()
	{
		$this->ci =& get_instance();

		// -------------------------------------
		// Get chunks
		// -------------------------------------
		
		$this->ci->load->model('chunks/chunks_m');
		
		$chunks = $this->ci->chunks_m->get_chunks();
		
		// -------------------------------------
		// Prep chunks
		// -------------------------------------

		foreach( $chunks as $chunk ):
		
				$this->var_chunks[$chunk->slug] = $this->ci->chunks_m->process_type( $chunk->type, $chunk->content, 'outgoing' );
			
		endforeach;
		
		// -------------------------------------
		// Commit chunks to ci vars
		// -------------------------------------
		
		$this->ci->load->vars('chunk', $this->var_chunks);
	}
}

/* End of file Chunks.php */
/* Location: ./third_party/modules/chunks/libraries/Chunks.php */