<?php namespace Pyro\Module\Streams_core;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

abstract class AbstractFieldType
{
	/**
	 * Use alternative processing
	 * @todo  Do we need this anymore?
	 * @var boolean
	 */
	public $alt_process = false;

	/**
	 * Assets
	 * @var array
	 */
	protected $assets = array();

	/**
	 * Custom parameters
	 * @var array
	 */
	protected $custom_parameters = array();

	/**
	 * Default parameters
	 * @var array
	 */
	protected $default_parameters = array('default_value');

	/**
	 * Default values
	 * @var array
	 */
	protected $defaults = null;

	/**
	 * The field object
	 * @var object
	 */
	protected $field = null;

	/**
	 * The stream object
	 * @var object
	 */
	protected $stream = null;

	/**
	 * The model
	 * @var string
	 */
	protected $model = null;

	/**
	 * The entry object
	 * @var object
	 */
	public $entry = null;

	/**
	 * The array of pre save parameter values
	 * @var array
	 */
	protected $pre_save_parameters = array();

	/**
	 * Override the field slug use to get the current entry value
	 * @var [type]
	 */
	protected $value_field_slug_override = null;

	/**
	 * The relation model
	 * @var [type]
	 */
	protected $relation = null;

	protected $plugin = false;

	/**
	 * Version
	 * @var string
	 */
	public $version = '1.0.0';

	public function stringOutput()
	{
		return $this->entry->getOriginal($this->fieldSlug());
	}

	public function pluginOutput()
	{
		return $this->entry->getOriginal($this->fieldSlug());
	}

	public function dataOutput()
	{
		return $this->entry->getOriginal($this->fieldSlug());
	}

	public function relation()
	{
		return null;
	}

	public function requireEntryColumns()
	{
		return array();
	}

	/**
	 * Set value
	 * @param mixed $value
	 */
	public function setValue($value = null)
	{
		$this->value = $value;
	}

	public function setPlugin($plugin = false)
	{
		$this->plugin = $plugin;

		return $this;
	}

	/**
	 * Set method
	 * @param string $method
	 */
	public function setMethod($method = 'new')
	{
		$this->method = $method;

		return $this;
	}

	/**
	 * Set field
	 * @param object $field
	 */
	public function setField(FieldModel $field = null)
	{
		$this->field = $field;

		return $this;
	}

	public function setValueFieldSlugOverride($value_field_slug_override = null)
	{
		$this->value_field_slug_override = $value_field_slug_override;

		return $this;
	}

	public function getCustomParameters()
	{
		return array_unique(array_merge($this->custom_parameters, $this->default_parameters));
	}

	/**
	 * Get the field
	 * @return object 
	 */
	public function getField()
	{
		return $this->field;
	}

	public function fieldSlug()
	{
		return $this->field->field_slug;
	}

	/**
	 * Set the pre save parameter values that will be available to param_[name]_preSave() callbacks
	 * @param array $pre_save_parameters The array of pre save parameter values
	 */
	public function setPreSaveParameters($pre_save_parameters = array())
	{
		$this->pre_save_parameters = $pre_save_parameters;

		return $this;
	}

	/**
	 * Get a pre save parameter value or return a default value if it is not set
	 * @param  [type] $name    [description]
	 * @param  [type] $default [description]
	 * @return [type]          [description]
	 */
	public function getPreSaveParameter($name = null, $default = null)
	{
		return isset($this->pre_save_parameters[$name]) ? $this->pre_save_parameters[$name] : $default;
	}

	/**
	 * Get the field
	 * @return object 
	 */
	public function getParameter($key, $default = null)
	{
		return $this->field->getParameter($key, $default);
	}

	/**
	 * Get the stream
	 * @return object 
	 */
	public function getStream()
	{
		return $this->stream;
	}

	/**
	 * Get form slug
	 * @return [type] [description]
	 */
	public function getFormSlug($field_slug = null)
	{
		$field_slug = $field_slug ? $field_slug : $this->field->field_slug;

		return $this->getFormSlugPrefix().$field_slug;
	}

