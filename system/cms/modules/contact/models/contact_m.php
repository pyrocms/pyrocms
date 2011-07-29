<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 * @author 		PyroCMS Dev Team
 * @package 	PyroCMS
 * @subpackage 	Contact
 * @category 	Module
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
			'name' => $input['name'],
			'email' => $input['email'],
			'subject' => $input['subject'],
			'message' => $input['message'],
			'company_name' => $input['company_name'],
			'sender_agent' => $input['sender_agent'],
			'sender_ip' => $input['sender_ip'],
			'sender_os' => $input['sender_os'],	
			'sent_at' => time(),
		));
	}
}