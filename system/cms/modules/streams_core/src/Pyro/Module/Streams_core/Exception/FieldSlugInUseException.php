<?php namespace Pyro\Module\Streams_core\Exception;

class FieldSlugInUseException extends Exception
{
	protected $message = 'The Field slug is already in use for this namespace.';
}