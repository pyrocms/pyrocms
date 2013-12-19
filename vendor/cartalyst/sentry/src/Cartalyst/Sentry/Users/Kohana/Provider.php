<?php namespace Cartalyst\Sentry\Users\Kohana;
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

use Cartalyst\Sentry\Hashing\HasherInterface;
use Cartalyst\Sentry\Groups\GroupInterface;
use Cartalyst\Sentry\Users\ProviderInterface;
use Cartalyst\Sentry\Users\UserInterface;
use Cartalyst\Sentry\Users\UserNotActivatedException;
use Cartalyst\Sentry\Users\UserNotFoundException;
use Cartalyst\Sentry\Users\WrongPasswordException;

class Provider implements ProviderInterface {

	/**
	 * The ORM user model.
	 *
	 * @var string
	 */
	protected $model = 'User';

	/**
	 * The hasher for the model.
	 *
	 * @var \Cartalyst\Sentry\Hashing\HasherInterface
	 */
	protected $hasher;

	/**
	 * Create a new ORM User provider.
	 *
	 * @param  \Cartalyst\Sentry\Hashing\HasherInterface  $hasher
	 * @param  string  $model
	 * @return void
	 */
	public function __construct(HasherInterface $hasher, $model = null)
	{
		$this->hasher = $hasher;

		if (isset($model))
		{
			$this->model = $model;
		}

		$this->setupHasherWithModel();
	}

	/**
	 * Finds a user by the given user ID.
	 *
	 * @param  mixed  $id
	 * @return \Cartalyst\Sentry\Users\UserInterface
	 * @throws \Cartalyst\Sentry\Users\UserNotFoundException
	 */
	public function findById($id)
	{
		$model = $this->createModel();

		$user = $model->where('id', '=', $id)->find();

		if ( ! $user->loaded() )
		{
			throw new UserNotFoundException("A user could not be found with ID [$id].");
		}

		return $user;
	}

	/**
	 * Finds a user by the login value.
	 *
	 * @param  string  $login
	 * @return \Cartalyst\Sentry\Users\UserInterface
	 * @throws \Cartalyst\Sentry\Users\UserNotFoundException
	 */
	public function findByLogin($login)
	{
		$model = $this->createModel();

		$user = $model->where($model->getLoginName(), '=', $login)->find();

		if ( ! $user->loaded() )
		{
			throw new UserNotFoundException("A user could not be found with a login value of [$login].");
		}

		return $user;
	}

	/**
	 * Finds a user by the given credentials.
	 *
	 * @param  array  $credentials
	 * @return \Cartalyst\Sentry\Users\UserInterface
	 * @throws \Cartalyst\Sentry\Users\UserNotFoundException
	 */
	public function findByCredentials(array $credentials)
	{
		$model     = $this->createModel();
		$loginName = $model->getLoginName();

		if ( ! array_key_exists($loginName, $credentials))
		{
			throw new \InvalidArgumentException("Login attribute [$loginName] was not provided.");
		}

		$passwordName = $model->getPasswordName();

		$query              = $model;
		$hashableAttributes = $model->getHashableAttributes();
		$hashedCredentials  = array();

		// build query from given credentials
		foreach ($credentials as $credential => $value)
		{
			// Remove hashed attributes to check later as we need to check these
			// values after we retrieved them because of salts
			if (in_array($credential, $hashableAttributes))
			{
				$hashedCredentials = array_merge($hashedCredentials, array($credential => $value));
			}
			else
			{
				$query = $query->where($credential, '=', $value);
			}
		}
		$user = $query->find();

		if ( ! $user->loaded() )
		{
			throw new UserNotFoundException("A user was not found with the given credentials.");
		}

		// Now check the hashed credentials match ours
		foreach ($hashedCredentials as $credential => $value)
		{
			if ( ! $this->hasher->checkHash($value, $user->{$credential}))
			{
				$message = "A user was found to match all plain text credentials however hashed credential [$credential] did not match.";

				if ($credential == $passwordName)
				{
					throw new WrongPasswordException($message);
				}

				throw new UserNotFoundException($message);
			}
		}

		return $user;
	}

