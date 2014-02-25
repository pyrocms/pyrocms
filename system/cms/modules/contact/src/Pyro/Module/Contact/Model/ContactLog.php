<?php namespace Pyro\Module\Contact\Model;

use Pyro\Model\Eloquent;

/**
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Contact\Models
 */
class ContactLog extends Eloquent
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'contact_log';

    /**
     * Cache minutes
     * @var int
     */
    public $cacheMinutes = 30;

    /**
     * The attributes that aren't mass assignable
     *
     * @var array
     */
    protected $guarded = array();

    /**
     * Disable updated_at and created_at on table
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Get all contact logs ordered by name
     *
     * @param string $direction The direction to sort results
     * @return void
     */
    public static function findAndSortByDate($direction = 'desc')
    {
        return static::orderBy('sent_at', $direction)->get();
    }

}
