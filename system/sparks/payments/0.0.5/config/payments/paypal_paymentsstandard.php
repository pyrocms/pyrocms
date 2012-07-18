<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['payment_email'] = "iambrs_1298074268_biz@gmail.com";
$config['api_endpoint_test'] = "https://www.sandbox.paypal.com/cgi-bin/webscr";
$config['api_endpoint_production'] = "https://www.paypal.com/cgi-bin/webscr";

/*
|--------------------------------------------------------------------------
| IPN Url
|--------------------------------------------------------------------------
|
| PayPal's Instant Payment Notifications alert you that a sale has been made after it has been completed.
|
*/
$config['ipn_url'] = '';

/*
|--------------------------------------------------------------------------
| Recurring Payments
|--------------------------------------------------------------------------
*/

$config['payments_never_expire'] = TRUE; //Set this to true if payments should keep happening no matter what

$config['retry_on_failure'] = TRUE; //Set this to true to try to rebill after a failure

$config['hide_note'] = TRUE; //This will hide the feature which allows user to enter a note about their subscription 

$config['allow_modifications'] =  0; /*    Options:
0 Ğ allows subscribers only to sign up for new subscriptions
1 Ğ allows subscribers to sign up for new subscriptions and modify their current subscriptions
2 Ğ allows subscribers to modify only their current subscriptions */

$config['user_manage'] = FALSE; //Set to true to have PayPal generate usernames and initial passwords for subscribers. For more information, seehttps://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/e_howto_html_subscribe_buttons

/*
|--------------------------------------------------------------------------
| Payment to Gateway Key Map
|--------------------------------------------------------------------------
|
| This allows you to setup a centralized key map conversion table.
| The array key is CodeIgniter Payments key and the value is the 
| current gateways (e.g. paypal) key
| 
| NOTE: If the key doesn't exist for your gateway, remove the
| key or set it to FALSE to prevent it from being passed
| 
| This array will be used in the private function _map_params()
|
| NOTE: We have NOT included all params available.  For a full list, please see: https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/e_howto_html_Appx_websitestandard_htmlvariables
|
*/
$config['payment_to_gateway_key_map'] = array(
	'first_name'	=>	'first_name', //first name of the purchaser
	'last_name'		=>	'last_name', //last name of the purchaser
	'business_name'	=>	'', //name of business
	'street'		=>	'address', //street address of the purchaser
	'street2'		=>	'address2', //street address 2 of purchaser
	'city'			=>	'city', //city of the purchaser
	'state'			=>	'state', //state of the purchaser
	'country'		=>	'country', // country of the purchaser
	'postal_code'	=>	'zip', //zip code of the purchaser
	'phone'			=>	'night_ phone_a', //phone num of customer shipped to
	'identifier' 	=> 'invoice', //Merchant provided identifier for the transaction
	'currency_code'	=>	'currency_code', //currency code to use for the transaction.	
	'desc' 			=> 	'item_name',
	'amt' 			=> 	'amount',
	'currency_code' => 'currency_code',
	'shipping_amt' 	=> 'shipping',	
);

/**
 * Required Parameters
 * 
 * Avoid sending payments to the gateway unless param requirements are met
*/

$config['required_params'] = array(
	'oneoff_payment_button'	=>	array(
		'amt',
		'desc',
	),
	'authorize_payment_button' => array(
		'amt',
		'desc'
	),
	'capture_payment_button' => array(
		'amt',
		'desc',
		'billing_period'
	),
	'recurring_payment_button' => array(
		'amt',
		'desc',
		'billing_period',
		'billing_frequency'
	),
	'void_transaction' => array(
		'identifier'
	),
	'cancel_recurring_profile' => array(
		'identifier'
	),
);