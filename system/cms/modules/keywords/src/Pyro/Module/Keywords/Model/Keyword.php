<?php namespace Pyro\Module\Keywords\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Keyword model
 *
 * @author	  PyroCMS Dev Team
 * @package	 PyroCMS\Core\Modules\Keywords\Models
 */
class Keyword extends Model
{
	/**
	 * Define the table name
	 *
	 * @var string
	 */
	public $table = 'keywords';

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
		return static::where('name', '=', $name)->first();
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
					->where('name', 'like', '%'.$term.'%')
					->get();
	}

	/**
	 * Add a keyword
	 *
	 * @param string $keyword The keyword to add
	 */
	public static function add($keyword)
	{
		return static::create(array('name' => $keyword));
	}
}
