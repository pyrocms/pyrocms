<?php namespace Pyro\Module\Streams_core\Exceptions;

class ClassNotInstanceOfEntryException extends Exception
{
    protected $message = 'The class is not an instance of Pyro\Module\Streams_core\EntryModel.';
}
