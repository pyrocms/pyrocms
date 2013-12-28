<?php namespace Pyro\Module\Streams_core\Exception;

class ClassNotInstanceOfEntryException extends Exception
{
    protected $message = 'The class is not an instance of Pyro\Module\Streams_core\EntryModel.';
}
