<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Ion Auth Model
*
* Author:  Ben Edmunds
* 		   ben.edmunds@gmail.com
*	  	   @benedmunds
*
* Added Awesomeness: Phil Sturgeon
*
* Location: http://github.com/benedmunds/CodeIgniter-Ion-Auth
*
* Created:  10.01.2009
*
* Description:  Modified auth system based on redux_auth with extensive customization.  This is basically what Redux Auth 2 should be.
* Original Author name has been kept but that does not mean that the method has not been modified.
*
* Requirements: PHP5 or above
*
*/


class Ion_auth_model extends CI_Model
{
	/**
	 * Holds an array of tables used
	 *
	 * @var string
	 **/
	public $tables = array();

	/**
	 * activation code
	 *
	 * @var string
	 **/
	public $activation_code;

	/**
	 * forgotten password key
	 *
	 * @var string
	 **/
	public $forgotten_password_code;

	/**
	 * new password
	 *
	 * @var string
	 **/
	public $new_password;

	/**
	 * Array of user data called
	 *
	 * @var string
	 **/
	public $users = array();

	/**
	 * Identity
	 *
	 * @var string
	 **/
	public $identity;

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->config('users/ion_auth', true);
		$this->load->helper('cookie');
		$this->load->helper('date');
		$this->load->library('session');
		$this->tables  = $this->config->item('tables', 'ion_auth');
		$this->columns = $this->config->item('columns', 'ion_auth');

		$this->identity_column = $this->config->item('identity', 'ion_auth');
	    $this->store_salt      = $this->config->item('store_salt', 'ion_auth');
	    $this->salt_length     = $this->config->item('salt_length', 'ion_auth');
	    $this->meta_join       = $this->config->item('join', 'ion_auth');

		$this->load->driver('Streams');

