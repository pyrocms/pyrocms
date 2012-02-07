<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams API Library
 *
 * @package  	Streams API
 * @category  	Libraries
 * @author  	Parse19
 */

// --------------------------------------------------------------------------
 
/**
 * Streams Utilities Driver
 *
 * Functions to help out with common
 * utility tasks.
 *
 * @package  	Streams API
 * @category  	Drivers
 * @author  	Parse19
 */ 
 
class Streams_utilities extends CI_Driver {

	private $CI;

	/**
	 * Constructor
	 *
	 * @access	public
	 * @return	void
	 */
	function __construct()
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
	 * @access	public
	 * @param	string - namespace
	 * @return	bool
	 */
	function remove_namespace($namespace)
	{		
		// Get all the streams in this namespace and remove each one:
		$streams = $this->CI->streams_m->get_streams($namespace);
		
		if ( ! $streams) return NULL;
		
		foreach ($streams as $stream)
		{
			$this->CI->streams_m->delete_stream($stream);
		}
		
		// Remove all fields where
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
	 * @access	public
	 * @param	string - table slug
	 * @param	string - namespace
	 * @param	string - stream prefix
	 * @param	string - full stream name
	 * @param	[string - about the stream]
	 * @param	[string - title column]
	 * @param	[array - view options]
	 * @return	bool
	 */
	function convert_table_to_stream($table_slug, $namespace, $prefix, $stream_name, $about = NULL, $title_column = NULL, $view_options = array('id', 'created'))
	{
		// ----------------------------
		// Table data checks
		// ----------------------------

		// Does the table w/ the prefix exist?
		// If not, then forget it. We can't make a stream
		// out of a table that doesn't exist.
		if ( ! $this->CI->db->table_exists($prefix.$table_slug))
		{
			return FALSE;
		}
		
		// Maybe this table already exsits in our streams table?
		// If so we can't have that.
		if($this->CI->db
						->where('stream_slug', $table_slug)
						->where('stream_prefix', $prefix)
						->where('stream_namespace', $namespace)
						->get($this->CI->config->item('streams:streams_table'))
						->num_rows > 0)
		{
			return FALSE;
		}
		
		// We need an ID field to be able to make
		// a table into a stream.
		if ( ! $this->CI->db->field_exists('id', $prefix.$table_slug) )
		{
			return FALSE;
		}
		
		// ----------------------------
		// Add some fields to profiles
		// in prep for making it a stream
		// ----------------------------
		
		$this->CI->load->dbforge();

		// Created Field
		if ( ! $this->CI->db->field_exists('created', $prefix.$table_slug) )
		{
			$this->CI->dbforge->add_column($prefix.$table_slug, array('created' => array('type' => 'DATETIME', 'null' => TRUE)));
		}
	
		// Updated Field
		if ( ! $this->CI->db->field_exists('updated', $prefix.$table_slug) )
		{
			$this->CI->dbforge->add_column($prefix.$table_slug, array('updated' => array('type' => 'DATETIME', 'null' => TRUE)));
		}

		// Created_by Field
		if ( ! $this->CI->db->field_exists('created_by', $prefix.$table_slug) )
		{
			$this->CI->dbforge->add_column($prefix.$table_slug, array('created_by' => array('type' => 'INT', 'constraint' => 11, 'null' => TRUE)));
		}

		// Ordering_count Field
		if ( ! $this->CI->db->field_exists('ordering_count', $prefix.$table_slug) )
		{
			$this->CI->dbforge->add_column($prefix.$table_slug, array('ordering_count' => array('type' => 'INT', 'constraint' => 11, 'null' => TRUE)));
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
	 * @access	public
	 * @param	string - namespace
	 * @return	bool
	 */
	function convert_column_to_field($stream_slug, $namespace, $field_data, )
	{
		
	}

}