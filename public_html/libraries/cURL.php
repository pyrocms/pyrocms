<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author Philip Sturgeon
 * @created 9 Dec 2008
 */

class cURL {
	
    private $CI;                // CodeIgniter instance
    
    private $session;           // Contains the cURL handler for a session
    private $url;               // URL of the session
    private $options = array(); // Populates curl_setopt_array
    
    public $error_code;         // Error code returned as an int
    public $error_string;       // Error message returned as a string
    public $info;               // Returned after request (elapsed time, etc)
    
    function __construct() {
        $this->CI =& get_instance();
        log_message('debug', 'cURL Class Initialized');
        
        if (!function_exists('curl_init')) {
            log_message('error', 'cURL Class - PHP was not built with --with-curl, rebuild PHP to use cURL.') ;
        }
    }
 
    // Return a get request results
    public function get($url = '', $options = array()) {

        // If a URL is provided, create new session
        if(!empty($url)) $this->create($url);

        // Add in the specific options provided
        $this->options($options);

        return $this->execute();
    }
 
    // Send a post request on its way with optional parameters (and get output)
    // $url = '', $params = array(), $options = array()
    //   or
    // $parays = array()
    public function post() { 
    	
        // Default values
        $url = '';
        $params = array();
        $options = array();
        
        // How many parameters have been passed?
        switch(count($args = func_get_args())) {
            
            // If they have JUST passed post parameters
            default:
            case 1:
                $advance_mode = TRUE;
                $params = $args[0];
            break;
            
            // They have passed several (up to 3) parameters
            case 2:
            case 3:
                $advance_mode = FALSE;
                if(isset($args[0])) $url = $args[0];
                if(isset($args[1])) $params = $args[1];
                if(isset($args[2])) $options = $args[2];
            break;
        }

        // If a URL is provided, create new session
        if(!empty($url)) $this->create($url);
        
        // If its an array (instead of a query string) then format it correctly
        if(is_array($params)) {
            $params = http_build_query($params);
        }
        
        // Add in the specific options provided
        $this->options($options);
        
        $this->options[CURLOPT_POST] = TRUE;
        $this->options[CURLOPT_POSTFIELDS] = $params;
        
        // We are in simple mode, they have only called this method, so return the output
        if(!$advance_mode) {
            return $this->execute();
        }
    }
    
    public function set_cookies($params = array()) {
        
        if(is_array($params)) {
            $params = http_build_query($params);
        }
        
        $this->option(CURLOPT_COOKIE, $params);
        return $this;
    }
    
    public function http_login($username = '', $password = '') {
        $this->option(CURLOPT_USERPWD, $username.':'.$password);
        return $this;
    }
    
    public function proxy($url = '', $port = 80) {
        
        $this->option(CURLOPT_HTTPPROXYTUNNEL. TRUE);
        $this->option(CURLOPT_PROXY, $url.':'. 80);
        return $this;
    }
    
    public function proxy_login($username = '', $password = '') {
        $this->option(CURLOPT_PROXYUSERPWD, $username.':'.$password);
        return $this;
    }
    
    // Start a session from a URL
    public function create($url) {
        
        // Reset the class
        $this->set_defaults();

        // If no a protocol in URL, assume its a CI link
        if(!preg_match('!^\w+://! i', $url)) {
        	$this->CI->load->helper('url');
            $url = site_url($url);
        }
        
        $this->url = $url;
        $this->session = curl_init($this->url);
        
        return $this;
    }
    
    public function options($options = array()) {
    	
        // Merge options in with the rest - done as array_merge() does not overwrite numeric keys
        foreach($options as $option_code => $option_value) {
            $this->option($option_code, $option_value);
        }
        unset($option_code, $option_value);

        // Set all options provided
        curl_setopt_array($this->session, $this->options);
        
        return $this;
    }
    
    public function option($code, $value) {
    	$this->options[$code] = $value;
        return $this;
    }
    
    // End a session and return the results
    public function execute() {
        
        // Set two default options, and merge any extra ones in
        if(!isset($this->options[CURLOPT_TIMEOUT]))           $this->options[CURLOPT_TIMEOUT] = 30;
        if(!isset($this->options[CURLOPT_RETURNTRANSFER]))    $this->options[CURLOPT_RETURNTRANSFER] = TRUE;
        if(!isset($this->options[CURLOPT_FOLLOWLOCATION]))    $this->options[CURLOPT_FOLLOWLOCATION] = TRUE;
        if(!isset($this->options[CURLOPT_FAILONERROR]))       $this->options[CURLOPT_FAILONERROR] = TRUE;

        $this->options();

        // Execute the request
        $return = curl_exec($this->session);
        
        // Request failed
        if($return === FALSE)
        {
            $this->error_code = curl_errno($this->session);
            $this->error_string = curl_error($this->session);
            
            curl_close($this->session);
            return FALSE;
        
        // Request successful
        } else {

            $this->info = curl_getinfo($this->session);
            
            curl_close($this->session);
            return $return;
        }
        
    }
    
    private function set_defaults() {
        $this->info = array();
        $this->options = array();
        $this->error_code = 0;
        $this->error_string = '';
    }
}
// END cURL Class

/* End of file cURL.php */
/* Location: ./application/libraries/cURL.php */
?>