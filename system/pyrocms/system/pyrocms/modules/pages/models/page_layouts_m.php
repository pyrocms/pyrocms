<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Page layout model
 * 
 * @author Phil Sturgeon - PyroCMS Dev Team
 * @package Pyrocms
 * @subpackage Pages module
 * @category Module
 * 
 */
class Page_layouts_m extends MY_Model
{
	
    /**
     * Create a new page layout
	 * 
	 * @access public
	 * @param array $input The input to insert into the DB
	 * @return mixed
	 * 
     */
    public function insert($input = array())
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
    public function update($id = 0, $input = array())
    {
        $this->load->helper('date');
        
        $input['updated_on'] = now();
        
        return parent::update($id, $input);
    }
}