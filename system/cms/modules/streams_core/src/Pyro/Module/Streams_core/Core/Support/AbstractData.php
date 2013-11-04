<?php
namespace Pyro\Module\Streams_core\Core\Support;

use Closure;

abstract class AbstractData extends AbstractDataCp
{

	public function setQuery($query)
	{
		$this->query = $query;

		return $this;
	}

	/**
	 * Set render
	 * @param  boolean $return 
	 * @return object          
	 */
	public function run($return = false)
	{
		$method = $this->getTriggerMethod();

		if (method_exists($this, $method))
		{
			return $this->{$method}();
		}

		return null;
	}
}
