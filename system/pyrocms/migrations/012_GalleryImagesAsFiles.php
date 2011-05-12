<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Galleryimagesasfiles extends Migration {

	function up()
	{
		$this->db->query("
			ALTER TABLE `galleries`
				ADD `folder_id` int(11) NOT NULL AFTER slug");
		
		$this->db->query("
			ALTER TABLE `galleries`
				DROP `parent`");

		$this->db->query("
			ALTER TABLE `gallery_images`
				ADD `file_id` TEXT NULL AFTER id");

		$this->db->query("
			ALTER TABLE `gallery_images`
				DROP `filename`");

		$this->db->query("
			ALTER TABLE `gallery_images`
				DROP `extension`");

		$this->db->query("
			ALTER TABLE `gallery_images`
				DROP `description`");

		$this->db->query("
			ALTER TABLE `gallery_images`
				DROP `uploaded_on`");

		$this->db->query("
			ALTER TABLE `gallery_images`
				DROP `updated_on`");
	}

	function down()
	{
	}
}