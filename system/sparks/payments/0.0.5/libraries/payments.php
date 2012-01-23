<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* CodeIgniter Payments
*
* Make payments to multiple payment systems using a single interface
*
* @package CodeIgniter
* @subpackage Sparks
* @category Payments
* @author Calvin Froedge (www.calvinfroedge.com)
* @created 07/02/2011
* @license http://www.opensource.org/licenses/mit-license.php
* @link https://github.com/calvinfroedge/codeigniter-payments
*/

class Payments
{
	/**
	 * The CodeIgniter instance
	*/		
	public $ci; 

	/**
	 * The version
	*/	
	public $mode;

	/**
	 * The payment module to use
	*/	
	public $payment_module;  

	/**
	 * The payment type to make
	*/		
	public $payment_type;	

	/**
	 * The params to use
	*/		
	private	$_params;
	
	/**
	 * Error codes in the response object
	*/		
	private $_response_codes;

	/**
	 * Response messages that can be returned to the user or logged in the application
	*/		
	private $_response_messages;
	
	/**
	 * The default params for the method
	*/	
	private	$_default_params;

	/**
	 * The default params for the method
	*/	
	public $required_params;
	
	/**
	 * Custom Gateway Credentials
	*/
	public $gateway_credentials;	
		
	/**
	 * The constructor function.
	 */	
	public function __construct()
	{
		$this->ci =& get_instance();
		$this->mode = $this->ci->config->item('payments_mode');
		$this->_response_codes = $this->ci->config->item('response_codes');
		$this->ci->lang->load('response_messages');	
		$this->ci->lang->load('response_details');
		$this->ci->load->spark('curl/1.2.1');
		$this->_connection_is_secure();
	}

	/**
	 * Make a call to a gateway. Uses other helper methods to make the request.
	 *
	 * @param	string	The payment method to use
	 * @param	array	$params[0] is the gateway, $params[1] are the params for the request
	 * @return	object	Should return a success or failure, along with a response.
	 */		
	public function __call($method, $params)
	{
		$supported = $this->_check_method_supported($method);
		
		if($supported)
		{
			$response = $this->_make_gateway_call($params[0], $method, $params[1]);
		}
		else
		{
			$response = $this->return_response(
				'failure', 
				'not_a_method', 
				'local_response'
			);
		}
		return $response;
	}

	/**
	 * Checks to ensure that a method is actually supported by cf_payments before continuing
	 *
	 * @param	string	The payment method to use
	 * @return	object	Should return a success or failure, along with a response.
	 */	
	private function _check_method_supported($method)
	{
		$supported_methods = $this->ci->config->item('supported_methods');
		return in_array($method, $supported_methods);
	}

	/**
	 * Make a call to a gateway. Uses other helper methods to make the request.
	 *
	 * @param	string	The payment module to use
	 * @param	string	The type of method being used.
	 * @param	array	Params to submit to the payment module
	 * @return	object	Should return a success or failure, along with a response.
	 */	
	private function _make_gateway_call($payment_module, $payment_type, $params)
	{	
		$module_exists = $this->_load_module($payment_module);

		if($module_exists === FALSE)
		{
			return $this->return_response(
				'failure', 
				'not_a_module', 
				'local_response'
			);
		}
		else
		{
			$this->ci->load->config('payments/'.$payment_module);
			$this->payment_type = $payment_type;
			
			if(isset($params['gateway_credentials']))
			{
				$this->gateway_credentials = $params['gateway_credentials'];
				unset($params['gateway_credentials']);
			}
				
			$valid_inputs = $this->_check_inputs($payment_module, $params);
			if($valid_inputs === TRUE)
			{
				$this->_params = $params;	
				$response = $this->_do_method($payment_module);
				return $response;		
			}
			else
			{
				return $valid_inputs;	
			}
		}	
	}
	
	/**
	 * Try use a method from a particular gateway
	 *
	 * @param	string	The payment module to use
	 * @param	string	The type of method being used.  Can be for making payments or getting statuses / profiles.
	 * @param	array	Params to submit to the payment module
	 * @return	object	Should return a success or failure, along with a response
	 */		
	private function _do_method($payment_module)
	{				
		$object = new $payment_module($this);
		
		$method = $payment_module.'_'.$this->payment_type;
		
		if(!method_exists($payment_module, $method))
		{
			return $this->return_response(
				'failure', 
				'not_a_method', 
				'local_response'
			);	
		}
		else
		{
			$this->ci->load->config('payment_types/'.$this->payment_type);
			$this->_default_params = $this->ci->config->item($this->payment_type);
			return $object->$method(
				array_merge(
					$this->_default_params, 
					$this->_params
				)
			);						
		}
	}

