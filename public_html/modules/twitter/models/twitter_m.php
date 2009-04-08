<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Twitter_m extends Model {

	private $CI;
	
	function __construct()
	{
		parent::Model();
		
		$this->CI =& get_instance();
		$this->CI->load->library('twitter_lib');
		
		// TODO: Replace this with settings
	    $this->CI->load->module_config('twitter', 'twitter');
	    
		// Authenticate the user once per page load
		$this->CI->twitter_lib->auth($this->CI->settings->item('twitter_username'), $this->CI->settings->item('twitter_password'));
		
	}
	
	// Just call whatever was asked for with whatever it was given
	function __call($method, $arguments)
	{
		return call_user_func_array(array($this->CI->twitter_lib, $method), $arguments);
	}
	
}
?>