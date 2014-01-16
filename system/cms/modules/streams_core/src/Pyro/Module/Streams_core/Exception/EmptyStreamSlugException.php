<?php namespace Pyro\Module\Streams_core\Exception;

class EmptyStreamSlugException extends Exception
{
    protected $message = 'The stream slug property is empty.';
}
