## Reset a User Password

In this section you will learn how easy it is to reset a user password with Sentry 2.

### Exceptions {#exceptions}

---

**Cartalyst\Sentry\Users\UserNotFoundException**

If the provided user was not found, this exception will be thrown.

### Step 1

---

The first step is to get a password reset code, to do this we use the
`getResetPasswordCode()` method.

#### Example

	try
	{
		// Find the user using the user email address
		$user = Sentry::findUserByLogin('john.doe@example.com');

		// Get the password reset code
		$resetCode = $user->getResetPasswordCode();

		// Now you can send this code to your user via email for example.
	}
	catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
	{
		echo 'User was not found.';
	}

### Step 2

---

After your user received the password reset code you need to provide a way
for them to validate that code, and reset their password.

All the logic part on how you pass the reset password code is all up to you.

#### Example

	try
	{
		// Find the user using the user id
		$user = Sentry::findUserById(1);

		// Check if the reset password code is valid
		if ($user->checkResetPasswordCode('8f1Z7wA4uVt7VemBpGSfaoI9mcjdEwtK8elCnQOb'))
		{
			// Attempt to reset the user password
			if ($user->attemptResetPassword('8f1Z7wA4uVt7VemBpGSfaoI9mcjdEwtK8elCnQOb', 'new_password'))
			{
				// Password reset passed
			}
			else
			{
				// Password reset failed
			}
		}
		else
		{
			// The provided password reset code is Invalid
		}
	}
	catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
	{
		echo 'User was not found.';
	}

