<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');

class MY_Form_validation extends CI_Form_validation
{
    private $use_nonce = FALSE;

    /**
     * Create a new unique nonce, save it to the current session and return it.
     */
    public function create_nonce() {
        $nonce = md5(rand() . $this->CI->input->ip_address() . microtime());
        $this->CI->session->set_userdata('nonce', $nonce);
        return $nonce;
    }

    public function has_nonce() {
        return $this->use_nonce;
    }

    public function run($group = '') {
        $this->use_nonce = TRUE;
        $this->set_rules('nonce', 'Nonce', 'required|valid_nonce');
        $result = parent::run($group);
        if($result === true) {
            $this->save_nonce();
        }
        return $result;
    }

    /**
     * Mark the nonce sent from the form as already used.
     */
    private function save_nonce() {
        $this->CI->session->set_userdata('old_nonce', $this->set_value('nonce'));
    }

    /**
     * Set form validation rules for the nonce.
     */
    function nonce() {
        $this->use_nonce = true;
        $this->set_rules('nonce', 'Nonce', 'required|valid_nonce');
    }

    /**
     * Make sure the nonce is valid.
     */
    function valid_nonce($str) {
        return ($str == $this->CI->session->userdata('nonce') &&
                $str != $this->CI->session->userdata('old_nonce'));
    }

	function MY_Form_validation()
	{
		parent::CI_Form_validation();

		$this->CI->load->language('extra_validation');
	}

	/**
	 * Alpha-numeric with underscores dots and dashes
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	function alpha_dot_dash($str)
	{
		return ( ! preg_match("/^([-a-z0-9_\-\.])+$/i", $str)) ? FALSE : TRUE;
	}

	/**
	 * Checks that a surname is valid
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	function surname($str)
	{
		return ( ! preg_match("/^([-a-z\'0-9_-])+$/i", $str)) ? FALSE : TRUE;
	}

	
} 