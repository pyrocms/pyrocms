<?php namespace Pyro\Module\Streams\FieldType;

use Illuminate\Support\Str;
use Pyro\Module\Streams\Entry\EntryModel;
use Pyro\Module\Streams\Field\FieldModel;
use Pyro\Module\Streams\Stream\StreamModel;

abstract class FieldTypeAbstract
{
    /**
     * Use alternative processing
     *
     * @todo  Do we need this anymore?
     * @var boolean
     */
    public $alt_process = false;
    /**
     * Database column type
     *
     * @var string
     */
    public $db_col_type = 'text';
    /**
     * The entry object
     *
     * @var object
     */
    public $entry = null;
    /**
     * Version
     *
     * @var string
     */
    public $version = '1.0.0';
    /**
     * Assets
     *
     * @var array
     */
    protected $assets = array();
    /**
     * Custom parameters
     *
     * @var array
     */
    protected $custom_parameters = array();
    /**
     * Default parameters
     *
     * @var array
     */
    protected $default_parameters = array('default_value');
    /**
     * Default values
     *
     * @var array
     */
    protected $defaults = null;
    /**
     * The field object
     *
     * @var object
     */
    protected $field = null;
    /**
     * The stream object
     *
     * @var object
     */
    protected $stream = null;
    /**
     * The model
     *
     * @var string
     */
    protected $model = null;
    /**
     * The array of pre save parameter values
     *
     * @var array
     */
    protected $pre_save_parameters = array();
    /**
     * Override the field slug use to get the current entry value
     *
     * @var [type]
     */
    protected $value_field_slug_override = null;
    /**
     * The relation class
     *
     * @var [type]
     */
    protected $relation = null;
    /**
     * The plugin object
     *
     * @var boolean
     */
    protected $plugin = null;

    /**
     * Applied filters
     *
     * @var null
     */
    protected $appliedFilters = null;

    public function pluginOutput()
    {
        return $this->stringOutput();
    }

    public function stringOutput()
    {
        return $this->value;
    }

    public function dataOutput()
    {
        return $this->stringOutput();
    }

    public function requireEntryColumns()
    {
        return array();
    }

    public function setPlugin($plugin = false)
    {
        $this->plugin = $plugin;

        return $this;
    }

    /**
     * Set method
     *
     * @param string $method
     */
    public function setMethod($method = 'new')
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Set value
     *
     * @param object $value
     */
    public function setValue($value = null)
    {
        $this->value = $value;

        return $this;
    }

    public function setValueFieldSlugOverride($value_field_slug_override = null)
    {
        $this->value_field_slug_override = $value_field_slug_override;

        return $this;
    }

    public function setAppliedFilters($filters = null)
    {
        $this->appliedFilters = $filters;

        return $this;
    }

    public function getCustomParameters()
    {
        return array_unique(array_merge($this->custom_parameters, $this->default_parameters));
    }

    /**
     * Get the field
     *
     * @return object
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Set field
     *
     * @param object $field
     */
    public function setField(FieldModel $field = null)
    {
        $this->field = $field;

        return $this;
    }

    public function fieldSlug()
    {
        return $this->field->field_slug;
    }

    /**
     * Set the pre save parameter values that will be available to param_[name]_preSave() callbacks
     *
     * @param array $pre_save_parameters The array of pre save parameter values
     */
    public function setPreSaveParameters($pre_save_parameters = array())
    {
        $this->pre_save_parameters = $pre_save_parameters;

        return $this;
    }

    /**
     * Get a pre save parameter value or return a default value if it is not set
     *
     * @param  [type] $name    [description]
     * @param  [type] $default [description]
     * @return [type]          [description]
     */
    public function getPreSaveParameter($name = null, $default = null)
    {
        return isset($this->pre_save_parameters[$name]) ? $this->pre_save_parameters[$name] : $default;
    }

    public function getFormSlugProperty()
    {
        return $this->getFormSlug($this->value_field_slug_override);
    }

    /**
     * Get form slug
     *
     * @return [type] [description]
     */
    public function getFormSlug($field_slug = null)
    {
        $field_slug = $field_slug ? $field_slug : $this->getColumnName();

        return $this->getFormSlugPrefix() . $field_slug;
    }

