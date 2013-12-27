<?php namespace Profiler\Logger;

use Psr\Log\LoggerInterface;

interface ProfilerLoggerInterface extends LoggerInterface {

	/**
	 * Log a query statement.
	 *
	 * @param  string  $query
	 * @param  int     $time
	 * @return null
	 */
	public function query($query, $time = 0);

	/**
	 * Retrieve the queries.
	 *
	 * @return array
	 */
	public function getQueries();

	/**
	 * Retrieve the logs for the matching level.
	 *
	 * @param  string  $level
	 * @return array
	 */
	public function getLogs($level = null);
}