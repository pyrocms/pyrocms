<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author 		Zack Kitzmiller - PyroCMS development team
 * @package		PyroCMS
 * @subpackage	Installer
 * @category	Application
 * @since 		v0.9.9.2
 *
 * Installer's Ajax controller.
 */
class Ajax extends Controller 
{

    public function __construct()
	{
		
		parent::__construct();
		$this->lang->load('global');
        $this->lang->load('step_1');
        
	}

    public function confirm_database() {
    
        $server     = $this->input->post('server');
        $username   = $this->input->post('username');
        $password   = $this->input->post('password');
        $port       = $this->input->post('port');
        
        $host = $server . ':' . $port;
        
        $link = @mysql_connect($host, $username, $password, TRUE);
        
        if ( ! $link )
        {
            $data['success'] = 'false';
            $data['message'] = lang('db_failure').mysql_error();
        } 
        else
        {
            $data['success'] = 'true';
            $data['message'] = lang('db_success');
        }
        
        echo json_encode($data);
        
    }

}

/* End of file installer.php */
/* Location: ./installer/controllers/installer.php */