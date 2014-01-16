<?php namespace Pyro\Module\Streams_core;

use Pyro\Module\Streams_core\Exception\EmptyStreamNamespaceException;
use Pyro\Module\Streams_core\Exception\EmptyStreamSlugException;

class EntryDataModel
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

		$this->streamModel = new $entryModelClass;
	}

	/**
	 * Get entry model class
	 * @return string
	 */
	public function getEntryModelClass()
	{
		if (! $streamSlug = $this->getStreamSlug()) {
			throw new EmptyStreamSlugException;
		}

		if (! $streamNamespace = $this->getStreamNamespace()) {
			throw new EmptyStreamNamespaceException;
		}

		return StreamModel::getEntryModelClass($streamSlug, $streamNamespace);
	}

	/**
	 * Get property dynamic call
	 * @return mixed
	 */
	public function __get($name)
	{
		return $this->entryModel->{$name};
	}

	/**
	 * Method dynamic call
	 * @return mixed
	 */
	public function __call($method, $arguments)
	{
		return call_user_func_array(array($this->entryModel, $method), $arguments);
	}

	/**
	 * Get stream slug
	 * @return string
	 */
	public function getStreamSlug()
	{
		return $this->streamSlug;
	}

	/**
	 * Get namespace
	 * @return string
	 */
	public function getStreamNamespace()
	{
		return $this->streamNamespace;
	}

	/**
	 * Static method dynamic call
	 * @return mixed
	 */
	public static function __callStatic($method, $arguments)
	{
		$entryModelClass = $this->getEntryModelClass();

		return call_user_func_array(array($entryModelClass, $method), $arguments);
	}

}