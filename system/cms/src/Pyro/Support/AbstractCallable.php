<?php namespace Pyro\Support;

class AbstractCallable
{
    /**
     * Instance
     * @var [type]
     */
    protected static $instance;

    /**
     * Callback trigger prefix
     * @var string
     */
    protected $callback_trigger_prefix = 'fire_';

	/**
	 * Registered callbacks
	 * @var array
	 */
	protected $callbacks = array();

    /**
     * Chain trigger method
     * @var string
     */
    protected $chain_trigger_method;

    /**
     * Get the instance
     * @param  boolean $render 
     * @return object         
     */
    protected static function instance($method = null)
    {
        $instance = new static;

        $instance->chain_trigger_method = $method;

        return $instance;
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
        	$this->callbacks[camel_case($this->callback_trigger_prefix.$method_name)] = \Closure::bind($method_callable, $this, get_class());
        }
    }
 
 	/**
 	 * Hook into PHP calls to look for callbacks
 	 * @param  strign $method_name 
 	 * @param  array  $args        
 	 * @return function              
 	 */
	public function __call($method_name, array $args)
    {
        if (isset($this->callbacks[$method_name]))
        {
            return call_user_func_array($this->callbacks[$method_name], $args);
        }
        else
        {
        	return null;
        }
    }
}