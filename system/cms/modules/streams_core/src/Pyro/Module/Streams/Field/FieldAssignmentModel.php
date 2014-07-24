<?php namespace Pyro\Module\Streams\Field;

use Illuminate\Database\Query\Expression as DBExpression;
use Pyro\Module\Streams\Exception\FieldAssignmentModelNotFoundException;
use Pyro\Module\Streams\FieldType\FieldTypeManager;
use Pyro\Module\Streams\Stream\StreamModel;

class FieldAssignmentModel extends FieldModel
{
    /**
     * Disable updated_at and created_at on table
     *
     * @var boolean
     */
    public $timestamps = false;
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
     * Find by field id and stream id
     *
     * @param  integer $field_id
     * @param  integer $stream_id
     *
     * @return object
     */
    public static function findByFieldIdAndStreamId($field_id = null, $stream_id = null, $fresh = false)
    {
        return static::where('field_id', $field_id)
            ->where('stream_id', $stream_id)
            ->take(1)
            ->first();
    }

    /**
     * Find many by stream ID
     *
     * @param  integer $stream_id
     * @param  integer $limit
     * @param  integer $offset
     * @param  string  $order
     *
     * @return array
     */
    public static function findManyByStreamId($stream_id, $limit = null, $offset = 0, $order = 'asc', $locked = null)
    {
        $query = static::select(array('*', 'data_field_assignments.id AS id'))->with('field')
            ->where('stream_id', $stream_id);

        if ($locked !== null) {
            $query = $query
                ->join('data_fields', 'data_field_assignments.field_id', '=', 'data_fields.id')
                ->where('data_fields.is_locked', $locked ? 'yes' : 'no');
        }

        return $query->take($limit)
            ->skip($offset)
            ->orderBy('sort_order', $order)
            ->get();
    }

    /**
     * Count assignments
     *
     * @return int
     */
    public static function countByFieldId($field_id = null)
    {
        if (!$field_id) {
            return 0;
        }

        return static::where('field_id', $field_id)->count('field_id');
    }

    /**
     * Count assignments for a stream
     *
     * @return  int
     */
    public static function countByStreamId($stream_id = null, $locked = null)
    {
        if (!$stream_id) {
            return 0;
        }

        $query = static::where('stream_id', $stream_id);

        if ($locked !== null) {
            $query = $query
                ->join('data_fields', 'data_field_assignments.field_id', '=', 'data_fields.id')
                ->where('data_fields.is_locked', $locked ? 'yes' : 'no');
        }

        return $query->count('stream_id');
    }

    /**
     * Cleanup stale assignments for fields and streams that don't exists
     *
     * @return boolean
     */
    public static function cleanup()
    {
        $field_ids = FieldModel::all()->modelKeys();

        if (!$field_ids) {
            return true;
        }

        return static::whereNotIn('field_id', $field_ids)->delete();
    }

    /**
     * Update sort order
     *
     * @param  integer $id         The assignment id
     * @param  integer $sort_order The sort order
     *
     * @return boolean
     */
    public static function updateSortOrder($id, $sort_order = 0)
    {
        return static::where('id', $id)->update(array('sort_order' => $sort_order));
    }

    /**
     * Get incremental sort order
     *
     * @param  integer $stream_id
     *
     * @return integer
     */
    public static function getIncrementalSortNumber($stream_id = null)
    {
        $instance = new static;

        $top_num = $instance->getQuery()
            ->select(new DBExpression('MAX(sort_order) as top_num'))
            ->where('stream_id', $stream_id)
            ->pluck('top_num');

        return $top_num ? $top_num + 1 : 1;
    }

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @param  mixed $id
     * @param  array $columns
     *
     * @return \Pyro\Module\Streams\FieldAssignmentModel|Collection|static
     */
    public static function findOrFail($id, $columns = array('*'))
    {
        if (!is_null($model = static::find($id, $columns))) {
            return $model;
        }

        throw new FieldAssignmentModelNotFoundException;
    }

    /**
     * Field garbage cleanup
     *
     * @param   obj - the assignment
     *
     * @return  void
     */
    public function delete()
    {
        $attributes = $this->getAttributes();

        $schema = ci()->pdb->getSchemaBuilder();

        // @todo - remove this once the hasColumn bug is fixed in Illuminate\Database
        $prefix = ci()->pdb->getQueryGrammar()->getTablePrefix();

        $stream = $this->getAttribute('stream');

        if ($field = $this->getAttribute('field')) {

            // Do we have a destruct function
            if ($type = $field->getType()) {

                // @todo - also pass the schema builder
                $type->setStream($stream);
                $type->fieldAssignmentDestruct();

                // Drop the column if it exists
                if (!$type->alt_process) {
                    $schema->table(
                        $this->stream_prefix . $this->stream_slug,
                        function ($table) use ($type, $schema) {
                            if ($schema->hasColumn($table->getTable(), $type->getColumnName())) {
                                $table->dropColumn($type->getColumnName());
                            }
                        }
                    );
                }

                $type->fieldAssignmentDestruct($schema);
            }

            // Update that stream's view options
            $stream->removeViewOption($field->field_slug);
        }

        // Find everything above it, and take each one
        // down a peg.
        if ($this->sort_order == '' or !is_numeric($this->sort_order)) {
            $this->sort_order = 0;
        }

        $other_assignments = static::where('stream_id', '=', $stream->id)
            ->where($this->getKeyName(), '!=', $this->getKey())
            ->where('sort_order', '>', $this->sort_order)
            ->get(array($this->getKeyName(), 'sort_order'));

        if (!$other_assignments->isEmpty()) {
            foreach ($other_assignments as $assignment) {
                $assignment->sort_order = $assignment->sort_order - 1;
                $assignment->save();
            }
        }

        // Make sure that garbage is collected even it the stream is not present anymore
        FieldModel::cleanup();

        return parent::delete();
    }

