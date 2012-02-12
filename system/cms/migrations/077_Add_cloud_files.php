<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_cloud_files extends CI_Migration {

	public function up()
	{
		$this->db->query(
				"INSERT INTO ".$this->db->dbprefix('settings')." (`slug`, `title`, `description`, `type`, `default`, `value`, `options`, `is_required`, `is_gui`, `module`, `order`) VALUES
					 ('files_enabled_providers', 'Enabled File Storage Providers', 'Which file storage providers do you want to enable? (If you enable a cloud provider you must provide valid auth keys below)', 'checkbox', 'local', 'local', 'local=Local Filesystem|amazon-s3=Amazon S3|rackspace-cf=Rackspace Cloud Files', '1', '1', 'files', '994'),
					 ('files_s3_access_key', 'Amazon S3 Access Key', 'To enable cloud file storage in your Amazon S3 account provide your Access Key. <a href=\"https://aws-portal.amazon.com/gp/aws/securityCredentials#access_credentials\">Find your credentials</a>', 'text', '', '', '', '1', '1', 'files', '993'),
					 ('files_s3_secret_key', 'Amazon S3 Secret Key', 'You also must provide your Amazon S3 Secret Key. You will find it at the same location as your Access Key in your Amazon account.', 'text', '', '', '', '1', '1', 'files', '992'),
					 ('files_cf_username', 'Rackspace Cloud Files Username', 'To enable cloud file storage in your Rackspace Cloud Files account please enter your Cloud Files Username. <a href=\"https://manage.rackspacecloud.com/APIAccess.do\">Find your credentials</a>', 'text', '', '', '', '1', '1', 'files', '991'),
					 ('files_cf_api_key', 'Rackspace Cloud Files API Key', 'You also must provide your Cloud Files API Key. You will find it at the same location as your Username in your Rackspace account.', 'text', '', '', '', '1', '1', 'files', '990')
			");
	}

	public function down()
	{
		$this->db->where('slug', 'files_enabled_providers')->delete('settings');
		$this->db->where('slug', 'files_s3_access_key')->delete('settings');
		$this->db->where('slug', 'files_s3_secret_key')->delete('settings');
		$this->db->where('slug', 'files_cf_username')->delete('settings');
		$this->db->where('slug', 'files_cf_api_key')->delete('settings');
	}
}