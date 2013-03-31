<?php

use Pyro\Module\Keywords\Model\Keyword;
use Pyro\Module\Keywords\Model\Applied;

/**
 * Keywords Library
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Keywords\Libraries
 */

class Keywords
{
	/**
	 * Get keywords
	 *
	 * Gets all the keywords as a comma-delimited string
	 *
	 * @param	string	$hash	The unique hash stored for a entry
	 * @return	string
	 */
	public static function get_string($hash)
	{
		$keywords = array();

		foreach (Applied::getNamesByHash($hash) as $keyword) {
			$keywords[] = $keyword->name;
		}

		return implode(', ', $keywords);
	}

	/**
	 * Get keywords
	 *
	 * Gets just the keywords, no other data
	 *
	 * @param	string	$hash	The unique hash stored for a entry
	 * @return	array
	 */
	public static function get_array($hash)
	{
		$keywords = array();

		foreach (Applied::getNamesByHash($hash) as $keyword) {
			$keywords[] = $keyword->name;
		}

		return $keywords;
	}

	/**
	 * Get full array of keywords
	 *
	 * Returns keywords with all data
	 *
	 * @param	string	$hash	The unique hash stored for a entry
	 * @return	array
	 */
	public static function get($hash)
	{
		return Applied::getNamesByHash($hash);
	}

	/**
	 * Add Keyword
	 *
	 * Adds a new keyword to the database
	 *
	 * @param	array	$keyword
	 * @return	int
	 */
	public static function add($keyword)
	{
		return Keyword::add(static::prep($keyword))->id;
	}

	/**
	 * Prepare Keyword
	 *
	 * Gets a keyword ready to be saved
	 *
	 * @param	string	$keyword
	 * @return	string
	 */
	public static function prep($keyword)
	{
		if (function_exists('mb_strtolower')) {
			return mb_strtolower(trim($keyword));
		} else {
			return strtolower(trim($keyword));
		}
	}

	/**
	 * Process Keywords
	 *
	 * Process a posted list of keywords into the db
	 *
	 * @param	string	$group	Arbitrary string to "namespace" unique requests
	 * @param	string	$keywords	String containing unprocessed list of keywords
	 * @param	string	$old_hash	If running an update, provide the old hash so we can remove it
	 *
	 * @return	string
	 */
	public static function process($keywords, $old_hash = null)
	{
		// Remove the old keyword assignments if we're updating
		if ($old_hash !== null) {
			Applied::deleteByHash($old_hash);
		}

		// No keywords? Let's not bother then
		if ( ! ($keywords = trim($keywords))) {
			return '';
		}

		$assignment_hash = md5(microtime().mt_rand());

		// Split em up and prep away
		$keywords = explode(',', $keywords);
		foreach ($keywords as &$keyword) {
			$keyword = self::prep($keyword);

			// Keyword already exists
			if (($row = Keyword::findByName($keyword))) {
				$keyword_id = $row->id;
			}

			// Create it, and keep the record
			else {
				$keyword_id = self::add($keyword);
			}

			// Create assignment record
			Applied::add($assignment_hash, $keyword_id);
		}

		return $assignment_hash;
	}

}

/* End of file Keywords.php */
