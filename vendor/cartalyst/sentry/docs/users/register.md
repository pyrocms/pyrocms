## Register a User

Registering a user will require the user to be manually activated but you can
bypass this passing a boolean of `true` as a second parameter.

If the user already exists but is not activated, it will create a new activation code.

### Exceptions

---

**Cartalyst\Sentry\Users\LoginRequiredException**

When you don't provide the required `login` field, this exception will be thrown.

**Cartalyst\Sentry\Users\PasswordRequiredException**

When you don't provide the required `password` field, this exception will be thrown.

**Cartalyst\Sentry\Users\UserExistsException**

This exception will be thrown when the user you are trying to create already
exists on your database.

What this means is, if your `login` field is `email` and that email address is
already registerd on your database, you can't use this email for this user.

#### Example

	try
	{
		// Let's register a user.
		$user = Sentry::register(array(
			'email'    => 'john.doe@example.com',
			'password' => 'test',
		));

		// Let's get the activation code
		$activationCode = $user->getActivationCode();

		// Send activation code to the user so he can activate the account
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

> **Note**: Passing a boolean of `true` as the second parameter activates the user automatically.
