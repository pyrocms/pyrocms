<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Eway_Examples extends CI_Controller {

	public function index()
	{
		$this->load->spark('codeigniter-payments/0.0.1');
		
		//*****EWAY******//
		/*/
		var_dump($this->payments->oneoff_payment('eway', 
				array(
					'first_name'		=>	'Calvin',
					'last_name'			=>	'Froedge',
					'cc_number'			=>	'4444333322221111', 
					'cc_exp'			=>	'022016', 
					'cc_code'			=>	'203',  
					'amt'				=>	'25.00', 
					'email'				=>	'calvinfroedge@gmail.com',
					'street'			=>	'181 Rowland Lane',
					'postal_code'		=>	'42167'
				)
			)
		);			
		/*/
	}
}