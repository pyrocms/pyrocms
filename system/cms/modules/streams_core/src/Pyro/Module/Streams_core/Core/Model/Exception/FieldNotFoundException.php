<?php namespace Pyro\Module\Streams_core\Core\Model\Exception;

use Pyro\Module\Streams_core\Core\Support\Exception\Exception;

class FieldNotFoundException extends Exception
{
	protected $message = 'The Field was not found.';
}