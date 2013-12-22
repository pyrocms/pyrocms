## User Throttling

### Exceptions

---

**Cartalyst\Sentry\Throttle\UserNotFoundException**

If the provided user was not found, this exception will be thrown.

**Cartalyst\Sentry\Throttling\UserSuspendedException**

When the provided user is suspended, this exception will be thrown.

**Cartalyst\Sentry\Users\UserBannedException**

When the provided user is banned, this exception will be thrown.

### Ban user(s) {#ban-users}

---

Bans the user associated with the throttle.

#### Example

	try
	{
		// Find the user using the user id
		$throttle = Sentry::findThrottlerByUserId(1);

		// Ban the user
		$throttle->ban();
	}
	catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
	{
		echo 'User was not found.';
	}

### Unban user(s) {#unban-users}

---

Unbans the user associated with the throttle.

#### Example

	try
	{
		// Find the user using the user id
		$throttle = Sentry::findThrottlerByUserId(1);

		// Unban the user
		$throttle->unBan();
	}
	catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
	{
		echo 'User was not found.';
	}

### Check if a User is Banned {#check-if-a-user-is-banned}

---

Checks to see if the user is banned.

#### Example

	try
	{
		$throttle = Sentry::findThrottlerByUserId(1);

		if($banned = $throttle->isBanned())
		{
			// User is Banned
		}
		else
		{
			// User is not Banned
		}
	}
	catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
	{
		echo 'User was not found.';
	}

### Suspend user(s) {#suspend-users}

---

Suspends a user temporarily. Length of the suspension is set by the driver or
setSuspensionTime($minutes).

#### Example

	try
	{
		// Find the user using the user id
		$throttle = Sentry::findThrottlerByUserId(1);

		// Suspend the user
		$throttle->suspend();
	}
	catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
	{
		echo 'User was not found.';
	}

### Unsuspend user(s) {#unsuspend-users}

---

Unsuspends a login. This also clears all previous attempts by the specified
login if they were suspended.

#### Example

	try
	{
		// Find the user using the user id
		$throttle = Sentry::findThrottlerByUserId(1);

		// Unsuspend the user
		$throttle->unsuspend();
	}
	catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
	{
		echo 'User was not found.';
	}

### Check if a User is Suspended {#check-if-a-user-is-suspended}

---

Checks to see if the user is suspended.

#### Example

	try
	{
		$throttle = Sentry::findThrottlerByUserId(1);

		if($suspended = $throttle->isSuspended())
		{
			// User is Suspended
		}
		else
		{
			// User is not Suspended
		}
	}
	catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
	{
		echo 'User was not found.';
	}

### Set the User Suspension Time {#set-the-user-suspension-time}

---

Sets the length of the suspension.

#### Example

	try
	{
		$throttle = Sentry::findThrottlerByUserId(1);

		$throttle->setSuspensionTime(10);
	}
	catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
	{
		echo 'User was not found.';
	}

### Get the User Suspension Time {#get-the-user-suspension-time}

---

Retrieves the length of the suspension time set by the throttling driver.

#### Example

	try
	{
		$throttle = Sentry::findThrottlerByUserId(1);

		$suspensionTime = $throttle->getSuspensionTime();
	}
	catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
	{
		echo 'User was not found.';
	}

### Add a Login Attempt {#add-a-login-attempt}

---

Adds an attempt to the throttle object.

#### Example

	try
	{
		$throttle = Sentry::findThrottlerByUserId(1);

		$throttle->addLoginAttempt();
	}
	catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
	{
		echo 'User was not found.';
	}

### Get Login Attempts {#get-login-attempts}

---

Retrieves the number of attempts a user currently has tried. Checks suspension
time to see if login attempts can be reset. This may happen if the suspension
time was (for example) 10 minutes however the last login was 15 minutes ago,
attempts will be reset to 0.

#### Example

	try
	{
		$throttle = Sentry::findThrottlerByUserId(1);

		$attempts = $throttle->getLoginAttempts();
	}
	catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
	{
		echo 'User was not found.';
	}

### Clear Login Attempts {#clear-login-attempts}

---

Clears all login attempts, it also unsuspends them. This does not unban a login.

#### Example

	try
	{
		$throttle = Sentry::findThrottlerByUserId(1);

		$throttle->clearLoginAttempts();
	}
	catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
	{
		echo 'User was not found.';
	}

### Check the User Throttle Status {#check-the-user-throttle-status}

---

Checks the login throttle status and throws a number of Exceptions upon failure.

#### Example

	try
	{
		$throttle = Sentry::findThrottlerByUserId(1);

		if ($throttle->check())
		{
			echo 'Good to go.';
		}
	}
	catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
	{
		echo 'User was not found.';
	}
	catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
	{
		$time = $throttle->getSuspensionTime();

		echo "User is suspended for [$time] minutes.";
	}
	catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
	{
		ehco 'User is banned.';
	}

### Set Attempt Limit {#set-attempt-limit}

---

Sets the number of attempts allowed before suspension.

#### Example

	try
	{
		$throttle = Sentry::findThrottlerByUserId(1);

		$throttle->setAttemptLimit(3);
	}
	catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
	{
		echo 'User was not found.';
	}

### Get Attempt Limit {#get-attempt-limit}

---

Retrieves the number of attempts allowed by the throttle object.

#### Example

	try
	{
		$throttle = Sentry::findThrottlerByUserId(1);

		$attemptLimit = $throttle->getAttemptLimit();
	}
	catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
	{
		echo 'User was not found.';
	}
