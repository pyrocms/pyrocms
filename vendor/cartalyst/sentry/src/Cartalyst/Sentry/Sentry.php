<?php namespace Cartalyst\Sentry;
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

use Cartalyst\Sentry\Cookies\CookieInterface;
use Cartalyst\Sentry\Cookies\NativeCookie;
use Cartalyst\Sentry\Groups\Eloquent\Provider as GroupProvider;
use Cartalyst\Sentry\Groups\ProviderInterface as GroupProviderInterface;
use Cartalyst\Sentry\Hashing\NativeHasher;
use Cartalyst\Sentry\Sessions\NativeSession;
use Cartalyst\Sentry\Sessions\SessionInterface;
use Cartalyst\Sentry\Throttling\Eloquent\Provider as ThrottleProvider;
use Cartalyst\Sentry\Throttling\ProviderInterface as ThrottleProviderInterface;
use Cartalyst\Sentry\Users\LoginRequiredException;
use Cartalyst\Sentry\Users\PasswordRequiredException;
use Cartalyst\Sentry\Users\Eloquent\Provider as UserProvider;
use Cartalyst\Sentry\Users\ProviderInterface as UserProviderInterface;
use Cartalyst\Sentry\Users\UserInterface;
use Cartalyst\Sentry\Users\UserNotFoundException;
use Cartalyst\Sentry\Users\UserNotActivatedException;

class Sentry {

	/**
	 * The user that's been retrieved and is used
	 * for authentication. Authentication methods
	 * are available for finding the user to set
	 * here.
	 *
	 * @var \Cartalyst\Sentry\Users\UserInterface
	 */
	protected $user;

	/**
	 * The session driver used by Sentry.
	 *
	 * @var \Cartalyst\Sentry\Sessions\SessionInterface
	 */
	protected $session;

	/**
	 * The cookie driver used by Sentry.
	 *
	 * @var \Cartalyst\Sentry\Cookies\CookieInterface
	 */
	protected $cookie;

	/**
	 * The user provider, used for retrieving
	 * objects which implement the Sentry user
	 * interface.
	 *
	 * @var \Cartalyst\Sentry\Users\ProviderInterface
	 */
	protected $userProvider;

	/**
	 * The group provider, used for retrieving
	 * objects which implement the Sentry group
	 * interface.
	 *
	 * @var \Cartalyst\Sentry\Groups\ProviderInterface
	 */
	protected $groupProvider;

	/**
	 * The throttle provider, used for retrieving
	 * objects which implement the Sentry throttling
	 * interface.
	 *
	 * @var \Cartalyst\Sentry\Throttling\ProviderInterface
	 */
	protected $throttleProvider;

	/**
	 * The client's IP address associated with Sentry.
	 *
	 * @var string
	 */
	protected $ipAddress = '0.0.0.0';

	/**
	 * Create a new Sentry object.
	 *
	 * @param  \Cartalyst\Sentry\Users\ProviderInterface $userProvider
	 * @param  \Cartalyst\Sentry\Groups\ProviderInterface $groupProvider
	 * @param  \Cartalyst\Sentry\Throttling\ProviderInterface $throttleProvider
	 * @param  \Cartalyst\Sentry\Sessions\SessionInterface $session
	 * @param  \Cartalyst\Sentry\Cookies\CookieInterface $cookie
	 * @param  string $ipAddress
	 * @return void
	 */
	public function __construct(
		UserProviderInterface $userProvider = null,
		GroupProviderInterface $groupProvider = null,
		ThrottleProviderInterface $throttleProvider = null,
		SessionInterface $session = null,
		CookieInterface $cookie = null,
		$ipAddress = null
	)
	{
		$this->userProvider     = $userProvider ?: new UserProvider(new NativeHasher);
		$this->groupProvider    = $groupProvider ?: new GroupProvider;
		$this->throttleProvider = $throttleProvider ?: new ThrottleProvider($this->userProvider);

		$this->session          = $session ?: new NativeSession;
		$this->cookie           = $cookie ?: new NativeCookie;

		if (isset($ipAddress))
		{
			$this->ipAddress = $ipAddress;
		}
	}

	/**
	 * Registers a user by giving the required credentials
	 * and an optional flag for whether to activate the user.
	 *
	 * @param  array  $credentials
	 * @param  bool   $activate
	 * @return \Cartalyst\Sentry\Users\UserInterface
	 */
	public function register(array $credentials, $activate = false)
	{
		$user = $this->userProvider->create($credentials);

		if ($activate)
		{
			$user->attemptActivation($user->getActivationCode());
		}

		return $this->user = $user;
	}


