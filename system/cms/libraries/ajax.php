<?php

	/**
	 * PHP AJAX Response Class
	 * A normalized format of sending AJAX requested responses.
	 */

	class Ajax {

		// Codeigniter instance
		protected $CI;

		protected $has_zlib = false;
		protected $is_jsonp = true;

		// Internal definitions to be used by the AJAX class
		public $_STATUS = array(
			'MSG'   => 1,
			'INFO'  => 2,
			'ERROR' => 3,
			'WARN'  => 4,
		);

		public $response_type = 'json';
		public $response_data = array();
		public $supported_types = array(
			'xml'        => 'application/xml',
			'json'       => 'application/json',
			'jsonp'      => 'application/javascript',
			'serialized' => 'application/vnd.php.serialized',
			'php'        => 'text/plain',
			'html'       => 'text/html',
			'csv'        => 'application/csv'
		);

		function __construct()
		{
			$this->CI = get_instance();
			$this->CI->load->library('format');
			$this->has_zlib = @ini_get('zlib.output_compression');
		}

		function type($type = 'json')
		{
			array_key_exists($type, $this->supported_types) and $this->response_type = $type;
			if ($this->response_type == 'jsonp')
			{
				$this->is_jsonp = true;
				$this->response_type = 'json';
			}
			return $this;
		}

		function data($data, $append=false)
		{
			$this->response_data = ($append)
				? $this->response_data + (array)$data
				: $this->response_data = (array)$data;

			return $this;
		}

		private function callback($data)
		{
			return $this->CI->input->get_post('callback').'('.$data.')';
		}

		public function response($data = array(), $http_code = null)
		{
			$data = array_merge($this->response_data, $data);
			// If data is empty and not code provide, error and bail
			if (empty($data) && $http_code === null)
			{
				$http_code = 404;

				// create the output variable here in the case of $this->response(array());
				$output = NULL;
			}

			// Otherwise (if no data but 200 provided) or some data, carry on camping!
			else
			{
				// Is compression requested?
				if ($this->has_zlib == FALSE and
					extension_loaded('zlib') and
					isset($_SERVER['HTTP_ACCEPT_ENCODING']) and
					strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== FALSE)
					{
						ob_start('ob_gzhandler');
					}

				is_numeric($http_code) or $http_code = 200;

				if (method_exists($this->CI->format, 'to_'.$this->response_type))
				{
					// Set the correct format header
					header('Content-Type: '.$this->supported_types[$this->response_type]);

					$output = $this->CI->format->factory($data)->{'to_'.$this->response_type}();

					if ($this->is_jsonp)
					{
						$output = $this->callback($output);
					}
				}

				// Format not supported, output directly
				else
				{
					$output = $data;
				}
			}

			header('HTTP/1.1: ' . $http_code);
			header('Status: ' . $http_code);
			$this->has_zlib or header('Content-Length: ' . strlen($output));

			exit($output);
		}
	}

?>