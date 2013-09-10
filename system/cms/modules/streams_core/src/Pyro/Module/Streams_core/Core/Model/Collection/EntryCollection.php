<?php namespace Pyro\Module\Streams_core\Core\Model\Collection;

use Pyro\Model\Collection\EloquentCollection;

class EntryCollection extends EloquentCollection
{
	/**
	 * [$unformatted_entries description]
	 * @var array
	 */
	public $unformatted_entries = array();

	/**
	 * [__construct description]
	 * @param array $entries             [description]
	 * @param array $unformatted_entries [description]
	 */
	public function __construct(array $entries = array(), array $unformatted_entries = array())
	{
		// Put the formatted entries as the default collection
		parent::__construct($entries);

		// Store the unformatted entries in case we need them later
		$this->unformatted_entries = $unformatted_entries;
	}

	/**
	 * [unformatted description]
	 * @return [type] [description]
	 */
	public function unformatted()
	{
		return new static($this->unformatted_entries);
	}

}