	/**
	 * Attempts to authenticate the given user
	 * according to the passed credentials.
	 *
	 * @param  array  $credentials
	 * @param  bool   $remember
	 * @return \Cartalyst\Sentry\Users\UserInterface
	 * @throws \Cartalyst\Sentry\Throttling\UserBannedException
	 * @throws \Cartalyst\Sentry\Throttling\UserSuspendedException
	 * @throws \Cartalyst\Sentry\Users\LoginRequiredException
	 * @throws \Cartalyst\Sentry\Users\PasswordRequiredException
	 * @throws \Cartalyst\Sentry\Users\UserNotFoundException
	 */
	public function authenticate(array $credentials, $remember = false)
	{
		// We'll default to the login name field, but fallback to a hard-coded
		// 'login' key in the array that was passed.
		$loginName = $this->userProvider->getEmptyUser()->getLoginName();
		$loginCredentialKey = (isset($credentials[$loginName])) ? $loginName : 'login';

		if (empty($credentials[$loginCredentialKey]))
		{
			throw new LoginRequiredException("The [$loginCredentialKey] attribute is required.");
		}

		if (empty($credentials['password']))
		{
			throw new PasswordRequiredException('The password attribute is required.');
		}

		// If the user did the fallback 'login' key for the login code which
		// did not match the actual login name, we'll adjust the array so the
		// actual login name is provided.
		if ($loginCredentialKey !== $loginName)
		{
			$credentials[$loginName] = $credentials[$loginCredentialKey];
			unset($credentials[$loginCredentialKey]);
		}

		// If throttling is enabled, we'll firstly check the throttle.
		// This will tell us if the user is banned before we even attempt
		// to authenticate them
		if ($throttlingEnabled = $this->throttleProvider->isEnabled())
		{
			if ($throttle = $this->throttleProvider->findByUserLogin($credentials[$loginName], $this->ipAddress))
			{
				$throttle->check();
			}
		}

		try
		{
			$user = $this->userProvider->findByCredentials($credentials);
		}
		catch (UserNotFoundException $e)
		{
			if ($throttlingEnabled and isset($throttle))
			{
				$throttle->addLoginAttempt();
			}

			throw $e;
		}

		if ($throttlingEnabled and isset($throttle))
		{
			$throttle->clearLoginAttempts();
		}

		$user->clearResetPassword();

		$this->login($user, $remember);

		return $this->user;
	}

	/**
	 * Alias for authenticating with the remember flag checked.
	 *
	 * @param  array  $credentials
	 * @return \Cartalyst\Sentry\Users\UserInterface
	 */
	public function authenticateAndRemember(array $credentials)
	{
		return $this->authenticate($credentials, true);
	}

	/**
	 * Check to see if the user is logged in and activated, and hasn't been banned or suspended.
	 *
	 * @return bool
	 */
	public function check()
	{
		if (is_null($this->user))
		{
			// Check session first, follow by cookie
			if ( ! $userArray = $this->session->get() and ! $userArray = $this->cookie->get())
			{
				return false;
			}

			// Now check our user is an array with two elements,
			// the username followed by the persist code
			if ( ! is_array($userArray) or count($userArray) !== 2)
			{
				return false;
			}

			list($id, $persistCode) = $userArray;

			// Let's find our user
			try
			{
				$user = $this->getUserProvider()->findById($id);
			}
			catch (UserNotFoundException $e)
			{
				return false;
			}

			// Great! Let's check the session's persist code
			// against the user. If it fails, somebody has tampered
			// with the cookie / session data and we're not allowing
			// a login
			if ( ! $user->checkPersistCode($persistCode))
			{
				return false;
			}

			// Now we'll set the user property on Sentry
			$this->user = $user;
		}

		// Let's check our cached user is indeed activated
		if ( ! $user = $this->getUser() or ! $user->isActivated())
		{
			return false;
		}
		// If throttling is enabled we check it's status
		if( $this->getThrottleProvider()->isEnabled())
		{
			// Check the throttle status
			$throttle = $this->getThrottleProvider()->findByUser( $user );

			if( $throttle->isBanned() or $throttle->isSuspended())
			{
				$this->logout();
				return false;
			}
		}

		return true;
	}

	/**
	 * Logs in the given user and sets properties
	 * in the session.
	 *
	 * @param  \Cartalyst\Sentry\Users\UserInterface  $user
	 * @param  bool  $remember
	 * @return void
	 * @throws \Cartalyst\Sentry\Users\UserNotActivatedException
	 */
	public function login(UserInterface $user, $remember = false)
	{
		if ( ! $user->isActivated())
		{
			$login = $user->getLogin();
			throw new UserNotActivatedException("Cannot login user [$login] as they are not activated.");
		}

		$this->user = $user;

		// Create an array of data to persist to the session and / or cookie
		$toPersist = array($user->getId(), $user->getPersistCode());

		// Set sessions
		$this->session->put($toPersist);

		if ($remember)
		{
			$this->cookie->forever($toPersist);
		}

		// The user model can attach any handlers
		// to the "recordLogin" event.
		$user->recordLogin();
	}

