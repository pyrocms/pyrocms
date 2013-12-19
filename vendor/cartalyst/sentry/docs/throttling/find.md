## Find User(s)

### Exceptions

---

**Cartalyst\Sentry\Users\UserNotFoundException**

If the provided user was not found, this exception will be thrown.

### Find a User by their Id {#find-a-user-by-their-id}

---

Retrieves a throttle object based on the user ID provided. Will always retrieve
a throttle object.

#### Example

	try
	{
		$throttle = Sentry::findThrottlerByUserId(1);
	}
	catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
	{
		echo 'User was not found.';
	}

### Find a User by their Login {#find-a-user-by-their-login}

---

Retrieves a throttle object based on the user login provided. Will always
retrieve a throttle object.

#### Example

	try
	{
		$throttle = Sentry::findThrottlerByUserLogin('john.doe@example.com');
	}
	catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
	{
		echo 'User was not found.';
	}
