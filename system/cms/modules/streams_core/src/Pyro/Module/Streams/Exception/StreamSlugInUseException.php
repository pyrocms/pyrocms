<?php namespace Pyro\Module\Streams\Exception;

class StreamSlugInUseException extends Exception
{
    protected $message = 'Stream slug is already in use.';
}
