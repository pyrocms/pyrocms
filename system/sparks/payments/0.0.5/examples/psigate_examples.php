<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Psigate_Examples extends CI_Controller {

	public function index()
	{
		$this->load->spark('codeigniter-payments/0.0.1');
		
		//*****PSIGATE******//
		//MAKE A ONE OFF PAYMENT
		/*/
		var_dump($this->payments->oneoff_payment('psigate', 
				array(
					'cc_number'			=>	'4111111111111111', 
					'cc_exp'			=>	'022016', 
					'cc_code'			=>	'203',  
					'amt'				=>	'25.00', 
				)
			)
		);	
		/*/	
		//AUTHORIZE A ONE OFF PAYMENT
		/*/
		var_dump($this->payments->authorize_payment('psigate', 
				array(
					'cc_number'			=>	'4111111111111111', 
					'bill_to_company'	=>	'test',
					'cc_exp'			=>	'022016', 
					'cc_code'			=>	'203',
					'amt'				=>	'25.00', 
				)
			)
		);	
		/*/		

		//CAPTURE A ONE OFF PAYMENT
		//NOTE: ONLY PROVIDE AMOUNT IF IT IS LESS THAN THE ORIGINALLY AUTHORIZED AMOUNT.  OTHERWISE YOU WILL GET A SYSTEM ERROR.  IF YOU WANT TO CHARGE THE FULL AMOUNT, OMIT THE AMT PARAM.
		/*/
		var_dump($this->payments->capture_payment('psigate', 
				array(			
					'identifier'		=>	'2011081016345702166'
				)
			)
		);	
		/*/	

		/*/VOID A PAYMENT
		//
		var_dump($this->payments->void_payment('psigate',
				array(
					'identifier'		=>	'2011081017111402189',
					'identifier_2'		=>	'1be8cb87a774d6cd'
				)
			)
		);
		/*/	
				
		//REFUND A PAYMENT
		/*/
		var_dump($this->payments->refund_payment('psigate',
				array(
					'identifier'		=>	'2011081016345702166',
					'amt'				=>	'25.00'
				)
			)
		);
		/*/	
	}
}