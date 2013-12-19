## Delete a user

Deleting users is very simple and easy.

### Exceptions {#exceptions}

---

**Cartalyst\Sentry\Users\UserNotFoundException**

If the provided user was not found, this exception will be thrown.

#### Example

	try
	{
		// Find the user using the user id
		$user = Sentry::findUserById(1);

		// Delete the user
		$user->delete();
	}
	catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
	{
		echo 'User was not found.';
	}
