<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Variables {

	private $CI;
	
	private $_vars = array();
	
	function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->model('variables/variables_m');
		
		$vars = $this->CI->variables_m->get_all();
		
		foreach($vars as $var)
		{
			$this->_vars[ $var->name ] = $var->data;
		}
		
		// unset($_items);
	}
    
	function __get($name) {
		
		// getting data
        
        if( isset( $this->_vars->$name ) )
        {
            return $name;
        }
        
        return NULL;
         
	}
    
    public function get_all()
    {
    	return $this->_vars;
    }

}