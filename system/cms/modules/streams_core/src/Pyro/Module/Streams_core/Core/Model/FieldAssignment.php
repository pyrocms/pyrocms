<?php namespace Pyro\Module\Streams_core\Core\Model;

use Illuminate\Database\Query\Expression as DBExpression;
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

    public static function findByFieldIdAndStreamId($field_id = null, $stream_id = null)
    {
        return static::where('field_id', $field_id)
            ->where('stream_id', $stream_id)
            ->take(1)
            ->first();
    }

    public static function findManyByStreamId($stream_id, $limit = null, $offset = 0, $order = 'asc')
    {
        return static::with('field')
            ->where('stream_id', $stream_id)
            ->take($limit)
            ->skip($offset)
            ->orderBy('field_name', $order)
            ->get();
    }

    /**
     * Count assignments
     *
     * @return int
     */
    public function countFieldAssignments($field_id = null)
    {
        if ( ! $field_id) return 0;

        return static::where('field_id', $stream_id)->count('field_id');
    }

    /**
     * Count assignments for a stream
     *
     * @return  int
     */
    public function countStreamAssignments($stream_id = null)
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

        $field = $this->getAttribute('field');

        $stream = $this->getAttribute('stream');

        // Drop the column if it exists
        if ($schema->hasColumn($field->field_slug, $prefix.$stream->stream_prefix.$stream->stream_slug))
        {
            $schema->table($stream->stream_prefix.$stream->stream_slug, function ($table) use ($field, $stream, $prefix) {
                
                $table->dropColumn($field->field_slug);
            
            });            
        }

        // Run the destruct
        if ($type = $field->getType() and method_exists($type, 'field_assignment_destruct'))
        {
            $type->field_assignment_destruct($field, $stream);
        }

        // Update that stream's view options
        ;

        if ( ! empty($field->stream->view_options))
        {
            foreach ($field->stream->view_options as $key => $option)
            {
                if (isset($field->stream->view_options[$field->field_slug]))
                {
                    unset($field->stream->view_options[$field->field_slug]);
                }
            }
        }

        $field->stream->save();

        return parent::delete();
    }

    /**
     * Cleanup stale assignments for fields and streams that don't exists
     * @return [type] [description]
     */
    public static function cleanup()
    {
        $field_ids = Field::all()->modelKeys();

        $stream_ids = Stream::all()->modelKeys();

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
            Stream::updateTitleColumnByStreamIds($stream->id, $field->field_slug);
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
            Stream::updateTitleColumnByStreamIds($stream->id, $field->field_slug, $attributes['title_column']);    
        }

        return parent::update($attributes);
    }

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
     * @return \Pyro\Module\Streams_core\Core\Model\FieldAssignment|Collection|static
     */
    public static function findOrFail($id, $columns = array('*'))
    {
        if ( ! is_null($model = static::find($id, $columns))) return $model;

        throw new Exception\FieldAssignmentNotFoundException;
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