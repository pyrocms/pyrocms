<?php namespace Pyro\Module\Streams_core\Core\Model\Exception;

use Pyro\Module\Streams_core\Core\Support\Exception\Exception;

class StreamNotFoundException extends Exception
{
	protected $message = 'The Stream was not found.';
}