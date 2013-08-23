<?php namespace Pyro\Module\Streams_core\Core\Model\Exception;

class StreamNotFoundException extends Exception
{
	protected $message = 'The Stream was not found.';
}