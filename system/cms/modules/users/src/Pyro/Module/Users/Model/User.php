<?php namespace Pyro\Module\Users\Model; 

use Cartalyst\Sentry\Users\Eloquent;
// use Cartalyst\Sentry\Users\UserInterface;

/**
 * User model for the users module.
 * 
 * @author      PyroCMS Dev Team
 * @package     PyroCMS\Core\Modules\User\Models
 */
class User extends Eloquent\User
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Disable updated_at and created_at on table
     *
     * @var boolean
     */
    public $timestamps = false;

	/**
	 * Returns the relationship between users and groups.
	 *
	 * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function groups()
	{
		return $this->belongsToMany('Cartalyst\Sentry\Groups\Eloquent\Group', 'users_groups', 'user_id');
	}

	/**
	 * Find a user based from their username
	 *
	 * @param 	array $username Username of the user
	 * @return  $this
	 */
	public function findByUsername($username)
	{
		return $this
			->whereRaw('LOWER(username) = ?', array(strtolower($username)))
			->first();
	}

	/**
	 * Find a user based from their email
	 *
	 * @param 	array $username Username of the user
	 * @return  $this
	 */
	public function findByEmail($email)
	{
		return $this
			->whereRaw('LOWER(email) = ?', array(strtolower($email)))
			->first();
	}

	/**
	 * Finds a user by the login value.
	 *
	 * @param  string  $login
	 * @return Cartalyst\Sentry\Users\UserInterface
	 * @throws Cartalyst\Sentry\Users\UserNotFoundException
	 */
	public function findByLogin($login)
	{
		$user = $this->findByUsername($login) ?: $this->findByEmail($login);

		if ( ! $user)
		{
			throw new UserNotFoundException("A user could not be found with a login value of [$login].");
		}

		return $user;
	}

	/**
	 * Check if user is activated
	 *
	 * @return bool
	 */
	public function isActivated()
	{
		return (bool) $this->is_activated;
	}

	/**
	 * Get recent users
	 *
	 * @return     array
	 */
	public function getRecent()
	{
		return $this
			->orderBy('created_on', 'desc')
			->all();
	}

	/**
	 * Get all user objects
	 *
	 * @return object
	 */
	public function getAll()
	{
		return $this
			->with('profiles')
			->groupBy('users.id')
			->all();
	}

	/**
	 * Get Stream Fields
	 *
	 * @TODO KILL ME! This should be a real join or something
	 * @return array
	 */
	public function getStreamFields()
	{
		$this->stream = ci()->streams_m->get_stream('profiles', true, 'users');

		return ci()->streams_m->get_stream_fields($this->stream->id);
	}

	// public function add($input = array())
	// {
	// 	return parent::insertDOESNTEXIST(array(
	// 		'email' => $input->email,
	// 		'password' => $input->password,
	// 		'salt' => $input->salt,
	// 		'role' => empty($input->role) ? 'user' : $input->role,
	// 		'active' => 0,
	// 		'lang' => $this->config->item('default_language'),
	// 		'activation_code' => $input->activation_hash,
	// 		'created_on' => now(),
	// 		'last_login' => now(),
	// 		'ip' => $this->input->ip_address()
	// 	));
	// }

	/**
	 * Checks if the user is a super user - has
	 * access to everything regardless of permissions.
	 *
	 * @return bool
	 */
	public function isAdmin()
	{
		$permissions = $this->getMergedPermissions();

		if ( ! array_key_exists('admin', $permissions))
		{
			return false;
		}

		return $permissions['admin'] == 1;
	}

	public function isSuperUser()
	{
		return $this->isAdmin();
	}

	/**
	 * Update the last login time
	 */
	public function updateLastLogin()
	{
		$this->last_login = now();
		$this->save();
	}

	/**
	 * Activate a newly created user
	 *
	 * @param int $id
	 *
	 * @return bool
	 */
	public function activateUser()
	{
		$this->is_activated = true;
		$this->activation_code = null;
		$this->save();
	}

}