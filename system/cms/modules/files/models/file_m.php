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
	 * @author	Eric Barnes <eric@pyrocms.com>
	 * @access	public
	 * @param	int		The file id
	 * @return	bool	If the file exists
	 */
	public function exists($file_id)
	{
		return (bool) (parent::count_by(array('id' => $file_id)) > 0);
	}
}

/* End of file file_m.php */