    /**
     * Get column name
     *
     * @return string
     */
    public function getColumnName()
    {
        return $this->field->field_slug;
    }

    /**
     * Get form slug prefix
     *
     * @return [type] [description]
     */
    public function getFormSlugPrefix()
    {
        return $this->getStream()->stream_namespace . '-' . $this->getStream()->stream_slug . '-';
    }

    /**
     * Get the stream
     *
     * @return object
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * Set the stream
     *
     * @param object $stream
     */
    public function setStream(StreamModel $stream = null)
    {
        $this->stream = $stream;

        return $this;
    }

    /**
     * Set the entry
     *
     * @param object $entry
     */
    public function setEntry(EntryModel $entry = null)
    {
        $this->entry = $entry;

        return $this;
    }

    /**
     * Set form data
     *
     * @param array $form_values
     */
    public function setFormValues(array $form_values = array())
    {
        $this->form_values = $form_values;

        return $this;
    }

    /**
     * Set form value
     *
     * @param      $key
     * @param null $value
     */
    public function setFormValue($key, $value = null)
    {
        $this->form_values[$key] = $value;

        return $this;
    }

    /**
     * Set the defaults
     *
     * @param array $defaults
     */
    public function setDefaults($defaults = array())
    {
        $this->defaults = $defaults;

        return $this;
    }

    /**
     * Get form values property
     *
     * @return array
     */
    public function getFormValuesProperty()
    {
        $form_values = array();

        foreach ($this->entry->getFieldSlugs() as $field_slug) {
            $form_values[$field_slug] = $this->getFormValue($field_slug);
        }

        return $form_values;
    }

    /**
     * Get the value
     *
     * @return mixed
     */
    public function getFormValue($field_slug = null, $default = null)
    {
        $field_slug = $field_slug ? $field_slug : $this->getColumnName();

        if (ci()->input->post() and ci()->input->post() !== null) {

            return $this->getPostValue($field_slug);

        } elseif ($value = $this->entry->getOriginal($field_slug)) {

            return $value;
        }

        return $default;
    }

    public function getPostValue($field_slug = null, $default = null)
    {
        $field_slug = $field_slug ? $field_slug : $this->getColumnName();

        if ($value = ci()->input->post($this->getFormSlug())) {
            return $value;
        } elseif ($value = ci()->input->post($this->getFormSlug() . '[]')) {
            return $value;
        }

        return $default;
    }

    public function getValueProperty()
    {
        return $this->getFormValue(
            $this->value_field_slug_override,
            $this->getDefault($this->value_field_slug_override, $this->getParameter('default_value'))
        );
    }

    /**
     * Get the default
     *
     * @param  string $key
     * @return mixed
     */
    public function getDefault($field_slug = null, $default = null)
    {
        $field_slug = $field_slug ? $field_slug : $this->field->field_slug;

        return isset($this->defaults[$field_slug]) ? $this->defaults[$field_slug] : $default;
    }

    /**
     * Get the field
     *
     * @return object
     */
    public function getParameter($key, $default = null)
    {
        return $this->field->getParameter($key, $default);
    }

    /**
     * Get the original value
     *
     * @param  boolean $plugin
     * @return mixed
     */
    public function getOriginalValue($field_slug = null)
    {
        $field_slug = $field_slug ? $field_slug : $this->field->field_slug;

        return $this->entry->getOriginal($field_slug);
    }

    /**
     * Get value
     *
     * @param mixed $value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get form
     *
     * @param  boolean
     * @return string|boolean
     */
    public function getForm($plugin = false)
    {
        // If this is for a plugin, this relies on a function that
        // many field types will not have
        if ($this->plugin and method_exists($this, 'formInputPlugin')) {
            return $this->formInputPlugin();
        } else {
            return $this->formInput();
        }

        return false;
    }

