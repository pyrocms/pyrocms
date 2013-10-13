<?php namespace Pyro\Module\Search\Model;

class SearchPluralAttributeNotSetException extends \RuntimeException
{
	protected $message = 'The plural attribute is not set.';
}