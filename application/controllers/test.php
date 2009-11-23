<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function __autoload($class)
{
	include(APPPATH . 'models/' . strtolower($class) . '.' . EXT);
}

class Test extends Controller {

    function index() {
    	
    	Modules_m::test();
    	
    	
	}
}



?>