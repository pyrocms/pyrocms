<?php namespace Pyro\Model\Exception;

class ClassNotInstanceOfEloquentException extends \RuntimeException
{
	protected $message = 'The class is not an instance of Pyro\Model\Eloquent.';
}