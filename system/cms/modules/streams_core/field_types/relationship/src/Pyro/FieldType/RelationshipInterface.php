<?php namespace Pyro\FieldType;


interface RelationshipInterface
{
    public function getFieldTypeRelationshipOptions($type);

    public function getFieldTypeRelationshipTitle();

    public function getFieldTypeRelationshipValueField();

    public function getFieldTypeRelationshipSearchFields();
}
