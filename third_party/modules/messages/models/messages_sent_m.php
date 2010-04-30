<?php
/**
 * Messages Sent Module
 *
 * @author Dan Horrigan
 */
class Messages_sent_m extends MY_Model {
	
	protected $table = 'messages_sent';

	public function get_messages($user_id, $offset, $per_page)
	{
		$this->db->where(array('from_id' => $user_id, 'in_trash' => 0));
		$this->db->order_by('sent DESC');

		return $this->db->get('messages_sent', $per_page, $offset)->result();
	}

	public function count_messages($user_id)
	{
		return $this->count_by(array('from_id' => $user_id, 'in_trash' => 0));
	}

}