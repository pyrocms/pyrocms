## Authenticate

Authenticates a user based on the provided credentials.

If the authentication is successful, password reset fields and any invalid
authentication attempts will be cleared.

### Exceptions {#exceptions}

---

**Cartalyst\Sentry\Users\LoginRequiredException**

When you don't provide the required `login` field, this exception will be thrown.

**Cartalyst\Sentry\Users\PasswordRequiredException**

When you don't provide the `password` field, this exception will be thrown.

**Cartalyst\Sentry\Users\UserNotActivatedException**

When the provided user is not activated, this exception will be thrown.

**Cartalyst\Sentry\Users\UserNotFoundException**

If the provided user was not found, this exception will be thrown.

**Cartalyst\Sentry\Users\WrongPasswordException**

When the provided password is incorrect, this exception will be thrown.

**Cartalyst\Sentry\Throttling\UserSuspendedException**

When the provided user is suspended, this exception will be thrown.

**Cartalyst\Sentry\Throttling\UserBannedException**

When the provided user is banned, this exception will be thrown.

#### Example

	try
	{
		// Set login credentials
		$credentials = array(
			'email'    => 'john.doe@example.com',
			'password' => 'test',
		);

		// Try to authenticate the user
		$user = Sentry::authenticate($credentials, false);
	}
	catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
	{
		echo 'Login field is required.';
	}
	catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
	{
		echo 'Password field is required.';
	}
	catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
	{
		echo 'Wrong password, try again.';
	}
	catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
	{
		echo 'User was not found.';
	}
	catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
	{
		echo 'User is not activated.';
	}

	// The following is only required if throttle is enabled
	catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
	{
		echo 'User is suspended.';
	}
	catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
	{
		echo 'User is banned.';
	}


### Authenticate and Remember {#authenticate-and-remember}

---

Authenticates and Remembers a user based on credentials. This is an helper
function for the `authenticate()` which sets the `$remember` flag to true so
the user is remembered (using a cookie). This is the "remember me" you are
used to see on web sites.

#### Example

	Sentry::authenticateAndRemember($credentials);
