<?php namespace Pyro\Model;

use Illuminate\Database\Eloquent\Builder;

class EloquentQueryBuilder extends Builder
{
	/**
	 * Get the hydrated models without eager loading.
	 *
	 * @param  array  $columns
	 * @return array|static[]
	 */
	public function getModels($columns = array('*'))
	{
		// First, we will simply get the raw results from the query builders which we
		// can use to populate an array with Eloquent models. We will pass columns
		// that should be selected as well, which are typically just everything.
		$results = array();

        if (ci()->cache->isEnabled() and $this->model->getCacheMinutes()) {
        	$this->rememberIndex();
        	$results = $this->query->getCached($columns);
        } else {
        	$results = $this->query->getFresh($columns);
        }

		$connection = $this->model->getConnectionName();

		$models = array();

		// Once we have the results, we can spin through them and instantiate a fresh
		// model instance for each records we retrieved from the database. We will
		// also set the proper connection name for the model after we create it.
		foreach ($results as $result)
		{
			$models[] = $model = $this->model->newFromBuilder($result);

			$model->setConnection($connection);
		}

		return $models;
	}

    public function rememberIndex()
    {
    	if ($cache_minutes = $this->model->getCacheMinutes()) {
			$this->remember($cache_minutes);
			$this->indexCacheCollection();    		
		}

		return $this;
    }

	/**
	 * Index cache collection
	 * @return object
	 */
	public function indexCacheCollection()
	{
		ci()->cache->collection(
			$this->model->getCacheCollectionKey(), 
			$this->getQuery()->getCacheKey()
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
            $this->model->setCacheMinutes(false);
        }

        return $this;
    }

	/**
     * Indicate that the query results should be cached.
     *
     * @param  \Carbon\Carbon|\Datetime|int  $minutes
     * @param  string  $key
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function remember($minutes, $key = null)
    {   
    	if (ci()->cache->isEnabled()) {
    		return $this->query->remember($minutes, $key);
    	}
        
        return $this;
    }
}