<?php namespace Pyro\Module\Pages\FieldType;

use Pyro\FieldType\RelationshipInterface;
use Pyro\Module\Users\Model\Group;

class GroupModel extends Group implements RelationshipInterface
{
    /**
     * Get field type relationship options
     *
     * @param $type
     * @return array
     */
    public function getFieldTypeRelationshipOptions($type)
    {
        return $this->get()->lists('description','id');
    }

    /**
     * Get field type relationship results
     *
     * @param $query
     */
    public function getFieldTypeRelationshipResults($query)
    {

    }

    /**
     * Get field type relationship title
     *
     * @return string
     */
    public function getFieldTypeRelationshipTitle()
    {
        return 'title';
    }

    /**
     * Get field type relationship value field
     *
     * @return string
     */
    public function getFieldTypeRelationshipValueField()
    {
        return $this->getKeyName();
    }

    /**
     * Get field type relationship search fields
     *
     * @return array
     */
    public function getFieldTypeRelationshipSearchFields()
    {
        return array('description');
    }
}
