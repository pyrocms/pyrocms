<?php namespace Pyro\Module\Streams_core\Data;

use Closure;
use Pyro\Module\Streams_core\Core\Model;
use Pyro\Module\Streams_core\Core\Support\AbstractData;

class Entries extends AbstractData
{

	public static function getEntry($id, $stream_slug = null, $stream_namespace = null, $format = true, $plugin = true)
	{
		return Model\Entry::stream($stream_slug, $stream_namespace)->setFormat($format)->setPlugin($plugin)->getEntry($id);
	}

	public static function delete($stream_slug = null, $stream_namespace = null)
	{

	}

}