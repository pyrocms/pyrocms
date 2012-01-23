<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Eway
{

	/**
	 * Constructor method
	*/		
	public function __construct($payments)
	{
		$this->payments = $payments;				
		$this->_default_params = $this->payments->ci->config->item('method_params');
		$this->_api_endpoint = $this->payments->ci->config->item('api_endpoint'.'_'.$this->payments->mode);		
		$this->_api_settings = array(
			'api_cid'		=> (isset($payments->gateway_credentials)) ? $payments->gateway_credentials['api_cid'] : $this->payments->ci->config->item('api_cid'),
			'api_endpoint'	=> $this->payments->ci->config->item('api_endpoint'),
			'xml_version'	=> '1.0',
			'encoding'		=> 'utf-8',
			'xml_schema'	=> '',
			'email_customer'=> $this->payments->ci->config->item('email_customer'),
		);
	}

	/**
	 * Builds a request
	 * @param	array	array of params
	 * @param	string	the api call to use
	 * @param	string	the type of transaction
	 * @return	array	Array of transaction settings
	*/	
	protected function _build_request($params, $transaction_type = NULL)
	{
		$nodes = array();
		
		$nodes['ewaygateway']['ewayCustomerID'] = $this->_api_settings['api_cid'];
		
		if(isset($params['amt']))
		{
			$nodes['ewaygateway']['ewayTotalAmount'] = $params['amt'];
		}
		
		if(isset($params['first_name']) AND isset($params['last_name']))
		{
			$nodes['ewaygateway']['ewayCardHoldersName'] = $params['first_name'] . ' ' . $params['last_name'];
			$nodes['ewaygateway']['ewayCustomerFirstName'] = $params['first_name']; 
			$nodes['ewaygateway']['ewayCustomerLastName'] = $params['last_name'];			
		}		
		
		if(isset($params['cc_number']))
		{
			$nodes['ewaygateway']['ewayCardNumber'] = $params['cc_number'];
		}
		
		if(isset($params['cc_exp']))
		{
			$month = substr($params['cc_exp'], 0, 2);
			$year = substr($params['cc_exp'], -2, 2);
			$nodes['ewaygateway']['ewayCardExpiryMonth'] = $month;
			$nodes['ewaygateway']['ewayCardExpiryYear'] = $year;
			
		}

		if(isset($params['email']))
		{
			$nodes['ewaygateway']['ewayCustomerEmail'] = $params['email'];
		}
		
		if(isset($params['street']))
		{
			$nodes['ewaygateway']['ewayCustomerAddress'] = $params['street'];
		}
		
		if(isset($params['postal_code']))
		{
			$nodes['ewaygateway']['ewayCustomerPostcode'] = $params['postal_code'];
		}

		if(!empty($params['desc']))
		{
			$nodes['ewaygateway']['ewayCustomerInvoiceDescription'] = $params['desc'];
		}
		else
		{
			$nodes['ewaygateway']['ewayCustomerInvoiceDescription'] = ' ';
		}
		
		$nodes['ewaygateway']['ewayCustomerInvoiceRef'] = ' ';
		$nodes['ewaygateway']['ewayTrxnNumber'] = ' ';
		$nodes['ewaygateway']['ewayOption1'] = ' ';
		$nodes['ewaygateway']['ewayOption2'] = ' ';
		$nodes['ewaygateway']['ewayOption3'] = ' ';	
								
		$request = $this->payments->build_xml_request(
			$this->_api_settings['xml_version'],
			$this->_api_settings['encoding'],
			$nodes
		);
		
		return $request;	
	}

	/**
	 * Make a oneoff payment
	 * @param	array	An array of payment params, sent from your controller / library
	 * @return	object	The response from the payment gateway
	*/	
	public function eway_oneoff_payment($params)
	{
		$this->_request = $this->_build_request($params, 'authCaptureTransaction');			
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
	 * Parses the XML response from the gateway and returns success or failure, along with details
	 *
	 * @param	object
	 * @return	object
	 */		
	private function _parse_response($response)
	{
		$details = (object) array();

		$as_array = $this->payments->arrayize_object($response);
		
		if($as_array['ewayTrxnStatus'] == 'True')
		{
			$details->identifier = $as_array['ewayTrxnNumber'];
			
			return $this->payments->return_response(
				'Success',
				$this->payments->payment_type.'_success',
				'gateway_response',
				$details
			);
		}
		else
		{
			$details->reason = $as_array['ewayTrxnError'];
			$details->gateway_response = $as_array;
			
			return $this->payments->return_response(
				'Failure',
				$this->payments->payment_type.'_gateway_failure',
				'gateway_response',
				$details
			);			
		}
		
		return $as_array;		
	}
}