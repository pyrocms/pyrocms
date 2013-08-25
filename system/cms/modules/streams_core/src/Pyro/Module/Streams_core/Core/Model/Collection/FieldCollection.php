<?php namespace Pyro\Module\Streams_core\Core\Model\Collection;

use Pyro\Collection\EloquentCollection;

class FieldCollection extends EloquentCollection
{
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
	 * [__construct description]
	 * @param array $fields [description]
	 */
	public function __construct(array $fields = array())
	{
		parent::__construct($fields);

		foreach ($fields as $field)
		{
			$this->indexed_by_slug[$field->field_slug] = $field;
		}
	}

	/**
	 * [findBySlug description]
	 * @param  [type] $field_slug [description]
	 * @return [type]             [description]
	 */
	public function findBySlug($field_slug = null)
	{
		return isset($this->indexed_by_slug[$field_slug]) ? $this->indexed_by_slug[$field_slug] : null;
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
		return $this->indexed_by_slug;
	}
}