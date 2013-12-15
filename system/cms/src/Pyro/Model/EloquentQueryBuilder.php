<?php namespace Pyro\Model;

use Illuminate\Database\Eloquent\Builder;

class EloquentQueryBuilder extends Builder
{
	protected static $runtime_query_cache = array();
	
	protected static function getCacheModels($key)
	{
		return isset(static::$runtime_query_cache[$key]) ? static::$runtime_query_cache[$key] : null;
	}

	protected static function setCacheModels($key, $models)
	{
		return static::$runtime_query_cache[$key] = $models;
	}

	/**
	 * Get the hydrated models without eager loading.
	 *
	 * @param  array  $columns
	 * @return array
	 */
	public function getModels($columns = array('*'))
	{
		if ($cached = $this->getCacheModels($this->query->generateCacheKey()))
		{
			return $cached;
		}

		return $this->setCacheModels($this->query->generateCacheKey(), parent::getModels($columns));
	}
}