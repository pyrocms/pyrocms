<?php namespace Pyro\Module\Streams_core\Core\Model\Exception;

class EntryNotFoundException extends Exception
{
	protected $message = 'The Entry was not found.';
}