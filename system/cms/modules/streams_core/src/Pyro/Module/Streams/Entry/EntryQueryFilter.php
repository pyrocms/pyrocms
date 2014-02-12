<?php namespace Pyro\Module\Streams\Entry;

use Illuminate\Database\Eloquent\Builder;
use Pyro\Model\EloquentReflection;

class EntryQueryFilter
{
    protected $query;

    protected $model;

    public function __construct(EntryQueryBuilder $query)
    {
        $this->query = $query;

        $this->model = $query->getModel();
    }

    public function query()
    {
        // -------------------------------------
        // Filters (QueryString API)
        // -------------------------------------

        $hasResults = true;

        if (ci()->input->get('filter-'.$this->model->getStream()->stream_namespace.'-'.$this->model->getStream()->stream_slug)) {

            $hasResults = false;

            // Get all URL variables
            $queryStringVariables = ci()->input->get();

            // Loop and process!
            foreach ($queryStringVariables as $filter => $value) {

                // Split into components
                $commands = explode('-', $filter);

                // Filter? namespace ? stream ?
                if ($commands[0] != 'f' or
                    $commands[1] != $this->model->getStream()->stream_namespace or
                    $commands[2] != $this->model->getStream()->stream_slug) {
                    continue;
                }

                $fieldSlug = $commands[3];

                $fieldSlugSegments = explode('|', $fieldSlug);

                $fieldSlug = array_shift($fieldSlugSegments);

                if ($relation = $this->reflection($this->model)->getRelationClass($fieldSlug)) {

                    $filterByColumns = explode('|', $commands[4]);

                    $foreignKey = $relation->getForeignKey();

                    if (! empty($fieldSlugSegments)) {
                        // Loop through to get the depest relation
                        foreach ($fieldSlugSegments as $nestedRelationSlug) {
                            
                            $relatedModel = $relation->getRelated();

                            if ($nestedRelation = $this->reflection($relatedModel)->getRelationClass($nestedRelationSlug)) {
                                $relation = $nestedRelation;
                            }
                        }

                        $otherKey = explode('.', $relation->getForeignKey());
                        $otherKey =  array_pop($otherKey);
                    
                    } else {
                    
                        $otherKey = $relation->getParent()->getKeyName();
                    
                    }

                    if (! empty($filterByColumns) and count($commands) == 6) {

                        $constraintType = $commands[5];

                        foreach ($filterByColumns as $filterBy) {
                            $query = $this->constrains($relation->getRelated()->newQuery(), $constraintType, $filterBy, $value);
                        }

                        $relatedModelResults = $query->get();

                        if (! $relatedModelResults->isEmpty()) {

                            $this->query->whereIn($foreignKey, array_values($relatedModelResults->lists($otherKey)));

                            $hasResults = true;
                        }
                    }

                } else {

                    $constraintType = $commands[4];

                    $this->query = $this->constrains($this->query, $constraintType, $fieldSlug, $value);

                    $hasResults = true;
                }
            }
        }

        // -------------------------------------
        // Ordering / Sorting (QueryString API)
        // -------------------------------------

        if ($orderBy = ci()->input->get('order-'.$this->model->getStream()->stream_namespace.'-'.$this->model->getStream()->stream_slug)) {
            if ($sortBy = ci()->input->get('sort-'.$this->model->getStream()->stream_namespace.'-'.$this->model->getStream()->stream_slug)) {

                if ($this->model->hasRelationMethod($orderBy) and $orderByRelation = $this->model->{$orderBy}()) {
                    $orderBy = $orderByRelation->getForeignKey();
                }

                $this->query->orderBy($orderBy, $sortBy);
            } else {
                $this->query->orderBy($orderBy, 'ASC');
            }
        }

        return $hasResults;
    }

    protected function constrains(Builder $query, $constraintType, $filterByColumn, $value)
    {
        // Switch on the restriction
        switch ($constraintType) {

            /**
             * IS
             * results in: filter = value
             */
            case 'is':

                // Gotta have a value for this one
                if (empty($value)) {
                    continue;
                }

                // Do it
                $query->where($filterByColumn, '=', $value);
                break;


            /**
             * ISNOT
             * results in: filter != value
             */
            case 'isnot':

                // Gotta have a value for this one
                if (empty($value)) {
                    continue;
                }

                // Do it
                $query->where($filterByColumn, '!=', $value);
                break;


            /**
             * ISNOT
             * results in: filter != value
             */
            case 'isnot':

                // Gotta have a value for this one
                if (empty($value)) {
                    continue;
                }

                // Do it
                $query->where($filterByColumn, '!=', $value);
                break;


            /**
             * CONTAINS
             * results in: filter LIKE '%value%'
             */
            case 'contains':

                // Gotta have a value for this one
                if (empty($value)) {
                    continue;
                }

                // Do it
                $query->where($filterByColumn, 'LIKE', '%'.$value.'%');
                break;


            /**
             * DOESNOTCONTAIN
             * results in: filter NOT LIKE '%value%'
             */
            case 'doesnotcontain':

                // Gotta have a value for this one
                if (empty($value)) {
                    continue;
                }

                // Do it
                $query->where($filterByColumn, 'NOT LIKE', '%'.$value.'%');
                break;


            /**
             * STARTSWITH
             * results in: filter LIKE 'value%'
             */
            case 'startswith':

                // Gotta have a value for this one
                if (empty($value)) {
                    continue;
                }

                // Do it
                $query->where($filterByColumn, 'LIKE', $value.'%');
                break;


            /**
             * ENDSWITH
             * results in: filter LIKE '%value'
             */
            case 'endswith':

                // Gotta have a value for this one
                if (empty($value)) {
                    continue;
                }

                // Do it
                $query->where($filterByColumn, 'LIKE', '%'.$value);
                break;


            /**
             * ISEMPTY
             * results in: (filter IS NULL OR filter = '')
             */
            case 'isempty':

                $query->where(function ($query) use ($commands, $value) {
                    $query->where($filterByColumn, 'IS', 'NULL');
                    $query->orWhere($filterByColumn, '=', '');
                });
                break;


            /**
             * ISNOTEMPTY
             * results in: filter > '')
             */
            case 'isnotempty':

                $query->where($filterByColumn, '>', '');
                break;

            default:
                break;
        }

        return $query;
    }

    protected function reflection($model)
    {
        return new EloquentReflection($model);
    }
}