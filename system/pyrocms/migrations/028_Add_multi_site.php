<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_multi_site extends Migration {

	public function up()
	{
		// If run via the command line and cannot emulate a HTTP request, bitch and fail
		if (empty($_SERVER['SERVER_NAME']) and ! file_get_contents(site_url()))
		{
			exit('WARNING: You cannot make this request via the command line, please run migrations (by visiting the website) in a browser.');
		}
		
		$existing_tables = $this->db->list_tables();
		
		// Take "philsturgeon" from "www.philsturgeon.co.uk" 
		preg_match('/^((local|dev|qa|www)\.)?([a-z0-9-_]*)/i', $_SERVER['SERVER_NAME'], $matches);	
		$site_ref = empty($matches[3]) ? 'default' : str_replace('-', '_', $matches[3]);
		
		// This migration will be run for each site, so this ensures it's only run once.
		if ( ! in_array('core_sites', $existing_tables))
		{
			$this->db->query("
				CREATE TABLE `core_sites` (
				`id` INT( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
				`ref` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
				`domain` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
				`created_on` INT(11) NOT NULL default '0',
				`updated_on` INT(11) NOT NULL default '0',
				UNIQUE KEY `Unique ref` (`ref`),
				UNIQUE KEY `Unique domain` (`domain`),
				KEY `ref` (`ref`),
				KEY `domain` (`domain`)
				) ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_unicode_ci;
			");
			
			$this->db->query("INSERT INTO core_sites (ref, domain, created_on) VALUES (?, ?, ?);", array(
				$site_ref,
				preg_replace('/^www\./', '', $_SERVER['SERVER_NAME']),
				time(),
			));
			
			// Move uploads
			//mkdir('uploads/'.$site_ref);
			//rename('uploads/*', 'uploads/'.$site_ref.'/');
		}
		
		// Core users not set?
		if ( ! in_array('core_users', $existing_tables))
		{
			// Take all existing admins and make them "multisite admins"
			$this->db->query("CREATE TABLE core_users SELECT * FROM users WHERE group_id='1' ");
		
			foreach ($existing_tables as $table)
			{
				$this->db->query("RENAME TABLE {$table} TO {$site_ref}_{$table}");
			}
		}
	}

	public function down()
	{
		$this->db->query("DROP TABLE core_sites, core_users");
		
		// Take "philsturgeon" from "www.philsturgeon.co.uk" 
		preg_match('/^((local|dev|qa|www)\.)?([a-z0-9-_]*)/i', $_SERVER['SERVER_NAME'], $matches);	
		$site_ref = empty($matches[3]) ? 'default' : str_replace('-', '_', $matches[3]);
		
		foreach ($existing_tables as $table)
		{
			$this->db->query("RENAME TABLE _{$table} TO {$table}");
		}
		
		rename('uploads/'.$site_ref.'/', 'uploads/');
		unlink('uploads/'.$site_ref);
	}

}