	/**
	 * Try to load a payment module
	 *
	 * @param	string	The payment module to load
	 * @return	mixed	Will return bool if file is not found.  Will return file as object if found.
	 */		
	private function _load_module($payment_module)
	{
		$module = dirname(__FILE__).'/payments/'.$payment_module.'.php';
		if (!is_file($module))
		{
			return FALSE;
		}
		ob_start();
		include $module;
		return ob_get_clean();
	}

	/**
	 * Check user inputs to make sure they're good
	 *
	 * @param	string	The payment module
	 * @param	array	An array of params
	 * @return	mixed	Will return bool if file is not found.  Will return file as object if found.
	 */
	private function _check_inputs($payment_module, $params)
	{
		$expected_datatypes = array(
			'string'	=> $payment_module,
			'arrays'	=> array($params)
		);
		
		$expected_datatypes = $this->_check_datatypes($expected_datatypes);
		if ($expected_datatypes === FALSE)
		{
			return $this->return_response(
				'failure', 
				'invalid_input', 
				'local_response'
			);		
		}

		$expected_params = $this->_check_params($payment_module, $params);
		
		if($expected_params !== TRUE)
		{
			return $expected_params;
		}
		
		return TRUE;
	}

	/**
	 * Make sure data types are as expected
	 *
	 * @param	array	array of params to check to ensure proper datatype
	 * @return	mixed	Will return TRUE if all pass.  Will return an object if datatypes are bad.
	 */		
	private function _check_datatypes($datatypes)
	{
		$invalids = 0;
		
		foreach($datatypes as $key=>$value)
		{
			if($key == 'arrays')
			{
				foreach($value as $array)
				{
					if(!is_array($array))
					{
						++$invalids;
					}			
				}
			}
			else
			{
				$check = 'is_'.$key;
				
				if(!$check($value))
				{
					++$invalids;
				}
			}
		}
		
		if($invalids)
		{
			return FALSE;
		}
		
		return TRUE;
	}

	/**
	 * Make sure params are as expected
	 *
	 * @param	string	the name of the payment module being used
	 * @param	array	array of params to check to ensure proper formatting
	 * @return	mixed	Will return TRUE if all pass.  Will return an object if a param is bad.
	 */			
	private function _check_params($payment_module, $params)
	{
		//Ensure required params are present
		$req = $this->ci->config->item('required_params');
		if( ! isset($req[$this->payment_type]))
		{
			return $this->return_response(
				'failure', 
				'not_a_method', 
				'local_response'
			);
		}
		
		$this->required_params = $req;
		$req = $req[$this->payment_type];
		
		$missing = array();
		
		foreach($req as $k=>$v)
		{	
			if(!array_key_exists($v, $params) OR empty($params[$v]) OR is_null($params[$v]) OR $params[$v] == ' ')
			{
				$missing[] = $this->ci->lang->line('response_detail_missing_'.$v);
			}
		}
		
		if(count($missing) > 0)
		{
			return $this->return_response(
				'failure', 
				'required_params_missing', 
				'local_response',
				$missing
			);					
		}
		
		//Ensure dates match MMYYYY format
		if(array_key_exists('cc_exp', $params))
		{
			$exp_date = $params['cc_exp'];
			$m1 = $exp_date[0];
			
			if(strlen($exp_date) != 6 OR !is_numeric($exp_date) OR $m1 > 1)
			{
				return $this->return_response(
					'failure', 
					'invalid_input', 
					'local_response', 
					$this->ci->lang->line('response_detail_invalid_date_format')
				);
			}
		}
		
		//Ensure billing period is submitted in normalized form
		if(array_key_exists('billing_period', $params))
		{
			$accepted_billing_period = array(
				'Month',
				'Day',
				'Week',
				'Year'
			);
			
			if(!in_array($params['billing_period'], $accepted_billing_period))
			{
				return $this->return_response(
					'failure', 
					'invalid_input', 
					'local_response', 
					$this->ci->lang->line('response_detail_invalid_billing_period')
				);			
			}
		}
		
		return TRUE;
	}

	/**
	 * Remove key=>value pairs with empty values
	 *
	 * @param	array	array of key=>value pairs to check
	 * @return	array	Will return filtered array
	 */
	public function filter_values($array)
	{	
		foreach($array as $k=>$v)
		{
			$v = trim($v);
			if(empty($v) AND !is_numeric($v))
			{
				unset($array[$k]);
			}
		}
		return $array;
	}

