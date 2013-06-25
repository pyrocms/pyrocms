<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_indexes extends CI_Migration
{

    public function up()
    {
					/*
					 * FILES
					 */
					if (!$this->has_key('file_folders', 'parent_id'))
					{
					    $this->db->query('ALTER TABLE ' . $this->db->dbprefix('file_folders') . ' ADD INDEX parent_id (`parent_id`)');
					}
				
					if (!$this->has_key('file_folders', 'slug'))
					{
					    $this->db->query('ALTER TABLE ' . $this->db->dbprefix('file_folders') . ' ADD INDEX slug (`slug`)');
					}
				
					if (!$this->has_key('files', 'folder_id'))
					{
					    $this->db->query('ALTER TABLE ' . $this->db->dbprefix('files') . ' ADD INDEX folder_id (`folder_id`)');
					}
				
					if (!$this->has_key('files', 'filename'))
					{
					    $this->db->query('ALTER TABLE ' . $this->db->dbprefix('files') . ' ADD INDEX filename (`filename`)');
					}
				
					if (!$this->has_key('files', 'type'))
					{
					    $this->db->query('ALTER TABLE ' . $this->db->dbprefix('files') . ' ADD INDEX type (`type`)');
					}
				
					if (!$this->has_key('files', 'extension'))
					{
					    $this->db->query('ALTER TABLE ' . $this->db->dbprefix('files') . ' ADD INDEX extension (`extension`)');
					}
				
				
					/*
					 * Streams
					 */
					if (!$this->has_key('data_fields', 'field_namespace'))
					{
					    $this->db->query('ALTER TABLE ' . $this->db->dbprefix('data_fields') . ' ADD INDEX field_namespace (`field_namespace`)');
					}
				
					if (!$this->has_key('data_fields', 'field_slug'))
					{
					    $this->db->query('ALTER TABLE ' . $this->db->dbprefix('data_fields') . ' ADD INDEX field_slug (`field_slug`)');
					}
				
					if (!$this->has_key('data_fields', 'field_type'))
					{
					    $this->db->query('ALTER TABLE ' . $this->db->dbprefix('data_fields') . ' ADD INDEX field_type (`field_type`)');
					}
				
				
					if (!$this->has_key('data_field_assignments', 'stream_id'))
					{
					    $this->db->query('ALTER TABLE ' . $this->db->dbprefix('data_field_assignments') . ' ADD INDEX stream_id (`stream_id`)');
					}
				
					if (!$this->has_key('data_field_assignments', 'field_id'))
					{
					    $this->db->query('ALTER TABLE ' . $this->db->dbprefix('data_field_assignments') . ' ADD INDEX field_id (`field_id`)');
					}
				
				
					if (!$this->has_key('data_streams', 'stream_slug'))
					{
					    $this->db->query('ALTER TABLE ' . $this->db->dbprefix('data_streams') . ' ADD INDEX stream_slug (`stream_slug`)');
					}
				
					if (!$this->has_key('data_streams', 'stream_namespace'))
					{
					    $this->db->query('ALTER TABLE ' . $this->db->dbprefix('data_streams') . ' ADD INDEX stream_namespace (`stream_namespace`)');
					}
    }

    public function down()
    {
					$this->db->query('ALTER TABLE ' . $this->db->dbprefix('file_folders') . ' DROP INDEX parent_id');
					$this->db->query('ALTER TABLE ' . $this->db->dbprefix('file_folders') . ' DROP INDEX slug');
				
					$this->db->query('ALTER TABLE ' . $this->db->dbprefix('files') . ' DROP INDEX folder_id');
					$this->db->query('ALTER TABLE ' . $this->db->dbprefix('files') . ' DROP INDEX filename');
					$this->db->query('ALTER TABLE ' . $this->db->dbprefix('files') . ' DROP INDEX type');
					$this->db->query('ALTER TABLE ' . $this->db->dbprefix('files') . ' DROP INDEX extension');
				
					$this->db->query('ALTER TABLE ' . $this->db->dbprefix('data_fields') . ' DROP INDEX field_namespace');
					$this->db->query('ALTER TABLE ' . $this->db->dbprefix('data_fields') . ' DROP INDEX field_slug');
					$this->db->query('ALTER TABLE ' . $this->db->dbprefix('data_fields') . ' DROP INDEX field_type');
				
					$this->db->query('ALTER TABLE ' . $this->db->dbprefix('data_field_assignments') . ' DROP INDEX stream_id');
					$this->db->query('ALTER TABLE ' . $this->db->dbprefix('data_field_assignments') . ' DROP INDEX field_id');
				
					$this->db->query('ALTER TABLE ' . $this->db->dbprefix('data_streams') . ' DROP INDEX stream_slug');
					$this->db->query('ALTER TABLE ' . $this->db->dbprefix('data_streams') . ' DROP INDEX stream_namespace');
	    }

    /**
     * Quick little function to 
     * check if a key has been added
     */
    public function has_key($table, $index)
    {
						$query = $this->db->query("SHOW INDEX FROM {$this->db->dbprefix($table)}");
					
						foreach ($query->result() as $row)
						{
						    if ($row->Key_name == $index)
						    {
										return true;
						    }
						}
					
						return false;
    }

}
