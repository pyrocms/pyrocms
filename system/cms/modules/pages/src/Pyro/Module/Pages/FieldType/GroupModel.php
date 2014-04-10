<?php namespace Pyro\Module\Pages\FieldType;

use Pyro\FieldType\RelationshipInterface;
use Pyro\Module\Users\Model\Group;

class GroupModel extends Group implements RelationshipInterface
{
    public function getFieldTypeRelationshipOptions($type)
    {
        // @todo - Ryan Thompson, do your thang.
        return array();
    }

    public function getFieldTypeRelationshipTitle()
    {
        // TODO: Implement getFieldTypeRelationshipTitle() method.
    }

    public function getFieldTypeRelationshipValueField()
    {
        // TODO: Implement getFieldTypeRelationshipValueField() method.
    }

    public function getFieldTypeRelationshipSearchFields()
    {
        // TODO: Implement getFieldTypeRelationshipSearchFields() method.
    }
}