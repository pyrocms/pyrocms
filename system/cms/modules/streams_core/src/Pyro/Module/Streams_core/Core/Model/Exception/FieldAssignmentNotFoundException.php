<?php namespace Pyro\Module\Streams_core\Core\Model\Exception;

use Pyro\Module\Streams_core\Core\Support\Exception\Exception;

class FieldAssignmentNotFoundException extends Exception
{
	protected $message = 'The Field Assignment was not found.';
}