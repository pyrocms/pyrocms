<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * BluePay Payment Module
 *
 * @package CodeIgniter
 * @subpackage Sparks
 * @category Payments
 * @author Joel Kallman (www.eclarian.com)
 * @email jkallman@eclarian.com
 * @created 08/24/2011
 * @license http://www.opensource.org/licenses/mit-license.php
 * @link https://github.com/calvinfroedge/codeigniter-payments
 */
class Bluepay {

	/**
	 * The API method currently being utilized
	 */
	private $_api_endpoint;	
	
	/**
	 * The API method currently being utilized
	 */
	private $_api_method;
	
	/**
	 * An array for storing all settings
	 */	
	private $_api_settings;

	/**
	 * The version of the API to use
	 */	
	private $_api_version;
	
	/**
	 * The final string to be sent in the http query
	 */	
	private $_http_query;

	/**
	 * An array for storing all request data
	 */	
	private $_request = array();	

	/**
	 * Maps CI Payments key names to Bluepay's API key name
	 */
	private $_payment_to_gateway_key_map;
	
	// -------------------------------------------------------------------------
	
	/**
	 * Constructor method
	 */		
	public function __construct($payments)
	{
		$this->payments = $payments;				
		$this->_api_endpoint = $this->payments->ci->config->item('api_endpoint');	
		$this->_api_version = $this->payments->ci->config->item('api_version');	
		$this->_payment_to_gateway_key_map = $this->payments->ci->config->item('payment_to_gateway_key_map');		
		$this->_api_settings = (object) array(
			'login'			=> (isset($payments->gateway_credentials)) ? $payments->gateway_credentials['api_account_id'] : $this->payments->ci->config->item('api_account_id'),
			'user_id'		=> (isset($payments->gateway_credentials)) ? $payments->gateway_credentials['api_user_id'] : $this->payments->ci->config->item('api_user_id'),
			'secret_key'	=> (isset($payments->gateway_credentials)) ? $payments->gateway_credentials['api_secret_key'] : $this->payments->ci->config->item('api_secret_key'),
			'email_customer'=> $this->payments->ci->config->item('email_customer'),
			'test_mode'		=> $this->payments->ci->config->item('test_mode')
		);
	}
	
	// -------------------------------------------------------------------------
	
	/**
	 * Authorize a oneoff payment
	 * @param	array	An array of payment params, sent from your controller / library
	 * @return	object	The response from the payment gateway
	 */	
	public function bluepay_authorize_payment($params)
	{
		$this->_api_method = 'AUTH';
		$this->_request = $this->_build_request($params);			
		return $this->_handle_query();
	}
	
	// -------------------------------------------------------------------------
	
	/**
	 * Capture a oneoff payment
	 * @param	array	An array of payment params, sent from your controller / library
	 * @return	object	The response from the payment gateway
	 */	
	public function bluepay_capture_payment($params)
	{
		$this->_api_method = 'CAPTURE';
		$this->_request = $this->_build_request($params);			
		return $this->_handle_query();
	}
	
	// -------------------------------------------------------------------------
	
	/**
	 * Make a oneoff payment
	 * @param	array	An array of payment params, sent from your controller / library
	 * @return	object	The response from the payment gateway
	 */	
	public function bluepay_oneoff_payment($params)
	{
		$this->_api_method = 'SALE';
		$this->_request = $this->_build_request($params);			
		return $this->_handle_query();
	}		
	
	// -------------------------------------------------------------------------
	
	/**
	 * Refund a transaction
	 * @param	array	An array that contains your identifier
	 * @return	object	The response from the payment gateway
	 */	
	public function bluepay_refund_payment($params)
	{
		$this->_api_method = 'REFUND';
		$this->_request = $this->_build_request($params);		
		return $this->_handle_query();	
	}

	// -------------------------------------------------------------------------
	
	/**
	 * Void a oneoff payment
	 * @param	array	An array of params, sent from your controller / library
	 * @return	object	The response from the payment gateway
	 * NOTE: This transaction type can be used to cancel either an original transaction that is not yet settled, or an entire order composed of more than one transaction.  A void prevents the transaction or order from being sent for settlement. A Void can be submitted against any other transaction type.
	 * NOTE: This will ONLY work for unsettled transactions.
	*/	
	public function bluepay_void_payment($params)
	{
		$this->_api_method = 'VOID';
		$this->_request = $this->_build_request($params);			
		return $this->_handle_query();	
	}	

	// -------------------------------------------------------------------------
	
	/**
	 * Add Config to Request
	 * 
	 * @param	array
	 * @return	array
	 */
	protected function _add_config_to_request($params)
	{	
		$params['MODE']			= ($this->_api_settings->test_mode) ? 'TEST': 'LIVE';
		$params['ACCOUNT_ID']	= $this->_api_settings->login;
		$params['TRANS_TYPE']	= $this->_api_method;
		$params['PAYMENT_TYPE']	= 'CREDIT';
		
		if( ! empty($this->_api_settings->user_id) )
		{
			$params['USER_ID'] = $this->_api_settings->user_id;
		}
		
		$params['TAMPER_PROOF_SEAL'] = $this->_build_tamper_proof_seal($params);
		
		return $params;
	}
	
