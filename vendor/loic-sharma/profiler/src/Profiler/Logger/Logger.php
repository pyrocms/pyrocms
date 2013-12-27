<?php namespace Profiler\Logger;

use Psr\Log\LogLevel;
use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

class Logger extends AbstractLogger implements ProfilerLoggerInterface {

	/**
	 * The array of logs.
	 *
	 * @var array
	 */
	protected $logs = array();

	/**
	 * The array of queries.
	 *
	 * @var array
	 */
	protected $queries = array();

	/**
	 * Log a query statement.
	 *
	 * @param  string  $query
	 * @param  int     $time
	 * @return null
	 */
	public function query($query, $time = 0)
	{
		$this->queries[] = compact('query', 'time');
	}

	/**
	 * Detailed debug information.
	 *
	 * @param string $message
	 * @param array $context
	 * @return null
	 */
	public function debug($value, array $context = array())
	{
		// If we were given anything other than a string,
		// we'll get readable format of the value.
		if( ! is_string($value))
		{
			$value = print_r($value, true);
		}

		$this->log(LogLevel::DEBUG, $value, $context);
	}

	/**
	 * Logs with an arbitrary level.
	 *
	 * @param  mixed   $level
	 * @param  string  $message
	 * @param  array   $context
	 * @return null
	 */
	public function log($level, $message, array $context = array())
	{
		$this->logs[] = compact('level', 'message', 'context');
	}

	/**
	 * Retrieve the queries.
	 *
	 * @return array
	 */
	public function getQueries()
	{
		return $this->queries;
	}

	/**
	 * Retrieve the logs for the matching level.
	 *
	 * @param  string  $level
	 * @return array
	 */
	public function getLogs($level = null)
	{
		// If no level was given, return all logs.
		if(is_null($level))
		{
			return $this->logs;
		}

		else
		{
			if(isset($this->logs[$level]))
			{
				return $this->logs[$level];
			}
		}

		// If the level doesn't exist, just return an empty array.
		//
		// @todo: check that the level exists, otherwise throw an exception. 
		return array();
	}
}