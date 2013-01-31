<?php

use Illuminate\Database\Eloquent\Model;

/**
 * Keyword model
 *
 * @author	  PyroCMS Dev Team
 * @package	 PyroCMS\Core\Modules\Keywords\Models
 */
class Keyword_m extends Model
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
	 * Get a single keyword by name
	 *
	 * @param  string $name The name of the keyword to retrieve
	 * @return object
	 */
	public static function findByName($name)
	{
		return self::where('name', '=', $name)->first();
	}

	/**
	 * Get all keywords ordered by name
	 *
	 * @param string $direction The direction to sort results
	 * @return void
	 */
	public static function findAndSortByName($direction = 'asc')
	{
		return self::orderBy('name', $direction)->get();
	}

	/**
	 * Get keywords containing a certain search term
	 *
	 * @param  string $term The search term
	 * @return void
	 */
	public static function findLikeTerm($term)
	{
		return self::select('name AS value')
					->where('name', 'like', '%'.$term.'%')
					->get();
	}

	/**
	 * Get applied
	 *
	 * Gets all the keywords applied with a certain hash
	 *
	 * @param   string  $hash   The unique hash stored for a entry
	 * @return  array
	 */
	public static function getAppliedByHash($hash)
	{
		return self::from('keywords_applied')
				->select('name')
				->where('hash', '=', $hash)
				->join('keywords', 'keyword_id', '=', 'keywords.id')
				->orderBy('name')
				->get();
	}

	/**
	 * Delete applied
	 *
	 * Deletes all the keywords applied by hash
	 *
	 * @param   string  $hash   The unique hash stored for an entry
	 * @return  int
	 */
	public static function deleteAppliedByHash($hash)
	{
		return self::from('keywords_applied')
					->where('hash', '=', $hash)
					->delete();
	}
}
