<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Email Templates Model
 * 
 * @author      Stephen Cozart - PyroCMS Dev Team
 * @package 	PyroCMS
 * @subpackage  Templates Module
 * @category	Module
 */
class Email_templates_m extends MY_Model {
    
    /**
     * Constructor method
     *
     * @access public
     * @return void
     */
    function __construct()
    {
        parent::__construct();
    }
    
    public function get_templates($slug = FALSE)
    {
        $results = parent::get_many_by('slug', $slug);
        $templates = array();
    
        if(!empty($results))
        {
            foreach($results as $template)
            {
                $templates[$template->lang] = $template; 
            }
        }
        
        return $templates;
    }
   
    /**
     * Delete a template only if it's not a default
     */
    public function delete_template($id = 0)
    {
        return $this->db->where('id', $id)
                    ->where('is_default <', 1)
                    ->delete($this->_table);
    }
   
    /**
     * Is Default
     */
    public function is_default($id = 0)
    {
		return parent::count_by(array(
			'id'			=> $id,
			'is_default >'	=> 0,
		)) > 0;
    }
}
/* End of file models/email_templates_m.php */