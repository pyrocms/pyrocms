<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authorize_Net_Examples extends CI_Controller {

	public function index()
	{
		$this->load->spark('codeigniter-payments/0.0.1/');
		//*****AUTHORIZE.NET******//
		
		//MAKE A ONE OFF PAYMENT
		/*/
		var_dump($this->payments->oneoff_payment('authorize_net', 
				array(
					'cc_type'			=>	'Visa',	
					'cc_number'			=>	'4997662409617853', 
					'cc_exp'			=>	'022016', 
					'amt'				=>	'6.00',
				)
			)		
		);	
		/*/
		//AUTHORIZE A ONE OFF PAYMENT	
		/*/	
		var_dump($this->payments->authorize_payment('authorize_net', 
				array(
					'cc_type'			=>	'Visa',	
					'cc_number'			=>	'4997662409617853', 
					'cc_exp'			=>	'022016', 
					'amt'				=>	'7.00',
				)
			)		
		);	
		/*/
		//CAPTURE A PREVIOUSLY AUTHORIZED PAYMENT
		/*/
		var_dump($this->payments->capture_payment('authorize_net',
				array(
					'identifier'			=>	'2161894134'
				)
			)
		);		
		/*/
		//VOID A PAYMENT
		/*/
		var_dump($this->payments->void_payment('authorize_net',
				array(
					'identifier'			=>	'2161908334'
				)
			)
		);		
		/*/
		//REFUND A PAYMENT
		/*/
		var_dump($this->payments->refund_payment('authorize_net', 
				array(
					'identifier'			=>	'2161908685',
					'cc_number'				=>	'7853', //Can be a full number or last 4 digits.  Note that storing full card info is usually not a good idea.
					'cc_exp'				=>	'022016',
					'amt'					=>	'1.00',
				)		
			)
		);
		/*/	
		//GET A PARTICULAR TRANSACTION'S DETAILS
		/*/
		var_dump($this->payments->get_transaction_details('authorize_net', 
				array(
					'identifier'			=>	'2161910058'
				)		
			)
		);
		/*/					
		//MAKE A RECURRING PAYMENT
		/*/
		var_dump($this->payments->recurring_payment('authorize_net',
				array(
				'profile_start_date'		=>	date("Y-m-d"),  
					'profile_reference'			=>	'',
					'desc'						=>	'Chill out.  Just a test!',	
					'max_failed_payments'		=>	'',
					'auto_bill_amt'				=>	'',
					'billing_period'			=>	'Month', 
					'billing_frequency'			=>	'1',	
					'total_billing_cycles'		=>	'9999', 
					'amt'						=>	'20.00',	
					'trial_billing_frequency'	=>	'',
					'trial_billing_cycles'		=>	'',
					'ship_to_country'			=>	'',
					'phone'						=>	'',
					'cc_type'					=>	'Visa',
					'cc_number'					=>	'4997662409617853',	
					'cc_exp'					=>	'022016',	
					'cc_code'					=>	'203',	
					'start_date'				=>	'',	
					'issue_number'				=>	'',
					'email'						=>	'',
					'identifier'				=>	'',
					'payer_status'				=>	'',
					'country_code'				=>	'US',	
					'business_name'				=>	'',
					'salutation'				=>	'',
					'first_name'				=>	'Joe',
					'middle_name'				=>	'',
					'last_name'					=>	'Blow',
					'suffix'					=>	'',
					'street'					=>	'181 Rowland Lane',  
					'street2'					=>	'',
					'city'						=>	'Tompkinsville',	
					'state'						=>	'KY',	
					'postal_code'				=>	'42167',
					'phone'			=>	'(270) 487 9560',					
				)
			)
		);
		/*/
		
		/*/Get a Recurring Profile
		var_dump($this->payments->get_recurring_profile('authorize_net', array('identifier' => '1135697')));
		/*/
		
		/*/Update a Recurring Profile
		var_dump($this->payments->update_recurring_profile('authorize_net', 
				array(
					'identifier' => '1135697',
					'cc_number'	=>	'4997662409617853',
					'cc_exp'	=>	'022017'
				)
			)
		);
		/*/
		
		/*/Cancel a recurring profile
		var_dump($this->payments->cancel_recurring_profile('authorize_net', 
				array(
					'identifier' => '1135697'
				)
			)
		);
		/*/

	}
}