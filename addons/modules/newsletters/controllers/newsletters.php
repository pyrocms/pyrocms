<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Newsletters Module - Create and manage newsletters
 *
 * @author 	PyroCMS Development Team
 * @package 	PyroCMS
 * @subpackage 	Newsletters
 * @category	Modules
 */
class Newsletters extends Public_Controller
{
	
	/**
	 * Constructor method
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::Public_Controller();
		$this->load->model('newsletters_m');
		$this->lang->load('newsletter');
	}
	
	/**
	 * List Active newsletters
	 *
	 * @access public
	 * @return void
	 */
	public function index()
	{
		$this->data->newsletters = $this->newsletters_m->getNewsletters(array('order'=>'created_on DESC'));
		$this->template->build('index', $this->data);
	}
	
	/**
	 * List archived newsletters
	 *
	 * @access public
	 * @return void
	 * @param $id the id of a newsletter
	 */
	public function archive($id = '')
	{
		$this->data->newsletter = $this->newsletters_m->getNewsletter($id);
		if ($this->data->newsletter)
		{
			$this->template->build('view', $this->data);
		}
		else
		{
			show_404();
		}
	}
	
	/**
	 * Subscribe to newsletters
	 *
	 * @access public
	 * @return void
	 */
	public function subscribe()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('email', lang('letter_email_label'), 'trim|required|valid_email');
		
		
		if ($this->form_validation->run())
		{
			if ($this->newsletters_m->subscribe($_POST))
			{
				redirect('newsletters/subscribed');
				return;
			}
			else
			{
				$this->session->set_flashdata(array('error'=> $this->lang->line('letter_add_mail_success')));
				redirect('');
				return;
			}
		}
		else
		{
			$this->session->set_flashdata(array('notice'=>$this->validation->error_string));
			redirect('');
			return;
		}
	}
	
	/**
	 * Successful subscription
	 * 
	 * @access public
	 * @return void
	 */
	public function subscribed()
	{
		$this->template->build('subscribed', $this->data);
	}
	
	/**
	 * Un-subscribe from newsletters
	 * 
	 * @access public
	 * @return void
	 * @param $email - the email address to remove from email list
	 */
	public function unsubscribe($email = '') 
	{
		
		if (!$email) redirect('');
		
		if ($this->newsletters_m->unsubscribe($email))
		{
			$this->session->set_flashdata(array('success'=> $this->lang->line('letter_delete_mail_success')));
			redirect('');
			return;
		}
		else
		{
			$this->session->set_flashdata(array('notice'=> $this->lang->line('letter_delete_mail_error')));
			redirect('');
			return;
		}
	}
}
?>