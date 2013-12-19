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

use Cartalyst\Sentry\Groups\NameRequiredException;
use Cartalyst\Sentry\Groups\GroupExistsException;
use Cartalyst\Sentry\Groups\GroupInterface;

class Group extends \ORM implements GroupInterface {

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $_table_name = 'groups';

	/**
	 * This model belongs to a user
	 * @var array
	 */
	protected $_belongs_to = array('user' => array('model' => 'User'));

	/**
	 * auto-set the updated_at column
	 * @var array
	 */
	protected $_updated_column = array('column' => 'updated_at', 'format' => 'Y-m-d H:i:s');

	/**
	 * Auto-set the created_at column
	 * @var array
	 */
	protected $_created_column = array('column' => 'created_at', 'format' => 'Y-m-d H:i:s');

	/**
	 * @var array Make sure permissions are serialized when storing them
	 */
	protected $_serialize_columns = array('permissions');

	/*
	 * Support Kohana's validation
	 */
	public function rules()
	{
		return array (
			'name' => array (
				array ('not_empty'),
				array (array($this, 'unique_key_exists'), array (':value', 'name'))
			)
		);
	}
	/**
	 * Allowed permissions values.
	 *
	 * Possible options:
	 *    0 => Remove.
	 *    1 => Add.
	 *
	 * @var array
	 */
	protected $allowedPermissionsValues = array(0, 1);

	/**
	 * Returns the group's ID.
	 *
	 * @return mixed
	 */
	public function getId()
	{
		return $this->pk();
	}

	/**
	 * Returns the group's name.
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Returns permissions for the group.
	 *
	 * @return array
	 */
	public function getPermissions()
	{
		return $this->permissions;
	}

	/**
	 * See if a group has access to the passed permission(s).
	 *
	 * If multiple permissions are passed, the group must
	 * have access to all permissions passed through, unless the
	 * "all" flag is set to false.
	 *
	 * @param  string|array  $permissions
	 * @param  bool  $all
	 * @return bool
	 */
	public function hasAccess($permissions, $all = true)
	{
		$groupPermissions = $this->getPermissions();

		if ( ! is_array($permissions) )
		{
			$permissions = (array) $permissions;
		}

		foreach ($permissions as $permission)
		{
			// We will set a flag now for whether this permission was
			// matched at all.
			$matched = true;

			// Now, let's check if the permission ends in a wildcard "*" symbol.
			// If it does, we'll check through all the merged permissions to see
			// if a permission exists which matches the wildcard.
			if ((strlen($permission) > 1) and \Text::ends_with($permission, '*'))
			{
				$matched = false;

				foreach ($groupPermissions as $groupPermission => $value)
				{
					// Strip the '*' off the end of the permission.
					$checkPermission = substr($permission, 0, -1);

					// We will make sure that the merged permission does not
					// exactly match our permission, but starts with it.
					if ($checkPermission != $groupPermission and \Text::starts_with($groupPermission, $checkPermission) and $value == 1)
					{
						$matched = true;
						break;
					}
				}
			}

			// Now, let's check if the permission starts in a wildcard "*" symbol.
			// If it does, we'll check through all the merged permissions to see
			// if a permission exists which matches the wildcard.
			elseif ((strlen($permission) > 1) and \Text::starts_with($permission, '*'))
			{
				$matched = false;

				foreach ($groupPermissions as $groupPermission => $value)
				{
					// Strip the '*' off the start of the permission.
					$checkPermission = substr($permission, 1);

					// We will make sure that the merged permission does not
					// exactly match our permission, but ends with it.
					if ($checkPermission != $groupPermission and \Text::ends_with($groupPermission, $checkPermission) and $value == 1)
					{
						$matched = true;
						break;
					}
				}
			}

			else
			{
				$matched = false;

				foreach ($groupPermissions as $groupPermission => $value)
				{
					// This time check if the groupPermission ends in wildcard "*" symbol.
					if ((strlen($groupPermission) > 1) and \Text::ends_with($groupPermission, '*'))
					{
						$matched = false;

						// Strip the '*' off the end of the permission.
						$checkGroupPermission = substr($groupPermission, 0, -1);

						// We will make sure that the merged permission does not
						// exactly match our permission, but starts with it.
						if ($checkGroupPermission != $permission and \Text::starts_with($permission, $checkGroupPermission) and $value == 1)
						{
							$matched = true;
							break;
						}
					}

					// Otherwise, we'll fallback to standard permissions checking where
					// we match that permissions explicitly exist.
					elseif ($permission == $groupPermission and $groupPermissions[$permission] == 1)
					{
						$matched = true;
						break;
					}
				}
			}

			// Now, we will check if we have to match all
			// permissions or any permission and return
			// accordingly.
			if ($all === true and $matched === false)
			{
				return false;
			}
			elseif ($all === false and $matched === true)
			{
				return true;
			}
		}

		if ($all === false)
		{
			return false;
		}

		return true;
	}

