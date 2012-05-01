<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Fix_api_stream_view extends CI_Migration
{
	public function up()
	{
		// Set the custom view fields for this stream
		$this->db
			->set('view_options', serialize(array('id', 'key', 'user_id', 'level', 'created')))
			->where('stream_name', 'lang:api:api_keys')
			->update('data_streams');
	}

	public function down()
	{
		$this->db
			->set('view_options', null)
			->where('stream_name', 'lang:api:api_keys')
			->update('data_streams');
	}
}