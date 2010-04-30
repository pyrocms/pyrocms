<?php
/**
 * Messages Module
 *
 * @author Dan Horrigan
 */
class Messages_m extends MY_Model {


	public function get_messages($user_id, $offset, $per_page)
	{
		$this->db->where(array('to_id' => $user_id, 'in_trash' => 0));
		$this->db->order_by('sent DESC');

		return $this->db->get('messages', $per_page, $offset)->result();
	}

	public function count_messages($user_id)
	{
		return $this->count_by(array('to_id' => $user_id));
	}

}