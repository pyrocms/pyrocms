<?php namespace Pyro\Module\Streams_core;

use Illuminate\Database\Query\Expression as DBExpression;
use Pyro\Model\Eloquent;

class FieldAssignmentModel extends Eloquent
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

    /**
     * Find by field id and stream id
     * @param  integer $field_id  
     * @param  integer $stream_id 
     * @return object            
     */
    public static function findByFieldIdAndStreamId($field_id = null, $stream_id = null)
    {
        return static::where('field_id', $field_id)
            ->where('stream_id', $stream_id)
            ->take(1)
            ->first();
    }

    /**
     * Find many by stream ID
     * @param  integer  $stream_id 
     * @param  integer  $limit     
     * @param  integer $offset    
     * @param  string  $order     
     * @return array
     */
    public static function findManyByStreamId($stream_id, $limit = null, $offset = 0, $order = 'asc')
    {
        return static::with('field')
            ->where('stream_id', $stream_id)
            ->take($limit)
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
        if ( ! $field_id) return 0;

        return static::where('field_id', $stream_id)->count('field_id');
    }

    /**
     * Count assignments for a stream
     *
     * @return  int
     */
    public static function countByStreamId($stream_id = null)
    {
        if ( ! $stream_id) return 0;

        return static::where('stream_id', $stream_id)->count('stream_id');
    }

    /**
     * Field garbage cleanup
     *
     * @param   obj - the assignment
     * @return  void
     */
    public function delete()
    {
        $attributes = $this->getAttributes();

        $schema = ci()->pdb->getSchemaBuilder();

        // @todo - remove this once the hasColumn bug is fixed in Illuminate\Database
        $prefix = ci()->pdb->getQueryGrammar()->getTablePrefix();

        $stream = $this->getAttribute('stream');

        if ($field = $this->getAttribute('field'))
        {
            // Drop the column if it exists
            if ($schema->hasColumn($field->field_slug, $prefix.$stream->stream_prefix.$stream->stream_slug))
            {
                $schema->table($stream->stream_prefix.$stream->stream_slug, function ($table) use ($field, $stream, $prefix) {
                    
                    $table->dropColumn($field->field_slug);
                
                });            
            }

            // Run the destruct
            if ($type = $field->getType())
            {
                $type->setStream($stream);
                $type->fieldAssignmentDestruct();
            }

            // Update that stream's view options
            $stream->removeViewOption($field->field_slug);
        }

        // Find everything above it, and take each one
        // down a peg.
        if ($this->sort_order == '' or ! is_numeric($this->sort_order))
        {
            $this->sort_order = 0;
        }

        $other_assignments = static::where('stream_id', '=', $stream->id)
            ->where($this->getKeyName(), '!=', $this->getKey())
            ->where('sort_order', '>', $this->sort_order)
            ->get(array($this->getKeyName(), 'sort_order'));

        if ( ! $other_assignments->isEmpty())
        {
            foreach ($other_assignments as $assignment)
            {
                $assignment->sort_order = $assignment->sort_order - 1;
                $assignment->save();
            }
        }

        return parent::delete();
    }

    /**
     * Get the field name attr
     * @param  string $field_name 
     * @return string             
     */
    public function getFieldNameAttribute($field_name)
    {
        // This guarantees that the language will be loaded
        if ($this->field)
        {
            FieldTypeManager::getType($this->field->field_type);

            $field_name = lang_label($field_name);
        }
        
        return $field_name;
    }

    /**
     * Cleanup stale assignments for fields and streams that don't exists
     * @return [type] [description]
     */
    public static function cleanup()
    {
        $field_ids = FieldModel::all()->modelKeys();

        $stream_ids = StreamModel::all()->modelKeys();

        return static::whereNotIn('field_id', $field_ids)->orWhereNotIn('stream_id', $stream_ids)->delete();
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
            (! isset($attributes['title_column']) or $attributes['title_column'] == 'no' or ! $attributes['title_column']))
        {
            // In this case, they don't want this to
            // be the title column anymore, so we wipe it out
            StreamModel::updateTitleColumnByStreamIds($stream->id, $field->field_slug);
        }
        elseif (isset($attributes['title_column']) and
            ($attributes['title_column'] == 'yes' or $attributes['title_column'] === true) and 
            $stream->title_column != $field->field_slug)
        {
            if ($attributes['title_column'] == 'yes')
            {
                $attributes['title_column'] = $field->field_slug;
            }

            // Scenario B: They have checked the title column
            // and this field it not the current field.
            StreamModel::updateTitleColumnByStreamIds($stream->id, $field->field_slug, $attributes['title_column']);    
        }

        return parent::update($attributes);
    }

    /**
     * Update sort order
     * @param  integer  $id        The assignment id
     * @param  integer $sort_order The sort order
     * @return boolean
     */
    public static function updateSortOrder($id, $sort_order = 0)
    {
        return static::where('id', $id)->update(array('sort_order' => $sort_order));
    }

    /**
     * Get incremental sort order
     * @param  integer $stream_id 
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
     * @param  mixed  $id
     * @param  array  $columns
     * @return \Pyro\Module\Streams_core\FieldAssignmentModel|Collection|static
     */
    public static function findOrFail($id, $columns = array('*'))
    {
        if ( ! is_null($model = static::find($id, $columns))) return $model;

        throw new Exception\FieldAssignmentModelNotFoundException;
    }

    /**
     * New collection instance
     * @param  array  $models 
     * @return object         
     */
    public function newCollection(array $models = array())
    {
        return new FieldAssignmentCollection($models);
    }

    /**
     * Stream
     * @return object
     */
    public function stream()
    {
    	return $this->belongsTo('Pyro\Module\Streams_core\StreamModel', 'stream_id');
    }

    /**
     * Field
     * @return object
     */
    public function field()
    {
        return $this->belongsTo('Pyro\Module\Streams_core\FieldModel');
    }

    /**
     * Get is required attr
     * @param  string $is_required 
     * @return boolean              
     */
    public function getIsRequiredAttribute($is_required)
    {
        return $is_required == 'yes' ? true : false;
    }

    /**
     * Set is required attr
     * @param boolean $is_required
     */
    public function setIsRequiredAttribute($is_required)
    {
        $this->attributes['is_required'] = ! $is_required ? 'no' : 'yes';
    }

    /**
     * Get is unique attr
     * @param  string $is_required 
     * @return boolean              
     */
    public function getIsUniqueAttribute($is_unique)
    {
        return $is_unique == 'yes' ? true : false;
    }

    /**
     * Set is unique attr
     * @param boolean $is_required
     */
    public function setIsUniqueAttribute($is_unique)
    {
        $this->attributes['is_unique'] = ! $is_unique ? 'no' : 'yes';
    }
}