    /**
     * Output form input
     *
     * @param    array
     * @param    array
     * @return    string
     */
    public function formInput()
    {
        $options['name']         = $this->form_slug;
        $options['id']           = $this->form_slug;
        $options['value']        = $this->value;
        $options['class']        = 'form-control';
        $options['autocomplete'] = 'off';
        $options['placeholder']  = $this->getPlaceholder();

        if ($max_length = $this->getParameter('max_length') and is_numeric($max_length)) {
            $options['max_length'] = $max_length;
        }

        return form_input($options);
    }

    /**
     * Get filter output for a field type for plugin usage
     *
     * @return string
     */
    public function pluginFilterInput()
    {
        return $this->filterInput();
    }

    /**
     * Get filter output for a field type
     *
     * @return string The input HTML
     */
    public function filterInput()
    {
        $data = array(
            'name'        => $this->getFilterSlug('contains'),
            'value'       => $this->getFilterValue('contains'),
            'class'       => 'form-control',
            'placeholder' => $this->getPlaceholder(null, $this->field->field_name),
        );

        return form_input($data);
    }

    /**
     * Get filter slug
     *
     * @param string $condition
     * @param null   $field_slug
     * @return string
     */
    public function getFilterSlug($constraint = 'contains', $fieldSlug = null)
    {
        $fieldSlug = $fieldSlug ? $fieldSlug : $this->getColumnName();

        return $this->getFilterSlugPrefix() . $fieldSlug . '-' . $constraint;
    }

    /**
     * Get filter value
     *
     * @param string $constraint
     * @param null   $fieldSlug
     */
    public function getFilterValue($constraint = 'contains', $fieldSlug = null)
    {
        $fieldSlug = $fieldSlug ? $fieldSlug : $this->getColumnName();

        if (isset($this->appliedFilters[$fieldSlug . '-' . $constraint])) {
            return $this->appliedFilters[$fieldSlug . '-' . $constraint];
        }

        return null;
    }

    /**
     * Get filter slug segment
     *
     * @return string
     */
    public function getFilterSlugPrefix()
    {
        return 'f-' . $this->getStream()->stream_namespace . '-' . $this->getStream()->stream_slug . '-';
    }

    /**
     * Get is new property
     *
     * @return bool
     */
    public function getIsNewProperty()
    {
        return (!$this->entry or !$this->entry->getKey());
    }

    /**
     * Add a field type CSS file
     */
    public function css($file, $field_type = null)
    {
        $field_type = $field_type ? $field_type : $this->field_type_slug;

        $html = '<link href="' . base_url($this->path_css . $file) . '" type="text/css" rel="stylesheet" />';

        ci()->template->append_metadata($html);

        $this->assets[] = $html;
    }

    /**
     * Add a field type JS file
     */
    public function js($file, $field_type = null)
    {
        $field_type = $field_type ? $field_type : $this->field_type_slug;

        $html = '<script type="text/javascript" src="' . base_url($this->path_js . $file) . '"></script>';

        ci()->template->append_metadata($html);

        $this->assets[] = $html;
    }

    /**
     * Append etadata
     */
    public function appendMetadata($html)
    {
        ci()->template->append_metadata($html);

        ci()->assets[] = $html;
    }

    public function formInputRow()
    {
        return $this->view(
            $this->getParameter('form_input_row', 'module::streams_core/fields/form_input_row'),
            array('field_type' => $this)
        );
    }

    /**
     * Load a view from a field type
     *
     * @param    string
     * @param    string
     * @param    bool
     */
    public function view($view_slug, $data = array(), $field_type = null)
    {
        $field_type = $field_type ? $field_type : $this->field_type_slug;

        $view_path = '';

        if (Str::startsWith($view_slug, 'module::')) {

            $view_slug = str_replace('module::', '', $view_slug);

            $segments = explode('/', $view_slug);

            $module_slug = array_shift($segments);

            $view_slug = array_pop($segments);

            $module = ci()->moduleManager->get($module_slug);

            $view_path = FCPATH . $module['path'] . '/views/' . implode('/', $segments) . '/';

        } else {

            if ($field_type != $this->field_type_slug) {

                $type = Type::getType($field_type);

            } else {

                $type = $this;
            }

            $view_path = $type->path_views;
        }

        $paths = ci()->load->get_view_paths();

        ci()->load->set_view_path($view_path);

        $view_data = ci()->load->_ci_load(
            array('_ci_view' => $view_slug, '_ci_vars' => $this->objectToArray($data), '_ci_return' => true)
        );

        ci()->load->set_view_path($paths);

        return $view_data;
    }

