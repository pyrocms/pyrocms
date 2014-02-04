\<?php namespace Pyro\Module\Streams_core\Exceptions;

class ColumnDoesNotExistException extends Exception
{
    protected $message = 'The column does not exist.';
}
