<?php namespace Pyro\Module\Search\Models;

class SearchSingularAttributeNotSetException extends \RuntimeException
{
	protected $message = 'The singular attribute is not set.';
}