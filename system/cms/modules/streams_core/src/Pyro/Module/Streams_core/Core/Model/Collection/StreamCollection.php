<?php namespace Pyro\Module\Streams_core\Core\Model\Collection;

use Pyro\Model\Collection\EloquentCollection;

class StreamCollection extends EloquentCollection
{
	/**
	 * Find a field type by slug and namespace
	 * @param  string $slug
	 * @param  string $namespace
	 * @return object
	 */
	public function findBySlugAndNamespace($slug = null, $namespace = null)
	{
		return array_first($this->items, function($key, $stream) use ($slug, $namespace)
        {
			return $stream->stream_slug == $slug and $stream->stream_namespace == $namespace;
		}, false);
	}

	/**
	 * Find many by namespace
	 * @param  string $namespace
	 * @return array
	 */
	public function findManyByNamespace($namespace = null)
	{		
		return $this->filter(function($stream) use ($namespace)
		{
			return $stream->stream_namespace == $namespace;
		});
	}
}
