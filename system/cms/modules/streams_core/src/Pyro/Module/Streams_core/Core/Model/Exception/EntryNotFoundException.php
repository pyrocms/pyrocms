<?php namespace Pyro\Module\Streams_core\Core\Model\Exception;

use Pyro\Module\Streams_core\Core\Support\Exception\Exception;

class EntryNotFoundException extends Exception
{
	protected $message = 'The Entry was not found.';
}