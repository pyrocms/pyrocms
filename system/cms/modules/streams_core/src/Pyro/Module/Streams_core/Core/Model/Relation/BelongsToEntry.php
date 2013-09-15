<?php namespace Pyro\Module\Streams_core\Core\Model\Relation;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BelongsToEntry extends BelongsTo
{
	/**
	 * String column
	 * @var string
	 */
	protected $stream_column = null;

	protected $stream = null;

	/**
	 * Set the string column
	 * @param string $stream_column
	 */
	public function setStreamColumn($stream_column = null)
	{
		$this->stream_column = $stream_column;

		return $this;
	}

	/**
	 * Get string column
	 * @return string
	 */
	public function getStreamColumn()
	{
		return $this->stream_column;
	}

	/**
	 * Set the string column
	 * @param string $stream_column
	 */
	public function setStream($stream = null)
	{
		$this->stream = $stream;

		return $this;
	}

	/**
	 * Set the string column
	 * @param string $stream_column
	 */
	public function getStream()
	{
		return $this->stream;
	}

	public function getResults()
	{
		if ($entry = parent::getResults())
		{
			$entry->exists = true;

			if ($this->stream)
			{
				$entry->setTable($this->stream->stream_prefix.$this->stream->stream_slug);
			}
		}

		return $entry;
	}
}
