<?php namespace Pyro\Module\Streams_core\Core\Model;

use Pyro\Model\Eloquent;

class Field extends Eloquent
{
    /**
     * Define the table name
     *
     * @var string
     */
	protected $table = 'data_fields';

    /**
     * The attributes that aren't mass assignable
     *
     * @var array
     */
    protected $guarded = array();

    /**
     * Disable updated_at and created_at on table
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Insert a field
     *
     * @param   string - the field name
     * @param   string - the field slug
     * @param   string - the field type
     * @param   [array - any extra data]
     * @return  bool
     */
    // $field_name, $field_slug, $field_type, $field_namespace, $extra = array(), $locked = 'no'
    public static function create(array $attributes = array())
    {
        if (isset($attributes['field_type']))
        {
            // @todo replace this with PSR version of Type class
            // Load the type to see if there are other fields
            if ($field_type = ci()->type->types->$attributes['field_type'] and isset($field_type->custom_parameters))
            {
                foreach ($field_type->custom_parameters as $param)
                {
                    if (method_exists($field_type, 'param_'.$param.'_pre_save'))
                    {
                        $attributes['field_data'][$param] = $field_type->{'param_'.$param.'_pre_save'}( $attributes );
                    }
                }
            }
        }

        return parent::create($attributes);
    }

    // --------------------------------------------------------------------------

    /**
     * Update field
     *
     * @param   obj
     * @param   array - data
     * @param   int
     */
    public function updateField($field, $data)
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
            if ($assignments) {
                // Alter the table names and types
                $this->load->dbforge();

                foreach ($assignments as $assignment) {
                    if ( ! method_exists($type, 'alt_rename_column')) {
                        if ( ! $this->dbforge->modify_column($assignment->stream_prefix.$assignment->stream_slug, array($field->field_slug => $this->field_data_to_col_data($type, $data, 'edit')))) {
                            return false;
                        }
                    }

                    // Update the view options
                    $view_options = unserialize($assignment->stream_view_options);

                    if (is_array($view_options)) {
                        foreach ($view_options as $key => $option) {
                            if ($option == $field->field_slug) {
                                // Replace with the new field slug so nothing goes apeshit
                                $view_options[$key] = $data['field_slug'];
                            }
                        }
                    } else {
                        $view_options = array();
                    }

                    $vo_update_data['view_options'] = serialize($view_options);

                    $this->db->where('id', $assignment->stream_id)->update(STREAMS_TABLE, $vo_update_data);

                    $vo_update_data     = array();
                    $view_options       = array();
                }
            }

