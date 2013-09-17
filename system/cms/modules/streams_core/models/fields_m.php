<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Fields Model
 *
 * @package		PyroStreams
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2011 - 2013, PyroCMS
 */
class Fields_m extends CI_Model {

	public $table;

    // --------------------------------------------------------------------------

	/**
	 * Fields Validation
	 */
	public $fields_validation = array(
		array(
			'field'	=> 'field_name',
			'label' => 'lang:streams:label.field_name',
			'rules'	=> 'trim|required|max_length[60]'
		),
		array(
			'field'	=> 'field_slug',
			'label' => 'lang:streams:label.field_slug',
			'rules'	=> 'trim|required|max_length[60]|streams_slug_safe'
		),
		array(
			'field'	=> 'field_type',
			'label' => 'lang:streams:label.field_type',
			'rules'	=> 'trim|required|max_length[50]|streams_type_valid'
		)
	);

	// --------------------------------------------------------------------------

	public $fields_cache;

	// --------------------------------------------------------------------------

	public function __construct()
	{
		$this->table = FIELDS_TABLE;
	}
 
    // --------------------------------------------------------------------------

	public function populate_field_cache()
	{
		$fields = $this->db->get($this->table)->result();

		foreach ($fields as $field)
		{
			$this->fields_cache['by_id'][$field->id] 			= $field;
			$this->fields_cache['by_slug'][$field->field_slug]	= $field;
		}
	}

	// --------------------------------------------------------------------------
    
    /**
     * Get some fields
     *
     * @access	public
     * @param	[string - field namespace]
     * @param	[int limit]
     * @param	[int offset]
     * @return	obj
     */
    public function get_fields($namespace = null, $limit = false, $offset = 0, $skips = array())
	{
		if ( ! empty($skips)) $this->db->or_where_not_in('field_slug', $skips);
		
		if ($namespace) $this->db->where('field_namespace', $namespace);
	
		if ($offset) $this->db->offset($offset);
		
		if ($limit) $this->db->limit($limit);

		$query = $this->db->order_by('field_name', 'asc')->get($this->table);
     
    	return $query->result();
	}
    
    // --------------------------------------------------------------------------
    
    /**
     * Get all fields with extra field info
     *
     * @access	public
     * @param	int limit
     * @param	int offset
     * @return	array
     */
    public function get_all_fields($namespace = false)
	{
		// Limit to namespace
		if ($namespace) $this->db->where('field_namespace', $namespace);
		
		$obj = $this->db->order_by('field_name', 'asc')->get($this->table);
		
		$fields = $obj->result_array();
		
		$return_fields = array();

		foreach($fields as $key => $field)
		{
			$return_fields[$field['field_slug']] = $field;
 			$return_fields[$field['field_slug']]['field_data'] = unserialize($field['field_data']);
		}
    	
    	return $return_fields;
	}

    // --------------------------------------------------------------------------
    
    /**
     * Count fields
     *
     * @access	public
     * @return	int
     */
	public function count_fields($namespace)
	{
		if ( ! $namespace) return 0;

		return $this->db
				->where('field_namespace', $namespace)
				->from($this->table)
				->count_all_results();
	}

    // --------------------------------------------------------------------------

