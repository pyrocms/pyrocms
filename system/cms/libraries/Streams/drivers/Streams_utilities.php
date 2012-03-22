<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Streams Utilities Driver
 *
 * Functions to help out with common utility tasks.
 * 
 * @author  	Parse19
 * @package  	PyroCMS\Core\Libraries\Streams\Drivers
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
		
		if ( ! $streams) return null;
		
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
	function convert_table_to_stream($table_slug, $namespace, $prefix, $stream_name, $about = null, $title_column = null, $view_options = array('id', 'created'))
	{
		// ----------------------------
		// Table data checks
		// ----------------------------

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
						->get($this->CI->config->item('streams:streams_table'))
						->num_rows > 0)
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
	 * @access	public
	 * @param	string - namespace
	 * @return	bool
	 */
	function convert_column_to_field($stream_slug, $namespace, $field_name, $field_slug, $field_type, $extra = array(), $assign_data = array())
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

	// --------------------------------------------------------------------------

	/**
	 * Streams Config Export
	 *
	 * Builds and downloads a php config
	 * with your stream info.
	 *
	 * Useful when you want to build a structure
	 * that you want to run through Streams API and you'd rather
	 * build it somewhere and then export it. Or, you know,
	 * other uses
	 *
	 * @access 	public
	 * @param 	the stream
	 * @return  void
	 */
	public function config_export($stream_slug, $namespace)
	{
		$stream = $this->stream_obj($stream_slug, $namespace);
		
		if ( ! $stream) $this->log_error('invalid_stream', 'config_export');

		$CI = get_instance();

		$parser_data = array(
			'namespace'		=> $stream->stream_namespace,
			'stream_name'	=> $stream->stream_name,
			'stream_slug'	=> $stream->stream_slug,
			'about'			=> $stream->about,
			'prefix'		=> $stream->stream_prefix,
			'view_options'	=> $this->array_string($stream->view_options)
		);
	
		$assignments = $CI->fields_m->get_assignments_for_stream($stream->id);

		$array_string = null;

		foreach($assignments as $assign)
		{
			$array_string .= "
			array(
				'name'			=> '{$assign->field_name}',
				'slug'			=> '{$assign->field_slug}',
				'namespace'		=> '{$stream->stream_namespace}',
				'type'			=> '{$assign->field_type}',
				'extra'			=> {$this->array_string($assign->field_data)},
				'assign'		=> '{$stream->stream_slug}',
				'title_column'	=> '{$this->title_column($assign->field_slug, $stream->title_column)}',
				'required'		=> '{$this->true_false($assign->is_required)}',
				'unique'		=> '{$this->true_false($assign->is_unique)}'
			),
			";
		}

		$parser_data['fields'] = $array_string;

		$config_template = @file_get_contents(APPPATH.'modules/streams_core/views/fields_template.txt');

		if ( ! $config_template)
		{
			show_error('Count not find config template');
		}

		foreach($parser_data as $key => $value)
		{
			$config_template = str_replace('{'.$key.'}', $value, $config_template);
		}

		$CI->load->helper('download');
		force_download($stream->stream_slug.'_schema.php', $config_template);		
	}

	// --------------------------------------------------------------------------

	/**
	 * Convert an array to a PHP
	 * representation of an array
	 *
	 * @access 	private
	 * @param 	array
	 * @return 	string
	 */
	private function array_string($array)
	{
		$array = @unserialize($array);

		if ( ! is_array($array))
		{
			return 'array()';
		}

		$array = trim(print_r($array, true));
	
		$array{0} = strtolower($array{0});

		return $array;
	}

	// --------------------------------------------------------------------------

	/**
	 * Convert an array to a PHP
	 * representation of an array
	 *
	 * @access 	private
	 * @param 	array
	 * @return 	string
	 */
	private function title_column($field_slug, $title_column)
	{
		return ($field_slug == $title_column) ? 'true' : 'false';
	}

	// --------------------------------------------------------------------------

	/**
	 * Turns a yes/no string into a true/false
	 * string (not the boolean).
	 *
	 * Used for the config export.
	 *
	 * @access 	private
	 * @param 	array
	 * @return 	string
	 */
	private function true_false($var)
	{
		return ($var == 'yes') ? 'true' : 'false';
	}

}