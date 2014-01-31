<?php namespace Pyro\Models\Exceptions;

class ClassNotInstanceOfEloquentException extends \RuntimeException
{
	protected $message = 'The class is not an instance of Pyro\Models\Eloquent.';
}