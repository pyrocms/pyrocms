<?php namespace Pyro\Module\Streams_core;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Pyro\Model\Eloquent;
use Pyro\Module\Search\Model\Search;
use Pyro\Module\Users\Model\User;

/**
 * Entry model
 *
 * @author   PyroCMS Dev Team
 * @package  PyroCMS\Core\Modules\Streams_core\Models
 */
class EntryModel extends Eloquent
{
    protected $columns = array('*');

    /**
     * The attributes that aren't mass assignable
     * @var array
     */
    protected $guarded = array('id');

    /**
     * The array of user columns that will be selected
     * @var array
     */
    protected $user_columns = array('id', 'username');

    /**
     * Field type instances
     * @var array
     */
    protected $field_type_instances = null;

    /**
     * Field maps
     * @var array
     */
    protected $field_maps = array();

    /**
     * Format mode
     * @var string
     */
    protected $format = 'eloquent';

    /**
     * Search index template
     * @var mixed The configuration array or false
     */
    protected $search_index_template = false;

    /**
     * View options
     * @var array
     */
    protected $view_options = array('*');

    /**
     * Default view options
     * @var array
     */
    protected $default_view_options = array('id', 'created_by');

    /**
     * Skip field slugs
     * @var array
     */
    protected $skip_field_slugs = array();

    /**
     * Process the model with field types
     */
    protected $streamProcess = false;

    /**
     * Disable pre save
     * @var boolean
     */
    protected $disable_pre_save = false;

    protected $disable_field_maps = false;

    /**
     * Stream data
     * @var array/null
     */
    protected static $streamData = array();

    /**
     * Relation fields
     * @var array
     */
    protected static $relationFieldsData = array();

    /**
     * The name of the "created at" column.
     * @var string
     */
    const CREATED_BY        = 'created_by';

    /**
     * Format Eloquent Constant
     */
    const FORMAT_ELOQUENT   = 'eloquent';

    /**
     * Format Original Constant
     */
    const FORMAT_ORIGINAL   = 'original';

    /**
     * Format Data Constant
     */
    const FORMAT_DATA       = 'data';

    /**
     * Format Plugin Constant
     */
    const FORMAT_PLUGIN     = 'plugin';

    /**
     * Format String Constant
     */
    const FORMAT_STRING     = 'string';

    public function setStreamProcess($streamProcess = false)
    {
        $this->streamProcess = $streamProcess;

        return $this;
    }

    /**
     * Format entry as data
     * @param  array $attribute_keys
     * @return object
     */
    public function asData($attribute_keys = null)
    {
        $this->format = static::FORMAT_DATA;

        return $this->replicateWithOutput($attribute_keys);
    }

    /**
     * Keep entry format as Eloquent
     * @param  array $attribute_keys
     * @return object
     */
    public function asEloquent()
    {
        $this->format = static::FORMAT_ELOQUENT;

        return $this;
    }

    /**
     * Keep entry format as Original
     * @param  array $attribute_keys
     * @return object
     */
    public function asOriginal()
    {
        $this->format = static::FORMAT_ORIGINAL;

        return $this;
    }

    /**
     * Format entry for Plugin use
     * @param  array $attribute_keys
     * @return object
     */
    public function asPlugin($attribute_keys = null)
    {
        $this->format = static::FORMAT_PLUGIN;

        return $this->replicateWithOutput($attribute_keys);
    }

    /**
     * Form entry as String
     * @param  array $attribute_keys
     * @return object
     */
    public function asString($attribute_keys = null)
    {
        $this->format = static::FORMAT_STRING;

        return $this->replicateWithOutput($attribute_keys);
    }

    /**
     * Get entry
     * @param  string $stream_slug
     * @param  string $stream_namespace
     * @return object
     */
    public static function getEntry($stream_slug, $stream_namespace = null)
    {
        return static::stream($stream_slug, $stream_namespace)->find($id);
    }

    /**
     * Delete an entry
     * @param  string $stream_slug
     * @param  string $stream_namespace
     * @param  integer $id
     * @return boolean
     */
    public static function deleteEntry($stream_slug, $stream_namespace = null, $id)
    {
        $entry = static::getEntry($stream_slug, $stream_namespace, $id);

        return $entry->delete();
    }

   /**
     * Get data from a stream.
     *
     * Only really shown on the back end.
     *
     * @param   obj
     * @param   obj
     * @param   int
     * @param   int
     * @return  obj
     */
    public function getEntries($limit = null, $offset = 0, $order = null, $filter_data = array())
    {
        return static::stream($stream_slug, $stream_namespace)->get();
    }

