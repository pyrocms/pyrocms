<?php namespace Cartalyst\Sentry\Groups\Kohana;
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
use Cartalyst\Sentry\Groups\GroupNotFoundException;
use Cartalyst\Sentry\Groups\ProviderInterface;

class Provider implements ProviderInterface {

	/**
	 * The Eloquent group model.
	 *
	 * @var string
	 */
	protected $model = 'Group';

	/**
	 * Create a new Eloquent Group provider.
	 *
	 * @param  string  $model
	 * @return void
	 */
	public function __construct($model = null)
	{
		if (isset($model))
		{
			$this->model = $model;
		}
	}

	/**
	 * Find the group by ID.
	 *
	 * @param  int  $id
	 * @return \Cartalyst\Sentry\Groups\GroupInterface  $group
	 * @throws \Cartalyst\Sentry\Groups\GroupNotFoundException
	 */
	public function findById($id)
	{
		$model = $this->createModel();

		$group = $model->where('id', '=', $id)->find();

		if ( ! $group->loaded() )
		{
			throw new GroupNotFoundException("A group could not be found with ID [$id].");
		}

		return $group;
	}

	/**
	 * Find the group by name.
	 *
	 * @param  string  $name
	 * @return \Cartalyst\Sentry\Groups\GroupInterface  $group
	 * @throws \Cartalyst\Sentry\Groups\GroupNotFoundException
	 */
	public function findByName($name)
	{
		$model = $this->createModel();

		$group = $model->where('name', '=', $name)->find();

		if ( ! $group->loaded() )
		{
			throw new GroupNotFoundException("A group could not be found with the name [$name].");
		}

		return $group;
	}

	/**
	 * Returns all groups.
	 *
	 * @return array  $groups
	 */
	public function findAll()
	{
		$model = $this->createModel();

		return $model->find_all();
	}

	/**
	 * Creates a group.
	 *
	 * @param  array  $attributes
	 * @return \Cartalyst\Sentry\Groups\GroupInterface
	 */
	public function create(array $attributes)
	{
		if ( ! isset($credentials['permissions']) )
		{
			$credentials['permissions'] = array();
		}

		$group = $this->createModel();
		$group->values($attributes, array('name', 'permissions'));
		$group->save();

		return $group;
	}

	/**
	 * Create a new instance of the model.
	 *
	 * @return \ORM
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
	}

}
