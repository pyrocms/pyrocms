<?php namespace Pyro\Module\Streams_core\Core\Model\Collection;

use Pyro\Collection\EloquentCollection;

class FieldCollection extends EloquentCollection
{
	protected $by_slug = null;

	public function  __construct($fields = array())
	{
		parent::__construct($fields);
		
		foreach ($fields as $field)
		{
			$this->by_slug[$field->field_slug] = $field;
		}
	}

	/**
	 * [$standard_columns description]
	 * @var array
	 */
	protected $standard_columns = array();

	/**
	 * [$indexed_by_slug description]
	 * @var array
	 */
	protected $indexed_by_slug = array();

	/**
	 * The array of Types 
	 * @var array
	 */
	protected $types = array();

	/**
	 * [findBySlug description]
	 * @param  [type] $field_slug [description]
	 * @return [type      [description]
	 */
	public function findBySlug($field_slug = null)
	{
		return isset($this->by_slug[$field_slug]) ? $this->by_slug[$field_slug] : null;
	}

	/**
	 * [getFieldSlugs description]
	 * @return [type] [description]
	 */
	public function getFieldSlugs()
	{
		return array_values($this->lists('field_slug'));
	}

	/**
	 * [getFieldSlugsExclude description]
	 * @param  array  $columns [description]
	 * @return [type]          [description]
	 */
	public function getFieldSlugsExclude(array $columns = array())
	{
		$all = array_merge($this->getStandardColumns(), $this->getFieldSlugs());

		return array_diff($all, $columns);
	}

	/**
	 * [getArrayIndexedBySlug description]
	 * @return [type] [description]
	 */
	public function getArrayIndexedBySlug()
	{
		$fields = array();

		foreach ($this->items as $field)
		{
			$fields[$field->field_slug] = $field;
		}

		return $fields;
	}

	/**
	 * Get an array of field types
	 * @param  Pyro\Module\Streams_core\Core\Model\Entry $entry An optional entry to instantiate the field types
	 * @return array The array of field types
	 */
	public function getTypes($entry = null)
	{
		$types = array();

		foreach ($this->items as $field)
		{
			$types[$field->field_type] = $field->getType($entry);
		}

		return new FieldTypeCollection($types);
	}
}