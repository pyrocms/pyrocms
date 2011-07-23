<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Updatedefaultprofilefields extends Migration {

	function up()
	{
		$this->migrations->verbose AND print "Update default profile fields to fix issue #251...";

		//can you set default to null with dbforge?
		$this->db->query('ALTER TABLE profiles MODIFY company varchar(100) DEFAULT NULL');
	}

	function down()
	{
	}
}