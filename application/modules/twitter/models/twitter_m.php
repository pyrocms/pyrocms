<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Twitter_m extends Model {

	private $CI;
	
	function __construct()
	{
		parent::Model();
		
		$this->CI =& get_instance();
		$this->CI->load->library('twitter/twitter_lib');
		
		// Authenticate the user once per page load
		$this->CI->twitter_lib->auth($this->CI->settings->item('twitter_username'), $this->CI->settings->item('twitter_password'));
	}
	
	// Just call whatever was asked for with whatever it was given
	function __call($method, $arguments)
	{
		// Only apply a cache to these methods
		if( in_array($method, array('public_timeline', 'friends_timeline', 'user_timeline', 'show', 'replies', 'friends', 'followers')) )
		{	
			return $this->cache->library('twitter_lib', $method, $arguments, $this->CI->settings->item('twitter_cache') * 60);
		}
		
		// Run as normal without worrying about a cache
		else
		{
			return call_user_func_array(array($this->CI->twitter_lib, $method), $arguments);
		}
	}
	
}
?>