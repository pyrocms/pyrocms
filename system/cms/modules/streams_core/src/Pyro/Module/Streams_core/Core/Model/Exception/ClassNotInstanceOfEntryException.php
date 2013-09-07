<?php namespace Pyro\Module\Streams_core\Core\Model\Exception;

use Pyro\Module\Streams_core\Core\Support\Exception\Exception;

class ClassNotInstanceOfEntryException extends Exception
{
	protected $message = 'The class is not an instance of Pyro\Module\Streams_core\Core\Model\Entry.';
}