<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Piwik_test extends Controller {

    function __construct() {
        parent::Controller();
		$this->load->library('piwik', 'http://piwik.org/demo/');
    }

    // Admin: Control Panel
    function index() {

    	$result = $this->piwik->VisitsSummary('getVisits', array('idSite' => 1, 'period' => 'day', 'date' => 'last10'));
    	
    	echo "<pre>";
    	var_dump($result);
    
    }
    
    function unique_visitors()
    {
    	//http://piwik.org/demo/?module=API&method=VisitsSummary.getUniqueVisitors&idSite=1&period=day&date=today
    	
    	$result = $this->piwik->VisitsSummary('getUniqueVisitors', array('idSite' => 1, 'period' => 'day', 'date' => 'yesterday'));
    	
    	echo "<pre>";
    	var_dump($result);
    }
}

?>