## Helpers

### getPermissions() {#getpermissions}

---

Returns the permissions of a group.

#### Example

	try
	{
		// Find the group using the group id
		$group = Sentry::findGroupById(1);

		// Get the group permissions
		$groupPermissions = $group->getPermissions();
	}
	catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
	{
		echo 'Group does not exist.';
	}
