<?php namespace Pyro\Model\Query;

use Closure;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Pyro\Module\Streams_core\Core\Model\Relation\BelongsToEntry;
use Pyro\Module\Streams_core\Core\Model\Stream;

class Builder extends EloquentBuilder
{
	protected $streams = array();

	/**
	 * Eagerly load the relationship on a set of models.
	 *
	 * @param  array    $models
	 * @param  string   $name
	 * @param  \Closure $constraints
	 * @return array
	 */
	protected function loadRelation(array $models, $name, Closure $constraints)
	{
		// First we will "back up" the existing where conditions on the query so we can
		// add our eager constraints. Then we will merge the wheres that were on the
		// query back to it in order that any where conditions might be specified.
		$relation = $this->getRelation($name);

		$relation->addEagerConstraints($models);

		call_user_func($constraints, $relation);

		$models = $relation->initRelation($models, $name);

		// Once we have the results, we just match those back up to their parent models
		// using the relationship instance. Then we just return the finished arrays
		// of models which have been eagerly hydrated and are readied for return.
		if ($relation instanceof BelongsToEntry)
		{
			if ($stream = $this->getStream($models, $relation->getStreamColumn()))
			{
				$relation->getModel()->setTable($stream->stream_prefix.$stream->stream_slug);	
			}				
		}

		$results = $relation->getModel()->newQuery()->get();

		return $relation->match($models, $results, $name);
	}

	public function getStream(array $models, $stream_column = null)
	{
		foreach ($models as $model)
		{
			if ($stream_column and $stream = $model->{$stream_column} and ! in_array($stream, $this->streams))
			{
				$this->streams[] = $stream;

				return Stream::findBySlugAndNameSpace($stream);
			}
		}

		return false;
	}

	public function setStreamColumn($stream_column = null)
	{
		$this->stream_column = $stream_column;
	}

}