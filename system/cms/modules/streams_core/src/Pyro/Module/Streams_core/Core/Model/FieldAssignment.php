<?php namespace Pyro\Module\Streams_core\Core\Model;

use Pyro\Model\Eloquent;

class FieldAssignment extends Eloquent
{
    /**
     * Define the table name
     *
     * @var string
     */
	protected $table = 'data_field_assignments';

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

/*    public static function findManyByStreamId()
    {
        return static::where('stream_id', '')
    }*/

    /**
     * Count assignments
     *
     * @return int
     */
    public function countFieldAssignments($field_id)
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
     * @return  int
     */
    public function count_assignments_for_stream($stream_id)
    {
        if ( ! $stream_id) return 0;

        return $this->db
                ->where('stream_id', $stream_id)
                ->from($this->db->dbprefix(ASSIGN_TABLE))
                ->count_all_results();
    }

    /**
     * Get assignments for a field
     *
     * @param   int
     * @return  mixed
     */
    public function get_assignments($field_id)
    {
        $this->db->select(STREAMS_TABLE.'.*, '.STREAMS_TABLE.'.view_options as stream_view_options, '.STREAMS_TABLE.'.id as stream_id, '.FIELDS_TABLE.'.id as field_id, '.FIELDS_TABLE.'.*, '.FIELDS_TABLE.'.view_options as field_view_options');
        $this->db->from(STREAMS_TABLE.', '.ASSIGN_TABLE.', '.FIELDS_TABLE);
        $this->db->where($this->db->dbprefix(STREAMS_TABLE).'.id', $this->db->dbprefix(ASSIGN_TABLE).'.stream_id', false);
        $this->db->where($this->db->dbprefix(FIELDS_TABLE).'.id', $this->db->dbprefix(ASSIGN_TABLE).'.field_id', false);
        $this->db->where($this->db->dbprefix(ASSIGN_TABLE).'.field_id', $field_id, false);

        $obj = $this->db->get();

        if ($obj->num_rows() == 0) {
            return false;
        }

        return $obj->result();
    }

    /**
     * Get assignments for a stream
     *
     * @param   int
     * @return  mixed
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

        if ($obj->num_rows() == 0) {
            return false;
        }

        return $obj->result();
    }

    /**
     * Field garbage cleanup
     *
     * @param   obj - the assignment
     * @return  void
     */
    public function cleanup()
    {
        // Drop the column if it exists
        if ($this->db->field_exists($assignment->field_slug, $assignment->stream_prefix.$assignment->stream_slug)) {
            if ( ! $this->dbforge->drop_column($assignment->stream_prefix.$assignment->stream_slug, $assignment->field_slug) ) {
                $outcome = false;
            }
        }

        // Run the destruct
        if (method_exists($this->type->types->{$assignment->field_type}, 'field_assignment_destruct')) {
            $this->type->types->{$assignment->field_type}->field_assignment_destruct($this->get_field($assignment->field_id), $this->streams_m->get_stream($assignment->stream_slug, true));
        }

        // Update that stream's view options
        $view_options = unserialize($assignment->stream_view_options);

        if (is_array($view_options)) {
            foreach ($view_options as $key => $option) {
                if ($option == $assignment->field_slug) {
                    unset($view_options[$key]);
                }
            }
        } else {
            $view_options = array();
        }

        $update_data['view_options'] = serialize($view_options);

        $this->db->where('id', $assignment->stream_id)->update(STREAMS_TABLE, $update_data);

        unset($update_data);
        unset($view_options);
    }

    /**
     * Assignment Exists
     *
     * @param   int - stream ID
     * @param   int - field ID
     * @return  bool
     */
    public function assignment_exists($stream_id, $field_id)
    {
        return $this->pdb->select('id')
            ->table(ASSIGN_TABLE)
            ->where('stream_id', $stream_id)
            ->where('field_id', $field_id)
            ->count() > 0;
    }

   /**
     * Edit Assignment
     *
     * @param   int
     * @param   obj
     * @param   obj
     * @param   [string - instructions]
     * return   bool
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
        } elseif (
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

    public function newCollection(array $models = array())
    {
        return new Collection\FieldAssignmentCollection($models);
    }

    public function stream()
    {
    	return $this->belongsTo(__NAMESPACE__.'\Stream', 'stream_id');
    }

    public function field()
    {
        return $this->belongsTo(__NAMESPACE__.'\Field');
    }

    public function getIsRequiredAttribute($is_required)
    {
        return $is_required == 'yes' ? true : false;
    }

    public function setIsRequiredAttribute($is_required)
    {
        $this->attributes['is_required'] = ! $is_required ? 'no' : 'yes';
    }

    public function getIsUniqueAttribute($is_unique)
    {
        return $is_unique == 'yes' ? true : false;
    }

    public function setIsUniqueAttribute($is_unique)
    {
        $this->attributes['is_unique'] = ! $is_unique ? 'no' : 'yes';
    }

}