<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class QuickBooksMS_Examples extends CI_Controller {

	public function index()
	{
		$this->load->spark('codeigniter-payments/0.0.1');
		
		//******QUICKBOOKS MERCHANT SERVICES******//
		
		//ONEOFF PAYMENT
		/*/
		var_dump($this->payments->oneoff_payment('quickbooksms', 
				array(
					'first_name'		=>	'Calvin',
					'last_name'			=>	'Froedge',
					'cc_number'			=>	'4111111111111111', 
					'cc_exp'			=>	'112014', 
					'cc_code'			=>	'203',  
					'amt'				=>	'25.00', 
					'email'				=>	'calvinfroedge@gmail.com',
					'street'			=>	'181 Rowland Lane',
					'postal_code'		=>	'42167'
				)
			)
		);
		/*/
		
		//AUTHORIZE A PAYMENT	
		/*/
		var_dump($this->payments->authorize_payment('quickbooksms', 
				array(
					'first_name'		=>	'Calvin',
					'last_name'			=>	'Froedge',
					'cc_number'			=>	'4111111111111111', 
					'cc_exp'			=>	'112014', 
					'cc_code'			=>	'203',  
					'amt'				=>	'25.00', 
					'email'				=>	'calvinfroedge@gmail.com',
					'street'			=>	'181 Rowland Lane',
					'postal_code'		=>	'42167'
				)
			)
		);
		/*/	
		
		//CAPTURE A PAYMENT	
		/*/
		var_dump($this->payments->capture_payment('quickbooksms', 
				array(
					'identifier'	=>	'YY1000523630'
				)
			)
		);
		/*/	

		//REFUND A PAYMENT
		/*/
		var_dump($this->payments->refund_payment('quickbooksms', 
				array(
					'identifier'	=>	'YY1000523665'
				)
			)
		);		
		/*/	
		
		//VOID A PAYMENT
		/*/
		var_dump($this->payments->void_payment('quickbooksms', 
				array(
					'identifier'	=>	'YY1000523653'
				)
			)
		);		
		/*/
	}
}