<?php namespace Pyro\Module\Streams\Exception;

class FieldSlugInUseException extends Exception
{
    protected $message = 'The Field slug is already in use for this namespace.';
}
