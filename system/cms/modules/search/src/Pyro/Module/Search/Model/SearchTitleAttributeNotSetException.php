<?php namespace Pyro\Module\Search\Model;

class SearchTitleAttributeNotSetException extends \RuntimeException
{
	protected $message = 'The title attribute is not set.';
}