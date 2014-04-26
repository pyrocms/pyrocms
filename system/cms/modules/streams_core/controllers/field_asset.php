<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Field Asset Controller
 *
 * @package		PyroStreams
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2011 - 2013, PyroCMS
 */
class Field_asset extends Public_Controller {

	/**
	 * The field type for the
	 * field asset.
	 *
	 * @access	public
	 * @var		object
	 */
	public $field_type;

	// --------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();
		
		// Turn off the OP for these assets.
		$this->output->enable_profiler(false);
		    
		$this->load->library('streams_core/Type');
		
		$this->load->helper('file');
	}
 
	// --------------------------------------------------------------------------
   
	/**
	 * Remap based on URL call
	 */
	public function _remap($method)
	{
		// Check the type
		$type = $this->uri->segment(4);
		
		$this->field_type = $this->type->load_single_type($type);
		
		// Check the file
		$file = $this->uri->segment(5);
		
		if (trim($file) == '') return null;
		
		$file = $this->security->sanitize_filename($file);
		
		// Call the method
		if ($method == 'css')
		{
			$this->_css($file);
		}
		elseif ($method == 'js')
		{
			$this->_js($file);
		}
	}

	// --------------------------------------------------------------------------

    /**
     * Pull CSS
     *
     * @access	private
     * @param	string - css file name
     * @return	void
     */
    private function _css($file)
    {
    	header("Content-Type: text/css");
    	
    	$file = FCPATH.$this->field_type->ft_path.'css/'.$file;
    	
   	 	if ( ! is_file($file)) return null;
   	 	
		echo read_file($file);   	 	
    }
  
  	// --------------------------------------------------------------------------

    /**
     * Pull JS
     *
     * @access	private
     * @param	string - css file name
     * @return	void
     */
    private function _js($file)
    {
    	header("Content-Type: text/javascript");
    	
    	$file = $this->field_type->ft_path.'js/'.$file;
    	
   	 	if ( ! is_file($file)) return null;
   	 	
		echo read_file($file);   	 	
    }
  
}