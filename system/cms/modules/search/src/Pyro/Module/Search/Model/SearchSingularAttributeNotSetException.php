<?php namespace Pyro\Module\Search\Model;

class SearchSingularAttributeNotSetException extends \RuntimeException
{
	protected $message = 'The singular attribute is not set.';
}