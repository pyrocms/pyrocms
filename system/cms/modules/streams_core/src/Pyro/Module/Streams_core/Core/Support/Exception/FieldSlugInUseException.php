<?php namespace Pyro\Module\Streams_core\Core\Support\Exception;

class FieldSlugInUseException extends Exception
{
	protected $message = 'The Field slug is already in use for this namespace.';
}