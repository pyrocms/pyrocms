<?php 

/**
 * Redirect model
 *
 * @author      PyroCMS Dev Team
 * @package     PyroCMS\Core\Modules\Redirects\Models 
 */
class Redirect_m extends \Illuminate\Database\Eloquent\Model
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'redirects';

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
        return self::where('from', '=', $uri)->first();
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
        return self::where('from','=',$from)->first();
    }

    /**
     * Find redirect by From with ID
     *
     * @param string $from The from of the redirect
     * @param int $id of the redirect
     *
     * @return void
     */
    public static function findByFromWithId($from, $id = 0)
    {
        return self::where('id', '!=', (int)$id)
                    ->where('from', '=', $from)->first();
    }
}