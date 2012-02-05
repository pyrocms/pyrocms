<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin controller for the api module
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\API\Controllers
 */
class Ajax extends Public_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		if ( ! $this->input->is_ajax_request())
		{
			exit('Trickery is afoot.');
		}
		
		$this->load->model('api_key_m');
		$this->load->config('rest');
	}
	
	public function generate_key()
	{
		if ( ! $this->current_user)
		{
			exit(json_encode(array('status' => false, 'error' => 'Log in')));
		}
				
		// Try and make the key, error on fail
		if ( ! ($api_key = $this->api_key_m->make_key($this->current_user->id)))
		{
			exit(json_encode(array('status' => false, 'error' => 'Could not create the key for some reason.')));
		}
		
		exit(json_encode(array('status' => true, 'api_key' => $api_key)));
	}

}

/* End of file admin.php */