	/**
	 * Alias for logging in and remembering.
	 *
	 * @param  \Cartalyst\Sentry\Users\UserInterface  $user
	 */
	public function loginAndRemember(UserInterface $user)
	{
		$this->login($user, true);
	}

	/**
	 * Logs the current user out.
	 *
	 * @return void
	 */
	public function logout()
	{
		$this->user = null;

		$this->session->forget();
		$this->cookie->forget();
	}

	/**
	 * Sets the user to be used by Sentry.
	 *
	 * @param  \Cartalyst\Sentry\Users\UserInterface
	 * @return void
	 */
	public function setUser(UserInterface $user)
	{
		$this->user = $user;
	}

	/**
	 * Returns the current user being used by Sentry, if any.
	 *
	 * @return \Cartalyst\Sentry\Users\UserInterface
	 */
	public function getUser()
	{
		// We will lazily attempt to load our user
		if (is_null($this->user))
		{
			$this->check();
		}

		return $this->user;
	}

	/**
	 * Sets the session driver for Sentry.
	 *
	 * @param  \Cartalyst\Sentry\Sessions\SessionInterface  $session
	 * @return void
	 */
	public function setSession(SessionInterface $session)
	{
		$this->session = $session;
	}

	/**
	 * Gets the session driver for Sentry.
	 *
	 * @return \Cartalyst\Sentry\Sessions\SessionInterface
	 */
	public function getSession()
	{
		return $this->session;
	}

	/**
	 * Sets the cookie driver for Sentry.
	 *
	 * @param  \Cartalyst\Sentry\Cookies\CookieInterface  $cookie
	 * @return void
	 */
	public function setCookie(CookieInterface $cookie)
	{
		$this->cookie = $cookie;
	}

	/**
	 * Gets the cookie driver for Sentry.
	 *
	 * @return \Cartalyst\Sentry\Cookies\CookieInterface
	 */
	public function getCookie()
	{
		return $this->cookie;
	}

	/**
	 * Sets the group provider for Sentry.
	 *
	 * @param  \Cartalyst\Sentry\Groups\ProviderInterface
	 * @return void
	 */
	public function setGroupProvider(GroupProviderInterface $groupProvider)
	{
		$this->groupProvider = $groupProvider;
	}

	/**
	 * Gets the group provider for Sentry.
	 *
	 * @return \Cartalyst\Sentry\Groups\ProviderInterface
	 */
	public function getGroupProvider()
	{
		return $this->groupProvider;
	}

	/**
	 * Sets the user provider for Sentry.
	 *
	 * @param  \Cartalyst\Sentry\Users\ProviderInterface
	 * @return void
	 */
	public function setUserProvider(UserProviderInterface $userProvider)
	{
		$this->userProvider = $userProvider;
	}

	/**
	 * Gets the user provider for Sentry.
	 *
	 * @return \Cartalyst\Sentry\Users\ProviderInterface
	 */
	public function getUserProvider()
	{
		return $this->userProvider;
	}

	/**
	 * Sets the throttle provider for Sentry.
	 *
	 * @param  \Cartalyst\Sentry\Throttling\ProviderInterface
	 * @return void
	 */
	public function setThrottleProvider(ThrottleProviderInterface $throttleProvider)
	{
		$this->throttleProvider = $throttleProvider;
	}

	/**
	 * Gets the throttle provider for Sentry.
	 *
	 * @return \Cartalyst\Sentry\Throttling\ProviderInterface
	 */
	public function getThrottleProvider()
	{
		return $this->throttleProvider;
	}

	/**
	 * Sets the IP address Sentry is bound to.
	 *
	 * @param  string  $ipAddress
	 * @return void
	 */
	public function setIpAddress($ipAddress)
	{
		$this->ipAddress = $ipAddress;
	}

	/**
	 * Gets the IP address Sentry is bound to.
	 *
	 * @return string
	 */
	public function getIpAddress()
	{
		return $this->ipAddress;
	}

	/**
	 * Find the group by ID.
	 *
	 * @param  int  $id
	 * @return \Cartalyst\Sentry\Groups\GroupInterface  $group
	 * @throws \Cartalyst\Sentry\Groups\GroupNotFoundException
	 */
	public function findGroupById($id)
	{
		return $this->groupProvider->findById($id);
	}

	/**
	 * Find the group by name.
	 *
	 * @param  string  $name
	 * @return \Cartalyst\Sentry\Groups\GroupInterface  $group
	 * @throws \Cartalyst\Sentry\Groups\GroupNotFoundException
	 */
	public function findGroupByName($name)
	{
		return $this->groupProvider->findByName($name);
	}

	/**
	 * Returns all groups.
	 *
	 * @return array  $groups
	 */
	public function findAllGroups()
	{
		return $this->groupProvider->findAll();
	}

