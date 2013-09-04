<?php namespace Pyro\Module\Streams_core\Core\Field;

abstract class AbstractField
{
	public $alt_process = false;

	protected $defaults = null;

	protected $value = null;

	protected $plugin = false;

	protected $query = null;

	protected $field = null;

	protected $stream = null;

	protected $model = null;

	protected $entry = null;

	protected $entries = null;

	protected $method = 'new';

	protected $form_data = array();

	public function setValue($value = null)
	{
		$this->value = $value;
	}

	public function setPlugin($plugin = null)
	{
		$this->plugin = $plugin;

		return $this;
	}

	public function setMethod($method = 'new')
	{
		$this->method = $method;

		return $this;
	}

	public function setEntryBuilder(\Pyro\Module\Streams_core\Core\Model\Query\EntryBuilder $builder = null)
	{
		$this->builder = $builder;

		return $this;
	}

	public function setField(\Pyro\Module\Streams_core\Core\Model\Field $field = null)
	{
		$this->field = $field;

		return $this;
	}

	public function getField()
	{
		return $this->field;
	}

	public function setStream(\Pyro\Module\Streams_core\Core\Model\Stream $stream = null)
	{
		$this->stream = $stream;

		return $this;
	}

	public function setModel(\Pyro\Module\Streams_core\Core\Model\Entry $model = null)
	{
		$this->model = $model;

		return $this;
	}

	public function setEntry(\Pyro\Module\Streams_core\Core\Model\Entry $entry = null)
	{
		$this->entry = $entry;

		return $this;
	}

	public function setEntries(\Pyro\Module\Streams_core\Core\Model\Collection\EntryCollection $entries = null)
	{
		$this->entries = $entries;

		return $this;
	}

	public function setFormData(array $form_data = array())
	{
		$this->form_data = $form_data;
	}

	public function getFormData($key = null)
	{
		return isset($this->form_data[$key]) ? $this->form_data[$key] : null;
	}

	public function setDefaults(array $defaults = array())
	{
		$this->defaults = $defaults;
	}

	public function getDefault($key = null)
	{
		return isset($this->defaults[$key]) ? $this->defaults[$key] : null;
	}

	public function getValue()
	{
		return $this->value;
	}

	// --------------------------------------------------------------------------	

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
			if ( ! $this->plugin and method_exists($this, 'alt_pre_output'))
			{
				return $this->alt_pre_output();
			}
		}	
		else
		{
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

	/**
	 * Add a field type CSS file
	 */
	public function addCss($field_type, $file)
	{
		$html = '<link href="'.site_url('streams_core/field_asset/css/'.$field_type.'/'.$file).'" type="text/css" rel="stylesheet" />';

		ci()->template->append_metadata($html);

		$this->assets[] = $html;
	}

	/**
	 * Add a field type JS file
	 */
	public function addJs($field_type, $file)
	{
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

		$this->assets[] = $html;
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

		$view_data = ci()->load->_ci_load(array('_ci_view' => $view_name, '_ci_vars' => $this->object_to_array($data), '_ci_return' => true));

		ci()->load->set_view_path($paths);

		return $view_data;
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

}