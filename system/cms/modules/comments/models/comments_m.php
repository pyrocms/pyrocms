<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Comments model
 *
 * @package		PyroCMS
 * @subpackage	Comments Module
 * @category	Models
 * @author		Phil Sturgeon - PyroCMS Dev Team
 */
class Comments_m extends MY_Model
{
    /**
     * Get a comment based on the ID
	 * @access public
	 * @param int $id The ID of the comment
	 * @return array
     */
  	public function get($id)
  	{
    	$this->db->select('c.*')
    		->select('IF(c.user_id > 0, IF(m.last_name = "", m.first_name, CONCAT(m.first_name, " ", m.last_name)), c.name) as name')
    		->select('IF(c.user_id > 0, u.email, c.email) as email')
    		->from('comments c')
    		->join('users u', 'c.user_id = u.id', 'left')
    		->join('profiles m', 'm.user_id = u.id', 'left')
    	
			// If there is a comment user id, make sure the user still exists
			->where('IF(c.user_id > 0, c.user_id = u.id, 1)')
    		->where('c.id', $id);
    	
    	return $this->db->get()->row();
  	}
  	
	/**
	 * Get recent comments
	 * 
	 * @access public
	 * @param int $limit The amount of comments to get
	 * @return array
	 */
  	public function get_recent($limit = 10)
  	{
		$this->_get_all_setup();
		
    	$this->db->order_by('c.created_on', 'desc');
    	
    	if ($limit > 0)
    	{
	    	$this->db->limit($limit);
    	}
    	
    	return $this->get_all();
  	}
  	
	/**
	 * Get something based on a module item
	 * 
	 * @access public
	 * @param string $module The name of the module
	 * @param int $ref_id The ID of the module
	 * @param int $is_active Is the module active?
	 * @return array
	 */
  	public function get_by_module_item($module, $ref_id, $is_active = 1)
  	{
		$this->_get_all_setup();
		
    	$this->db
    		->where('c.module', $module)
    		->where('c.module_id', $ref_id)
    		->where('c.is_active', $is_active)
    		->order_by('c.created_on', $this->settings->comment_order);
    	
	    return $this->get_all();
  	}
  	
	/**
	 * Get all comments
	 * 
	 * @access public
	 * @return array
	 */
  	public function get_all()
  	{
    	return parent::get_all();
  	}
	
	/**
	 * Insert a new comment
	 * 
	 * @access public
	 * @param array $input The data to insert
	 * @return void
	 */
	public function insert($input)
	{
		$this->load->helper('date');
		
		return parent::insert(array(
			'user_id'		=> isset($input['user_id']) 	? 	$input['user_id'] 									:  0,
			'is_active'		=> isset($input['is_active']) 	? 	$input['is_active'] 								:  0,
			'name'			=> isset($input['name']) 		? 	ucwords(strtolower(strip_tags($input['name']))) 	: '',
			'email'			=> isset($input['email']) 		? 	strtolower($input['email']) 						: '',
			'website'		=> isset($input['website']) 	? 	prep_url(strip_tags($input['website'])) 			: '',
			'comment'		=> htmlspecialchars($input['comment']),
			'module'		=> $input['module'],
			'module_id'		=> $input['module_id'],
			'created_on' 	=> now(),
			'ip_address'	=> $this->input->ip_address()
		));
	}
	
	/**
	 * Update an existing comment
	 * 
	 * @access public
	 * @param int $id The ID of the comment to update
	 * @param array $input The array containing the data to update
	 * @return void
	 */
	public function update($id, $input)
	{
  		$this->load->helper('date');
		
		return parent::update($id, array(
			'name'			=> isset($input['name']) 		? 	ucwords(strtolower(strip_tags($input['name']))) 	: '',
			'email'			=> isset($input['email']) 		? 	strtolower($input['email']) 						: '',
			'website'		=> isset($input['website']) 	? 	prep_url(strip_tags($input['website'])) 			: '',
			'comment'		=> htmlspecialchars($input['comment']),
		));
	}
	
	/**
	 * Approve a comment
	 * 
	 * @access public
	 * @param int $id The ID of the comment to approve
	 * @return mixed
	 */
	public function approve($id)
	{
		return parent::update($id, array('is_active' => 1));
	}
	
	/**
	 * Unapprove a comment
	 * 
	 * @access public
	 * @param int $id The ID of the comment to unapprove
	 * @return mixed
	 */
	public function unapprove($id)
	{
		return parent::update($id, array('is_active' => 0));
	}
	
	public function get_slugs()
	{
		$this->db->select('comments.module, modules.name')
						->distinct()
						->join('modules', 'comments.module = modules.slug', 'left');
		$slugs = parent::get_all();

		$options = array();
		
		if ( ! empty($slugs))
		{
			foreach($slugs as $slug)
			{
				if ( ! $slug->name && ($pos = strpos($slug->module, '-')) !== FALSE)
				{
					$slug->ori_module	= $slug->module;
					$slug->module		= substr($slug->module, 0, $pos);
				}

				if ( ! $slug->name && $module = $this->module_m->get_by('slug', plural($slug->module)))
				{
					$slug->name = $module->name;
				}

				//get the module name
				if ($slug->name AND $module_names = unserialize($slug->name))
				{
					if (array_key_exists(CURRENT_LANGUAGE, $module_names))
					{
						$slug->name = $module_names[CURRENT_LANGUAGE];
					}
					else
					{
						$slug->name = $module_names['en'];
					}

					if (isset($slug->ori_module))
					{
						$options[$slug->ori_module] = $slug->name . " ($slug->ori_module)";
					}
					else
					{
						$options[$slug->module] = $slug->name;
					}
				}
				else
				{
					if (isset($slug->ori_module))
					{
						$options[$slug->ori_module] = $slug->ori_module;
					}
					else
					{
						$options[$slug->module] = $slug->module;
					}
				}
			}
		}

		asort($options);

		return $options;
	}
	
	/**
	 * Setting up the query for the get* functions
	 */
	private function _get_all_setup()
	{
		$this->_table = NULL;
    	$this->db->select('c.*');
		$this->db->from('comments c');
    	$this->db->select('IF(c.user_id > 0, IF(m.last_name = "", m.first_name, CONCAT(m.first_name, " ", m.last_name)), c.name) as name');
    	$this->db->select('IF(c.user_id > 0, u.email, c.email) as email');

    	$this->db->join('users u', 'c.user_id = u.id', 'left');
    	$this->db->join('profiles m', 'm.user_id = u.id', 'left');
	}
}