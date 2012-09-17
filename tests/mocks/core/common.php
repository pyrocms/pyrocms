<?php

// Set up the global CI functions in their most minimal core representation

if ( ! function_exists('get_instance'))
{
	function &get_instance()
	{
		$test = CI_TestCase::instance();
		$test = $test->ci_instance();
		return $test;
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('get_config'))
{
	function &get_config()
	{
		$test = CI_TestCase::instance();
		$config = $test->ci_get_config();
		return $config;
	}
}

if ( ! function_exists('config_item'))
{
	function config_item($item)
	{
		$config =& get_config();

		if ( ! isset($config[$item]))
		{
			return FALSE;
		}

		return $config[$item];
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('load_class'))
{
	function load_class($class, $directory = 'libraries', $prefix = 'CI_')
	{
		if ($directory !== 'core' OR $prefix !== 'CI_')
		{
			throw new Exception('Not Implemented: Non-core load_class()');
		}

		$test = CI_TestCase::instance();

		$obj =& $test->ci_core_class($class);

		if (is_string($obj))
		{
			throw new Exception('Bad Isolation: Use ci_set_core_class to set '.$class);
		}

		return $obj;
	}
}

// This is sort of meh. Should probably be mocked up with
// controllable output, so that we can test some of our
// security code. The function itself will be tested in the
// bootstrap testsuite.
// --------------------------------------------------------------------

if ( ! function_exists('remove_invisible_characters'))
{
	function remove_invisible_characters($str, $url_encoded = TRUE)
	{
		$non_displayables = array();

		// every control character except newline (dec 10)
		// carriage return (dec 13), and horizontal tab (dec 09)

		if ($url_encoded)
		{
			$non_displayables[] = '/%0[0-8bcef]/';	// url encoded 00-08, 11, 12, 14, 15
			$non_displayables[] = '/%1[0-9a-f]/';	// url encoded 16-31
		}

		$non_displayables[] = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S';	// 00-08, 11, 12, 14-31, 127

		do
		{
			$str = preg_replace($non_displayables, '', $str, -1, $count);
		}
		while ($count);

		return $str;
	}
}


// Clean up error messages
// --------------------------------------------------------------------

if ( ! function_exists('show_error'))
{
	function show_error($message, $status_code = 500, $heading = 'An Error Was Encountered')
	{
		throw new RuntimeException('CI Error: '.$message);
	}
}

if ( ! function_exists('show_404'))
{
	function show_404($page = '', $log_error = TRUE)
	{
		throw new RuntimeException('CI Error: 404');
	}
}

if ( ! function_exists('_exception_handler'))
{
	function _exception_handler($severity, $message, $filepath, $line)
	{
		throw new RuntimeException('CI Exception: '.$message.' | '.$filepath.' | '.$line);
	}
}


// We assume a few things about our environment ...
// --------------------------------------------------------------------

if ( ! function_exists('is_php'))
{
	function is_php($version = '5.0.0')
	{
		return ! (version_compare(PHP_VERSION, $version) < 0);
	}
}

if ( ! function_exists('is_really_writable'))
{
	function is_really_writable($file)
	{
		return is_writable($file);
	}
}

if ( ! function_exists('is_loaded'))
{
	function is_loaded()
	{
		throw new Exception('Bad Isolation: mock up environment');
	}
}

if ( ! function_exists('log_message'))
{
	function log_message($level = 'error', $message, $php_error = FALSE)
	{
		return TRUE;
	}
}

if ( ! function_exists('set_status_header'))
{
	function set_status_header($code = 200, $text = '')
	{
		return TRUE;
	}
}