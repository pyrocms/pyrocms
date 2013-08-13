<?php namespace Pyro\Module\Streams_core\Core\Field;

abstract class AbstractField
{
	protected $alt_process = false;

	protected $value = null;

	protected $is_plugin = false;

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

	public function setMethod($method = 'new')
	{
		$this->method = $method;

		return $this;
	}

	public function setPlugin($is_plugin = true)
	{
		$this->is_plugin = $is_plugin;

		return $this;
	}

	public function setEntryBuilder(\Pyro\Module\Streams_core\Core\Query\EntryBuilder $builder = null)
	{
		$this->builder = $builder;

		return $this;
	}

	public function setField(\Pyro\Module\Streams_core\Core\Model\Field $field = null)
	{
		$this->field = $field;

		return $this;
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

	public function setEntries(\Pyro\Module\Streams_core\Core\Collection\EntryCollection $entries = null)
	{
		$this->entries = $entries;

		return $this;
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
	public function getFormattedValue()
	{
		// Is this an alt process type?
		if ($this->alt_process === true)
		{
			if ( ! $this->is_plugin and method_exists($this, 'alt_pre_output'))
			{
				return $this->alt_pre_output();
			}
			
			return $this->value;
		}	
		else
		{
			// If not, check and see if there is a method
			// for pre output or pre_output_plugin
			if ($this->is_plugin and method_exists($this, 'pre_output_plugin'))
			{
				return $this->pre_output_plugin();
			}
			elseif (method_exists($this, 'pre_output'))
			{
				return $this->pre_output();
			}
		}

		return $this->value;
	}

	// $field, $value = null, $row_id = null, $plugin = false
	public function getForm()
	{
		$this->form_data['form_slug']	= $this->field->field_slug;
		$this->form_data['custom'] 		= $this->field->field_data;
		$this->form_data['value']		= $this->value;
		$this->form_data['max_length']	= (isset($this->field->field_data['max_length'])) ? $this->field->field_data['max_length'] : null;

		// If this is for a plugin, this relies on a function that
		// many field types will not have
		if ($this->is_plugin)
		{
			if (method_exists($this, 'form_output_plugin'))
			{
				return $this->form_output_plugin();
			}
			else
			{
				return false;
			}
		}
		else
		{
			return $this->form_output();
		}
	}

}