	public function getFormSlugProperty()
	{
		return $this->getFormSlug($this->value_field_slug_override);
	}

	/**
	 * Get form slug prefix
	 * @return [type] [description]
	 */
	public function getFormSlugPrefix()
	{
		return $this->stream->stream_namespace.'-'.$this->stream->stream_slug.'-';
	}

	public function getFilterSlug($condition = 'contains', $field_slug = null)
	{
		$field_slug = $field_slug ? $field_slug : $this->field->field_slug;

		return $this->getFilterSlugPrefix().$field_slug.'-'.$condition;
	}

	/**
	 * Get filter slug segment
	 * @return string
	 */
	public function getFilterSlugPrefix()
	{
		return 'f-'.$this->stream->stream_namespace.'-'.$this->stream->stream_slug.'-';
	}

	/**
	 * Set the stream
	 * @param object $stream
	 */
	public function setStream(StreamModel $stream = null)
	{
		$this->stream = $stream;

		return $this;
	}

	/**
	 * Set the entry
	 * @param object $entry
	 */
	public function setEntry(EntryModel $entry = null)
	{
		$this->entry = $entry;

		return $this;
	}

	/**
	 * Set the entries
	 * @param array $entries
	 */
	public function setEntries(EntryCollection $entries = null)
	{
		$this->entries = $entries;

		return $this;
	}

	/**
	 * Set form data
	 * @param array $form_values
	 */
	public function setFormValues(array $form_values = array())
	{
		$this->form_values = $form_values;

		return $this;
	}

	public function setFormValue($key, $value = null)
	{
		$this->form_values[$key] = $value;
	}

	/**
	 * Set the defaults
	 * @param array $defaults
	 */
	public function setDefaults(array $defaults = array())
	{
		$this->defaults = $defaults;
	}

	/**
	 * Get the default
	 * @param  string $key
	 * @return mixed
	 */
	public function getDefault($field_slug = null, $default = null)
	{
		$field_slug = $field_slug ? $field_slug : $this->field->field_slug;

		return isset($this->defaults[$field_slug]) ? $this->defaults[$field_slug] : $default;
	}

	/**
	 * Get the value
	 * @return mixed
	 */
	public function getFormValue($field_slug = null, $default = null)
	{
		$field_slug = $field_slug ? $field_slug : $this->field->field_slug;

		if (ci()->input->post()) {

			return $this->getPostValue($field_slug);

		} elseif ($value = $this->entry->getOriginal($field_slug)) {

			return $value;
		}

		return $default;
	}

	public function getPostValue($field_slug = null, $default = null)
	{
		$field_slug = $field_slug ? $field_slug : $this->field->field_slug;

		if ($value = ci()->input->post($this->getFormSlug($field_slug)))
		{
			return $value;
		}
		elseif ($value = ci()->input->post($this->getFormSlug($field_slug).'[]'))
		{
			return $value;
		}

		return $default;
	}

	public function getFormValuesProperty()
	{
		$form_values = array();

		foreach($this->entry->getFieldSlugs() as $field_slug)
		{
			$form_values[$field_slug] = $this->getFormValue($field_slug);
		}

		return $form_values;
	}

	public function getValueProperty()
	{
		return $this->getFormValue($this->value_field_slug_override, $this->getDefault($this->value_field_slug_override, $this->getParameter('default_value')));
	}

	/**
	 * Get the original value
	 * @param  boolean $plugin
	 * @return mixed
	 */
	public function getOriginalValue($field_slug = null)
	{
		$field_slug = $field_slug ? $field_slug : $this->field->field_slug;

		return $this->entry->getOriginal($field_slug);
	}

	/**
	 * Get form
	 * @param  boolean
	 * @return string|boolean
	 */
	public function getForm($plugin = false)
	{
		// If this is for a plugin, this relies on a function that
		// many field types will not have
		if ($this->plugin and method_exists($this, 'formInputPlugin'))
		{
			return $this->formInputPlugin();
		}
		else
		{
			return $this->formInput();
		}

		return false;
	}

