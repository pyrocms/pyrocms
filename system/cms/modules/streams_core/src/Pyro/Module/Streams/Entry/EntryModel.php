<?php namespace Pyro\Module\Streams\Entry;

use Illuminate\Support\Str;
use Pyro\FieldType\RelationshipInterface;
use Pyro\Model\Eloquent;
use Pyro\Module\Search\Model\Search;
use Pyro\Module\Streams\Exception\EntryModelNotFoundException;
use Pyro\Module\Streams\Stream\StreamModel;

/**
 * Entry model
 *
 * @author   PyroCMS Dev Team
 * @package  PyroCMS\Core\Modules\Streams\Model
 */
class EntryModel extends Eloquent implements RelationshipInterface
{
    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_BY = 'created_by';

    /**
     * Allow timestamp fields to be populated automatically
     *
     * @var string
     */
    public $timestamps = true;

    /**
     * Stream data
     *
     * @var array/null
     */
    protected static $streamData = array();
    /**
     * Relation fields
     *
     * @var array
     */
    protected static $relationFieldsData = array();
    /**
     * Custom Relation Methods
     *
     * @var array
     */
    protected static $customRelationFieldsMethods = array();
    protected $columns = array('*');
    /**
     * The attributes that aren't mass assignable
     *
     * @var array
     */
    protected $guarded = array('id');
    /**
     * The array of user columns that will be selected
     *
     * @var array
     */
    protected $createdByUserColumns = array('id', 'username', 'email');
    /**
     * Search index template
     *
     * @var mixed The configuration array or false
     */
    protected $searchIndexTemplate = false;
    /**
     * Collection class
     *
     * @var string
     */
    protected $collectionClass = 'Pyro\Module\Streams\Entry\EntryCollection';
    /**
     * Presenter class
     */
    protected $presenterClass = 'Pyro\Module\Streams\Entry\EntryPresenter';

    public static function eager($relations)
    {
        if ($relations === true) {
            $relations = static::getRelationFieldsMethods();
        }

        return static::with($relations);
    }

    /**
     * Get relation field methods
     */
    public static function getRelationFieldsMethods()
    {
        $relationMethods = static::getRelationFieldsSlugs();

        foreach ($relationMethods as $key => &$value) {
            $value = Str::camel($value);
        }

        return array_merge($relationMethods, static::$customRelationFieldsMethods);
    }

    /**
     * Get relation field slugs
     */
    public static function getRelationFieldsSlugs()
    {
        $relationFields = static::getRelationFields();

        return array_keys($relationFields);
    }

    /**
     * Get relation field data
     */
    public static function getRelationFields()
    {
        return static::$relationFieldsData;
    }

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @param  mixed $id
     * @param  array $columns
     * @return \Pyro\Module\Streams\Entry\EntryModel|Collection|static
     */
    public static function findOrFail($id, $columns = array('*'))
    {
        if (!is_null($model = static::find($id, $columns))) {
            return $model;
        }

        throw new EntryModelNotFoundException;
    }

    /**
     * Run fields through their pre-process
     * Just used for updating right now
     *
     * @access  public
     * @param   obj
     * @param   string
     * @param   int
     * @param   array   - update data
     * @param   skips   - optional array of skips
     * @param   bool    - set_missing_to_null. Should we set missing pieces of data to null
     *                  for the database?
     * @return  bool
     */
    public static function runFieldPreProcesses(
        $fields,
        $entry = null,
        $form_data = array(),
        $skips = array(),
        $set_missing_to_null = true
    ) {
        $return_data = array();

        if ($fields) {
            foreach ($fields as $field) {
                // If we don't have a post item for this field,
                // then simply set the value to null. This is necessary
                // for fields that want to run a preSave but may have
                // a situation where no post data is sent (like a single checkbox)
                if (!isset($form_data[$field->field_slug]) and $set_missing_to_null) {
                    $form_data[$field->field_slug] = null;
                }

                // If this is not in our skips list, process it.
                if (!in_array($field->field_slug, $skips)) {
                    $type = $field->getType($entry);
                    $type->setFormData($form_data);

                    if (!$type->alt_process) {
                        // If a preSave function exists, go ahead and run it
                        if (method_exists($type, 'preSave')) {
                            $return_data[$field->field_slug] = $type->preSave();

                            // We are unsetting the null values to as to
                            // not upset db can be null rules.
                            if (is_null($return_data[$field->field_slug])) {
                                unset($return_data[$field->field_slug]);
                            }
                        } else {
                            $return_data[$field->field_slug] = isset($form_data[$type->getFormSlug(
                            )]) ? $form_data[$type->getFormSlug()] : null;

                            // Make null - some fields don't like just blank values
                            if ($return_data[$field->field_slug] == '') {
                                $return_data[$field->field_slug] = null;
                            }
                        }
                    } else {
                        // If this is an alt_process, there can still be a preSave,
                        // it just won't return anything so we don't have to
                        // save the value
                        if (method_exists($type, 'preSave')) {
                            $type->preSave();
                        }
                    }
                }
            }
        }

        return $return_data;
    }

