<?php namespace Pyro\Module\Streams\Entry;

use Illuminate\Database\Eloquent\Builder;
use Pyro\Model\EloquentReflection;
use Pyro\Module\Streams\Stream\StreamModel;

class EntryQueryFilter
{
    /**
     * The query builder instance
     *
     * @var EntryQueryBuilder
     */
    protected $query;

    /**
     * The parent model
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * The stream
     *
     * @var StreamModel
     */
    protected $stream;

    public function __construct(Builder $query)
    {
        $this->query = $query;
        $this->model = $query->getModel();
        $this->stream = $this->model->getStream();
    }

    public function getQuery()
    {
        // -------------------------------------
        // Filters (QueryString API)
        // -------------------------------------
        if (ci()->input->get('filter-' . $this->stream->stream_namespace . '-' . $this->stream->stream_slug)) {

            // Get all URL variables
            $queryStringVariables = ci()->input->get();

            // Loop and process!
            foreach ($queryStringVariables as $filter => $value) {

                // Split into components
                $commands = explode('-', $filter);

                // Filter? namespace ? stream ?
                if ($commands[0] != 'f' or
                    $commands[1] != $this->stream->stream_namespace or
                    $commands[2] != $this->stream->stream_slug
                ) {
                    continue;
                }

                $fieldSlug = $commands[3];


                /** @var $constraintType string */
                $constraintType = $commands[4];

                /** @var $filterBy array */
                $filterBy = explode('|', $fieldSlug);

                /**
                 * @var $fieldSlug array
                 */
                $fieldSlug = array_shift($filterBy);

                if ($relation = $this->reflection($this->model)->getRelationClass($fieldSlug)) {

                    $this->query->whereHas(
                        'category',
                        function ($query) use ($filterBy, $constraintType, $value) {
                            foreach ($filterBy as $column) {
                                $this->constrain($query, $constraintType, $column, $value);
                            }
                        }
                    );

                } else {

                    $this->constrain($this->query, $constraintType, $fieldSlug, $value);

                }
            }
        }

        // -------------------------------------
        // Ordering / Sorting (QueryString API)
        // -------------------------------------

        if ($orderBy = ci()->input->get(
            'order-' . $this->stream->stream_namespace . '-' . $this->stream->stream_slug
        )
        ) {

            $sort = ci()->input->get(
                'sort-' . $this->stream->stream_namespace . '-' . $this->stream->stream_slug,
                'ASC'
            );

            $this->order($this->query, $orderBy, $sort);
        }

        return $this->query;
    }

    /**
     * Get a new EloquentReflection object
     *
     * @param $model
     *
     * @return EloquentReflection
     */
    protected function reflection($model)
    {
        return new EloquentReflection($model);
    }

    /**
     * Constraint
     *
     * @param Builder $query
     * @param         $constraintType
     * @param         $filterByColumn
     * @param         $value
     *
     * @return Builder
     */
    protected function constrain(Builder $query, $constraintType, $filterByColumn, $value)
    {
        $constraint = new EntryQueryFilterConstraint($query, $constraintType, $filterByColumn, $value);

        return $constraint->getQuery();
    }

    /**
     * Order
     *
     * @param Builder $query
     * @param                   $orderBy
     * @param                   $order
     *
     * @return Builder
     */
    public function order(Builder $query, $orderBy, $order)
    {
        $order = new EntryQuerySorter($query, $orderBy, $order);

        return $order->getQuery();
    }
}