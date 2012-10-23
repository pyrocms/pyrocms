<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Keyword model
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Keywords\Models
 */
class Keyword_m extends MY_Model {
	
	/**
	 * Get applied
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
	 * Delete applied
	 *
	 * Deletes all the keywords applied byhash
	 *
	 * @param	string	$hash	The unique hash stored for a entry
	 * @return	array
	 */
	public function delete_applied($hash)
	{
		return $this->db
			->where('hash', $hash)
			->delete('keywords_applied');
	}
}