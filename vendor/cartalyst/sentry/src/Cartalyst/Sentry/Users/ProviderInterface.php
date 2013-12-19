<?php namespace Cartalyst\Sentry\Users;
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

use Cartalyst\Sentry\Groups\GroupInterface;

interface ProviderInterface {

	/**
	 * Finds a user by the given user ID.
	 *
	 * @param  mixed  $id
	 * @return \Cartalyst\Sentry\Users\UserInterface
	 * @throws \Cartalyst\Sentry\Users\UserNotFoundException
	 */
	public function findById($id);

	/**
	 * Finds a user by the login value.
	 *
	 * @param  string  $login
	 * @return \Cartalyst\Sentry\Users\UserInterface
	 * @throws \Cartalyst\Sentry\Users\UserNotFoundException
	 */
	public function findByLogin($login);

	/**
	 * Finds a user by the given credentials.
	 *
	 * @param  array  $credentials
	 * @return \Cartalyst\Sentry\Users\UserInterface
	 * @throws \Cartalyst\Sentry\Users\UserNotFoundException
	 */
	public function findByCredentials(array $credentials);

	/**
	 * Finds a user by the given activation code.
	 *
	 * @param  string  $code
	 * @return \Cartalyst\Sentry\Users\UserInterface
	 * @throws \Cartalyst\Sentry\Users\UserNotFoundException
	 * @throws InvalidArgumentException
	 * @throws RuntimeException
	 */
	public function findByActivationCode($code);

	/**
	 * Finds a user by the given reset password code.
	 *
	 * @param  string  $code
	 * @return \Cartalyst\Sentry\Users\UserInterface
	 * @throws RuntimeException
	 * @throws \Cartalyst\Sentry\Users\UserNotFoundException
	 */
	public function findByResetPasswordCode($code);

	/**
	 * Returns an all users.
	 *
	 * @return array
	 */
	public function findAll();

	/**
	 * Returns all users who belong to
	 * a group.
	 *
	 * @param  \Cartalyst\Sentry\Groups\GroupInterface  $group
	 * @return array
	 */
	public function findAllInGroup(GroupInterface $group);

	/**
	 * Returns all users with access to
	 * a permission(s).
	 *
	 * @param  string|array  $permissions
	 * @return array
	 */
	public function findAllWithAccess($permissions);

	/**
	 * Returns all users with access to
	 * any given permission(s).
	 *
	 * @param  array  $permissions
	 * @return array
	 */
	public function findAllWithAnyAccess(array $permissions);

	/**
	 * Creates a user.
	 *
	 * @param  array  $credentials
	 * @return \Cartalyst\Sentry\Users\UserInterface
	 */
	public function create(array $credentials);

	/**
	 * Returns an empty user object.
	 *
	 * @return \Cartalyst\Sentry\Users\UserInterface
	 */
	public function getEmptyUser();

}