            // Run though alt rename column routines. Needs to be done
            // after the above loop through assignments.
            if ($assignments) {
                foreach ($assignments as $assignment) {
                    if (method_exists($type, 'alt_rename_column')) {
                        // We run a different function for alt_process
                        $type->alt_rename_column($field, $this->streams_m->get_stream($assignment->stream_slug), $assignment);
                    }
                }
            }
        }

        // Run edit field update hook
        if (method_exists($type, 'update_field')) {
            $type->update_field($field, $assignments);
        }

        // Update field information
        if (isset($data['field_name']))         $update_data['field_name']      = $data['field_name'];
        if (isset($data['field_slug']))         $update_data['field_slug']      = $data['field_slug'];
        if (isset($data['field_namespace']))    $update_data['field_namespace'] = $data['field_namespace'];
        if (isset($data['field_type']))         $update_data['field_type']      = $data['field_type'];

        if (isset($data['is_locked'])) {
            if (! $data['is_locked']) {
                $data['is_locked'] = 'no';
            }

            if ($data['is_locked'] != 'yes' and $data['is_locked']!= 'no') {
                $data['is_locked'] = 'no';
            }
        }

        // Gather extra data
        if ( ! isset($type->custom_parameters) or $type->custom_parameters == '') {
            $update_data['field_data'] = null;
        } else {
            foreach ($type->custom_parameters as $param) {
                if (isset($data[$param])) {
                    $update_data['custom'][$param] = $data[$param];
                } else {
                    $update_data['custom'][$param] = null;
                }
            }

            foreach ($type->custom_parameters as $param) {
                if (method_exists($type, 'param_'.$param.'_pre_save')) {
                    $update_data['custom'][$param] = $type->{'param_'.$param.'_pre_save'}( $update_data );
                }
            }

            if ( ! empty($update_data['custom'])) {
                $update_data['field_data'] = serialize($update_data['custom']);
            }
            unset($update_data['custom']);
        }

        $this->db->where('id', $field->id);

        if ($this->db->update('data_fields', $update_data)) {
            $tc_update['title_column']  = $data['field_slug'];

            // Success. Now let's update the title column.
            $this->db->where('title_column', $field->field_slug);
            return $this->db->update(STREAMS_TABLE, $tc_update);
        } else {
            // Boo.
            return false;
        }
    }

    /**
     * Count fields
     *
     * @return int
     */
    public static function countByNamespace($field_namespace = null)
    {
        if ( ! $field_namespace) return 0;

        return static::where('field_namespace', $field_namespace)->count();
    }

    /**
     * Delete a field
     *
     * @param   int
     * @return  bool
     */
    public function deleteField($field_id)
    {
        // Make sure field exists
        if ( ! $field = $this->get_field($field_id)) {
            return false;
        }

        // Find assignments, and delete rows from table
        $assignments = $this->get_assignments($field_id);

        if ($this->assignments()) {
            $this->load->dbforge();

            $outcome = true;

            // Cycle and delete columns
            foreach ($assignments as $assignment) {
                $this->cleanup_assignment($assignment);
            }

            if ( ! $outcome) return $outcome;
        } else {
            // If we have no assignments, let's call a special
            // function (if it exists). This is for deleting
            // fields that have no assignments.
            if (method_exists($this->type->types->{$field->field_type}, 'field_no_assign_destruct')) {
                $this->type->types->{$field->field_type}->field_no_assign_destruct($field);
            }
        }

        // Delete field assignments
        $this->db->where('field_id', $field->id);

        if ( ! $this->db->delete(ASSIGN_TABLE)) {
            return false;
        }

        // Reset instances where the title column
        // is the field we are deleting. PyroStreams will
        // always just use the ID in place of the field.
        $this->db->where('title_column', $field->field_slug);
        $this->db->update(STREAMS_TABLE, array('title_column' => null));

        // Delete from actual fields table
        $this->db->where('id', $field->id);

        if ( ! $this->db->delete(FIELDS_TABLE)) {
            return false;
        }

        return true;
    }

    /**
     * Get a single field by the field slug
     *
     * @param   string field slug
     * @param   string field namespace
     * @return  object
     */
    public static function findBySlugAndNamespace($field_slug = null, $field_namespace = null)
    {
        return static::where('field_slug', $field_slug)
            ->where('field_namespace', $field_namespace)
            ->take(1)
            ->first();
    }

    public static function findManyByNamespace($field_namespace = null, $pagination = false, $offset = 0, $skips = null)
    {
        return static::where('field_namespace', '=', $field_namespace)->get();
    }

    public function newCollection(array $models = array())
    {
        return new Collection\FieldCollection($models);
    }

    public function assignments()
    {
        return $this->hasMany(__NAMESPACE_.'\FieldAssignment', 'field_id');
    }

    public function getFieldDataAttribute($field_data)
    {
        return unserialize($field_data);
    }

    public function getViewOptionsAttribute($view_options)
    {
        return unserialize($view_options);
    }

    public function setViewOptionsAttribute($view_options)
    {   
        $this->attributes['view_options'] = serialize($view_options);
    }

    public function getIsLockedAttribute($is_locked)
    {
        return $is_locked == 'yes' ? true : false;
    }

    public function setIsLockedAttribute($is_locked)
    {
        $this->attributes['is_locked'] = ! $is_locked ? 'no' : 'yes';
    }
}