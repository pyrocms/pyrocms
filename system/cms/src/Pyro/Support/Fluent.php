<?php namespace Pyro\Support;

use Illuminate\Support\Fluent as IlluminateFluent;

class Fluent extends IlluminateFluent
{
	/**
	 * Construct
	 */ 
	public function __construct(array $attributes = array())
	{
		parent::__construct(array_merge($this->getDefaultAttributes(), $attributes));

		$this->boot();
	}

	/**
	 * Boot - initialize things on the construct without having to call parent
	 * 
	 * @return @void
	 */
	public function boot()
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
    protected function mergeAttributes(array $attributes = array())
    {
        $this->attributes = array_merge($this->attributes, $attributes);

        return $this;
    }
}