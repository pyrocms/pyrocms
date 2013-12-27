## Helpers

### Check if the User is Logged In {#check-if-the-user-is-logged-in}

---

The check method returns a `bool` of whether the user is logged in or not, or
if the user is not activated.

If it's logged in, the current User is set in Sentry so you can easily access
it via [`getUser()`]({url}/users/find#get-the-current-logged-in-user).

A user must be activated to pass `check()`.

#### Example

	if ( ! Sentry::check())
	{
		// User is not logged in, or is not activated
	}
	else
	{
		// User is logged in
	}
