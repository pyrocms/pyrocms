<?php namespace Cartalyst\Sentry\Groups;
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

interface ProviderInterface {

	/**
	 * Find the group by ID.
	 *
	 * @param  int  $id
	 * @return \Cartalyst\Sentry\Groups\GroupInterface  $group
	 * @throws \Cartalyst\Sentry\Groups\GroupNotFoundException
	 */
	public function findById($id);

	/**
	 * Find the group by name.
	 *
	 * @param  string  $name
	 * @return \Cartalyst\Sentry\Groups\GroupInterface  $group
	 * @throws \Cartalyst\Sentry\Groups\GroupNotFoundException
	 */
	public function findByName($name);

	/**
	 * Returns all groups.
	 *
	 * @return array  $groups
	 */
	public function findAll();

	/**
	 * Creates a group.
	 *
	 * @param  array  $attributes
	 * @return \Cartalyst\Sentry\Groups\GroupInterface
	 */
	public function create(array $attributes);

}