	/**
	 * Returns an xml document
	 *
	 * @param 	array	the structure for the xml
	 * @return	string	a well-formed XML string
	*/	
	public function build_xml_request($xml_version, $character_encoding, $xml_params, $parent = NULL, $xml_schema = NULL, $xml_extra = NULL)
	{
		$xml = '<?xml version="'.$xml_version.'" encoding="'.$character_encoding.'"?>';

		if(!is_null($xml_extra))
		{
			$xml .= '<?'.$xml_extra.'?>';
		}
		
		if(!is_null($parent) AND is_null($xml_schema))
		{
			$xml .= '<'.$parent.'>';
		}
				
		if(!is_null($parent) AND !is_null($xml_schema))
		{
			$xml .= '<'.$parent.' '.$xml_schema.'>';
		}
		
		$xml .= $this->build_nodes($xml_params);
		
		if(!is_null($parent))
		{
			$xml .= '</'.$parent.'>';
		}
		
		return $xml;
	}
	
	/**
	 * Returns a well-formed string of XML nodes
	 *
	 * @param	array	associative array of values
	 * @return	string	well-formed XML string
	*/
	public function build_nodes($params, $key_to_set = NULL)
	{
		$string = "";
		$dont_wrap = FALSE;
		
		foreach($params as $k=>$v)
		{		
			if(is_bool($v) AND $v === TRUE)
			{
				$v = 'true';
			}
			
			if(is_bool($v) AND $v === FALSE)
			{
				$v = 'false';
			}
			
			if(empty($v) AND $v != '0')
			{
				unset($k);
				continue;
			}
			
			if(is_array($v))
			{		
				if($k === 'repeated_key')
				{					
					if($v['wraps'] === FALSE)
					{
						$dont_wrap = TRUE;
					}
					
					$node_name = $v['name'];
					$node_contents = $this->build_nodes($v['values'], $v['name']);
				}
				else
				{
					$node_name = $k;
					$node_contents = $this->build_nodes($v);
				}
			}
			
			if(!is_array($v))
			{
				$node_name = $k;
				$node_contents = $v;
			}
			
			if($key_to_set !== NULL)
			{
				$node_name = $key_to_set;
			}
				
			if(!empty($node_contents) AND $dont_wrap === TRUE)
			{
				$string .= $node_contents;
			}

			if(!empty($node_contents) AND $dont_wrap === FALSE)
			{		
				$string .= '<'.$node_name.'>';
				$string .= $node_contents;
				$string .= '</'.$node_name.'>';
			}	
			
			if($node_contents === '0' AND $dont_wrap === TRUE)
			{
				$string .= $node_contents;			
			}

			if($node_contents === '0' AND $dont_wrap === FALSE)
			{
				$string .= '<'.$node_name.'>';
				$string .= $node_contents;
				$string .= '</'.$node_name.'>';			
			}					
		}
		return $string;
	}

	/**
	 * Parses an XML response and creates an object using SimpleXML
	 *
	 * @param 	string	raw xml string
	 * @return	object	response object
	*/		
	public function parse_xml($xml_str)
	{
		$xml_str = trim($xml_str);
		$xml_str = preg_replace('/xmlns="(.+?)"/', '', $xml_str);
		if($xml_str[0] != '<')
		{
			$xml_str = explode('<', $xml_str);
			unset($xml_str[0]);
			$xml_str = '<'.implode('<', $xml_str);
		}
		
		$xml = new SimpleXMLElement($xml_str);
		
		return $xml;
	}

	/**
	 * Arrayize an object
	 *
	 * @param	object	the object to convert to an array
	 * @return	array	a converted array
	*/
	public function arrayize_object($input)
	{
		if(!is_object($input))
		{
			return $input;
		}
		else
		{
			$final = array();
			$vars = get_object_vars($input);
			foreach($vars as $k=>$v)
			{
				if(is_object($v))
				{
					$final[$k] = $this->arrayize_object($v);
				}
				else
				{
					$final[$k] = $v;
				}
			}
		}
	
		return $final;
	}

