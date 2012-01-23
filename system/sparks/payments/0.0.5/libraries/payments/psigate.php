<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Psigate
{		
	/**
	 * The use who wil make the call to the paypal gateway
	*/
	private $_api_user;

	/**
	 * The default parameters for a particular method
	*/
	private $_default_params;	

	/**
	 * The endpoint for a particular transaction
	*/
	private $_api_endpoint;	

	/**
	 * The settings for a particular transaction
	*/
	private $_api_settings;	

	/**
	 * The api method to use
	*/
	private $_api_method;	
				
	/**
	 * Constructor method
	*/		
	public function __construct($payments)
	{
		$this->payments = $payments;				
		$this->_default_params = $this->payments->ci->config->item('method_params');
	}
	
	protected function _set_messenger_settings()
	{
		$this->_api_endpoint = $this->payments->ci->config->item('api_endpoint'.'_'.$this->payments->mode);	
		
		$this->_api_settings = array(
			'cid'			=> (isset($payments->gateway_credentials)) ? $payments->gateway_credentials['api_cid'] : $this->payments->ci->config->item('api_cid'),
			'store_id'		=> (isset($payments->gateway_credentials)) ? $payments->gateway_credentials['api_username'] : $this->payments->ci->config->item('api_username'),
			'pass_phrase'	=> (isset($payments->gateway_credentials)) ? $payments->gateway_credentials['api_password'] : $this->payments->ci->config->item('api_password'),
			'xml_version'	=> '1.0',
			'encoding'		=> 'utf-8',
			'xml_schema'	=> '',
		);		
	}
	
	protected function _set_account_manager_settings()
	{
		$this->_api_endpoint = $this->payments->ci->config->item('api_recurring_endpoint'.'_'.$this->payments->mode);	
		
		$this->_api_settings = array(
			'cid'			=> $this->payments->ci->config->item('api_cid'),
			'store_id'		=> $this->payments->ci->config->item('api_username'),
			'pass_phrase'	=> $this->payments->ci->config->item('api_recurring_password'),
			'xml_version'	=> '1.0',
			'encoding'		=> 'utf-8',
			'xml_schema'	=> '',
		);		
	}

	/**
	 * Builds a request
	 * @param	array	array of params
	 * @param	string	the type of transaction
	 * @return	array	Array of transaction settings
	*/	
	protected function _build_request($params, $transaction_type = NULL)
	{	
		//var_dump($params);exit;
		$nodes = array();	
		$nodes[$this->_api_method] = array(
			'StoreID' => $this->_api_settings['store_id'],
			'Passphrase' => $this->_api_settings['pass_phrase']
		);
		
		if(isset($params['amt']))
		{
			$nodes[$this->_api_method]['Subtotal'] = $params['amt'];
		}
		
		$nodes[$this->_api_method] = array_merge($nodes[$this->_api_method], $this->_build_bill_to_fields($params));
		
		$nodes[$this->_api_method] = array_merge($nodes[$this->_api_method], $this->_build_ship_to_fields($params));
				
		if(isset($params['phone']))
		{
			$nodes[$this->_api_method]['Phone'] = $params['phone'];
		}
		
		if(isset($params['fax']))
		{
			$nodes[$this->_api_method]['Fax'] = $params['fax'];
		}
		
		if(isset($params['email']))
		{
			$nodes[$this->_api_method]['Email'] = $params['email'];
		}
		
		if(isset($params['note']))
		{
			$nodes[$this->_api_method]['Comments'] = $params['note'];
		}
		
		if(isset($params['tax_amt']))
		{
			$nodes[$this->_api_method]['Tax1'] = $params['tax_amt'];
		}
		
		if(isset($params['shipping_amt']))
		{
			$nodes[$this->_api_method]['ShippingTotal'] = $params['shipping_amt'];
		}
		
		if(isset($params['ip_address']))
		{
			$nodes[$this->_api_method]['CustomerIP'] = $params['ip_address'];
		}
		
		if($transaction_type === '2' OR $transaction_type === '3' OR $transaction_type === '9')
		{
			$nodes[$this->_api_method]['PaymentType'] = 'CC';
			$nodes[$this->_api_method]['CardAction'] = $transaction_type;
		}
		
		if(isset($params['cc_number']) AND isset($params['cc_exp']) AND isset($params['cc_code']))
		{
			$nodes[$this->_api_method]['PaymentType'] = 'CC';
			$nodes[$this->_api_method]['CardAction'] = $transaction_type;
			$nodes[$this->_api_method]['CardNumber'] = $params['cc_number'];
			
			if(strlen($params['cc_exp']) > 0)
			{
				$month = substr($params['cc_exp'], 0, 2);
				$year = substr($params['cc_exp'], -2, 2);
				$nodes[$this->_api_method]['CardExpMonth'] = $month;
				$nodes[$this->_api_method]['CardExpYear'] = $year;				
			}
			
			$nodes[$this->_api_method]['CardIDNumber'] = $params['cc_code'];		
		}
		
		if($transaction_type === '2' OR $transaction_type === '3' OR $transaction_type === '9')
		{
			$nodes[$this->_api_method]['OrderID'] = $params['identifier'];
		}
		
		if($transaction_type === '9')
		{
			$nodes[$this->_api_method]['TransRefNumber'] = $params['identifier_2'];
		}

		$request = $this->payments->build_xml_request(
			$this->_api_settings['xml_version'],
			$this->_api_settings['encoding'],
			$nodes
		);	
		
		
		return $request;	
	}

	/**
	 * Builds bill to fields
	 * @param	array	array of params
	 * @return	array	Array of fields
	*/		
	protected function _build_bill_to_fields($params)
	{	
		$billing = array();
		
		if(isset($params['first_name']))
		{
			$billing['Bname'] = $params['first_name'];
		}
		
		if(isset($params['last_name']))
		{
			if(!empty($params['first_name']))
			{
				$billing['Bname'] .= ' '.$params['last_name'];
			}
			else
			{
				$billing['Bname'] = $params['last_name'];
			}
		}
		
		if(isset($params['company']))
		{
			$billing['Bcompany'] = $params['company'];
		}
		
		if(isset($params['street']))
		{
			$billing['Baddress1'] = $params['street'];
		}
		
		if(isset($params['city']))
		{
			$billing['Bcity'] = $params['city'];
		}
		
		if(isset($params['state']))
		{
			$billing['Bprovince'] = $params['state'];
		}
		
		if(isset($params['country']))
		{
			$billing['Bcountry'] = $params['country'];
		}
		
		return $billing;
	}
	
	/**
	 * Builds ship to fields
	 * @param	array	array of params
	 * @return	array	Array of fields
	*/	
	protected function _build_ship_to_fields($params)
	{
		$shipping = array();
		
		if(isset($params['ship_to_first_name']))
		{
			$shipping['Sname'] = $params['ship_to_first_name'];
		}
		
		if(isset($params['ship_to_last_name']))
		{
			if(!empty($params['ship_to_first_name']))
			{
				$shipping['Sname'] .= ' '.$params['ship_to_last_name'];
			}
			else
			{
				$shipping[$this->_api_method]['Sname'] = $params['ship_to_last_name'];
			}
		}
		
		if(isset($params['ship_to_company']))
		{
			$shipping['Scompany'] = $params['ship_to_company'];
		}
		
		if(isset($params['ship_to_street']))
		{
			$shipping['Saddress1'] = $params['ship_to_street'];
		}
		
		if(isset($params['ship_to_city']))
		{
			$shipping['Scity'] = $params['ship_to_city'];
		}
		
		if(isset($params['ship_to_state']))
		{
			$shipping['Sprovince'] = $params['ship_to_state'];
		}
		
		if(isset($params['ship_to_country']))
		{
			$shipping['Scountry'] = $params['ship_to_country'];
		}
		
		return $shipping;	
	}
	
	/**
	 * Make a oneoff payment
	 * @param	array	An array of payment params, sent from your controller / library
	 * @return	object	The response from the payment gateway
	*/	
	public function psigate_oneoff_payment($params)
	{
		$this->_api_method = 'Order';
		$this->_set_messenger_settings();
		$this->_request = $this->_build_request($params, '0');			
		return $this->_handle_query();
	}

	/**
	 * Authorize a oneoff payment
	 * @param	array	An array of payment params, sent from your controller / library
	 * @return	object	The response from the payment gateway
	*/	
	public function psigate_authorize_payment($params)
	{
		$this->_api_method = 'Order';
		$this->_set_messenger_settings();		
		$this->_request = $this->_build_request($params, '1');			
		return $this->_handle_query();
	}

	/**
	 * Authorize a oneoff payment
	 * @param	array	An array of payment params, sent from your controller / library
	 * @return	object	The response from the payment gateway
	*/	
	public function psigate_capture_payment($params)
	{
		$this->_api_method = 'Order';
		$this->_set_messenger_settings();		
		$this->_request = $this->_build_request($params, '2');			
		return $this->_handle_query();
	}	

	/**
	 * Void a transaction
	 * @param	array	An array that contains your identifier
	 * @return	object	The response from the payment gateway
	*/	
	public function psigate_void_payment($params)
	{
		$this->_api_method = 'Order';
		$this->_set_messenger_settings();		
		$this->_request = $this->_build_request($params, '9');		
		return $this->_handle_query();	
	}
	
	/**
	 * Refund a transaction
	 * @param	array	An array that contains your identifier
	 * @return	object	The response from the payment gateway
	 *
	 * NOTE:  You must include the original transaction amount for this payment gateway!  You can issue a refund amount less than or equal the original order amount.
	*/	
	public function psigate_refund_payment($params)
	{
		$this->_api_method = 'Order';
		$this->_set_messenger_settings();		
		$this->_request = $this->_build_request($params, '3');		
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
		//var_dump($this->_request);exit;
		$this->_http_query = $this->_request;
		
		$response_object = $this->payments->gateway_request($this->_api_endpoint, $this->_http_query);	
		$response = $this->_parse_response($response_object);
		
		return $response;
	}	

	/**
	 * Parse the response from the server
	 *
	 * @param	array
	 * @return	object
	 */		
	protected function _parse_response($xml)
	{	
		$details = (object) array();

		$as_array = $this->payments->arrayize_object($xml);

		$result = $as_array['Approved'];
		
		if(isset($as_array['OrderID']))
		{
			$identifier = $as_array['OrderID'];
		}
		
		if(isset($as_array['subscriptionId']))
		{
			$identifier = $as_array['subscriptionId'];
		}
		
		if(isset($as_array['TransRefNumber']))
		{
			$identifier2 = $as_array['TransRefNumber'];
		}
		
		$details->timestamp = $as_array['TransTime'];
		$details->gateway_response = $as_array;
		
		if(isset($identifier))
		{
			$identifier = (string) $identifier; 
			if(strlen($identifier) > 1)
			{
				$details->identifier = $identifier;
			}
		}
		
		if(isset($identifier2))
		{
			$identifier2 = (string) $identifier2; 
			if(strlen($identifier2) > 1)
			{		
				$details->identifier2 = $identifier2;
			}
		}
		
		if($result == 'APPROVED')
		{
			return $this->payments->return_response(
				'Success',
				$this->payments->payment_type.'_success',
				'gateway_response',
				$details
			);
		}
		
		if($result == 'ERROR' OR $result == 'DECLINED')
		{
			if(isset($as_array['ErrMsg']))
			{
				$message = $as_array['ErrMsg'];
				$message = explode(':', $message);
				$message = $message[1];
			}
			
			if(isset($message))
			{
				$details->reason = $message;
			}	

			return $this->payments->return_response(
				'Failure',
				$this->payments->payment_type.'_gateway_failure',
				'gateway_response',
				$details
			);				
		}
	}
				
}