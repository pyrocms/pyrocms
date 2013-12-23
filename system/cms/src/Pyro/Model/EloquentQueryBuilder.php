<?php namespace Pyro\Model;

use Illuminate\Database\Eloquent\Builder;

class EloquentQueryBuilder extends Builder
{
    /**
     * Execute the query as a "select" statement.
     *
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function get($columns = array('*'))
    {
		$this->remember($this->model->getCacheMinutes());
		$this->indexCacheCollection();

		$models = $this->getModels($columns);

		// If we actually found models we will also eager load any relationships that
		// have been specified as needing to be eager loaded, which will solve the
		// n+1 query issue for the developers to avoid running a lot of queries.
		if (count($models) > 0)
		{
			$models = $this->eagerLoadRelations($models);
		}

		return $this->model->newCollection($models);
    }

	/**
	 * Index cache collection
	 * @return object
	 */
	public function indexCacheCollection()
	{
		ci()->cache->collection(
			$this->model->getCacheCollectionKey(), 
			array($this->getQuery()->getCacheKey())
		)->index();

		return $this;
	}

	/**
	 * Get fresh models / disable cache
	 * @param  boolean $fresh
	 * @return object
	 */
    public function fresh($fresh = true)
    {
        if ($fresh) {
            $this->model->setCacheMinutes(0);
        }

        return $this;
    }
}