	/**
	 * Finds a user by the given activation code.
	 *
	 * @param  string  $code
	 * @return \Cartalyst\Sentry\Users\UserInterface
	 * @throws \Cartalyst\Sentry\Users\UserNotFoundException
	 * @throws InvalidArgumentException
	 * @throws RuntimeException
	 */
	public function findByActivationCode($code)
	{
		if ( ! $code)
		{
			throw new \InvalidArgumentException("No activation code passed.");
		}

		$model = $this->createModel();

		$result = $model->where('activation_code', '=', $code)->get();

		if (($count = $result->count()) > 1)
		{
			throw new \RuntimeException("Found [$count] users with the same activation code.");
		}

		 $user = $result->find();

		if ( !$user->loaded() )
		{
			throw new UserNotFoundException("A user was not found with the given activation code.");
		}

		return $user;
	}

	/**
	 * Finds a user by the given reset password code.
	 *
	 * @param  string  $code
	 * @return \Cartalyst\Sentry\Users\UserInterface
	 * @throws RuntimeException
	 * @throws \Cartalyst\Sentry\Users\UserNotFoundException
	 */
	public function findByResetPasswordCode($code)
	{
		$model = $this->createModel();

		$result = $model->where('reset_password_code', '=', $code)->get();

		if (($count = $result->count()) > 1)
		{
			throw new \RuntimeException("Found [$count] users with the same reset password code.");
		}

		$user = $result->find();

		if ( ! $user->loaded() )
		{
			throw new UserNotFoundException("A user was not found with the given reset password code.");
		}

		return $user;
	}

	/**
	 * Returns an all users.
	 *
	 * @return array
	 */
	public function findAll()
	{
		return $this->createModel()->find_all();
	}

	/**
	 * Returns all users who belong to
	 * a group.
	 *
	 * @param  \Cartalyst\Sentry\Groups\GroupInterface  $group
	 * @return array
	 */
	public function findAllInGroup(GroupInterface $group)
	{
		return array_filter($this->findAll(), function($user) use ($group)
		{
			return $user->inGroup($group);
		});
	}

	/**
	 * Returns all users with access to
	 * a permission(s).
	 *
	 * @param  string|array  $permissions
	 * @return array
	 */
	public function findAllWithAccess($permissions)
	{
		return array_filter($this->findAll(), function($user) use ($permissions)
		{
			return $user->hasAccess($permissions);
		});
	}

	/**
	 * Returns all users with access to
	 * any given permission(s).
	 *
	 * @param  array  $permissions
	 * @return array
	 */
	public function findAllWithAnyAccess(array $permissions)
	{
		return array_filter($this->findAll(), function($user) use ($permissions)
		{
			return $user->hasAnyAccess($permissions);
		});
	}

	/**
	 * Creates a user.
	 *
	 * @param  array  $credentials
	 * @return \Cartalyst\Sentry\Users\UserInterface
	 */
	public function create(array $credentials)
	{
		if ( ! isset($credentials['permissions']) )
		{
			$credentials['permissions'] = array();
		}

		$user = $this->createModel();
		$user->values($credentials);
		$user->save();

		return $user;
	}

	/**
	 * Returns an empty user object.
	 *
	 * @return \Cartalyst\Sentry\Users\UserInterface
	 */
	public function getEmptyUser()
	{
		return $this->createModel();
	}

	/**
	 * Create a new instance of the model.
	 *
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public function createModel()
	{
		return \ORM::factory($this->model);
	}

	/**
	 * Sets a new model class name to be used at
	 * runtime.
	 *
	 * @param  string  $model
	 */
	public function setModel($model)
	{
		$this->model = $model;
		$this->setupHasherWithModel();
	}

	/**
	 * Statically sets the hasher with the model.
	 *
	 * @return void
	 */
	public function setupHasherWithModel()
	{
		\Model_User::setHasher($this->hasher);
	}

}
