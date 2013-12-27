## Logs a User In

Logs in the provided user and sets properties in the session.

If the login is successful, password reset fields and any invalid
authentication attempts will be cleared.

### Exceptions {#exceptions}

---

**Cartalyst\Sentry\Users\LoginRequiredException**

When you don't provide the required `login` field, this exception will be thrown.

**Cartalyst\Sentry\Users\UserNotFoundException**

If the provided user was not found, this exception will be thrown.

**Cartalyst\Sentry\Users\UserNotActivatedException**

When the provided user is not activated, this exception will be thrown.

**Cartalyst\Sentry\Throttling\UserSuspendedException**

When the provided user is suspended, this exception will be thrown.

**Cartalyst\Sentry\Throttling\UserBannedException**

When the provided user is banned, this exception will be thrown.

#### Example

	try
	{
		// Find the user using the user id
		$user = Sentry::findUserById(1);

		// Log the user in
		Sentry::login($user, false);
	}
	catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
	{
		echo 'Login field is required.';
	}
	catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
	{
		echo 'User not activated.';
	}
	catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
	{
		echo 'User not found.';
	}

	// Following is only needed if throttle is enabled
	catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
	{
		$time = $throttle->getSuspensionTime();

		echo "User is suspended for [$time] minutes.";
	}
	catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
	{
		echo 'User is banned.';
	}

### Login and Remember {#login-and-remember}

---

Logs in and Remembers a user based on credentials. This is an helper
function for the `login()` which sets the `$remember` flag to true so
the user is remembered (using a cookie). This is the "remember me" you are
used to see on web sites.

#### Example

	Sentry::loginAndRemember($user);
