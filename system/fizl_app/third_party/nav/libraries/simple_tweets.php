<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Simple Tweets CodeIgniter Library
 *
 * Caches and displays Tweets from a user. Very simple.
 *
 * @copyright	Copyright (c) 2011, Adam Fairholm
 * @author		Adam Fairholm (@adamfairholm)
 * @link		https://github.com/adamfairholm/CI-Simple-Tweets
 */
class Simple_tweets
{
	/**
	 * Handle of the Twitter user we are pulling tweets for.
	 */
	public $twitter_user;
	
	/**
	 * Number of Tweets tp pull
	 */
	public $number_of_tweets;
	
	/**
	 * Cache directory
	 */
	public $cache_dir;
	
	/**
	 * Our hash for the cache file
	 */
	private $hash;
	
	/**
	 * Just make this readable by strtotime
	 */
	public $cache_limit = '+15 minutes';

	/**
	 * These are items are NOT going to strip out of the 
	 * Individual tweets array
	 */
	public $user_tweet_info 		= array('screen_name', 'name', 'url', 'profile_image_url');

	/**
	 * Constructor
	 *
	 * @access	public
	 * @return	void
	 */
	function __construct()
	{	
		$this->CI = get_instance();
		
		// Set cache dir
		$this->cache_dir = APPPATH.'cache/simple_tweets/';

		$this->CI->load->helper('file');
	}

	// --------------------------------------------------------------------	
	