	/**
	 * Returns if the user has access to any of the
	 * given permissions.
	 *
	 * @param  array  $permissions
	 * @return bool
	 */
	public function hasAnyAccess(array $permissions)
	{
		return $this->hasAccess($permissions, false);
	}

	/**
	 * Delete the group.
	 *
	 * @return bool
	 */
	public function delete()
	{
		\DB::delete('users_groups')
			->where('group_id', '=', $this->pk())
			->execute($this->_db);

		return parent::delete();
	}

	/**
	 * Mutator for giving permissions.
	 *
	 * @param  mixed  $permissions
	 * @return array  $_permissions
	 * @throws \InvalidArgumentException
	 */
	public function getPermissionsAttribute($permissions)
	{
		if ( ! $permissions)
		{
			return array();
		}

		if (is_array($permissions))
		{
			return $permissions;
		}

		if ( ! $_permissions = json_decode($permissions, true))
		{
			throw new \InvalidArgumentException("Cannot JSON decode permissions [$permissions].");
		}

		return $_permissions;
	}

	/**
	 * Mutator for taking permissions.
	 *
	 * @param  array  $permissions
	 * @return void
	 * @throws \InvalidArgumentException
	 */
	public function setPermissionsAttribute(array $permissions)
	{
		// Merge permissions
		$permissions = array_merge($this->getPermissions(), $permissions);

		// Loop through and adjsut permissions as needed
		foreach ($permissions as $permission => &$value)
		{
			// Lets make sure their is a valid permission value
			if ( ! in_array($value = (int) $value, $this->allowedPermissionsValues))
			{
				throw new \InvalidArgumentException("Invalid value [$value] for permission [$permission] given.");
			}

			// If the value is 0, delete it
			if ($value === 0)
			{
				unset($permissions[$permission]);
			}
		}

		$this->attributes['permissions'] = ( ! empty($permissions)) ? $permissions : '';
	}

	/**
	 * Validates the group and throws a number of
	 * Exceptions if validation fails.
	 *
	 *
	 * @return bool
	 * @throws \Cartalyst\Sentry\Groups\NameRequiredException
	 * @throws \Cartalyst\Sentry\Groups\GroupExistsException
	 */
	public function validate()
	{
		// Check if name field was passed
		$name = $this->name;

		if ( empty($name) )
		{
			throw new NameRequiredException("A name is required for a group, none given.");
		}

		// Check if group already exists
		$persistedGroup = $this->unique_key_exists($name, 'name');

		if (! $persistedGroup)
		{
			throw new GroupExistsException("A group already exists with name [$name], names must be unique for groups.");
		}

		return true;
	}

	/**
	 * Tests if a unique key value exists in the database.
	 *
	 * @param   mixed  $value  the value to test
	 * @param   string $field  field name
	 * @return  boolean
	 */
	public function unique_key_exists($value, $field)
	{
		$total = \DB::select(array(\DB::expr('COUNT(*)'), 'total_count'))
			->from($this->_table_name)
			->where($field, '=', $value)
			->where($this->_primary_key, '!=', $this->pk())
			->execute()
			->get('total_count');

		return ($total == 0);
	}
}
