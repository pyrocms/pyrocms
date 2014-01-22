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
	}

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
    protected function addAttributes(array $attributes = array())
    {
        $this->attributes = array_merge($this->attributes, $attributes);

        return $this;
    }
}