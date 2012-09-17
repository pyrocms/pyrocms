<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.2.4 or newer
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Open Software License version 3.0
 *
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst. It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

/**
 * Cookie-based session management driver
 *
 * This is the classic CI_Session functionality, as written by EllisLab, abstracted out to a driver.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Sessions
 * @author		EllisLab Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/sessions.html
 */
class CI_Session_cookie extends CI_Session_driver {

	/**
	 * Whether to encrypt the session cookie
	 *
	 * @var bool
	 */
	public $sess_encrypt_cookie		= FALSE;

	/**
	 * Whether to use to the database for session storage
	 *
	 * @var bool
	 */
	public $sess_use_database		= FALSE;

	/**
	 * Name of the database table in which to store sessions
	 *
	 * @var string
	 */
	public $sess_table_name			= '';

	/**
	 * Length of time (in seconds) for sessions to expire
	 *
	 * @var int
	 */
	public $sess_expiration			= 7200;

	/**
	 * Whether to kill session on close of browser window
	 *
	 * @var bool
	 */
	public $sess_expire_on_close	= FALSE;

	/**
	 * Whether to match session on ip address
	 *
	 * @var bool
	 */
	public $sess_match_ip			= FALSE;

	/**
	 * Whether to match session on user-agent
	 *
	 * @var bool
	 */
	public $sess_match_useragent	= TRUE;

	/**
	 * Name of session cookie
	 *
	 * @var string
	 */
	public $sess_cookie_name		= 'ci_session';

	/**
	 * Session cookie prefix
	 *
	 * @var string
	 */
	public $cookie_prefix			= '';

	/**
	 * Session cookie path
	 *
	 * @var string
	 */
	public $cookie_path				= '';

	/**
	 * Session cookie domain
	 *
	 * @var string
	 */
	public $cookie_domain			= '';

	/**
	 * Whether to set the cookie only on HTTPS connections
	 *
	 * @var bool
	 */
	public $cookie_secure			= FALSE;

	/**
	 * Whether cookie should be allowed only to be sent by the server
	 *
	 * @var bool
	 */
	public $cookie_httponly 		= FALSE;

	/**
	 * Interval at which to update session
	 *
	 * @var int
	 */
	public $sess_time_to_update		= 300;

	/**
	 * Key with which to encrypt the session cookie
	 *
	 * @var string
	 */
	public $encryption_key			= '';

	/**
	 * Timezone to use for the current time
	 *
	 * @var string
	 */
	public $time_reference			= 'local';

	/**
	 * Session data
	 *
	 * @var array
	 */
	public $userdata				= array();

	/**
	 * Reference to CodeIgniter instance
	 *
	 * @var object
	 */
	public $CI;

	/**
	 * Current time
	 *
	 * @var int
	 */
	public $now;

	/**
	 * Default userdata keys
	 *
	 * @var	array
	 */
	protected $defaults = array(
		'session_id' => NULL,
		'ip_address' => NULL,
		'user_agent' => NULL,
		'last_activity' => NULL
	);

	/**
	 * Data needs DB update flag
	 *
	 * @var	bool
	 */
	protected $data_dirty = FALSE;

