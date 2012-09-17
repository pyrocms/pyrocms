<?php

/**
 * Session driver library unit test
 */
class Session_test extends CI_TestCase {
	protected $settings = array(
		'use_cookies' => 0,
	   	'use_only_cookies' => 0,
	   	'cache_limiter' => false
	);
	protected $setting_vals = array();
	protected $cookie_vals;
	protected $session;

	/**
	 * Set up test framework
	 */
	public function set_up()
	{
		// Override settings
		foreach ($this->settings as $name => $value) {
			$this->setting_vals[$name] = ini_get('session.'.$name);
			ini_set('session.'.$name, $value);
		}

		// Start with clean environment
		$this->cookie_vals = $_COOKIE;
		$_COOKIE = array();

		// Establish necessary support classes
		$obj = new stdClass;
		$classes = array(
			'config' => 'cfg',
			'load' => 'load',
			'input' => 'in'
		);
		foreach ($classes as $name => $abbr) {
			$class = $this->ci_core_class($abbr);
			$obj->$name = new $class;
		}
		$this->ci_instance($obj);

		// Attach session instance locally
		$config = array(
			'sess_encrypt_cookie' => FALSE,
			'sess_use_database' => FALSE,
			'sess_table_name' => '',
			'sess_expiration' => 7200,
			'sess_expire_on_close' => FALSE,
			'sess_match_ip' => FALSE,
			'sess_match_useragent' => TRUE,
			'sess_cookie_name' => 'ci_session',
			'cookie_path' => '',
			'cookie_domain' => '',
			'cookie_secure' => FALSE,
			'cookie_httponly' => FALSE,
			'sess_time_to_update' => 300,
			'time_reference' => 'local',
			'cookie_prefix' => '',
			'encryption_key' => 'foobar',
			'sess_valid_drivers' => array(
				'Mock_Libraries_Session_native',
			   	'Mock_Libraries_Session_cookie'
			)
		);
		$this->session = new Mock_Libraries_Session($config);
	}

	/**
	 * Tear down test framework
	 */
	public function tear_down()
	{
		// Restore environment
		if (session_id()) session_destroy();
		$_SESSION = array();
		$_COOKIE = $this->cookie_vals;

		// Restore settings
		foreach ($this->settings as $name => $value) {
			ini_set('session.'.$name, $this->setting_vals[$name]);
		}
	}

	/**
	 * Test set_userdata() function
	 *
	 * @covers  CI_Session::set_userdata
	 * @covers  CI_Session::userdata
	 */
	public function test_set_userdata()
	{
		// Set userdata values for each driver
		$key1 = 'test1';
		$ckey2 = 'test2';
		$nkey2 = 'test3';
		$cmsg1 = 'Some test data';
		$cmsg2 = 42;
		$nmsg1 = 'Other test data';
		$nmsg2 = true;
		$this->session->cookie->set_userdata($key1, $cmsg1);
		$this->session->set_userdata($ckey2, $cmsg2);
		$this->session->native->set_userdata($key1, $nmsg1);
		$this->session->set_userdata($nkey2, $nmsg2);

		// Verify independent messages
		$this->assertEquals($cmsg1, $this->session->cookie->userdata($key1));
		$this->assertEquals($nmsg1, $this->session->native->userdata($key1));

		// Verify pre-selected driver sets
		$this->assertEquals($cmsg2, $this->session->cookie->userdata($ckey2));
		$this->assertEquals($nmsg2, $this->session->native->userdata($nkey2));

		// Verify no crossover
		$this->assertNull($this->session->cookie->userdata($nkey2));
		$this->assertNull($this->session->native->userdata($ckey2));
	}

	/**
	 * Test the has_userdata() function
	 *
	 * @covers	CI_Session::has_userdata
	 */
	public function test_has_userdata()
	{
		// Set a userdata value for each driver
		$key = 'hastest';
		$cmsg = 'My test data';
		$this->session->cookie->set_userdata($key, $cmsg);
		$nmsg = 'Your test data';
		$this->session->native->set_userdata($key, $nmsg);

		// Verify values exist
		$this->assertTrue($this->session->cookie->has_userdata($key));
		$this->assertTrue($this->session->native->has_userdata($key));

		// Verify non-existent values
		$nokey = 'hasnot';
		$this->assertFalse($this->session->cookie->has_userdata($nokey));
		$this->assertFalse($this->session->native->has_userdata($nokey));
	}

