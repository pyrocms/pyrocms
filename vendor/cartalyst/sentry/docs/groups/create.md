## Create a new Group

Creating new Groups is very easy and in this section you will learn how to
create one.

### Exceptions

---

**Cartalyst\Sentry\Groups\NameRequiredException**

If you don't provide the group name, this exception will be thrown.

**Cartalyst\Sentry\Groups\GroupExistsException**

This exception will be thrown when the group you are trying to create already
exists on your database.

#### Example

	try
	{
		// Create the group
		$group = Sentry::createGroup(array(
			'name'        => 'Users',
			'permissions' => array(
				'admin' => 1,
				'users' => 1,
			),
		));
	}
	catch (Cartalyst\Sentry\Groups\NameRequiredException $e)
	{
		echo 'Name field is required';
	}
	catch (Cartalyst\Sentry\Groups\GroupExistsException $e)
	{
		echo 'Group already exists';
	}
