<?php namespace Cartalyst\Sentry\Tests;
/**
 * Part of the Sentry package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    Sentry
 * @version    2.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2013, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Mockery as m;
use Cartalyst\Sentry\Users\Eloquent\User;
use PHPUnit_Framework_TestCase;

class EloquentUserTest extends PHPUnit_Framework_TestCase {

	/**
	 * Close mockery.
	 *
	 * @return void
	 */
	public function tearDown()
	{
		m::close();
		User::unsetHasher();
	}

	public function testUserIdCallsKey()
	{
		$user = m::mock('Cartalyst\Sentry\Users\Eloquent\User[getKey]');
		$user->shouldReceive('getKey')->once()->andReturn('foo');

		$this->assertEquals('foo', $user->getId());
	}

	public function testUserLoginCallsLoginAttribute()
	{
		$user = new User;
		$user->email = 'foo@bar.com';

		$this->assertEquals('foo@bar.com', $user->getLogin());
	}

	public function testUserLoginNameCallsLoginName()
	{
		$user = m::mock('Cartalyst\Sentry\Users\Eloquent\User[getLoginName]');
		$user->shouldReceive('getLoginName')->once()->andReturn('foo');
		$this->assertEquals('foo', $user->getLoginName());
	}

	public function testUserPasswordCallsPasswordAttribute()
	{
		User::setHasher($hasher = m::mock('Cartalyst\Sentry\Hashing\HasherInterface'));
		$hasher->shouldReceive('hash')->with('unhashed_password_here')->once()->andReturn('hashed_password_here');
		$user = new User;
		$user->password = 'unhashed_password_here';

		$this->assertEquals('hashed_password_here', $user->getPassword());
	}

	public function testGettingGroups()
	{
		$pivot = m::mock('StdClass');
		$pivot->shouldReceive('get')->once()->andReturn('foo');

		$user  = m::mock('Cartalyst\Sentry\Users\Eloquent\User[groups]');
		$user->shouldReceive('groups')->once()->andReturn($pivot);

		$this->assertEquals('foo', $user->getGroups());
	}

	public function testInGroup()
	{
		$group1 = m::mock('Cartalyst\Sentry\Groups\GroupInterface');
		$group1->shouldReceive('getId')->once()->andReturn(123);

		$group2 = m::mock('Cartalyst\Sentry\Groups\GroupInterface');
		$group2->shouldReceive('getId')->once()->andReturn(124);

		$user = m::mock('Cartalyst\Sentry\Users\Eloquent\User[getGroups]');
		$user->shouldReceive('getGroups')->once()->andReturn(array($group2));

		$this->assertFalse($user->inGroup($group1));
	}

	public function testAddingToGroupChecksIfAlreadyInThatGroup()
	{
		$group = m::mock('Cartalyst\Sentry\Groups\GroupInterface');
		$user  = m::mock('Cartalyst\Sentry\Users\Eloquent\User[inGroup,groups]');
		$user->shouldReceive('inGroup')->with($group)->once()->andReturn(true);
		$user->shouldReceive('groups')->never();

		$user->addGroup($group);
	}

	public function testAddingGroupAttachesToRelationship()
	{
		$group = m::mock('Cartalyst\Sentry\Groups\GroupInterface');

		$relationship = m::mock('StdClass');
		$relationship->shouldReceive('attach')->with($group)->once();

		$user  = m::mock('Cartalyst\Sentry\Users\Eloquent\User[inGroup,groups]');
		$user->shouldReceive('inGroup')->once()->andReturn(false);
		$user->shouldReceive('groups')->once()->andReturn($relationship);

		$this->assertTrue($user->addGroup($group));
	}

	public function testRemovingFromGroupDetachesRelationship()
	{
		$group = m::mock('Cartalyst\Sentry\Groups\GroupInterface');

		$relationship = m::mock('StdClass');
		$relationship->shouldReceive('detach')->with($group)->once();

		$user  = m::mock('Cartalyst\Sentry\Users\Eloquent\User[inGroup,groups]');
		$user->shouldReceive('inGroup')->once()->andReturn(true);
		$user->shouldReceive('groups')->once()->andReturn($relationship);

		$this->assertTrue($user->removeGroup($group));
	}

	public function testMergedPermissions()
	{
		$group1 = m::mock('Cartalyst\Sentry\Groups\GroupInterface');
		$group1->shouldReceive('getPermissions')->once()->andReturn(array(
			'foo' => 1,
			'bar' => 1,
			'baz' => 1,
		));

		$group2 = m::mock('Cartalyst\Sentry\Groups\GroupInterface');
		$group2->shouldReceive('getPermissions')->once()->andReturn(array(
			'qux' => 1,
		));

		$user = m::mock('Cartalyst\Sentry\Users\Eloquent\User[getGroups,getPermissions]');
		$user->shouldReceive('getGroups')->once()->andReturn(array($group1, $group2));
		$user->shouldReceive('getPermissions')->once()->andReturn(array(
			'corge' => 1,
			'foo'   => -1,
			'baz'   => -1,
		));

		$expected = array(
			'foo'   => -1,
			'bar'   => 1,
			'baz'   => -1,
			'qux'   => 1,
			'corge' => 1,
		);

		$this->assertEquals($expected, $user->getMergedPermissions());
	}

	public function testSuperUserHasAccessToEverything()
	{
		$user  = m::mock('Cartalyst\Sentry\Users\Eloquent\User[isSuperUser]');
		$user->shouldReceive('isSuperUser')->once()->andReturn(true);

		$this->assertTrue($user->hasAccess('bar'));
	}

	public function testHasAccess()
	{
		$user = m::mock('Cartalyst\Sentry\Users\Eloquent\User[isSuperUser,getMergedPermissions]');
		$user->shouldReceive('isSuperUser')->twice()->andReturn(false);
		$user->shouldReceive('getMergedPermissions')->twice()->andReturn(array(
			'foo' => -1,
			'bar' => 1,
			'baz' => 1,
		));

		$this->assertTrue($user->hasAccess('bar'));
		$this->assertFalse($user->hasAccess('foo'));
	}

	public function testHasAccessWithMultipleProperties()
	{
		$user = m::mock('Cartalyst\Sentry\Users\Eloquent\User[isSuperUser,getMergedPermissions]');
		$user->shouldReceive('isSuperUser')->twice()->andReturn(false);
		$user->shouldReceive('getMergedPermissions')->twice()->andReturn(array(
			'foo' => -1,
			'bar' => 1,
			'baz' => 1,
		));

		$this->assertTrue($user->hasAccess(array('bar', 'baz')));
		$this->assertFalse($user->hasAccess(array('foo', 'bar', 'baz')));
	}

	/**
	 * Feature test for https://github.com/cartalyst/sentry/issues/123
	 */
	public function testWildcardPermissionsCheck()
	{
		$user = m::mock('Cartalyst\Sentry\Users\Eloquent\User[isSuperUser,getMergedPermissions]');
		$user->shouldReceive('isSuperUser')->atLeast(1)->andReturn(false);
		$user->shouldReceive('getMergedPermissions')->atLeast(1)->andReturn(array(
			'users.edit' => 1,
			'users.delete' => 1,
		));

		$this->assertFalse($user->hasAccess('users'));
		$this->assertTrue($user->hasAccess('users.*'));
	}

	/**
	 * Feature test for https://github.com/cartalyst/sentry/pull/131
	 */
	public function testWildcardPermissionsSetting()
	{
		$user = m::mock('Cartalyst\Sentry\Users\Eloquent\User[isSuperUser,getMergedPermissions]');
		$user->shouldReceive('isSuperUser')->atLeast(1)->andReturn(false);
		$user->shouldReceive('getMergedPermissions')->atLeast(1)->andReturn(array(
			'users.*' => 1,
		));

		$this->assertFalse($user->hasAccess('users'));
		$this->assertTrue($user->hasAccess('users.edit'));
		$this->assertTrue($user->hasAccess('users.delete'));
	}


	public function testAnyPermissions()
	{
		$user = m::mock('Cartalyst\Sentry\Users\Eloquent\User[isSuperUser,getMergedPermissions]');
		$user->shouldReceive('isSuperUser')->once()->andReturn(false);
		$user->shouldReceive('getMergedPermissions')->once()->andReturn(array(
			'foo' => -1,
			'baz' => 1,
		));

		$this->assertTrue($user->hasAccess(array('foo', 'baz'), false));
	}

	public function testAnyPermissionsWithInvalidPermissions()
	{
		$user = m::mock('Cartalyst\Sentry\Users\Eloquent\User[isSuperUser,getMergedPermissions]');
		$user->shouldReceive('isSuperUser')->once()->andReturn(false);
		$user->shouldReceive('getMergedPermissions')->once()->andReturn(array(
			'foo' => -1,
			'baz' => 1,
		));

		$this->assertFalse($user->hasAccess(array('foo', 'bar'), false));
	}

	public function testHasAnyAccess()
	{
		$user = m::mock('Cartalyst\Sentry\Users\Eloquent\User[hasAccess]');
		$user->shouldReceive('hasAccess')->with(array('foo', 'bar'), false)->once()->andReturn(true);

		$this->assertTrue($user->hasAnyAccess(array('foo', 'bar')));
	}

	/**
	 * Regression test for https://github.com/cartalyst/sentry/issues/103
	 */
	public function testSettingPermissionsWhenPermissionsAreStrings()
	{
		$user = new User;
		$user->permissions = array(
			'superuser' => '1',
			'admin'    => '1',
			'foo'      => '0',
			'bar'      => '-1',
		);

		$expected = array(
			'superuser' => 1,
			'admin'     => 1,
			'bar'       => -1,
		);

		$this->assertEquals($expected, $user->permissions);
	}

	/**
	 * Regression test for https://github.com/cartalyst/sentry/issues/103
	 */
	public function testSettingPermissionsWhenAllPermissionsAreZero()
	{
		$user = new User;

		$user->permissions = array(
			'superuser' => 0,
			'admin'     => 0,
		);

		$this->assertEquals(array(), $user->permissions);
	}

	/**
	 * @expectedException Cartalyst\Sentry\Users\LoginRequiredException
	 */
	public function testValidationThrowsLoginExceptionIfNoneGiven()
	{
		$user = new User;
		$user->validate();
	}

	/**
	 * @expectedException Cartalyst\Sentry\Users\PasswordRequiredException
	 */
	public function testValidationThrowsPasswordExceptionIfNoneGiven()
	{
		$user = new User;
		$user->email = 'foo';
		$user->validate();
	}

	/**
	 * @expectedException Cartalyst\Sentry\Users\UserExistsException
	 */
	public function testValidationFailsWhenUserAlreadyExists()
	{
		User::setHasher($hasher = m::mock('Cartalyst\Sentry\Hashing\HasherInterface'));
		$hasher->shouldReceive('hash')->with('bazbat')->once()->andReturn('hashed_bazbat');

		$persistedUser = m::mock('Cartalyst\Sentry\Users\UserInterface');
		$persistedUser->shouldReceive('getId')->once()->andReturn(123);

		$user = m::mock('Cartalyst\Sentry\Users\Eloquent\User[newQuery]');
		$user->email = 'foo@bar.com';
		$user->password = 'bazbat';

		$query = m::mock('StdClass');
		$query->shouldReceive('where')->with('email', '=', 'foo@bar.com')->once()->andReturn($query);
		$query->shouldReceive('first')->once()->andReturn($persistedUser);

		$user->shouldReceive('newQuery')->once()->andReturn($query);

		$user->validate();
	}

	/**
	 * @expectedException Cartalyst\Sentry\Users\UserExistsException
	 */
	public function testValidationFailsWhenUserAlreadyExistsOnExistent()
	{
		User::setHasher($hasher = m::mock('Cartalyst\Sentry\Hashing\HasherInterface'));
		$hasher->shouldReceive('hash')->with('bazbat')->once()->andReturn('hashed_bazbat');

		$persistedUser = m::mock('Cartalyst\Sentry\Users\UserInterface');
		$persistedUser->shouldReceive('getId')->once()->andReturn(123);

		$user = m::mock('Cartalyst\Sentry\Users\Eloquent\User[newQuery]');
		$user->id = 124;
		$user->email = 'foo@bar.com';
		$user->password = 'bazbat';

		$query = m::mock('StdClass');
		$query->shouldReceive('where')->with('email', '=', 'foo@bar.com')->once()->andReturn($query);
		$query->shouldReceive('first')->once()->andReturn($persistedUser);

		$user->shouldReceive('newQuery')->once()->andReturn($query);

		$user->validate();
	}

	public function testValidationDoesNotThrowAnExceptionIfPersistedUserIsThisUser()
	{
		User::setHasher($hasher = m::mock('Cartalyst\Sentry\Hashing\HasherInterface'));
		$hasher->shouldReceive('hash')->with('bazbat')->once()->andReturn('hashed_bazbat');

		$persistedUser = m::mock('Cartalyst\Sentry\Users\UserInterface');
		$persistedUser->shouldReceive('getId')->once()->andReturn(123);

		$user = m::mock('Cartalyst\Sentry\Users\Eloquent\User[newQuery]');
		$user->id = 123;
		$user->email = 'foo@bar.com';
		$user->password = 'bazbat';

		$query = m::mock('StdClass');
		$query->shouldReceive('where')->with('email', '=', 'foo@bar.com')->once()->andReturn($query);
		$query->shouldReceive('first')->once()->andReturn($persistedUser);

		$user->shouldReceive('newQuery')->once()->andReturn($query);

		$this->assertTrue($user->validate());
	}

	public function testClearResetPassword()
	{
		$user = m::mock('Cartalyst\Sentry\Users\Eloquent\User[save]');
		$user->shouldReceive('save')->never();
		$user->clearResetPassword();

		$user = m::mock('Cartalyst\Sentry\Users\Eloquent\User[save]');

		$user->reset_password_code = 'foo_bar_baz';
		$user->shouldReceive('save')->once();
		$user->clearResetPassword();
		$this->assertNull($user->reset_password_code);
	}

	public function testHasherSettingAndGetting()
	{
		$this->assertNull(User::getHasher());
		User::setHasher($hasher = m::mock('Cartalyst\Sentry\Hashing\HasherInterface'));
		$this->assertEquals($hasher, User::getHasher());
	}

	/**
	 * @expectedException RuntimeException
	 */
	public function testHasherThrowsExceptionIfNotSet()
	{
		$user = new User;
		$user->checkHash('foo', 'bar');
	}

	public function testRandomStrings()
	{
		$user = new User;
		$last = '';

		for ($i = 0; $i < 500; $i++)
		{
			$now = $user->getRandomString();

			if ($now === $last)
			{
				throw new \UnexpectedValueException("Two random strings are the same, [$now], [$last].");
			}

			$last = $now;
		}

	}

	public function testGetPersistCode()
	{
		$randomString = 'random_string_here';
		$hashedRandomString = 'hashed_random_string_here';

		User::setHasher($hasher = m::mock('Cartalyst\Sentry\Hashing\HasherInterface'));
		$hasher->shouldReceive('hash')->with($randomString)->once()->andReturn($hashedRandomString);

		$user = m::mock('Cartalyst\Sentry\Users\Eloquent\User[save,getRandomString]');

		$this->assertNull($user->persist_code);
		$user->shouldReceive('save')->once();
		$user->shouldReceive('getRandomString')->once()->andReturn($randomString);

		$persistCode = $user->getPersistCode();
		$this->assertEquals($hashedRandomString, $persistCode);
		$this->assertEquals($hashedRandomString, $user->persist_code);
	}

	public function testCheckingPersistCode()
	{
		User::setHasher($hasher = m::mock('Cartalyst\Sentry\Hashing\HasherInterface'));
		$user = new User;

		// Create a new hash
		$hasher->shouldReceive('hash')->with('reset_code')->andReturn('hashed_reset_code');
		$user->persist_code = 'reset_code';

		// Check the hash
		$this->assertTrue($user->checkPersistCode('hashed_reset_code'));
		$this->assertFalse($user->checkPersistCode('not_the_codeed_reset_code'));
	}

	public function testGetActivationCode()
	{
		$user = m::mock('Cartalyst\Sentry\Users\Eloquent\User[save,getRandomString]');

		$this->assertNull($user->activation_code);
		$user->shouldReceive('save')->once();
		$user->shouldReceive('getRandomString')->once()->andReturn($randomString = 'random_string_here');

		$activationCode = $user->getActivationCode();
		$this->assertEquals($randomString, $activationCode);
		$this->assertEquals($randomString, $user->activation_code);
	}

	public function testGetResetPasswordCode()
	{
		$user = m::mock('Cartalyst\Sentry\Users\Eloquent\User[save,getRandomString]');

		$this->assertNull($user->reset_password_code);
		$user->shouldReceive('save')->once();
		$user->shouldReceive('getRandomString')->once()->andReturn($randomString = 'random_string_here');

		$resetCode = $user->getResetPasswordCode();
		$this->assertEquals($randomString, $resetCode);
		$this->assertEquals($randomString, $user->reset_password_code);
	}

	/**
	 * @expectedException Cartalyst\Sentry\Users\UserAlreadyActivatedException
	 */
	public function testUserIsNotActivatedTwice()
	{
		$user = m::mock('Cartalyst\Sentry\Users\Eloquent\User[checkHash]');
		$user->shouldReceive('checkHash')->never();
		$user->activated = true;

		$user->attemptActivation('not_needed');
	}

	public function testUserActivation()
	{
		$user = m::mock('Cartalyst\Sentry\Users\Eloquent\User[getActivationCode,checkHash,save]');
		$this->addMockConnection($user);
		$user->getConnection()->getQueryGrammar()->shouldReceive('getDateFormat')->andReturn('Y-m-d H:i:s');

		$user->activation_code = 'activation_code';
		$user->shouldReceive('save')->once()->andReturn(true);

		$this->assertNull($user->activated_at);
		$this->assertTrue($user->attemptActivation('activation_code'));
		$this->assertNull($user->activation_code);
		$this->assertTrue($user->activated);
		$this->assertInstanceOf('DateTime', $user->activated_at);
	}

	public function testCheckingPassword()
	{
		$user = m::mock('Cartalyst\Sentry\Users\Eloquent\User[getPassword,checkHash]');
		$user->shouldReceive('getPassword')->once()->andReturn('hashed_password');
		$user->shouldReceive('checkHash')->with('password', 'hashed_password')->once()->andReturn(true);

		$this->assertTrue($user->checkPassword('password'));
	}

	public function testCheckingResetPasswordCode()
	{
		User::setHasher($hasher = m::mock('Cartalyst\Sentry\Hashing\HasherInterface'));
		$user = new User;

		// Check the hash
		$user->reset_password_code = 'reset_code';
		$this->assertTrue($user->checkResetPasswordCode('reset_code'));
		$this->assertFalse($user->checkResetPasswordCode('not_the_reset_code'));
	}

	public function testResettingPassword()
	{
		User::setHasher($hasher = m::mock('Cartalyst\Sentry\Hashing\HasherInterface'));
		$user = m::mock('Cartalyst\Sentry\Users\Eloquent\User[checkResetPasswordCode,save]');
		$user->shouldReceive('checkResetPasswordCode')->with('reset_code')->andReturn(true);

		$hasher->shouldReceive('hash')->with('new_password')->once()->andReturn('hashed_new_password');

		$user->shouldReceive('save')->once()->andReturn(true);

		$this->assertTrue($user->attemptResetPassword('reset_code', 'new_password'));
		$this->assertNull($user->reset_password_code);
		$this->assertEquals('hashed_new_password', $user->getPassword());
	}

	public function testPermissionsAreMergedAndRemovedProperly()
	{
		$user = new User;
		$user->permissions = array(
			'foo' => 1,
			'bar' => 1,
		);

		$user->permissions = array(
			'baz' => 1,
			'qux' => 1,
			'foo' => 0,
		);

		$expected = array(
			'bar' => 1,
			'baz' => 1,
			'qux' => 1,
		);

		$this->assertEquals($expected, $user->permissions);
	}


	public function testPermissionsWithArrayCastingAndJsonCasting()
	{
		$user = new User;
		$user->email = 'foo@bar.com';
		$user->permissions = array(
			'foo' => 1,
			'bar' => -1,
			'baz' => 1,
		);

		$expected = array(
			'email' => 'foo@bar.com',
			'permissions' => array(
				'foo' => 1,
				'bar' => -1,
				'baz' => 1,
			),
			//'activated' => false,
			//'login' => 'email'
		);
		$this->assertEquals($expected, $user->toArray());

		$expected = json_encode($expected);
		$this->assertEquals($expected, (string) $user);
	}

	public function testDeletingUserDetachesAllGroupRelationships()
	{
		$relationship = m::mock('StdClass');
		$relationship->shouldReceive('detach')->once();

		$user = m::mock('Cartalyst\Sentry\Users\Eloquent\User[groups]');
		$user->shouldReceive('groups')->once()->andReturn($relationship);

		$user->delete();
	}

	public function testSettingLoginAttribute()
	{
		$originalAttribute = User::getLoginAttributeName();
		User::setLoginAttributeName('foo');
		$this->assertEquals('foo', User::getLoginAttributeName());
		user::setLoginAttributeName($originalAttribute);
	}

	public function testRecordingLogin()
	{
		$user = m::mock('Cartalyst\Sentry\Users\Eloquent\User[save]');
		$this->addMockConnection($user);
		$user->getConnection()->getQueryGrammar()->shouldReceive('getDateFormat')->andReturn('Y-m-d H:i:s');

		$user->shouldReceive('save')->once();
		$user->recordLogin();
		$this->assertInstanceOf('DateTime', $user->last_login);
	}

	protected function addMockConnection($model)
	{
		$model->setConnectionResolver($resolver = m::mock('Illuminate\Database\ConnectionResolverInterface'));
		$resolver->shouldReceive('connection')->andReturn(m::mock('Illuminate\Database\Connection'));
		$model->getConnection()->shouldReceive('getQueryGrammar')->andReturn(m::mock('Illuminate\Database\Query\Grammars\Grammar'));
		$model->getConnection()->shouldReceive('getPostProcessor')->andReturn(m::mock('Illuminate\Database\Query\Processors\Processor'));
	}

}
