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
		$entries = $this->getModels($columns);

		// If we actually found models we will also eager load any relationships that
		// have been specified as needing to be eager loaded, which will solve the
		// n+1 query issue for the developers to avoid running a lot of queries.
		if (count($entries) > 0)
		{
			$entries = $this->eagerLoadRelations($entries);
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
		// $entries = Field\Formatter::formatModels($entries);

		// Both arrays of formatted and unformatted models are passed to the new collection construct
		// This will allow us to return a formatted collection by default
		// 
		// i.e.
		// echo $entries;
		// 
		// or to return the unformatted collection
		// 
		// i.e
		// echo $entries->unformatted();
		//

		return $this->model->newCollection($this->getFormattedEntries($entries), $entries);
	}

	public function getFormattedEntries(array $entries = array())
	{
        $formatter = new \Pyro\Module\Streams_core\Core\Field\Formatter($entries);

        $formatter->setModel($this->model);

        return $formatter->getFormattedEntries();
	}
}