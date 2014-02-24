<?php namespace Pyro\FieldType;


class ClassNotInstanceOfRelationshipInterfaceException extends \RuntimeException
{
    protected $message = 'The related model is not instanceof Pyro\FieldType\Relationship\RelationshipInterface.';
}
