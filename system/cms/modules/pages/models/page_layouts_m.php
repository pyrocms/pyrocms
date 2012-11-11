<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Page layout model
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Pages\Models
 */
class Page_layouts_m extends MY_Model
{
	
    /**
     * Create a new page layout
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
     * Update a page layout
	 *
	 * @param int $id The ID of the page layout to update
	 * @param array $input The data to update
	 * @return mixed
     */
    public function update($id = 0, $input = array(), $skip_validation = false)
    {
        $this->load->helper('date');

        $input['updated_on'] = now();

        return parent::update($id, $input);
    }
    
    /**
     * Get the body class(es) for this layout
     * 
     * @param int (id of page layout)
     * @return string
     */
	public function get_body_class($id)
	{	
		return $this->db->get_where('page_layouts', array('id'=>$id))->row()->body_class;
	}
}