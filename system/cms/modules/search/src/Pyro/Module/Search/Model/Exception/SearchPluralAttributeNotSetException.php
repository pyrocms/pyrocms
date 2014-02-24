<?php namespace Pyro\Module\Search\Model\Exception;

class SearchPluralAttributeNotSetException extends \RuntimeException
{
    protected $message = 'The plural attribute is not set.';
}