    /**
     * Object to Array
     * Takes an object as input and converts the class variables to array key/vals
     * From CodeIgniter's Loader class - moved over here since it was protected.
     *
     * @param    object
     * @return    array
     */
    protected function objectToArray($object)
    {
        return (is_object($object)) ? get_object_vars($object) : $object;
    }

    public function getInput()
    {
        return defined('ADMIN_THEME') ? $this->formInput() : $this->publicFormInput();
    }

    /**
     * Output public form input
     *
     * @param    array
     * @param    array
     * @return    string
     */
    public function publicFormInput()
    {
        return $this->formInput();
    }

    /**
     * Get the results for the field type relation
     *
     * @return mixed
     */
    public function getRelationResult($attribute = null)
    {
        $attribute = $attribute ? $attribute : $this->field->field_slug;

        return $this->entry->getAttribute($attribute);
    }

    /**
     * Wrapper method for the Eloquent hasOne method
     *
     * @param  EntryModel $related
     * @param  string     $foreignKey
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function hasOne($related, $foreignKey = null, $localKey = null)
    {
        return array(
            'method'    => __FUNCTION__,
            'arguments' => func_get_args(),
        );
    }

    /**
     * Wrapper method for the Eloquent morphOne method
     *
     * @param  EntryModel $related
     * @param  string     $name
     * @param  string     $type
     * @param  string     $id
     * @return Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function morphOne($related, $name, $type = null, $id = null, $localKey = null)
    {
        return array(
            'method'    => __FUNCTION__,
            'arguments' => func_get_args(),
        );
    }

    /**
     * Wrapper method for the Eloquent belongsTo() method
     *
     * @param  EntryModel $related
     * @param  string     $foreignKey
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function belongsTo($related, $foreignKey = null)
    {
        return array(
            'method'    => __FUNCTION__,
            'arguments' => func_get_args(),
        );
    }

    /**
     * Wrapper method for the Eloquent morphTo() method
     *
     * @param  string $name
     * @param  string $type
     * @param  string $id
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function morphTo($name = null, $type = null, $id = null)
    {
        return array(
            'method'    => __FUNCTION__,
            'arguments' => func_get_args(),
        );
    }

    /**
     * Wrapper method for the Eloquent hasMany() method
     *
     * @param  EntryModel $related
     * @param  string     $foreignKey
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hasMany($related, $foreignKey = null)
    {
        return array(
            'method'    => __FUNCTION__,
            'arguments' => func_get_args(),
        );
    }

    /**
     * Wrapper method for the Eloquent morphMany() method
     *
     * @param  EntryModel $related
     * @param  string     $name
     * @param  string     $type
     * @param  string     $id
     * @return Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function morphMany($related, $name, $type = null, $id = null, $localKey = null)
    {
        return array(
            'method'    => __FUNCTION__,
            'arguments' => func_get_args(),
        );
    }

    /**
     * Wrapper method for the Eloquent belongsTo() method
     *
     * @param  EntryModel $related
     * @param  string     $table
     * @param  string     $foreignKey
     * @param  string     $otherKey
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function belongsToMany($related, $table = null, $foreignKey = null, $otherKey = null)
    {
        return array(
            'method'    => __FUNCTION__,
            'arguments' => func_get_args(),
        );
    }

    /**
     * Define a polymorphic many-to-many relationship.
     *
     * @param  string $related
     * @param  string $name
     * @param  string $table
     * @param  string $foreignKey
     * @param  string $otherKey
     * @param  bool   $inverse
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function morphToMany($related, $name, $table = null, $foreignKey = null, $otherKey = null, $inverse = false)
    {
        return array(
            'method'    => __FUNCTION__,
            'arguments' => func_get_args(),
        );
    }

    /**
     * Has relation
     *
     * @return boolean
     */
    public function hasRelation()
    {
        $relationArray = $this->relation();

        if (!is_array($relationArray) or empty($relationArray)) {
            return false;
        }

        if (!empty($relationArray['method']) and in_array(
                $relationArray['method'],
                $this->getValidRelationMethods()
            )
        ) {
            return true;
        }
    }

