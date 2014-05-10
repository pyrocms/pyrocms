<?php namespace Pyro\Module\Streams\Entry;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
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
        $this->query  = $query;
        $this->model  = $query->getModel();
        $this->stream = $this->model->getStream();
    }

    /**
     * Make filters
     */
    public function make()
    {
        if (($action = ci()->input->post($this->getPostTrigger())) == 'apply') {
            $this->applyFilters();

            redirect(uri_string());
        } elseif ($action == 'clear') {
            $this->clearFilters();

            redirect(uri_string());
        }
    }

    public function getQuery()
    {
        // -------------------------------------
        // Filters (QueryString API)
        // -------------------------------------
        if ($filters = $this->getAppliedFilters()) {

            // Loop and process!
            foreach ($filters as $filter => $value) {

                // Split into components
                $commands = explode('-', $filter);

                // Get the original fieldSlug
                $fieldSlug = $commands[0];

                // Get the filterBy array
                $filterBy = explode('|', $fieldSlug);

                // The first item in the array is the qualified fieldSlug
                $fieldSlug = array_shift($filterBy);

                // Get the camel case relation method from the fieldSlug
                $relationMethod = Str::camel($fieldSlug);

                // Get the constraint type string
                if (isset($commands[1])) {
                    $constraintType = $commands[1];
                } else {
                    continue;
                }

                // Enable whereHas logic only if the slug is a relation
                if ($value != null) {
                    if ($relation = $this->reflection($this->model)->getRelationClass($relationMethod)) {
                        $this->query->whereHas(
                            $relationMethod,
                            function ($query) use ($filterBy, $constraintType, $value) {
                                // Do a constraint for each column from the related model
                                foreach ($filterBy as $column) {
                                    /**
                                     * @todo - Here is an opportunity to override the constraint
                                     * by parsing each column string. Revisit to implement this feature.
                                     */
                                    $this->constraint($query, $constraintType, $column, $value);
                                }
                            }
                        );
                    } else {

                        // Do a normal constraint
                        $this->constraint($this->query, $constraintType, $fieldSlug, $value);
                    }
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
     * @return EloquentReflection
     */
    protected function reflection($model)
    {
        return new EloquentReflection($model);
    }

    /**
     * Get filter key
     *
     * @return string
     */
    protected function getFilterKey()
    {
        return $this->stream->stream_namespace . '-' . $this->stream->stream_slug;
    }

    /**
     * Get post trigger
     *
     * @return string
     */
    protected function getPostTrigger()
    {
        return 'filter-' . $this->getFilterKey();
    }

    /**
     * Get post data
     *
     * @return mixed
     */
    protected function getPostData()
    {
        $post = ci()->input->post();

        unset($post[$this->getPostTrigger()]);

        foreach ($post as $key => $value) {
            if ($value == null or $value == '-----') {
                unset($post[$key]);
            } else {

                // Clean core filters
                if (strpos($key, 'f-') !== false) {
                    $post[$this->getPostDataFilterKey($key)] = $value;

                    unset($post[$key]);
                }
            }
        }

        return $post;
    }

    /**
     * Get post data filter key
     *
     * @param $key
     */
    public function getPostDataFilterKey($key)
    {
        return str_replace('f-' . $this->getFilterKey() . '-', '', $key);
    }

    /**
     * Apply filters
     */
    protected function applyFilters()
    {
        if (isset(ci()->module_details['slug'])) {
            $prefix = ci()->module_details['slug'] . '_';
        } else {
            $prefix = null;
        }

        ci()->session->set_userdata($prefix . $this->getFilterKey(), $this->getPostData());
    }

    /**
     * Clear filters
     */
    protected function clearFilters()
    {
        if (isset(ci()->module_details['slug'])) {
            $prefix = ci()->module_details['slug'] . '_';
        } else {
            $prefix = null;
        }
        
        ci()->session->unset_userdata($prefix . $this->getFilterKey());
    }

    /**
     * Get filters
     *
     * @return mixed
     */
    public function getAppliedFilters()
    {
        if (isset(ci()->module_details['slug'])) {
            $prefix = ci()->module_details['slug'] . '_';
        } else {
            $prefix = null;
        }

        if (isset(ci()->session)) {
            return ci()->session->userdata($prefix . $this->getFilterKey());
        }

        return array();
    }

    /**
     * Get limit
     * 
     * @return null
     */
    public function getLimit()
    {
        $appliedFilters = $this->getAppliedFilters();

        if (isset($appliedFilters['limit-'.$this->getFilterKey()])) {
            return $appliedFilters['limit-'.$this->getFilterKey()];
        }

        return null;
    }

    /**
     * Constraint
     *
     * @param Builder $query
     * @param         $constraintType
     * @param         $filterByColumn
     * @param         $value
     * @return Builder
     */
    protected function constraint(Builder $query, $constraintType, $filterByColumn, $value)
    {
        $constraint = new EntryQueryFilterConstraint($query, $constraintType, $filterByColumn, $value);

        return $constraint->getQuery();
    }

    /**
     * Order
     *
     * @param Builder           $query
     * @param                   $orderBy
     * @param                   $order
     * @return Builder
     */
    public function order(Builder $query, $orderBy, $order)
    {
        $order = new EntryQuerySorter($query, $orderBy, $order);

        return $order->getQuery();
    }
}
