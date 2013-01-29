<?php 

/**
 * Redirect model
 *
 * @author      PyroCMS Dev Team
 * @package     PyroCMS\Core\Modules\Redirects\Models 
 */
class Redirect_m extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'redirects';
    public $timestamps = false;

    static function findByUri($uri)
    {
        return self::where('from', '=', $uri)->first();
    }

    static function findByFrom($from)
    {
        return self::where('from','=',$from)->first();
    }

    static function findByFromWithId($from, $id = 0)
    {
        return self::where('id', '!=', (int)$id)
                    ->where('from', '=', $from)->first();
    }
}