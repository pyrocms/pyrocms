<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Upgrade to PyroStreams
 *
 * This takes into account the fact the user may already
 * have PyroStreams installed on their copy of PyroCMS.
 */
class Migration_Add_streams extends CI_Migration {

	public function up()
	{
		$this->load->helper('date');
		
		// If they don't have the streams module theres not much point in trying this
		// (Probably means its community not professional, but who knows)
		if ( ! file_exists(APPPATH.'modules/streams/config/streams.php'))
		{
			return;
		}
		
		include APPPATH.'modules/streams/config/streams.php';
		
		$obj = $this->db->limit(1)->where('slug', 'streams')->get('modules');
		
		if ($obj->num_rows() == 0)
		{
			// No streams entry in the modules table, so let's
			// add it. This would happen by going to Add-ons, but
			// why make the user go through the extra setp
			require_once(APPPATH.'modules/streams/details.php');
			
			if(!class_exists('Module_streams')) return false;
			
			$details = new Module_streams();
			
			// Get some info for the db
			$module = $details->info();
	
			// Now lets set some details ourselves
			$module['slug']			= 'streams';
			$module['version']		= $details->version;
			$module['enabled']		= 1;
			$module['installed']	= 1;
			$module['is_core']		= 1;
	
			$this->db->insert('modules', array(
				'name'			=> serialize($module['name']),
				'slug'			=> $module['slug'],
				'version'		=> $module['version'],
				'description'	=> serialize($module['description']),
				'skip_xss'		=> ! empty($module['skip_xss']),
				'is_frontend'	=> ! empty($module['frontend']),
				'is_backend'	=> ! empty($module['backend']),
				'menu'			=> ! empty($module['menu']) ? $module['menu'] : false,
				'enabled'		=> ! empty($module['enabled']),
				'installed'		=> ! empty($module['installed']),
				'is_core'		=> ! empty($module['is_core']),
				'updated_on'	=> now()
			));
		}
		
		// Add the streams tables if they don't exist already
		
		if ( ! $this->db->table_exists($config['streams.streams_table'])):
		
			$this->db->query("
			CREATE TABLE `".$this->db->dbprefix($config['streams.streams_table'])."` (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `stream_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
			  `stream_slug` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
			  `about` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `view_options` blob NOT NULL,
			  `title_column` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
			  `sorting` enum('title','custom') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'title',
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
			");
		
		endif;

		if ( ! $this->db->table_exists($config['streams.fields_table'])):
		
			$this->db->query("
			CREATE TABLE `".$this->db->dbprefix($config['streams.fields_table'])."` (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `field_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
			  `field_slug` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
			  `field_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
			  `field_data` blob,
			  `view_options` blob,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
		
		endif;

		if ( ! $this->db->table_exists($config['streams.assignments_table'])):
		
			$this->db->query("
			CREATE TABLE `".$this->db->dbprefix($config['streams.assignments_table'])."` (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `sort_order` int(11) NOT NULL,
			  `stream_id` int(11) NOT NULL,
			  `field_id` int(11) NOT NULL,
			  `is_required` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
			  `is_unique` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
			  `instructions` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
			  `field_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
		
		endif;

		if ( ! $this->db->table_exists($config['streams.searches_table'])):
		
			$this->db->query("
			CREATE TABLE `".$this->db->dbprefix($config['streams.searches_table'])."` (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `search_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `search_term` text COLLATE utf8_unicode_ci NOT NULL,
			  `ip_address` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
			  `total_results` int(11) NOT NULL,
			  `query_string` longtext COLLATE utf8_unicode_ci NOT NULL,
			  `stream_slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
			
		endif;
		
		return true;
	}

	public function down()
	{
		// They should have the core version if we are going 
		// to go about removing all of their streams and data here
		// in the down function
		if ( ! file_exists(APPPATH.'modules/streams/config/streams.php'))
		{
			return;
		}

		require_once(APPPATH.'modules/streams/config/streams.php');

		$this->load->dbforge();
		
		$streams = $this->db->get($config['streams.streams_table'])->result();
		
		foreach( $streams as $stream ):
		
			$this->dbforge->drop_table($config['stream_prefix'].$stream->stream_slug);
		
		endforeach;
		
		// Drop the other tables
		$this->dbforge->drop_table($config['streams.streams_table']);
		$this->dbforge->drop_table($config['streams.fields_table']);
		$this->dbforge->drop_table($config['streams.assignments_table']);
		$this->dbforge->drop_table($config['streams.searches_table']);
	}
}