<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Variables model
 * 
 * @author		PyroCMS Dev Team
 * @package		PyroCMS
 * @subpackage	Variables module
 * @category	Modules
 */

class Variables_m extends MY_Model
{
	/**
	 * Insert
	 *
     * @access	public
	 * @param	array	$input
	 * @return	mixed
	 */
    public function insert($input = array())
    {
    	return parent::insert(array(
    		'name' => $input['name'],
    		'data' => $input['data']
        ));
    }

	/**
	 * Update
	 *
     * @access	public
	 * @param	id		$id
	 * @param	array	$input
	 * @return	mixed
	 */
    public function update($id, $input = array())
    {
        return parent::update($id, array(
			'name'	=> $input['name'],
			'data'	=> $input['data']
		));
    }

	/**
	 * Check name
	 *
     * @access	public
	 * @param	string	$name
	 * @param	id		$id
	 * @return	bool
	 */
    public function check_name($name = '', $id = 0)
    {
    	return (int) parent::count_by(array(
			'id !='	=>	$id,
			'name'	=>	$name
		)) > 0;
    }
}

/* End of file variables_m.php */