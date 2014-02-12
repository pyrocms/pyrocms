<?php namespace Pyro\Module\Streams\Exception;

class EmptyStreamSlugException extends Exception
{
    protected $message = 'The stream slug property is empty.';
}
