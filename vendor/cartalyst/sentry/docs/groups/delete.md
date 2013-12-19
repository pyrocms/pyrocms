## Delete a Group

Deleting groups is very simple and easy.

### Exceptions

---

**Cartalyst\Sentry\Groups\GroupNotFoundException**

If the provided group was not found, this exception will be thrown.

#### Example

	try
	{
		// Find the group using the group id
		$group = Sentry::findGroupById(1);

		// Delete the group
		$group->delete();
	}
	catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
	{
		echo 'Group was not found.';
	}
