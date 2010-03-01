<?php

	// ================================
	// 	CodeIgniter Library conversion by Elliot Haughin
	//	http://www.haughin.com/
	// ================================


	define("AKISMET_SERVER_NOT_FOUND",	0);
	define("AKISMET_RESPONSE_FAILED",	1);
	define("AKISMET_INVALID_KEY",		2);

	class Akismet {
	
		var $akismet_version = '1.1';
		var $akismet_server = 'rest.akismet.com';
		var $api_port = 80;
		
		var $ignore = array(
			'HTTP_COOKIE',
			'HTTP_X_FORWARDED_FOR',
			'HTTP_X_FORWARDED_HOST',
			'HTTP_MAX_FORWARDS',
			'HTTP_X_FORWARDED_SERVER',
			'REDIRECT_STATUS',
			'SERVER_PORT',
			'PATH',
			'DOCUMENT_ROOT',
			'SERVER_ADMIN',
			'QUERY_STRING',
			'PHP_SELF',
			'argv'
		);
		
		var $api_key;
		var $blog_url;
		var $errors = array();
		var $comment = array();
	
		function Akismet()
		{			
		}
		
		function init($config)
		{
			foreach ($config as $key => $value)
			{
				$this->$key = $value;
			}
			
			$this->set_comment($this->comment);

			$this->_connect();
			
			if($this->errors_exist())
			{
				$this->errors = array_merge($this->errors, $this->get_errors());
			}
			
			// Check if the API key is valid
			if(!$this->_is_valid_api_key($this->api_key))
			{
				$this->set_error('AKISMET_INVALID_KEY', "Your Akismet API key is not valid.");
			}
		}
		
		// Connect to the Akismet server and store that connection in the instance variable $con
		function _connect()
		{
			if(!($this->con = @fsockopen($this->akismet_server, $this->api_port)))
			{
				$this->set_error('AKISMET_SERVER_NOT_FOUND', "Could not connect to akismet server.");
			}
		}
		
		// Close the connection to the Akismet server
		function _disconnect()
		{
			@fclose($this->con);
		}
		
		function get_response($request, $path, $type = "post", $response_length = 1160)
		{
			$this->_connect();
			
			if($this->con && !$this->is_error('AKISMET_SERVER_NOT_FOUND'))
			{
				$request  = 
						strToUpper($type)." /{$this->akismet_version}/$path HTTP/1.0\r\n" .
						"Host: ".((!empty($this->api_key)) ? $this->api_key."." : null)."{$this->akismet_server}\r\n" .
						"Content-Type: application/x-www-form-urlencoded; charset=utf-8\r\n" .
						"Content-Length: ".strlen($request)."\r\n" .
						"User-Agent: Akismet CodeIgniter Library\r\n" .
						"\r\n" .
						$request
					;
				$response = "";
		
				@fwrite($this->con, $request);
		
				while(!feof($this->con))
				{
					$response .= @fgets($this->con, $response_length);
				}
		
				$response = explode("\r\n\r\n", $response, 2);
				return $response[1];
			}
			else
			{
				$this->set_error('AKISMET_RESPONSE_FAILED', "The response could not be retrieved.");
			}
			
			$this->_disconnect();
		}
		
		function set_error($name, $message)
		{
			$this->errors[$name] = $message;
		}
		
		function get_error($name)
		{
			if($this->is_error($name))
			{
				return $this->errors[$name];
			}
			else
				{
				return false;
			}
		}
		 
		function get_errors()
		{
			return (array)$this->errors;
		}
		
		function is_error($name)
		{
			return isset($this->errors[$name]);
		}
		
		function errors_exist()
		{
			return (count($this->errors) > 0);
		}
		
		function is_spam()
		{
			$response = $this->get_response($this->_get_query_string(), 'comment-check');
			
			return ($response == "true");
		}
		
		
		function submit_spam()
		{
			$this->get_response($this->_get_querystring(), 'submit-spam');
		}
		
		
		function submit_ham()
		{
			$this->get_response($this->_get_query_string(), 'submit-ham');
		}
		
		function set_comment($comment)
		{
			$this->comment = $comment;
			
			if(!empty($comment))
			{
				$this->_format_comment_array();
				$this->_fill_comment_values();
			}
		}
		
		function get_comment()
		{
			return $this->comment;
		}
		
		function _is_valid_api_key($key)
		{
			$key_check = $this->get_response("key=".$this->api_key."&blog=".$this->blog_url, 'verify-key');
				
			return ($key_check == "valid");
		}
		
		function _format_comment_array() {
			
			$format = array(
					'type' => 'comment_type',
					'author' => 'comment_author',
					'email' => 'comment_author_email',
					'website' => 'comment_author_url',
					'body' => 'comment_content'
				);
			
			foreach($format as $short => $long)
			{
				if(isset($this->comment[$short]))
				{
					$this->comment[$long] = $this->comment[$short];
					unset($this->comment[$short]);
				}
			}
		}
		
		
		/**
		 * Fill any values not provided by the developer with available values.
		 *
		 * @return	void
		 */
		
		function _fill_comment_values()
		{
			if(!isset($this->comment['user_ip']))
			{
				$this->comment['user_ip'] = ($_SERVER['REMOTE_ADDR'] != getenv('SERVER_ADDR')) ? $_SERVER['REMOTE_ADDR'] : getenv('HTTP_X_FORWARDED_FOR');
			}
			
			if(!isset($this->comment['user_agent']))
			{
				$this->comment['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
			}
			
			if(!isset($this->comment['referrer']) && !empty($_SERVER['HTTP_REFERER']))
			{
				$this->comment['referrer'] = $_SERVER['HTTP_REFERER'];
			}
			
			if(!isset($this->comment['blog']))
			{
				$this->comment['blog'] = $this->blog_url;
			}
		}
		
		
		function _get_query_string()
		{
			foreach($_SERVER as $key => $value)
			{
				if(!in_array($key, $this->ignore))
				{
					if($key == 'REMOTE_ADDR')
					{
						$this->comment[$key] = $this->comment['user_ip'];
					}
					else
					{
						$this->comment[$key] = $value;
					}
				}
			}
	
			$query_string = '';
	
			foreach($this->comment as $key => $data)
			{
				$query_string .= $key . '=' . urlencode(stripslashes($data)) . '&';
			}
	
			return $query_string;
		}
	}
	
?>