	/**
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function formInput()
	{
		$options['name'] 	= $this->form_slug;
		$options['id']		= $this->form_slug;
		$options['value']	= $this->value;
		$options['class'] 	= 'form-control';
		$options['placeholder'] = lang_label($this->getParameter('placeholder'));

		if ($max_length = $this->getParameter('max_length') and is_numeric($max_length))
		{
			$options['max_length'] = $max_length;
		}

		return form_input($options);
	}

	/**
	 * Get filter output for a field type
	 * @return string The input HTML
	 */
	public function filterInput()
	{
		return '<input type="text" name="'.$this->getFilterSlug('contains').'" value="'.ci()->input->get($this->getFilterSlug('contains')).'" class="form-control" placeholder="'.$this->field->field_name.'">';
	}

	/**
	 * Get is new property
	 * @return bool
	 */
	public function getIsNewProperty()
	{
		return ( ! $this->entry or ! $this->entry->getKey());
	}

	/**
	 * Add a field type CSS file
	 */
	public function css($file, $field_type = null)
	{
		$field_type = $field_type ? $field_type : $this->field_type_slug;
		
		$html = '<link href="'.site_url('streams_core/field_asset/css/'.$field_type.'/'.$file).'" type="text/css" rel="stylesheet" />';

		ci()->template->append_metadata($html);

		$this->assets[] = $html;
	}

