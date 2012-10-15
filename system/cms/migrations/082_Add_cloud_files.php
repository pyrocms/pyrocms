<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_cloud_files extends CI_Migration {

	public function up()
	{
		$this->load->model('files/file_m');

		$this->db->query(
				"INSERT INTO ".$this->db->dbprefix('settings')." (`slug`, `title`, `description`, `type`, `default`, `value`, `options`, `is_required`, `is_gui`, `module`, `order`) VALUES
					 ('files_enabled_providers', 'Enabled File Storage Providers', 'Which file storage providers do you want to enable? (If you enable a cloud provider you must provide valid auth keys below)', 'checkbox', '0', '0', 'amazon-s3=Amazon S3|rackspace-cf=Rackspace Cloud Files', '0', '1', 'files', '994'),
					 ('files_s3_access_key', 'Amazon S3 Access Key', 'To enable cloud file storage in your Amazon S3 account provide your Access Key. <a href=\"https://aws-portal.amazon.com/gp/aws/securityCredentials#access_credentials\">Find your credentials</a>', 'text', '', '', '', '0', '1', 'files', '993'),
					 ('files_s3_secret_key', 'Amazon S3 Secret Key', 'You also must provide your Amazon S3 Secret Key. You will find it at the same location as your Access Key in your Amazon account.', 'text', '', '', '', '0', '1', 'files', '992'),
					 ('files_s3_url', 'Amazon S3 URL', 'You may need to change this if using one of Amazon\'s UK locations.', 'text', 'http://{{ bucket }}.s3.amazonaws.com/', 'http://{{ bucket }}.s3.amazonaws.com/', '', '1', '1', 'files', '991'),
					 ('files_cf_username', 'Rackspace Cloud Files Username', 'To enable cloud file storage in your Rackspace Cloud Files account please enter your Cloud Files Username. <a href=\"https://manage.rackspacecloud.com/APIAccess.do\">Find your credentials</a>', 'text', '', '', '', '0', '1', 'files', '990'),
					 ('files_cf_api_key', 'Rackspace Cloud Files API Key', 'You also must provide your Cloud Files API Key. You will find it at the same location as your Username in your Rackspace account.', 'text', '', '', '', '0', '1', 'files', '989')
			");

		$this->dbforge->add_column('file_folders', array(
			'location' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => false,
				'default' => 'local'
			),
		));

		$this->dbforge->add_column('file_folders', array(
			'remote_container' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => false,
				'default' => ''
			),
		));

		$this->dbforge->add_column('files', array(
			'path' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => false,
				'default' => ''
			),
		));

		$this->dbforge->add_column('files', array(
			'download_count' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => false,
				'default' => 0
			),
		));

		// change some constraints
		$this->dbforge->modify_column('files', array(
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'default' => ''
			),
		));

		$this->dbforge->modify_column('files', array(
			'description' => array(
				'type' => 'TEXT'
			),
		));

		$this->dbforge->modify_column('files', array(
			'mimetype' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'default' => ''
			),
		));

		$this->dbforge->modify_column('file_folders', array(
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'default' => ''
			),
		));

		$files = $this->file_m->select('id, filename')->get_all();

		foreach ($files as $file) 
		{
			// build local paths so that we have a uniform style between local, amazon, and rackspace
			$this->file_m
				->where('type', 'i')
				->update($file->id, array('path' => '{{ url:site }}files/large/'.$file->filename));

			$this->file_m
				->where('type !=', 'i')
				->update($file->id, array('path' => '{{ url:site }}files/download/'.$file->id));
		}
	}

	public function down()
	{
		$this->db->where('slug', 'files_enabled_providers')->delete('settings');
		$this->db->where('slug', 'files_s3_access_key')->delete('settings');
		$this->db->where('slug', 'files_s3_secret_key')->delete('settings');
		$this->db->where('slug', 'files_s3_url')->delete('settings');
		$this->db->where('slug', 'files_cf_username')->delete('settings');
		$this->db->where('slug', 'files_cf_api_key')->delete('settings');

		$this->dbforge->drop_column('file_folders', 'location');
		$this->dbforge->drop_column('file_folders', 'remote_container');
		$this->dbforge->drop_column('files', 'path');
		$this->dbforge->drop_column('files', 'download_count');
	}
}