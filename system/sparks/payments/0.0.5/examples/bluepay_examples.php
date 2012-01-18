<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bluepay_Examples extends CI_Controller {

	public function index()
	{
		// Setup Spark
		$vrs = '0.0.1'; // Update to your spark version
		$this->load->spark("codeigniter-payments/$vrs");
		$gateway = 'bluepay';
					   
		// Change to reflect the identifier (Transaction ID from previous transaction)
		// Required for CAPTURE, REFUND, and VOID
		$identifier = '100000000000';	
		
		// Only used for AUTH and ONEOFF
		$info = array(
			
			// Required Information for AUTH and ONEOFF
			'cc_number'			=>	'4111111111111111', 
			'cc_code'			=>	'203',
			'cc_exp'			=>	'022016',						
			'amt'				=>	'25.00',
			
			// Not necessarily required to process, but strongly suggested
			// Omitting some of these may result in HIGHER processing charges
			'email'				=>	'your-email@your-domain.com',
			'first_name'		=>	'Bill',
			'last_name'			=>	'Testing',
			'street'			=>	'181 Something Street', 
			'city'				=>	'Tompkinsville', 
			'state'				=>	'KY', 
			'country'			=>	'US', 
			'postal_code'		=>	'42167'
			
			// There are other fields you can include that Bluepay will record.
			// Check out the config for more info.
		);
		
		/**
		 * INSTRUCTIONS: Uncomment the line below that you want to test out.
		 */
		$response = 'Uncomment the line you want to test.';
		 
		// One Off Payment Example
		// $response = $this->payments->oneoff_payment($gateway, $info);

		// Auth
		// $response = $this->payments->authorize_payment($gateway, $info);
				
		// Capture
		//$response = $this->payments->capture_payment($gateway, array('identifier' => $identifier));
		
		// Refund
		// $response = $this->payments->refund_payment($gateway, array('identifier' => $identifier));
		
		// Void Payment Example
		// $response = $this->payments->void_payment($gateway, array('identifier' => $identifier));
		
		
		// Display the Outcome
		echo "<pre>";
		print_r($response);
		echo "</pre>";
		
		// Just so you can check it out later
		// Probably want to store some of this information in a database
		log_message('error', 'GATEWAY RESPONSE!!');
		log_message('error', json_encode($response));
	}
}