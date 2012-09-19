# CodeIgniter Unit Tests #

Status : [![Build Status](https://secure.travis-ci.org/EllisLab/CodeIgniter.png?branch=develop)](http://travis-ci.org/EllisLab/CodeIgniter)

### Introduction:

This is the preliminary CodeIgniter testing documentation. It
will cover both internal as well as external APIs and the reasoning
behind their implemenation, where appropriate. As with all CodeIgniter
documentation, this file should maintain a mostly human readable
format to facilitate clean api design. [see http://arrenbrecht.ch/testing/]

*First public draft: everything is subject to change*

### Requirements

PHP Unit >= 3.5.6

	pear channel-discover pear.phpunit.de
	pear install phpunit/PHPUnit

vfsStream

	pear channel-discover pear.bovigo.org
	pear install bovigo/vfsStream-beta

#### Installation of PEAR and PHPUnit on Ubuntu

  Installation on Ubuntu requires a few steps. Depending on your setup you may
  need to use 'sudo' to install these. Mileage may vary but these steps are a
  good start.

	# Install the PEAR package
	sudo apt-get install php-pear

	# Add a few sources to PEAR
	pear channel-discover pear.phpunit.de
	pear channel-discover pear.symfony-project.com
	pear channel-discover components.ez.no
	pear channel-discover pear.bovigo.org

	# Finally install PHPUnit and vfsStream (including dependencies)
	pear install --alldeps phpunit/PHPUnit
	pear install --alldeps bovigo/vfsStream-beta

	# Finally, run 'phpunit' from within the ./tests directory
	# and you should be on your way!

## Test Suites:

CodeIgniter bootstraps a request very directly, with very flat class
hierarchy. As a result, there is no main CodeIgniter class until the
controller is instantiated.

This has forced the core classes to be relatively decoupled, which is
a good thing. However, it makes that portion of code relatively hard
to test.

Right now that means we'll probably have two core test suites, along
with a base for application and package tests. That gives us:

1. Bootstrap Test	- test common.php and sanity check codeigniter.php [in planning]
2. System Test		- test core components in relative isolation [in development]
3. Application Test	- bootstrapping for application/tests [not started]
4. Package Test		- bootstrapping for <package>/tests [not started]

### CI_TestCase Documentation

Test cases should extend CI_TestCase. This internally extends
PHPUnit\_Framework\_TestCase, so you have access to all of your
usual PHPUnit methods.

We need to provide a simple way to modify the globals and the
common function output. We also need to be able to mock up
the super object as we please.

Current API is *not stable*. Names and implementations will change.

    $this->ci_set_config($key, $val)

Set the global config variables. If key is an array, it will
replace the entire config array. They are _not_ merged.

    $this->ci_instance($obj)

Set the object to use as the "super object", in a lot
of cases this will be a simple stdClass with the attributes
you need it to have. If no parameter, will return the instance.

	$this->ci_instance_var($name, $val)

Add an attribute to the super object. This is useful if you
set up a simple instance in setUp and then need to add different
class mockups to your super object.

	$this->ci_core_class($name)

Get the _class name_ of a core class, so that you can instantiate
it. The variable is returned by reference and is tied to the correct
$GLOBALS key. For example:
    
	$cfg =& $this->ci_core_class('cfg'); // returns 'CI_Config'
    $cfg = new $cfg; // instantiates config and overwrites the CFG global

	$this->ci_set_core_class($name, $obj)
	
An alternative way to set one of the core globals.

	$this->ci_get_config()  __internal__
	
Returns the global config array. Internal as you shouldn't need to
call this (you're setting it, after all). Used internally to make
CI's get_config() work.

	CI_TestCase::instance()  __internal__

Returns an instance of the current test case. We force phpunit to
run with backup-globals enabled, so this will always be the instance
of the currently running test class.

### Going forward

#### 1. Bootstrap Test

Testing common.php should be pretty simple. Include the file, and test the
functions. May require some tweaking so that we can grab the statics from all
methods (see is_loaded()). Testing the actual CodeIgniter.php file will most
likely be an output test for the default view, with some object checking after
the file runs. Needs consideration.

#### 2. System Test

Testing the core system relies on being able to isolate the core components
as much as possible. A few of them access other core classes as globals. These
should be mocked up and easy to manipulate.

All functions in common.php should be a minimal implementation, or and mapped
to a method in the test's parent class to gives us full control of their output.

#### 3. Application Test:

Not sure yet, needs to handle:

- Libraries
- Helpers
- Models
- MY_* files
- Controllers (uh...?)
- Views? (watir, selenium, cucumber?)
- Database Testing

#### 4. Package Test:

I don't have a clue how this will work.

Needs to be able to handle packages
that are used multiple times within the application (i.e. EE/Pyro modules)
as well as packages that are used by multiple applications (library distributions)
