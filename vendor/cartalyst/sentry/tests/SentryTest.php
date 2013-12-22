<?php namespace Cartalyst\Sentry\Tests;
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

use Mockery as m;
use Cartalyst\Sentry\Sentry;
use Cartalyst\Sentry\Throttling\UserBannedException;
use Cartalyst\Sentry\Throttling\UserSuspendedException;
use Cartalyst\Sentry\Users\UserNotFoundException;
use PHPUnit_Framework_TestCase;

class SentryTest extends PHPUnit_Framework_TestCase {

	protected $userProvider;

	protected $groupProvider;

	protected $throttleProvider;

	protected $hasher;

	protected $session;

	protected $cookie;

	protected $sentry;

	/**
	 * Setup resources and dependencies.
	 *
	 * @return void
	 */
	public function setUp()
	{
		$this->sentry = new Sentry(
			$this->userProvider     = m::mock('Cartalyst\Sentry\Users\ProviderInterface'),
			$this->groupProvider    = m::mock('Cartalyst\Sentry\Groups\ProviderInterface'),
			$this->throttleProvider = m::mock('Cartalyst\Sentry\Throttling\ProviderInterface'),
			$this->session          = m::mock('Cartalyst\Sentry\Sessions\SessionInterface'),
			$this->cookie           = m::mock('Cartalyst\Sentry\Cookies\CookieInterface')
		);
	}

	/**
	 * Close mockery.
	 *
	 * @return void
	 */
	public function tearDown()
	{
		m::close();
	}

	/**
	 * @expectedException Cartalyst\Sentry\Users\UserNotActivatedException
	 */
	public function testLoggingInUnactivatedUser()
	{
		$user = m::mock('Cartalyst\Sentry\Users\UserInterface');
		$user->shouldReceive('isActivated')->once()->andReturn(false);
		$user->shouldReceive('getLogin')->once()->andReturn('foo');

		$this->sentry->login($user);
	}

	public function testLoggingInUser()
	{
		$user = m::mock('Cartalyst\Sentry\Users\UserInterface');
		$user->shouldReceive('isActivated')->once()->andReturn(true);
		$user->shouldReceive('getId')->once()->andReturn('foo');
		$user->shouldReceive('getPersistCode')->once()->andReturn('persist_code');
		$user->shouldReceive('recordLogin')->once();

		$this->session->shouldReceive('put')->with(array('foo', 'persist_code'))->once();

		$this->sentry->login($user);
	}

	public function testLoggingInAndRemembering()
	{
		$sentry = m::mock('Cartalyst\Sentry\Sentry[login]');
		$sentry->shouldReceive('login')->with($user = m::mock('Cartalyst\Sentry\Users\UserInterface'), true)->once();
		$sentry->loginAndRemember($user);
	}

	/**
	 * @expectedException Cartalyst\Sentry\Users\LoginRequiredException
	 */
	public function testAuthenticatingUserWhenLoginIsNotProvided()
	{
		$credentials = array();

		$this->userProvider->shouldReceive('getEmptyUser')->once()->andReturn($user = m::mock('Cartalyst\Sentry\Users\UserInterface'));
		$user->shouldReceive('getLoginName')->once()->andReturn('email');

		$this->sentry->authenticate($credentials);
	}

	/**
	 * @expectedException Cartalyst\Sentry\Users\PasswordRequiredException
	 */
	public function testAuthenticatingUserWhenPasswordIsNotProvided()
	{
		$credentials = array(
			'email' => 'foo@bar.com',
		);

		$this->userProvider->shouldReceive('getEmptyUser')->once()->andReturn($user = m::mock('Cartalyst\Sentry\Users\UserInterface'));
		$user->shouldReceive('getLoginName')->once()->andReturn('email');

		$this->sentry->authenticate($credentials);
	}

	/**
	 * @expectedException Cartalyst\Sentry\Users\UserNotFoundException
	 */
	public function testAuthenticatingUserWhereTheUserDoesNotExist()
	{
		$credentials = array(
			'email'    => 'foo@bar.com',
			'password' => 'baz_bat',
		);

		$this->throttleProvider->shouldReceive('isEnabled')->once()->andReturn(false);

		$this->userProvider->shouldReceive('getEmptyUser')->once()->andReturn($user = m::mock('Cartalyst\Sentry\Users\UserInterface'));
		$user->shouldReceive('getLoginName')->once()->andReturn('email');

		$this->userProvider->shouldReceive('findByCredentials')->with($credentials)->once()->andThrow(new UserNotFoundException);

		$this->sentry->authenticate($credentials);
	}

