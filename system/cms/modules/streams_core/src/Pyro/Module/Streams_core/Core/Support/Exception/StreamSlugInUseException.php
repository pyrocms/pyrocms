<?php namespace Pyro\Module\Streams_core\Core\Support\Exception;

class StreamSluginUseException extends Exception
{
	protected $message = 'Stream slug is already in use.';
}