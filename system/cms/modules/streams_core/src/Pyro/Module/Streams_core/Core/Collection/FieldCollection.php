<?php namespace Pyro\Module\Streams_core\Core\Collection;

use Pyro\Collection\EloquentCollection;

class FieldCollection extends EloquentCollection
{
	protected $standard_columns = array();

	public function findBySlug($field_slug = null)
	{
		return $this->findByAttribute($field_slug, 'field_slug');
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

	public function setStandardColumns(array $standard_columns = array())
	{
		$this->standard_columns = $standard_columns;

		return $this;
	}

	public function getStandardColumns()
	{
		return $this->standard_columns;
	}
}