	/**
	 * @expectedException Cartalyst\Sentry\Throttling\UserBannedException
	 */
	public function testAuthenticatingWhenUserIsBanned()
	{
		$credentials = array(
			'email'    => 'foo@bar.com',
			'password' => 'baz_bat',
		);

		$this->userProvider->shouldReceive('getEmptyUser')->once()->andReturn($emptyUser = m::mock('Caralyst\Sentry\Users\UserInterface'));
		$emptyUser->shouldReceive('getLoginName')->once()->andReturn('email');

		$this->throttleProvider->shouldReceive('isEnabled')->once()->andReturn(true);
		$this->throttleProvider->shouldReceive('findByUserLogin')->with('foo@bar.com', '0.0.0.0')->once()->andReturn($throttle = m::mock('Cartalyst\Sentry\Throttling\ThrottleInterface'));

		$throttle->shouldReceive('check')->once()->andThrow(new UserBannedException);

		$this->sentry->authenticate($credentials);
	}

	/**
	 * @expectedException Cartalyst\Sentry\Throttling\UserSuspendedException
	 */
	public function testAuthenticatingWhenUserIsSuspended()
	{
		$credentials = array(
			'email'    => 'foo@bar.com',
			'password' => 'baz_bat',
		);

		$this->userProvider->shouldReceive('getEmptyUser')->once()->andReturn($emptyUser = m::mock('Caralyst\Sentry\Users\UserInterface'));
		$emptyUser->shouldReceive('getLoginName')->once()->andReturn('email');

		$this->throttleProvider->shouldReceive('isEnabled')->once()->andReturn(true);
		$this->throttleProvider->shouldReceive('findByUserLogin')->with('foo@bar.com', '0.0.0.0')->once()->andReturn($throttle = m::mock('Cartalyst\Sentry\Throttling\ThrottleInterface'));

		$throttle->shouldReceive('check')->once()->andThrow(new UserSuspendedException);

		$this->sentry->authenticate($credentials);
	}

	/**
	 * @expectedException Cartalyst\Sentry\Users\UserNotFoundException
	 */
	public function testAuthenticatingUserWhereTheUserDoesNotExistWithThrottling()
	{
		$credentials = array(
			'email'    => 'foo@bar.com',
			'password' => 'baz_bat',
		);

		$this->userProvider->shouldReceive('getEmptyUser')->once()->andReturn($emptyUser = m::mock('Caralyst\Sentry\Users\UserInterface'));
		$emptyUser->shouldReceive('getLoginName')->once()->andReturn('email');

		$this->throttleProvider->shouldReceive('isEnabled')->once()->andReturn(true);
		$this->throttleProvider->shouldReceive('findByUserLogin')->with('foo@bar.com', '0.0.0.0')->once()->andReturn($throttle = m::mock('Cartalyst\Sentry\Throttling\ThrottleInterface'));

		$throttle->shouldReceive('check')->once();

		$this->userProvider->shouldReceive('findByCredentials')->with($credentials)->once()->andThrow(new UserNotFoundException);

		// If we try find the user and they do not exist, we
		// add another login attempt to their throttle
		$throttle->shouldReceive('addLoginAttempt')->once();

		$this->sentry->authenticate($credentials);
	}

	public function testAuthenticatingUser()
	{
		$this->sentry = m::mock('Cartalyst\Sentry\Sentry[login]');
		$this->sentry->__construct(
			$this->userProvider,
			$this->groupProvider,
			$this->throttleProvider,
			$this->session,
			$this->cookie
		);

		$credentials = array(
			'email'    => 'foo@bar.com',
			'password' => 'baz_bat',
		);

		$this->throttleProvider->shouldReceive('isEnabled')->once()->andReturn(false);

		$this->userProvider->shouldReceive('getEmptyUser')->once()->andReturn($user = m::mock('Cartalyst\Sentry\Users\UserInterface'));
		$user->shouldReceive('getLoginName')->once()->andReturn('email');

		$this->userProvider->shouldReceive('findByCredentials')->with($credentials)->once()->andReturn($user = m::mock('Cartalyst\Sentry\Users\UserInterface'));

		$user->shouldReceive('clearResetPassword')->once();

		$this->sentry->shouldReceive('login')->with($user, false)->once();
		$this->sentry->authenticate($credentials);
	}