    /**
     * Is subclass of Entry
     *
     * @param  string $subclass
     * @param  string $class
     * @return boolean
     */
    public static function isSubclassOfEntryModel($subclass, $class = 'Pyro\Module\Streams\Entry\EntryModel')
    {
        if (!is_string($class) or !class_exists($subclass)) {
            return false;
        }

        $reflection = new \ReflectionClass($subclass);

        return $reflection->isSubclassOf($class);
    }

    public function getDefaultFields()
    {
        return array($this->getKeyName(), static::CREATED_AT, 'createdByUser');
    }

    /**
     * Get stream slug
     *
     * @return mixed
     */
    public function getStreamSlug()
    {
        return $this->getStream()->stream_slug;
    }

    /**
     * Get the stream object with assignments and field relations
     *
     * @return Pyro\Module\Streams\Entry\StreamModel
     */
    public static function getStream()
    {
        return StreamModel::object(static::$streamData);
    }

    /**
     * Get stream namespace
     *
     * @return mixed
     */
    public function getStreamNamespace()
    {
        return $this->getStream()->stream_namespace;
    }

    /**
     * Get entry type
     *
     * @param  string $field_slug
     * @return object
     */
    public function getFieldType($field_slug = '')
    {
        if (!$field = $this->getField($field_slug)) {
            return null;
        }

        if (!$type = $field->getType($this)) {
            return null;
        }

        $type->setStream($this->getStream());

        return $type;
    }

    /**
     * Get field
     *
     * @param  string $field_slug
     * @return object
     */
    public function getField($field_slug = '')
    {
        return $this->getAssignments()->findBySlug($field_slug);
    }

    /**
     * Get assignments
     *
     * @return [type] [description]
     */
    public function getAssignments()
    {
        return $this->getStream()->assignments;
    }

    /**
     * Get the related model's title for the Relationship field type
     *
     * @return string|integer
     */
    public function getFieldTypeRelationshipTitle()
    {
        return $this->getTitleColumnValue();
    }

    /**
     * Get field type relationship results
     *
     * @param $query
     * @return mixed
     */
    public function getFieldTypeRelationshipResults($query)
    {
        echo $this->limit(10)->where($this->getTitleColumn(), 'LIKE', '%' . $query . '%')->get();
    }

    /**
     * Get field type relationship value field
     *
     * @return string
     */
    public function getFieldTypeRelationshipValueField()
    {
        return $this->getKeyName();
    }

    /**
     * Get field type relationship search field
     *
     * @return string
     */
    public function getFieldTypeRelationshipSearchFields()
    {
        return (array)$this->getTitleColumn();
    }

    /**
     * Get title column value
     *
     * @return mixed The title column value or model key
     */
    public function getTitleColumnValue($default = null)
    {
        if (!$column = $default) {
            $column = $this->getTitleColumn();
        }

        return $this->getAttributeFromArray($column);
    }

    /**
     * Get title column
     *
     * @return string The title column or model key name
     */
    public function getTitleColumn()
    {
        $titleColumn = $this->getStream()->title_column;

        if (empty($titleColumn)) {
            $titleColumn = $this->getKeyName();
        }

        return $titleColumn;
    }

    /**
     * Get the related model's options for the Relationship field type
     *
     * @return array
     */
    public function getFieldTypeRelationshipOptions($type)
    {
        $options = $this->take(1000)
            ->orderBy($this->getTitleColumn(), 'asc')
            ->lists($this->getTitleColumn(), 'id');

        if ($type->isFilter) {
            if ($placeholder = $type->getPlaceholder('filter')) {
                $options = array('-----' => $placeholder) + $options;
            } else {
                $options = array('-----' => lang('global:select-any')) + $options;
            }
        } elseif (!$type->getField()->is_required and $placeholder = $type->getParameter('placeholder')) {
            $options = array('-----' => lang_label($placeholder)) + $options;
        }

        return $options;
    }

