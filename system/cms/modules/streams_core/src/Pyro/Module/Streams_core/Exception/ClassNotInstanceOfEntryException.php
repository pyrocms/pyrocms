<?php namespace Pyro\Module\Streams_core\Exception;

class ClassNotInstanceOfEntryModelException extends Exception
{
	protected $message = 'The class is not an instance of Pyro\Module\Streams_core\EntryModel.';
}