	/**
	 * Add a field type JS file
	 */
	public function js($file, $field_type = null)
	{
		$field_type = $field_type ? $field_type : $this->field_type_slug;

		$html = '<script type="text/javascript" src="'.site_url('streams_core/field_asset/js/'.$field_type.'/'.$file).'"></script>';

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

	/**
	 * Load a view from a field type
	 *
	 * @param	string
	 * @param	string
	 * @param	bool
	 */
	public function view($view_name, $data = array(), $field_type = null)
	{
		$field_type = $field_type ? $field_type : $this->field_type_slug;

		if ($field_type != $this->field_type_slug)
		{
			$type = Type::getType($field_type);
		}
		else
		{
			$type = $this;
		}

		$paths = ci()->load->get_view_paths();

		ci()->load->set_view_path($type->path_views);

		$view_data = ci()->load->_ci_load(array('_ci_view' => $view_name, '_ci_vars' => $this->objectToArray($data), '_ci_return' => true));

		ci()->load->set_view_path($paths);

		return $view_data;
	}

	/**
	 * Get the results for the field type relation
	 * @return mixed
	 */
	public function getRelationResult($field_slug = null)
	{
		$field_slug = $field_slug ? $field_slug : $this->field->field_slug;
		
		// Check if we have a parent foreing key value and avoid making queries with null values
		$original = $this->getOriginalValue();

		if ($this->hasLocalForeingKey() and empty($original)) return null;

		// If the relation result exists, return it
		if ($relation = $this->entry->getRelation($field_slug)) {
			
			return $relation;
		
		} elseif ($this->hasRelation()) {
		
			return $this->relation()->getResults();
		
		}

		return null;
	}

	/**
	 * Check if the relation holds the foreing key on the parent table
	 * @return boolean
	 */
	public function hasLocalForeingKey()
	{
		return $this->relation() instanceof BelongsTo;
	}

	/**
	 * Wrapper method for the Eloquent belongsTo() method
	 * @param  [type] $related     [description]
	 * @param  [type] $foreign_key [description]
	 * @return [type]              [description]
	 */
	public function belongsTo($related, $foreign_key = null)
	{
		$foreign_key = $foreign_key ? $foreign_key : $this->field->field_slug;

		return $this->entry->belongsTo($related, $foreign_key);
	}

	/**
	 * Wrapper method for the Eloquent belongsToEntry() method
	 * @param  [type] $related     [description]
	 * @param  [type] $foreign_key [description]
	 * @return [type]              [description]
	 */
	public function belongsToEntry($related = 'Pyro\Module\Streams_core\EntryModel', $foreign_key = null, $stream = null)
	{
		$foreign_key = $foreign_key ? $foreign_key : $this->field->field_slug;

		return $this->entry->belongsToEntry($related, $foreign_key, $this->getParameter('stream', $stream));
	}

	/**
	 * Wrapper method for the Eloquent belongsToManyEntries() method
	 * @param  [type] $related     [description]
	 * @param  [type] $foreign_key [description]
	 * @return [type]              [description]
	 */
	public function belongsToManyEntries($related = 'Pyro\Module\Streams_core\EntryModel', $foreign_key = null, $other_key = null, $stream = null, $pivot_suffix = null)
	{
		$pivot_suffix = $pivot_suffix ? $pivot_suffix : $this->field->field_slug;

		$foreign_key = $foreign_key ? $foreign_key : 'entry_id';

		$other_key = $other_key ? $other_key : 'related_id';

		return $this->entry->belongsToManyEntries($related, $foreign_key, $other_key, $this->getParameter('stream', $stream), $pivot_suffix);
	}

	/**
	 * Wrapper method for the Eloquent hasMany() method
	 * @param  [type] $related     [description]
	 * @param  [type] $foreign_key [description]
	 * @return [type]              [description]
	 */
	public function hasManyEntries($related = 'Pyro\Module\Streams_core\EntryModel', $foreign_key = null, $stream = null)
	{
		$foreign_key = $foreign_key ? $foreign_key : 'entry_id';

		return $this->entry->hasManyEntries($related, $foreign_key, $this->getParameter('stream', $stream));
	}

	/**
	 * Has relation
	 * @return boolean
	 */
	public function hasRelation()
	{
		return ($this->relation() instanceof Relation);
	}

	/**
	 * Pre Save
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
        if ( ! isset($form_data[$field->field_slug]) and $set_missing_to_null)
        {
            $form_data[$field->field_slug] = null;
        }

        // If this is not in our skips list, process it.
        if ( ! in_array($field->field_slug, $skips))
        {
            $type = $field->getType($entry);
            $this->setFormData($form_data);

            if ( ! $type->alt_process)
            {
				$return_data[$field->field_slug] = $type->preSave();
            }
            else
            {
                // If this is an alt_process, there can still be a preSave,
                // it just won't return anything so we don't have to
                // save the value
            	$type->preSave();
            }
        }
	}

	/**
	 * Object to Array
	 *
	 * Takes an object as input and converts the class variables to array key/vals
	 *
	 * From CodeIgniter's Loader class - moved over here since it was protected.
	 *
	 * @param	object
	 * @return	array
	 */
	protected function objectToArray($object)
	{
		return (is_object($object)) ? get_object_vars($object) : $object;
	}

	public function getProperty($key)
	{
		$method = 'get'.Str::studly($key).'Property';

		if (method_exists($this, $method))
		{
			return $this->$method($key);
		}

		return null;
	}

	/**
	 * Ran when the form is built
	 * @return void
	 */
	public function event()
	{}

	/**
	 * Ran when a field assignment is removed from a stream
	 * @return [type] [description]
	 */
	public function fieldAssignmentDestruct()
	{}

	/**
	 * Ran when an entry is deleted
	 * @return void
	 */
	public function entryDestruct()
	{}

    /**
     * Ran when a namespace is destroyed
     * @return void
     */
    public function namespaceDestruct()
    {}

	/**
	 * Dynamic method call
	 * @param  array $method
	 * @param  string $arguments
	 * @return mixed
	 */
	public function __call($method, $arguments)
	{
		if (preg_match('/^get(.+)Value$/', $method, $matches))
		{
			$default = isset($arguments[0]) ? $arguments[0] : null;

			return $this->getPostValue($this->field->field_slug.'_'.Str::snake($matches[1]), $default);
		}

		return null;
	}

	/**
	 * Get dynamic property
	 * @param  string
	 * @return mixed
	 */
	public function __get($key)
	{
		return $this->getProperty($key);
	}

	/**
	 * Convert the object to string when treated as such
	 * @return string
	 */
	public function __toString()
	{
		return json_encode($this);
	}
}
