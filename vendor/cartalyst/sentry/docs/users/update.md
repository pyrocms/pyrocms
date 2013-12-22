## Update a User

Updating users information is very easy with Sentry, you just need to find the
user you want to update and update their information. You can add or remove
groups from users as well.

### Exceptions {#exceptions}

---

**Cartalyst\Sentry\Users\LoginRequiredException**

When you don't provide the required `login` field, this exception will be thrown.

**Cartalyst\Sentry\Users\UserExistsException**

This exception will be thrown when the user you are trying to create already
exists in your database.

What this means is, if your `login` field is `email` and that email address is
already registered in your database, you can't use this email for this user.

**Cartalyst\Sentry\Users\UserNotFoundException**

If the provided user was not found, this exception will be thrown.

#### Examples

##### Update the User details

	try
	{
		// Find the user using the user id
		$user = Sentry::findUserById(1);

		// Update the user details
		$user->email = 'john.doe@example.com';
		$user->first_name = 'John';

		// Update the user
		if ($user->save())
		{
			// User information was updated
		}
		else
		{
			// User information was not updated
		}
	}
	catch (Cartalyst\Sentry\Users\UserExistsException $e)
	{
		echo 'User with this login already exists.';
	}
	catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
	{
		echo 'User was not found.';
	}

In this example we are just updating the user information. If you provide another
email address, and that email address is already registered in your system, an
Exception `Cartalyst\Sentry\Users\UserExistsException` will be thrown.

##### Assign a new Group to a User

	try
	{
		// Find the user using the user id
		$user = Sentry::findUserById(1);

		// Find the group using the group id
		$adminGroup = Sentry::findGroupById(1);

		// Assign the group to the user
		if ($user->addGroup($adminGroup))
		{
			// Group assigned successfully
		}
		else
		{
			// Group was not assigned
		}
	}
	catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
	{
		echo 'User was not found.';
	}
	catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
	{
		echo 'Group was not found.';
	}

In this example we are assigning the provided Group to the provided User.

> **Note:** If the provided Group is not found an Exception `Cartalyst\Sentry\Groups\GroupNotFoundException`
will be thrown.

##### Remove a Group from the User

	try
	{
		// Find the user using the user id
		$user = Sentry::findUserById(1);

		// Find the group using the group id
		$adminGroup = Sentry::findGroupById(1);

		// Assign the group to the user
		if ($user->removeGroup($adminGroup))
		{
			// Group removed successfully
		}
		else
		{
			// Group was not removed
		}
	}
	catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
	{
		echo 'User was not found.';
	}
	catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
	{
		echo 'Group was not found.';
	}

In this example we are removing the provided Group from the provided User.

> **Note:** If the provided Group is not found an Exception `Cartalyst\Sentry\Groups\GroupNotFoundException`
will be thrown.

##### Update the User details and assign a new Group

	try
	{
		// Find the user using the user id
		$user = Sentry::findUserById(1);

		// Find the group using the group id
		$adminGroup = Sentry::findGroupById(1);

		// Assign the group to the user
		if ($user->addGroup($adminGroup))
		{
			// Group assigned successfully
		}
		else
		{
			// Group was not assigned
		}

		// Update the user details
		$user->email = 'john.doe@example.com';
		$user->first_name = 'John';

		// Update the user
		if ($user->save())
		{
			// User information was updated
		}
		else
		{
			// User information was not updated
		}
	}
	catch (Cartalyst\Sentry\Users\UserExistsException $e)
	{
		echo 'User with this login already exists.';
	}
	catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
	{
		echo 'User was not found.';
	}
	catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
	{
		echo 'Group was not found.';
	}

This is a combination of the previous examples, where we are updating the user
information and assigning a new Group the provided User.

> **Note:** If the provided Group is not found an Exception `Cartalyst\Sentry\Groups\GroupNotFoundException`
will be thrown.
