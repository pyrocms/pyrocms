<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Api_log_m extends MY_Model
{
	public function get_all()
	{
		return $this->db
			->select('api_logs.*, user_id, users.username')
			->join('api_keys', 'api_keys.key = api_key','left')
			->join('users', 'api_keys.user_id = users.id', 'left')
			->order_by('time', 'desc')
			->get('api_logs')
			->result();
	}
}