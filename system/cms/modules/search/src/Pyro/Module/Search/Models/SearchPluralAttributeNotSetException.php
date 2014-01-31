<?php namespace Pyro\Module\Search\Models;

class SearchPluralAttributeNotSetException extends \RuntimeException
{
	protected $message = 'The plural attribute is not set.';
}