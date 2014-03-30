<?php namespace Pyro\Module\Keywords\Model;

use Pyro\Model\Eloquent;

/**
 * Applied Keyword model
 *
 * @author    PyroCMS Dev Team
 * @package   PyroCMS\Core\Modules\Keywords\Model
 */
class Applied extends Eloquent
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'keywords_applied';

    /**
     * Cache minutes
     *
     * @var int
     */
    public $cacheMinutes = 0;

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
     * Apply a unique hash to a keyword
     *
     * @param  string $hash The unique hash
     * @param  int    $id   Keyword ID
     * @return object
     */
    public static function add($keyword_id, $object_id, $object_type)
    {
        return static::create(
            array(
                'keyword_id' => $keyword_id,
                'model_id'   => $object_id,
                'model_type' => $object_type
            )
        );
    }

    /**
     * Delete by entry id
     *
     * @param $entryId
     * @return mixed
     */
    public static function deleteByEntryIdAndEntryType($entryId, $entryType)
    {
        return static::where('entry_id', $entryId)->where('entry_type', $entryType)->delete();
    }
}
