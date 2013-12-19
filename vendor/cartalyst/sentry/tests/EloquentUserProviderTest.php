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
use Cartalyst\Sentry\Users\Eloquent\Provider;
use Cartalyst\Sentry\Users\Eloquent\User;
use UserModelStub1;
use UserModelStub2;
use PHPUnit_Framework_TestCase;

class EloquentUserProviderTest extends PHPUnit_Framework_TestCase {

	/**
	 * Setup resources and dependencies.
	 *
	 * @return void
	 */
	public static function setUpBeforeClass()
	{
		require_once __DIR__.'/stubs/users/UserModelStubs.php';
	}

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

	public function testFindingById()
	{
		$provider = m::mock('Cartalyst\Sentry\Users\Eloquent\Provider[createModel]');
		$provider->__construct(
			$hasher = m::mock('Cartalyst\Sentry\Hashing\HasherInterface')
		);

		$user = m::mock('Cartalyst\Sentry\Users\Eloquent\User');
		$user->shouldReceive('hasGetMutator')->andReturn(false);

		$query = m::mock('StdClass');
		$query->shouldReceive('newQuery')->andReturn($query);
		$query->shouldReceive('find')->with(1)->once()->andReturn($user);

		$provider->shouldReceive('createModel')->once()->andReturn($query);

		$this->assertEquals($user, $provider->findById(1));
	}

	/**
	 * @expectedException Cartalyst\Sentry\Users\UserNotFoundException
	 */
	public function testFailedFindingByIdThrowsException()
	{
		$provider = m::mock('Cartalyst\Sentry\Users\Eloquent\Provider[createModel]');

		$query = m::mock('StdClass');
		$query->shouldReceive('newQuery')->andReturn($query);
		$query->shouldReceive('find')->with(1)->once()->andReturn(null);

		$provider->shouldReceive('createModel')->once()->andReturn($query);

		$provider->findById(1);
	}

	public function testFindingByName()
	{
		$provider = m::mock('Cartalyst\Sentry\Users\Eloquent\Provider[createModel]');
		$provider->__construct(
			$hasher = m::mock('Cartalyst\Sentry\Hashing\HasherInterface')
		);

		$loginColumn = 'email';

		$user = m::mock('Cartalyst\Sentry\Users\Eloquent\User');
		$user->shouldReceive('hasGetMutator')->andReturn(false);

		$query = m::mock('StdClass');
		$query->shouldReceive('getLoginName')->once()->andReturn($loginColumn);

		$query->shouldReceive('newQuery')->andReturn($query);
		$query->shouldReceive('where')->with($loginColumn, '=', 'foo@bar.com')->once()->andReturn($query);
		$query->shouldReceive('first')->andReturn($user);

		$provider->shouldReceive('createModel')->once()->andReturn($query);

		$this->assertEquals($user, $provider->findByLogin('foo@bar.com'));
	}

