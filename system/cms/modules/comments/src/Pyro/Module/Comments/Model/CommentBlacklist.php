<?php namespace Pyro\Module\Comments\Model;

/**
 * Comment Blacklist model
 *
 * @author      PyroCMS Dev Team
 * @package     PyroCMS\Core\Modules\Comments\Models 
 */
class CommentBlacklist extends \Illuminate\Database\Eloquent\Model
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'comment_blacklists';

    /**
     * Disable updated_at and created_at on table
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Find blacklist by email and website
     *
     * @param string $email 
     * @param string $website
     *
     * @return void
     */
    public static function findManyByEmailOrWebsite($email, $website = null)
    {
        if ($website) {
            return static::where('email','=',$email)->orWhere('website','=',$website)->get();
        } else {
            return static::where('email','=',$email)->get();
        }
    }

}