    public function relation()
    {
        return null;
    }

    protected function getValidRelationMethods()
    {
        return array(
            'hasOne',
            'morphOne',
            'belongsTo',
            'morphTo',
            'hasMany',
            'morphMany',
            'belongsToMany',
            'morphToMany',
        );
    }

    /**
     * Pre Save
     *
     * @return mixed
     */
    public function preSave()
    {
        return $this->value;
    }

    public function runPreSave()
    {
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
            $this->setFormData($form_data);

            if (!$type->alt_process) {
                $return_data[$field->field_slug] = $type->preSave();
            } else {
                // If this is an alt_process, there can still be a preSave,
                // it just won't return anything so we don't have to
                // save the value
                $type->preSave();
            }
        }
    }

    /**
     * Relation class
     *
     * @return string
     */
    public function getRelationClass($default = null)
    {
        // Fallback default
        if (!$default and $this->getParameter('stream')) {
            list($stream, $namespace) = explode('.', $this->getParameter('stream'));
            if (isset($stream) and isset($namespace)) {
                $default = StreamModel::getEntryModelClass($stream, $namespace);
            }
        }

        return $this->getParameter('relation_class', $default);
    }

    /**
     * Run when the form is built per field type
     *
     * @return void
     */
    public function event()
    {
    }

    /**
     * Run when a table is built per field type
     *
     * @return void
     */
    public function filterEvent()
    {
    }

    /**
     * Run when the public form is built per field type
     *
     * @return void
     */
    public function publicEvent()
    {
    }

    /**
     * Run when the form is built per field
     *
     * @return void
     */
    public function fieldEvent()
    {
    }

    /**
     * Run when a table is built per field
     *
     * @return void
     */
    public function filterFieldEvent()
    {
    }

    /**
     * Run when the public form is built per field
     *
     * @return void
     */
    public function publicFieldEvent()
    {
    }

    /**
     * Ran when a field assignment is removed from a stream
     *
     * @return [type] [description]
     */
    public function fieldAssignmentDestruct()
    {
    }

    /**
     * Ran when an entry is deleted
     *
     * @return void
     */
    public function entryDestruct()
    {
    }

    /**
     * Ran when a namespace is destroyed
     *
     * @return void
     */
    public function namespaceDestruct()
    {
    }

    /**
     * Generate a cache key based on attributes
     *
     * @return string
     */
    public function generateCacheKey()
    {
        return md5(
            implode(
                '-',
                $this->field->field_data
            ) . '-' . $this->field->field_type . '-' . $this->field->field_slug . '-' . $this->getStream(
            )->stream_slug . '-' . $this->getStream()->stream_namespace . '-' . $this->entry->id
        );
    }

    /**
     * Get the placeholder.
     *
     * @param null $type
     * @return string
     */
    public function getPlaceholder($type = null, $default = null)
    {
        if (!$default) {
            $default = lang_label($this->getParameter('placeholder'));
        }

        return lang(
            $this->getStream()->stream_namespace .
            '.field.' . $this->field->field_slug .
            ($type ? $type . '_' : null) . '.placeholder'
        ) ?: $default;
    }

    /**
     * Dynamic method call
     *
     * @param  array  $method
     * @param  string $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        if (preg_match('/^get(.+)Value$/', $method, $matches)) {
            $default = isset($arguments[0]) ? $arguments[0] : null;

            return $this->getPostValue($this->field->field_slug . '_' . Str::snake($matches[1]), $default);
        }

        return null;
    }

    /**
     * Get dynamic property
     *
     * @param  string
     * @return mixed
     */
    public function __get($key)
    {
        return $this->getProperty($key);
    }

    public function getProperty($key)
    {
        $method = 'get' . Str::studly($key) . 'Property';

        if (method_exists($this, $method)) {
            return $this->$method($key);
        }

        return null;
    }

    /**
     * Convert the object to string when treated as such
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode($this);
    }
}
