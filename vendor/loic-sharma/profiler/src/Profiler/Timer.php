<?php namespace Profiler;

class Timer {

	/**
	 * The time at which the timer was started.
	 *
	 * @var double
	 */
	protected $startTime;

	/**
	 * The time at which the timer was ended.
	 *
	 * @var double
	 */
	protected $endTime;

	/**
	 * Start the timer.
	 *
	 * @param  double|null  $startTime
	 * @return void
	 */
	public function __construct($startTime = null)
	{
		$this->startTime = $startTime ?: microtime(true);
	}

	/**
	 * End the timer.
	 *
	 * @param  double|null  $time
	 * @return void
	 */
	public function end($time = null)
	{
		// The timer should be ended only once.
		if(is_null($this->endTime))
		{
			$this->endTime = $time ?: microtime(true);
		}
	}

	/**
	 * Get the amount of time (in milliseconds) that elapsed while the timer
	 * was turned on.
	 *
	 * @return double
	 */
	public function getElapsedTime()
	{
		// Make sure the timer is turned off before we attempt
		// to measure how much time elapsed.
		$this->end();

		return round(1000 * ($this->endTime - $this->startTime), 4);
	}
}