    /**
     * Save the model
     *
     * @param  array $options
     *
     * @return boolean
     */
    public function save(array $options = array())
    {
        $success = parent::save($options);

        // Save the stream so that the EntryModel gets recompiled
        $this->stream->save();

        return $success;
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
    public function update(array $attributes = array())
    {
        $stream = $this->getAttribute('stream');

        $field = $this->getAttribute('field');

        // -------------------------------------
        // Title Column
        // -------------------------------------

        // Scenario A: The title column is the field slug, and we
        // have it unchecked.
        if ($stream->title_column == $field->field_slug and
            (!isset($attributes['title_column']) or $attributes['title_column'] == 'no' or !$attributes['title_column'])
        ) {
            // In this case, they don't want this to
            // be the title column anymore, so we wipe it out
            StreamModel::updateTitleColumnByStreamIds($stream->id, $field->field_slug);
        } elseif (isset($attributes['title_column']) and
            ($attributes['title_column'] == 'yes' or $attributes['title_column'] === true) and
            $stream->title_column != $field->field_slug
        ) {
            if ($attributes['title_column'] == 'yes') {
                $attributes['title_column'] = $field->field_slug;
            }

            // Scenario B: They have checked the title column
            // and this field it not the current field.
            StreamModel::updateTitleColumnByStreamIds($stream->id, $field->field_slug, $attributes['title_column']);
        }

        return parent::update($attributes);
    }

    /**
     * Get the field name attr
     *
     * @param  string $field_name
     *
     * @return string
     */
    public function getFieldNameAttribute($field_name)
    {
        if (!empty($field_name)) {
            return $field_name;
        }

        // This guarantees that the language will be loaded
        if ($this->field instanceof FieldModel) {
            FieldTypeManager::getType($this->field->field_type);

            $field_name = lang_label($this->field->field_name);
        }

        return $field_name;
    }

    /**
     * Get field slug attribute from the field relation
     *
     * @param  string $field_slug
     *
     * @return string
     */
    public function getFieldSlugAttribute($field_slug)
    {
        if ($this->field) {
            return $this->field->field_slug;
        }

        return null;
    }

    /**
     * Get field namespace attribute
     *
     * @param  string $field_namespace
     *
     * @return string
     */
    public function getFieldNamespaceAttribute($field_namespace)
    {
        return $this->field->field_namespace;
    }

    /**
     * Get field type attribute
     *
     * @param  string $field_namespace
     *
     * @return string
     */
    public function getFieldTypeAttribute($field_type)
    {
        if ($this->field) {
            return $this->field->field_type;
        }

        return null;
    }

    /**
     * Get field data attribute
     *
     * @param  string $field_namespace
     *
     * @return array
     */
    public function getFieldDataAttribute($field_data)
    {
        return $this->field->field_data;
    }

    /**
     * Get is_locked attribute
     *
     * @param  string $field_namespace
     *
     * @return boolean
     */
    public function getIsLockedAttribute($isLocked)
    {
        return $this->field->is_locked;
    }

    /**
     * New collection instance
     *
     * @param  array $models
     *
     * @return object
     */
    public function newCollection(array $models = array())
    {
        return new FieldAssignmentCollection($models);
    }

    /**
     * Stream
     *
     * @return object
     */
    public function stream()
    {
        return $this->belongsTo('Pyro\Module\Streams\Stream\StreamModel', 'stream_id');
    }

    /**
     * Field
     *
     * @return object
     */
    public function field()
    {
        return $this->belongsTo('Pyro\Module\Streams\Field\FieldModel');
    }

    /**
     * Get is_required attr
     *
     * @param  string $isRequired
     *
     * @return boolean
     */
    public function getIsRequiredAttribute($isRequired = false)
    {
        return $isRequired === 'yes';
    }

    /**
     * Set is_required attr
     *
     * @param boolean $isRequired
     */
    public function setIsRequiredAttribute($isRequired = false)
    {
        $this->attributes['is_required'] = $isRequired ? 'yes' : 'no';
    }

    /**
     * Get is_unique attr
     *
     * @param  string $isUnique
     *
     * @return boolean
     */
    public function getIsUniqueAttribute($isUnique = false)
    {
        return $isUnique === 'yes';
    }

    /**
     * Set is_unique attr
     *
     * @param boolean $isUnique
     */
    public function setIsUniqueAttribute($isUnique = false)
    {
        $this->attributes['is_unique'] = $isUnique ? 'yes' : 'no';
    }
}