	/**
	 * Insert a field
	 *
	 * @access	public
	 * @param	string - the field name
	 * @param	string - the field slug
	 * @param	string - the field type
	 * @param	[array - any extra data]
	 * @return	bool
	 */
	public function insert_field($field_name, $field_slug, $field_type, $field_namespace, $extra = array(), $locked = 'no')
	{
		if ( ! $locked)
		{
			$locked = 'no';
		}

		if ($locked != 'yes' and $locked != 'no')
		{
			$locked = 'no';
		}

		$insert_data = array(
			'field_name' 		=> $field_name,
			'field_slug'		=> $field_slug,
			'field_namespace'	=> $field_namespace,
			'field_type'		=> $field_type,
			'is_locked'			=> $locked
		);
	
		// Load the type to see if there are other fields
		$field_type = $this->type->types->$field_type;
		
		if (isset($field_type->custom_parameters))
		{
			foreach ($field_type->custom_parameters as $param)
			{
				if(isset($extra[$param]))
				{
					$insert_data['custom'][$param] = $extra[$param];
				}
				else
				{
					$insert_data['custom'][$param] = null;
				}
			}
			
			foreach ($field_type->custom_parameters as $param)
			{
				if (method_exists($field_type, 'param_'.$param.'_pre_save'))
				{
					$insert_data['custom'][$param] = $field_type->{'param_'.$param.'_pre_save'}( $insert_data );
				}
			}
			
			$insert_data['field_data'] = serialize($insert_data['custom']);
			unset($insert_data['custom']);
		}
		
		return $this->db->insert($this->table, $insert_data);
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Take field data and parse it into an array
	 * the the DB forge class can use
	 *
	 * @access	public
	 * @param	obj
	 * @param	array
	 * @param	string
	 * @return	array
	 */
	public function field_data_to_col_data($type, $field_data, $method = 'add')
	{
		$col_data = array();

		// -------------------------------------		
		// Name
		// -------------------------------------
		
		if ($method == 'edit')
		{
			$col_data['name'] 			= $field_data['field_slug'];
		}
		
		// -------------------------------------		
		// Col Type
		// -------------------------------------		
	
		$col_data['type'] 				= strtoupper($type->db_col_type);
		
		// -------------------------------------		
		// Constraint
		// -------------------------------------
		
		// First we check and see if a constraint has been added
		if (isset($type->col_constraint) and $type->col_constraint)
		{
			$col_data['constraint']		= $type->col_constraint;
		}	
		// Otherwise, we'll check for a max_length field
		elseif (isset($field_data['max_length']) and is_numeric($field_data['max_length']))
		{	
			$col_data['constraint']		= $field_data['max_length'];
		}

		// -------------------------------------		
		// Text field varchar change
		// -------------------------------------
		
		if ($type->field_type_slug == 'text')		
		{
			if (isset($col_data['constraint']) and $col_data['constraint'] > 255)
			{
				$col_data['type'] 				= 'TEXT';
				
				// Don't need a constraint no more
				unset($col_data['constraint']);
			}
			else
			{
				$col_data['type'] 				= 'VARCHAR';
			}
		}

		// -------------------------------------		
		// Default
		// -------------------------------------		
		
		if (isset($field_data['default_value']) and $field_data['default_value'] != '')
		{
			$col_data['default']		= $field_data['default_value'];
		}

		// -------------------------------------		
		// Remove Default for some col types:
		// -------------------------------------
		// * TEXT
		// * LONGTEXT
		// -------------------------------------
		
		$no_default = array('TEXT', 'LONGTEXT');
		
		if (in_array($col_data['type'], $no_default))
		{
			unset($col_data['default']);
		}

		// -------------------------------------		
		// Default to allow null
		// -------------------------------------		

		$col_data['null'] = true;

		// -------------------------------------		
		// Check for varchar with no constraint
		// -------------------------------------
		// Catch it and default to 255
		// -------------------------------------		

		if ($col_data['type'] == 'VARCHAR' and ( ! isset($col_data['constraint']) || !is_numeric($col_data['constraint']) || $col_data['constraint'] == ''))
		{
			$col_data['constraint'] = 255;
		}

		// -------------------------------------	
		
		return $col_data;	
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Update field
	 *
	 * @access	public
	 * @param	obj
	 * @param	array - data
	 * @param	int
	 */
	public function update_field($field, $data)
	{	
		$type = $this->type->types->{$data['field_type']};
		
		// -------------------------------------
		// Alter Columns	
		// -------------------------------------		
		// We want to change columns if the
		// following change:
		//		
		// * Field Type
		// * Field Slug
		// * Max Length
		// * Default Value
		// -------------------------------------		

		$assignments = $this->get_assignments($field->id);
	
		if(
			$field->field_type != $data['field_type'] or 
			$field->field_slug != $data['field_slug'] or 
			( isset( $field->field_data['max_length'] ) and  $field->field_data['max_length'] != $data['max_length'] ) or  
			( isset( $field->field_data['default_value'] ) and  $field->field_data['default_value'] != $data['default_value'] )
		)
		{						
			// If so, we need to update some table columns
			// Get the field assignments and change the table names
						
			// Check first to see if there are any assignments
			if ($assignments)
			{
				// Alter the table names and types
				$this->load->dbforge();
				
				foreach ($assignments as $assignment)
				{				
					if ( ! method_exists($type, 'alt_rename_column'))
					{
						if ( ! $this->dbforge->modify_column($assignment->stream_prefix.$assignment->stream_slug, array($field->field_slug => $this->field_data_to_col_data($type, $data, 'edit'))))
						{
							return false;
						}
					}
					
					// Update the view options
					$view_options = unserialize($assignment->stream_view_options);
					
					if (is_array($view_options))
					{
						foreach ($view_options as $key => $option)
						{
							if ($option == $field->field_slug)
							{
								// Replace with the new field slug so nothing goes apeshit
								$view_options[$key] = $data['field_slug'];
							}
						}
					}
					else
					{
						$view_options = array();
					}
					
					$vo_update_data['view_options'] = serialize($view_options);
	
					$this->db->where('id', $assignment->stream_id)->update(STREAMS_TABLE, $vo_update_data);
	
					$vo_update_data 	= array();
					$view_options 		= array();
				}
			}

			// Run though alt rename column routines. Needs to be done
			// after the above loop through assignments.
			if ($assignments)
			{
				foreach ($assignments as $assignment)
				{
					if (method_exists($type, 'alt_rename_column'))
					{
						// We run a different function for alt_process
						$type->alt_rename_column($field, $this->streams_m->get_stream($assignment->stream_slug), $assignment);
					}
				}
			}
		}

		// Run edit field update hook
		if (method_exists($type, 'update_field'))					
		{
			$type->update_field($field, $assignments);
		}
			
		// Update field information		
		if (isset($data['field_name']))			$update_data['field_name']		= $data['field_name'];
		if (isset($data['field_slug'])) 		$update_data['field_slug']		= $data['field_slug'];
		if (isset($data['field_namespace'])) 	$update_data['field_namespace']	= $data['field_namespace'];
		if (isset($data['field_type']))			$update_data['field_type']		= $data['field_type'];

		if (isset($data['is_locked']))
		{
			if ( ! $data['is_locked'])
			{
				$data['is_locked'] = 'no';
			}

			if ($data['is_locked'] != 'yes' and $data['is_locked']!= 'no')
			{
				$data['is_locked'] = 'no';
			}
		}

		// Gather extra data		
		if ( ! isset($type->custom_parameters) or $type->custom_parameters == '')
		{
			$update_data['field_data'] = null;
		}
		else
		{
			foreach ($type->custom_parameters as $param)
			{
				if(isset($data[$param]))
				{
					$update_data['custom'][$param] = $data[$param];
				}
				else
				{
					$update_data['custom'][$param] = null;
				}
			}
			
			foreach ($type->custom_parameters as $param)
			{
				if (method_exists($type, 'param_'.$param.'_pre_save'))
				{
					$update_data['custom'][$param] = $type->{'param_'.$param.'_pre_save'}( $update_data );
				}
			}
			
			if ( ! empty($update_data['custom']))
			{
				$update_data['field_data'] = serialize($update_data['custom']);
			}
			unset($update_data['custom']);
		}
		
		$this->db->where('id', $field->id);
					
		if ($this->db->update('data_fields', $update_data))
		{
			$tc_update['title_column']	= $data['field_slug'];
		
			// Success. Now let's update the title column.
			$this->db->where('title_column', $field->field_slug);
			return $this->db->update(STREAMS_TABLE, $tc_update);
		}	
		else
		{
			// Boo.
			return false;
		}
	}

	// --------------------------------------------------------------------------

    /**
     * Count assignments
     *
     * @access	public
     * @return	int
     */
	public function count_assignments($field_id)
	{
		if ( ! $field_id) return 0;

		return $this->db
				->where('field_id', $field_id)
				->from($this->db->dbprefix(ASSIGN_TABLE))
				->count_all_results();
	}

    /**
     * Count assignments for a stream
     *
     * @access	public
     * @return	int
     */
	public function count_assignments_for_stream($stream_id)
	{
		if ( ! $stream_id) return 0;

		return $this->db
				->where('stream_id', $stream_id)
				->from($this->db->dbprefix(ASSIGN_TABLE))
				->count_all_results();
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Get assignments for a field
	 *
	 * @access	public
	 * @param	int
	 * @return	mixed
	 */
	public function get_assignments($field_id)
	{
		$this->db->select(STREAMS_TABLE.'.*, '.STREAMS_TABLE.'.view_options as stream_view_options, '.STREAMS_TABLE.'.id as stream_id, '.FIELDS_TABLE.'.id as field_id, '.FIELDS_TABLE.'.*, '.FIELDS_TABLE.'.view_options as field_view_options');
		$this->db->from(STREAMS_TABLE.', '.ASSIGN_TABLE.', '.FIELDS_TABLE);
		$this->db->where($this->db->dbprefix(STREAMS_TABLE).'.id', $this->db->dbprefix(ASSIGN_TABLE).'.stream_id', false);
		$this->db->where($this->db->dbprefix(FIELDS_TABLE).'.id', $this->db->dbprefix(ASSIGN_TABLE).'.field_id', false);
		$this->db->where($this->db->dbprefix(ASSIGN_TABLE).'.field_id', $field_id, false);
		
		$obj = $this->db->get();
		
		if ($obj->num_rows() == 0)
		{
			return false;
		}
		
		return $obj->result();
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Get assignments for a stream
	 *
	 * @access	public
	 * @param	int
	 * @return	mixed
	 */
	public function get_assignments_for_stream($stream_id)
	{
		$this->db->select(STREAMS_TABLE.'.*, '.STREAMS_TABLE.'.view_options as stream_view_options, '.ASSIGN_TABLE.'.id as assign_id, '.STREAMS_TABLE.'.id as stream_id, '.FIELDS_TABLE.'.id as field_id, '.FIELDS_TABLE.'.*, '.FIELDS_TABLE.'.view_options as field_view_options, '.ASSIGN_TABLE.'.instructions, '.ASSIGN_TABLE.'.is_required, '.ASSIGN_TABLE.'.is_unique');
		$this->db->from(STREAMS_TABLE.', '.ASSIGN_TABLE.', '.FIELDS_TABLE);
		$this->db->where($this->db->dbprefix(STREAMS_TABLE).'.id', $this->db->dbprefix(ASSIGN_TABLE).'.stream_id', false);
		$this->db->where($this->db->dbprefix(FIELDS_TABLE).'.id', $this->db->dbprefix(ASSIGN_TABLE).'.field_id', false);
		$this->db->where($this->db->dbprefix(ASSIGN_TABLE).'.stream_id', $stream_id, false);
		$this->db->order_by('sort_order', 'ASC');
		
		$obj = $this->db->get();
			
		if ($obj->num_rows() == 0)
		{
			return false;
		}
		
		return $obj->result();
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Delete a field
	 *
	 * @access	public
	 * @param	int
	 * @return	bool
	 */
	public function delete_field($field_id)
	{
		// Make sure field exists		
		if ( ! $field = $this->get_field($field_id))
		{
			return false;
		}
		
		// Remove from cache
		if (isset($this->fields_cache['by_id'][$field_id]))
		{
			unset($this->fields_cache['by_id'][$field_id]);
		}

		$namespace_key = $field->field_namespace.':'.$field->field_slug;
		
		if (isset($this->fields_cache['by_slug'][$namespace_key]))
		{
			unset($this->fields_cache['by_slug'][$namespace_key]);
		}
	
		// Find assignments, and delete rows from table
		$assignments = $this->get_assignments($field_id);
		
		if ($assignments)
		{
			$this->load->dbforge();
		
			$outcome = true;
		
			// Cycle and delete columns			
			foreach ($assignments as $assignment)
			{
				$this->cleanup_assignment($assignment);
			}
			
			if ( ! $outcome) return $outcome;
		}
		else
		{
			// If we have no assignments, let's call a special
			// function (if it exists). This is for deleting
			// fields that have no assignments.
			if (method_exists($this->type->types->{$field->field_type}, 'field_no_assign_destruct'))
			{
				$this->type->types->{$field->field_type}->field_no_assign_destruct($field);
			}
		}
		
		// Delete field assignments		
		$this->db->where('field_id', $field->id);
		
		if ( ! $this->db->delete(ASSIGN_TABLE))
		{
			return false;
		}
		
		// Reset instances where the title column
		// is the field we are deleting. PyroStreams will
		// always just use the ID in place of the field.
		$this->db->where('title_column', $field->field_slug);
		$this->db->update(STREAMS_TABLE, array('title_column' => null));
		
		// Delete from actual fields table		
		$this->db->where('id', $field->id);
		
		if ( ! $this->db->delete(FIELDS_TABLE))
		{
			return false;
		}

		return true;
	}

	// --------------------------------------------------------------------------

	/**
	 * Field garbage cleanup
	 *
	 * @access	public
	 * @param	obj - the assignment
	 * @return	void
	 */
	public function cleanup_assignment($assignment)
	{
		// Drop the column if it exists
		if ($this->db->field_exists($assignment->field_slug, $assignment->stream_prefix.$assignment->stream_slug))
		{
			if ( ! $this->dbforge->drop_column($assignment->stream_prefix.$assignment->stream_slug, $assignment->field_slug) )
			{
				$outcome = false;
			}
		}

		// Run the destruct
		if (method_exists($this->type->types->{$assignment->field_type}, 'field_assignment_destruct'))
		{
			$this->type->types->{$assignment->field_type}->field_assignment_destruct($this->get_field($assignment->field_id), $this->streams_m->get_stream($assignment->stream_slug, true));
		}
		
		// Update that stream's view options
		$view_options = unserialize($assignment->stream_view_options);
		
		if (is_array($view_options))
		{
			foreach ($view_options as $key => $option)
			{
				if ($option == $assignment->field_slug)
				{
					unset($view_options[$key]);
				}
			}
		}
		else
		{
			$view_options = array();
		}
		
		$update_data['view_options'] = serialize($view_options);
	
		$this->db->where('id', $assignment->stream_id)->update(STREAMS_TABLE, $update_data);
	
		unset($update_data);
		unset($view_options);
	}

	// --------------------------------------------------------------------------

	/**
	 * Get a single field
	 *
	 * @access	public
	 * @param	int
	 * @return	obj
	 */
	public function get_field($field_id)
	{
		// Check for already cached value
		if (isset($this->fields_cache['by_id'][$field_id]))
		{
			return $this->fields_cache['by_id'][$field_id];
		}

		$this->db->limit(1)->where('id', $field_id);
		
		$obj = $this->db->get($this->table);
		
		if ($obj->num_rows() == 0)
		{
			return false;
		}
		
		$field = $obj->row();
		
		$field->field_data = unserialize($field->field_data);

		// Save for later use
		$this->fields_cache['by_id'][$field_id] = $field;
		
		return $field;
	}

	// --------------------------------------------------------------------------

	/**
	 * Get a single field by the field slug
	 *
	 * @access	public
	 * @param	string - field slug
	 * @param	string - field namespace
	 * @return	obj
	 */
	public function get_field_by_slug($field_slug, $field_namespace)
	{
		// Check for already cached value
		if (isset($this->fields_cache['by_slug'][$field_namespace.':'.$field_slug]))
		{
			return $this->fields_cache['by_slug'][$field_namespace.':'.$field_slug];
		}

		$obj = $this->db
				->limit(1)
				->where('field_namespace', $field_namespace)
				->where('field_slug', $field_slug)
				->get($this->table);
		
		if ($obj->num_rows() == 0)
		{
			return false;
		}
		
		$field = $obj->row();
		
		$field->field_data = unserialize($field->field_data);

		// Save for later use
		$this->fields_cache['by_slug'][$field_namespace.':'.$field_slug] = $field;
		
		return $field;
	}

	// --------------------------------------------------------------------------

	/**
	 * Assignment Exists
	 *
	 * @access 	public
	 * @param 	int - stream ID
	 * @param 	int - field ID
	 * @return 	bool
	 */
	public function assignment_exists($stream_id, $field_id)
	{
		if ($this->db->select('id')->where('stream_id', $stream_id)->where('field_id', $field_id)->get(ASSIGN_TABLE)->num_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Edit Assignment
	 *
	 * @access	public
	 * @param	int
	 * @param	obj
	 * @param	obj
	 * @param	[string - instructions]
	 * return	bool
	 */
	public function edit_assignment($assignment_id, $stream, $field, $data)
	{
		// -------------------------------------
		// Title Column
		// -------------------------------------

		// Scenario A: The title column is the field slug, and we 
		// have it unchecked.
		if (
			$stream->title_column == $field->field_slug and
			( ! isset($data['title_column']) or $data['title_column'] == 'no' or ! $data['title_column'])
		)
		{
			// In this case, they don't want this to
			// be the title column anymore, so we wipe it out
			$this->db
				->limit(1)
				->where('id', $stream->id)
				->update('data_streams', array('title_column' => null));
		}
		elseif (
			isset($data['title_column']) and
			($data['title_column'] == 'yes' or $data['title_column'] === true) and
			$stream->title_column != $field->field_slug
		)
		{
			// Scenario B: They have checked the title column
			// and this field it not the current field.
			$this->db
					->limit(1)
					->where('id', $stream->id)
					->update('data_streams', array('title_column' => $field->field_slug));
		}

		// Is required	
		if( isset($data['is_required']) and $data['is_required'] == 'yes' ):

			$update_data['is_required'] = 'yes';

		else:

			$update_data['is_required'] = 'no';

		endif;

		// Is unique
		if( isset($data['is_unique']) and $data['is_unique'] == 'yes' ):

			$update_data['is_unique'] = 'yes';

		else:

			$update_data['is_unique'] = 'no';

		endif;

		// Add in instructions		
		$update_data['instructions'] = $data['instructions'];

		$this->db->where('id', $assignment_id);
		return $this->db->update(ASSIGN_TABLE, $update_data);
	}

}
