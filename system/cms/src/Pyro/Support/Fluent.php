<?php namespace Pyro\Support;

use Illuminate\Support\Fluent as BaseFluent;
use Illuminate\Support\Str;

class Fluent extends BaseFluent
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
	 * Construct
	 */ 
	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);

		$this->boot();
	}

	/**
	 * Boot - initialize things on the construct without having to call parent
	 * 
	 * @return @void
	 */
	protected function boot()
	{}

	/**
	 * Get default attributes
	 * 
	 * @return array
	 */
	public function getDefaultAttributes()
	{
		return array();
	}

	/**
	 * Add attributes
	 * 
	 * @param attributes - array
	 * @return Pyro\Support\Fluent
	 */ 
    public function mergeAttributes(array $attributes = array())
    {
        $this->attributes = array_merge($this->attributes, $attributes);

        return $this;
    }

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
     * Reinitialize
     */
    public function clear()
    {
        self::__construct();
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
        } elseif (substr($method, 0, 3) == 'get') {
            return $this->get(lcfirst(substr($method, 3)), count($parameters) > 0 ? $parameters[0] : null);
        }

        $this->attributes[$method] = count($parameters) > 0 ? $parameters[0] : true;

        return $this;
    }
}