	/**
	 * Test the all_userdata() function
	 *
	 * @covers	CI_Session::all_userdata
	 */
	public function test_all_userdata()
	{
		// Set a specific series of data for each driver
		$cdata = array(
			'one' => 'first',
			'two' => 'second',
		   	'three' => 'third',
		   	'foo' => 'bar',
		   	'bar' => 'baz'
		);
		$ndata = array(
			'one' => 'gold',
		   	'two' => 'silver',
		   	'three' => 'bronze',
		   	'foo' => 'baz',
		   	'bar' => 'foo'
		);
		$this->session->cookie->set_userdata($cdata);
		$this->session->native->set_userdata($ndata);

		// Make sure all values are present
		$call = $this->session->cookie->all_userdata();
		foreach ($cdata as $key => $value) {
			$this->assertEquals($value, $call[$key]);
		}
		$nall = $this->session->native->all_userdata();
		foreach ($ndata as $key => $value) {
			$this->assertEquals($value, $nall[$key]);
		}
	}

	/**
	 * Test the unset_userdata() function
	 *
	 * @covers	CI_Session::unset_userdata
	 */
	public function test_unset_userdata()
	{
		// Set a userdata message for each driver
		$key = 'untest';
		$cmsg = 'Other test data';
		$this->session->cookie->set_userdata($key, $cmsg);
		$nmsg = 'Sundry test data';
		$this->session->native->set_userdata($key, $nmsg);

		// Verify independent messages
		$this->assertEquals($this->session->cookie->userdata($key), $cmsg);
		$this->assertEquals($this->session->native->userdata($key), $nmsg);

		// Unset them and verify absence
		$this->session->cookie->unset_userdata($key);
		$this->session->native->unset_userdata($key);
		$this->assertNull($this->session->cookie->userdata($key));
		$this->assertNull($this->session->native->userdata($key));
	}

	/**
	 * Test the flashdata() functions
	 *
	 * @covers	CI_Session::set_flashdata
	 * @covers	CI_Session::flashdata
	 */
	public function test_flashdata()
	{
		// Set flashdata message for each driver
		$key = 'fltest';
		$cmsg = 'Some flash data';
		$this->session->cookie->set_flashdata($key, $cmsg);
		$nmsg = 'Other flash data';
		$this->session->native->set_flashdata($key, $nmsg);

		// Simulate page reload
		$this->session->cookie->reload();
		$this->session->native->reload();

		// Verify independent messages
		$this->assertEquals($cmsg, $this->session->cookie->flashdata($key));
		$this->assertEquals($nmsg, $this->session->native->flashdata($key));

		// Simulate next page reload
		$this->session->cookie->reload();
		$this->session->native->reload();

		// Verify absence of messages
		$this->assertNull($this->session->cookie->flashdata($key));
		$this->assertNull($this->session->native->flashdata($key));
	}

	/**
	 * Test the keep_flashdata() function
	 *
	 * @covers	CI_Session::keep_flashdata
	 */
	public function test_keep_flashdata()
	{
		// Set flashdata message for each driver
		$key = 'kfltest';
		$cmsg = 'My flash data';
		$this->session->cookie->set_flashdata($key, $cmsg);
		$nmsg = 'Your flash data';
		$this->session->native->set_flashdata($key, $nmsg);

		// Simulate page reload and verify independent messages
		$this->session->cookie->reload();
		$this->session->native->reload();
		$this->assertEquals($cmsg, $this->session->cookie->flashdata($key));
		$this->assertEquals($nmsg, $this->session->native->flashdata($key));

		// Keep messages
		$this->session->cookie->keep_flashdata($key);
		$this->session->native->keep_flashdata($key);

		// Simulate next page reload and verify message persistence
		$this->session->cookie->reload();
		$this->session->native->reload();
		$this->assertEquals($cmsg, $this->session->cookie->flashdata($key));
		$this->assertEquals($nmsg, $this->session->native->flashdata($key));

		// Simulate next page reload and verify absence of messages
		$this->session->cookie->reload();
		$this->session->native->reload();
		$this->assertNull($this->session->cookie->flashdata($key));
		$this->assertNull($this->session->native->flashdata($key));
	}

