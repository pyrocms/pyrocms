<?php namespace Pyro\Module\Search\Models;

class SearchTitleAttributeNotSetException extends \RuntimeException
{
	protected $message = 'The title attribute is not set.';
}