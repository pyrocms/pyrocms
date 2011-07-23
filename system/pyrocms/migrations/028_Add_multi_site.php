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
		
		// This migration will be run for each site, so this check ensures that the following tables are only added once.
		if ( ! in_array('core_settings', $existing_tables))
		{
			$this->db->query("
				CREATE TABLE core_settings(
				`slug` varchar( 30 ) COLLATE utf8_unicode_ci NOT NULL ,
				`value` varchar( 255 ) COLLATE utf8_unicode_ci NOT NULL ,
				`default` varchar( 255 ) COLLATE utf8_unicode_ci NOT NULL ,
				PRIMARY KEY ( `slug` ) ,
				UNIQUE KEY `unique - slug` ( `slug` ) ,
				KEY `index - slug` ( `slug` )
				) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;							 
			");
			
			$this->db->query("
				INSERT INTO `core_settings` (`slug`, `value`, `default`)
				VALUES ('date_format', 'g:ia -- m/d/y', 'g:ia -- m/d/y'), ('lang_direction', 'ltr', 'ltr');
			");
		}
		
		// no core_users yet?
		if ( ! in_array('core_sites', $existing_tables))
		{
			$this->db->query("
				CREATE TABLE `core_sites` (
				`id` INT( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
				`name` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
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
			
			$this->db->query("INSERT INTO core_sites (name, ref, domain, created_on) VALUES ('Default', ?, ?, ?);", array(
				'default',
				SITE_SLUG,
				time(),
			));
			
			$this->load->helper('file');
			
			// create the site's cache folder
			is_dir(APPPATH.'cache/default/simplepie') OR mkdir(APPPATH.'cache/default/simplepie', DIR_READ_MODE, TRUE);
			
			// Move uploads			
			is_dir('uploads/default') OR $this->_move('uploads', 'uploads/default', 'default');
			
			// Create site specific addon folder and move them
			is_dir('addons/default') OR $this->_move('addons', 'addons/default', 'default');
			
			// create the site specific addon folder if it didn't get created yet
			is_dir('addons/default/modules') OR mkdir('addons/default/modules', DIR_READ_MODE, TRUE);
			is_dir('addons/default/themes') OR mkdir('addons/default/themes', DIR_READ_MODE, TRUE);
			is_dir('addons/default/widgets') OR mkdir('addons/default/widgets', DIR_READ_MODE, TRUE);
			
			// create the site specific upload folder if it didn't get created yet
			is_dir(FCPATH.'uploads/default') OR mkdir(FCPATH.'uploads/default', DIR_WRITE_MODE, TRUE);
			
			//insert empty html files
			write_file(APPPATH.'cache/default/simplepie/index.html','');
			write_file('addons/default/modules/index.html','');
			write_file('addons/default/themes/index.html','');
			write_file('addons/default/widgets/index.html','');
			write_file(FCPATH.'uploads/index.html','');
		
		}
		
		// Core users not set?
		if ( ! in_array('core_users', $existing_tables))
		{
			// Take all existing admins and make them "multisite admins"
			$this->db->query("CREATE TABLE core_users SELECT * FROM users WHERE group_id='1' ");
		
			foreach ($existing_tables as $table)
			{
				$this->db->query("RENAME TABLE {$table} TO default_{$table}");
			}
			
			// since theme_options is added by a migration it is missing from $existing_tables array
			if ( ! $this->db->table_exists('theme_options') )
			{
				$this->db->query("RENAME TABLE theme_options TO default_theme_options");
			}
		}
		
		// set the db prefix for the rest of the migrations
		$this->db->set_dbprefix(SITE_REF.'_');
	}

	public function down()
	{
		$this->db->query("DROP TABLE core_sites, core_users, core_settings");
		
		foreach ($existing_tables as $table)
		{
			$this->db->query("RENAME TABLE _{$table} TO {$table}");
		}
		
		if ($this->_move('uploads/default/', 'uploads/', NULL))
		{
			unlink('uploads/default');
		}
		
		if ($this->_move('addons/default/', 'addons/', NULL))
		{
			unlink('addons/default');
		}
	}
	
	/**
	 * Move the uploads folder
	 */
	private function _move( $path, $dest, $site_ref )
	{
		if ( is_dir($path) )
		{
			$objects = scandir($path);
			
			@mkdir($dest, 0777, TRUE);
			
			$skip = array('.', '..', $site_ref, 'shared_addons');
			
			if( sizeof($objects) > 0 )
			{
				foreach( $objects AS $file )
				{
					if( in_array($file, $skip) ) continue;

					if( is_dir( $path.'/'.$file ) )
					{
						if ($this->_move( $path.'/'.$file, $dest.'/'.$file, $site_ref ))
						{
							@rmdir($path.'/'.$file);
						}
					}
					else
					{
						if (copy( $path.'/'.$file, $dest.'/'.$file ))
						{
							@unlink($path.'/'.$file);
						}
					}
				}
			}
			return TRUE;
		}
		elseif ( is_file($path) )
		{
			return copy($path, $dest);
		}
		else
		{
			return FALSE;
		}
	}
}