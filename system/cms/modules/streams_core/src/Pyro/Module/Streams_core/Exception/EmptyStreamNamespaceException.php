<?php namespace Pyro\Module\Streams_core\Exception;

class EmptyStreamNamespaceException extends Exception
{
    protected $message = 'The stream namespace property is empty.';
}
