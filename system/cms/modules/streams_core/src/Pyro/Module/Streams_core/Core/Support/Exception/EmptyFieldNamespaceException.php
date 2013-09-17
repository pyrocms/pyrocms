<?php namespace Pyro\Module\Streams_core\Core\Support\Exception;

class EmptyFieldNamespaceException extends Exception
{
	protected $message = 'The Field namespace is empty.';
}