<?php namespace Pyro\Support;

use Illuminate\Support\Str;

abstract class AbstractCallable extends Fluent
{
	/**
	 * Registered callbacks
	 * @var array
	 */
	protected $callbacks = array();

    /**
     * Callback trigger prefix
     * @var string
     */
    const CALLBACK_TRIGGER_PREFIX = 'fire_';

    /**
     * Chain trigger method prefix
     * @var string
     */
    const TRIGGER_PREFIX = 'trigger';

    /**
     * Get trigger method
     * @return string
     */
    protected function getTriggerMethod()
    {
        return static::TRIGGER_PREFIX.Str::studly($this->triggerMethod);
    }

	/**
	 * Add a callback
	 * @param string $method_name     
	 * @param boolean $method_callable
     *
     * The call back will be like fire[CamelCaseCallback]() and the Closure will be [camelCaseCallback]()
     *
     * i.e. fireOnSave() is the callback for the onSave() Closure
     * 
	 */
    protected function addCallback($method_name, $method_callable)
    {
        if (is_callable($method_callable))
        {
        	$this->callbacks[camel_case(static::CALLBACK_TRIGGER_PREFIX.$method_name)] = \Closure::bind($method_callable, $this, get_class());
        }
    }
 
 	/**
 	 * Handle dynamic calls to the container to set attributes 
     * or Hook into PHP calls to look for callbacks
 	 * @param  strign $method 
 	 * @param  array  $parameters        
 	 * @return function|\Illuminate\Support\Fluent      
 	 */
	public function __call($method, $parameters)
    {
        if (isset($this->callbacks[$method]))
        {
            return call_user_func_array($this->callbacks[$method], $parameters);
        }

        $this->attributes[$method] = count($parameters) > 0 ? $parameters[0] : true;

        return $this;
    }
}