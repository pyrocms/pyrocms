## Download

You have two options to download Sentry 2:

* Download with [Composer](http://getcomposer.org)
* Download from GitHub
	* Download the `.zip` file
	* Clone the repository

### Composer

---

To install through composer, simply put the following in your `composer.json` file:

	{
		"require": {
			"cartalyst/sentry": "2.0.*"
		},
		"minimum-stability": "dev"
	}

The `minimum-stability` flag is only required while Sentry 2 is in alpha stage.
When it becomes stable you may change your flag.


### GitHub

---

##### Download Sentry

Download Sentry into the 'vendor/cartalyst' folder (or wherever you see fit for
your application). You can download the latest version of Sentry via zip
[here](https://github.com/cartalyst/sentry/zipball/master) or pull directly from
 the repository with the following command within the 'vendor/cartalyst' directory.

##### Clone Sentry

    $ git clone -b master git@github.com:cartalyst/sentry.git

If you manually access from GitHub, you will need to handle autoloading logic
yourself. You will need to do the following:

1. Use PSR 0 to load the `Cartalyst\Sentry` namespace to `path/to/sentry/src`
2. Manually map or include the following files:
   1. `path/to/sentry/src/Cartalyst/Sentry/Groups/Exceptions.php`
   2. `path/to/sentry/src/Cartalyst/Sentry/Users/Exceptions.php`
   3. `path/to/sentry/src/Cartalyst/Sentry/Throttling/Exceptions.php`
