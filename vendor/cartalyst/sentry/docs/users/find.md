## Finding Users

Finding users can sometimes be difficult and harsh, well, Sentry provides you
simple methods to find your users.

### Exceptions {#exceptions}

---

**Cartalyst\Sentry\Users\UserNotFoundException**

If the provided user was not found, this exception will be thrown.

### Get the Current Logged in User {#get-the-current-logged-in-user}

---

Returns the user that's set with Sentry, does not check if a user is logged in
or not. To do that, use [`check()`]({url}/authentication/helpers#check-if-the-user-is-logged-in) instead.

#### Example

	try
	{
		// Get the current active/logged in user
		$user = Sentry::getUser();
	}
	catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
	{
		// User wasn't found, should only happen if the user was deleted
		// when they were already logged in or had a "remember me" cookie set
		// and they were deleted.
	}

### Find all the Users {#find-all-the-users}

---

This will return all the users.

#### Example

	$users = Sentry::findAllUsers();

### Find all the Users with access to a permissions(s) {#find-all-the-users-with-access-to-a-permissions}

---

Finds all users with access to a permission(s).

#### Example

	// Feel free to pass a string for just one permission instead
	$users = Sentry::findAllUsersWithAccess(array('admin', 'other'));

### Find all the Users in a Group {#find-all-the-users-in-a-group}

---

Finds all users assigned to a group.

#### Example

	$group = Sentry::findGroupByName('admin');

	$users = Sentry::findAllUsersInGroup($group);

### Find a User by their Credentials {#find-a-user-by-their-credentials}

---

Find a user by an array of credentials, which must include the login column. Hashed fields will be hashed and checked against their value in the database.

#### Example

	try
	{
		$user = Sentry::findUserByCredentials(array(
			'email'      => 'john.doe@example.com',
			'password'   => 'test',
			'first_name' => 'John',
		));
	}
	catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
	{
		echo 'User was not found.';
	}

### Find a User by their Id {#find-a-user-by-their-id}

---

Find a user by their ID.

#### Example

	try
	{
		$user = Sentry::findUserById(1);
	}
	catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
	{
		echo 'User was not found.';
	}

### Find a User by their Login Id {#find-a-user-by-their-login-id}

---

Find a user by their login ID.

#### Example

	try
	{
		$user = Sentry::findUserByLogin('john.doe@example.com');
	}
	catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
	{
		echo 'User was not found.';
	}

### Find a User by their Activation Code {#find-a-user-by-their-activation-code}

---

Find a user by their registration activation code.

#### Example

	try
	{
		$user = Sentry::findUserByActivationCode('8f1Z7wA4uVt7VemBpGSfaoI9mcjdEwtK8elCnQOb');
	}
	catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
	{
		echo 'User was not found.';
	}

### Find a User by their Reset Password Code {#find-a-user-by-their-reset-password-code}

---

Find a user by their reset password code.

#### Example

	try
	{
		$user = Sentry::findUserByResetPasswordCode('8f1Z7wA4uVt7VemBpGSfaoI9mcjdEwtK8elCnQOb');
	}
	catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
	{
		echo 'User was not found.';
	}
