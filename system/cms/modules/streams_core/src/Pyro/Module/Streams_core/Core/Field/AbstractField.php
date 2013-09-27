<?php namespace Pyro\Module\Streams_core\Core\Field;

use Illuminate\Database\Eloquent\Relations;
use Pyro\Module\Streams_core\Core\Model;

abstract class AbstractField
{
	/**
	 * Use alternative processing
	 * @todo  Do we need this anymore?
	 * @var boolean
	 */
	public $alt_process = false;

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
	 * Unformatted value
	 * @var mixed
	 */
	protected $unformatted_value = null;

	/**
	 * Value
	 * @var mixed
	 */
	protected $value = null;

	/**
	 * Plugin call?
	 * @var boolean
	 */
	protected $plugin = false;

	/**
	 * Query injection
	 * @var string
	 */
	protected $query = null;

	/**
	 * The field object
	 * @var object
	 */
	protected $field = null;

	/**
	 * The unique input name like namespace:stream.slug
	 * @var string
	 */
	protected $form_slug = null;

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
	protected $entry = null;

	/**
	 * An array of entry objects
	 * @var array
	 */
	protected $entries = null;

	/**
	 * New or edit
	 * @var string
	 */
	protected $method = 'new';

	/**
	 * Form data
	 * @var array
	 */
	protected $form_data = array();

	/**
	 * The array of pre save parameter values
	 * @var array
	 */
	protected $pre_save_parameters = array();

	/**
	 * The relation model
	 * @var [type]
	 */
	protected $relation = null;

	/**
	 * Set value
	 * @param mixed $value
	 */
	public function setValue($value = null)
	{
		$this->value = $value;
	}

	/**
	 * Set unformatted value
	 * @param mixed $unformatted_value
	 */
	public function setUnformattedValue($unformatted_value = null)
	{
		$this->unformatted_value = $unformatted_value;
	}

	/**
	 * Set plugin property
	 * @param boolean $plugin
	 */
	public function setPlugin($plugin = null)
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
	 * Set entry builder
	 * @param object $builder
	 */
	public function setEntryBuilder(Model\Query\EntryBuilder $builder = null)
	{
		$this->builder = $builder;

		return $this;
	}

