<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Newsletters_m extends Model
{
	var $emailFrom;
	
	// TODO: PJS Change emails table to newsletter_subscriptions
	function __construct()
	{
		parent::Model();
		$this->emailFrom = 'admin@madebyfresh.com';
	}
	
	function getNewsletters($params = array())
	{	
		if(isset($params['order'])) $this->db->order_by($params['order']);
		
		// Limit the results based on 1 number or 2 (2nd is offset)
		if(isset($params['limit']) && is_int($params['limit'])) $this->db->limit($params['limit']);
		elseif(isset($params['limit']) && is_array($params['limit'])) $this->db->limit($params['limit'][0], $params['limit'][1]);
		
		$query = $this->db->get('newsletters');
		if ($query->num_rows() == 0)
		{
			return FALSE;
		}
		else
		{
			return $query->result();
		}
	}
	
	function getNewsletter($id = '')
	{
		$query = $this->db->getwhere('newsletters', array('id'=>$id));
		if ($query->num_rows() == 0)
		{
			return FALSE;
		}
		else
		{
			return $query->row();
		}
	}
	
	function countNewsletters($params = array())
	{
		return $this->db->count_all_results('newsletters');
	}
	
	function newNewsletter($input = array())
	{	
		$this->load->helper('date');
		
		$this->db->insert('newsletters', array(
		'title'=>$input['title'],
		'body'=>$input['body'],
		'created_on'=>now()
		));
		
		return $this->db->insert_id();
	}
	
	function sendNewsletter($id)
	{
		$this->load->helper('date');	
		$this->load->library('email');
		$query = $this->db->get('emails');
		
		// Get the nesletter details
		$newsletter = $this->getNewsletter($id); 
		
		foreach ($query->result() as $recipient)
		{
		$this->email->clear();
		
		$this->email->from($this->emailFrom);
		$this->email->to($recipient->email);
		$this->email->subject($newsletter->title .' | '.$this->settings->item('site_name') .' '.$this->lang->line('letter_subject_suffix'));
		$this->email->message($newsletter->body);
		$this->email->send();
		}
		
		// TODO PJS Newsletter sending wont be good for large mailing lists, make it better.
		return $this->db->update('newsletters', array('sent_on'=>now()),array('id'=>$id));
	}
	
	function subscribe($input = array())
	{
		if ($input['btnSignup'])
		{
			$this->load->helper('date');		
			$email = $input['email'];
			
			if (!$this->checkEmail($email))
			{
				$this->db->insert('emails', array('email'=>$email, 'registered_on'=>now()));
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
	}
	
	function unsubscribe($email)
	{
		$this->db->delete('emails', array('email'=>$email));
		return TRUE;
	}
	
	function checkEmail($email)
	{
		$query = $this->db->getwhere('emails', array('email'=>$email));
		if ($query->num_rows() == 0)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
}
?>