<?php namespace Pyro\Module\Streams_core\Core\Model\Relation;

use Illuminate\Database\Eloquent\Relations\MorphOne;

class MorphOneEntry extends MorphOne
{
	/**
	 * String column
	 * @var string
	 */
	public $stream_column = null;

	/**
	 * Set the string column
	 * @param string $stream_column
	 */
	public function setStreamColumn($stream_column = null)
	{
		$this->stream_column = $stream_column;
	}

	/**
	 * Get string column
	 * @return string
	 */
	public function getStreamColumn()
	{
		return $this->stream_column;
	}
}
