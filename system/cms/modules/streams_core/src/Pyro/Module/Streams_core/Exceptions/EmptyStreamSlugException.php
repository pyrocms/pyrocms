<?php namespace Pyro\Module\Streams_core\Exceptions;

class EmptyStreamSlugException extends Exception
{
    protected $message = 'The stream slug property is empty.';
}