    /**
     * Get the presenter object
     *
     * @param array  $viewOptions
     * @param string $defaultFormat
     * @return Pyro\Support\Presenter|Pyro\Model\Eloquent
     */
    public function getPresenter($viewOptions = array(), $defaultFormat = null)
    {
        $decorator = new EntryPresenterDecorator;

        $viewOptions = EntryViewOptions::make($this, $viewOptions, $defaultFormat);

        return $decorator->setViewOptions($viewOptions)->decorate($this);
    }

    /**
     * Create a new form builder
     *
     * @return object
     */
    public function newFormBuilder(array $attributes = array())
    {
        $formBuilder = new EntryFormBuilder($this);

        return $formBuilder->mergeAttributes($attributes);
    }

    /**
     * Set search index template
     *
     * @param mixed $searchIndexTemplate
     */
    public function setSearchIndexTemplate($searchIndexTemplate = false)
    {
        $this->searchIndexTemplate = $searchIndexTemplate;

        return $this;
    }

    /**
     * Flush cache collection
     *
     * @return void
     */
    public function flushCacheCollection()
    {
        ci()->cache->collection($this->getCacheCollectionKey('entries'))->flush();
    }

    /**
     * Get cache collection key
     *
     * @return string
     */
    public function getCacheCollectionKey($suffix = 'entries')
    {
        return $this->getCacheCollectionPrefix() . $suffix;
    }

    /**
     * Get cache collection prefix
     *
     * @return string
     */
    public function getCacheCollectionPrefix()
    {
        return 'streams.' . $this->getStream()->stream_slug . '.' . $this->getStream()->stream_namespace . '.';
    }

    /**
     * Process data with field types before saving the model to the database.
     *
     * @param  array $options
     * @return bool
     */
    public function preSave($skips = array(), array $options = array())
    {
        $fields = $this->getAssignments();

        $insert_data = array();

        $alt_process = array();

        $types = array();

        $this->setEntryMeta();

        if ($this->replicated) {
            $attributes = array_except($this->getAttributes(), array($this->getKeyName()));
        } else {
            $attributes = $this->getAttributes();
        }

        $this->setRawAttributes($attributes);

        if (!$fields->isEmpty()) {
            foreach ($fields as $field) {
                $type = $field->getType($this);

                if (!in_array($field->field_slug, $skips)) {
                    $types[] = $type;

                    // We don't process the alt process stuff.
                    // This is for field types that store data outside of the
                    // actual table
                    if ($type->alt_process) {
                        $alt_process[] = $field->field_slug;
                    } else {
                        $this->setAttribute($type->getColumnName(), $type->preSave());
                    }
                } elseif ($default = $type->getDefault() and !$type->alt_process) {
                    $this->setAttribute($type->getColumnName(), $default);
                }
            }
        }

        foreach ($skips as $skip) {
            unset($this->{$skip});
            unset($this->{$skip . '_id'});
        }

        $saved = $this->save($options);

        // -------------------------------------
        // Alt Processing
        // -------------------------------------
        foreach ($fields as $field) {
            if (!in_array($field->field_slug, $skips)) {
                if (in_array($field->field_slug, $alt_process)) {
                    $type = $field->getType($this);
                    $type->preSave();
                }
            }
        }

        return $saved;
    }

    /**
     * Set entry information that every record needs
     *
     * @return EntryModel
     */
    public function setEntryMeta()
    {
        // Set some values for a new entry
        if (!$this->exists) {
            $created_by = (isset(ci()->current_user->id) and is_numeric(ci()->current_user->id))
                ? ci()->current_user->id
                : null;

            $this->setAttribute('created_by', $created_by);
            $this->setAttribute('updated_at', '0000-00-00 00:00:00');
            $this->setAttribute('ordering_count', $this->count('id') + 1);
        } else {
            $this->setAttribute('updated_at', time());
        }

        return $this;
    }

    public function save(array $options = array())
    {
        $new    = (!isset($this->id));
        $stream = $this->getStream();

        $this->setEntryMeta();

        if ($new) {
            \Events::trigger($stream->stream_namespace . '.' . $stream->stream_slug . '.entry.creating', $this);
        } else {
            \Events::trigger($stream->stream_namespace . '.' . $stream->stream_slug . '.entry.editing', $this);
        }

        \Events::trigger($stream->stream_namespace . '.' . $stream->stream_slug . '.entry.saving', $this);
        \Events::trigger('streams.entry.saving', $this);

        if ($saved = parent::save($options) and $this->searchIndexTemplate) {
            Search::indexEntry($this, $this->searchIndexTemplate);
        }

        // -------------------------------------
        // Event: Post Insert Entry
        // -------------------------------------

        $stream = $this->getStream();

        // @todo Deprecate this
        \Events::trigger('streams_post_insert_entry', $this);

        if ($new) {
            \Events::trigger($stream->stream_namespace . '.' . $stream->stream_slug . '.entry.created', $this);
        } else {
            \Events::trigger($stream->stream_namespace . '.' . $stream->stream_slug . '.entry.edited', $this);
        }

        \Events::trigger($stream->stream_namespace . '.' . $stream->stream_slug . '.entry.saved', $this);
        \Events::trigger('streams.entry.saved', $this);

        return $saved;
    }

