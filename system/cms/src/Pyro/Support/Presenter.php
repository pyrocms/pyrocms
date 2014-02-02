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

    	$resourceArray = $this->resource->toArray();

    	return array_merge($resourceArray, $presenterArray);
    }
}