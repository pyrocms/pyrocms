### Notable Changes

Sentry 2 is a full rewrite of the Sentry library. A new API, new methods, with
some database changes (no more user metadata table) and the use of Eloquent for
our models.

With this rewrite we felt we should note some key changes that may cause issues
if you are porting from the original Sentry library.

----------

### Dependency Injection / Interfaces / PSR

We made Sentry2 to be PSR-0, PSR-1 and (mostly) PSR-2 compatible and take
advantage of Dependency Injection. We feel this will allow more people to use
Sentry to fit their needs. Because we have opted to use Dependency Injection,
we have provided several interfaces to keep the Sentry API as consistent as
possible for your application. We hope this serves you well and allows you to
easily switch out classes for your own needs without having to modify your
application in the future.

----------

### Exceptions

Since we are making Sentry 2 composer-based and framework agnostic, we wanted to
limit dependencies were we could. As a result, we made more descriptive
Exceptions which should allow you to catch and make your own error messages for
them. There is no longer a `SentryException` catch all.

----------

### Sentry::login() and Sentry::force_login()

`Sentry::login()` used to take 2 required parameters, login and password, and
authenticate the user against them. `Sentry::login()` is now used as a login for
both authentication and force login, used by passing a UserInterface object.

A new `Sentry::authenticate()` method has been introduced for authentication
purposes and should replace your `Sentry::login()` methods. This method passes
an array which requires just the login (email) field by default to authenticate
against. You may also choose any number of fields you may also want to validate
against, such as password, first name, or any other field you may add to your
users table. We always recommend using a password, but you may have your own
ideas for which you want to authenticate against instead.

----------

### Sentry::user()

`Sentry::user()` used to return the active user, if they existed, or the user
requested by passing in an optional parameter of their id or login field. To get
the active user, you now use `Sentry::getUser()` . This will check if their is
an active user and return their object, otherwise it will return null.

To find specific users, you can retrieve a `User Provider` by calling
`Sentry::getUserProvider()` and taking advantage of 3 new methods, `findById()`,
 `findByLogin()` and `findByCredentials()` .

----------

### Objects over Arrays

By high demand, we now use objects over arrays for pretty much everything in
Sentry 2.

----------

### User Metadata

We used to have a separate table and array key for user metadata. This table has
 been completely removed, along with the metadata key. If you wish to have user
 metadata, simply add the columns onto the current users table.

----------

### Password Reset

Many people were initially confused as to why we would prompt for a password
during the initial password reset request. In Sentry 2 we have decided to go
back to the more 'normal' approach and ask for the new password after receiving
the confirmation code.

----------

### Password Hashing

Sentry2 now uses BCrypt by default as it's password hashing algorithm. We still
have a SHA-256 Hashing driver included in the library you can easily switch to
if you wish to still use our old hashing algorithm.

----------

### Sentry::group()

`Sentry::group()` changes pretty much reflect the `Sentry::user()` changes.
This method no longer takes any parameters and returns an empty `Group Provider`
Object. You can find specific groups by using the `findById()` and `findByName()`
methods.

----------

### Session/Cookie

We used to only store the current user's ID in the session, we now store the
`UserInterface` object.

----------

### Throttling

Throttling has had some minor changes, but all in all works pretty much the
same. One new key feature is we now allow banning of users.
