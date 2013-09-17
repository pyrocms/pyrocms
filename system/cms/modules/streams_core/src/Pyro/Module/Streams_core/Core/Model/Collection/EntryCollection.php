<?php namespace Pyro\Module\Streams_core\Core\Model\Collection;

use Pyro\Model\Collection\EloquentCollection;

class EntryCollection extends EloquentCollection
{
	/**
	 * Unformatted entries
	 * @var array
	 */
	public $unformatted_entries = array();

	/**
	 * Construct passing the entries and unformatted entries
	 * @param array $entries
	 * @param array $unformatted_entries
	 */
	public function __construct(array $entries = array(), array $unformatted_entries = array())
	{
		// Put the formatted entries as the default collection
		parent::__construct($entries);

		// Store the unformatted entries in case we need them later
		$this->unformatted_entries = $unformatted_entries;
	}

	/**
	 * Unformatted enties
	 * @return array
	 */
	public function unformatted()
	{
		return new static($this->unformatted_entries);
	}
}
