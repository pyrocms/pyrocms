<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['api_mid'] = "";
$config['api_username'] = "";
$config['api_password'] = "";
$config['api_endpoint'] = "https://www.beanstream.com/scripts/process_transaction.asp?";
$config['api_recurring_endpoint'] = "https://www.beanstream.com/scripts/recurring_billing.asp?";
$config['api_recurring_billing_passcode'] = "72b7bdbCaac44AAa9b94ec9ca790E6AB";
$config['validation_username'] = "";
$config['validation_password'] = "";

//Recurring billing settings.  Important!
$config['delay_charge'] = '1'; //set this to 0 if you want to charge customers as soon as they elect to begin recurring billing, or 1 if you want to wait until their profile start date to bill them.
$config['bill_outstanding'] = '1'; /* By default, new recurring billing accounts are flagged
to automatically process back payments if the account
is disabled and then re-activated. This setting may be
modified at any time through the Beanstream member
area or via API. This is done separately for each
individual recurring billing customer account.	When
re-activating an account via API, back payments will be
processed or ignored according to the value set for the
individual customer in the Beanstream member area
unless this variable is passed.
Specify processBackPayments=1 to process back
payments and charge the customer for any missed
invoices when an account is re-activated. Specify
processBackPayments=0 to re-activate the account
without charging back payments.*/

$config['required_params'] = array(
	'oneoff_payment'	=>	array(
		'cc_number',
		'cc_exp',
		'cc_code',
		'amt',
		'first_name',
		'last_name',
		'phone',
		'email',
		'street',
		'city',
		'state',
		'country',
		'postal_code'	
	),
	'authorize_payment'	=>	array(
		'cc_number',
		'cc_exp',
		'cc_code',
		'amt',
		'first_name',
		'last_name',
		'phone',
		'email',
		'street',
		'city',
		'state',
		'country',
		'postal_code'	
	),
	'capture_payment'	=>	array(
		'identifier',
		'amt'
	),
	'void_payment'	=>	array(
		'identifier',
		'amt'
	),
	'void_refund' => array(
		'identifier',
		'amt',
		'first_name',
		'last_name',
		'cc_number',
		'cc_exp',
		'email',
		'phone',
		'street',
		'city',
		'state',
		'country'
	),
	'refund_payment' =>	array(
		'identifier'
	),		
	'get_transaction_details' => array(
		'identifier'
	),		
	'recurring_payment' => array(
		'cc_number',
		'cc_exp',
		'cc_code',
		'amt',
		'first_name',
		'last_name',
		'phone',
		'email',
		'street',
		'city',
		'state',
		'country',
		'postal_code',	
	),
	'suspend_recurring_profile' => array(
		'identifier'
	),
	'activate_recurring_profile' => array(
		'identifier'
	),
	'cancel_recurring_profile' => array(
		'identifier'
	),
	'update_recurring_profile' => array(
		'identifier'
	)
);