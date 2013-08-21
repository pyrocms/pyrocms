<?php namespace Pyro\Module\Streams_core\Core\Collection;

use Pyro\Collection\EloquentCollection;

class FieldCollection extends EloquentCollection
{
	protected $standard_columns = array();

	protected $indexed_by_slug = array();

	public function __construct(array $fields = array())
	{
		parent::__construct($fields);

		foreach ($fields as $field)
		{
			$this->indexed_by_slug[$field->field_slug] = $field;
		}
	}

	public function findBySlug($field_slug = null)
	{
		return isset($this->indexed_by_slug[$field_slug]) ? $this->indexed_by_slug[$field_slug] : null;
	}

	public function getFieldSlugs()
	{
		return array_values($this->lists('field_slug'));
	}

	public function getFieldSlugsExclude(array $columns = array())
	{
		$all = array_merge($this->getStandardColumns(), $this->getFieldSlugs());

		return array_diff($all, $columns);
	}

	public function getArrayIndexedBySlug()
	{
		return $this->indexed_by_slug;
	}
}