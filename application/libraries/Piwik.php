<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author Philip Sturgeon
 * @created 22/05/2009
 */

class Piwik
{
	// CodeIgniter instance
    private $CI;        	
    
	// Points to piwik
    private $url;	
    
    function __construct($url)
    {
        $this->CI =& get_instance();
        log_message('debug', 'Piwiki class initialized');
        
        $this->url = $url;
    }

    // Example url build
    // http://piwik.org/demo/?module=API&method=VisitsSummary.getVisits&idSite=1&period=day&date=last10
    public function __call($plugin, $arguments)
    {
    	list($method, $params)=$arguments;
    	
    	$query_url = $this->url.'?module=API&method='.$plugin.'.'.$method;
    	
    	foreach($params as $key => $val)
    	{
    		$query_url .= '&'.urlencode($key).'='.urlencode($val);
    	}

    	$responce = $this->_fetch_data($query_url.'&format=json');
    	
    	if(empty($responce))
    	{
    		return FALSE;
    	}
    	
    	return $responce;
    }

    
    private function _fetch_data($url)
    {
    	$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$returned = curl_exec($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close ($ch);

		if ($status == '200'){
			return json_decode( $returned );
		} else {
			return false;
		}
	}
	
}
// END Piwik class
?>