<?php namespace Pyro\Module\Streams_core\Core\Model\Exception;

class FieldSlugEmptyException extends Exception
{
	protected $message = 'The Field model has no field_slug value in the fields table.';
}