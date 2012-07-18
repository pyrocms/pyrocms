<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Contact\Models
 */
class Contact_m extends MY_Model {
	
	public function get_log()
	{
		return $this->db
			->get('contact_log')
			->result();
	}
	
	public function insert_log($input)
	{		
		return $this->db->insert('contact_log', array(
			'email'			=> isset($input['email']) ? $input['email'] : '',
			'subject' 		=> substr($input['subject'], 0, 255),
			'message' 		=> $input['body'],
			'sender_agent' 	=> $input['sender_agent'],
			'sender_ip' 	=> $input['sender_ip'],
			'sender_os' 	=> $input['sender_os'],	
			'sent_at' 		=> time(),
			'attachments'	=> isset($input['attach']) ? implode('|', $input['attach']) : '',
		));
	}
}