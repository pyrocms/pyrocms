<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Beanstream_Examples extends CI_Controller {

	public function index()
	{
		$this->load->spark('codeigniter-payments/0.0.1/');

		//******BEANSTREAM PAYMENTS******//
		
		//ONEOFF PAYMENT
		/*/
		var_dump($this->payments->oneoff_payment('beanstream', 
				array(
					'first_name'		=>	'Calvin',
					'last_name'			=>	'Froedge',
					'phone'				=>	'(801) 754 4466',
					'cc_number'			=>	'4030000010001234', 
					'cc_exp'			=>	'112014', 
					'cc_code'			=>	'203',  
					'amt'				=>	'23.00', 
					'email'				=>	'jondoe@gmail.com',
					'street'			=>	'181 Rowland Lane',
					'city'				=>	'Tompkinsville',
					'state'				=>	'KY',
					'country'			=>	'US',
					'postal_code'		=>	'42167'
				)
			)
		);
		/*/	

		//AUTHORIZE A PAYMENT
		/*/
		var_dump($this->payments->authorize_payment('beanstream', 
				array(
					'first_name'		=>	'Calvin',
					'last_name'			=>	'Froedge',
					'phone'				=>	'(801) 754 4466',
					'cc_number'			=>	'4030000010001234', 
					'cc_exp'			=>	'112014', 
					'cc_code'			=>	'203',  
					'amt'				=>	'15.00', 
					'email'				=>	'jondoe@gmail.com',
					'street'			=>	'181 Rowland Lane',
					'city'				=>	'Tompkinsville',
					'state'				=>	'KY',
					'country'			=>	'US',
					'postal_code'		=>	'42167'
				)
			)
		);
		/*/	

		//CAPTURE A PAYMENT
		/*/
		var_dump($this->payments->capture_payment('beanstream', 
				array(
					'identifier'		=>	'10000013',
					'amt'				=>	'15.00'
				)
			)
		);
		/*/
		
		//VOID A PAYMENT
		/*/
		var_dump($this->payments->void_payment('beanstream',
				array(
					'identifier'		=>	'10000014',
					'amt'				=>	'15.00'
				)
			)
		);
		/*/	

		//REFUND A PAYMENT
		/*/
		var_dump($this->payments->refund_payment('beanstream',
				array(
					'identifier'		=>	'10000013',
					'amt'				=>	'15.00'
				)
			)
		);
		/*/		

		//GET A TRANSACTION'S DETAILS
		/*/
		var_dump($this->payments->get_transaction_details('beanstream',
				array(
					'identifier'		=>	'10000020'
				)
			)
		);
		/*/		
		
		//CREATE A RECURRING PROFILE
		/*/
		var_dump($this->payments->recurring_payment('beanstream',
			array(
					'profile_start_date'		=>	date("Y-m-d"),  
					'profile_reference'			=>	'',
					'desc'						=>	'Chill out.  Just a test!',	
					'max_failed_payments'		=>	'',
					'auto_bill_amt'				=>	'',
					'billing_period'			=>	'Month', 
					'billing_frequency'			=>	'1',	
					'total_billing_cycles'		=>	'9999', 
					'amt'						=>	'11.00',	
					'trial_billing_frequency'	=>	'',
					'trial_billing_cycles'		=>	'',
					'ship_to_country'			=>	'',
					'phone'						=>	'',
					'cc_type'					=>	'Visa',
					'cc_number'					=>	'4030000010001234',	
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
					'phone'						=>	'(270) 487 9560',	
					'country'					=>	'US',
					'email'						=>	'calvinfroedge@gmail.com'		
				)
			)
		);
		/*/	
		
		//UPDATE A RECURRING PROFILE
		/*/
		var_dump($this->payments->update_recurring_profile('beanstream',
				array(
					'identifier'				=>	'4999531',
					'first_name'				=>	'Joe',
					'middle_name'				=>	'',
					'last_name'					=>	'Blow'					
				)
			)
		);
		/*/

		//SUSPEND A RECURRING PROFILE
		/*/
		var_dump($this->payments->suspend_recurring_profile('beanstream',
				array(
					'identifier'	=> '4999520'
				)
			)
		);
		/*/
		/*/
		//ACTIVATE A RECURRING PROFILE THAT HAS BEEN SUSPENDED
		var_dump($this->payments->activate_recurring_profile('paypal_paymentspro', 
				array(
					'identifier'	=> 'I-9DGMTBN36EFD',
					'note'			=> 'This is just a note'
				)
			)
		);
		/*/
				
		//CANCEL A RECURRING PROFILE
		/*/
		var_dump($this->payments->cancel_recurring_profile('beanstream',
				array(
					'identifier' => '4998415'
				)
			)
		);
		/*/	
	}
}