<?php namespace Pyro\Module\Streams_core;

use Illuminate\Support\Str;
use Pyro\Model\EloquentCollection;

class EntryCollection extends EloquentCollection
{
	protected $format = 'eloquent';

	/**
	 * Set the active format of all models as original
	 * @return object
	 */
	public function asOriginal()
	{
		$this->format = EntryModel::FORMAT_ORIGINAL;

		return $this;
	}

	/**
	 * Set the active format of all models as eloquent
	 * @return object
	 */
	public function asEloquent()
	{
		$this->format = EntryModel::FORMAT_ELOQUENT;

		return $this;
	}

	/**
	 * Set the active format of all models as string
	 * @return object
	 */
	public function asString()
	{
		$this->format = EntryModel::FORMAT_STRING;

		return $this;
	}

	/**
	 * Set the active format of all models as data
	 * @return object
	 */
	public function asData()
	{
		$this->format = EntryModel::FORMAT_DATA;

		return $this;
	}

	/**
	 * Set the active format of all models as plugin
	 * @return object
	 */
	public function asPlugin()
	{
		$this->format = EntryModel::FORMAT_PLUGIN;

		$entries = array();

		foreach($this->items as $entry) {
			$entries[] = $entry->asPlugin();
		}

		return new static($entries);


		//return $this;
	}

	/**
	 * Get entry options
	 * @return array
	 */
	public function getEntryOptions($title_column = null)
	{
		$options = array();

		foreach($this->items as $entry)
		{
			$options[$entry->getKey()] = $entry->getTitleColumnValue($title_column);
		}

		return $options;
	}

	/**
	 * To output array
	 * @return array
	 */
	public function toOutputArray()
	{
		$output = array();

		foreach ($this->items as $entry) {
			$output[] = $entry->{'as'.Str::studly($this->format)}()->toOutputArray();
		}

		return $output;
	}

	/**
	 * To Json
	 * @param  integer $options
	 * @return string
	 */
	public function toJson($options = 0)
	{
		return json_encode($this->toOutputArray(), $options);
	}
}