	public function testAuthenticatingUserWithThrottling()
	{
		$this->sentry = m::mock('Cartalyst\Sentry\Sentry[login]');
		$this->sentry->__construct(
			$this->userProvider,
			$this->groupProvider,
			$this->throttleProvider,
			$this->session,
			$this->cookie
		);

		$credentials = array(
			'email'    => 'foo@bar.com',
			'password' => 'baz_bat',
		);

		$credentials = array(
			'email'    => 'foo@bar.com',
			'password' => 'baz_bat',
		);

		$this->userProvider->shouldReceive('getEmptyUser')->once()->andReturn($emptyUser = m::mock('Caralyst\Sentry\Users\UserInterface'));
		$emptyUser->shouldReceive('getLoginName')->once()->andReturn('email');

		$this->throttleProvider->shouldReceive('isEnabled')->once()->andReturn(true);
		$this->throttleProvider->shouldReceive('findByUserLogin')->with('foo@bar.com', '0.0.0.0')->once()->andReturn($throttle = m::mock('Cartalyst\Sentry\Throttling\ThrottleInterface'));

		$throttle->shouldReceive('check')->once();

		$this->userProvider->shouldReceive('findByCredentials')->with($credentials)->once()->andReturn($user = m::mock('Cartalyst\Sentry\Users\UserInterface'));

		// Upon successful login with throttling, the throttle
		// attemps are cleared
		$throttle->shouldReceive('clearLoginAttempts')->once();

		// We then clear any reset password attempts as the
		// login was succesfuly
		$user->shouldReceive('clearResetPassword')->once();

		// And we manually log in our user
		$this->sentry->shouldReceive('login')->with($user, false)->once();

		$this->sentry->authenticate($credentials);
	}

	public function testAuthenticatingUserAndRemembering()
	{
		$this->sentry = m::mock('Cartalyst\Sentry\Sentry[authenticate]');

		$credentials = array(
			'email'    => 'foo@bar.com',
			'password' => 'baz_bat',
		);

		$this->sentry->shouldReceive('authenticate')->with($credentials, true)->once();
		$this->sentry->authenticateAndRemember($credentials);
	}

	public function testCheckLoggingOut()
	{
		$this->sentry->setUser(m::mock('Cartalyst\Sentry\Users\UserInterface'));
		$this->session->shouldReceive('get')->once();
		$this->session->shouldReceive('forget')->once();
		$this->cookie->shouldReceive('get')->once();
		$this->cookie->shouldReceive('forget')->once();

		$this->sentry->logout();
		$this->assertNull($this->sentry->getUser());
	}

	public function testCheckingUserWhenUserIsSetAndActivated()
	{
		$user = m::mock('Cartalyst\Sentry\Users\UserInterface');
		$throttle = m::mock('Cartalyst\Sentry\Throttling\ThrottleInterface');
		$throttle->shouldReceive('isBanned')->once()->andReturn(false);
		$throttle->shouldReceive('isSuspended')->once()->andReturn(false);

		$user->shouldReceive('isActivated')->once()->andReturn(true);

		$this->throttleProvider->shouldReceive('findByUser')->once()->andReturn($throttle);
		$this->throttleProvider->shouldReceive('isEnabled')->once()->andReturn(true);

		$this->sentry->setUser($user);
		$this->assertTrue($this->sentry->check());
	}

	public function testCheckingUserWhenUserIsSetAndSuspended()
	{
		$user     = m::mock('Cartalyst\Sentry\Users\UserInterface');
		$throttle = m::mock('Cartalyst\Sentry\Throttling\ThrottleInterface');
		$session  = m::mock('Cartalyst\Sentry\Sessions\SessionInterface');
		$cookie   = m::mock('Cartalyst\Sentry\Cookies\CookieInterface');

		$throttle->shouldReceive('isBanned')->once()->andReturn(false);
		$throttle->shouldReceive('isSuspended')->once()->andReturn(true);

		$session->shouldReceive('forget')->once();
		$cookie->shouldReceive('forget')->once();

		$user->shouldReceive('isActivated')->once()->andReturn(true);

		$this->throttleProvider->shouldReceive('findByUser')->once()->andReturn($throttle);
		$this->throttleProvider->shouldReceive('isEnabled')->once()->andReturn(true);

		$this->sentry->setSession($session);
		$this->sentry->setCookie($cookie);
		$this->sentry->setUser($user);
		$this->assertFalse($this->sentry->check());
	}

