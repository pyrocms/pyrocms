<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Notes & Unsupported Parameters
|--------------------------------------------------------------------------
|
| Does not support SWIPE or TRACK2 transactions (e.g. cannot integrate with
| a card reader)
| 
| Unused Parameters:
| IS_CORPORATE, CUSTOM_ID2, DUPLICATE_OVERRIDE, AMOUNT_TIP, AMOUNT_FOOD,
|  AMOUNT_MISC, DO_REBILL, REB_IS_CREDIT, REB_FIRST_DATE, REB_EXPR,
|  REB_CYCLES, REB_AMOUNT, SMID_ID, PIN_BLOCK, AMOUNT_CASHBACK, 
|  AMOUNT_SURCHARGE, F_REBILLING
*/


/*
|--------------------------------------------------------------------------
| Payment Gateway Credentials
|--------------------------------------------------------------------------
|
| Fill out the following information with those provided 
| to you by your gateway.
| 
*/
$config['api_secret_key']	= "XXXXXXXXXXX"; // Bluepay Secret Key (NEVER sent directly over the wire)
$config['api_account_id']	= "00000000000"; // Bluepay 12 Digit ACCOUNT_ID
$config['api_user_id']		= "00000000000"; // Bluepay 12 Digit USER_ID (optional but helpful)


/*
|--------------------------------------------------------------------------
| Payment Gateway Settings
|--------------------------------------------------------------------------
|
| You should be able to leave these alone unless the API changes.
| 
| API endpoints are the same for both the TEST and LIVE gateways
| 
*/
$config['api_endpoint'] = "https://secure.bluepay.com/interfaces/bp20post";
$config['api_version'] = "2"; // Bluepay's API - Using the POST API
$config['test_mode'] = TRUE;


/*
|--------------------------------------------------------------------------
| Payment to Gateway Key Map
|--------------------------------------------------------------------------
|
| This allows you to setup a centralized key map conversion table.
| The array key is CodeIgniter Payments key and the value is the 
| current gateways (e.g. bluepay) key
| 
| NOTE: If the key doesn't exist for your gateway, remove the
| key or set it to FALSE to prevent it from being passed
| 
| This array will be used in the private function _map_params()
|
*/
$config['payment_to_gateway_key_map'] = array(
			'ip_address'		=> FALSE,	//IP address of purchaser
			'cc_type'			=> FALSE,	//Visa, MasterCard, Discover, Amex
			'cc_number'			=> 'PAYMENT_ACCOUNT', //Credit card number
			'cc_exp'			=> 'CARD_EXPIRE', //Must be formatted MMYYYY @todo - Must translate to MMYY
			'cc_code'			=> 'CARD_CVV2', //3 or 4 digit cvv code
			'email'				=> 'EMAIL', //email associated with account being billed
			'first_name'		=> 'NAME1', //first name of the purchaser
			'last_name'			=> 'NAME2', //last name of the purchaser
			'business_name'		=> 'COMPANY_NAME', //name of business
			'street'			=> 'ADDR1', //street address of the purchaser @todo - Only 64 Char
			'street2'			=> 'ADDR2', //street address 2 of purchaser @todo - Only 64 Char
			'city'				=> 'CITY', //city of the purchaser @todo - Only 32 Char
			'state'				=> 'STATE', //state of the purchaser @todo - Only 16 Char; 2 lttr abbr pref.
			'country'			=> 'COUNTRY', // country of the purchaser (64 Char)
			'postal_code'		=> 'ZIP', //zip code of the purchaser (16 Char)
			'amt'				=> 'AMOUNT', //purchase amount (XXXXXXX.XX FORMAT) Includes Tax and Tip
			'phone'				=> 'PHONE', //phone num of customer shipped to @todo - Required for ACH; 16 Chars.
			'fax'				=> FALSE,
			'identifier' 		=> 'MASTER_ID', //Merchant provided identifier for the transaction @todo - IS PREVIOUS TRANS_ID AND ONLY REQUIRED FOR CAPTURE OR REFUND.
			'currency_code'		=> FALSE, //currency code to use for the transaction.
			'item_amt'			=> FALSE, //Amount for just the item being purchased.
			'insurance_amt'		=> FALSE, //Amount for just insurance.
			'shipping_disc_amt'	=> FALSE, //Amount for just shipping.
			'handling_amt'		=> FALSE, //Amount for just handling.
			'tax_amt'			=> 'AMOUNT_TAX', //Amount for just tax.
			'desc'				=> 'MEMO', //Description for the transaction
			'custom'			=> FALSE, //Free form text field
			'inv_num'			=> 'INVOICE_ID', //Invoice number @todo - 64 Characters
			'po_num'			=> 'ORDER_ID',
			'notify_url'		=> FALSE,	//Your URL for receiving Instant Payment Notification (IPN) about this transaction. If you do not specify this value in the request, the notification URL from your Merchant Profile is used, if one exists.
			'run_as_test'		=> FALSE, //Run the transaction in test mode @todo - MODE Needs to be set to TEST
			'duplicate_window'	=> FALSE, //Duration of time for which duplicate transactions will be rejected
			'ship_to_first_name'=> FALSE,
			'ship_to_last_name' => FALSE,
			'ship_to_street'	=> FALSE,
			'ship_to_city'		=> FALSE,
			'ship_to_state'		=> FALSE,
			'ship_to_postal_code'=> FALSE,
			'ship_to_country'	=> FALSE,	
			'ship_to_company'	=> FALSE,
			'shipping_amt'		=> FALSE,
			'duty_amt'			=> FALSE,
			'tax_exempt'		=> FALSE,
			
			// @todo ACH Transactions
			'ach_account'		=> 'PAYMENT_ACCOUNT', // 3 colon-separated fields (1) C or S for account type, (2) Routing, (3) Account #
			'doc_type'			=> 'DOC_TYPE', // The Documenation for the ACH transactions (PPD, CCD, TEL, WEB, ARC)
);


