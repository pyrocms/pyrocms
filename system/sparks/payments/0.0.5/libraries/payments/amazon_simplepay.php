<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Amazon_SimplePay
{	
	/**
	 *	The payments object
	*/
	public $payments;
	
	/**
	 * The button to use
	*/
	private $_button;
	
	/**
	 * An array for storing all settings
	*/	
	private $_settings = array();

	/**
	 * The HTML form to return
	*/	
	private $_form_string = array();	

	/**
	 * The api endpoint
	*/	
	private $_api_endpoint;	

	/**
	 * The FPS endpoint
	*/	
	private $_fps_endpoint;	
		
	/**
	 * The final string to be sent in the http query
	*/	
	private $_http_query;	

	private $_http_method = "POST";
	
	private $_params;
	
	/**
	 * Constructor method
	*/		
	public function __construct($payments)
	{
		$this->payments = $payments;
		$this->_api_endpoint = $this->payments->ci->config->item('api_endpoint_'.$this->payments->mode);	
		$this->_fps_endpoint = $this->payments->ci->config->item('fps_endpoint_'.$this->payments->mode);
		$this->_fps_version = $this->payments->ci->config->item('fps_version');
		$this->_fps_endpoint_parsed = parse_url($this->_fps_endpoint);		
		$this->_api_settings = array(
			'immediateReturn'	=> $this->payments->ci->config->item('immediate_return'),
			'collectShippingAddress'	=> $this->payments->ci->config->item('collect_shipping_address'),
			'signatureVersion' => (isset($payments->gateway_credentials)) ? $payments->gateway_credentials['api_signature_version'] : $this->payments->ci->config->item('api_signature_version'),
			'signatureMethod'	=> (isset($payments->gateway_credentials)) ? $payments->gateway_credentials['api_signature_method'] : (isset($payments->gateway_credentials)) ? $payments->gateway_credentials['api_signature_method'] : $this->payments->ci->config->item('api_signature_method'),	
			'accessKey' => (isset($payments->gateway_credentials)) ? $payments->gateway_credentials['api_access_key'] : $this->payments->ci->config->item('api_access_key'),
			'isDonationWidget' => $this->payments->ci->config->item('donation_widget'),
			'amazonPaymentsAccountId' => (isset($payments->gateway_credentials)) ? $payments->gateway_credentials['api_account_id'] : $this->payments->ci->config->item('api_account_id'),
			'ipnUrl' => $this->payments->ci->config->item('ipn_url'),
			'returnUrl' => $this->payments->ci->config->item('return_url'),
			'cobrandingStyle' => 'logo',
			'abandonUrl' => $this->payments->ci->config->item('abandon_url'),
		);
		$this->_secret_key = $this->payments->ci->config->item('api_access_secret_key');
		
		$this->_algorithm = $this->_api_settings['signatureMethod'];
		
		$custom_button = $this->payments->ci->config->item('custom_button');
		if(!empty($custom_button))
		{
			$this->_button = $custom_button;
		}
		else
		{	
			$choices = explode('.', $this->payments->ci->config->item('button_choice'));
			$style = $choices[0];
			$color = $choices[1];
			$size = $choices[2];
			
			$button = $this->payments->ci->config->item('button_choices');
			$this->_button = $button[$style][$color][$size];
		}
		
	}

	/**
	 * Build the button
	 * @param	array	An array of payment params, sent from your controller / library
	 * @param	string	The capture method should be set to 1 or 0 (for true or false)
	 * @param	bool	Either true or false.  If true, transaction is recurring.
	 * @return	object	The response from the payment gateway
	*/
	private function _build_button($params, $capture_method, $recurring = FALSE)
	{
		$fields = array();
		if(isset($params['amt']))
		{
			$fields['amount'] = "USD " . $params['amt'];
		}
		
		if(isset($params['desc']))
		{
			$fields['description'] = $params['desc'];
		}
		
		if($recurring)
		{
			if(!empty($params['trial_amt']) AND !empty($params['trial_billing_cycles']))
			{
				$fields['noOfPromotionTransactions'] = $params['trial_billing_cycles'];
				$fields['promotionAmount'] = $params['trial_amt'];
			}
			
			if(!empty($params['billing_frequency']) AND !empty($params['billing_period']))
			{
				$params['billing_period'] = strtolower($params['billing_period']);
				$fields['recurringFrequency'] = $params['billing_frequency'] .' '. $params['billing_period'];
			}		
						
			if(!empty($params['profile_start_date']))
			{
				$fields['recurringStartDate'] = $params['profile_start_date'];
			}
			
			if(!empty($params['total_billing_cycles']))
			{
				$fields['subscriptionPeriod'] = $params['total_billing_cycles'].' '.$params['billing_period'];
			}		
		}
		
		$this->_api_settings['processImmediate'] = $capture_method;
		
		$this->payments->ci->load->helper('form');
		
		$fields = array_merge($fields, $this->_api_settings);
		
		$submit = array(
        	'type'        => 'image',
        	'src'         => $this->_button,
        	'border'      => '0'
        );
        
        $to_sign = parse_url($this->_api_endpoint);
        $signature = SignatureUtils::signParameters($fields, $this->_secret_key, $this->_http_method, $to_sign['host'], $to_sign['path'], $this->_algorithm);
        
		$string = "";
		$string .= form_open($this->_api_endpoint);
		$string .= form_hidden($fields);
		$string .= form_hidden(array('signature' => $signature));
		$string .= form_input($submit);
		$string .= form_close();
		
		return $string;
	}

	/**
	 * Payment authorization button
	 * @param	array	An array of payment params, sent from your controller / library
	 * @return	string	A well-formed HTML string
	*/	
	public function amazon_simplepay_oneoff_payment_button($params)
	{
		$form = $this->_build_button($params, '1');	
		return $form;
	}

	/**
	 * Payment authorization button
	 * @param	array	An array of payment params, sent from your controller / library
	 * @return	string	A well-formed HTML string
	*/	
	public function amazon_simplepay_authorize_payment_button($params)
	{
		$form = $this->_build_button($params, '0');	
		return $form;
	}

	/**
	 * Recurring payment button
	 * @param	array	An array of payment params, sent from your controller / library
	 * @return	string	A well-formed HTML string
	*/	
	public function amazon_simplepay_recurring_payment_button($params)
	{
		$form = $this->_build_button($params, '0', TRUE);	
		return $form;
	}	

	/**
	 * Void a transaction
	 * @param	array	An array of payment params, sent from your controller / library
	 * @return	object	A response from the payment gateway
	*/	
	public function amazon_simplepay_void_payment($params)
	{
		$this->_api_method = 'Cancel';
		$this->_params = array(
			'Action' => $this->_api_method,
			'AWSAccessKeyId' => $this->_api_settings['accessKey'],
			'CurrencyCode' => 'USD',
			'TransactionId' => $params['identifier'],
			'CancelReason' => $params['note'],
			'Description' => $params['note'],
			'Timestamp' => date('Y-m-d'),			
			'Version' => $this->_fps_version,		
			'SignatureVersion' => $this->_api_settings['signatureVersion'],			
			'SignatureMethod' => $this->_api_settings['signatureMethod'],
		);
		
		if(!empty($params['note']))
		{
			$this->_params['CancelReason'] = $params['note'];
		}
		
		$this->_params['Signature'] = SignatureUtils::signParameters($this->_params, $this->_secret_key, $this->_http_method, $this->_fps_endpoint_parsed['host'], '/', $this->_algorithm);
		
		$call = $this->_api_call();
		return $call;
	}

	/**
	 * Get a recurring profile
	 * @param	array	An array of payment params, sent from your controller / library
	 * @return	object	A response from the payment gateway
	*/		
	public function amazon_simplepay_get_recurring_profile($params)
	{
		/*
		NOT YET IMPLEMENTED
		$this->_api_method = 'GetSubscriptionDetails';
		$this->_params = array(
			'Action' => $this->_api_method,
			'AWSAccessKeyId' => $this->_api_settings['accessKey'],
			'CurrencyCode' => 'USD',
			'SubscriptionId' => $params['identifier'],
			'Timestamp' => date('Y-m-d'),			
			'Version' => $this->_fps_version,		
			'SignatureVersion' => $this->_api_settings['signatureVersion'],			
			'SignatureMethod' => $this->_api_settings['signatureMethod'],
		);
		
		if(!empty($params['note']))
		{
			$this->_params['CancelReason'] = $params['note'];
		}
		
		$this->_params['Signature'] = SignatureUtils::signParameters($this->_params, $this->_secret_key, $this->_http_method, $this->_fps_endpoint_parsed['host'], '/', $this->_algorithm);
		
		$call = $this->_api_call();
		return $call;
		*/
	}
	
	/**
	 * Cancel a recurring profile
	 * @param	array	An array of payment params, sent from your controller / library
	 * @return	object	A response from the payment gateway
	*/		
	public function amazon_simplepay_cancel_recurring_profile($params)
	{
		$this->_api_method = 'CancelSubscriptionAndRefund';
		$this->_params = array(
			'Action' => $this->_api_method,
			'AWSAccessKeyId' => $this->_api_settings['accessKey'],
			'CurrencyCode' => 'USD',
			'SubscriptionId' => $params['identifier'],
			'Timestamp' => date('Y-m-d'),			
			'Version' => $this->_fps_version,		
			'SignatureVersion' => $this->_api_settings['signatureVersion'],			
			'SignatureMethod' => $this->_api_settings['signatureMethod'],
		);
		
		if(!empty($params['note']))
		{
			$this->_params['CancelReason'] = $params['note'];
		}
		
		$this->_params['Signature'] = SignatureUtils::signParameters($this->_params, $this->_secret_key, $this->_http_method, $this->_fps_endpoint_parsed['host'], '/', $this->_algorithm);
		
		$call = $this->_api_call();
		return $call;
	}

	/**
	 * Make a call to the Amazon API
	 * @return	object	The response from the payment gateway
	*/		
	private function _api_call()
	{
		$this->_params = $this->payments->filter_values($this->_params);
		$this->_http_query = $this->_fps_endpoint.'?'.http_build_query($this->_params);
		//var_dump($this->_http_query);exit;
		$gateway_call = $this->payments->gateway_request($this->_http_query);
		
		return $this->_parse_response($gateway_call);
	}

	/**
	 * Parse a response from the payment gateway
	 * @return	object	The response from the payment gateway
	*/		
	private function _parse_response($response)
	{
		$details = (object) array();
		
		$response = $this->payments->arrayize_object($response);
		
		if(array_key_exists($response['Errors']))
		{
			$details->reason = $response['Errors']['Error']['Message'];
			return $this->payments->return_response(
				'Failure',
				$this->payments->payment_type.'_gateway_failure',
				'gateway_response',
				$details
			);	
		}
		else
		{
			return $this->payments->return_response(
				'Success',
				$this->payments->payment_type.'_success',
				'gateway_response'
			);			
		}
		
		return $response;
	}	
}

