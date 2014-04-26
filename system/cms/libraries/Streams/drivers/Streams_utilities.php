<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Streams Utilities Driver
 *
 * Functions to help out with common utility tasks.
 * 
 * @package		PyroStreams
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2011 - 2013, PyroCMS
 */ 
 
class Streams_utilities extends CI_Driver {

	/**
	 * The CodeIgniter instance
	 *
	 * @var object 
	 */
	private $CI;

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		$this->CI =& get_instance();
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Remove Namespace
	 *
	 * Performs all uninstall actions for a specific
	 * namespace.
	 *
	 * @param	string - namespace
	 * @return	bool
	 */
	public function remove_namespace($namespace)
	{
		// Some field destructs use stream data from the cache,
		// so let's make sure that the slug cache has run.
		$this->CI->streams_m->run_slug_cache();

		// Get all the streams in this namespace and remove each one:
		$streams = $this->CI->streams_m->get_streams($namespace);
		
		if ( ! $streams) return null;
		
		foreach ($streams as $stream)
		{
			$this->CI->streams_m->delete_stream($stream);
		}
		
		// Remove all fields in namespace
		$this->CI->db->where('field_namespace', $namespace)->delete(FIELDS_TABLE);
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Convert table to stream.
	 *
	 * Note: this does NOT handle fields
	 * at this time. This must be done manually.
	 *
	 * We are trying not to make a lot of assumptions
	 * in this function, lest we get anything else
	 * in the database messed up.
 	 *
	 * @param	string - table slug
	 * @param	string - namespace
	 * @param	string - stream prefix
	 * @param	string - full stream name
	 * @param	[string - about the stream]
	 * @param	[string - title column]
	 * @param	[array - view options]
	 * @return	bool
	 */
	public function convert_table_to_stream($table_slug, $namespace, $prefix, $stream_name, $about = null, $title_column = null, $view_options = array('id', 'created'))
	{
		// ----------------------------
		// Table data checks
		// ----------------------------

		// Thanks to CodeIgniter's results caching any tables created after 
		// table_exists() or list_tables() are called will not be included in 
		// subsequent calls to table_exists() or list_tables() unless we clear the cache
		$this->CI->db->data_cache = array();

		// Does the table w/ the prefix exist?
		// If not, then forget it. We can't make a stream
		// out of a table that doesn't exist.
		if ( ! $this->CI->db->table_exists($prefix.$table_slug))
		{
			return false;
		}
		
		// Maybe this table already exsits in our streams table?
		// If so we can't have that.
		if($this->CI->db
			->where('stream_slug', $table_slug)
			->where('stream_prefix', $prefix)
			->where('stream_namespace', $namespace)
			->count_all_results($this->CI->config->item('streams:streams_table')) > 0)
		{
			return false;
		}
		
		// We need an ID field to be able to make
		// a table into a stream.
		if ( ! $this->CI->db->field_exists('id', $prefix.$table_slug) )
		{
			return false;
		}
		
		// ----------------------------
		// Add some fields to profiles
		// in prep for making it a stream
		// ----------------------------
		
		$this->CI->load->dbforge();

		// Created Field
		if ( ! $this->CI->db->field_exists('created', $prefix.$table_slug) )
		{
			$this->CI->dbforge->add_column($prefix.$table_slug, array('created' => array('type' => 'DATETIME', 'null' => true)));
		}
	
		// Updated Field
		if ( ! $this->CI->db->field_exists('updated', $prefix.$table_slug) )
		{
			$this->CI->dbforge->add_column($prefix.$table_slug, array('updated' => array('type' => 'DATETIME', 'null' => true)));
		}

		// Created_by Field
		if ( ! $this->CI->db->field_exists('created_by', $prefix.$table_slug) )
		{
			$this->CI->dbforge->add_column($prefix.$table_slug, array('created_by' => array('type' => 'INT', 'constraint' => 11, 'null' => true)));
		}

		// Ordering_count Field
		if ( ! $this->CI->db->field_exists('ordering_count', $prefix.$table_slug) )
		{
			$this->CI->dbforge->add_column($prefix.$table_slug, array('ordering_count' => array('type' => 'INT', 'constraint' => 11, 'null' => true)));
		}

		// ----------------------------
		// Order The Columns
		// ----------------------------

		$this->CI->db->query("ALTER TABLE {$this->CI->db->dbprefix($prefix.$table_slug)} MODIFY COLUMN created DATETIME AFTER id");
		$this->CI->db->query("ALTER TABLE {$this->CI->db->dbprefix($prefix.$table_slug)} MODIFY COLUMN updated DATETIME AFTER created");
		$this->CI->db->query("ALTER TABLE {$this->CI->db->dbprefix($prefix.$table_slug)} MODIFY COLUMN created_by INT AFTER updated");
		$this->CI->db->query("ALTER TABLE {$this->CI->db->dbprefix($prefix.$table_slug)} MODIFY COLUMN ordering_count INT AFTER created_by");

		// ----------------------------
		// Add to stream table
		// ----------------------------
		
		$insert_data = array(
			'stream_name'		=> $stream_name,
			'stream_namespace'	=> $namespace,
			'stream_prefix' 	=> $prefix,
			'stream_slug'		=> $table_slug,
			'about'				=> $about,
			'title_column'		=> $title_column,
			'sorting'			=> 'title',
			'view_options'		=> serialize($view_options)
		);
	
		return $this->CI->db->insert($this->CI->config->item('streams:streams_table'), $insert_data);
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Field to Stream Frield
	 *
	 * Allows you to take a column in a stream table
	 * and turn it into a stream field.
	 *
	 * @param	string - namespace
	 * @return	bool
	 */
	public function convert_column_to_field($stream_slug, $namespace, $field_name, $field_slug, $field_type, $extra = array(), $assign_data = array())
	{
		// Get the stream
		if ( ! $stream = $this->stream_obj($stream_slug, $namespace))
		{
			$this->log_error('invalid_stream', 'convert_column_to_field');
			return false;
		}
	
		// Make sure this column actually exists.
		if ( ! $this->CI->db->field_exists($field_slug, $stream->stream_prefix.$stream->stream_slug))
		{
			$this->log_error('no_column', 'convert_column_to_field');
			return false;
		}
		
		// Maybe we already added this?
		if ($this->CI->db
					->limit(1)
					->where('field_slug', $field_slug)
					->where('field_namespace', $namespace)
					->get(FIELDS_TABLE)
					->num_rows() == 1)
		{
			return false;
		}
		
		// If it does, we are in business! Let's add the field
		// metadata + the field assignment

		// ----------------------------
		// Add Field Metadata
		// ----------------------------

		if ( ! isset($extra) or ! is_array($extra)) $extra = array();

		if ( ! $this->CI->fields_m->insert_field($field_name, $field_slug, $field_type, $namespace, $extra)) return false;
		
		$field_id = $this->CI->db->insert_id();

		// ----------------------------
		// Add Assignment
		// ----------------------------

		$data = array();
		extract($assign_data);
	
		// Title column
		if (isset($title_column) and $title_column === true)
		{
			$data['title_column'] = 'yes';
		}

		// Instructions
		$data['instructions'] = (isset($instructions) and $instructions != '') ? $instructions : null;
		
		// Is Unique
		if (isset($unique) and $unique === true)
		{
			$data['is_unique'] = 'yes';
		}
		
		// Is Required
		if (isset($required) and $required === true)
		{
			$data['is_required'] = 'yes';
		}
	
		// Add actual assignment
		// The 4th parameter is to stop the column from being
		// created, since we already did that.
		return $this->CI->streams_m->add_field_to_stream($field_id, $stream->id, $data, false);
	}

}