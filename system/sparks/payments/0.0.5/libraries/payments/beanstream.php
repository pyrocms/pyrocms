<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Beanstream
{	
	/**
	 *	The payments object
	*/
	public $payments;
	
	/**
	 * The use who wil make the call to the paypal gateway
	*/
	private $_api_user;

	/**
	 * The password for API user
	*/
	private $_pwd;	

	/**
	 * The version of the API to use
	*/	
	private $_api_version;

	/**
	 * The API signature to use
	*/	
	private $_api_signature;

	/**
	 * A description to use for the transaction
	*/
	private $_transaction_description;

	/**
	 * The API method currently being utilized
	*/
	protected $_api_method;		

	/**
	 * The API method currently being utilized
	*/
	private $_api_endpoint;	

	/**
	 * An array for storing all settings
	*/	
	private $_settings = array();
	
	/**
	 * Validation
	*/
	private $_validation;
	
	/**
	 * An array for storing all request data
	*/	
	private $_request = array();	

	/**
	 * The final string to be sent in the http query
	*/	
	private $_http_query;	

	/**
	 * Constructor method
	*/		
	public function __construct($payments)
	{
		$this->payments = $payments;
		$this->_api_endpoint = $this->payments->ci->config->item('api_endpoint');		
		$this->_api_settings = array(
			'merchant_id'	=> (isset($payments->gateway_credentials)) ? $payments->gateway_credentials['api_mid'] : $this->payments->ci->config->item('api_mid'),
			'username'		=> (isset($payments->gateway_credentials)) ? $payments->gateway_credentials['api_username'] : $this->payments->ci->config->item('api_username'),
			'password'		=> (isset($payments->gateway_credentials)) ? $payments->gateway_credentials['password'] : $this->payments->ci->config->item('api_password'),
			'requestType'	=> 'BACKEND'
		);
		
		$this->_validation = array(
			'username' => $this->payments->ci->config->item('validation_username'),
			'password' => $this->payments->ci->config->item('validation_password')
		);	
	}

	private function _recurring_settings()
	{
		$this->_api_endpoint = $this->payments->ci->config->item('api_recurring_endpoint');
		$this->_api_settings['passCode'] = $this->payments->ci->config->item('api_recurring_billing_passcode');
		$this->_api_settings['merchantId'] = $this->payments->ci->config->item('api_mid');
		$this->_api_settings['serviceVersion'] = "1.0";
		$this->_api_settings = array_reverse($this->_api_settings);
		unset($this->_api_settings['username']);
		unset($this->_api_settings['password']);
		unset($this->_api_settings['requestType']);
		unset($this->_api_settings['merchant_id']);
	}
	
	/**
	 * Build requests
	 * @param	array	An array of payment param
	 * @return	void
	*/	
	private function _build_request($params, $transaction_type = NULL)
	{	
		$request = $this->_build_common_fields($params);
		
		//If it's a recurring transaction, but not profile creation
		if(strstr($transaction_type, 'recurring') !== FALSE AND $transaction_type !== 'recurring')
		{
			$this->_recurring_settings();
		}
		
		if($transaction_type === 'recurring' OR $transaction_type === 'recurring_modify')
		{
			$request['trnRecurring'] = '1';
		
			if(isset($params['billing_period']) AND !empty($params['billing_period']))
			{
				$period = strtolower($params['billing_period']);
				$periods = array(
					'month'	=>	'M',
					'year'	=>	'Y',
					'week'	=>	'W',
					'day'	=>	'D'
				);
				$request['rbBillingPeriod'] = $periods[$period];	
			}
			
			if(isset($params['billing_frequency']))
			{
				$request['rbBillingIncrement'] = $params['billing_frequency'];
			}
			
			$request['rbCharge'] = $this->payments->ci->config->item('delay_charge');
			$request['processBackPayments'] = $this->payments->ci->config->item('bill_outstanding');
			
			if(isset($params['profile_start_date']))
			{
				$start = $params['profile_start_date'];
				$m = substr($start, 4, 2);
				$d = substr($start, -2, 2);
				$y = substr($start, 0, 4);
				
				$first_bill = $m.$d.$y;
				
				$request['rbFirstBilling'] = $first_bill;
			}
			
			//rbSecondBilling could be integrated as well.  It is a field used in combination with rbFirstBilling to prorate a first payment. The second billing date will mark the start of the regular billing schedule. The first customer payment will be prorated based on the difference between the first and second billing date. All subsequent billing intervals will be counted after this date.	This value must be formatted as MMDDYYYY.
			
			//Profile end date could also be passed here as rbExpiry
			
			//Did not use rbApplyTax1 or rbApplyTax2
		}	
		
		if($transaction_type === 'recurring_modify' OR $transaction_type === 'recurring_cancel' OR $transaction_type === 'recurring_suspend' OR $transaction_type === 'recurring_activate')
		{
			$request['rbAccountID'] = $params['identifier'];
			$request['processBackPayments'] = $this->payments->ci->config->item('bill_outstanding');
		}
		
		if($transaction_type === 'recurring_suspend')
		{
			$request['rbBillingState'] = 'O';
		}
		
		if($transaction_type === 'recurring_activate')
		{
			$request['rbBillingState'] = 'A';
		}
		
		$this->_request = $request;
	}

	/**
	 * Build common fields for the request
	 * @param	array	An array of payment param
	 * @return	void
	*/		
	private function _build_common_fields($params)
	{
		$request = array();
		
		if(isset($this->_api_method['trnType']))
		{
			$method = $this->_api_method['trnType'];
		}
		
		if(isset($this->_api_method['operationType']))
		{
			$method = $this->_api_method['operationType'];
		}
			
		if(isset($params['first_name']) AND isset($params['last_name']))
		{
			$name = $params['first_name'].' '.$params['last_name'];
			$request['ordName'] = $name;
			$request['trnCardOwner'] = $name;
		}
		
		if(isset($params['cc_exp']))
		{
			$month = substr($params['cc_exp'], 0, 2);
			$year = substr($params['cc_exp'], -2, 2);
			$request['trnExpMonth'] = $month;
			$request['trnExpYear'] = $year;
		}

		if(isset($params['identifier']))
		{
			if($method === 'PAC' OR $method === 'VP' OR $method === 'VR' OR $method === 'R')
			{
				$request['adjId'] = $params['identifier'];
			}
			
			if($method === 'Q')
			{
				$request['trnOrderNumber'] = $params['identifier'];
			}
		}
		
		if(isset($params['cc_number']))
		{
			$request['trnCardNumber'] = $params['cc_number'];
		}
		
		if(isset($params['amt']))
		{
			$request['trnAmount'] = $params['amt'];
		}
		
		if(isset($params['phone']))
		{
			$request['ordPhoneNumber'] = $params['phone'];
		}
		
		if(isset($params['email']))
		{
			$request['ordEmailAddress'] = $params['email'];
		}
		
		if(isset($params['street']))
		{
			$request['ordAddress1'] = $params['street'];
		}
		
		if(isset($params['city']))
		{
			$request['ordCity'] = $params['city'];
		}
		
		if(isset($params['state']))
		{
			$request['ordProvince'] = $params['state'];
		}
		
		if(isset($params['postal_code']))
		{
			$request['ordPostalCode'] = $params['postal_code'];
		}
		
		if(isset($params['country']))
		{
			$request['ordCountry'] = $params['country'];
		}
		
		if(isset($params['ship_to_name']))
		{
			$request['shipName'] = $params['ship_to_name'];
		}
		
		if(isset($params['ship_to_phone_number']))
		{
			$request['shipPhoneNumber'];
		}
		
		if(isset($params['ship_to_street']))
		{
			$request['shipAddress1'] = $params['ship_to_street'];
		}
		
		if(isset($params['ship_to_city']))
		{
			$request['shipCity'] = $params['ship_to_city'];
		}
		
		if(isset($params['ship_to_state']))
		{
			$request['shipProvince'] = $params['ship_to_state'];
		}
		
		if(isset($params['ship_to_postal_code']))
		{
			$request['shipPostalCode'] = $params['ship_to_postal_code'];
		}
		
		if(isset($params['ship_to_country']))
		{
			$request['shipCountry'] = $params['ship_to_country'];
		}
		
		if(isset($params['note']))
		{
			$request['trnComments'] = $params['note'];
		}
		
		if(isset($params['ip_address']))
		{
			$request['customerIP'] = $params['ip_address'];
		}	


		if(isset($this->_validation['username'], $this->_validation['password']))
		{
			$request['username'] = $this->payments->ci->config->item('validation_username');
			$request['password'] = $this->payments->ci->config->item('validation_password');
		}				
		
		return $request;
	}	

	/**
	 * Make a oneoff payment
	 * @param	array	An array of payment params, sent from your controller / library
	 * @return	object	The response from the payment gateway
	*/	
	public function beanstream_oneoff_payment($params)
	{
		$this->_api_method = array('trnType' => 'P');
		$this->_build_request($params);
		return $this->_handle_query();
	}
		
	/**
	 * Authorize a oneoff payment
	 * @param	array	An array of payment params, sent from your controller / library
	 * @return	object	The response from the payment gateway
	*/	
	public function beanstream_authorize_payment($params)
	{
		$this->_api_method = array('trnType' => 'PA');
		$this->_build_request($params);		
		return $this->_handle_query();	
	}
	
	/**
	 * Capture a oneoff payment
	 * @param	array	An array of payment params, sent from your controller / library
	 * @return	object	The response from the payment gateway
	 *
	 * NOTE: Prior to processing PACs through the API, you must modify the transaction settings in your Beanstream merchant member area.
	*/	
	public function beanstream_capture_payment($params)
	{
		$this->_api_method = array('trnType' => 'PAC');
		$this->_build_request($params);	
		if(isset($this->_validation['username'], $this->_validation['password']))
		{
			$this->_request['username'] = $this->payments->ci->config->item('validation_username');
			$this->_request['password'] = $this->payments->ci->config->item('validation_password');
		}	
		return $this->_handle_query();
	}

	/**
	 * Void a oneoff payment
	 * @param	array	An array of params, sent from your controller / library
	 * @return	object	The response from the payment gateway
	 *
	 * Note: This can only be issued the same day as the original transaction
	*/	
	public function beanstream_void_payment($params)
	{
		$this->_api_method = array('trnType' => 'VP');
		$this->_build_request($params);					
		return $this->_handle_query();
	}	
	
	/**
	 * Void a return payment
	 * @param	array	An array of params, sent from your controller / library
	 * @return	object	The response from the payment gateway
	 *
	 * Note: This can only be issued the same day as the original transaction
	*/	
	public function beanstream_void_refund($params)
	{
		$this->_api_method = array('trnType' => 'VR');
		$this->_build_request($params);				
		return $this->_handle_query();
	}

	/**
	 * Refund a transaction
	 * @param	array	An array that contains your identifier
	 * @return	object	The response from the payment gateway
	*/	
	public function beanstream_refund_payment($params)
	{
		$this->_api_method = array('trnType' => 'R');
		$this->_build_request($params);				
		return $this->_handle_query();	
	}		


	/**
	 * Get a transaction's details
	 * @param	string	An array that contains your identifier
	 * @return	object	The response from the payment gateway
	*/	
	public function beanstream_get_transaction_details($params)
	{
		$this->_api_method = array('trnType' => 'Q');
		$this->_build_request($params);		
		return $this->_handle_query();		
	}	

	/**
	 * Create a new recurring payment
	 *
	 * @param	array
	 * @return	object
	 *
	 * NOTE: must be performed with either Hash validation or Username and Password validation. Prior to sending a request via API, you must activate one of these options through the Beanstream Order Settings module.
	 */		
	public function beanstream_recurring_payment($params)
	{
		$this->_api_method = array('trnType' => 'P');
		$this->_build_request($params, 'recurring');		
		return $this->_handle_query();			
	}

	/**
	 * Cancel a recurring profile
	 *
	 * @param	array
	 * @return	object
	 */		
	public function beanstream_cancel_recurring_profile($params)
	{
		$this->_api_method = array('operationType' => 'C');
		$this->_build_request($params, 'recurring_cancel');		
		return $this->_handle_query();	
	}

	/**
	 * Suspend a recurring profile
	 *
	 * @param	array
	 * @return	object
	 */		
	public function beanstream_suspend_recurring_profile($params)
	{
		$this->_api_method = array('operationType' => 'M');
		$this->_build_request($params, 'recurring_suspend');		
		return $this->_handle_query();	
	}

	/**
	 * Activate a recurring profile
	 *
	 * @param	array
	 * @return	object
	 */		
	public function beanstream_activate_recurring_profile($params)
	{
		$this->_api_method = array('operationType' => 'M');
		$this->_build_request($params, 'recurring_activate');		
		return $this->_handle_query();	
	}	

	/**
	 * Update a recurring payments profile
	 *
	 * @param	array
	 * @return	object
	 */		
	public function beanstream_update_recurring_profile($params)
	{
		$this->_api_method = array('operationType' => 'M');
		$this->_build_request($params, 'recurring_modify');		
		return $this->_handle_query();	
	}
	
	/**
	 * Build the query for the response and call the request function
	 *
	 * @param	array
	 * @param	array
	 * @param	string
	 * @return	array
	 */		
	private function _handle_query()
	{
		$settings = array_merge($this->_api_settings, $this->_api_method);
		$merged = array_merge($settings, $this->_request);
		//var_dump($merged);exit;
		$request = $this->payments->filter_values($merged);	
		//var_dump($request);exit;
		$this->_request = http_build_query($request);
		$this->_http_query = $this->_api_endpoint.$this->_request;
		
		//var_dump($this->_http_query);exit;
		$request = $this->payments->gateway_request($this->_http_query);	
		
		$response = $this->_parse_response($request);
		
		return $response;
	}

	/**
	 * Parse the response from the server
	 *
	 * @param	array
	 * @return	object
	 */		
	private function _parse_response($response)
	{	
		$details = (object) array();
			
		if(strstr($response, '<response>'))
		{
			$response = $this->payments->parse_xml($response);
			$response = $this->payments->arrayize_object($response);
			$details->gateway_response = $response;
							
			if($response['code'] == '1')
			{
				return $this->payments->return_response(
					'Success',
					$this->payments->payment_type.'_success',
					'gateway_response',
					$details
				);			
			}
			else
			{
				$details->reason = $response['message'];
				return $this->payments->return_response(
					'Failure',
					$this->payments->payment_type.'_gateway_failure',
					'gateway_response',
					$details
				);				
			}
		}
		else
		{
		//var_dump($response);exit;
			$results = explode('&',urldecode($response));
			foreach($results as $result)
			{
				list($key, $value) = explode('=', $result);
				$gateway_response[$key]=$value;
			}
			
			$details->gateway_response = $gateway_response;	
			$details->timestamp = $gateway_response['trnDate'];		
				
			if($gateway_response['trnApproved'] == '1')
			{	
				$details->identifier = $gateway_response['trnId'];
				
				if(isset($gateway_response['rbAccountId']))
				{
					$details->identifier = $gateway_response['rbAccountId'];
				}
				
				return $this->payments->return_response(
					'Success',
					$this->payments->payment_type.'_success',
					'gateway_response',
					$details
				);
			}
			else
			{
				$details->reason = $gateway_response['messageText'];
				
				return $this->payments->return_response(
					'Failure',
					$this->payments->payment_type.'_gateway_failure',
					'gateway_response',
					$details
				);		
			}	
		}
	}
			
}