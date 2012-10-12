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
		$return_files = array();
		$hashes = array();

		// while not as nice as straight queries this allows devs to select
		// files using their own complex where clauses and we then filter from there.
		$files = $this->get_all();

		if (is_string($tags))
		{
			$tags = array_map('trim', explode('|', $tags));
		}

		$this->db->select('keywords_applied.hash')
			->join('keywords_applied', 'keywords.id = keywords_applied.keyword_id');

		foreach ($tags as $tag)
		{
			$this->db->or_where('name', $tag);
		}

		$keywords = $this->db->get('keywords')
			->result();

		foreach ($keywords as $keyword)
		{
			$hashes[] = $keyword->hash;
		}

		// select the files
		foreach ($files as $file)
		{
			if (in_array($file->keywords, $hashes))
			{
				$return_files[] = $file;
			}
		}

		return $return_files;
	}
}

/* End of file file_m.php */