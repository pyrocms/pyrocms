<?php namespace Pyro\Module\Streams_core\Core\Model\Query;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Pyro\Module\Streams_core\Core\Model\Entry;

class EntryBuilder extends Builder
{
	protected $entries = array();

    /**
     * Enable or disable eager loading field type relations
     * @var boolean
     */
    protected $enable_auto_eager_loading = false;

	/**
	 * Execute the query as a "select" statement.
	 *
	 * @param  array  $columns
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function get($columns = array('*'), $exclude = false)
	{
		// Get set up with our environment
		$this->stream = $this->model->getStream();
		$this->fields = $this->model->getFields();
		$this->table = $this->model->getTable();

		// -------------------------------------
		// Filters (QueryString API)
		// -------------------------------------

		if (ci()->input->get('filter-'.$this->stream->stream_namespace.'-'.$this->stream->stream_slug)) {

			// Get all URL variables
			$query_string_variables = ci()->input->get();

			// Loop and process!
			foreach ($query_string_variables as $filter => $value) {
				
				// Split into components
				$commands = explode('-', $filter);

				// Filter?
				if ($commands[0] != 'f') continue;

				// Only filter our current namespace / stream
				if ($commands[1] != $this->stream->stream_namespace) continue;
				if ($commands[2] != $this->stream->stream_slug) continue;

				// Switch on the restriction
				switch ($commands[4]) {
					
					/**
					 * IS
					 * results in: filter = value
					 */
					case 'is':
						
						// Gotta have a value for this one
						if (empty($value)) continue;

						// Do it
						$this->where($commands[3], '=', $value);
						break;


					/**
					 * ISNOT
					 * results in: filter != value
					 */
					case 'isnot':
						
						// Gotta have a value for this one
						if (empty($value)) continue;

						// Do it
						$this->where($commands[3], '!=', $value);
						break;


					/**
					 * ISNOT
					 * results in: filter != value
					 */
					case 'isnot':
						
						// Gotta have a value for this one
						if (empty($value)) continue;

						// Do it
						$this->where($commands[3], '!=', $value);
						break;
					

					/**
					 * CONTAINS
					 * results in: filter LIKE '%value%'
					 */
					case 'contains':
						
						// Gotta have a value for this one
						if (empty($value)) continue;

						// Do it
						$this->where($commands[3], 'LIKE', '%'.$value.'%');
						break;


					/**
					 * DOESNOTCONTAIN
					 * results in: filter NOT LIKE '%value%'
					 */
					case 'doesnotcontain':
						
						// Gotta have a value for this one
						if (empty($value)) continue;

						// Do it
						$this->where($commands[3], 'NOT LIKE', '%'.$value.'%');
						break;


					/**
					 * STARTSWITH
					 * results in: filter LIKE 'value%'
					 */
					case 'startswith':
						
						// Gotta have a value for this one
						if (empty($value)) continue;

						// Do it
						$this->where($commands[3], 'LIKE', $value.'%');
						break;


					/**
					 * ENDSWITH
					 * results in: filter LIKE '%value'
					 */
					case 'endswith':
						
						// Gotta have a value for this one
						if (empty($value)) continue;

						// Do it
						$this->where($commands[3], 'LIKE', '%'.$value);
						break;


					/**
					 * ISEMPTY
					 * results in: (filter IS NULL OR filter = '')
					 */
					case 'isempty':
						
						$this->where(function($query) use ($commands, $value) {
							$query->where($commands[3], 'IS', 'NULL');
							$query->orWhere($commands[3], '=', '');
						});
						break;


					/**
					 * ISNOTEMPTY
					 * results in: filter > '')
					 */
					case 'isnotempty':
						
						$this->where($commands[3], '>', '');
						break;


