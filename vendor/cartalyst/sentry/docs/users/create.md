## Create a new User

In this section you will learn how to create a user and assign him a group.

To create a new user you need to pass an `array()` of user fields into the
`create()` method, please note, that the `login` field and the password are
required, all the other fields are optional.

When you are creating your user, and something goes wrong, you most likely want
to know where is the problem, well, Sentry got you covered, and if a problem
arises, individual [Exceptions]({url}/users/create#exceptions) are thrown, one for each error you have.

### Exceptions {#exceptions}

---

**Cartalyst\Sentry\Users\LoginRequiredException**

When you don't provide the required `login` field, this exception will be thrown.

**Cartalyst\Sentry\Users\PasswordRequiredException**

When you don't provide the `password` field, this exception will be thrown.

**Cartalyst\Sentry\Users\UserExistsException**

This exception will be thrown when the user you are trying to create already
exists on your database.

What this means is, if your `login` field is `email` and that email address is
already registerd on your database, you can't use this email for this user.

#### Examples

##### Create a User and assign him an existing Group

	try
	{
		// Create the user
		$user = Sentry::createUser(array(
			'email'     => 'john.doe@example.com',
			'password'  => 'test',
			'activated' => true,
		));

		// Find the group using the group id
		$adminGroup = Sentry::findGroupById(1);

		// Assign the group to the user
		$user->addGroup($adminGroup);
	}
	catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
	{
		echo 'Login field is required.';
	}
	catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
	{
		echo 'Password field is required.';
	}
	catch (Cartalyst\Sentry\Users\UserExistsException $e)
	{
		echo 'User with this login already exists.';
	}
	catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
	{
		echo 'Group was not found.';
	}

In this example we are creating a new user and assigning him with a group.

As you can see there is an extra Exception `Cartalyst\Sentry\Groups\GroupNotFoundException`,
that is not referenced on the list above, this is because, we are fetching the
group that we want to assign, and if that group does not exist, this Exception
will be thrown.

##### Create an user and Grant Permissions

	try
	{
		// Create the user
		$user = Sentry::createUser(array(
			'email'       => 'john.doe@example.com',
			'password'    => 'test',
			'activated'   => true,
			'permissions' => array(
				'user.create' => -1,
				'user.delete' => -1,
				'user.view'   => 1,
				'user.update' => 1,
			),
		));
	}
	catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
	{
		echo 'Login field is required.';
	}
	catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
	{
		echo 'Password field is required.'
	}
	catch (Cartalyst\Sentry\Users\UserExistsException $e)
	{
		echo 'User with login already exists.';
	}

This example does pretty much the same as the previous one with the exception
that we are not assigning him any group, but we are granting this user some
permissions.