	public function testCheckingUserWhenUserIsSetAndBanned()
	{
		$user     = m::mock('Cartalyst\Sentry\Users\UserInterface');
		$throttle = m::mock('Cartalyst\Sentry\Throttling\ThrottleInterface');
		$session  = m::mock('Cartalyst\Sentry\Sessions\SessionInterface');
		$cookie   = m::mock('Cartalyst\Sentry\Cookies\CookieInterface');

		$throttle->shouldReceive('isBanned')->once()->andReturn(true);

		$session->shouldReceive('forget')->once();
		$cookie->shouldReceive('forget')->once();

		$user->shouldReceive('isActivated')->once()->andReturn(true);

		$this->throttleProvider->shouldReceive('findByUser')->once()->andReturn($throttle);
		$this->throttleProvider->shouldReceive('isEnabled')->once()->andReturn(true);

		$this->sentry->setSession($session);
		$this->sentry->setCookie($cookie);
		$this->sentry->setUser($user);
		$this->assertFalse($this->sentry->check());
	}

	public function testCheckingUserWhenUserIsSetAndNotActivated()
	{
		$user = m::mock('Cartalyst\Sentry\Users\UserInterface');
		$user->shouldReceive('isActivated')->once()->andReturn(false);

		$this->sentry->setUser($user);
		$this->assertFalse($this->sentry->check());
	}

	public function testCheckingUserChecksSessionFirst()
	{
		$this->session->shouldReceive('get')->once()->andReturn(array('foo', 'persist_code'));
		$this->cookie->shouldReceive('get')->never();

		$throttle = m::mock('Cartalyst\Sentry\Throttling\ThrottleInterface');
		$throttle->shouldReceive('isBanned')->once()->andReturn(false);
		$throttle->shouldReceive('isSuspended')->once()->andReturn(false);

		$this->throttleProvider->shouldReceive('findByUser')->once()->andReturn($throttle);
		$this->throttleProvider->shouldReceive('isEnabled')->once()->andReturn(true);

		$this->userProvider->shouldReceive('findById')->andReturn($user = m::mock('Cartalyst\Sentry\Users\UserInterface'));

		$user->shouldReceive('checkPersistCode')->with('persist_code')->once()->andReturn(true);
		$user->shouldReceive('isActivated')->once()->andReturn(true);

		$this->assertTrue($this->sentry->check());
	}

	public function testCheckingUserChecksSessionFirstAndThenCookie()
	{
		$this->session->shouldReceive('get')->once();
		$this->cookie->shouldReceive('get')->once()->andReturn(array('foo', 'persist_code'));

		$throttle = m::mock('Cartalyst\Sentry\Throttling\ThrottleInterface');
		$throttle->shouldReceive('isBanned')->once()->andReturn(false);
		$throttle->shouldReceive('isSuspended')->once()->andReturn(false);

		$this->userProvider->shouldReceive('findById')->andReturn($user = m::mock('Cartalyst\Sentry\Users\UserInterface'));
		$this->throttleProvider->shouldReceive('findByUser')->once()->andReturn($throttle);
		$this->throttleProvider->shouldReceive('isEnabled')->once()->andReturn(true);

		$user->shouldReceive('checkPersistCode')->with('persist_code')->once()->andReturn(true);
		$user->shouldReceive('isActivated')->once()->andReturn(true);

		$this->assertTrue($this->sentry->check());
	}

	public function testCheckingUserReturnsFalseIfNoArrayIsReturned()
	{
		$this->session->shouldReceive('get')->once()->andReturn('we_should_never_return_a_string');

		$this->assertFalse($this->sentry->check());
	}

	public function testCheckingUserReturnsFalseIfIncorrectArrayIsReturned()
	{
		$this->session->shouldReceive('get')->once()->andReturn(array('we', 'should', 'never', 'have', 'more', 'than', 'two'));

		$this->assertFalse($this->sentry->check());
	}

	public function testCheckingUserWhenNothingIsFound()
	{
		$this->session->shouldReceive('get')->once()->andReturn(null);

		$this->cookie->shouldReceive('get')->once()->andReturn(null);

		$this->assertFalse($this->sentry->check());
	}

	public function testRegisteringUser()
	{
		$credentials = array(
			'email'    => 'foo@bar.com',
			'password' => 'sdf_sdf',
		);

		$user = m::mock('Cartalyst\Sentry\Users\UserInterface');
		$user->shouldReceive('getActivationCode')->never();
		$user->shouldReceive('attemptActivation')->never();
		$user->shouldReceive('isActivated')->once()->andReturn(false);

		$this->userProvider->shouldReceive('create')->with($credentials)->once()->andReturn($user);

		$this->assertEquals($user, $registeredUser = $this->sentry->register($credentials));
		$this->assertFalse($registeredUser->isActivated());
	}

