## Activating a User

User activation is very easy with Sentry, you need to first find the user you
want to activate, then use the `attemptActivation()` method and provide the
activation code, if the activation passes it will return `true` otherwise, it
will return `false` .

If the user you are trying to activate, is already activated, an Exception
`Cartalyst\Sentry\Users\UserAlreadyActivatedException` will be thrown.

### Exceptions {#exceptions}

---

**Cartalyst\Sentry\Users\UserAlreadyActivatedException**

If the provided user is already activated, this exception will be thrown.

**Cartalyst\Sentry\Users\UserNotFoundException**

If the provided user was not found, this exception will be thrown.

#### Example

	try
	{
		// Find the user using the user id
		$user = Sentry::findUserById(1);

		// Attempt to activate the user
		if ($user->attemptActivation('8f1Z7wA4uVt7VemBpGSfaoI9mcjdEwtK8elCnQOb'))
		{
			// User activation passed
		}
		else
		{
			// User activation failed
		}
	}
	catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
	{
		echo 'User was not found.';
	}
	catch (Cartalyst\Sentry\Users\UserAlreadyActivatedException $e)
	{
		echo 'User is already activated.';
	}
