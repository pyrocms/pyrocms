<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Keyword model
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS
 * @subpackage Modules
 * @category Keywords
 *
 */
class Keyword_m extends MY_Model {
	
	/**
	 * Get keywords applied
	 *
	 * Gets all the keywords applied with a certain hash
	 *
	 * @param	string	$hash	The unique hash stored for a entry
	 * @return	array
	 */
	public function get_applied($hash)
	{
		return $this->db
			->select('name')
			->where('hash', $hash)
			->join('keywords', 'keyword_id = keywords.id')
			->order_by('name')
			->get('keywords_applied')
			->result();
	}
	
	/**
	 * Get hashes applied
	 *
	 * Does the reverse of get_applied()
	 * Gets all the hashes applied with certain keywords
	 *
	 * @param	string	$names	The array of names to get
	 * @return	array
	 */
	public function get_hashes_applied($names)
	{	
		return $this->db
			->or_where_in('name', $names)
			->join('keywords_applied', 'keywords_applied.keyword_id = keywords.id')
			->order_by('name')
			->get('keywords')
			->result();
	}
	
}