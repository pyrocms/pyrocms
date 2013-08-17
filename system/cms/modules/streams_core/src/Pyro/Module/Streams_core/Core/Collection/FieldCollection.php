<?php namespace Pyro\Module\Streams_core\Core\Collection;

use Pyro\Collection\EloquentCollection;

class FieldCollection extends EloquentCollection
{
	public function findBySlug($field_slug)
	{
		return $this->findByAttribute($field_slug, 'field_slug');
	}

	public function getFieldSlugsArray()
	{
		return array_values($this->lists('field_slug'));
	}

	public function getFieldsSlugsExclusive(array $exlude = array())
	{
		return array_diff($this->getFieldSlugsArray(), $exlude);
	}
}