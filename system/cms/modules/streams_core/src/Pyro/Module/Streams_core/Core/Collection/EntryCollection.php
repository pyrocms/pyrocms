<?php namespace Pyro\Module\Streams_core\Core\Collection;

use Pyro\Collection\EloquentCollection;

class EntryCollection extends EloquentCollection
{
	
	public $unformatted_entries = array();

	public function __construct(array $entries = array(), array $unformatted_entries = array())
	{
		// Put the formatted entries as the default collection
		parent::__construct($entries);

		// Store the unformatted entries in case we need them later
		$this->unformatted_entries = $unformatted_entries;
	}

	// We can add custom methods here that will be available in the collection returned by the Entry model
	public function enhanced()
	{
		// add odd / even boolean and add extra stuff to the models
	}

	public function unformatted()
	{
		return new static($this->unformatted_entries);
	}

}