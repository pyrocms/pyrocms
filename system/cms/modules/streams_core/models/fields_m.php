<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Fields Model
 *
 * @package		PyroStreams
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
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
			'label' => 'Field Name',
			'rules'	=> 'trim|required|max_length[60]'
		),
		array(
			'field'	=> 'field_slug',
			'label' => 'Field Slug',
			'rules'	=> 'trim|required|max_length[60]|slug_safe'
		),
		array(
			'field'	=> 'field_type',
			'label' => 'Field Type',
			'rules'	=> 'trim|required|max_length[50]|type_valid'
		)
	);

    // --------------------------------------------------------------------------
	
	function __construct()
	{
		$this->table = FIELDS_TABLE;
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
    public function get_fields($namespace = NULL, $limit = FALSE, $offset = 0)
	{
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
     * @return	obj
     */
    public function get_all_fields()
	{
		$obj = $this->db->order_by('field_name', 'asc')->get($this->table);
		
		$fields = $obj->result_array();
		
		$return_fields = array();

		foreach($fields as $key => $field):
		
			$return_fields[$field['field_slug']] = $field;
 			$return_fields[$field['field_slug']]['field_data'] = unserialize($field['field_data']);
		
		endforeach; 
    	
    	return $return_fields;
	}

    // --------------------------------------------------------------------------
    
    /**
     * Count fields
     *
     * @access	public
     * @return	int
     */
	public function count_fields()
	{
		// @todo - add namespace
		return $this->db->count_all($this->table);
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
	public function insert_field($field_name, $field_slug, $field_type, $field_namespace, $extra = array())
	{
		$insert_data = array(
			'field_name' 		=> $field_name,
			'field_slug'		=> $field_slug,
			'field_namespace'	=> $field_namespace,
			'field_type'		=> $field_type
		);
	
		// Load the type to see if there are other fields
		$field_type = $this->type->types->$field_type;
		
		if( isset($field_type->custom_parameters) ):
		
			$extra_data = array();
		
			foreach( $field_type->custom_parameters as $param ):
			
				if(isset($extra[$param])) $extra_data[$param] = $extra[$param];
			
			endforeach;
		
			$insert_data['field_data'] = serialize($extra_data);
		
		endif;
		
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
		
		if($method == 'edit'):		

			$col_data['name'] 				= $field_data['field_slug'];
		
		endif;
		
		// -------------------------------------		
		// Col Type
		// -------------------------------------		
	
		$col_data['type'] 				= strtoupper($type->db_col_type);
		
		// -------------------------------------		
		// Constraint
		// -------------------------------------
		
		// First we check and see if a constraint has been added
		if(isset($type->col_constraint) and $type->col_constraint!=''):
		
			$col_data['constraint']		= $type->col_constraint;
			
		// Otherwise, we'll check for a max_length field
		elseif( isset($field_data['max_length']) and is_numeric($field_data['max_length']) ):
			
			$col_data['constraint']		= $field_data['max_length'];
		
		endif;

		// -------------------------------------		
		// Text field varchar change
		// -------------------------------------
		
		if( $type->field_type_slug == 'text' ):		

			if( isset($col_data['constraint']) and $col_data['constraint'] > 255 ):
			
				$col_data['type'] 				= 'TEXT';
				
				// Don't need a constraint no more
				unset($col_data['constraint']);
				
			else:
			
				$col_data['type'] 				= 'VARCHAR';
			
			endif;
		
		endif;

		// -------------------------------------		
		// Default
		// -------------------------------------		
		
		if( isset($field_data['default_value']) && $field_data['default_value'] != '' ):
		
			$col_data['default']		= $field_data['default_value'];
		
		endif;

		// -------------------------------------		
		// Remove Default for some col types:
		// -------------------------------------
		// * TEXT
		// * LONGTEXT
		// -------------------------------------
		
		$no_default = array('TEXT', 'LONGTEXT');
		
		if( in_array($col_data['type'], $no_default) ):
		
			unset($col_data['default']);
		
		endif;

		// -------------------------------------		
		// Default to allow null
		// -------------------------------------		

		$col_data['null'] = true;

		// -------------------------------------		
		// Check for varchar with no constraint
		// -------------------------------------
		// Catch it and default to 255
		// -------------------------------------		

		if( $col_data['type'] == 'VARCHAR' && ( !isset($col_data['constraint']) || !is_numeric($col_data['constraint']) || $col_data['constraint'] == '' ) ):
		
			$col_data['constraint'] = 255;
		
		endif;

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
		):
								
			// If so, we need to update some table columns
			// Get the field assignments and change the table names
						
			// Check first to see if there are any assignments
			if($assignments):
			
				// Alter the table names and types
				$this->load->dbforge();
				
				foreach($assignments as $assignment):
				
					if(method_exists($type, 'alt_rename_column')):
									
						// We run a different function for alt_process
						$type->alt_rename_column($field, $this->streams_m->get_stream($assignment->stream_slug));
					
					else:
					
						// Run the regular column renaming
						$fields[$field->field_slug] = $this->field_data_to_col_data($type, $data, 'edit');
					
						if( !$this->dbforge->modify_column(STR_PRE.$assignment->stream_slug, $fields) ):
						
							return FALSE;
						
						endif;
						
					endif;
					
					// Update the view options
					$view_options = unserialize($assignment->stream_view_options);
					
					if(is_array($view_options)):
					
						foreach($view_options as $key => $option):
						
							if( $option == $field->field_slug ):
							
								// Replace with the new field slug so nothing goes apeshit
								$view_options[$key] = $data['field_slug'];
							
							endif;					
						
						endforeach;
						
					else:
						
						$view_options = array();
					
					endif;
					
					$vo_update_data['view_options'] = serialize($view_options);
	
					$this->db->where('id', $assignment->stream_id)->update(STREAMS_TABLE, $vo_update_data);
	
					$vo_update_data 	= array();
					$view_options 		= array();
				
				endforeach;
				
			endif;
		
		endif;
		
		// Run edit field update hook
		if(method_exists($type, 'update_field')):						
			
			$type->update_field($field, $assignments);
		
		endif;
			
		// Update field information		
		$update_data['field_name']		= $data['field_name'];
		$update_data['field_slug']		= $data['field_slug'];
		$update_data['field_namespace']	= $data['field_namespace'];
		$update_data['field_type']		= $data['field_type'];
		
		// Gather extra data		
		if( !isset($type->custom_parameters) || $type->custom_parameters == '' ):
		
			$custom_params = array();
			
			$update_data['field_data'] = null;
		
		else:
		
			foreach( $type->custom_parameters as $param ):
			
				if(isset($data[$param])):
				
					$custom_params[$param] = $data[$param];
					
				else:
				
					$custom_params[$param] = null;
				
				endif;
			
			endforeach;

			$update_data['field_data'] = serialize($custom_params);
		
		endif;
		
		$this->db->where('id', $field->id);
					
		if( $this->db->update('data_fields', $update_data) ):
		
			$tc_update['title_column']	= $data['field_slug'];
		
			// Success. Now let's update the title column.
			$this->db->where('title_column', $field->field_slug);
			return $this->db->update(STREAMS_TABLE, $tc_update);
			
		else:
		
			// Boo.
			return FALSE;
		
		endif;
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
		$this->db->where($this->db->dbprefix(STREAMS_TABLE).'.id', $this->db->dbprefix(ASSIGN_TABLE).'.stream_id', FALSE);
		$this->db->where($this->db->dbprefix(FIELDS_TABLE).'.id', $this->db->dbprefix(ASSIGN_TABLE).'.field_id', FALSE);
		$this->db->where($this->db->dbprefix(ASSIGN_TABLE).'.field_id', $field_id, FALSE);
		
		$obj = $this->db->get();
		
		if( $obj->num_rows() == 0 ) return FALSE;
		
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
		$this->db->select(STREAMS_TABLE.'.*, '.STREAMS_TABLE.'.view_options as stream_view_options, '.STREAMS_TABLE.'.id as stream_id, '.FIELDS_TABLE.'.id as field_id, '.FIELDS_TABLE.'.*, '.FIELDS_TABLE.'.view_options as field_view_options');
		$this->db->from(STREAMS_TABLE.', '.ASSIGN_TABLE.', '.FIELDS_TABLE);
		$this->db->where($this->db->dbprefix(STREAMS_TABLE).'.id', $this->db->dbprefix(ASSIGN_TABLE).'.stream_id', FALSE);
		$this->db->where($this->db->dbprefix(FIELDS_TABLE).'.id', $this->db->dbprefix(ASSIGN_TABLE).'.field_id', FALSE);
		$this->db->where($this->db->dbprefix(ASSIGN_TABLE).'.stream_id', $stream_id, FALSE);
		
		$obj = $this->db->get();
			
		if( $obj->num_rows() == 0 ) return FALSE;
		
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
		if( ! $field = $this->get_field($field_id) ) return FALSE;
	
		// Find assignments, and delete rows from table
		$assignments = $this->get_assignments($field_id);
		
		if( $assignments ):
		
			$this->load->dbforge();
		
			$outcome = TRUE;
		
			// Cycle and delete columns			
			foreach( $assignments as $assignment):
			
				$this->cleanup_assignment($assignment);
			
			endforeach;
			
			if( !$outcome ) return $outcome;
		
		endif;
		
		// Delete field assignments		
		$this->db->where('field_id', $field->id);
		
		if( ! $this->db->delete(ASSIGN_TABLE) ):
		
			return FALSE;
		
		endif;
		
		// Reset instances where the title column
		// is the field we are deleting. PyroStreams will
		// always just use the ID in place of the field.
		$this->db->where('title_column', $field->field_slug);
		$this->db->update(STREAMS_TABLE, array('title_column' => NULL));
		
		// Delete from actual fields table		
		$this->db->where('id', $field->id);
		
		if( !$this->db->delete(FIELDS_TABLE) ):
		
			return FALSE;
		
		endif;
		
		return TRUE;
	}

	// --------------------------------------------------------------------------

	/**
	 * Field garbage cleanup
	 *
	 * @access	public
	 * @param	obj - the assignment
	 * @return	void
	 */
	function cleanup_assignment($assignment)
	{
		// Drop the column if it exists
		if( $this->db->field_exists($assignment->field_slug, STR_PRE.$assignment->stream_slug) ):
	
			if( !$this->dbforge->drop_column(STR_PRE.$assignment->stream_slug, $assignment->field_slug) ):
			
				$outcome = FALSE;
			
			endif;
		
		endif;

		// Run the destruct
		if(method_exists($this->type->types->{$assignment->field_type}, 'field_assignment_destruct')):
		
			$this->type->types->{$assignment->field_type}->field_assignment_destruct($this->get_field($assignment->field_id), $this->streams_m->get_stream($assignment->stream_slug, true));
		
		endif;
		
		// Update that stream's view options
		$view_options = unserialize($assignment->stream_view_options);
		
		if(is_array($view_options)):
		
			foreach($view_options as $key => $option):
			
				if($option == $assignment->field_slug) unset($view_options[$key]);
			
			endforeach;
		
		else:
		
			$view_options = array();
		
		endif;
		
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
		$this->db->limit(1)->where('id', $field_id);
		
		$obj = $this->db->get($this->table);
		
		if( $obj->num_rows() == 0 ):
		
			return FALSE;
		
		endif;
		
		$field = $obj->row();
		
		$field->field_data = unserialize($field->field_data);
		
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
		$obj = $this->db
				->limit(1)
				->where('field_namespace', $field_namespace)
				->where('field_slug', $field_slug)
				->get($this->table);
		
		if( $obj->num_rows() == 0 ):
		
			return FALSE;
		
		endif;
		
		$field = $obj->row();
		
		$field->field_data = unserialize($field->field_data);
		
		return $field;
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
		// Check for title column
		// -------------------------------------
		// See if this should be made the title column
		// -------------------------------------

		if( isset($data['title_column']) and $data['title_column'] == 'yes' ):
		
			$title_update_data['title_column'] = $field->field_slug;
		
			$this->db->where('id', $stream->id );
			$this->db->update('data_streams', $title_update_data);
		
		endif;

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

/* End of file fields_m.php */