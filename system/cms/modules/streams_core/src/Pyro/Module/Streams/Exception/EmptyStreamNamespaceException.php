<?php namespace Pyro\Module\Streams\Exception;

class EmptyStreamNamespaceException extends Exception
{
    protected $message = 'The stream namespace property is empty.';
}
