<?php namespace Pyro\Module\Users\Model;

use Cartalyst\Sentry\Users\Eloquent\User as EloquentUser;
use Pyro\Support\Contracts\ArrayableInterface;

/**
 * User model for the users module.
 *
 * @author      PyroCMS Dev Team
 * @package     PyroCMS\Core\Modules\User\Models
 */
class User extends EloquentUser implements ArrayableInterface
{
    /**
     * Disable updated_at and created_at on table
     *
     * @var boolean
     */
    public $timestamps = true;
    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'users';
    /**
     * The attributes that aren't mass assignable
     *
     * @var array
     */
    protected $guarded = array();
    /**
     * Order by column
     *
     * @var string
     */
    protected $orderByColumn = 'username';

    /**
     * Get an array of user options
     *
     * @param  string $group Optional group name to filter users
     *
     * @return array         The array of user options
     */
    public static function getUserOptions($group = null)
    {
        $users = static::all();

        if (!empty($group) and $group = Group::findByName($group)) {
            $users = $users->filter(
                function ($user) use ($group) {
                    return $user->inGroup($group);
                }
            );
        }

        return $users->lists('username', 'id');
    }

    public static function assignGroupIdsToUser(User $user = null, $group_ids = array())
    {
        if (!$user->isSuperUser() and !empty($group_ids) and $groups = Group::findManyInId($group_ids)) {
            foreach ($groups as $group) {
                // Add the groups to the user
                // We must pass a Group model to addGroup()
                $user->addGroup($group);
            }

            // Remove any groups that are not selected
            foreach ($user->groups as $group) {
                if (!in_array($group->id, $groups->modelKeys())) {
                    $user->removeGroup($group);
                }
            }
        }
    }

    public function isSuperUser()
    {
        return $this->isAdmin();
    }

    /**
     * Checks if the user is a super user - has
     * access to everything regardless of permissions.
     *
     * @return bool
     */
    public function isAdmin()
    {
        $permissions = $this->getMergedPermissions();

        if (!array_key_exists('admin', $permissions)) {
            return false;
        }

        return $permissions['admin'] == 1;
    }

    /**
     * Get order by column
     *
     * @return string
     */
    public function getOrderByColumn()
    {
        return $this->orderByColumn;
    }

    public function getDates()
    {
        return array('created_at');
    }

    /**
     * Returns the relationship between users and groups.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany('Pyro\Module\Users\Model\Group', 'users_groups', 'user_id');
    }

    public function getCurrentGroupIds()
    {
        $ids = $this->groups->modelKeys();

        return !empty($ids) ? $ids : array(2); // At least return the Users group
    }

    public function getHidden()
    {
        array_unshift($this->hidden, 'salt');

        return $this->hidden;
    }

    /**
     * Returns the relationship between comments and users
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profile()
    {
        return $this->hasOne('Pyro\Module\Users\Model\Profile');
    }

    /**
     * Finds a user by the login value.
     *
     * @param  string $login
     *
     * @return Cartalyst\Sentry\Users\UserInterface
     * @throws Cartalyst\Sentry\Users\UserNotFoundException
     */
    public function findByLogin($login)
    {
        return $this->findByUsername($login) ? : $this->findByEmail($login);
    }

    /**
     * Find a user based from their username
     *
     * @param    array $username Username of the user
     *
     * @return  $this
     */
    public static function findByUsername($username)
    {
        return self::whereRaw('LOWER(username) = ?', array(strtolower($username)))->first();
    }

    /**
     * Find a user based from their email
     *
     * @param    array $username Username of the user
     *
     * @return  $this
     */
    public static function findByEmail($email)
    {
        return self::whereRaw('LOWER(email) = ?', array(strtolower($email)))->first();
    }

    /**
     * Get recent users
     *
     * @return     array
     */
    public function getRecent()
    {
        return $this
            ->orderBy('created_at', 'desc')
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
     * Check if user is activated
     *
     * @return bool
     */
    public function isActivated()
    {
        return isset($this->is_activated) ? $this->is_activated : false;
    }

    /**
     * Update the last login time
     */
    public function updateLastLogin()
    {
        $this->last_login = time();
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
        $this->is_activated    = true;
        $this->activation_code = null;
        $this->save();
    }

    /**
     * Delete a user, their profile and assigned groups
     *
     * @return boolean The delete success
     */
    public function delete()
    {
        // Delete the profile
        if ($this->profile) {
            $this->profile->delete();
        }

        // Remove assigned groups
        if (!$this->groups->isEmpty()) {
            foreach ($this->groups as $group) {
                $this->removeGroup($group);
            }
        }

        return parent::delete();
    }

    /**
     * Override sentry's method here - no activated, activated_on fields
     *
     * @param  string $activationCode
     *
     * @return boolean
     */
    public function attemptActivation($activationCode)
    {
        if ($this->is_activated) {
            throw new \Exception('Cannot attempt activation on an already activated user.');
        }

        if ($activationCode == $this->activation_code) {
            $this->activation_code = null;
            $this->is_activated    = true;

            return $this->save();
        }

        return false;
    }
}
