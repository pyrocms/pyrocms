<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Model to handle Twitter interactions
 *
 * @author 		Ben Edmunds - PyroCMS Dev Team
 * @package 	PyroCMS
 * @subpackage 	Twitter Module
 * @category	Third Party Modules
 */

class Twitter_m extends CI_Model {

	private $CI;
	
	function __construct()
	{
		parent::CI_Model();
		
		$this->CI =& get_instance();
		$this->CI->load->library('twitter/twitter');

		// Try to authenticate
		$auth = $this->CI->twitter->oauth($this->CI->settings->item('twitter_consumer_key'), $this->CI->settings->item('twitter_consumer_key_secret'), $this->CI->settings->item('twitter_access_token'), $this->CI->settings->item('twitter_access_token_secret'));
	}
	
	function __call($method, $arguments)
	{
		// Only apply a cache to these methods
		if( in_array($arguments[0], array('statuses/public_timeline', 'statuses/friends_timeline', 'statuses/user_timeline', 'show', 'replies', 'friends', 'followers')) )
		{	
			return $this->cache->library('twitter', 'call', $arguments, $this->CI->settings->item('twitter_cache') * 60);
		}
		else // Run as normal without worrying about a cache
		{
			if (is_object($this->CI->twitter->$method) && method_exists($this->CI->twitter, $method))
			{
				return call_user_func_array(array($this->CI->twitter, $method), $arguments);
			}
			else // If the method doesn't exist use the call method
			{
				return call_user_func_array(array($this->CI->twitter, 'call'), $arguments);
			}
		}
	}
	
}
?>