<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Streams Model
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Models
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Streams_m extends MY_Model {

	public $table;

    // --------------------------------------------------------------------------
    // Caches
    // --------------------------------------------------------------------------
    // This is data stored in the class at runtime
    // and saved/checked so we don't keep going back to
    // the database.
    // --------------------------------------------------------------------------
	
	/**
	 * Stream fields cache.
	 * Stored by id ie array('id'=>data)
	 */
	public $stream_fields_cache = array();
	
	/**
	 * Streams cache
	 * Stored by slug
	 */
	public $streams_cache = array();

    // --------------------------------------------------------------------------

	/**
	 * Streams Validation
	 */
	public $streams_validation = array(
		array(
			'field'	=> 'stream_name',
			'label' => 'lang:streams.stream_name',
			'rules'	=> 'trim|required|max_length[60]'
		),
		array(
			'field'	=> 'stream_slug',
			'label' => 'lang:streams.stream_slug',
			'rules'	=> 'trim|required|max_length[60]|slug_safe'
		),
		array(
			'field'	=> 'stream_prefix',
			'label' => 'lang:streams:stream_prefix',
			'rules'	=> 'trim|max_length[60]'
		),
		array(
			'field'	=> 'about',
			'label' => 'lang:streams.about_stream',
			'rules'	=> 'trim|max_length[255]'
		)
	);
	
    // --------------------------------------------------------------------------

	public function __construct()
	{
		$this->table = STREAMS_TABLE;
		
		// We just grab all the streams now.
		// That way we don't have to do a separate DB
		// call for each.
		$this->run_cache();
	}

    // --------------------------------------------------------------------------

	/**
	 * Run Slug Cache
	 *
	 * This function can be used in the case where you need
	 * to make sure that all streams data is in the cache.
	 *
	 * @access 	public
	 * @return 	void
	 */
	public function run_slug_cache()
	{
		$this->run_cache();
	}

    // --------------------------------------------------------------------------

	/**
	 * Run Cache
	 *
	 * Puts streams data into cache to reduce
	 * database load.
	 *
	 * @access 	private
	 * @param 	string - type 'id' or 'slug'
	 * @return 	void
	 */
	private function run_cache()
	{		
		foreach($this->db->get($this->table)->result() as $stream)
		{
			if (trim($stream->view_options) == '')
			{
				$stream->view_options = array();
			}
			else
			{
				$stream->view_options = unserialize($stream->view_options);
				
				// Just in case we get bad data
				if ( ! is_array($stream->view_options))
				{
					$stream->view_options = array();
				}
			}

			$this->streams_cache[$stream->id] = $stream;	
			$this->streams_cache['ns'][$stream->stream_namespace][$stream->stream_slug] = $stream;
		}

	}
    
    // --------------------------------------------------------------------------
    
    /**
     * Get streams
     *
     * @access	public
     * @param	string - the stream namespace
     * @param	[int limit]
     * @param	[int offset]
     * @return	obj
     */
    public function get_streams($namespace, $limit = null, $offset = 0)
	{
		if ($limit) $this->db->limit($limit, $offset);
	
		$obj = $this->db
				->where('stream_namespace', $namespace)
				->order_by('stream_name', 'ASC')
				->get($this->table);
				
		if ($obj->num_rows() == 0)
		{
			return false;
		}
		
		$streams = $obj->result();
		
		// Go through and unserialize all the view_options
		foreach ($streams as $key => $stream)
		{
			$streams[$key]->view_options = unserialize($streams[$key]->view_options);
		}

		return $streams;
	}

    // --------------------------------------------------------------------------
    
    /**
     * Count total streams
     *
     * @access	public
     * @param	[mixed - provide a namespace string to restrict total]
     * @return	int
     */
	public function total_streams($namespace = null)
	{
		$where = ($namespace) ? "WHERE stream_namespace='$namespace'" : null;
	
		$result = $this->db->query("SELECT COUNT(*) as total FROM {$this->db->dbprefix($this->table)} $where")->row();
	
    	return $result->total;
	}

    // --------------------------------------------------------------------------

	/**
	 * Count entries in a stream
	 *
	 * @access	public
	 * @param	string - stream slug
	 * @param	string - stream namespace
	 * @return	int
	 */
	public function count_stream_entries($stream_slug, $namespace)
	{
		$stream = $this->get_stream($stream_slug, true, $namespace);
	
		return $this->db->count_all($stream->stream_prefix.$stream->stream_slug);
	}

    // --------------------------------------------------------------------------

	/**
	 * Create a new stream
	 *
	 * @access	public
	 * @param	string - name of the stream
	 * @param	string - stream slug
	 * @param	string - stream prefix
	 * @param	string - stream namespace
	 * @param	[string - about the stream]
	 * @param 	[array - extra data]
	 * @return	false or stream id
	 */
	public function create_new_stream($stream_name, $stream_slug, $prefix, $namespace, $about = null, $extra = array())
	{	
		// See if table exists. You never know if it sneaked past validation
		if ($this->db->table_exists($prefix.$stream_slug)) return false;
			
		// Create the db table
		$this->load->dbforge();
		
		$this->dbforge->add_field('id');
		
		// Add in our standard fields		
		$standard_fields = array(
	        'created' 			=> array('type' => 'DATETIME'),
            'updated'	 		=> array('type' => 'DATETIME', 'null' => true),
            'created_by'		=> array('type' => 'INT', 'constraint' => '11', 'null' => true),
            'ordering_count'	=> array('type' => 'INT', 'constraint' => '11', 'null' => true)
		);
		
		$this->dbforge->add_field($standard_fields);
		
		if ( ! $this->dbforge->create_table($prefix.$stream_slug) ) return false;
		
		// Add data into the streams table
		$insert_data['stream_slug']			= $stream_slug;
		$insert_data['stream_name']			= $stream_name;
		$insert_data['stream_prefix']		= $prefix;
		$insert_data['stream_namespace']	= $namespace;
		$insert_data['about']				= $about;

		// Our extra columns, coming from the $extra array.
		$insert_data['title_column']		= (isset($extra['title_column'])) ? $extra['title_column'] : null;
		$insert_data['is_hidden']			= (isset($extra['is_hidden'])) ? $extra['is_hidden'] : 'no';
		$insert_data['sorting']				= (isset($extra['sorting'])) ? $extra['sorting'] : 'title';
		$insert_data['menu_path']			= (isset($extra['menu_path'])) ? $extra['menu_path'] : null;

		// Extra enum data checks
		if ($insert_data['is_hidden'] != 'yes' and $insert_data['is_hidden'] != 'no')
		{
			$insert_data['is_hidden'] = 'no';
		}

		if ($insert_data['sorting'] != 'title' and $insert_data['sorting'] != 'custom')
		{
			$insert_data['sorting'] = 'title';
		}

		// Permissions can be handled differently by each module, so unless they are 
		// passed, we are just going to forget about them
		if (isset($extra['permissions']) and is_array($extra['permissions']))
		{
			$insert_data['permissions']		= serialize($extra['permissions']);
		}

		// View options.
		if (isset($extra['view_options']) and is_array($extra['view_options']))
		{
			$insert_data['view_options']		= serialize($extra['view_options']);
		}
		else
		{
			// Since this is a new stream, we are going to add a basic view profile
			// with data we know will be there.	
			$insert_data['view_options']		= serialize(array('id', 'created'));
		}
		
		if ($this->db->insert($this->table, $insert_data))
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Update Stream
	 *
	 * @access	public
	 * @param	int
	 * @param	array - update_data
	 * @return	bool
	 */
	public function update_stream($stream_id, $data)
	{
		// See if the stream slug is different
		$stream = $this->get_stream($stream_id);
		
		if ($stream->stream_slug != $data['stream_slug'] or (isset($data['stream_prefix']) and $stream->stream_prefix != $data['stream_prefix']))
		{
			// Use the right DB prefix
			if (isset($data['stream_prefix']))
			{
				$prefix = $data['stream_prefix'];
				$update_data['stream_prefix'] = $prefix;
			}
			else
			{
				$prefix = $stream->stream_prefix;
			}
			
			// Use the right stream slug
			if (isset($data['stream_slug']))
			{
				$stream_slug = $data['stream_slug'];
				$update_data['stream_slug'] = $stream_slug;
			}
			else
			{
				$stream_slug = $stream->stream_slug;
			}

			// Okay looks like we need to alter the table name.			
			// Check to see if there is a table, then alter it.
			if ($this->db->table_exists($prefix.$stream_slug))
			{
				show_error(sprintf(lang('streams:table_exists'), $data['stream_slug']));
			}
			
			$this->load->dbforge();
			
			// Using the PyroStreams DB prefix because rename_table
			// does not prefix the table name properly, it would seem
			if ( ! $this->dbforge->rename_table($stream->stream_prefix.$stream->stream_slug, $prefix.$stream_slug))
			{
				return false;
			}
		}
		
		if (isset($data['stream_name']))		$update_data['stream_name']		= $data['stream_name'];
		if (isset($data['about']))				$update_data['about']			= $data['about'];
		if (isset($data['sorting']))			$update_data['sorting']			= $data['sorting'];
		if (isset($data['title_column']))		$update_data['title_column']	= $data['title_column'];
		if (isset($data['is_hidden']))			$update_data['is_hidden']		= $data['is_hidden'];
		if (isset($data['sorting']))			$update_data['sorting']			= $data['sorting'];
		if (isset($data['menu_path']))			$update_data['menu_path']		= $data['menu_path'];
		
		// View options
		if (isset($data['view_options']) and $data['view_options'])
		{
			// We can take a serizlied array or we can serialize it
			// all by ourselves.
			if(is_array($data['view_options']))
			{
				$update_data['view_options']	= serialize($data['view_options']);
			}
			else
			{
				$update_data['view_options']	= $data['view_options'];
			}
		}

		// Extra enum data checks
		if (isset($update_data['is_hidden']) and $update_data['is_hidden'] != 'yes' and $update_data['is_hidden'] != 'no')
		{
			$update_data['is_hidden'] = 'no';
		}

		if (isset($update_data['sorting']) and $update_data['sorting'] != 'title' and $update_data['sorting'] != 'custom')
		{
			$update_data['sorting'] = 'title';
		}

		// Permissions
		if (isset($data['permissions']) and is_array($data['permissions']))
		{
			$update_data['permissions']		= serialize($data['permissions']);
		}

		// View options.
		if (isset($extra['view_options']) and is_array($extra['view_options']))
		{
			$insert_data['view_options']		= serialize($extra['view_options']);
		}
		else
		{
			// Since this is a new stream, we are going to add a basic view profile
			// with data we know will be there.	
			$insert_data['view_options']		= serialize(array('id', 'created'));
		}
		
		return $this->db->where('id', $stream_id)->update($this->table, $update_data);
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Delete a stream
	 *
	 * @access	public
	 * @param	obj
	 * @return	bool
	 */
	public function delete_stream($stream)
	{
		if ( ! is_object($stream)) return null;
	
		// -------------------------------------
		// Get assignments and run destructs
		// -------------------------------------

		$assignments = $this->fields_m->get_assignments_for_stream($stream->id);
		
		if (is_array($assignments))
		{
			foreach ($assignments as $assignment)
			{
				// Run the destruct
				if (isset($this->type->types->{$assignment->field_type}) and method_exists($this->type->types->{$assignment->field_type}, 'field_assignment_destruct'))
				{
					$this->type->types->{$assignment->field_type}->field_assignment_destruct($this->fields_m->get_field($assignment->field_id), $this->get_stream($assignment->stream_id));
				}
			}		
		}

		// -------------------------------------
		// Delete actual table
		// -------------------------------------
		
		$this->load->dbforge();
		
		if ( ! $this->dbforge->drop_table($stream->stream_prefix.$stream->stream_slug)) return false;

		// -------------------------------------
		// Delete from assignments
		// -------------------------------------
		
		$this->db->where('stream_id', $stream->id);
		
		if ( ! $this->db->delete(ASSIGN_TABLE)) return false;

		// -------------------------------------
		// Clear the runtime cache
		// -------------------------------------

		if (isset($this->streams_cache[$stream->id]))
		{
			unset($this->streams_cache[$stream->id]);
		}

		if (isset($this->streams_cache['ns'][$stream->stream_namespace][$stream->stream_slug]))
		{
			unset($this->streams_cache['ns'][$stream->stream_namespace][$stream->stream_slug]);
		}

		// -------------------------------------
		// Delete from streams table
		// -------------------------------------
		
		return $this->db->where('id', $stream->id)->delete($this->table);
	}

	// --------------------------------------------------------------------------

	/**
	 * Get the ID for a stream from the slug
	 *
	 * @access	public
	 * @param	string - stream slug
	 * @param 	string - stream namespace
	 * @return	mixed
	 */	
	public function get_stream_id_from_slug($slug, $namespace)
	{
		$db = $this->db
					->limit(1)
					->where('stream_slug', $slug)
					->where('stream_namespace', $namespace)
					->get($this->table);
		
		if ($db->num_rows() == 0)
		{
			return false;
		}
		else
		{
			$row = $db->row();
			
			return $row->id;
		}
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Get a data for a single stream
	 *
	 * @access	public
	 * @param	int
	 * @param	bool
	 * @return	mixed
	 */
	public function get_stream($stream_id, $by_slug = false, $namespace = null)
	{
		// -------------------------------------
		// Check for cache
		// -------------------------------------
		// We can cache by either slug or ID.
		// We need a namespace for slug though.
		// -------------------------------------

		if ( ! $by_slug and is_numeric($stream_id))
		{
			if (isset($this->streams_cache[$stream_id]))
			{
				return $this->streams_cache[$stream_id];
			}
		}
		elseif ($by_slug and $namespace)
		{
			if (isset($this->streams_cache['ns'][$namespace][$stream_id]))
			{
				return $this->streams_cache['ns'][$namespace][$stream_id];
			}
		}

		// -------------------------------------


		$this->db->limit(1);
		
		if ($by_slug == true and ! is_null($namespace))
		{
			$this->db->where('stream_namespace', $namespace);
			$this->db->where('stream_slug', $stream_id);		
		}
		elseif (is_numeric($stream_id))
		{
			$this->db->where('id', $stream_id);
		}
		else
		{
			return null;
		}

		$obj = $this->db->get($this->table);
		
		if ($obj->num_rows() == 0) return false;
		
		$stream = $obj->row();
		
		if (trim($stream->view_options) == '')
		{
			$stream->view_options = array();
		}
		else
		{
			$stream->view_options = unserialize($stream->view_options);
		}
		
		// Save to cache
		$this->streams_cache[$stream_id] = $stream;
		
		return $stream;
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Get data from a stream.
	 *
	 * Only really shown on the back end.
	 *
	 * @access	public
	 * @param	obj
	 * @param	obj
	 * @param	int
	 * @param	int
	 * @return 	obj
	 */
	public function get_stream_data($stream, $stream_fields, $limit = null, $offset = 0, $filter_data = array())
	{
		$this->load->config('streams');

		// -------------------------------------
		// Set Ordering
		// -------------------------------------

		if ($stream->sorting == 'title' and ($stream->title_column != '' and $this->db->field_exists($stream->title_column, $stream->stream_prefix.$stream->stream_slug)))
		{
			if ($stream->title_column != '' and $this->db->field_exists($stream->title_column, $stream->stream_prefix.$stream->stream_slug))
			{
				$this->db->order_by($stream->title_column, 'ASC');
			}
		}
		elseif ($stream->sorting == 'custom')
		{
			$this->db->order_by('ordering_count', 'ASC');
		}	
		else
		{
			$this->db->order_by('created', 'DESC');
		}

		// -------------------------------------
		// Filter results
		// -------------------------------------

		foreach ($filter_data as $filter)
		{
			$this->db->where($filter, null, false);
		}

		// -------------------------------------
		// Optional Limit
		// -------------------------------------

		if (is_numeric($limit))
		{
			$this->db->limit($limit, $offset);
		}

		// -------------------------------------
		// Created By
		// -------------------------------------

		$this->db->select($stream->stream_prefix.$stream->stream_slug.'.*, '.$this->db->dbprefix('users').'.username as created_by_username, '.$this->db->dbprefix('users').'.id as created_by_user_id, '.$this->db->dbprefix('users').'.email as created_by_email');
		$this->db->join('users', 'users.id = '.$stream->stream_prefix.$stream->stream_slug.'.created_by', 'left');

		// -------------------------------------
		// Get Data
		// -------------------------------------
		
		$items = $this->db->get($stream->stream_prefix.$stream->stream_slug)->result();

		// -------------------------------------
		// Get Format Profile
		// -------------------------------------

		$stream_fields = $this->streams_m->get_stream_fields($stream->id);

		// -------------------------------------
		// Run formatting
		// -------------------------------------
		
		if (count($items) != 0)
		{
			$fields = new stdClass;
	
			foreach ($items as $id => $item)
			{
				$fields->$id = $this->row_m->format_row($item, $stream_fields, $stream);
			}
		}
		else
		{
			$fields = false;
		}
		
		return $fields;
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Get the assigned fields for a stream
	 *
	 * @access	public
	 * @param	int
	 * @param	int
	 * @param	int
	 * @return	mixed
	 */
	public function get_stream_fields($stream_id, $limit = false, $offset = false, $skips = array())
	{	
		// Check and see if there is a cache
		if (isset($this->stream_fields_cache[$stream_id]) and ! $limit and ! $offset)
		{
			return $this->stream_fields_cache[$stream_id];
		}
	
		if ( ! is_numeric($stream_id))
		{
			return false;
		}
	
		$this->db->select(ASSIGN_TABLE.'.id as assign_id, '.STREAMS_TABLE.'.*, '.ASSIGN_TABLE.'.*, '.FIELDS_TABLE.'.*');
		$this->db->order_by(ASSIGN_TABLE.'.sort_order', 'asc');
		
		if (is_numeric($limit))
		{
			if (is_numeric($offset))
			{
				$this->db->limit($limit, $offset);
			}	
			else
			{
				$this->db->limit($limit);
			}
		}
		
		if ( ! empty($skips)) $this->db->or_where_not_in('field_slug', $skips);
		
		$this->db->where(STREAMS_TABLE.'.id', $stream_id);
		$this->db->join(ASSIGN_TABLE, STREAMS_TABLE.'.id='.ASSIGN_TABLE.'.stream_id');
		$this->db->join(FIELDS_TABLE, FIELDS_TABLE.'.id='.ASSIGN_TABLE.'.field_id');
		
		$obj = $this->db->get(STREAMS_TABLE);
		
		if ($obj->num_rows() == 0)
		{
			return false;
		}
		else
		{
			$streams = new stdClass;
		
			$raw = $obj->result();
			
			foreach ($raw as $item)
			{
				$node = $item->field_slug;
			
				$streams->$node = $item;
				
				$streams->$node->field_data = unserialize($item->field_data);
			}
			
			// Save for cache
			if ( ! $limit and ! $offset) $this->stream_fields_cache[$stream_id] = $streams;
			
			return $streams;
		}
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Get total stream fields
	 *
	 * @access	public
	 * @param	int
	 * @return	int
	 */
	public function total_stream_fields($stream_id)
	{
		$query = $this->db->where('stream_id', $stream_id)->get(ASSIGN_TABLE);
		
		return $query->num_rows();
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Add Field to Stream
	 *
	 * Runs all the processess necessary to add a field to a stream including
	 * Creating the necessary column in the database
	 *
	 * @access  public
	 * @param	int
	 * @param	int
	 * @param	array - data
	 * @param	[bool - should we create the column?]
	 * @return	mixed - false or assignment ID
	 */
	public function add_field_to_stream($field_id, $stream_id, $data, $create_column = true)
	{
		// -------------------------------------
		// Get the field data
		// -------------------------------------
		
		$field = $this->fields_m->get_field($field_id);
		
		if ( ! $field) return false;
		
		// -------------------------------------
		// Get stream info
		// -------------------------------------
		
		$stream = $this->get_stream($stream_id);
		
		if ( ! $stream) return false;

		// -------------------------------------
		// Load the field type
		// -------------------------------------
		
		$field_type = $this->type->types->{$field->field_type};
		
		if ( ! $field_type) return false;
		
		// Do we have a pre-add function?
		if (method_exists($field_type, 'field_assignment_construct'))
		{
			$field_type->field_assignment_construct($field, $stream);
		}
		
		// -------------------------------------
		// Create database column
		// -------------------------------------
		
		$this->load->dbforge();
		
		$field_data = array();
		
		$field_data['field_slug']				= $field->field_slug;
		
		if (isset($field->field_data['max_length']))
		{
			$field_data['max_length']			= $field->field_data['max_length'];
		}

		if (isset($field->field_data['default_value']))
		{
			$field_data['default_value']		= $field->field_data['default_value'];
		}
		
		$field_to_add[$field->field_slug] 	= $this->fields_m->field_data_to_col_data($field_type, $field_data);
		
		if ($field_type->db_col_type !== false and $create_column === true)
		{
			if ( ! $this->dbforge->add_column($stream->stream_prefix.$stream->stream_slug, $field_to_add)) return false;
		}
		
		// -------------------------------------
		// Check for title column
		// -------------------------------------
		// See if this should be made the title column
		// -------------------------------------

		if (isset($data['title_column']) and $data['title_column'] == 'yes')
		{
			$update_data['title_column'] = $field->field_slug;
		
			$this->db->where('id', $stream->id );
			$this->db->update(STREAMS_TABLE, $update_data);
		}
		
		// -------------------------------------
		// Create record in assignments
		// -------------------------------------
		
		$insert_data['stream_id'] 		= $stream_id;
		$insert_data['field_id']		= $field_id;
		
		if (isset($data['instructions']))
		{
			$insert_data['instructions']	= $data['instructions'];
		}
		else
		{
			$insert_data['instructions']	= null;
		}
		
		// +1 for ordering.
		$this->db->select('MAX(sort_order) as top_num')->where('stream_id', $stream->id);
		$query = $this->db->get(ASSIGN_TABLE);
		
		if ($query->num_rows() == 0)
		{
			// First one! Make it 1
			$insert_data['sort_order'] = 1;
		}
		else
		{
			$row = $query->row();
			$insert_data['sort_order'] = $row->top_num+1;
		}
		
		// Is Required
		if (isset($data['is_required']) and $data['is_required'] == 'yes')
		{
			$insert_data['is_required']		= 'yes';
		}
		
		// Unique		
		if (isset($data['is_unique']) and $data['is_unique'] == 'yes')
		{
			$insert_data['is_unique']		= 'yes';
		}
		
		if ( ! $this->db->insert(ASSIGN_TABLE, $insert_data))
		{
			return false;
		}
		else
		{
			return $this->db->insert_id();
		}
	}

    // --------------------------------------------------------------------------

	/**
	 * Check to see if the table name needed for a stream is
	 * actually available.
	 *
	 * @access 	public
	 * @param 	string
	 * @param 	string
	 * @param 	string
	 */
	public function check_table_exists($stream_slug, $prefix)
	{
		return $this->db->table_exists($prefix.$stream_slug);
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Remove a field assignment
	 *
	 * @param	obj
	 * @param	obj
	 * @param	obj
	 * @return	bool
	 */
	public function remove_field_assignment($assignment, $field, $stream)
	{
		$this->load->dbforge();

		// Do we have a destruct function
		if (method_exists($this->type->types->{$field->field_type}, 'field_assignment_destruct'))
		{
			$this->type->types->{$field->field_type}->field_assignment_destruct($field, $stream, $assignment);
		}

		// -------------------------------------
		// Remove from db structure
		// -------------------------------------
		
		// Alternate method fields will not have a column, so we just
		// check for it first
		if ($this->db->field_exists($field->field_slug, $stream->stream_prefix.$stream->stream_slug))
		{
			if ( ! $this->dbforge->drop_column($stream->stream_prefix.$stream->stream_slug, $field->field_slug))
			{
				return false;
			}
		}

		// -------------------------------------
		// Remove from field assignments table
		// -------------------------------------
	
		$this->db->where('id', $assignment->id);
		
		if ( ! $this->db->delete(ASSIGN_TABLE)) return false;

		// -------------------------------------
		// Reset the ordering
		// -------------------------------------

		// Find everything above it, and take each one
		// down a peg.
		if ($assignment->sort_order == '' or !is_numeric($assignment->sort_order))
		{
			$assignment->sort_order = 0;
		}
		
		$this->db->where('sort_order >', $assignment->sort_order)->select('id, sort_order');
		$ord_obj = $this->db->get(ASSIGN_TABLE);
		
		if ($ord_obj->num_rows() > 0)
		{		
			$rows = $ord_obj->result();
			
			foreach ($rows as $update_row)
			{
				$update_data['sort_order'] = $update_row->sort_order-1;
				
				$this->db->where('id', $update_row->id)->update(ASSIGN_TABLE, $update_data);
				
				$update_data = array();
			}
		}

		// -------------------------------------
		// Remove from from field options
		// -------------------------------------
		
		if (is_array($stream->view_options) and in_array($field->field_slug, $stream->view_options))
		{
			$options = $stream->view_options;
			
			foreach ($options as $key => $val)
			{
				if ($val == $field->field_slug)
				{
					unset($options[$key]);
				}
			}
			
			$update_data['view_options'] = serialize($options);
			
			$this->db->where('id', $stream->id);
		
			if ( ! $this->db->update($this->table, $update_data))
			{
				return false;
			}
		}
		
		// -------------------------------------
		
		return true;
	}
	
}
