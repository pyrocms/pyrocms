<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Page type model
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Pages\Models
 */
class Page_type_m extends MY_Model
{
	
    /**
     * Create a new page type
	 *
	 * 
	 * @param array $input The input to insert into the DB
	 * @return mixed
	 *
     */
    public function insert($input = array(), $skip_validation = false)
    {
        $this->load->helper('date');

        $input['updated_on'] = now();

        return parent::insert($input);
    }

    /**
     * Update a page type
	 *
	 * @param int $id The ID of the page type to update
	 * @param array $input The data to update
	 * @return mixed
     */
    public function update($id = 0, $input = array(), $skip_validation = false)
    {
        $this->load->helper('date');

        $input['updated_on'] = now();

        return parent::update($id, $input);
    }
}