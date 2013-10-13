<?php namespace Pyro\Module\Streams_core\Core\Field;

use Illuminate\Database\Eloquent\Relations;
use Pyro\Module\Streams_core\Core\Field\Type;
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
	 * Unformatted value
	 * @var mixed
	 */
	protected $unformatted_value = null;

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
	 * Version
	 * @var string
	 */
	public $version = '1.0';

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
		return $this->getFormSlug();
	}

	/**
	 * Get form slug prefix
	 * @return [type] [description]
	 */
	public function getFormSlugPrefix()
	{
		return $this->stream->stream_namespace.'-'.$this->stream->stream_slug.'-';
	}

	/**
	 * Get filter slug segment
	 * @return string
	 */
	public function getFilterSlugSegment()
	{
		return $this->stream->stream_namespace.'-'.$this->stream->stream_slug;
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

		if ($value = ci()->input->post($this->getFormSlug($field_slug)))
		{
			return $value;
		}
		elseif ($value = ci()->input->post($this->getFormSlug($field_slug).'[]'))
		{
			return $value;
		}
		elseif ($this->entry)
		{
			return $this->entry->{$field_slug};
		}
		else
		{
			return $default;
		}
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
		return $this->getFormValue(null, $this->getDefault(null, $this->getParameter('default_value')));
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

		return $this->getValueProperty();
	}

	/**
	 * Get the unformatted value
	 * @param  boolean $plugin
	 * @return mixed
	 */
	public function getUnformattedValue($plugin = false)
	{
		return $this->getValueProperty();
	}

	// --------------------------------------------------------------------------

	// $field, $value = null, $row_id = null, $plugin = false
	public function getForm()
	{
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

	// --------------------------------------------------------------------------

	/**
	 * Get filter output for a field type
	 * @return string The input HTML
	 */
	public function getFilterOutput()
	{
		if (method_exists($this, 'filterOutput'))
		{
			return $this->filterOutput();
		}

		return '<input type="text" name="f-'.$this->getFilterSlugSegment().'-contains-'.$this->field->field_slug.'" value="'.ci()->input->get('f-'.$this->getFilterSlugSegment().'-contains-'.$this->field->field_slug).'" class="form-control" placeholder="'.$this->field->field_name.'">';
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
			$type = Type::getLoader()->getType($field_type);
		}
		else
		{
			$type = $this;
		}

		$paths = ci()->load->get_view_paths();

		ci()->load->set_view_path($type->ft_path.'views/');

		$view_data = ci()->load->_ci_load(array('_ci_view' => $view_name, '_ci_vars' => $this->objectToArray($data), '_ci_return' => true));

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
		if ($this->hasRelation() and $this->value)
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
	 * Has relation
	 * @return boolean [description]
	 */
	public function hasRelation()
	{
		return method_exists($this, 'relation') and ($this->relation() instanceof Relations\Relation);
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
		$method = 'get'.\Illuminate\Support\Str::studly($key).'Property';

		if (method_exists($this, $method))
		{
			return $this->$method($key);
		}

		if ($parameter = $this->getParameter($key))
		{
			return $parameter;
		}

		return null;
	}

	public function __get($key)
	{
		return $this->getProperty($key);
	}
}
