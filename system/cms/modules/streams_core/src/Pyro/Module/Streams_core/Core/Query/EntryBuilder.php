<?php namespace Pyro\Module\Streams_core\Core\Query;

use Illuminate\Database\Eloquent\Builder;
// use Pyro\Module\Streams_core\Core\Field;

class EntryBuilder extends Builder
{
	/**
	 * Execute the query as a "select" statement.
	 *
	 * @param  array  $columns
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function get($columns = array('*'))
	{
		$models = $this->getModels($columns);

		// If we actually found models we will also eager load any relationships that
		// have been specified as needing to be eager loaded, which will solve the
		// n+1 query issue for the developers to avoid running a lot of queries.
		if (count($models) > 0)
		{
			$models = $this->eagerLoadRelations($models);
		}

		// The problem: Mutators and accesors are nice but they have to be added to a model before hand
		// and there is now way of predicting what fields will be added to the stream
		// 
		// The solution: Here we have a chance to process the models when they are returned by any query
		// and process their attributes with field types
		// This is a key part of making field types play nice with eloquent
		// 
		// i.e.
		// 
		// $models = Field\Formatter::formatEntries($models);
		// 

		return $this->model->newCollection($models);
	}

}