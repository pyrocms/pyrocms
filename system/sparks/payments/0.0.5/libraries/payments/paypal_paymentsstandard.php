<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class PayPal_PaymentsStandard
{
	/**
	 *	The payments object
	*/
	public $payments;
	
	/**
	 * The API method currently being utilized
	*/
	private $_api_endpoint;	

	/**
	 * An array for storing all request data
	*/	
	private $_request = array();	

	/**
	 * Constructor method
	*/		
	public function __construct($payments)
	{
		$this->payments = $payments;
		$this->_api_endpoint = $this->payments->ci->config->item('api_endpoint'.'_'.$this->payments->mode);	
	}

	/**
	 * Builds the form used to generate the button
	 *
	 * @return	string
	*/	
	private function _build_form()
	{
		$this->payments->ci->load->helper('form');
		$form_attrs = array(
			'target' => 'paypal',
			'method' => 'post'
		);
		$form = form_open($this->_api_endpoint, $form_attrs);
		
		//Set some common variables
		$this->_request['business'] = $this->payments->ci->config->item('payment_email');
		
		$ipn = $this->payments->ci->config->item('ipn_url');
		if(!empty($ipn)) $this->_request['notify_url'] = $ipn;
		
		//End set common variables
		
		foreach($this->_request as $k=>$v)
		{
			$input = array(
				'type' => 'hidden',
				'name' => $k,
				'value' => $v
			);
			$form .= form_input($input);
		}
		
		$form .= '<input type="image" name="submit"border="0" src="https://www.paypal.com/en_US/i/btn/btn_buynow_LG.gif" alt="PayPal - The safer, easier way to pay online">';
		
		$form .= form_close();
		return $form;
	}

	/**
	 * Maps payment params to correct keys
	 *
	 * @param	array	An array of payment params
	 * @return	void
	*/		
	private function _map_params($params)
	{
		$map = $this->payments->ci->config->item('payment_to_gateway_key_map');
		$return = array();
		foreach($params as $k=>$v)
		{
			if(array_key_exists($k, $map))
			{
				$return[$map[$k]] = $v;
			}
		}
		$this->_request = $return;
	}
	
	/**
	 * Payment button
	 * @param	array	An array of payment params, sent from your controller / library
	 * @return	string	A well-formed HTML string
	*/	
	public function paypal_paymentsstandard_oneoff_payment_button($params)
	{	
		$this->_request['cmd'] = '_xclick';
		$this->_map_params($params);
		$form = $this->_build_form();	
		
		return $form;
	}

	/**
	 * Recurring payments button
	 * @param	array	An array of payment params, sent from your controller / library
	 * @return	string	A well-formed HTML string
	*/	
	public function paypal_paymentsstandard_recurring_payment_button($params)
	{
		$this->_request['cmd'] = '_xclick-subscriptions';
		
		if(isset($params['trial_billing_frequency']) OR isset($params['trial_billing_cycles']) OR isset($params['trial_amt']))
		{
			if(!isset($params['trial_billing_frequency'], $params['trial_billing_cycles'], $params['trial_amt']))
			{
				@unset($params['trial_billing_frequency'], $params['trial_billing_cycles'], $params['trial_amt']);
			}
			else
			{
				$this->_request['a1'] = $params['trial_amt'];
				$this->_request['t1'] = $this->_set_recurring_f($params['trial_billing_frequency']); 
				$this->_request['p1'] = $params['trial_billing_cycles'];
				unset($params['trial_billing_frequency'], $params['trial_billing_cycles'], $params['trial_amt']);
			}
		}
		
		if(isset($params['amt']) OR isset($params['billing_period']) OR isset($params['billing_frequency']) OR isset($params['total_billing_cycles']))
		{
			if(!isset($params['amt'], $params['billing_period'], $params['billing_frequency'], $params['total_billing_cycles']))
			{
				@unset($params['amt'], $params['billing_period'], $params['billing_frequency'], $params['total_billing_cycles']);
			}
			else
			{
				$this->_request['a3'] = $params['amt'];  
				$this->_request['t3'] = $this->_set_recurring_f($params['billing_frequency']);
				$this->_request['p3'] = $this->_set_recurring_f($params['total_billing_cycles']);
				
				unset($params['amt'], $params['billing_period'], $params['billing_frequency'], $params['total_billing_cycles']);
			}
		}
		
		$this->_request['src'] = ($this->payments->ci->config->item('payments_never_expire') === TRUE) ? 1 : 0;
		
		$this->_request['src'] = ($this->payments->ci->config->item('retry_on_failure') === TRUE) ? 1 : 0;
		
		$this->_request['no_note'] = ($this->payments->ci->config->item('hide_note') === TRUE) ? 1 : 0;
		
		$this->_request['modify'] = $this->payments->ci->config->item('modify');
		
		if($this->payments->ci->config->item('user_manage')) $this->_request['usr_manage'] = 1;
		
		$this->_map_params();
		
		$form = $this->_build_form();	
		
		return $form;	
	}		

	/**
	 * Sets the recurring freqency, converting the CI payments entry to gateway required standard
	 * @param	string
	 * @return	string
	*/		
	private function _set_recurring_f($choice)
	{
		$unit = strtolower($choice);
		switch($unit)
		{
			case "week":
				return 'W';
				break;
					
			case "month":
				return 'M';
				break;
					
			case "year":
				return 'Y';
				break;
					
			case "day":
				return 'D';
				break;
		}	
	}
}