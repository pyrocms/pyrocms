#v2.0.0-beta7

 - User's activation codes and reset password codes are now URL friendly. We've had a number of issues regarding this.
 - `activation_hash`, `persist_hash` and `reset_password_hash` have now changed to `activation_code`, `persist_code` and `reset_password_code` to be consistent with the Sentry API. You will need to re-run migrations or adjust your tables accordingly. Migrations will not be altered after a stable release, however; new ones will be added.
 - Added `Sentry::getUserProvider()->findAllInGroup($group)`.
 - Tracking throttling by IP address to prevent a potential DoS attack.
 - Refactored dependencies & Facades to simplify initialization of Sentry.
 - Added an optional `Cartalyst\Sentry\Users\WrongPasswordException` to allow you to catch wrong passwords specifically when authenticating a user. This should be [used with knowledge and caution](https://github.com/cartalyst/sentry/issues/148).
 - Added an `activated_at` column to the `user` table, which will record the time which a user was activated.
 - Added a 'last_login' column to the `user` table.
 - Renaming configuration files to simplify configuration.
 - Added a `suspended_at` column to the `throttle` table.

#v2.0.0-beta6

 - Allow you to pass an array of permissions to `hasAccess()` to check the user has access to **all** of those permissions.
 - Added method to find all users through `Sentry::getUserProvider()->findAll()` and `entry::getUserProvider()->findAllWithAccess()`.
 - Added method to find all users with permissions, where permissions may be a single string or an array of permissions which the users must match all (driven by the changes to `hasAccess` listed above).
 - Made the hasher on the default user model a static property for performance and boilerplate code improvements.
 - Made the login attribute name static.
 - Made a configuration item to edit the login attribute.
 - Attempting to activate an already activated user will now throw a `UserAlreadyActivatedException`.
 - Wildcard permissions. `Sentry::hasAccess('users.*')` will match `users.edit`, `users.create` etc. It will check that at least one of the permissions represented by the wildcard exists. Good for overall blcoking of sections in your website.
 - "Match any permissions". Previously, `Sentry::hasAccess(array('foo', 'bar'))` would have checked for access to **both** `foo` and `bar`. Now, `Sentry::hasAnyAccess(array('foo', 'bar'))` will check for access to either `foo` or `bar`. Added `Sentry::getUserProvider()->findAllWithAnyAccess()`.

#v2.0.0-beta5

 - Renamed a whole bunch of interface methods to simplify them. For example, `GroupInterface::getGroupPermissions()` is now `GroupInterface::getPermissions()`. Eloquent changes have occured which have allowed a clean implementation of this.
 - Adding configuration to specify default hasher for Sentry out of "native", "bcrypt" or "sha256".
 - Some older versions of PHP 5.3 (< 5.3.7) are most likely to be incompatible with the Native Hasher. Added Exception and suggestions for when this occurs. See [here](https://github.com/ircmaxell/password_compat/issues/10) and [here](https://github.com/cartalyst/sentry/issues/98#issuecomment-12974603).

#v2.0.0-beta4

 - Fixing security issue with latest persist code changes.
 - Added new column to users table, `persist_hash` (schema identical to `reset_hash`) - need to re-run migrations or modify table manually.

#v2.0.0-beta3

 - Added configuration for Laravel 4 users.
 - Added native Facade to reduce boilerplate for users outside a framework.
 - Switching from full hashing to an MD5 hash when creating a login hash (persist code) - speed improvement.
 - Allow you to override User / Group / Throttle models at runtime - `Sentry::getGroupProvider()->setModel('MyCustomModel')`.
 - User methods `addGroup()` and `removeGroup()` now return a boolean.

#v2.0.0-beta2

 - Validate that the login and password attributes are provided when authenticating and throwing dedicated exceptions for these errors.
 - `UserInterface::checkResetPassword()` renamed to `UserInterface::checkResetPasswordCode()`.
 - Adding method to return all groups - `GroupProvider::findAll()`.
 - No longer storing serialized user object in cookie / session, creating a hash based on some of the user's attributes.
 - Switch to native PHP5.5+ hasher (with forwards compatibility for PHP 5.3+) for hashing as to reduce issues moving forward