/** 
 *  PHP Version 5
 *
 *  @category    Amazon
 *  @package     Amazon_FPS
 *  @copyright   Copyright 2008-2010 Amazon Technologies, Inc.
 *  @link        http://aws.amazon.com
 *  @license     http://aws.amazon.com/apache2.0  Apache License, Version 2.0
 *  @version     2008-09-17
 */

class SignatureUtils
{ 

    /**
     * Computes RFC 2104-compliant HMAC signature for request parameters
     * Implements AWS Signature, as per following spec:
     *
     * In Signature Version 2, string to sign is based on following:
     *
     *    1. The HTTP Request Method followed by an ASCII newline (%0A)
     *    2. The HTTP Host header in the form of lowercase host, followed by an ASCII newline.
     *    3. The URL encoded HTTP absolute path component of the URI
     *       (up to but not including the query string parameters);
     *       if this is empty use a forward '/'. This parameter is followed by an ASCII newline.
     *    4. The concatenation of all query string components (names and values)
     *       as UTF-8 characters which are URL encoded as per RFC 3986
     *       (hex characters MUST be uppercase), sorted using lexicographic byte ordering.
     *       Parameter names are separated from their values by the '=' character
     *       (ASCII character 61), even if the value is empty.
     *       Pairs of parameter and values are separated by the '&' character (ASCII code 38).
     *
     */
    /**
	* This function call appropriate functions for calculating signature
	* @param array $parameters request parameters
	* @param key - Secret key 
	* @param httpMethod - httpMethos used
	* @param host - Host 
	* @requestURi -  Path
		
     */		

