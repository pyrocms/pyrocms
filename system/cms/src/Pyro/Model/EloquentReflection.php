<?php namespace Pyro\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Pyro\Model\Contracts\FilterableModelInterface;
use ReflectionClass;

class EloquentReflection extends ReflectionClass
{
    protected $model;

    public function __construct(Model $model)
    {
        parent::__construct($model);

        $this->model = $model;
    }

    public function getFilterableColumns()
    {
        if ($this->model instanceof FilterableModelInterface) {
            return $this->model->getFilterableColumns();
        }

        return array();
    }

    public function getRelationClass($attribute = null)
    {
        if (! method_exists($this->model, $attribute)) {
            return false;
        }

        $relation = $this->model->{$attribute}();

        return ($relation instanceof Relation) ? $relation : false;
    }
}