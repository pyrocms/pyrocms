<?php namespace Pyro\Module\Streams_core\Core\Model\Collection;

use Pyro\Collection\EloquentCollection;

class StreamCollection extends EloquentCollection
{
	/**
	 * [findBySlugAndNamespace description]
	 * @param  [type] $slug      [description]
	 * @param  [type] $namespace [description]
	 * @return [type]            [description]
	 */
	public function findBySlugAndNamespace($slug = null, $namespace = null)
	{
		return array_first($this->items, function($key, $stream) use ($slug, $namespace)
        {
			return $stream->stream_slug == $slug and $stream->stream_namespace == $namespace;
		}, false);
	}

	/**
	 * [findManyByNamespace description]
	 * @param  [type] $namespace [description]
	 * @return [type]            [description]
	 */
	public function findManyByNamespace($namespace = null)
	{		
		return $this->filter(function($stream) use ($namespace)
		{
			return $stream->stream_namespace == $namespace;
		});
	}
}