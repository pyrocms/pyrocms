<?php  defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		Rick Ellis
 * @copyright	Copyright (c) 2006, EllisLab, Inc.
 * @license		http://www.codeignitor.com/user_guide/license.html
 * @link		http://www.codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter User_lib Class
 *
 * Handles logic and functions for user registration and activation.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Philip Sturgeon
 * @link		
 */
class User_lib
{
    var $CI;
    var $user_table = 'users';
	
	var $user_data;
	
	var $error_code = '';

    function __construct()
    {
        $this->CI =& get_instance();
        log_message('debug', "User_lib Class Initialized");
        
		$this->CI->load->library('session');
        $this->CI->load->model('users/users_m');
        
        $this->CI->lang->load('email');
        
        if( $this->logged_in() )
        {
        	$this->user_data = $this->CI->users_m->get( array( 'id' => $this->CI->session->userdata('user_id') ) );
        }
    }

    /**
     * Create a user account
     *
     * @access    public
     * @param    string
     * @param    string
     * @param    bool
     * @return    bool
     */
    function create($email = '', $password = '') {      

		//Make sure account info was sent
        if( $email == '' OR $password == '' )
        {
			$this->error_code = 'user_email_pass_missing';
            return false;
        }
		
		$this->CI->load->helper(array('string', 'security'));
        $salt = random_string('alnum', 5);
        $activation_code = random_string('alnum', 8);
		
		$this->user_data->email = $email;
		$this->user_data->password = dohash($password . $salt);
		$this->user_data->salt = $salt;
		$this->user_data->first_name = $this->CI->input->post('first_name', TRUE);
		$this->user_data->last_name = $this->CI->input->post('last_name', TRUE);
		$this->user_data->full_name = $this->user_data->first_name . ( $this->user_data->last_name != '' ? ' '. $this->user_data->last_name : '' );
		$this->user_data->role = $this->CI->input->post('role', TRUE);
		$this->user_data->activation_code = $activation_code;

        //Check against user table
        if ($this->CI->users_m->get(array('email'=>$email))):
            // email already exists
			$this->error_code = 'user_email_exists';
            return false;
        endif;
		
        // return true/false
        $this->user_data->id = $this->CI->users_m->add($this->user_data);
		return $this->user_data->id;

    }
	
	function admin_create($username = '', $password = '', $entry = array()) {
    /*
        //Put here for PHP 4 users
        $this->CI =& get_instance();        

		$this->CI->load->helper('password');

		//Make sure account info was sent
        if($username == '' OR $password == ''):
            return false;
        endif;
		
		// Update password
		$entry['user_password']	= encryptPassword($password);

        //Check against user table
        $this->CI->db->where('user_name', $username);
        $query = $this->CI->db->get_where($this->user_table);
        
        if ($query->num_rows() > 0):
            //username already exists
            return false; 
        endif;
		
		$this->CI->db->where('email', $entry['email']);
        $query = $this->CI->db->get_where($this->user_table);
        
        if ($query->num_rows() > 0):
            //email already exists
            return false; 
        else:		
			return ($this->CI->user_model->insert($entry));

        endif;
	*/
	}
    
	// --------------------------------------------------------------------
	