    /**
     * Delete de model
     *
     * @return boolean
     */
    public function delete()
    {
        $stream = $this->getStream();

        // Delete index automatically per SAPI conventions
        if (!$search_index_module = $this->getModuleSlug()) {
            $search_index_module = $stream->stream_namespace;
        }

        $search_index_scope = $this->getStreamTypeSlug();

        Search::dropIndex($search_index_module, $search_index_scope, $this->id);


        // Run through destructs
        foreach ($this->getAssignments() as $field) {

            $field->getType($this)->entryDestruct();

        }

        // Fire before deleting an entry
        \Events::trigger('streams_pre_delete_entry', $this);
        \Events::trigger('streams.entry.deleting', $this);
        \Events::trigger($stream->stream_namespace . '.' . $stream->stream_slug . '.entry.deleting', $this);

        $deleted = parent::delete();

        // Fire after deleting an entry
        \Events::trigger('streams_post_delete_entry', $this->id);
        \Events::trigger('streams.entry.deleted', $this);
        \Events::trigger($stream->stream_namespace . '.' . $stream->stream_slug . '.entry.deleted', $this);

        return $deleted;
    }

    /**
     * Get model slug
     *
     * @return string
     */
    public function getModuleSlug()
    {
        $module = false;

        $entry_class = get_called_class();

        // Try to figure out if the module from an extended entry model
        if ($entry_class != 'Pyro\Module\Streams\Entry\EntryModel') {
            $folders = explode($entry_class, '\\');

            $module = isset($folders[2]) ? strtolower($folders[2]) : null;

            // Check if this module exists, set to null if it doesn't
            if (!module_exists($module)) {
                $module = false;
            }
        }

        return $module;
    }

    /**
     * Get stream type slug
     *
     * @return string
     */
    public function getStreamTypeSlug()
    {
        $stream = $this->getStream();

        return $stream->stream_slug . '.' . $stream->stream_namespace;
    }

    /**
     * Update ordering count
     *
     * @param  int $ordering_count
     * @return boolean
     */
    public function updateOrderingCount($ordering_count = null)
    {
        return $this->where($this->getKeyName(), $this->getKey())->update(array('ordering_count' => $ordering_count));
    }

    /**
     * Get columns exluding
     *
     * @param  array $columns [description]
     * @return array
     */
    public function getAllColumnsExclude()
    {
        return array_diff($this->getAllColumns(), $this->model->getColumns());
    }

    /**
     * Get all columns
     *
     * @return array
     */
    public function getAllColumns()
    {
        return array_merge($this->getStandardColumns(), $this->getFieldSlugs(), $this->getAttributeKeys());
    }

    /**
     * Get all the non-field standard columns for entries as an array
     *
     * @return array An array of standard columns
     */
    public function getStandardColumns()
    {
        return array_merge(array($this->getKeyName()), $this->getDates(), array(static::CREATED_BY));
    }

    /**
     * Get the dates the should use Carbon
     *
     * @return array The array of date columns
     */
    public function getDates()
    {
        $dates = array(static::CREATED_AT, static::UPDATED_AT);

        if ($this->softDelete) {
            $dates = array_push($dates, static::DELETED_AT);
        }

        return $dates;
    }

    /* Created by user format
     * @return [type] [description]
     */

    /**
     * Get field slugs
     *
     * @return array
     */
    public function getFieldSlugs()
    {
        return $this->getAssignments()->getFieldSlugs();
    }

    public function createdByUser()
    {
        return $this->belongsTo('\Pyro\Module\Users\Model\User', 'created_by')->select($this->createdByUserColumns);
    }

    /**
     * Get a new query builder for the model's table.
     *
     * @param  bool $excludeDeleted
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newQuery($excludeDeleted = true)
    {
        $builder = new EntryQueryBuilder($this->newBaseQueryBuilder());

        // Once we have the query builders, we will set the model instances so the
        // builder can easily access any information it may need from the model
        // while it is constructing and executing various queries against it.
        $builder->setModel($this)->with($this->with);

        if ($excludeDeleted and $this->softDelete) {
            $builder->whereNull($this->getQualifiedDeletedAtColumn());
        }

        return $builder;
    }
}