	/**
	 * @expectedException Cartalyst\Sentry\Users\UserNotFoundException
	 */
	public function testFailedFindingByNameThrowsException()
	{
		$provider = m::mock('Cartalyst\Sentry\Users\Eloquent\Provider[createModel]');

		$loginColumn = 'email';

		$query = m::mock('StdClass');
		$query->shouldReceive('getLoginName')->once()->andReturn($loginColumn);

		$query->shouldReceive('newQuery')->andReturn($query);
		$query->shouldReceive('where')->with($loginColumn, '=', 'foo@bar.com')->once()->andReturn($query);
		$query->shouldReceive('first')->andReturn(null);

		$provider->shouldReceive('createModel')->once()->andReturn($query);

		$provider->findByLogin('foo@bar.com');
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testFindingByCredentialsFailsWithoutLoginColumn()
	{
		$user = m::mock('Cartalyst\Sentry\Users\Eloquent\User');
		$user->shouldReceive('getLoginName')->once()->andReturn('foo');
		$user->shouldReceive('hasGetMutator')->andReturn(false);

		$provider = m::mock('Cartalyst\Sentry\Users\Eloquent\Provider[createModel]');
		$provider->shouldReceive('createModel')->once()->andReturn($user);

		$provider->findByCredentials(array(
			'not_foo' => 'ff',
		));
	}

	/**
	 * @expectedException Cartalyst\Sentry\Users\UserNotFoundException
	 */
	public function testFindingByCredentialsFailsWhenModelIsNull()
	{
		$query = m::mock('StdClass');
		$query->shouldReceive('where')->with('foo', '=', 'fooval')->once()->andReturn($query);
		$query->shouldReceive('where')->with('bar', '=', 'barval')->once()->andReturn($query);
		$query->shouldReceive('first')->andReturn(null);

		$user = m::mock('Cartalyst\Sentry\Users\Eloquent\User');
		$user->shouldReceive('getLoginName')->once()->andReturn('foo');
		$user->shouldReceive('getPasswordName')->once()->andReturn('password');
		$user->shouldReceive('newQuery')->andReturn($query);
		$user->shouldReceive('getHashableAttributes')->once()->andReturn(array('baz', 'bat'));
		$user->shouldReceive('hasGetMutator')->andReturn(false);

		$provider = m::mock('Cartalyst\Sentry\Users\Eloquent\Provider[createModel,getHashableCredentials]');
		$provider->shouldReceive('createModel')->once()->andReturn($user);

		$result = $provider->findByCredentials(array(
			'foo' => 'fooval',
			'bar' => 'barval',
			'baz' => 'unhashed_baz',
			'bat' => 'unhashed_bat',
		));
	}

	/**
	 * Regression test for https://github.com/cartalyst/sentry/issues/148
	 *
	 * @expectedException Cartalyst\Sentry\Users\WrongPasswordException
	 */
	public function testFindingByCredentialsFailsForBadPassword()
	{
		$actualUser = m::mock('Cartalyst\Sentry\Users\Eloquent\User');
		$actualUser->shouldReceive('getAttribute')->with('password')->andReturn('hashed_passwordval');
		$actualUser->shouldReceive('hasGetMutator')->andReturn(false);

		$hasher = m::mock('Cartalyst\Sentry\Hashing\HasherInterface');
		$hasher->shouldReceive('checkhash')->with('unhashed_passwordval', 'hashed_passwordval')->
		once()->andReturn(false);

		$query = m::mock('StdClass');
		$query->shouldReceive('where')->with('foo', '=', 'fooval')->once()->andReturn($query);
		$query->shouldReceive('first')->andReturn($actualUser);

		$user = m::mock('Cartalyst\Sentry\Users\Eloquent\User');
		$user->shouldReceive('getLoginName')->once()->andReturn('foo');
		$user->shouldReceive('getPasswordName')->once()->andReturn('password');
		$user->shouldReceive('newQuery')->andReturn($query);
		$user->shouldReceive('getHashableAttributes')->once()->andReturn(array('password'));
		$user->shouldReceive('hasGetMutator')->andReturn(false);

		$provider = m::mock('Cartalyst\Sentry\Users\Eloquent\Provider[createModel,getHashableCredentials]');
		$provider->__construct($hasher);

		$provider->shouldReceive('createModel')->once()->andReturn($user);

		$result = $provider->findByCredentials(array(
			'foo'      => 'fooval',
			'password' => 'unhashed_passwordval',
		));

		$this->assertEquals($actualUser, $result);
	}

	public function testFindingByCredentials()
	{
		$actualUser = m::mock('Cartalyst\Sentry\Users\Eloquent\User');
		$actualUser->shouldReceive('getAttribute')->with('baz')->andReturn('hashed_baz');
		$actualUser->shouldReceive('getAttribute')->with('bat')->andReturn('hashed_bat');
		$actualUser->shouldReceive('hasGetMutator')->andReturn(false);

		$hasher = m::mock('Cartalyst\Sentry\Hashing\HasherInterface');
		$hasher->shouldReceive('checkhash')->with('unhashed_baz', 'hashed_baz')->
		once()->andReturn(true);
		$hasher->shouldReceive('checkhash')->with('unhashed_bat', 'hashed_bat')->once()->andReturn(true);

		$query = m::mock('StdClass');
		$query->shouldReceive('where')->with('foo', '=', 'fooval')->once()->andReturn($query);
		$query->shouldReceive('where')->with('bar', '=', 'barval')->once()->andReturn($query);
		$query->shouldReceive('first')->andReturn($actualUser);

		$user = m::mock('Cartalyst\Sentry\Users\Eloquent\User');
		$user->shouldReceive('getLoginName')->once()->andReturn('foo');
		$user->shouldReceive('getPasswordName')->once()->andReturn('password');
		$user->shouldReceive('newQuery')->andReturn($query);
		$user->shouldReceive('getHashableAttributes')->once()->andReturn(array('baz', 'bat'));
		$user->shouldReceive('hasGetMutator')->andReturn(false);

		$provider = m::mock('Cartalyst\Sentry\Users\Eloquent\Provider[createModel,getHashableCredentials]');
		$provider->__construct($hasher);

		$provider->shouldReceive('createModel')->once()->andReturn($user);

		$result = $provider->findByCredentials(array(
			'foo' => 'fooval',
			'bar' => 'barval',
			'baz' => 'unhashed_baz',
			'bat' => 'unhashed_bat',
		));

		$this->assertEquals($actualUser, $result);
	}

	/**
	 * Regression test for https://github.com/cartalyst/sentry/issues/157
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function testFindByNullActivationCode()
	{
		$provider = new Provider($hasher = m::mock('Cartalyst\Sentry\Hashing\HasherInterface'));
		$provider->findByActivationCode(null);
	}

	/**
	 * Regression test for https://github.com/cartalyst/sentry/issues/157
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function testFindByEmptyActivationCode()
	{
		$provider = new Provider($hasher = m::mock('Cartalyst\Sentry\Hashing\HasherInterface'));
		$provider->findByActivationCode('');
	}

	public function testFindByActivationCode()
	{
		$provider = m::mock('Cartalyst\Sentry\Users\Eloquent\Provider[createModel]');
		$provider->__construct(
			$hasher = m::mock('Cartalyst\Sentry\Hashing\HasherInterface')
		);

		$query = m::mock('StdClass');

		$query->shouldReceive('newQuery')->andReturn($query);
		$query->shouldReceive('where')->with('activation_code', '=', 'foo')->once()->andReturn($query);
		$query->shouldReceive('get')->andReturn($result = m::mock('StdClass'));

		$user = m::mock('Cartalyst\Sentry\Users\Eloquent\User');
		$user->shouldReceive('hasGetMutator')->andReturn(false);

		$result->shouldReceive('count')->once()->andReturn(1);

		$result->shouldReceive('first')->once()->andReturn($user);

		$provider->shouldReceive('createModel')->once()->andReturn($query);

		$this->assertEquals($user, $provider->findByActivationCode('foo'));
	}

	/**
	 * @expectedException Cartalyst\Sentry\Users\UserNotFoundException
	 */
	public function testFailedFindByActivationCode()
	{
		$provider = m::mock('Cartalyst\Sentry\Users\Eloquent\Provider[createModel]');
		$provider->__construct(
			$hasher = m::mock('Cartalyst\Sentry\Hashing\HasherInterface')
		);

		$query = m::mock('StdClass');

		$query->shouldReceive('newQuery')->andReturn($query);
		$query->shouldReceive('where')->with('activation_code', '=', 'foo')->once()->andReturn($query);
		$query->shouldReceive('get')->andReturn($result = m::mock('StdClass'));

		$result->shouldReceive('count')->once()->andReturn(1);

		$result->shouldReceive('first')->once()->andReturn(null);

		$provider->shouldReceive('createModel')->once()->andReturn($query);

		$provider->findByActivationCode('foo');
	}

	public function testFindByResetPasswordCode()
	{
		$provider = m::mock('Cartalyst\Sentry\Users\Eloquent\Provider[createModel]');
		$provider->__construct(
			$hasher = m::mock('Cartalyst\Sentry\Hashing\HasherInterface')
		);

		$query = m::mock('StdClass');

		$query->shouldReceive('newQuery')->andReturn($query);
		$query->shouldReceive('where')->with('reset_password_code', '=', 'foo')->once()->andReturn($query);
		$query->shouldReceive('get')->andReturn($result = m::mock('StdClass'));

		$user = m::mock('Cartalyst\Sentry\Users\Eloquent\User');
		$user->shouldReceive('hasGetMutator')->andReturn(false);

		$result->shouldReceive('count')->once()->andReturn(1);

		$result->shouldReceive('first')->once()->andReturn($user);

		$provider->shouldReceive('createModel')->once()->andReturn($query);

		$this->assertEquals($user, $provider->findByResetPasswordCode('foo'));
	}

	/**
	 * @expectedException Cartalyst\Sentry\Users\UserNotFoundException
	 */
	public function testFailedFindByResetPasswordCode()
	{
		$provider = m::mock('Cartalyst\Sentry\Users\Eloquent\Provider[createModel]');
		$provider->__construct(
			$hasher = m::mock('Cartalyst\Sentry\Hashing\HasherInterface')
		);

		$query = m::mock('StdClass');

		$query->shouldReceive('newQuery')->andReturn($query);
		$query->shouldReceive('where')->with('reset_password_code', '=', 'foo')->once()->andReturn($query);
		$query->shouldReceive('get')->andReturn($result = m::mock('StdClass'));

		$result->shouldReceive('count')->once()->andReturn(1);

		$result->shouldReceive('first')->once()->andReturn(null);

		$provider->shouldReceive('createModel')->once()->andReturn($query);

		$provider->findByResetPasswordCode('foo');
	}

	public function testCreatingUser()
	{
		$attributes = array(
			'email'    => 'foo@bar.com',
			'password' => 'foo_bar_baz',
		);

		$user = m::mock('Cartalyst\Sentry\Users\Eloquent\User');
		$user->shouldReceive('hasGetMutator')->andReturn(false);
		$user->shouldReceive('fill')->with($attributes)->once();
		$user->shouldReceive('save')->once();

		$provider = m::mock('Cartalyst\Sentry\Users\Eloquent\Provider[createModel]');
		$provider->__construct(
			$hasher = m::mock('Cartalyst\Sentry\Hashing\HasherInterface')
		);
		$provider->shouldReceive('createModel')->once()->andReturn($user);

		$this->assertEquals($user, $provider->create($attributes));
	}

	public function testGettingEmptyUserInterface()
	{
		$provider = m::mock('Cartalyst\Sentry\Users\Eloquent\Provider[createModel]');
		$provider->__construct(
			$hasher = m::mock('Cartalyst\Sentry\Hashing\HasherInterface')
		);

		$user = m::mock('Cartalyst\Sentry\Users\Eloquent\User');
		$user->shouldReceive('hasGetMutator')->andReturn(false);

		$provider->shouldReceive('createModel')->once()->andReturn($user);

		$this->assertEquals($user, $provider->getEmptyUser());
	}

	public function testSettingModel()
	{
		$provider = new Provider(
			$hasher = m::mock('Cartalyst\Sentry\Hashing\HasherInterface'),
			'UserModelStub1'
		);

		$this->assertInstanceOf('UserModelStub1', $provider->createModel());

		$provider->setModel('UserModelStub2');
		$this->assertInstanceOf('UserModelStub2', $provider->createModel());
	}

	public function testFindingAllUsers()
	{
		$provider = m::mock('Cartalyst\Sentry\Users\Eloquent\Provider[createModel]');
		$provider->__construct(
			$hasher = m::mock('Cartalyst\Sentry\Hashing\HasherInterface')
		);

		$provider->shouldReceive('createModel')->once()->andReturn($user = m::mock('Cartalyst\Sentry\Users\Eloquent\User'));
		$user->shouldReceive('newQuery')->once()->andReturn($query = m::mock('StdClass'));
		$user->shouldReceive('hasGetMutator')->andReturn(false);
		$query->shouldReceive('get')->once()->andReturn($collection = m::mock('StdClass'));
		$collection->shouldReceive('all')->once()->andReturn(array($user = m::mock('Cartalyst\Sentry\Users\User')));

		$this->assertEquals(array($user), $provider->findAll());
	}

	public function testFindingAllUsersInGroup()
	{
		$user1 = m::mock('Cartalyst\Sentry\Users\Eloquent\User');
		$user1->shouldReceive('hasGetMutator')->andReturn(false);
		$user2 = m::mock('Cartalyst\Sentry\Users\Eloquent\User');
		$user2->shouldReceive('hasGetMutator')->andReturn(false);

		$users = m::mock('Cartalyst\Sentry\Users\Eloquent\User');
		$users->shouldReceive('hasGetMutator')->andReturn(false);
		$users->shouldReceive('get')->andReturn(array($user1));

		$group = m::mock('Cartalyst\Sentry\Groups\Eloquent\Group');
		$group->shouldReceive('hasGetMutator')->andReturn(false);
		$group->shouldReceive('users')->once()->andReturn($users);

		$provider = m::mock('Cartalyst\Sentry\Users\Eloquent\Provider');
		$provider->shouldReceive('findAllInGroup')->once()->andReturn($group->users()->get());

		$this->assertEquals(array($user1), $provider->findAllInGroup($group));
	}

	public function testFindingAllUsersWithAccess()
	{
		$provider = m::mock('Cartalyst\Sentry\Users\Eloquent\Provider[findAll]');

		$provider->shouldReceive('findAll')->once()->andReturn(array(
			$user1 = m::mock('Cartalyst\Sentry\Users\Eloquent\User'),
			$user2 = m::mock('Cartalyst\Sentry\Users\Eloquent\User'),
		));

		$user1->shouldReceive('hasAccess')->with($permissions = array('foo', 'bar'))->once()->andReturn(true);
		$user1->shouldReceive('hasGetMutator')->andReturn(false);
		$user2->shouldReceive('hasAccess')->with($permissions)->once()->andReturn(false);
		$user2->shouldReceive('hasGetMutator')->andReturn(false);

		$this->assertEquals(array($user1), $provider->findAllWithAccess($permissions));
	}

	public function testFindingAllUsersWithAnyAccess()
	{
		$provider = m::mock('Cartalyst\Sentry\Users\Eloquent\Provider[findAll]');

		$provider->shouldReceive('findAll')->once()->andReturn(array(
			$user1 = m::mock('Cartalyst\Sentry\Users\Eloquent\User'),
			$user2 = m::mock('Cartalyst\Sentry\Users\Eloquent\User'),
		));

		$user1->shouldReceive('hasAnyAccess')->with($permissions = array('foo', 'bar'))->once()->andReturn(true);
		$user1->shouldReceive('hasGetMutator')->andReturn(false);
		$user2->shouldReceive('hasAnyAccess')->with($permissions)->once()->andReturn(false);
		$user2->shouldReceive('hasGetMutator')->andReturn(false);

		$this->assertEquals(array($user1), $provider->findAllWithAnyAccess($permissions));
	}

}