/*
|--------------------------------------------------------------------------
| AVS Code Meaning
|--------------------------------------------------------------------------
|
| Will interpret the AVS code response from Bluepay. If the API responds with
| one of these it does not mean that the transaction failed.
| 
*/
$config['avs_code_meaning'] = array(
	/*
	A  = Street match, Zip no match 
	N  = No match 
	S  = AVS not supported for this card type 
	U  = AVS not available for this card type 
	W  = Zip match 9, street no match 
	X  = Zip match 9, street match 
	Y  = Zip match 5, street match 
	Z  = Zip match 5, street no match 
	E  = Not eligible 
	R  = System unavailable 
	_  = Not supported for this network or transaction type.


	B  = Street match, Zip not verified 
	C  = Street and Zip not Verified 
	D  = Street and Zip match 
	M  = Street and Zip match 
	G  = Issuer does not support AVS 
	I  = Not verified 
	P  = Street no match, zip match
	*/
);

/*
|--------------------------------------------------------------------------
| CVV Code Meaning
|--------------------------------------------------------------------------
|
| Will interpret the CVV code response from Bluepay. If the API responds with
| one of these it does not mean that the transaction failed.
| 
*/
$config['cvv_code_meaning'] = array(
	/*
	M  = CVV2 – Match  
	N  = CVV2 – No match 
	P  = CVV2 was not processed 
	S  = CVV2 exists but was not input 
	U  = Zip match 9, street no match 
	_  = Card issuer does not provide CVV2 service 
	*/
);


/*
|--------------------------------------------------------------------------
| Required Parameters
|--------------------------------------------------------------------------
|
| Avoid sending payments to the gateway unless param requirements are met
| 
| NOTE: You should setup form_validation to prevent these parameters
|  from being missed on the payment page.
|
*/
$config['required_params'] = array(
	'oneoff_payment'	=> array(
		'cc_number',
		'cc_code',
		'cc_exp',
		'amt'
	),
	'authorize_payment'	=> array(
		'cc_number',
		'cc_code',
		'cc_exp',
		'amt'	
	),
	'capture_payment'	=> array(
		'identifier'
	),
	'void_payment'		=> array(
		'identifier'
	),
	'refund_payment'	=> array(
		'identifier'
	)
);