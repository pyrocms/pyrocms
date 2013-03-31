<?php namespace Pyro\Module\Redirects\Model;

/**
 * Redirect model
 *
 * @author      PyroCMS Dev Team
 * @package     PyroCMS\Core\Modules\Redirects\Models
 */
class Redirect extends \Illuminate\Database\Eloquent\Model
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'redirects';

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
     * Find redirect by URI
     *
     * @param string $uri The URI of the redirect
     *
     * @return void
     */
    public static function findByUri($uri)
    {
        return static::where('from', '=', $uri)->first();
    }

    /**
     * Find redirect by From
     *
     * @param string $from The from of the redirect
     *
     * @return void
     */
    public static function findByFrom($from)
    {
        return static::where('from','=',$from)->first();
    }

    /**
     * Find redirect by From with ID
     *
     * @param string $from The from of the redirect
     * @param int    $id   of the redirect
     *
     * @return void
     */
    public static function findByFromAndId($from, $id = 0)
    {
        return static::where('id', '!=', $id)
                    ->where('from', '=', $from)->first();
    }
}
