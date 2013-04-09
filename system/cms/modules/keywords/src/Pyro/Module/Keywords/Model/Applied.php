<?php namespace Pyro\Module\Keywords\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Applied Keyword model
 *
 * @author    PyroCMS Dev Team
 * @package  PyroCMS\Core\Modules\Keywords\Models
 */
class Applied extends Model
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'keywords_applied';

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
     * Define the relationship
     *
     * @return void
     */
    public function keyword()
    {
        return $this->belongsTo('Keyword', 'keyword_id');
    }

    /**
     * Get applied names
     *
     * Gets only the name of applied keywords, just like the old method
     *
     * @param  string $hash The hash stored for an entry
     * @return array
     */
    public static function getNamesByHash($hash)
    {
        $keyword_ids = static::where('hash', $hash)->lists('keyword_id');
        
        if ( ! $keyword_ids) {
            return array();    
        }

        return Keyword::select('name')
            ->whereIn('id', $keyword_ids)
            ->get();
    }

    /**
     * Apply a unique hash to a keyword
     *
     * @param  string $hash The unique hash
     * @param  int    $id   Keyword ID
     * @return object
     */
    public static function add($hash, $keyword_id)
    {
        return static::create(array(
            'hash' => $hash,
            'keyword_id' => $keyword_id
        ));
    }

    /**
     * Delete applied
     *
     * Deletes all the keywords applied by hash
     *
     * @param  string $hash The unique hash stored for an entry
     * @return int
     */
    public static function deleteByHash($hash)
    {
        return static::where('hash', '=', $hash)->delete();
    }
}