		$this->user_stream 			= $this->streams_m->get_stream('profiles', true, 'users');
		$this->user_stream_fields 	= $this->streams_m->get_stream_fields($this->user_stream->id);
	}

	// --------------------------------------------------------------------------

	/**
	 * Misc functions
	 *
	 * Hash password : Hashes the password to be stored in the database.
     * Hash password db : This function takes a password and validates it
     * against an entry in the users table.
     * Salt : Generates a random salt value.
	 *
	 * @author Mathew
	 */

	// --------------------------------------------------------------------------

	/**
	 * Hashes the password to be stored in the database.
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function hash_password($password, $salt=false)
	{
	    if (empty($password))
	    {
		return false;
	    }

	    if ($this->store_salt && $salt)
		{
			return  sha1($password . $salt);
		}
		else
		{
		$salt = $this->salt();
		return  $salt . substr(sha1($salt . $password), 0, -$this->salt_length);
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * This function takes a password and validates it
     * against an entry in the users table.
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function hash_password_db($id, $password)
	{
		if (empty($id) or empty($password))
		{
			return false;
		}

	   $query = $this->db->select('password')
						 ->select('salt')
						 ->where('id', $id)
						 ->where($this->ion_auth->_extra_where)
						 ->limit(1)
						 ->get($this->tables['users']);

		$hash_password_db = $query->row();

		if ($query->num_rows() !== 1)
		{
		    return false;
		}

		if ($this->store_salt)
		{
			return sha1($password . $hash_password_db->salt);
		}
		else
		{
			$salt = substr($hash_password_db->password, 0, $this->salt_length);

			return $salt . substr(sha1($salt . $password), 0, -$this->salt_length);
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Generates a random salt value.
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function salt()
	{
		return substr(md5(uniqid(rand(), true)), 0, $this->salt_length);
	}

	// --------------------------------------------------------------------------

	/**
	 * Activation functions
	 *
     * Activate : Validates and removes activation code.
     * Deactivae : Updates a users row with an activation code.
	 *
	 * @author Mathew
	 */

	// --------------------------------------------------------------------------

	/**
	 * activate
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function activate($id, $code = false)
	{
	    if ($code !== false)
	    {
		    $query = $this->db->select($this->identity_column)
			->where('activation_code', $code)
			->limit(1)
			->get($this->tables['users']);

			$result = $query->row();

			if ($query->num_rows() !== 1)
			{
				return false;
			}

			$identity = $result->{$this->identity_column};

			$data = array(
				'activation_code' => '',
				'active'	  => 1
			);

			$this->db->where($this->ion_auth->_extra_where);
			$this->db->update($this->tables['users'], $data, array($this->identity_column => $identity));
	    }
	    else
	    {
			$data = array(
				'activation_code' => '',
				'active' => 1
			);

			$this->db->where($this->ion_auth->_extra_where);
			$this->db->update($this->tables['users'], $data, array('id' => $id));
	    }

		return $this->db->affected_rows() == 1;
	}

	// --------------------------------------------------------------------------

	/**
	 * Deactivate
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function deactivate($id = 0)
	{
	    if (empty($id))
	    {
		return false;
	    }

		$activation_code       = sha1(md5(microtime()));
		$this->activation_code = $activation_code;

		$data = array(
			'activation_code' => $activation_code,
			'active'	  => 0
		);

		$this->db->where($this->ion_auth->_extra_where);
		$this->db->update($this->tables['users'], $data, array('id' => $id));

		return $this->db->affected_rows() == 1;
	}

	// --------------------------------------------------------------------------

	/**
	 * change password
	 *
	 * @return bool
	 * @author Mathew
	 **/
	public function change_password($identity, $old, $new)
	{
	    $result = $this->db->select('password, id, salt')
						  ->where($this->identity_column, $identity)
						  ->where($this->ion_auth->_extra_where)
						  ->limit(1)
						  ->get($this->tables['users'])->row();

	    $db_password = $result->password;
	    $old		 = $this->hash_password_db($result->id, $old);
	    $new		 = $this->hash_password($new, $result->salt);

	    if ($db_password === $old)
	    {
			// Store the new password and reset the remember code so all remembered instances have to re-login
			$data = array(
				'password' => $new,
				'remember_code' => '',
				);

			$this->db->where($this->ion_auth->_extra_where);
			$this->db->update($this->tables['users'], $data, array($this->identity_column => $identity));

			return $this->db->affected_rows() == 1;
	    }

	    return false;
	}

	// --------------------------------------------------------------------------

	/**
	 * Checks username
	 *
	 * @return bool
	 * @author Mathew
	 **/
	public function username_check($username = '')
	{
	    if (empty($username))
	    {
		return false;
	    }

	    return $this->db->where('username', $username)
		->where($this->ion_auth->_extra_where)
			->count_all_results($this->tables['users']) > 0;
	}

	// --------------------------------------------------------------------------

	/**
	 * Checks email
	 *
	 * @return bool
	 * @author Mathew
	 **/
	public function email_check($email = '')
	{
	    if (empty($email))
	    {
			return false;
	    }

	    return $this->db->where('email', $email)
			->where($this->ion_auth->_extra_where)
			->count_all_results($this->tables['users']) > 0;
	}

	// --------------------------------------------------------------------------

	/**
	 * Identity check
	 *
	 * @return bool
	 * @author Mathew
	 **/
	protected function identity_check($identity = '')
	{
	    if (empty($identity))
	    {
			return false;
	    }

	    return $this->db->where($this->identity_column, $identity)
			->count_all_results($this->tables['users']) > 0;
	}

	// --------------------------------------------------------------------------

	/**
	 * Insert a forgotten password key.
	 *
	 * @return bool
	 * @author Mathew
	 **/
	public function forgotten_password($email = '')
	{
	    if (empty($email))
	    {
			return false;
	    }

		$key = $this->hash_password(microtime().$email);

		$this->forgotten_password_code = $key;

		$this->db->where($this->ion_auth->_extra_where);

		$this->db->update($this->tables['users'], array('forgotten_password_code' => $key), array('email' => $email));

		return $this->db->affected_rows() == 1;
	}

	// --------------------------------------------------------------------------

	/**
	 * Forgotten Password Complete
	 *
	 * @return string
	 * @author Mathew
	 **/
	public function forgotten_password_complete($code, $salt=false)
	{
		if (empty($code))
		{
			return false;
		}

		$this->db->where('forgotten_password_code', $code);

		if ($this->db->count_all_results($this->tables['users']) > 0)
		{
			$password = $this->salt();

			$data = array(
				'password'			=> $this->hash_password($password, $salt),
				'forgotten_password_code'	=> '0',
				'active'			=> 1,
				);

			$this->db->update($this->tables['users'], $data, array('forgotten_password_code' => $code));

			return $password;
		}

		return false;
	}

	// --------------------------------------------------------------------------

	/**
	 * profile
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function profile($identity = '', $is_code = false)
	{
		if (empty($identity))
		{
			return false;
		}

		$this->db->select(array(
			$this->tables['users'].'.*',
			$this->tables['groups'].'.name AS '. $this->db->protect_identifiers('group'),
			$this->tables['groups'].'.description AS '. $this->db->protect_identifiers('group_description'),
			$this->tables['meta'].'.*',
		));

		$this->db->join($this->tables['meta'], $this->tables['users'].'.id = '.$this->tables['meta'].'.'.$this->meta_join, 'left');
		$this->db->join($this->tables['groups'], $this->tables['users'].'.group_id = '.$this->tables['groups'].'.id', 'left');

		if ($is_code)
		{
			$this->db->where($this->tables['users'].'.forgotten_password_code', $identity);
		}
		else
		{
			$this->db->where($this->tables['users'].'.'.$this->identity_column, $identity);
		}

		$this->db->where($this->ion_auth->_extra_where);

		$this->db->limit(1);
		$i = $this->db->get($this->tables['users']);

		// @todo - run the profile fields through streams

		return ($i->num_rows() > 0) ? $i->row() : false;
	}

	// --------------------------------------------------------------------------

	/**
	 * Basic functionality
	 *
	 * Register
	 * Login
	 *
	 * @author Mathew
	 */

	// --------------------------------------------------------------------------

	/**
	 * register
	 *
	 * @return bool
	 * @author Mathew
	 **/
	public function register($username, $password, $email, $group_id = null, $additional_data = array(), $group_name = false)
	{
		if ($this->identity_column == 'email' && $this->email_check($email))
		{
			$this->ion_auth->set_error('account_creation_duplicate_email');
			return false;
		}
		elseif ($this->identity_column == 'username' && $this->username_check($username))
		{
			$this->ion_auth->set_error('account_creation_duplicate_username');
			return false;
		}

		// If username is taken, use username1 or username2, etc.
		if ($this->identity_column != 'username')
		{
			$original_username = $username;
			for($i = 0; $this->username_check($username); $i++)
			{
				if($i > 0)
				{
					$username = $original_username.$i;
				}
			}
		}

		// If the group id does not exist, get it via the 
		// group name. 
		if ( ! $group_id)
		{
			// Group ID
			if( ! $group_name)
			{
				$group_name = $this->config->item('default_group', 'ion_auth');
			}

			$group_id = ($group = $this->db->select('id')
				->where('name', $group_name)
				->get($this->tables['groups'])
				->row()) ? $group->id: 0;
		}

		// IP Address
		$ip_address	= $this->input->ip_address();
		$salt		= $this->store_salt ? $this->salt() : false;
		$password	= $this->hash_password($password, $salt);

		// Users table.
		$data = array(
			'username'   => $username,
			'password'   => $password,
			'email'      => $email,
			'group_id'   => $group_id,
			'ip_address' => $ip_address,
			'created_on' => now(),
			'last_login' => now(),
			'active'     => 1
		);

		if ($this->store_salt)
		{
			$data['salt'] = $salt;
		}

		if ($this->ion_auth->_extra_set)
		{
			$this->db->set($this->ion_auth->_extra_set);
		}

		$this->db->insert($this->tables['users'], $data);

		// For the profiles tables.
		if ($this->db->dbdriver == 'mysql')
		{
			$last = $this->db->query("SELECT LAST_INSERT_ID() as last_id")->row();
			$id = $last->last_id;
		}
		else
		{
			$id = $this->db->insert_id();
		}

		// Use streams to add the profile data.
		// Even if there is not data to add, we still want an entry
		// for the profile data.
		if ( ! class_exists('Streams'))
		{
			$this->load->driver('Streams');
		}

		// This is the profile data that we are not running through streams
		$extra = array(
			'user_id'			=> $id,
			'display_name' 		=> $additional_data['display_name']
		);

		if ($this->streams->entries->insert_entry($additional_data, 'profiles', 'users', array(), $extra))
		{
			return $id;
		}
		else
		{
			return false;
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * login
	 *
	 * @return bool
	 * @author Mathew
	 **/
	public function login($identity, $password, $remember=false)
	{
		if (empty($identity) || empty($password))
		{
			return false;
		}

		$this->db->select('username, email, id, password, group_id')
			->where(sprintf('(username = "%1$s" OR email = "%1$s")', $this->db->escape_str($identity)));

		if (isset($this->ion_auth->_extra_where))
		{
			$this->db->where($this->ion_auth->_extra_where);
		}

		$query = $this->db->where('active', 1)
					   ->limit(1)
					   ->get($this->tables['users']);

		$user = $query->row();

		if ($query->num_rows() == 1)
		{
			$password = $this->hash_password_db($user->id, $password);

			if ($user->password === $password)
			{
				$this->_set_login($user, $remember);
				return true;
			}
		}

		return false;
	}
	
	// --------------------------------------------------------------------------
	
	public function force_login($user_id, $remember = false)
	{
		if (empty($user_id))
		{
			return false;
		}

		$this->db->select('username, email, id, password, group_id')->where('id', $user_id);

		if (isset($this->ion_auth->_extra_where))
		{
			$this->db->where($this->ion_auth->_extra_where);
		}

		$user = $this->db
			->where('active', 1)
			->limit(1)
			->get($this->tables['users'])
			->row();

		if ($user)
		{
			$this->_set_login($user, $remember);
			return true;
		}

		return false;
	}

	// --------------------------------------------------------------------------
	
	public function _set_login($user, $remember)
	{
		$this->update_last_login($user->id);

		$group_row = $this->db->select('name')->where('id', $user->group_id)->get($this->tables['groups'])->row();

		$this->session->set_userdata(array(
			'username' 			   => $user->username,
			'email' 			   => $user->email,
			'id'                   => $user->id, //kept for backwards compatibility
			'user_id'              => $user->id, //everyone likes to overwrite id so we'll use user_id
			'group_id'             => $user->group_id,
			'group'                => $group_row->name
		));

		if ($remember && $this->config->item('remember_users', 'ion_auth'))
		{
			$this->remember_user($user->id);
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * get_users
	 *
	 * @return object Users
	 * @author Ben Edmunds
	 **/
	public function get_users($group = false, $limit = null, $offset = null)
	{
		$this->db->select(array(
			$this->tables['users'].'.*',
			$this->tables['groups'].'.name AS '. $this->db->protect_identifiers('group'),
			$this->tables['groups'].'.description AS '. $this->db->protect_identifiers('group_description')
		));

		// Add our user stream fields to the join
		if ( ! empty($this->user_stream_fields))
		{
			foreach ($this->user_stream_fields as $field_key => $field_data)
			{
				// Is this an alt. process field type? If so, we don't
				// want to select the column since it doesn't exist.
				if (
					! isset($this->type->types->{$field_data->field_type}->alt_process) or 
					! $this->type->types->{$field_data->field_type}->alt_process
				)
				{
					$this->db->select($this->tables['meta'].'.'. $field_key);
				}
			}
		}

		// Profile columns that are not under streams control, but we 
		// want to have access to anyways.
		$this->db->select($this->tables['meta'].'.display_name as display_name');
		$this->db->select($this->tables['meta'].'.updated_on as updated_on');
		$this->db->select($this->tables['meta'].'.user_id as user_id');
		
		// Just in case this is different than the user_id, it's good
		// to have this on hand.
		$this->db->select($this->tables['meta'].'.id as profile_id');

		$this->db->join($this->tables['meta'], $this->tables['users'].'.id = '.$this->tables['meta'].'.'.$this->meta_join, 'left');
		$this->db->join($this->tables['groups'], $this->tables['users'].'.group_id = '.$this->tables['groups'].'.id', 'left');

		if (is_string($group))
		{
			$this->db->where($this->tables['groups'].'.name', $group);
		}
		else if (is_array($group))
		{
			$this->db->where_in($this->tables['groups'].'.name', $group);
		}


		if (isset($this->ion_auth, $this->ion_auth->_extra_where) && !empty($this->ion_auth->_extra_where))
		{
			$this->db->where($this->ion_auth->_extra_where);
		}

		if (isset($limit) && isset($offset))
		{
			$this->db->limit($limit, $offset);
		}

		return $this->db->get($this->tables['users']);
	}

	// --------------------------------------------------------------------------

	/**
	 * get_users_count
	 *
	 * @return int Number of Users
	 * @author Sven Lueckenbach
	 **/
	public function get_users_count($group = false)
	{
		if (is_string($group))
		{
			$this->db->where($this->tables['groups'].'.name', $group);
		}
		else if (is_array($group))
		{
			$this->db->where_in($this->tables['groups'].'.name', $group);
		}

		if (isset($this->ion_auth->_extra_where) && !empty($this->ion_auth->_extra_where))
		{
			$this->db->where($this->ion_auth->_extra_where);
		}

		$this->db->from($this->tables['users']);

		return $this->db->count_all_results();
	}

	// --------------------------------------------------------------------------

	/**
	 * get_active_users
	 *
	 * @return object
	 * @author Ben Edmunds
	 **/
	public function get_active_users($group_name = false)
	{
	    $this->db->where($this->tables['users'].'.active', 1);

		return $this->get_users($group_name);
	}

	// --------------------------------------------------------------------------

	/**
	 * get_inactive_users
	 *
	 * @return object
	 * @author Ben Edmunds
	 **/
	public function get_inactive_users($group_name = false)
	{
	    $this->db->where($this->tables['users'].'.active', 0);

		return $this->get_users($group_name);
	}

	// --------------------------------------------------------------------------

	/**
	 * get_user
	 *
	 * @return object
	 * @author Phil Sturgeon
	 **/
	public function get_user($id = null)
	{
		// Don't grab the user data again if we
		// already have it
		if (is_numeric($id) and isset($this->users[$id]))
		{
			return $this->users[$id];
		}

		$_user_is_current = false;

		//if no id was passed use the current users id
		if (is_null($id) or is_bool($id))
		{
			$identity	= $this->config->item('identity', 'ion_auth');
			$id			= $this->session->userdata($identity);

			// we'll use it bellow.. before returning
			$_user_is_current = is_scalar($id) && $id
				? array($id)	// as bool is true, as array pass the value to log
				: ($id = null);	// as bool is false and $id is null
		}
		//if a valid id was passed set identity
		elseif (is_scalar($id))
		{
			$identity = (is_numeric($id) OR empty($id)) ? 'id' : 'username';
		}
		//avoid a syntax error
		else
		{
			$identity	= $this->config->item('identity', 'ion_auth');
			$id			= null;
		}

		$this->db->where(sprintf('%s.%s', $this->tables['users'], $identity), $id);
		$this->db->limit(1);

		$user = $this->get_users();

		// Save for later use
		$this->users[$id] = $user;

		//the user disappeared for a moment?
		if ($user->num_rows() === 0 && $_user_is_current)
		{
			log_message('error', sprintf('End user session - reason: Could not find a user identified by %s:%s', $identity, $_user_is_current[0]));

			$this->session->sess_destroy();
		}

		return $user;
	}

	// --------------------------------------------------------------------------

	/**
	 * get_user_by_email
	 *
	 * @return object
	 * @author Ben Edmunds
	 **/
	public function get_user_by_email($email)
	{
	    $this->db->limit(1);

	    return $this->get_users_by_email($email);
	}

	// --------------------------------------------------------------------------

	/**
	 * get_users_by_email
	 *
	 * @return object
	 * @author Ben Edmunds
	 **/
	public function get_users_by_email($email)
	{
	    $this->db->where($this->tables['users'].'.email', $email);

	    return $this->get_users();
	}

	// --------------------------------------------------------------------------

	/**
	 * get_user_by_username
	 *
	 * @return object
	 * @author Kevin Smith
	 **/
	public function get_user_by_username($username)
	{
	    $this->db->limit(1);

	    return $this->get_users_by_username($username);
	}

	// --------------------------------------------------------------------------

	/**
	 * get_users_by_username
	 *
	 * @return object
	 * @author Kevin Smith
	 **/
	public function get_users_by_username($username)
	{
	    $this->db->where($this->tables['users'].'.username', $username);

	    return $this->get_users();
	}

	// --------------------------------------------------------------------------

	/**
	 * get_user_by_identity
	 *                                      //copied from above ^
	 * @return object
	 * @author jondavidjohn
	 **/
	public function get_user_by_identity($identity)
	{
	    $this->db->where($this->tables['users'].'.'.$this->identity_column, $identity);
	    $this->db->limit(1);

	    return $this->get_users();
	}

	// --------------------------------------------------------------------------

	/**
	 * get_newest_users
	 *
	 * @return object
	 * @author Ben Edmunds
	 **/
	public function get_newest_users($limit = 10)
	{
		$this->db->order_by($this->tables['users'].'.created_on', 'desc');
		$this->db->limit($limit);

		return $this->get_users();
	}

	// --------------------------------------------------------------------------

	/**
	 * get_users_group
	 *
	 * @return object
	 * @author Ben Edmunds
	 **/
	public function get_users_group($id=false)
	{
		//if no id was passed use the current users id
		$id || $id = $this->session->userdata('user_id');

		$user = $this->db->select('group_id')
			->where('id', $id)
			->get($this->tables['users'])
			->row();

		return $this->db->select('name, description')
			->where('id', $user->group_id)
			->get($this->tables['groups'])
			->row();
	}

	// --------------------------------------------------------------------------

	/**
	 * get_groups
	 *
	 * @return object
	 * @author Phil Sturgeon
	 **/
	public function get_groups()
	{
	return $this->db->get($this->tables['groups'])
			->result();
	}

	// --------------------------------------------------------------------------

	/**
	 * get_group
	 *
	 * @return object
	 * @author Ben Edmunds
	 **/
	public function get_group($id)
	{
	$this->db->where('id', $id);

		return $this->db->get($this->tables['groups'])
					->row();
	}

	// --------------------------------------------------------------------------

	/**
	 * get_group_by_name
	 *
	 * @return object
	 * @author Ben Edmunds
	 **/
	public function get_group_by_name($name)
	{
	$this->db->where('name', $name);

		return $this->db->get($this->tables['groups'])
					->row();
	}

	// --------------------------------------------------------------------------

	/**
	 * update_user
	 *
	 * @return bool
	 * @author Phil Sturgeon
	 **/
	public function update_user($id, $data, $profile_data)
	{
		$user = $this->get_user($id)->row();

		$this->db->trans_begin();

	    if (array_key_exists($this->identity_column, $data) && $this->identity_check($data[$this->identity_column]) && $user->{$this->identity_column} !== $data[$this->identity_column])
	    {
			$this->db->trans_rollback();
			$this->ion_auth->set_error('account_creation_duplicate_'.$this->identity_column);
			return false;
	    }

	    $this->load->driver('streams');

	    // Get the row id for the profile. It's probably the same as
	    // the user_id but not necessarily.
	    $profile = $this->db->limit(1)->where('user_id', $id)->get($this->tables['meta'])->row();
	    if ( ! $profile) return false;

	    // Get the stream
	    $stream = $this->streams_m->get_stream('profiles', true, 'users');
	    if ( ! $stream) die('boo');

		$stream_fields = $this->streams_m->get_stream_fields($stream->id);
	
	    $profile_parsed_data = $this->row_m->run_field_pre_processes($stream_fields, $stream, $profile->id, $profile_data);

	    // Special provision for our non-stream controlled fields
	    $profile_parsed_data['display_name'] 	= (array_key_exists('display_name', $profile_data)) ? $profile_data['display_name'] : $profile->display_name;
	    $profile_parsed_data['updated_on']		= now();

	    // Hey look at me I'm Phil Sturgeon I'm using transactions I'm so fancy!
		$this->db->where($this->meta_join, $id);
		$this->db->set($profile_parsed_data);
		$this->db->update($this->tables['meta']);

		if (array_key_exists('username', $data) || array_key_exists('password', $data) || array_key_exists('email', $data) || array_key_exists('group_id', $data))
		{
			if (array_key_exists('password', $data))
			{
				$data['password'] = $this->hash_password($data['password'], $user->salt);
			}

			$this->db->where($this->ion_auth->_extra_where);
			$this->db->update($this->tables['users'], $data, array('id' => $id));
		}

		if ($this->db->trans_status() === false)
		{
		    $this->db->trans_rollback();
		    return false;
		}

		$this->db->trans_commit();
		return true;
	}

	// --------------------------------------------------------------------------

	/**
	 * delete_user
	 *
	 * @return bool
	 * @author Phil Sturgeon
	 **/
	public function delete_user($id)
	{
		$this->db->trans_begin();

		$this->db->delete($this->tables['meta'], array($this->meta_join => $id));
		$this->db->delete($this->tables['users'], array('id' => $id));

		if ($this->db->trans_status() === false)
		{
		    $this->db->trans_rollback();
		    return false;
		}

		$this->db->trans_commit();
		return true;
	}

	// --------------------------------------------------------------------------

	/**
	 * update_last_login
	 *
	 * @return bool
	 * @author Ben Edmunds
	 **/
	public function update_last_login($id)
	{
		$this->load->helper('date');

	    if (isset($this->ion_auth->_extra_where) && !empty($this->ion_auth->_extra_where))
		{
			$this->db->where($this->ion_auth->_extra_where);
		}

		$this->db->update($this->tables['users'], array('last_login' => now()), array('id' => $id));

		return $this->db->affected_rows() == 1;
	}


	// --------------------------------------------------------------------------

	/**
	 * set_lang
	 *
	 * @return bool
	 * @author Ben Edmunds
	 **/
	public function set_lang($lang = 'en')
	{
		set_cookie(array(
			'name'   => 'lang_code',
			'value'  => $lang,
			'expire' => $this->config->item('user_expire', 'ion_auth') + time()
		));

		return true;
	}

	// --------------------------------------------------------------------------

	/**
	 * login_remembed_user
	 *
	 * @return bool
	 * @author Ben Edmunds
	 **/
	public function login_remembered_user()
	{
		//check for valid data
		if (!get_cookie('identity') || !get_cookie('remember_code') || !$this->identity_check(get_cookie('identity')))
		{
			return false;
		}

		//get the user
	    if (isset($this->ion_auth->_extra_where) && !empty($this->ion_auth->_extra_where))
		{
			$this->db->where($this->ion_auth->_extra_where);
		}

		$query = $this->db->select($this->identity_column.', id, group_id')
					->where($this->identity_column, get_cookie('identity'))
					->where('remember_code', get_cookie('remember_code'))
					->limit(1)
					->get($this->tables['users']);

		//if the user was found, sign them in
		if ($query->num_rows() == 1)
		{
			$user = $query->row();

			$this->update_last_login($user->id);

			$group_row = $this->db->select('name')->where('id', $user->group_id)->get($this->tables['groups'])->row();

		$session_data = array(
				    $this->identity_column => $user->{$this->identity_column},
				    'id'                   => $user->id, //kept for backwards compatibility
				    'user_id'              => $user->id, //everyone likes to overwrite id so we'll use user_id
				    'group_id'             => $user->group_id,
				    'group'                => $group_row->name
				     );

		$this->session->set_userdata($session_data);


			//extend the users cookies if the option is enabled
			if ($this->config->item('user_extend_on_login', 'ion_auth'))
			{
				$this->remember_user($user->id);
			}

			return true;
		}

		return false;
	}

	// --------------------------------------------------------------------------

	/**
	 * remember_user
	 *
	 * @return bool
	 * @author Ben Edmunds
	 **/
	private function remember_user($id)
	{
		if (!$id)
		{
			return false;
		}

		$user = $this->get_user($id)->row();

		$salt = sha1($user->password);

		$this->db->update($this->tables['users'], array('remember_code' => $salt), array('id' => $id));

		if ($this->db->affected_rows() > -1)
		{
			set_cookie(array(
				'name'   => 'identity',
				'value'  => $user->{$this->identity_column},
				'expire' => $this->config->item('user_expire', 'ion_auth'),
			));

			set_cookie(array(
				'name'   => 'remember_code',
				'value'  => $salt,
				'expire' => $this->config->item('user_expire', 'ion_auth'),
			));

			return true;
		}

		return false;
	}
}
