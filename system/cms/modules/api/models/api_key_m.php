<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Api_key_m extends MY_Model
{
	public function get_active_key()
	{
		$row = $this->db
			->select('key')
			->join('users', 'api_keys.user_id = users.id')
			->where('users.active', 1)
			->order_by('date_created', 'desc')
			->limit(1)
			->get('api_keys')
			->row();
			
		return $row ? $row->key : NULL;
	}
	
	public function make_key($user_id)
	{
		$this->update_by('user_id', $user_id, array(
			'active' => false,
		));
		
		$this->insert(array(
			'user_id' => $user_id,
			'level' => 1,
			'active' => true,
			'key' => $key = $this->_generate_key(),
			'date_created' => time(),
		));
		
		return $key;
	}
	
	private function _generate_key()
	{
		do
		{
			$salt = do_hash(time().mt_rand());
			$new_key = substr($salt, 0, config_item('rest_key_length'));
		}

		// Already in the DB? Fail. Try again
		while ($this->count_by('key', $new_key));

		return $new_key;
	}
}