## Update a Group

In this section you will learn how easy it is to update a Group.

### Exceptions

---

**Cartalyst\Sentry\Groups\NameRequiredException**

If you don't provide the group name, this exception will be thrown.

**Cartalyst\Sentry\Groups\GroupExistsException**

This exception will be thrown when the group you are trying to create already
exists on your database.

**Cartalyst\Sentry\Groups\GroupNotFoundException**

If the provided group was not found, this exception will be thrown.

#### Example

	try
	{
		// Find the group using the group id
		$group = Sentry::findGroupById(1);

		// Update the group details
		$group->name = 'Users';
		$group->permissions = array(
			'admin' => 1,
			'users' => 1,
		);

		// Update the group
		if ($group->save())
		{
			// Group information was updated
		}
		else
		{
			// Group information was not updated
		}
	}
	catch (Cartalyst\Sentry\Groups\GroupExistsException $e)
	{
		echo 'Group already exists.';
	}
	catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
	{
		echo 'Group was not found.';
	}
