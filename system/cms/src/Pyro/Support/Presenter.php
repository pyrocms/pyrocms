<?php namespace Pyro\Support;

use McCool\LaravelAutoPresenter\BasePresenter;
use Pyro\Support\Contracts\ArrayableInterface;

class Presenter extends BasePresenter implements ArrayableInterface
{
    /**
     * The array of appended attributes
     *
     * @var array
     */
    protected $appends = array();

    /**
     * Convert the object to an array
     *
     * @return array
     */
    public function toArray()
    {
        $presenterArray = $this->getAppendsAttributes();

        if (!$this->resource instanceof ArrayableInterface) {
            return array_merge($this->resource->toArray(), $presenterArray);
        }

        return array();
    }

    /**
     * Get appended attributes
     *
     * @return array
     */
    public function getAppendsAttributes()
    {
        $presenterArray = array();

        foreach ($this->appends as $method) {
            $presenterArray[$method] = $this->{$method}();
        }

        return $presenterArray;
    }

    /**
     * Magic Method access initially tries for local methods then, defers to
     * the decorated object.
     */
    public function __get($key)
    {
        return $this->getPresenterAttribute($key);
    }

    /**
     * Get presenter formatted attribute
     *
     * @param  string $key
     *
     * @return mixed
     */
    public function getPresenterAttribute($key)
    {
        return $this->resource->{Str::camel($key)};
    }
}