<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Csrf library class
* 
* Protects against cross site request forgery attempts
*/
class Csrf {

	private $form_id;
	private $token;
	private $CI;

	public function Csrf()
	{
		log_message('debug', 'Csrf class initialized');
		// Get the CI super object
		$this->CI =& get_instance();
	}
   
	/**
	 * Create Token
	 *
	 * Creates and saves a form ID & token
	 *
	 * @access	public
	 * @return	array
	 */
	public function create_token()
	{
		log_message('debug', 'Csrf::create_token() called');

		// Get existing tokens from the session
		$tokens = $this->CI->session->userdata('tokens');

		if ( ! is_array($tokens))
		{
			$tokens = array();
		}

		// Remove old tokens
		$now = time();
		foreach (array_keys($tokens) as $key)
		{
			if ($tokens[$key]['ts'] > $now + 86400)
			{
				unset($tokens[$key]);
			}
		}

		// Limit the tokens saved. Less if stored in a cookie
		$numTokens = 3;
		if ($this->CI->config->item('sess_use_database'))
		{
			$numTokens = 10;
		}

		if (count($tokens) >= $numTokens)
		{
			// Trim and re-index the array but keep the array order.
			$tokens = array_values(array_slice($tokens, 0, $numTokens, TRUE));
		}

		// Generate data for the new token
		$token  = md5(uniqid(rand(), TRUE));
		$form_id = uniqid(rand());

		// Add the new token to the token array and save to the session
		$tokens[] = array('ts'=>$now, 'token'=>$token, 'form_id'=>$form_id);
		$this->CI->session->set_userdata('tokens', $tokens);

		// Save the token data for this instance
		$this->form_id = $form_id;
		$this->token  = $token;
		return array('form_id'=>$form_id, 'token'=>$token);

	}

	/**
	 * Get Token
	 *
	 * Returns the current form ID and token
	 *
	 * @access	public
	 * @return	array
	 */
	public function get_token()
	{
		log_message('debug', 'Csrf::get_token() called');
		if ( ! $this->form_id OR ! $this->token)
		{
			log_message('debug', 'Csrf::get_token() invalid token');
			return FALSE;
		}
		return array('form_id' => $this->form_id, 'token' => $this->token);
	}

	/**
	 * Save Token
	 *
	 * Saves a form ID and token
	 *
	 * @access	public
	 * @param   string  form_id
	 * @param   string  token
	 * @return	void
	 */
	public function save_token($form_id, $token)
	{
		log_message('debug', 'Csrf::save_token() called');
		$this->form_id = $form_id;
		$this->token  = $token;
	}

	/**
	 * Clear Token
	 * 
	 * Clears form ID and token after successful validation
	 *
	 * @access	public
	 * @return	void
	 */
	public function clear_token()
	{
		log_message('debug', 'Csrf::clear_token() called');

		// Get existing tokens
		$tokens = $this->CI->session->userdata('tokens');

		// No existing tokens. Clear current tokens and return.
		if ( ! is_array($tokens))
		{
			$this->form_id = $this->token = NULL;
			return NULL;
		}

		// Loop through existing tokens and remove this one only
		foreach (array_keys($tokens) as $key)
		{
			if ($tokens[$key]['form_id'] == $this->form_id)
			{
				unset($tokens[$key]);
			}
		}

		// Reindex the remaining tokens and save them to the session
		$tokens = array_values($tokens);
		$this->CI->session->set_userdata('tokens', $tokens);

		// Clear current tokens
		$this->form_id = $this->token = NULL;
	}

	/**
	 * Validate Token
	 * 
	 * Validates token sent in POST
	 *
	 * @access	public
	 * @param	string	  form_id
	 * @param	string	  token
	 * @return	void
	 */
	public function validate_token($form_id, $token)
	{
		log_message('debug', 'Csrf::validate_token() called');

		// Get existing tokens
		$tokens = $this->CI->session->userdata('tokens');

		// No known tokens
		if ( ! is_array($tokens))
		{
			return FALSE;
		}

		// Loop through tokens for a match
		foreach (array_keys($tokens) as $key)
		{
			if ($tokens[$key]['form_id'] == $form_id AND $tokens[$key]['token'] == $token)
			{
				return TRUE;
			}
		}
		return FALSE;
	}
}

/* End of file Csrf.php */