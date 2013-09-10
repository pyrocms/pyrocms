<?php namespace Pyro\Module\Streams_core\Core\Model\Relation;

use Illuminate\Database\Eloquent\Relations\MorphOne;

class MorphOneEntry extends MorphOne
{
	public $stream_column = null;

	public function setStreamColumn($stream_column = null)
	{
		$this->stream_column = $stream_column;
	}

	public function getStreamColumn()
	{
		return $this->stream_column;
	}
}