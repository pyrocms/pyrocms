<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin controller for the api module
 *
 * @author 		PyroCMS Dev Team
 * @package 	PyroCMS
 * @subpackage 	Api
 * @category	Modules
 */
class Admin extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->language('api');
	}
	
	/**
	 * Index method
	 *
	 * @return void
	 */
	public function index()
	{
		$this->load->model('api_log_m');
		$this->load->language('users/user');
		
		if ($this->db->table_exists('api_logs'))
		{
			$this->template->logs = $this->api_log_m->limit(10)->get_all();
		}
		
		$this->template
			->title($this->module_details['name'])
			->build('index');
	}
	
	public function ajax_set_api_status()
	{
		if ( ! $this->input->is_ajax_request())
		{
			exit('Trickery is afoot.');
		}
		
		// Are we enabling?
		if ($this->input->post('status') === "1")
		{
			$this->load->dbforge();
			
			// Check for api key table
			if ( ! $this->db->table_exists('api_keys'))
			{
				// Create API Keys
				$this->dbforge
					->add_field(array(
						'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
						'key' => array('type' => 'varchar', 'constraint' => 40),
						'level' => array('type' => 'int', 'constraint' => 2),
						'ignore_limits' => array('type' => 'tinyint', 'constraint' => 1, 'default' => 0),
						'user_id' => array('type' => 'int', 'constraint' => 11),
						'date_created' => array('type' => 'int', 'constraint' => 11),
						'active' => array('type' => 'tinyint', 'constraint' => 1),
					))
					// Make the key Primary (thats what true does)
					->add_key('id', true)
					// Make the key key an index
					->add_key('key')
					// Now build it!
					->create_table('api_keys');
			}
			
			// Check for logging table
			if ( ! $this->db->table_exists('api_logs'))
			{
				// Create Logging table
				$this->dbforge
					->add_field(array(
						'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
						'uri' => array('type' => 'varchar', 'constraint' => 255),
						'method' => array('type' => 'varchar', 'constraint' => 6),
						'params' => array('type' => 'text', 'null' => true),
						'api_key' => array('type' => 'varchar', 'constraint' => 40),
						'ip_address' => array('type' => 'varchar', 'constraint' => 15),
						'time' => array('type' => 'int', 'constraint' => 11),
						'authorized' => array('type' => 'tinyint', 'constraint' => 1),
					))
					// Make the key Primary (thats what true does)
					->add_key('id', true)
					// Make the api_key key an index
					->add_key('api_key')
					// Now build it!
					->create_table('api_logs');
			}
		}
		
		$status = (bool) (int) $this->input->post('status');
		
		// Update the setting
		Settings::set('api_enabled', $status);
		
		echo json_encode(array('status' => $status));
	}
	
	public function ajax_set_api_user_keys()
	{
		if ( ! $this->input->is_ajax_request())
		{
			exit('Trickery is afoot.');
		}
		
		$status = (bool) (int) $this->input->post('status');
		
		// Update the setting
		Settings::set('api_user_keys', $status);
		
		echo json_encode(array('status' => $status));
	}
}

/* End of file admin.php */