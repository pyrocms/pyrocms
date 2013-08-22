<?php namespace Pyro\Module\Streams_core\Core\Model;

class StreamNotFoundException extends \RuntimeException
{
	protected $message = 'The Stream was not found';
}