	/**
	 * Get tweets from a user.
	 *
	 * @access	public
	 * @param	array
	 * @return 	array
	 */
	function get_tweets($twitter_user = FALSE, $number_of_tweets = FALSE)
	{	
		// -------------------------------------
		// Data setup and Tweet grabbing
		// -------------------------------------

		// Set some data
		if($twitter_user) $this->twitter_user = $twitter_user;
		
		if(is_numeric($number_of_tweets)) $this->number_of_tweets = $number_of_tweets;
		
		// Set the cache file name hash
		$this->hash = sha1(md5($this->twitter_user));
	
		// Grab the tweets
		if(!$tweets = $this->read_cache_file()):
		
			$tweets = $this->pull_live_tweets();
		
		endif;
		
		// Error
		if( $tweets === FALSE || empty($tweets) ) return FALSE;
		
		// -------------------------------------
		// Tweet Processing
		// -------------------------------------
		// Start by grabbing the 
		// Twitter data for user from 1st tweet
		// -------------------------------------

		$tweeter = array();

		if(isset($tweets[0]->user)):
		
			foreach( $tweets[0]->user as $user_key => $user_value ):
			
				$tweeter[$user_key] = $user_value;
			
			endforeach;
		
		endif;
		
		// -------------------------------------
		// Go through Twitter data and put
		// tweets into an array
		// -------------------------------------	
			
		$twitter_data = array();
		
		$count = 0;
			
		foreach( $tweets as $tweet_obj ):
		
			foreach( $tweet_obj as $key => $value ):
			
				if( ! is_object($value) ){
			
					$twitter_data[$count][$key] = $value;
				
				}else if( $key == "user" ) {
								
					foreach( $value as $user_key => $user_value ):
					
						if( in_array($user_key, $this->user_tweet_info) ):
					
							$twitter_data[$count]['user_'.$user_key] = $user_value;
					
						endif;
					
					endforeach;
				
				}
			
			endforeach;

			// -------------------------------------			
			// Tweet Link
			// -------------------------------------

			$twitter_data[$count]['tweet_url'] = 'http://twitter.com/'.$twitter_data[$count]['user_screen_name'].'/status/'.$twitter_data[$count]['id_str'];
			
			// -------------------------------------			
			// Username Link
			// -------------------------------------
			
			$twitter_data[$count]['username_link'] = 'http://twitter.com/'.$twitter_data[$count]['user_screen_name'];

			// -------------------------------------			
			// How long ago
			// -------------------------------------
			
			$twitter_data[$count]['how_long_ago'] = $this->_time_since( strtotime($twitter_data[$count]['created_at']) ).' ago';

			// -------------------------------------
			// Text with links and no links
			// -------------------------------------
			
			$text = $twitter_data[$count]['text'];
			
			$twitter_data[$count]['text'] = $this->_process_tweet($twitter_data[$count]['text']);
			
			$twitter_data[$count]['text_no_links'] = $text;

			// -------------------------------------
			
			$count++;
		
		endforeach;
		
		return array('tweets'=>$twitter_data, 'user'=>$tweeter);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Cache data call
	 *
	 * Exists if you want to cache JUST a small piece of data and still
	 * call the render() function
	 *
	 * @access	public
	 * @return	mixed
	 */	
	function read_cache_file($ignore_cache_limit = FALSE)
	{
		$cache_file = $this->cache_dir.$this->hash.'.txt';
			
		// Read cache file.
		if($file = get_file_info($cache_file)):
		
			// We don't have a date.
			if(!isset($file['date'])):
			
				if(!$ignore_cache_limit) return FALSE;
			
			endif;
			
			// Get the contents
			$contents = unserialize(read_file($cache_file));
			
			if($contents and is_array($contents)):
			
				// No need to check the cache limit.
				if($ignore_cache_limit) return $contents;
						
				// Check to see if our cache has expired
				if($file['date'] < strtotime($this->cache_limit)):
		
					// It's still good!
					return $contents;
				
				endif;
				
			endif;
			
		endif;
		
		return FALSE;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Get the tweets and write the cache
	 *
	 * @access	public
	 * @return	mixed
	 */
	public function pull_live_tweets()
	{
		$tweets = json_decode(@file_get_contents('http://twitter.com/statuses/user_timeline/'.$this->twitter_user.'.json?count='.$this->number_of_tweets));
	
		if($tweets):
							
			// If the cache directory doesn't exist, make it.
			if(!@is_dir($this->cache_dir)):
			
				@mkdir($this->cache_dir, DIR_WRITE_MODE);
			
			endif;

			// Write the cache
			write_file($this->cache_dir.$this->hash.'.txt', serialize($tweets));
		
			return $tweets;
			
		else:
			
			// Rather than throw an error, 
			// Just read the cache file.
			return $this->read_cache_file(TRUE);
		
		endif;
	
		return FALSE;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Make tweet have links to people, links, and hashtags
	 *
	 * From: http://www.snipe.net/2009/09/php-twitter-clickable-links/
	 *
	 * @access	private
	 * @param	string
	 * @return	string
	 */
	public function _process_tweet( $tweet_text )
	{
  		$tweet_text = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $tweet_text);
  		$tweet_text = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $tweet_text);
  		$tweet_text = preg_replace("/@(\w+)/", "<a href=\"http://www.twitter.com/\\1\" target=\"_blank\">@\\1</a>", $tweet_text);
		$tweet_text = preg_replace("/#(\w+)/", "<a href=\"http://search.twitter.com/search?q=\\1\" target=\"_blank\">#\\1</a>", $tweet_text);
	
		return $tweet_text;
	}

	// --------------------------------------------------------------------------

	/**
	 * Works out the time since the entry post, takes a an argument in unix time (seconds)
	 * 
	 * From: http://www.dreamincode.net/code/snippet86.htm
	 *
	 * @access	public
	 * @param	string
	 * @return 	string
	 */
	public function _time_since($original)
	{
	    $chunks = array(
	        array(60 * 60 * 24 * 365 , 'year'),
	        array(60 * 60 * 24 * 30 , 'month'),
	        array(60 * 60 * 24 * 7, 'week'),
	        array(60 * 60 * 24 , 'day'),
	        array(60 * 60 , 'hour'),
	        array(60 , 'minute'),
	    );
    
    	$today = time();
		$since = $today - $original;
    
	    // $j saves performing the count function each time around the loop
	    for ($i = 0, $j = count($chunks); $i < $j; $i++) {
	        
	        $seconds = $chunks[$i][0];
	        $name = $chunks[$i][1];
	        
	        // finding the biggest chunk (if the chunk fits, break)
	        if (($count = floor($since / $seconds)) != 0) {
	            // DEBUG print "<!-- It's $name -->\n";
	            break;
	        }
	    }
    
	    $print = ($count == 1) ? '1 '.$name : "$count {$name}s";
	    
	    if ($i + 1 < $j) {
	        // now getting the second item
	        $seconds2 = $chunks[$i + 1][0];
	        $name2 = $chunks[$i + 1][1];
	        
	        // add second item if it's greater than 0
	        if (($count2 = floor(($since - ($seconds * $count)) / $seconds2)) != 0) {
	            $print .= ($count2 == 1) ? ', 1 '.$name2 : ", $count2 {$name2}s";
	        }
	    }
	    
	    return $print;
	}
}

/* End of file Simple_tweets.php */