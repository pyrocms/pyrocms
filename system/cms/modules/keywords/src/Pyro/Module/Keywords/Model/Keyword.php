<?php namespace Pyro\Module\Keywords\Model;

use Illuminate\Database\Eloquent\Model;
use Pyro\Model\Eloquent;

/**
 * Keyword model
 *
 * @author      PyroCMS Dev Team
 * @package     PyroCMS\Core\Modules\Keywords\Models
 */
class Keyword extends Eloquent
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'keywords';

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
    public function hashes()
    {
        return $this->hasMany('Applied', 'keyword_id');
    }

    /**
     * Get a single keyword by name
     *
     * @param  string $name The name of the keyword to retrieve
     * @return object
     */
    public static function findByName($name)
    {
        return static::where('name', '=', static::prep($name))->first();
    }

    /**
     * Get all keywords ordered by name
     *
     * @param string $direction The direction to sort results
     * @return void
     */
    public static function findAndSortByName($direction = 'asc')
    {
        return static::orderBy('name', $direction)->get();
    }

    /**
     * Get keywords containing a certain search term
     *
     * @param  string $term The search term
     * @return void
     */
    public static function findLikeTerm($term)
    {
        return static::select('name AS value')
            ->where('name', 'like', '%' . $term . '%')
            ->get();
    }

    /**
     * Add a keyword
     *
     * @param string $keyword The keyword to add
     */
    public static function add($keyword)
    {
        return static::create(array('name' => static::prep($keyword)));
    }

    /**
     * Prepare Keyword
     * Gets a keyword ready to be saved
     *
     * @param    string $keyword
     * @return    string
     */
    public static function prep($keyword)
    {
        if (function_exists('mb_strtolower')) {
            return mb_strtolower(trim($keyword));
        } else {
            return strtolower(trim($keyword));
        }
    }

    public static function sync($keywords, Model $model, $relationMethod)
    {
        if (!($keywords = trim($keywords))) {

            return '';
        }

        Applied::deleteByEntryIdAndEntryType($model->getKey(), get_class($model));

        // Split em up and prep away
        $keywords = explode(',', $keywords);

        foreach ($keywords as &$keyword) {

            // Keyword already exists
            if (!($row = Keyword::findByName($keyword))) {
                $row = Keyword::add($keyword);
            }
            
            if (method_exists($model, $relationMethod)) {
                $model->{$relationMethod}()->save($row);
            }
        }

        return $keywords;
    }

}