	/**
	 * Initialize session driver object
	 *
	 * @return	void
	 */
	protected function initialize()
	{
		// Set the super object to a local variable for use throughout the class
		$this->CI =& get_instance();

		// Set all the session preferences, which can either be set
		// manually via the $params array or via the config file
		$prefs = array(
			'sess_encrypt_cookie',
			'sess_use_database',
			'sess_table_name',
			'sess_expiration',
			'sess_expire_on_close',
			'sess_match_ip',
			'sess_match_useragent',
			'sess_cookie_name',
			'cookie_path',
			'cookie_domain',
			'cookie_secure',
			'cookie_httponly',
			'sess_time_to_update',
			'time_reference',
			'cookie_prefix',
			'encryption_key'
		);

		foreach ($prefs as $key)
		{
			$this->$key = isset($this->_parent->params[$key])
				? $this->_parent->params[$key]
				: $this->CI->config->item($key);
		}

		if ($this->encryption_key === '')
		{
			show_error('In order to use the Cookie Session driver you are required to set an encryption key in your config file.');
		}

		// Load the string helper so we can use the strip_slashes() function
		$this->CI->load->helper('string');

		// Do we need encryption? If so, load the encryption class
		if ($this->sess_encrypt_cookie === TRUE)
		{
			$this->CI->load->library('encrypt');
		}

		// Check for database
		if ($this->sess_use_database === TRUE && $this->sess_table_name !== '')
		{
			// Load database driver
			$this->CI->load->database();

			// Register shutdown function
			register_shutdown_function(array($this, '_update_db'));
		}

		// Set the "now" time. Can either be GMT or server time, based on the config prefs.
		// We use this to set the "last activity" time
		$this->now = $this->_get_time();

		// Set the session length. If the session expiration is
		// set to zero we'll set the expiration two years from now.
		if ($this->sess_expiration === 0)
		{
			$this->sess_expiration = (60*60*24*365*2);
		}

		// Set the cookie name
		$this->sess_cookie_name = $this->cookie_prefix.$this->sess_cookie_name;

		// Run the Session routine. If a session doesn't exist we'll
		// create a new one. If it does, we'll update it.
		if ( ! $this->_sess_read())
		{
			$this->_sess_create();
		}
		else
		{
			$this->_sess_update();
		}

		// Delete expired sessions if necessary
		$this->_sess_gc();
	}

	// ------------------------------------------------------------------------

	/**
	 * Write the session data
	 *
	 * @return	void
	 */
	public function sess_save()
	{
		// Check for database
		if ($this->sess_use_database === TRUE)
		{
			// Mark custom data as dirty so we know to update the DB
			$this->data_dirty = TRUE;
		}

		// Write the cookie
		$this->_set_cookie();
	}

	// ------------------------------------------------------------------------

	/**
	 * Destroy the current session
	 *
	 * @return	void
	 */
	public function sess_destroy()
	{
		// Kill the session DB row
		if ($this->sess_use_database === TRUE && isset($this->userdata['session_id']))
		{
			$this->CI->db->delete($this->sess_table_name, array('session_id' => $this->userdata['session_id']));
			$this->data_dirty = FALSE;
		}

		// Kill the cookie
		$this->_setcookie($this->sess_cookie_name, addslashes(serialize(array())), ($this->now - 31500000),
			$this->cookie_path, $this->cookie_domain, 0);

		// Kill session data
		$this->userdata = array();
	}

	// ------------------------------------------------------------------------

