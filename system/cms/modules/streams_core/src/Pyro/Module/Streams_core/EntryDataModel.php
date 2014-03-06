<?php namespace Pyro\Module\Streams_core;

use Pyro\Module\Streams_core\Exception\EmptyStreamNamespaceException;
use Pyro\Module\Streams_core\Exception\EmptyStreamSlugException;

abstract class EntryDataModel
{
	/**
	 * Stream slug
	 * @var string
	 */
	protected $streamSlug;

	/**
	 * Stream namespace
	 * @var string
	 */
	protected $streamNamespace;

	/**
	 * Entry model
	 * @var Pyro\Module\Streams_core\EntryModel|null
	 */
	protected $entryModel;

	/**
	 * Class construct
	 * @return null
	 */
	public function __construct()
	{
		$entryModelClass = $this->getEntryModelClass();

		$this->entryModel = new $entryModelClass;
	}

	/**
	 * Get entry model class
	 * @return string
	 */
	public function getEntryModelClass()
	{
		if (! $this->streamSlug) {
			throw new EmptyStreamSlugException;
		}

		if (! $this->streamNamespace) {
			throw new EmptyStreamNamespaceException;
		}

		return StreamModel::getEntryModelClass($this->streamSlug, $this->streamNamespace);
	}

	public function getEntryModel()
	{
		return $this->entryModel;
	}

	/**
	 * Get property dynamic call
	 * @return mixed
	 */
	public function __get($name)
	{
		return $this->entryModel->getAttribute($name);
	}

	/**
	 * Get property dynamic call
	 * @return mixed
	 */
	public function __set($name, $value)
	{
		return $this->entryModel->setAttribute($name, $value);
	}

    /**
     * Handle dynamic method calls into the method.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (method_exists($this->entryModel, $method) or in_array($method, array('increment', 'decrement')))
        {
                return call_user_func_array(array($this->entryModel, $method), $parameters);
        }

        $query = $this->entryModel->newQuery();

        return call_user_func_array(array($query, $method), $parameters);
    }

	/**
	 * Static method dynamic call
	 * @return mixed
	 */
	public static function __callStatic($method, $arguments)
	{
		$instance = new static;

		return $instance->__call($method, $arguments);
	}

}