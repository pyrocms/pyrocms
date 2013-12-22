<?php namespace Cartalyst\Sentry\Throttling\Kohana;
/**
 * Part of the Sentry package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    Sentry
 * @version    2.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2013, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Cartalyst\Sentry\Throttling\ThrottleInterface;
use Cartalyst\Sentry\Throttling\UserSuspendedException;
use Cartalyst\Sentry\Throttling\UserBannedException;
use DateTime;

class Throttle extends \ORM implements ThrottleInterface {

	/**
	 * Throttling status.
	 *
	 * @var bool
	 */
	protected $enabled = true;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $_table_name = 'throttle';

	/**
	 * @var array Define belogst to relation
	 */
	protected $_belongs_to = array('user' => array('model' => 'User'));

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = array();

	/**
	 * Attempt limit.
	 *
	 * @var int
	 */
	protected static $attemptLimit = 5;

	/**
	 * Suspensions time in minutes.
	 *
	 * @var int
	 */
	protected static $suspensionTime = 15;

	/**
	 * Returns the associated user with the throttler.
	 *
	 * @return \Cartalyst\Sentry\Users\UserInterface
	 */
	public function getUser()
	{
		return $this->user;
	}

	/**
	 * Get the current amount of attempts.
	 *
	 * @return int
	 */
	public function getLoginAttempts()
	{
		if ($this->attempts > 0 and $this->last_attempt_at)
		{
			$this->clearLoginAttemptsIfAllowed();
		}

		return $this->attempts;
	}

	/**
	 * Get the number of login attempts a user has left before suspension.
	 *
	 * @return int
	 */
	public function getRemainingLoginAttempts()
	{
		return static::getAttemptLimit() - $this->getLoginAttempts();
	}

	/**
	 * Add a new login attempt.
	 *
	 * @return void
	 */
	public function addLoginAttempt()
	{
		$this->attempts++;
		$this->last_attempt_at = new DateTime;

		if ($this->getLoginAttempts() >= static::$attemptLimit)
		{
			$this->suspend();
		}
		else
		{
			$this->save();
		}
	}

	/**
	 * Clear all login attempts
	 *
	 * @return void
	 */
	public function clearLoginAttempts()
	{
		// If our login attempts is already at zero
		// we do not need to do anything. Additionally,
		// if we are suspended, we are not going to do
		// anything either as clearing login attempts
		// makes us unsuspended. We need to manually
		// call unsuspend() in order to unsuspend.
		if ($this->getLoginAttempts() == 0 or $this->suspended)
		{
			return;
		}

		$this->attempts        = 0;
		$this->last_attempt_at = null;
		$this->suspended       = false;
		$this->suspended_at    = null;
		$this->save();
	}

	/**
	 * Suspend the user associated with the throttle
	 *
	 * @return void
	 */
	public function suspend()
	{
		if ( ! $this->suspended)
		{
			$this->suspended    = true;
			$this->suspended_at = new DateTime;
			$this->save();
		}
	}

	/**
	 * Unsuspend the user.
	 *
	 * @return void
	 */
	public function unsuspend()
	{
		if ($this->suspended)
		{
			$this->attempts        = 0;
			$this->last_attempt_at = null;
			$this->suspended       = false;
			$this->suspended_at    = null;
			$this->save();
		}
	}

	/**
	 * Check if the user is suspended.
	 *
	 * @return bool
	 */
	public function isSuspended()
	{
		if ($this->suspended and $this->suspended_at)
		{
			$this->removeSuspensionIfAllowed();
			return (bool) $this->suspended;
		}

		return false;
	}

	/**
	 * Ban the user.
	 *
	 * @return void
	 */
	public function ban()
	{
		if ( ! $this->banned)
		{
			$this->banned = true;
			$this->banned_at = new DateTime;
			$this->save();
		}
	}

	/**
	 * Unban the user.
	 *
	 * @return void
	 */
	public function unban()
	{
		if ($this->banned)
		{
			$this->banned = false;
			$this->banned_at = null;
			$this->save();
		}
	}

	/**
	 * Check if user is banned
	 *
	 * @return bool
	 */
	public function isBanned()
	{
		return $this->banned;
	}

	/**
	 * Check user throttle status.
	 *
	 * @param \Validation $extra_validation
	 * @return bool
	 * @throws \Cartalyst\Sentry\Throttling\UserBannedException
	 * @throws \Cartalyst\Sentry\Throttling\UserSuspendedException
	 */
	public function check(\Validation $extra_validation = NULL)
	{
		if ($this->isBanned())
		{
			throw new UserBannedException(sprintf(
				'User [%s] has been banned.',
				$this->getUser()->getLogin()
			));
		}
		else if ($this->isSuspended())
		{
			throw new UserSuspendedException(sprintf(
				'User [%s] has been suspended.',
				$this->getUser()->getLogin()
			));
		}

		return parent::check($extra_validation);
	}

	/**
	 * Inspects the last attempt vs the suspension time
	 * (the time in which attempts must space before the
	 * account is suspended). If we can clear our attempts
	 * now, we'll do so and save.
	 *
	 * @return void
	 */
	public function clearLoginAttemptsIfAllowed()
	{
		$lastAttempt = new DateTime($this->last_attempt_at);

		$suspensionTime  = static::$suspensionTime;
		$clearAttemptsAt = $lastAttempt->modify("+{$suspensionTime} minutes");
		$now             = new DateTime;

		if ($clearAttemptsAt <= $now)
		{
			$this->attempts = 0;
			$this->save();
		}

		unset($lastAttempt);
		unset($clearAttemptsAt);
		unset($now);
	}

	/**
	 * Inspects to see if the user can become unsuspended
	 * or not, based on the suspension time provided. If so,
	 * unsuspends.
	 *
	 * @return void
	 */
	public function removeSuspensionIfAllowed()
	{
		$suspended = new DateTime($this->suspended_at);

		$suspensionTime = static::$suspensionTime;
		$unsuspendAt    = $suspended->modify("+{$suspensionTime} minutes");
		$now            = new DateTime;

		if ($unsuspendAt <= $now)
		{
			$this->unsuspend();
		}

		unset($suspended);
		unset($unsuspendAt);
		unset($now);
	}

	/**
	 * Get mutator for the suspended property.
	 *
	 * @param  mixed  $suspended
	 * @return bool
	 */
	public function getSuspendedAttribute($suspended)
	{
		return (bool) $suspended;
	}

	/**
	 * Get mutator for the banned property.
	 *
	 * @param  mixed  $banned
	 * @return bool
	 */
	public function getBannedAttribute($banned)
	{
		return (bool) $banned;
	}

	public function set($column, $value)
	{
		$dates = array('last_attempt_at', 'suspended_at', 'banned_at');

		if (in_array($column, $dates) and is_a($value, 'DateTime'))
		{
			$value = $value->format('Y-m-d H:i:s');
		}

		return parent::set($column, $value);
	}

	/**
	 * Set attempt limit.
	 *
	 * @param  int  $limit
	 */
	public static function setAttemptLimit($limit)
	{
		static::$attemptLimit = (int) $limit;
	}

	/**
	 * Get attempt limit.
	 *
	 * @return  int
	 */
	public static function getAttemptLimit()
	{
		return static::$attemptLimit;
	}

	/**
	 * Set suspension time.
	 *
	 * @param  int  $minutes
	 */
	public static function setSuspensionTime($minutes)
	{
		static::$suspensionTime = (int) $minutes;
	}

	/**
	 * Get suspension time.
	 *
	 * @return int
	 */
	public static function getSuspensionTime()
	{
		return static::$suspensionTime;
	}

	/**
	 * Get the remaining time on a suspension in minutes rounded up. Returns
	 * 0 if user is not suspended.
	 *
	 * @return int
	 */
	public function getRemainingSuspensionTime()
	{
		if(!$this->isSuspended())
			return 0;

		$lastAttempt = clone $this->last_attempt_at;

		$suspensionTime  = static::$suspensionTime;
		$clearAttemptsAt = $lastAttempt->modify("+{$suspensionTime} minutes");
		$now             = new Datetime;

		$timeLeft = $clearAttemptsAt->diff($now);

		$minutesLeft = ($timeLeft->s != 0 ?
						($timeLeft->days * 24 * 60) + ($timeLeft->h * 60) + ($timeLeft->i) + 1 :
						($timeLeft->days * 24 * 60) + ($timeLeft->h * 60) + ($timeLeft->i));

		return $minutesLeft;
	}
}
