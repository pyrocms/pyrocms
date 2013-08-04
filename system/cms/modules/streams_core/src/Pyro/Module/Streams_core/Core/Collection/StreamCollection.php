<?php namespace Pyro\Module\Streams_core\Collection;

use Pyro\Collection\EloquentCollection;

// Here we can grab Stream models from a StreamCollection without the need to query again

class StreamCollection extends EloquentCollection
{

	public function findBySlugAndNamespace($slug = null, $namespace = null)
	{
		return array_first($this->items, function($key, $stream) use ($slug, $namespace)
        {
			return $stream->stream_slug == $slug and $stream->stream_namespace == $namespace;
		}, false);
	}

	public function findManyByNamespace($namespace = null)
	{		
		return $this->filter(function($stream) use ($namespace)
		{
			return $stream->stream_namespace == $namespace;
		});
	}
}