	/**
	 * Makes the actual request to the gateway
	 *
	* @param   string  This is the API endpoint currently being used
    * @param  string  The data to be passed to the API
    * @param  string  A specific content type to define for cURL request
	* @return	object	response object
	*/	
	public function gateway_request($query_string, $payload = NULL, $content_type = NULL, $custom_headers = NULL)
	{
		$headers = (is_null($custom_headers)) ? array() : $custom_headers;
		
		$this->ci->curl->create($query_string);	
		$this->ci->curl->option('FAILONERROR', FALSE);

		if(is_null($payload))
		{
			$request = $this->ci->curl->execute();
			if($request[0] == '<')
			{
				return $this->parse_xml($request);
			}
			else
			{
				return $request;
			}
		}
		else
		{
			if(is_null($content_type))
			{
				$xml = TRUE;
				$headers[] = "Content-Type: text/xml";
			}
			else
			{
				if(strpos($content_type, 'xml') !== FALSE)
				{
					$xml = TRUE;
				}
				
				$headers[] = "Content-Type: $content_type";
			}
			
			$this->ci->curl->option(CURLOPT_HTTPHEADER, $headers);
			$this->ci->curl->option(CURLOPT_POSTFIELDS, $payload);

			$request = $this->ci->curl->execute();
			
			if(isset($xml) && $xml === TRUE)
			{
				return $this->parse_xml($request);
			}
			else
			{
				return $request;
			}
		}
	}
		
	/**
	 * Returns the response
	 *
	 * @param 	string	can be either 'Success' or 'Failure'
	 * @param	string	the response used to grab the code / message
	 * @param	string	whether the response is coming from the application or the gateway
	 * @param	mixed	can be an object, string or null.  Depends on whether local or gateway.
	 * @return	object	response object
	*/	
	public function return_response($status, $response, $response_type, $response_details = null)
	{
		$status = strtolower($status);
		
		($status == 'success')
		? $message_type = 'info'
		: $message_type = 'error';
		
		log_message($message_type, $this->_response_messages[$response]);
		
		if($response_type == 'local_response')
		{
			$local_response = $this->_return_local_response($status, $response, $response_details);
			return $local_response;
		}
		else if($response_type == 'gateway_response')
		{
			$gateway_response = $this->_return_gateway_response($status, $response, $response_details);
			return $gateway_response;			
		}

	}

	/**
	 * Returns a local response
	 *
	 * @param 	string	can be either 'Success' or 'Failure'
	 * @param	string	the response used to grab the code / message
	 * @param	mixed	can be string or null. 
	 * @return	object	
	*/	
	private function _return_local_response($status, $response, $response_details = null)
	{
		$status = strtolower($status);
		
		($status == 'success')
		? $message_type = 'info'
		: $message_type = 'error';
			
		log_message($message_type, $this->ci->lang->line('response_message_'.$response));
		
		if(is_null($response_details))
		{
			return (object) array
			(
				'type'				=>	'local_response',
				'status' 			=>	$status, 
				'response_code' 	=>	$this->_response_codes[$response], 
				'response_message' 	=>	$this->ci->lang->line('response_message_'.$response)
			);			
		}
		else
		{
			return (object) array
			(
				'type'				=>	'local_response',
				'status' 			=>	$status, 
				'response_code' 	=>	$this->_response_codes[$response], 
				'response_message' 	=>	$this->ci->lang->line('response_message_'.$response),
				'details'			=>	$response_details
			);				
		}	
	}

	/**
	 * Returns a gateway response
	 *
	 * @param 	string	can be either 'Success' or 'Failure'
	 * @param	string	the response used to grab the code / message
	 * @param	mixed	can be string or null. 
	 * @return	object	
	*/	
	private function _return_gateway_response($status, $response, $details)
	{	
		return (object) array
		(
			'type'				=>	'gateway_response',
			'status' 			=>	$status, 
			'response_code' 	=>	$this->_response_codes[$response], 
			'response_message' 	=>	$this->ci->lang->line('response_message_'.$response),
			'details'			=>	$details
		);		
	}	
	
	/**
	 * Connection is Secure
	 * 
	 * Checks whether current connection is secure and will redirect
	 * to secure version of page if 'force_secure_connection' is TRUE
	 * 
	 * To Force HTTPS for your entire website, use a .htaccess like the following:
	 *
	 *  RewriteEngine On
	 *  RewriteCond %{SERVER_PORT} 80
	 *  RewriteRule ^(.*)$ https://domain.com/$1 [R,L]
	 * 
	 * @link http://davidwalsh.name/force-secure-ssl-htaccess
	 * @return	bool
	 */
	private function _connection_is_secure()
	{
		// Check whether secure connection is required
		if($this->ci->config->item('force_secure_connection') === FALSE) 
		{
			log_message('error', 'WARNING!! Using Payment Gateway without Secure Connection!');
			return FALSE;
		}
		
		// Redirect if NOT secure and forcing a secure connection.
		if(($_SERVER['SERVER_PORT'] === '443' && isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') === FALSE)
		{
			log_message('debug', 'Forcing Secure Connection for Payment Gateway');
			$loc = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			$this->ci->load->helper('url');
			redirect($loc);
			exit;
		}
		
		return TRUE; // Only Possible Outcome is TRUE
	}
}