    public static function signParameters(array $parameters, $key, $httpMethod, $host, $requestURI,$algorithm) {
        $stringToSign = null;
        $stringToSign = self::_calculateStringToSignV2($parameters, $httpMethod, $host, $requestURI);
        return self::_sign($stringToSign, $key, $algorithm);
    }

    /**
     * Calculate String to Sign for SignatureVersion 2
     * @param array $parameters request parameters
     * @return String to Sign
     */
    private static function _calculateStringToSignV2(array $parameters, $httpMethod, $hostHeader, $requestURI) {
        if ($httpMethod == null) {
        	throw new Exception("HttpMethod cannot be null");
        }
        $data = $httpMethod;
        $data .= "\n";
        
        if ($hostHeader == null) {
        	$hostHeader = "";
        } 
        $data .= $hostHeader;
        $data .= "\n";
        
        if (!isset ($requestURI)) {
        	$requestURI = "/";
        }
		$uriencoded = implode("/", array_map(array("SignatureUtils", "_urlencode"), explode("/", $requestURI)));
        $data .= $uriencoded;
        $data .= "\n";
        
        uksort($parameters, 'strcmp');
        $data .= self::_getParametersAsString($parameters);
        return $data;
    }

    private static function _urlencode($value) {
		return str_replace('%7E', '~', rawurlencode($value));
    }

    /**
     * Convert paremeters to Url encoded query string
     */
    public static function _getParametersAsString(array $parameters) {
        $queryParameters = array();
        foreach ($parameters as $key => $value) {
            $queryParameters[] = $key . '=' . self::_urlencode($value);
        }
        return implode('&', $queryParameters);
    }

    /**
     * Computes RFC 2104-compliant HMAC signature.
     */
    private static function _sign($data, $key, $algorithm) {
        if ($algorithm === 'HmacSHA1') {
            $hash = 'sha1';
        } else if ($algorithm === 'HmacSHA256') {
            $hash = 'sha256';
        } else {
            throw new Exception ("Non-supported signing method specified");
        }
        return base64_encode(
            hash_hmac($hash, $data, $key, true)
        );
    }
}