<?php namespace Pyro\Module\Streams\Exception;

class ClassNotInstanceOfEntryException extends Exception
{
    protected $message = 'The class is not an instance of Pyro\Module\Streams\EntryModel.';
}
