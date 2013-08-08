<?php namespace Pyro\Module\Streams_core\Core\Collection;

use Pyro\Collection\EloquentCollection;

class FieldCollection extends EloquentCollection
{
	public function findBySlug($field_slug)
	{
		return $this->findByAttribute($field_slug, 'field_slug');
	}
}