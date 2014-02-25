<?php namespace Pyro\Module\Search\Model\Exception;

class SearchSingularAttributeNotSetException extends \RuntimeException
{
    protected $message = 'The singular attribute is not set.';
}