	public function testRegisteringUserWithActivationDone()
	{
		$credentials = array(
			'email'    => 'foo@bar.com',
			'password' => 'sdf_sdf',
		);

		$user = m::mock('Cartalyst\Sentry\Users\UserInterface');
		$user->shouldReceive('getActivationCode')->once()->andReturn('activation_code_here');
		$user->shouldReceive('attemptActivation')->with('activation_code_here')->once();
		$user->shouldReceive('isActivated')->once()->andReturn(true);

		$this->userProvider->shouldReceive('create')->with($credentials)->once()->andReturn($user);

		$this->assertEquals($user, $registeredUser = $this->sentry->register($credentials, true));
		$this->assertTrue($registeredUser->isActivated());
	}

	public function testGetUserWithCheck()
	{
		$sentry = m::mock('Cartalyst\Sentry\Sentry[check]');
		$sentry->shouldReceive('check')->once();
		$sentry->getUser();
	}

    public function testFindGroupById()
    {
        $this->groupProvider->shouldReceive('findById')->once()->andReturn(true);
        $this->assertTrue($this->sentry->findGroupByID(1));
    }

    public function testFindGroupByName()
    {
        $this->groupProvider->shouldReceive('findByName')->once()->andReturn(true);
        $this->assertTrue($this->sentry->findGroupByName("name"));
    }

    public function testFindAllGroups()
    {
        $this->groupProvider->shouldReceive('findAll')->once()->andReturn(true);
        $this->assertTrue($this->sentry->findAllGroups());
    }

    public function testCreateGroup()
    {
        $this->groupProvider->shouldReceive('create')->once()->andReturn(true);
        $this->assertTrue($this->sentry->createGroup(array()));
    }

    public function testFindUserByID()
    {
        $this->userProvider->shouldReceive('findById')->once()->andReturn(true);
        $this->assertTrue($this->sentry->findUserById(1));
    }
    public function testFindUserByLogin()
    {
        $this->userProvider->shouldReceive('findByLogin')->once()->andReturn(true);
        $this->assertTrue($this->sentry->findUserByLogin("login"));
    }

    public function testFindUserByCredentials()
    {
        $this->userProvider->shouldReceive('findByCredentials')->once()->andReturn(true);
        $this->assertTrue($this->sentry->findUserByCredentials(array()));
    }

    public function testFindUserByActivationCode()
    {
        $this->userProvider->shouldReceive('findByActivationCode')->once()->andReturn(true);
        $this->assertTrue($this->sentry->findUserByActivationCode("x"));
    }

    public function testFindUserByResetPasswordCode()
    {
        $this->userProvider->shouldReceive('findByResetPasswordCode')->once()->andReturn(true);
        $this->assertTrue($this->sentry->findUserByResetPasswordCode("x"));
    }

    public function testFindAllUsers()
    {
        $this->userProvider->shouldReceive('findAll')->once()->andReturn(true);
        $this->assertTrue($this->sentry->findAllUsers());
    }

    public function testFindAllUsersInGroup()
    {
        $group = m::mock('Cartalyst\Sentry\Groups\GroupInterface');
        $this->userProvider->shouldReceive('findAllInGroup')->once()->andReturn(true);
        $this->assertTrue($this->sentry->findAllUsersInGroup($group));
    }

    public function testFindAllUsersWithAccess()
    {
        $this->userProvider->shouldReceive('findAllWithAccess')->once()->andReturn(true);
        $this->assertTrue($this->sentry->findAllUsersWithAccess(""));
    }

    public function testFindAllUsersWithAnyAccess()
    {
        $this->userProvider->shouldReceive('findAllWithAnyAccess')->once()->andReturn(true);
        $this->assertTrue($this->sentry->findAllUsersWithAnyAccess(array()));
    }

    public function testCreateUser()
    {
        $this->userProvider->shouldReceive('create')->once()->andReturn(true);
        $this->assertTrue($this->sentry->createUser(array()));
    }

    public function testGetEmptyUser()
    {
        $this->userProvider->shouldReceive('getEmptyUser')->once()->andReturn(true);
        $this->assertTrue($this->sentry->getEmptyUser());
    }

    public function testFindThrottlerByUserID()
    {
        $this->throttleProvider->shouldReceive('findByUserId')->once()->andReturn(true);
        $this->assertTrue($this->sentry->findThrottlerByUserId(1));
    }

    public function testFindThrottlerByUserLogin()
    {
        $this->throttleProvider->shouldReceive('findByUserLogin')->once()->andReturn(true);
        $this->assertTrue($this->sentry->findThrottlerByUserLogin("X"));
    }

}
