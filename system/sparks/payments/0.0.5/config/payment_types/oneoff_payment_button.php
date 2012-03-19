<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['oneoff_payment_button'] = array(
	'amt'			=>	'',	//Amount for the payment
	'desc'			=>	'', //A description for the transaction
	'notify_url'	=>	'',	//Your URL for receiving Instant Payment Notification (IPN) about this transaction. If you do not specify this value in the request, the notification URL from your Merchant Profile is used, if one exists.
	'shipping_amt'  =>	'', //The cost of shipping
	'tax_amt'		=>	'', //Amount for just tax.	
			'first_name'		=>	'', //first name of the purchaser
			'last_name'			=>	'', //last name of the purchaser
			'business_name'		=>	'', //name of business
			'street'			=>	'', //street address of the purchaser
			'street2'			=>	'', //street address 2 of purchaser
			'city'				=>	'', //city of the purchaser
			'state'				=>	'', //state of the purchaser
			'country'		=>	'', // country of the purchaser
			'postal_code'				=>	'', //zip code of the purchaser
			'phone'	=>	'', //phone num of customer shipped to
			'fax'				=>	'',
			'identifier' => '', //Merchant provided identifier for the transaction
			'currency_code'		=>	'', //currency code to use for the transaction.	
);