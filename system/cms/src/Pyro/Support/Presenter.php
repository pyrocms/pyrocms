<?php namespace Pyro\Support;

use Pyro\Support\Contracts\ArrayableInterface;
use McCool\LaravelAutoPresenter\BasePresenter;

class Presenter extends BasePresenter implements ArrayableInterface
{
	protected $appends = array();

    public function toArray()
    {
    	$presenterArray = array();

    	foreach ($this->appends as $method) {
    		$presenterArray[$method] = $this->{$method}(); 
    	}

    	$resourceArray = array();

        foreach ($this->resource->getAttributeKeys() as $key) {
            $resourceArray[$key] = $this->getPresenterAttribute($key);
        }

    	return array_merge($resourceArray, $presenterArray);
    }

    /**
     * Get presenter formatted attribute
     * @param  string $key
     * @return mixed
     */
    public function getPresenterAttribute($key)
    {
        $key = Str::camel($key);
        return $this->resource->$key;
    }

    /**
     * Magic Method access initially tries for local methods then, defers to
     * the decorated object.
     */
    public function __get($key)
    {
        return $this->getPresenterAttribute($key);
    }
}