	/**
	 * Regenerate the current session
	 *
	 * Regenerate the session id
	 *
	 * @param	bool	Destroy session data flag (default: false)
	 * @return	void
	 */
	public function sess_regenerate($destroy = FALSE)
	{
		// Check destroy flag
		if ($destroy)
		{
			// Destroy old session and create new one
			$this->sess_destroy();
			$this->_sess_create();
		}
		else
		{
			// Just force an update to recreate the id
			$this->_sess_update(TRUE);
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Get a reference to user data array
	 *
	 * @return	array	Reference to userdata
	 */
	public function &get_userdata()
	{
		return $this->userdata;
	}

	// ------------------------------------------------------------------------

	/**
	 * Fetch the current session data if it exists
	 *
	 * @return	bool
	 */
	protected function _sess_read()
	{
		// Fetch the cookie
		$session = $this->CI->input->cookie($this->sess_cookie_name);

		// No cookie? Goodbye cruel world!...
		if ($session === NULL)
		{
			log_message('debug', 'A session cookie was not found.');
			return FALSE;
		}

		// Check for encryption
		if ($this->sess_encrypt_cookie === TRUE)
		{
			// Decrypt the cookie data
			$session = $this->CI->encrypt->decode($session);
		}
		else
		{
			// Encryption was not used, so we need to check the md5 hash in the last 32 chars
			$len	 = strlen($session)-32;
			$hash	 = substr($session, $len);
			$session = substr($session, 0, $len);

			// Does the md5 hash match? This is to prevent manipulation of session data in userspace
			if ($hash !== md5($session.$this->encryption_key))
			{
				log_message('error', 'The session cookie data did not match what was expected. This could be a possible hacking attempt.');
				$this->sess_destroy();
				return FALSE;
			}
		}

		// Unserialize the session array
		$session = $this->_unserialize($session);

		// Is the session data we unserialized an array with the correct format?
		if ( ! is_array($session) OR ! isset($session['session_id'], $session['ip_address'], $session['user_agent'], $session['last_activity']))
		{
			$this->sess_destroy();
			return FALSE;
		}

		// Is the session current?
		if (($session['last_activity'] + $this->sess_expiration) < $this->now)
		{
			$this->sess_destroy();
			return FALSE;
		}

		// Does the IP match?
		if ($this->sess_match_ip === TRUE && $session['ip_address'] !== $this->CI->input->ip_address())
		{
			$this->sess_destroy();
			return FALSE;
		}

		// Does the User Agent Match?
		if ($this->sess_match_useragent === TRUE &&
			trim($session['user_agent']) !== trim(substr($this->CI->input->user_agent(), 0, 120)))
		{
			$this->sess_destroy();
			return FALSE;
		}

		// Is there a corresponding session in the DB?
		if ($this->sess_use_database === TRUE)
		{
			$this->CI->db->where('session_id', $session['session_id']);

			if ($this->sess_match_ip === TRUE)
			{
				$this->CI->db->where('ip_address', $session['ip_address']);
			}

			if ($this->sess_match_useragent === TRUE)
			{
				$this->CI->db->where('user_agent', $session['user_agent']);
			}

			// Is caching in effect? Turn it off
			$db_cache = $this->CI->db->cache_on;
			$this->CI->db->cache_off();

			$query = $this->CI->db->limit(1)->get($this->sess_table_name);

			// Was caching in effect?
			if ($db_cache)
			{
				// Turn it back on
				$this->CI->db->cache_on();
			}

			// No result? Kill it!
			if ($query->num_rows() === 0)
			{
				$this->sess_destroy();
				return FALSE;
			}

			// Is there custom data? If so, add it to the main session array
			$row = $query->row();
			if ( ! empty($row->user_data))
			{
				$custom_data = $this->_unserialize($row->user_data);

				if (is_array($custom_data))
				{
					$session = $session + $custom_data;
				}
			}
		}

		// Session is valid!
		$this->userdata = $session;
		return TRUE;
	}

	// ------------------------------------------------------------------------

	/**
	 * Create a new session
	 *
	 * @return	void
	 */
	protected function _sess_create()
	{
		// Initialize userdata
		$this->userdata = array(
			'session_id'	=> $this->_make_sess_id(),
			'ip_address'	=> $this->CI->input->ip_address(),
			'user_agent'	=> substr($this->CI->input->user_agent(), 0, 120),
			'last_activity'	=> $this->now,
		);

		// Check for database
		if ($this->sess_use_database === TRUE)
		{
			// Add empty user_data field and save the data to the DB
			$this->CI->db->set('user_data', '')->insert($this->sess_table_name, $this->userdata);
		}

		// Write the cookie
		$this->_set_cookie();
	}

	// ------------------------------------------------------------------------

	/**
	 * Update an existing session
	 *
	 * @param	bool	Force update flag (default: false)
	 * @return	void
	 */
	protected function _sess_update($force = FALSE)
	{
		// We only update the session every five minutes by default (unless forced)
		if ( ! $force && ($this->userdata['last_activity'] + $this->sess_time_to_update) >= $this->now)
		{
			return;
		}

		// Update last activity to now
		$this->userdata['last_activity'] = $this->now;

		// Save the old session id so we know which DB record to update
		$old_sessid = $this->userdata['session_id'];

		// Changing the session ID during an AJAX call causes problems
		if ( ! $this->CI->input->is_ajax_request())
		{
			// Get new id
			$this->userdata['session_id'] = $this->_make_sess_id();
		}

		// Check for database
		if ($this->sess_use_database === TRUE)
		{
			// Update the session ID and last_activity field in the DB
			$this->CI->db->update($this->sess_table_name, array(
					 'last_activity' => $this->now,
					 'session_id' => $this->userdata['session_id']
			), array('session_id' => $old_sessid));
		}

		// Write the cookie
		$this->_set_cookie();
	}

	// ------------------------------------------------------------------------

	/**
	 * Update database with current data
	 *
	 * This gets called from the shutdown function and also
	 * registered with PHP to run at the end of the request
	 * so it's guaranteed to update even when a fatal error
	 * occurs. The first call makes the update and clears the
	 * dirty flag so it won't happen twice.
	 *
	 * @return	void
	 */
	public function _update_db()
	{
		// Check for database and dirty flag and unsaved
		if ($this->sess_use_database === TRUE && $this->data_dirty === TRUE)
		{
			// Set up activity and data fields to be set
			// If we don't find custom data, user_data will remain an empty string
			$set = array(
				'last_activity' => $this->userdata['last_activity'],
				'user_data' => ''
			);

			// Get the custom userdata, leaving out the defaults
			// (which get stored in the cookie)
			$userdata = array_diff_key($this->userdata, $this->defaults);

			// Did we find any custom data?
			if ( ! empty($userdata))
			{
				// Serialize the custom data array so we can store it
				$set['user_data'] = $this->_serialize($userdata);
			}

			// Run the update query
			// Any time we change the session id, it gets updated immediately,
			// so our where clause below is always safe
			$this->CI->db->update($this->sess_table_name, $set, array('session_id' => $this->userdata['session_id']));

			// Clear dirty flag to prevent double updates
			$this->data_dirty = FALSE;

			log_message('debug', 'CI_Session Data Saved To DB');
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Generate a new session id
	 *
	 * @return	string	Hashed session id
	 */
	protected function _make_sess_id()
	{
		$new_sessid = '';
		do
		{
			$new_sessid .= mt_rand(0, mt_getrandmax());
		}
		while (strlen($new_sessid) < 32);

		// To make the session ID even more secure we'll combine it with the user's IP
		$new_sessid .= $this->CI->input->ip_address();

		// Turn it into a hash and return
		return md5(uniqid($new_sessid, TRUE));
	}

	// ------------------------------------------------------------------------

	/**
	 * Get the "now" time
	 *
	 * @return	int	 Time
	 */
	protected function _get_time()
	{
		if ($this->time_reference === 'local' OR $this->time_reference === date_default_timezone_get())
		{
			return time();
		}

		$datetime = new DateTime('now', new DateTimeZone($this->time_reference));
		sscanf($datetime->format('j-n-Y G:i:s'), '%d-%d-%d %d:%d:%d', $day, $month, $year, $hour, $minute, $second);

		return mktime($hour, $minute, $second, $month, $day, $year);
	}

	// ------------------------------------------------------------------------

	/**
	 * Write the session cookie
	 *
	 * @return	void
	 */
	protected function _set_cookie()
	{
		// Get userdata (only defaults if database)
		$cookie_data = ($this->sess_use_database === TRUE)
				? array_intersect_key($this->userdata, $this->defaults)
				: $this->userdata;

		// Serialize the userdata for the cookie
		$cookie_data = $this->_serialize($cookie_data);

		$cookie_data = ($this->sess_encrypt_cookie === TRUE)
			? $this->CI->encrypt->encode($cookie_data)
			// if encryption is not used, we provide an md5 hash to prevent userside tampering
			: $cookie_data.md5($cookie_data.$this->encryption_key);

		$expire = ($this->sess_expire_on_close === TRUE) ? 0 : $this->sess_expiration + time();

		// Set the cookie
		$this->_setcookie($this->sess_cookie_name, $cookie_data, $expire, $this->cookie_path, $this->cookie_domain,
			$this->cookie_secure, $this->cookie_httponly);
	}

	// ------------------------------------------------------------------------

	/**
	 * Set a cookie with the system
	 *
	 * This abstraction of the setcookie call allows overriding for unit testing
	 *
	 * @param	string	Cookie name
	 * @param	string	Cookie value
	 * @param	int	Expiration time
	 * @param	string	Cookie path
	 * @param	string	Cookie domain
	 * @param	bool	Secure connection flag
	 * @param	bool	HTTP protocol only flag
	 * @return	void
	 */
	protected function _setcookie($name, $value = '', $expire = 0, $path = '', $domain = '', $secure = FALSE, $httponly = FALSE)
	{
		setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
	}

	// ------------------------------------------------------------------------

	/**
	 * Serialize an array
	 *
	 * This function first converts any slashes found in the array to a temporary
	 * marker, so when it gets unserialized the slashes will be preserved
	 *
	 * @param	mixed	Data to serialize
	 * @return	string	Serialized data
	 */
	protected function _serialize($data)
	{
		if (is_array($data))
		{
			array_walk_recursive($data, array(&$this, '_escape_slashes'));
		}
		elseif (is_string($data))
		{
			$data = str_replace('\\', '{{slash}}', $data);
		}

		return serialize($data);
	}

	// ------------------------------------------------------------------------

	/**
	 * Escape slashes
	 *
	 * This function converts any slashes found into a temporary marker
	 *
	 * @param	string	Value
	 * @param	string	Key
	 * @return	void
	 */
	protected function _escape_slashes(&$val, $key)
	{
		if (is_string($val))
		{
			$val = str_replace('\\', '{{slash}}', $val);
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Unserialize
	 *
	 * This function unserializes a data string, then converts any
	 * temporary slash markers back to actual slashes
	 *
	 * @param	mixed	Data to unserialize
	 * @return	mixed	Unserialized data
	 */
	protected function _unserialize($data)
	{
		$data = @unserialize(strip_slashes(trim($data)));

		if (is_array($data))
		{
			array_walk_recursive($data, array(&$this, '_unescape_slashes'));
			return $data;
		}

		return is_string($data) ? str_replace('{{slash}}', '\\', $data) : $data;
	}

	// ------------------------------------------------------------------------

	/**
	 * Unescape slashes
	 *
	 * This function converts any slash markers back into actual slashes
	 *
	 * @param	string	Value
	 * @param	string	Key
	 * @return	void
	 */
	protected function _unescape_slashes(&$val, $key)
	{
		if (is_string($val))
		{
	 		$val= str_replace('{{slash}}', '\\', $val);
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Garbage collection
	 *
	 * This deletes expired session rows from database
	 * if the probability percentage is met
	 *
	 * @return	void
	 */
	protected function _sess_gc()
	{
		if ($this->sess_use_database !== TRUE)
		{
			return;
		}

		$probability = ini_get('session.gc_probability');
		$divisor = ini_get('session.gc_divisor');

		srand(time());
		if ((mt_rand(0, $divisor) / $divisor) < $probability)
		{
			$expire = $this->now - $this->sess_expiration;
			$this->CI->db->delete($this->sess_table_name, 'last_activity < '.$expire);

			log_message('debug', 'Session garbage collection performed.');
		}
	}

}

/* End of file Session_cookie.php */
/* Location: ./system/libraries/Session/drivers/Session_cookie.php */