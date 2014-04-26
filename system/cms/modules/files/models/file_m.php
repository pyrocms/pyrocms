<?php  defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * PyroCMS Files Model
 *
 * @author		Jerel Unruh - PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Files\Models
 */
class File_m extends MY_Model {

	protected $table = 'files';

	// ------------------------------------------------------------------------

	/**
	 * Exists
	 *
	 * Checks if a given file exists.
	 * 
	 * @param	int		The file id
	 * @return	bool	If the file exists
	 */
	public function exists($file_id)
	{
		return (bool) (parent::count_by(array('id' => $file_id)) > 0);
	}

	// ------------------------------------------------------------------------

	/**
	 * Tagged
	 *
	 * Selects files with any of the specified tags
	 * 
	 * @param	array|string	The tags to search by
	 * @return	array	
	 */
	public function get_tagged($tags)
	{
		// Make sure we have an array
		if (is_string($tags))
		{
			$tags = array_map('trim', explode('|', $tags));
		}

        // join keywords, filter by tags
        // group_by files.id to avoid duplicates files
		$this->db
			->join('keywords_applied', 'keywords_applied.hash = files.keywords')
			->join('keywords', 'keywords.id = keywords_applied.keyword_id')
			->where_in('keywords.name', $tags)
			->group_by('files.id');

		return $this->get_all();
	}
}

/* End of file file_m.php */
