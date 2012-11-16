<?php

class Date_helper_test extends CI_TestCase {

	public function set_up()
	{
		$this->helper('date');

		$this->time = time();
	}

	// ------------------------------------------------------------------------

	public function test_now_local()
	{
		/*

		// This stub job, is simply to cater $config['time_reference']
		$config = $this->getMock('CI_Config');
		$config->expects($this->any())
			   ->method('item')
			   ->will($this->returnValue('local'));

		// Add the stub to our test instance
		$this->ci_instance_var('config', $config);

		*/

		$this->ci_set_config('time_reference', 'local');

		$this->assertEquals(time(), now());
	}

	// ------------------------------------------------------------------------

	public function test_now_utc()
	{
		/*

		// This stub job, is simply to cater $config['time_reference']
		$config = $this->getMock('CI_Config');
		$config->expects($this->any())
			   ->method('item')
			   ->will($this->returnValue('UTC'));

		// Add the stub to our stdClass
		$this->ci_instance_var('config', $config);

		*/

		$this->assertEquals(
			mktime(gmdate('G'), gmdate('i'), gmdate('s'), gmdate('n'), gmdate('j'), gmdate('Y')),
			now('UTC')
		);
	}

	// ------------------------------------------------------------------------

	public function test_mdate()
	{
		$this->assertEquals(
			date('Y-m-d - h:i a', $this->time),
			mdate('%Y-%m-%d - %h:%i %a', $this->time)
		);
	}

	// ------------------------------------------------------------------------

	public function test_standard_date_rfc822()
	{
		$this->assertEquals(
			date(DATE_RFC822, $this->time),
			standard_date('DATE_RFC822', $this->time)
		);
	}

	// ------------------------------------------------------------------------

	public function test_standard_date_atom()
	{
		$this->assertEquals(
			date(DATE_ATOM, $this->time),
			standard_date('DATE_ATOM', $this->time)
		);
	}

	// ------------------------------------------------------------------------

	public function test_standard_date_cookie()
	{
		$this->assertEquals(
			date(DATE_COOKIE, $this->time),
			standard_date('DATE_COOKIE', $this->time)
		);
	}

	// ------------------------------------------------------------------------

	public function test_standard_date_iso8601()
	{
		$this->assertEquals(
			date(DATE_ISO8601, $this->time),
			standard_date('DATE_ISO8601', $this->time)
		);
	}

	// ------------------------------------------------------------------------

	public function test_standard_date_rfc850()
	{
		$this->assertEquals(
			date(DATE_RFC850, $this->time),
			standard_date('DATE_RFC850', $this->time)
		);
	}

	// ------------------------------------------------------------------------

	public function test_standard_date_rfc1036()
	{
		$this->assertEquals(
			date(DATE_RFC1036, $this->time),
			standard_date('DATE_RFC1036', $this->time)
		);
	}

	// ------------------------------------------------------------------------

	public function test_standard_date_rfc1123()
	{
		$this->assertEquals(
			date(DATE_RFC1123, $this->time),
			standard_date('DATE_RFC1123', $this->time)
		);
	}

	// ------------------------------------------------------------------------

	public function test_standard_date_rfc2822()
	{
		$this->assertEquals(
			date(DATE_RFC2822, $this->time),
			standard_date('DATE_RFC2822', $this->time)
		);
	}

	// ------------------------------------------------------------------------

	public function test_standard_date_rss()
	{
		$this->assertEquals(
			date(DATE_RSS, $this->time),
			standard_date('DATE_RSS', $this->time)
		);
	}

	// ------------------------------------------------------------------------

	public function test_standard_date_w3c()
	{
		$this->assertEquals(
			date(DATE_W3C, $this->time),
			standard_date('DATE_W3C', $this->time)
		);
	}

	// ------------------------------------------------------------------------