	/**
	 * Creates a group.
	 *
	 * @param  array  $attributes
	 * @return \Cartalyst\Sentry\Groups\GroupInterface
	 */
	public function createGroup(array $attributes)
	{
		return $this->groupProvider->create($attributes);
	}


	/**
	 * Finds a user by the given user ID.
	 *
	 * @param  mixed  $id
	 * @return \Cartalyst\Sentry\Users\UserInterface
	 * @throws \Cartalyst\Sentry\Users\UserNotFoundException
	 */
	public function findUserById($id)
	{
		return $this->userProvider->findById($id);
	}

	/**
	 * Finds a user by the login value.
	 *
	 * @param  string  $login
	 * @return \Cartalyst\Sentry\Users\UserInterface
	 * @throws \Cartalyst\Sentry\Users\UserNotFoundException
	 */
	public function findUserByLogin($login)
	{
		return $this->userProvider->findByLogin($login);
	}

	/**
	 * Finds a user by the given credentials.
	 *
	 * @param  array  $credentials
	 * @return \Cartalyst\Sentry\Users\UserInterface
	 * @throws \Cartalyst\Sentry\Users\UserNotFoundException
	 */
	public function findUserByCredentials(array $credentials){
		return $this->userProvider->findByCredentials($credentials);
	}

	/**
	 * Finds a user by the given activation code.
	 *
	 * @param  string  $code
	 * @return \Cartalyst\Sentry\Users\UserInterface
	 * @throws \RuntimeException
	 * @throws \Cartalyst\Sentry\Users\UserNotFoundException
	 */
	public function findUserByActivationCode($code)
	{
		return $this->userProvider->findByActivationCode($code);
	}

	/**
	 * Finds a user by the given reset password code.
	 *
	 * @param  string  $code
	 * @return \Cartalyst\Sentry\Users\UserInterface
	 * @throws \RuntimeException
	 * @throws \Cartalyst\Sentry\Users\UserNotFoundException
	 */
	public function findUserByResetPasswordCode($code)
	{
		return $this->userProvider->findByResetPasswordCode($code);
	}

	/**
	 * Returns an all users.
	 *
	 * @return array
	 */
	public function findAllUsers()
	{
		return $this->userProvider->findAll();
	}

	/**
	 * Returns all users who belong to
	 * a group.
	 *
	 * @param  \Cartalyst\Sentry\Groups\GroupInterface  $group
	 * @return array
	 */
	public function findAllUsersInGroup($group)
	{
		return $this->userProvider->findAllInGroup($group);
	}

	/**
	 * Returns all users with access to
	 * a permission(s).
	 *
	 * @param  string|array  $permissions
	 * @return array
	 */
	public function findAllUsersWithAccess($permissions)
	{
		return $this->userProvider->findAllWithAccess($permissions);
	}

	/**
	 * Returns all users with access to
	 * any given permission(s).
	 *
	 * @param  array  $permissions
	 * @return array
	 */
	public function findAllUsersWithAnyAccess(array $permissions)
	{
		return $this->userProvider->findAllWithAnyAccess($permissions);
	}

	/**
	 * Creates a user.
	 *
	 * @param  array  $credentials
	 * @return \Cartalyst\Sentry\Users\UserInterface
	 */
	public function createUser(array $credentials)
	{
		return $this->userProvider->create($credentials);
	}

	/**
	 * Returns an empty user object.
	 *
	 * @return \Cartalyst\Sentry\Users\UserInterface
	 */
	public function getEmptyUser()
	{
		return $this->userProvider->getEmptyUser();
	}

	/**
	 * Finds a throttler by the given user ID.
	 *
	 * @param  mixed   $id
	 * @param  string  $ipAddress
	 * @return \Cartalyst\Sentry\Throttling\ThrottleInterface
	 */
	public function findThrottlerByUserId($id, $ipAddress = null)
	{
		return $this->throttleProvider->findByUserId($id,$ipAddress);
	}

	/**
	 * Finds a throttling interface by the given user login.
	 *
	 * @param  string  $login
	 * @param  string  $ipAddress
	 * @return \Cartalyst\Sentry\Throttling\ThrottleInterface
	 */
	public function findThrottlerByUserLogin($login, $ipAddress = null)
	{
		return $this->throttleProvider->findByUserLogin($login,$ipAddress);
	}

	/**
	 * Handle dynamic method calls into the method.
	 *
	 * @param  string  $method
	 * @param  array   $parameters
	 * @return mixed
	 * @throws \BadMethodCallException
	 */
	public function __call($method, $parameters)
	{
		if (isset($this->user))
		{
			return call_user_func_array(array($this->user, $method), $parameters);
		}

		throw new \BadMethodCallException("Method [$method] is not supported by Sentry or no User has been set on Sentry to access shortcut method.");
	}

}

