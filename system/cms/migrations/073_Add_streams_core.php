<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_streams_core extends CI_Migration {

	public function up()
	{
		$this->load->config('streams_core/streams');

		// Go through our schema and make sure
		// all the tables are complete.
		foreach ($this->config->item('streams:schema') as $table_name => $schema)
		{
			// Case where table does not exist.
			// Add fields and keys.
			if( ! $this->db->table_exists($table_name))
			{
				$this->dbforge->add_field($schema['fields']);
	
				// Add keys
				if (isset($schema['keys']) and ! empty($schema['keys']))
				{
					$this->dbforge->add_key($schema['keys']);	
				}
	
				// Add primary key
				if(isset($schema['primary_key']))
				{
					$this->dbforge->add_key($schema['primary_key'], true);
				}
	
				$this->dbforge->create_table($table_name);
			}
			else
			{
				foreach ($schema['fields'] as $field_name => $field_data)
				{
					// If a field does not exist, then create it.
					if ( ! $this->db->field_exists($field_name, $table_name))
					{
						$this->dbforge->add_column($table_name, array($field_name => $field_data));	
					}
					else
					{
						// Okay, it exists, we are just going to modify it.
						// If the schema is the same it won't hurt it.
						$this->dbforge->modify_column($table_name, array($field_name => $field_data));
					}
				}
			}
		}
		
		// If we are upgrading to core for the first time,
		// let's set all the current streams and fields to the
		// streams namespace. They'll be blank if we are upgrading
		// for the first time.
		$this->db->query("UPDATE {$this->db->dbprefix($this->config->item('streams:streams_table'))} SET stream_namespace='streams', stream_prefix='str_' WHERE stream_namespace is null");
		$this->db->query("UPDATE {$this->db->dbprefix($this->config->item('streams:fields_table'))} SET field_namespace='streams' WHERE field_namespace is null");
	}

	public function down()
	{
	}
}