	/**
	 * Set field
	 * @param object $field
	 */
	public function setField(Model\Field $field = null)
	{
		$this->field = $field;

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

	/**
	 * Set the pre save parameter values that will be available to param_[name]_pre_save() callbacks
	 * @param array $pre_save_parameters The array of pre save parameter values
	 */
	public function setPreSaveParameters($pre_save_parameters = array())
	{
		$this->pre_save_parameters = $pre_save_parameters;
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
		return isset($this->field->field_data[$key]) ? $this->field->field_data[$key] : $default;
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
	 * Get the input name
	 * @return string 
	 */
	public function setFormSlug($form_slug = null)
	{
		if ($form_slug)
		{
			$this->form_slug = $form_slug;
		}
		elseif ($this->stream instanceof Model\Stream)
		{
			$this->form_slug = $this->stream->stream_namespace.'-'.$this->stream->stream_slug.'-'.$this->field->field_slug;
		}
	}

	public function getFormSlug()
	{
		return $this->form_slug;
	}

	/**
	 * Set the stream
	 * @param object $stream
	 */
	public function setStream(Model\Stream $stream = null)
	{
		$this->stream = $stream;

		return $this;
	}

	/**
	 * Set the model
	 * @param object $model
	 */
	public function setModel(Model\Entry $model = null)
	{
		$this->model = $model;

		return $this;
	}

	/**
	 * Set the entry
	 * @param object $entry
	 */
	public function setEntry(Model\Entry $entry = null)
	{
		$this->entry = $entry;

		return $this;
	}

	/**
	 * Set the entries
	 * @param array $entries
	 */
	public function setEntries(Model\Collection\EntryCollection $entries = null)
	{
		$this->entries = $entries;

		return $this;
	}

	/**
	 * Set form data
	 * @param array $form_data
	 */
	public function setFormData(array $form_data = array())
	{
		$this->form_data = $form_data;
	}

	/**
	 * Set the form data
	 * @param  string $key
	 * @return string
	 */
	public function getFormData($key = null)
	{
		return isset($this->form_data[$key]) ? $this->form_data[$key] : null;
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
	public function getDefault($key = null)
	{
		return isset($this->defaults[$key]) ? $this->defaults[$key] : null;
	}

	/**
	 * Get the value
	 * @return mixed
	 */
	public function getValue($default = null)
	{
		return $this->value ? $this->value : $default;
	}

	/**
	 * Format a single column
	 *
	 * @access 	public
	 * @params	
	 */
	public function getFormattedValue($plugin = false)
	{
		// Is this an alt process type?
		if ($this->alt_process === true)
		{
			if ( ! $plugin and method_exists($this, 'alt_pre_output'))
			{
				return $this->alt_pre_output();
			}
		}	
		else
		{
			if ($this->model->isEnableFieldRelations())
			{
				// Get relations from the model
				$relations = $this->model->getRelations();

				// Return relations if they are eager loaded
				if (isset($relations[$this->field->field_slug]))
				{
					return $this->relation = $this->relations[$this->field->field_slug];
				}
				// If the field type has a relationship, get the results
				elseif (method_exists($this, 'relation'))
				{
				    return $this->relation = $this->relation()->getResults();          
				}				
			}

			// If not, check and see if there is a method
			// for pre output or pre_output_plugin
			if ($plugin and method_exists($this, 'pre_output_plugin'))
			{
				return $this->pre_output_plugin();
			}
			elseif (method_exists($this, 'pre_output'))
			{
				return $this->pre_output();
			}
		}

		return $this->getValue();
	}

	/**
	 * Get the unformatted value
	 * @param  boolean $plugin
	 * @return mixed
	 */
	public function getUnformattedValue($plugin = false)
	{
		return $this->getValue();
	}

	// --------------------------------------------------------------------------

	// $field, $value = null, $row_id = null, $plugin = false
	public function getForm()
	{
		$this->setFormSlug();

		// If this is for a plugin, this relies on a function that
		// many field types will not have
		if ($this->plugin and method_exists($this, 'form_output_plugin'))
		{
			return $this->form_output_plugin();
		}
		elseif (method_exists($this, 'form_output'))
		{
			return $this->form_output();
		}

		return false;
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
	 * Add a field type JS file
	 */
	public function addMisc($html)
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
	public function loadView($type, $view_name, $data = array())
	{
		$paths = ci()->load->get_view_paths();

		ci()->load->set_view_path(static::$types->$type->ft_path.'views/');

		$view_data = ci()->load->_ci_load(array('_ci_view' => $view_name, '_ci_vars' => $this->objectToArraydeto($data), '_ci_return' => true));

		ci()->load->set_view_path($paths);

		return $view_data;
	}

	/**
	 * Get the results for the field type relation
	 * @return [type] [description]
	 */
	public function getRelation($field_slug = null)
	{
		$field_slug = $field_slug ? $field_slug : $this->field->field_slug;

		// If not, if there is a relation defined, query it
		if ($this->hasRelation())
		{
			$relations = $this->entry->getRelations();

			// Return the related model if it was eager loaded
			if (isset($relations[$field_slug]))
			{
				return $relations[$field_slug];
			}
			else
			{
				return $this->relation()->getResults();
			}
		}
		else
		{
			return null;
		}
	}

	/**
	 * Wrapper method for the Eloquent belongsTo() method
	 * @param  [type] $related     [description]
	 * @param  [type] $foreing_key [description]
	 * @return [type]              [description]
	 */
	public function belongsTo($related, $foreing_key = null)
	{
		$foreing_key = $foreing_key ? $foreing_key : $this->field->field_slug;

		return $this->model->belongsTo($related, $foreing_key);
	}

	/**
	 * Wrapper method for the Eloquent belongsToEntry() method
	 * @param  [type] $related     [description]
	 * @param  [type] $foreing_key [description]
	 * @return [type]              [description]
	 */
	public function belongsToEntry($related = 'Pyro\Module\Streams_core\Core\Model\Entry', $foreing_key = null, $stream = null)
	{
		$foreing_key = $foreing_key ? $foreing_key : $this->field->field_slug;

		return $this->model->belongsToEntry($related, $foreing_key, $this->getParameter('choose_stream', $stream));
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

	public function hasRelation()
	{
		return method_exists($this, 'relation') and ($this->relation() instanceof Relations\Relation);
	}
}
