<?php namespace Pyro\Module\Streams_core\Core\Field;

abstract class AbstractField
{
	protected $alt_process = false;

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
			if ( ! $this->plugin and method_exists($this, 'alt_pre_output'))
			{
				return $this->alt_pre_output();
			}
		}	
		else
		{
			// If not, check and see if there is a method
			// for pre output or pre_output_plugin
			if ($this->plugin and method_exists($this, 'pre_output_plugin'))
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

}