	/**
	 * Test the all_flashdata() function
	 *
	 * @covers	CI_Session::all_flashdata
	 */
	public function test_all_flashdata()
	{
		// Set a specific series of data for each driver
		$cdata = array(
			'one' => 'first',
		   	'two' => 'second',
		   	'three' => 'third',
		   	'foo' => 'bar',
		   	'bar' => 'baz'
		);
		$ndata = array(
			'one' => 'gold',
		   	'two' => 'silver',
		   	'three' => 'bronze',
		   	'foo' => 'baz',
		   	'bar' => 'foo'
		);
		$this->session->cookie->set_flashdata($cdata);
		$this->session->native->set_flashdata($ndata);

		// Simulate page reload and make sure all values are present
		$this->session->cookie->reload();
		$this->session->native->reload();
		$this->assertEquals($cdata, $this->session->cookie->all_flashdata());
		$this->assertEquals($ndata, $this->session->native->all_flashdata());
	}

	/**
	 * Test the tempdata() functions
	 *
	 * @covers	CI_Session::set_tempdata
	 * @covers	CI_Session::tempdata
	 */
	public function test_set_tempdata()
	{
		// Set tempdata message for each driver - 1 second timeout
		$key = 'tmptest';
		$cmsg = 'Some temp data';
		$this->session->cookie->set_tempdata($key, $cmsg, 1);
		$nmsg = 'Other temp data';
		$this->session->native->set_tempdata($key, $nmsg, 1);

		// Simulate page reload and verify independent messages
		$this->session->cookie->reload();
		$this->session->native->reload();
		$this->assertEquals($cmsg, $this->session->cookie->tempdata($key));
		$this->assertEquals($nmsg, $this->session->native->tempdata($key));

		// Wait 2 seconds, simulate page reload and verify message absence
		sleep(2);
		$this->session->cookie->reload();
		$this->session->native->reload();
		$this->assertNull($this->session->cookie->tempdata($key));
		$this->assertNull($this->session->native->tempdata($key));
	}

	/**
	 * Test the unset_tempdata() function
	 *
	 * @covers	CI_Session::unset_tempdata
	 */
	public function test_unset_tempdata()
	{
		// Set tempdata message for each driver - 1 second timeout
		$key = 'utmptest';
		$cmsg = 'My temp data';
		$this->session->cookie->set_tempdata($key, $cmsg, 1);
		$nmsg = 'Your temp data';
		$this->session->native->set_tempdata($key, $nmsg, 1);

		// Verify independent messages
		$this->assertEquals($cmsg, $this->session->cookie->tempdata($key));
		$this->assertEquals($nmsg, $this->session->native->tempdata($key));

		// Unset data and verify message absence
		$this->session->cookie->unset_tempdata($key);
		$this->session->native->unset_tempdata($key);
		$this->assertNull($this->session->cookie->tempdata($key));
		$this->assertNull($this->session->native->tempdata($key));
	}

	/**
	 * Test the sess_regenerate() function
	 *
	 * @covers	CI_Session::sess_regenerate
	 */
	public function test_sess_regenerate()
	{
		// Get current session id, regenerate, and compare
		// Cookie driver
		$oldid = $this->session->cookie->userdata('session_id');
		$this->session->cookie->sess_regenerate();
		$newid = $this->session->cookie->userdata('session_id');
		$this->assertNotEquals($oldid, $newid);

		// Native driver - bug #55267 (https://bugs.php.net/bug.php?id=55267) prevents testing this
		// $oldid = session_id();
		// $this->session->native->sess_regenerate();
		// $oldid = session_id();
		// $this->assertNotEquals($oldid, $newid);
	}

	/**
	 * Test the sess_destroy() function
	 *
	 * @covers	CI_Session::sess_destroy
	 */
	public function test_sess_destroy()
	{
		// Set a userdata message, destroy session, and verify absence
		$key = 'dsttest';
		$msg = 'More test data';

		// Cookie driver
		$this->session->cookie->set_userdata($key, $msg);
		$this->assertEquals($msg, $this->session->cookie->userdata($key));
		$this->session->cookie->sess_destroy();
		$this->assertNull($this->session->cookie->userdata($key));

		// Native driver
		$this->session->native->set_userdata($key, $msg);
		$this->assertEquals($msg, $this->session->native->userdata($key));
		$this->session->native->sess_destroy();
		$this->assertNull($this->session->native->userdata($key));
	}
}