					default: break;
				}
			}
		}


		// -------------------------------------
		// Ordering / Sorting (QueryString API)
		// -------------------------------------

		if ($order_by = ci()->input->get('order-'.$this->stream->stream_namespace.'-'.$this->stream->stream_slug)) {
			if ($sort_by = ci()->input->get('sort-'.$this->stream->stream_namespace.'-'.$this->stream->stream_slug)) {
				
				if ($order_by_relation = $this->getRelationAttribute($order_by) and $order_by_relation instanceof Relation)
				{
					$order_by = $order_by_relation->getForeignKey();
				}

				$this->orderBy($order_by, $sort_by);
			} else {
				$this->orderBy($order_by, 'ASC');
			}
		}

		if ($exclude)
		{
			$columns = $this->model->getAllColumnsExclude($columns);
		}

		$columns = $this->prepareColumns($columns);

	
		// We prepare the view options after preparing the columns and before the key is required
		$this->prepareViewOptions($columns);

		// We need to return the models with their keys
		$columns = $this->requireKey($columns);

		$columns = $this->requireForeingKeys($columns);

		$this->entries = $this->getModels($columns);

		foreach ($this->entries as $entry)
		{
			// Pass our custom properties to the queried models
			$this->model->passProperties($entry);
		}

		// If we actually found models we will also eager load any relationships that
		// have been specified as needing to be eager loaded, which will solve the
		// n+1 query issue for the developers to avoid running a lot of queries.
		if (count($this->entries) > 0)
		{
			if ($eager_loads = $this->getViewOptionRelations() and is_array($eager_loads))
			{
				if (is_array($this->eagerLoad))
				{
					$eager_loads = array_merge($eager_loads, $this->eagerLoad);	
				}
			}

			if ( ! empty($eager_loads)) {

				$this->with($eager_loads);
			}

			$this->entries = $this->eagerLoadRelations($this->entries);
		}

		// Shall we return formatted entries or not?
		if ($this->model->isFormat())
		{
			return $this->model->newCollection($this->formatEntries($this->entries), $this->entries);
		}
		else
		{
			return $this->model->newCollection($this->entries);
		}
	}

	/**
	 * Format entries
	 * @param  array  $entries
	 * @return array
	 */
	public function formatEntries(array $entries = array())
	{	
		// returns the models with the attributes formated by their corresponding field type
		$formatted = array();

		foreach ($entries as $entry)
		{
			$formatted[] = $this->formatEntry($entry);
		}

		return $formatted;
	}

	/**
	 * Format an entry
	 * @param  object $entry
	 * @return object
	 */
	public function formatEntry($entry = null)
	{
		// Replicate the model to keep the original intact
		$clone = $entry->replicate();
		
		// We must set the fields for both the entry and the clone
		// Setting them on the clone will have an effect on the resulting collection and 
		// Setting them on the entry will have an effect when returning a single model

		// Restore the primary key to the replicated model
		$clone->{$this->model->getKeyName()} = $entry->{$this->model->getKeyName()};	

		foreach ($this->model->getViewOptions() as $field_slug)
		{
			if ($field_slug == 'created_by')
			{
				$clone->setAttribute('created_by', $clone->createdByUser);
			}
			elseif ($type = $entry->getFieldType($field_slug))
			{
				// Set the unformatted value, we might need it
				$clone->setUnformattedValue($field_slug, $entry->{$field_slug});

				$clone->setPluginValue($field_slug, $type->pluginOutput());
				
				// If there exist a field for the corresponding attribute, format it
				$clone->{$field_slug} = $type->stringOutput();
			}
		};

		// Store the unformatted entry in case we need it later
		$clone->setUnformattedEntry($entry);

		return $clone;	
	}

	/**
	 * Get the relation instance for the given relation name.
	 *
	 * @param  string  $relation
	 * @return \Illuminate\Database\Eloquent\Relations\Relation
	 */
	public function getRelation($relation)
	{
		$me = $this;

		// We want to run a relationship query without any constrains so that we will
		// not have to remove these where clauses manually which gets really hacky
		// and is error prone while we remove the developer's own where clauses.
		$query = Relation::noConstraints(function() use ($me, $relation)
		{	
			return $me->getRelationAttribute($relation);
		});

		$nested = $this->nestedRelations($relation);

		// If there are nested relationships set on the query, we will put those onto
		// the query instances so that they can be handled after this relationship
		// is loaded. In this way they will all trickle down as they are loaded.
		if (count($nested) > 0)
		{
			$query->getQuery()->with($nested);
		}

		return $query;
	}

	public function getRelationAttribute($relation = null)
	{
		if ( ! $relation) return null;

		if ($type = $this->getModel()->getFieldType($relation) and $type->hasRelation())
		{
			return $type->relation();	
		}
		elseif (method_exists($this->getModel(), $relation) and $instance = $this->getModel()->$relation())
		{
			if ($instance instanceof Relation) {
				return $instance;
			}
		}

		return $this;
	}

	public function hasRelation($attribute = null)
	{
		return $this->getRelationAttribute($attribute) instanceof Relation;
	}

    /**
     * Enable or disable automatic eager loading
     * @param boolean $format
     * @return  object
     */
    public function enableAutoEagerLoading($enable_auto_eager_loading = true)
    {
        $this->enable_auto_eager_loading = $enable_auto_eager_loading;

        return $this;
    }

    /**
     * Is eager loading field relations enabled
     * @return boolean
     */
    public function isEnableAutoEagerLoading()
    {
        return $this->enable_auto_eager_loading;
    }

	/**
	 * Prep columns
	 * @param  array  $columns
	 * @return array
	 */
    protected function prepareColumns(array $columns = array('*'))
    {
    	// Stash relation: columns
    	$relation_columns = array();

    	foreach ($columns as $column) {
    		if (substr($column, 0, 9) == 'relation:') $relation_columns[] = str_replace('relation:', '', $column);
    	}

    	// Remove any columns that don't exist
        $columns = array_intersect($this->model->getAllColumns(), $columns);

        $columns = array_merge($columns, $relation_columns);

    	// If for some reason we passed an empty array, put the asterisk back
    	$columns = empty($columns) ? array('*') : $columns;

        // Make sure there are no duplicate columns
        return array_unique($columns);
    }

    /**
     * Require the primary key
     * @param  array  $columns
     * @return array
     */
    public function requireKey(array $columns = array())
    {
    	// Always include the primary key if we are selecting specific columns, regardless
        if ( ! $this->hasAsterisk($columns) and ! in_array($this->model->getKeyName(), $columns))
        {
            array_unshift($columns, $this->model->getTable().'.'.$this->model->getKeyName());
        }

        return $columns;
    }

    public function requireForeingKeys($columns)
    {
    	$entry = new Entry;

    	foreach ($columns as $key => $column) {

    		$relation_method = Str::studly($column);

    		if (method_exists($this->model, $relation_method)) {

    			$relation = $this->getRelation($relation_method);

				if ($relation instanceof BelongsToMany) {
					unset($columns[$key]);
				} elseif (method_exists($relation, 'getForeignKey')) {
					$foreign_key = $relation->getForeignKey();
					$columns[] = $foreign_key;

					if ($column != $foreign_key)
					{
						$columns = array_diff($columns, array($column));	
					}
				}
    		}
    	}

    	return array_unique($columns);
    }

    /**
     * Test if ALL columns (*)
     * @param  array   $columns
     * @return boolean
     */
    public function hasAsterisk(array $columns = array())
    {
    	if ( ! empty($columns))
    	{
			foreach ($columns as $column)
			{
				if ($column == '*') return true;
			}
    	}

    	return false;
    }

    /**
     * Prep view options
     * @param  array  $columns
     * @return array
     */
    protected function prepareViewOptions(array $columns = array('*'))
    {	
    	// Use existing stored view options only if we have an asterisk 
    	if ($this->hasAsterisk($columns) and $stream = $this->model->getStream() and ! empty($stream->view_options))
    	{
    		$columns = $stream->view_options;
    	}
    	// If there are no stored options and there is an asterisk, get all columns
		elseif ($this->hasAsterisk($columns))
		{
			$columns = $this->model->getAllColumns();
		}

		return $columns;
    }

    /**
     * Get view option relations
     * @return array
     */
    public function getViewOptionRelations()
    {
    	$relations = array();
    	
    	$entry = new Entry;

    	$model_methods = get_class_methods($this->model);

    	if ($this->isEnableAutoEagerLoading() and $view_options = $this->model->getViewOptions())
    	{
    		if (in_array('created_by', $view_options))
    		{
    			$relations[] = 'createdByUser';
    		}

	    	foreach ($view_options as $column) {
	    		$column = str_replace('relation:', '', $column);
	    		if ($this->hasRelation($column)) {
	    			$relations[] = $column;
	    		}
	    	} 		
    	}

    	return $relations;
    }

}