    /**
     * Get stream slug
     * @return mixed
     */
    public function getStreamSlug()
    {
        return $this->getStream()->stream_slug;
    }

    /**
     * Get stream namespace
     * @return mixed
     */
    public function getStreamNamespace()
    {
        return $this->getStream()->stream_namespace;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function setColumns($columns = array('*'))
    {
        $this->columns = $columns;

        return $this;
    }

    /**
     * Set fields
     * @param array $fields
     */
    public function setFields($fields = array())
    {
        $this->fields = FieldCollection::make($fields);

        return $this;
    }

    public function setSkipFieldSlugs($skip_field_slugs = array())
    {
        $this->$skip_field_slugs = $skip_field_slugs;

        return $this;
    }

    public function disablePreSave($disable_pre_save = false)
    {
        $this->disable_pre_save = $disable_pre_save;

        return $this;
    }

    /**
     * Get assignments
     * @return [type] [description]
     */
    public function getAssignments()
    {
        return $this->getStream()->assignments;
    }

    /**
     * Get field
     * @param  string $field_slug
     * @return object
     */
    public function getField($field_slug = '')
    {
        return $this->getAssignments()->findBySlug($field_slug);
    }

    /**
     * Get entry type
     * @param  string $field_slug
     * @return object
     */
    public function getFieldType($field_slug = '')
    {
        if (! $field = $this->getField($field_slug)) return null;

        $type = $field->getType($this);

        $type->setStream($this->getStream());

        return $type;
    }

    /**
     * Get field slugs
     * @return array
     */
    public function getFieldSlugs()
    {
        return $this->getAssignments()->getFieldSlugs();
    }

    public function setFieldMaps($field_maps = array())
    {
        $this->field_maps = $field_maps;

        return $this;
    }

    /**
     * Is data format
     * @return boolean
     */
    public function isDataFormat()
    {
        return ($this->format == static::FORMAT_DATA);
    }

    /**
     * Is eloquent format
     * @return boolean
     */
    public function isEloquentFormat()
    {
        return ($this->format == static::FORMAT_ELOQUENT);
    }

    /**
     * Is original format
     * @return boolean
     */
    public function isOriginalFormat()
    {
        return ($this->format == static::FORMAT_ORIGINAL);
    }

    /**
     * Is plugin format
     * @return boolean
     */
    public function isPluginFormat()
    {
        return ($this->format == static::FORMAT_PLUGIN);
    }

    /**
     * Is string format
     * @return boolean
     */
    public function isStringFormat()
    {
        return ($this->format == static::FORMAT_STRING);
    }

    /**
     * What format dawg?
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Create a new form builder
     * @return object
     */
    public function newFormBuilder()
    {
        return new EntryFormBuilder($this);
    }

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @param  mixed  $id
     * @param  array  $columns
     * @return \Pyro\Module\Streams_core\EntryModel|Collection|static
     */
    public static function findOrFail($id, $columns = array('*'))
    {
        if ( ! is_null($model = static::find($id, $columns))) return $model;

        throw new Exception\EntryModelNotFoundException;
    }

    public function getRelation($attribute)
    {
        if (isset($this->relations[$attribute])) return $this->relations[$attribute];

        return null;
    }

    /**
     * Set search index template
     * @param mixed $search_index_template
     */
    public function setSearchIndexTemplate($search_index_template = false)
    {
        $this->search_index_template = $search_index_template;

        return $this;
    }

    /**
     * Get cache collection key
     * @return string
     */
    public function getCacheCollectionKey($suffix = 'entries')
    {
        return $this->getCacheCollectionPrefix().$suffix;
    }

    /**
     * Get cache collection prefix
     * @return string
     */
    public function getCacheCollectionPrefix()
    {
        return 'streams.'.$this->getStream()->stream_slug.'.'.$this->getStream()->stream_namespace.'.';
    }

    public function flushCacheCollection()
    {
        ci()->cache->collection($this->getCacheCollectionKey('entries'))->flush();
    }

    /**
     * Save the model to the database.
     *
     * @param  array  $options
     * @return bool
     */
    public function save(array $options = array())
    {
        $this->flushCacheCollection();

        // Allways the format as eloquent for saving
        $this->asEloquent();

        $fields = $this->getAssignments();

        $insert_data = array();

        $alt_process = array();

        $types = array();

        // Set some values for a new entry
        if ( ! $this->exists) {
            $created_by = (isset(ci()->current_user->id) and is_numeric(ci()->current_user->id)) ? ci()->current_user->id : null;

            $this->setAttribute('created_by', $created_by);
            $this->setAttribute('updated_at', '0000-00-00 00:00:00');
            $this->setAttribute('ordering_count', $this->count('id')+1);
        } else {
            $this->setAttribute('updated_at', time());
        }


        if ($this->replicated) {
            $attributes = array_except($this->getAttributes(), array($this->getKeyName()));
        } else {
            $attributes = $this->getAttributes();
        }

        $this->setRawAttributes($attributes);

        if ($this->streamProcess) {

            if ( ! $fields->isEmpty() and ! $this->disable_pre_save) {
                foreach ($fields as $field) {
                    // or (in_array($field->field_slug, $skips) and isset($_POST[$field->field_slug]))
                    if ( ! in_array($field->field_slug, $this->skip_field_slugs)) {

                        $type = $field->getType($this);
                        $types[] = $type;

                        // We don't process the alt process stuff.
                        // This is for field types that store data outside of the
                        // actual table
                        if ($type->alt_process) {
                            $alt_process[] = $field->field_slug;
                        } else {
                            $this->setAttribute($type->getColumnName(), $type->preSave());
                        }
                    }
                }
            }            
        }

        // -------------------------------------
        // Insert data
        // -------------------------------------

        // Is there any logic to complete before inserting?
        //if ( \Events::trigger('streams_pre_insert_entry', array('stream' => $this->stream, 'insert_data' => $this->getAttributes())) === false ) return false;

        if ($saved = parent::save($options) and $this->search_index_template) {
            Search::indexEntry($this, $this->search_index_template);
        }

        if ($this->streamProcess) {

            // -------------------------------------
            // Alt Processing
            // -------------------------------------
            foreach ($fields as $field) {
                if (! in_array($field->field_slug, $this->skip_field_slugs)) {
                    if (in_array($field->field_slug, $alt_process)) {
                        $type = $field->getType($this);
                        $type->preSave();
                    }
                }
            }
        }
        // -------------------------------------
        // Event: Post Insert Entry
        // -------------------------------------

        \Events::trigger('streams_post_insert_entry', $this);

        return $saved;
    }

    /**
     * Delete de model
     * @return boolean
     */
    public function delete()
    {
        // Delete index automatically per SAPI conventions
        if ( ! $search_index_module = $this->getModuleSlug()) {
            $search_index_module = $this->getStream()->stream_namespace;
        }

        $search_index_scope = $this->getStreamTypeSlug();

        Search::dropIndex($search_index_module, $search_index_scope, $this->id);


        // Run through destructs
        foreach ($this->getAssignments() as $field) {

            $field->getType($this)->entryDestruct();

        }

        // Fire before deleting an entry
        \Events::trigger('streams_pre_delete_entry', $this);

        $deleted = parent::delete();

        // Fire after deleting an entry
        \Events::trigger('streams_post_delete_entry', $this->id);

        return $deleted;
    }

    /**
     * Get model slug
     * @return string
     */
    public function getModuleSlug()
    {
        $module = false;

        $entry_class = get_called_class();

        // Try to figure out if the module from an extended entry model
        if ($entry_class != 'Pyro\Module\Streams_core\EntryModel') {
            $folders = explode($entry_class, '\\');

            $module = isset($folders[2]) ? strtolower($folders[2]) : null;

            // Check if this module exists, set to null if it doesn't
            if ( ! module_exists($module)) {
                $module = false;
            }
        }

        return $module;
    }

    /**
     * Get stream type slug
     * @return string
     */
    public function getStreamTypeSlug()
    {
        $stream = $this->getStream();

        return $stream->stream_slug.'.'.$stream->stream_namespace;
    }

    /**
     * Update ordering count
     * @param  int $ordering_count
     * @return boolean
     */
    public function updateOrderingCount($ordering_count = null)
    {
        return $this->where($this->getKeyName(), $this->getKey())->update(array('ordering_count' => $ordering_count));
    }

    /**
     * Run fields through their pre-process
     *
     * Just used for updating right now
     *
     * @access  public
     * @param   obj
     * @param   string
     * @param   int
     * @param   array - update data
     * @param   skips - optional array of skips
     * @param   bool - set_missing_to_null. Should we set missing pieces of data to null
     *                  for the database?
     * @return  bool
     */
    public static function runFieldPreProcesses($fields, $entry = null, $form_data = array(), $skips = array(), $set_missing_to_null = true)
    {
        $return_data = array();

        if ($fields) {
            foreach ($fields as $field) {
                // If we don't have a post item for this field,
                // then simply set the value to null. This is necessary
                // for fields that want to run a preSave but may have
                // a situation where no post data is sent (like a single checkbox)
                if ( ! isset($form_data[$field->field_slug]) and $set_missing_to_null) {
                    $form_data[$field->field_slug] = null;
                }

                // If this is not in our skips list, process it.
                if ( ! in_array($field->field_slug, $skips)) {
                    $type = $field->getType($entry);
                    $type->setFormData($form_data);

                    if ( ! $type->alt_process) {
                        // If a preSave function exists, go ahead and run it
                        if (method_exists($type, 'preSave')) {
                            $return_data[$field->field_slug] = $type->preSave();

                            // We are unsetting the null values to as to
                            // not upset db can be null rules.
                            if (is_null($return_data[$field->field_slug])) {
                                unset($return_data[$field->field_slug]);
                            }
                        } else {
                            $return_data[$field->field_slug] = isset($form_data[$type->getFormSlug()]) ? $form_data[$type->getFormSlug()] : null;

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

    public function runFieldPreSave()
    {

    }

    /**
     * Get all the non-field standard columns for entries as an array
     * @return array An array of standard columns
     */
    public function getStandardColumns()
    {
        return array_merge(array($this->getKeyName()), $this->getDates(), array(static::CREATED_BY));
    }

    /**
     * Get all columns
     * @return array
     */
    public function getAllColumns()
    {
        return array_merge($this->getStandardColumns(), $this->getFieldSlugs(), $this->getAttributeKeys());
    }

    /**
     * Get columns exluding
     * @param  array  $columns [description]
     * @return array
     */
    public function getAllColumnsExclude()
    {
       return array_diff($this->getAllColumns(), $this->model->getColumns());
    }

    /**
     * Set view options
     * @param $columns
     */
    public function setViewOptions(array $columns = null)
    {
        if ($columns) {
            $this->view_options = $columns;
        }

        return $this;
    }

    /**
     * Get view options
     * @return array
     */
    public function getViewOptions()
    {
        if ($this->hasAsterisk($this->view_options)) {

            if ($stream_view_options = $this->getStream()->view_options and ! empty($stream_view_options)) {
                return $stream_view_options;
            } else {
                return $this->default_view_options;
            }
        }

        return $this->view_options;
    }

    public function getViewOptionsFields()
    {
        $columns = array();

        foreach ($this->getViewOptions() as $key => $column) {

            if (is_string($key)) {

                $segments = explode(':', $key);

                $columns[] = $segments[count($segments)-1];

            } else {

                $columns[] = $column;

            }
        }

        return $columns;
    }

    /**
     * Get view options field names
     * @return array
     */
    public function getViewOptionsFieldNames()
    {
        $field_names = array();

        $fields = $this->getAssignments()->getArrayIndexedBySlug();

        foreach ($this->getViewOptions() as $key => $value) {
            if (Str::startsWith($key, 'lang:')) {
                $field_names[$value] = lang_label($key);

                continue;
            }

            $value = is_numeric($key) ? $value : $key;

            $segments = explode(':', $value);

            $value = $segments[count($segments)-1];

            $field_names[$value] = isset($fields[$value]) ? $fields[$value]->field_name : 'lang:streams:'.$value.'.name';
        }

        foreach ($field_names as &$value) {
            $value = lang_label($value);
        }

        return $field_names;
    }

    /**
     * Get title column value
     * @return mixed The title column value or model key
     */
    public function getTitleColumnValue($default = null)
    {
        if ( ! $column = $default) {
            $column = $this->getTitleColumn();
        }

        return $this->getEloquentOutput($column);
    }

    /**
     * Get title column
     * @return string The title column or model key name
     */
    public function getTitleColumn()
    {
        $title_column = $this->getStream()->title_column;

        // Default to ID for title column
        if (! trim($title_column) or ! $this->getEloquentOutput($title_column)) {
            $title_column = $this->getKeyName();
        }

        return $title_column;
    }

    /**
     * Get the stream object with assignments and field relations
     * @return Pyro\Module\Streams_core\StreamModel
     */
    public static function getStream()
    {
        return StreamModel::object(static::$streamData);
    }

    /**
     * Get relation field data
     */
    public static function getRelationFields()
    {
        return static::$relationFieldsData;
    }

    /**
     * Get relation field slugs
     */
    public static function getRelationFieldsSlugs()
    {
        $relationFields = static::getRelationFields();

        if (empty($relationFields)) return null;

        return array_keys($relationFields);
    }

    /**
     * Get the dates the should use Carbon
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
    public function createdByUser()
    {
        return $this->belongsTo('\Pyro\Module\Users\Model\User', 'created_by')->select($this->user_columns);
    }

    /**
     * Is subclass of Entry
     * @param  string  $subclass
     * @param  string  $class
     * @return boolean
     */
    public static function isSubclassOfEntryModel($subclass, $class = 'Pyro\Module\Streams_core\EntryModel')
    {
        if ( ! is_string($class) or ! class_exists($subclass)) return false;

        $reflection = new \ReflectionClass($subclass);

        return $reflection->isSubclassOf($class);
    }

    public function toOutputArray()
    {
        $output = array();

        foreach ($this->getAttributeKeys() as $attribute) {

            $output[$attribute] = $this->getOutput($attribute);

        }

        return $output;
    }

    public function getEloquentOutput($attribute)
    {
        return parent::getAttribute($attribute);
    }

    public function getOriginalOutput($attribute)
    {
        return $this->getOriginal($attribute);
    }

    public function getDataOutput($attribute)
    {
        if ($type = $this->getFieldType($attribute)) {

            $type->setStream($this->getStream());

            return $type->dataOutput($attribute);
        }

        return $this->getEloquentOutput($attribute);
    }

    public function getPluginOutput($attribute)
    {
        if ($type = $this->getFieldType($attribute)) {

            // Set value - entry - stream
            $type->setValue($this->{$attribute})->setEntry($this)->setStream($this->stream);

            return $type->pluginOutput($attribute);
        } elseif ($attribute == 'id') {
            return (string) $this->id;
        }

        return $this->getEloquentOutput($attribute);
    }

    /**
     * String output
     * @param  string
     * @return string
     */
    public function getStringOutput($attribute)
    {
        if ( ! empty($this->field_maps[$attribute]) and ! $this->disable_field_maps) {

            $template = $this->field_maps[$attribute];

            $entry = $this;

            if (is_array($template)) {
                $format = isset($template['format']) ? $template['format'] : null;

                switch ($format) {

                    case 'string':
                        $entry = $this->asString($attribute);
                        break;

                    case 'plugin':
                        $entry = $this->asPlugin($attribute);
                        break;

                    case 'data':
                        $entry = $this->asData($attribute);
                        break;

                    default:
                        $entry = $this;
                        break;
                }

                $template = isset($template['template']) ? $template['template'] : null;
            }

            return ci()->parser->parse_string($template, array('entry' => $entry->toArray()), true, false, array(
                'stream' => $this->stream_slug,
                'namespace' => $this->stream_namespace
            ));

        } elseif ($type = $this->getFieldType($attribute)) {

            return $type->stringOutput();

        }

        return $this->getEloquentOutput($attribute);
    }

    public function disableFieldMaps($disable_field_maps = false)
    {
        $this->disable_field_maps = $disable_field_maps;

        return $this;
    }

    public function getOutput($attribute)
    {
        // Disable field maps to avoid recursion
        $this->disableFieldMaps(true);

        // Get formatted output
        $output = $this->{'get'.Str::studly($this->format).'Output'}($attribute);

        // Reenable field maps
        $this->disableFieldMaps(false);

        return $output;
    }

    /**
     * Replicate
     * @return object The clone entry
     */
    public function replicate()
    {
        $entry = parent::replicate();

        $this->passProperties($entry);

        return $entry;
    }

    public function replicateWithOutput($attribute_keys = null)
    {
        if (is_string($attribute_keys)) {
            $attribute_keys = array($attribute_keys);
        }

        $clone = $this->replicate();

        if (empty($attribute_keys)) {
            $attribute_keys = $this->getAttributeKeys();
        }

        foreach ($attribute_keys as $attribute) {
            $clone->setAttribute($attribute, $this->getOutput($attribute));
        }

        return $clone;
    }

    /**
     * New collection instance
     * @param  array  $entries
     * @return object
     */
    public function newCollection(array $entries = array())
    {
        return new EntryCollection($entries);
    }

    /**
     * Get a new query builder for the model's table.
     *
     * @param  bool  $excludeDeleted
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

    /**
     * Pass properties
     * @param  object $instance
     * @return object
     */
    public function passProperties(EntryModel $model = null)
    {
        $model
            ->setFieldMaps($this->field_maps)
            ->setViewOptions($this->view_options);

        $model->exists = $model->getKey() ? true : false;

        return $model;
    }

    /**
     * Handle dynamic method calls into the method.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     */
/*    public function __call($method, $parameters)
    {
        // Handle dynamic relation as join
        if (preg_match('/^join([A-Z][a-z]+)$/', $method, $matches)) {
            return $this->relationAsJoin($matches[1]);
        }

        return parent::__call($method, $parameters);
    }
*/
    public function toJson($options = 0)
    {
        return json_encode($this->toOutputArray(), $options);
    }
}
