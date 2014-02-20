<?php namespace Pyro\Module\Streams\Entry;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\Relation;
use Pyro\Model\EloquentQueryBuilder;

class EntryQueryBuilder extends EloquentQueryBuilder
{
    protected $entries = array();

    /**
     * Enable or disable eager loading field type relations
     * @var boolean
     */
    protected $enable_auto_eager_loading = false;

    protected $foreign_keys = array();

    protected $columns = array('*');

    protected $field_maps = array();

    /**
     * Execute the query as a "select" statement.
     *
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function get($columns = null, $exclude = false)
    {
        // Get set up with our environment

        $this->filterQuery();

        //$columns = $this->prepareColumns($columns);

        $this->entries = $this->getModels($columns);

        // If we actually found models we will also eager load any relationships that
        // have been specified as needing to be eager loaded, which will solve the
        // n+1 query issue for the developers to avoid running a lot of queries.
        if (count($this->entries) > 0) {
            $this->entries = $this->eagerLoadRelations($this->entries);
        }

        return $this->model->newCollection($this->entries);
    }

    /**
     * Prep columns
     * @param  array  $columns
     * @return array
     */
    protected function prepareColumns($columns = null)
    {
        $this->parseColumnsAndFieldMaps();

        if (empty($columns)) {
            $columns = $this->model->getColumns();
        } elseif (empty($columns) and $exclude) {
            $columns = $this->model->getAllColumnsExclude();
        }

        foreach ($columns as $key => $column) {

            $segments = explode(':', $column);

            $columns[$key] = $segments[count($segments)-1];
        }

        // We need to return the models with their keys
        //return $this->requireColumns($columns);
        return $columns;
    }

    public function requireColumns($columns)
    {
        $entry = new EntryModel;

        // Always include the primary key if we are selecting specific columns, regardless
        if ( ! $this->hasAsterisk($columns) and ! in_array($this->model->getKeyName(), $columns)) {
            array_unshift($columns, $this->model->getTable().'.'.$this->model->getKeyName());
        } elseif ($this->hasAsterisk($columns)) {
            $columns = $this->model->getAllColumns();
        }

        // Require keys
        foreach ($columns as $key => $column) {

            // Field types can require columns
            if ($type = $this->model->getFieldType($column)) {
                $columns = array_merge($columns, $type->requireEntryColumns());
            }

            // Foreing keys are required too
            if ($relation = $this->model->getRelationAttribute($column)) {

                if ($relation instanceof BelongsToMany) {

                    unset($columns[$key]);

                } elseif ($relation instanceof BelongsTo) {

                    $foreign_key = $relation->getForeignKey();
                    $columns[] = $foreign_key;

                    if ($column != $foreign_key) {
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
        if ( ! empty($columns)) {
            foreach ($columns as $column) {
                if ($column == '*') return true;
            }
        }

        return false;
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
     * Filter the query
     *
     * @return EntryQueryBuilder
     */
    protected function filterQuery()
    {
        $filter = new EntryQueryFilter($this);

        $filter->make();

        return $filter->getQuery();
    }

    /**
     * Retrieve the "count" result of the query.
     * @param  string $column
     * @return int
     */
    public function count($column = '*')
    {
        $this->filterQuery();

        return parent::count($column);
    }
}