	/**
	 * Set the mode of the creation
	 *
	 * @access	public
	 * @param	string
	 
	 * @return	void
	 */	
	function login($email = '', $password = '')
    {
        $this->CI->load->helper('security');
		
        if($this->CI->session->userdata('user_id'))
        {
        	$this->error_code = 'user_already_logged_in';
            return FALSE;
        }
        
        // Get the user with these details
        $this->user_data = $this->CI->users_m->get(array('email'=>$email));
        
        // No user, or passwords do not match
        if( !$this->user_data or $this->user_data->password != dohash($password . $this->user_data->salt))
        {
        	$this->error_code = 'user_login_incorrect';
            return FALSE;
		}
        
        // Check user is active
        if ($this->user_data->active == 0)
        {
            $this->error_code = 'user_inactive';
            return FALSE;
		}
	
		// They are in -------------------------------------------------------------------------------------------------------------
				
		// Update last login
		$this->CI->users_m->update_last_login($this->user_data->id);

		// Destroy old session
		$this->CI->session->sess_destroy();
		
		// Create a fresh new session
		$this->CI->session->sess_create();
	
		// Set the user id to a CI session
		$this->CI->session->set_userdata('user_id', $this->user_data->id);
		
		// Set the language for this user
		$this->set_lang_cookie($this->user_data->lang);

		return TRUE;
	}
	
	
	function logout()
	{
		// Wipe user id
		$this->CI->session->unset_userdata('user_id');
		
		// Destroy session
        $this->CI->session->sess_destroy();
        
        // Remove the lang cookie
        $this->unset_lang_cookie();
	}

	
	function activate($id, $code = '')
	{
		// Check against user table
        if(!$this->user_data = $this->CI->users_m->get(array('id'=>$id, 'activation_code'=>$code))):
            // email already exists
			$this->error_code = 'user_activation_wrong';
            return false; 
        endif;
		
		if ($this->user_data->active == 0):
			
			// Activate the user in the database
			return $this->CI->users_m->activate($this->user_data->id);
			
		endif;
		return false;
	}
	
	
	function reset_password($first_name, $last_name, $email)
	{
		$this->CI->load->helper(array('string', 'security'));
        
		// Find a user with the supplied details
		$this->user_data = $this->CI->users_m->get(array(
			'first_name'=> $first_name,
			'last_name'	=> $last_name,
			'email'		=> $email
		));
		
		// No user found
		if(!$this->user_data): 
			$this->error_code = 'user_forgot_incorrect';
            return FALSE;
        endif;
        
        // Create a new password
		$password = random_string('alnum', 8);
		
		// Update user object with new password
		$this->user_data->password = dohash($password . $this->user_data->salt);
		
		// Store the new encrypted password in the database
		$result = $this->CI->users_m->update($this->user_data->id, array('password' => $this->user_data->password));
		
		return $result ? $password : FALSE;
	}
	
	
	function logged_in()
	{
		return $this->CI->session->userdata('user_id') > 0;
	}
    
	
	function check_role($role = NULL)
	{
		return isset($this->user_data->role) && $this->user_data->role == $role;
	}
	
	// --------------------------------------------------------------------
	
	function set_lang_cookie($lang) {
		// set to zero we'll set the expiration two years from now.
		$expire = ($this->CI->config->item('sess_expiration')) ? $this->CI->config->item('sess_expiration') : (60*60*24*365*2); // CI default as correct at 1.7.0
		
		// Set the lang setting in a native PHP cookie so it can be picked up by hooks/pick_language.php
		setcookie(
			'lang_code',
			$lang,
			$expire + time(),
			$this->CI->config->item('cookie_path'),
			$this->CI->config->item('cookie_domain'),
			0
		);
	}
	
	function unset_lang_cookie() {
		
		$_SESSION['lang_code'] = NULL;
		
		// Unset the lang setting
		setcookie(
			'lang_code',
			'',
			0,
			$this->CI->config->item('cookie_path'),
			$this->CI->config->item('cookie_domain'),
			0
		);
	}
	
	// --------------------------------------------------------------------

	
	function registered_email($user)
	{
		$this->CI->load->library('email');
		$this->CI->load->helper('text');

		// Send it from the server
		$this->CI->email->from($this->CI->settings->item('server_email'), $this->CI->settings->site_name);
		$this->CI->email->to($user->email);
		
		$this->CI->email->subject($this->CI->lang->line('user_activation_email_subject'));
		
		// Send it in both HTML and plain text form
		$this->CI->email->message( $this->CI->load->view('emails/activation_required', $user, TRUE) );
		
		return $this->CI->email->send();
	}
	

	function activated_email($user)
	{
		$this->CI->load->library('email');
		$this->CI->load->helper('text');

		// Send it from the server
		$this->CI->email->from($this->CI->settings->item('server_email'), $this->CI->settings->site_name);
		$this->CI->email->to($user->email);
		
		$this->CI->email->subject($this->CI->lang->line('user_activated_email_subject'));
		
		// Send it in both HTML and plain form.
		$this->CI->email->message( $this->CI->load->view('emails/activation_complete', $user, TRUE) );
		
		return $this->CI->email->send();
	}
	
	
	function reset_password_email($user, $new_password)
	{
		$user->new_password = $new_password;
		
		$this->CI->load->library('email');
		$this->CI->load->helper('text');

		// Send it from the server
		$this->CI->email->from($this->CI->settings->item('server_email'), $this->CI->settings->site_name);
		$this->CI->email->to($user->email);
		
		$this->CI->email->subject($this->CI->lang->line('user_reset_pass_email_subject'));
		
		// Send it in both HTML and plain form.
		$this->CI->email->message( $this->CI->load->view('emails/reset_password', $user, TRUE) );
		
		return $this->CI->email->send();
	}
}
?>