	// -------------------------------------------------------------------------
	
	/**
	 * Builds a request
	 *
	 * Builds as an HTTP POST Request
	 *
	 * @param	array	array of params
	 * @param	string	the api call to use
	 * @return	array	Array of transaction settings
	*/	
	protected function _build_request($params)
	{
		$request = array();
				
		// Map CI Payments Keys to Gateway Keys
		foreach($this->_payment_to_gateway_key_map as $map => $val)
		{
			// Key not being used or Parameter not included or empty
			if($val === FALSE OR ! isset($params[$map]) OR empty($params[$map]) ) continue;			
			$request[$val] = $params[$map];
		}
		
		// Setup Configured Values for Request
		$request = $this->_add_config_to_request($request);
		
		// Build HTTP Query Because we are using POST rather than XML
		return http_build_query($request);
	}

	// -------------------------------------------------------------------------
	
	/**
	 * Build Tamper Proof Seal
	 *
	 * This function creates a md5 checksum to validate the integrity of the request
	 * The secret key is never passed directly and is used as a salt to provide a check
	 * on the gateway servers.
	 * 
	 * FORMAT:
	 * md5(SECRET KEY + ACCOUNT_ID + TRANS_TYPE + AMOUNT + MASTER_ID + NAME1 + PAYMENT_ACCOUNT)
	 * 
	 * @param	array	Current Requests Parameters
	 * @return	string	Checksum for Tamper Proof Seal
	 */
	protected final function _build_tamper_proof_seal($params)
	{
		$hash = '';
		$params['SECRET_KEY'] =  $this->_api_settings->secret_key;
		$tps_contents = array('SECRET_KEY', 'ACCOUNT_ID', 'TRANS_TYPE', 'AMOUNT', 'MASTER_ID', 'NAME1', 'PAYMENT_ACCOUNT');		
		foreach($tps_contents as $key) $hash .= (isset($params[$key])) ? $params[$key]: '';
		return bin2hex( md5($hash, TRUE) );		
	}
	
	// -------------------------------------------------------------------------
	
	/**
	 * Build the query for the response and call the request function
	 *
	 * @param	array
	 * @param	array
	 * @param	string
	 * @return	array
	 */		
	protected function _handle_query()
	{	
		$this->_http_query = $this->_request;
		$response_object = $this->payments->gateway_request($this->_api_endpoint, $this->_http_query, 'application/x-www-form-urlencoded');
		return $this->_parse_response($response_object);
	}
	
	// -------------------------------------------------------------------------
	
	/**
	 * Parse the response from the server
	 *
	 * @param	object	Always includes timestamp, gateway_response, reason
	 * @return	object
	 */		
	protected function _parse_response($data)
	{
		// Since this module currently uses POST to make the gateway request
		// We know our current object can be simply typecasted back to an array.
		// IF THIS EVER CHANGES, USE $this->payments->arrayize_object($data);
		$results = explode('&',urldecode($data));
		foreach($results as $result)
		{
			list($key, $value) = explode('=', $result);
			$gateway_response[$key]=$value;
		}		
		
		$details = (object) array();
		$details->timestamp = gmdate('c');
		$details->gateway_response = $gateway_response; // Full Gateway Response		
		
		//Set response types
		$response_types = array(
			'E' => $this->payments->payment_type.'_gateway_failure', 
			'1' => $this->payments->payment_type.'_success', 
			'0' => $this->payments->payment_type.'_local_failure'
		);
		
		// Default to Failure if data is not what is expected
		$status = 'failure';
		
		// Setup Final Response 
		if(isset($gateway_response['MESSAGE']))
		{		
			$details->reason = $gateway_response['MESSAGE'];
		}
		
		if(isset($gateway_response['STATUS']))
		{
			$details->status = $gateway_response['STATUS']; // The request can be successful, yet have the card be declined
		}
		
		// Setup additional properties if successful
		if(isset($gateway_response['TRANS_ID']))
		{
			$details->identifier = $gateway_response['TRANS_ID'];
		}
				
		// Return Local Response, because we didn't get an expected response from server
		if( ! isset($gateway_response['STATUS'], $gateway_response['MESSAGE']))
		{
			// @todo - Don't know if this should be a different response than "gateway" 
			return $this->payments->return_response($status, $response_types['E'], 'gateway_response', $details);
		}
				
		// Possible Responses are 1 = Approved, 0 = Decline, 'E' = Error
		$is_success = ($data['STATUS'] === '1');
		
		// Setup Response
		$status = ($is_success) ? 'success': 'failure';
		$response = $response_types[$gateway_response['STATUS']];
		
		// Send it back!	
		return $this->payments->return_response($status, $response, 'gateway_response', $details);
	}

	// -------------------------------------------------------------------------	
}