	public function test_timespan()
	{
		$loader_cls = $this->ci_core_class('load');
		$this->ci_instance_var('load', new $loader_cls);

		$lang_cls = $this->ci_core_class('lang');
		$this->ci_instance_var('lang', new $lang_cls);

		$this->assertEquals('1 Second', timespan(time(), time()+1));
		$this->assertEquals('1 Minute', timespan(time(), time()+60));
		$this->assertEquals('1 Hour', timespan(time(), time()+3600));
		$this->assertEquals('2 Hours', timespan(time(), time()+7200));
	}

	// ------------------------------------------------------------------------

	public function test_days_in_month()
	{
		$this->assertEquals(30, days_in_month(06, 2005));
		$this->assertEquals(28, days_in_month(02, 2011));
		$this->assertEquals(29, days_in_month(02, 2012));
	}

	// ------------------------------------------------------------------------

	public function test_local_to_gmt()
	{
		$this->assertEquals(
			mktime(
				gmdate('G', $this->time), gmdate('i', $this->time), gmdate('s', $this->time),
				gmdate('n', $this->time), gmdate('j', $this->time), gmdate('Y', $this->time)
			),
			local_to_gmt($this->time)
		);
	}

	// ------------------------------------------------------------------------

	public function test_gmt_to_local()
	{
		$this->assertEquals(1140128493, gmt_to_local('1140153693', 'UM8', TRUE));
	}

	// ------------------------------------------------------------------------

	public function test_mysql_to_unix()
	{
		$this->assertEquals($this->time, mysql_to_unix(date('Y-m-d H:i:s', $this->time)));
	}

	// ------------------------------------------------------------------------

	public function test_unix_to_human()
	{
		$this->assertEquals(date('Y-m-d h:i A', $this->time), unix_to_human($this->time));
		$this->assertEquals(date('Y-m-d h:i:s A', $this->time), unix_to_human($this->time, TRUE, 'us'));
		$this->assertEquals(date('Y-m-d H:i:s', $this->time), unix_to_human($this->time, TRUE, 'eu'));
	}

	// ------------------------------------------------------------------------

	public function test_human_to_unix()
	{
		$date = '2000-12-31 10:00:00 PM';
		$this->assertEquals(strtotime($date), human_to_unix($date));
		$this->assertFalse(human_to_unix());
	}

	// ------------------------------------------------------------------------

	public function test_timezones()
	{
		$zones = array(
			'UM12'		=> -12,
			'UM11'		=> -11,
			'UM10'		=> -10,
			'UM95'		=> -9.5,
			'UM9'		=> -9,
			'UM8'		=> -8,
			'UM7'		=> -7,
			'UM6'		=> -6,
			'UM5'		=> -5,
			'UM45'		=> -4.5,
			'UM4'		=> -4,
			'UM35'		=> -3.5,
			'UM3'		=> -3,
			'UM2'		=> -2,
			'UM1'		=> -1,
			'UTC'		=> 0,
			'UP1'		=> +1,
			'UP2'		=> +2,
			'UP3'		=> +3,
			'UP35'		=> +3.5,
			'UP4'		=> +4,
			'UP45'		=> +4.5,
			'UP5'		=> +5,
			'UP55'		=> +5.5,
			'UP575'		=> +5.75,
			'UP6'		=> +6,
			'UP65'		=> +6.5,
			'UP7'		=> +7,
			'UP8'		=> +8,
			'UP875'		=> +8.75,
			'UP9'		=> +9,
			'UP95'		=> +9.5,
			'UP10'		=> +10,
			'UP105'		=> +10.5,
			'UP11'		=> +11,
			'UP115'		=> +11.5,
			'UP12'		=> +12,
			'UP1275'	=> +12.75,
			'UP13'		=> +13,
			'UP14'		=> +14
		);

		foreach ($zones AS $test => $expected)
		{
			$this->assertEquals($expected, timezones($test));
		}

		$this->assertArrayHasKey('UP3', timezones());
		$this->assertEquals(0, timezones('non_existant'));
	}

}

/* End of file date_helper_test.php */