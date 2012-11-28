<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Migration for adding the database component for a new
 * feature: hidden streams. These are useful for streams
 * that are created for field types like the grid field type that
 * need to be used for internal purposes but also within a 
 * certain namespace.
 */
class Migration_Add_hidden_stream_option extends CI_Migration
{
	public function up()
	{
		$this->load->config('streams_core/streams');

		if ( ! $this->db->field_exists('is_hidden', $this->config->item('streams:streams_table')))
		{
			$this->dbforge->add_column($this->config->item('streams:streams_table'), array(
			    'is_hidden' => array(
					'type' => 'ENUM',
					'constraint' => array('yes', 'no'),
					'default' => 'no'
				)
			));
		}
	}

	public function down()
	{
		$this->load->config('streams_core/streams');
		if ( $this->db->field_exists('is_hidden', $this->config->item('streams:streams_table')))
		$this->dbforge->drop_column($this->config->item('streams:streams_table'), 'is_hidden');
	}
}