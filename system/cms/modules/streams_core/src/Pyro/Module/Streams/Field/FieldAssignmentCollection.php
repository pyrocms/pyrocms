<?php namespace Pyro\Module\Streams\Field;

class FieldAssignmentCollection extends FieldCollection
{
    /**
     * Get stream ids from the assignment collection
     *
     * @return array The array of stream ids
     */
    public function getStreamIds()
    {
        return array_values($this->lists('stream_id'));
    }

    /**
     * Get field ids from the assignment collection
     *
     * @return array The array of field ids
     */
    public function getFieldIds()
    {
        return array_values($this->lists('field_id'));
    }

    public function getRelationFields()
    {
        return $this->filter(
            function ($assignment) {

                if ($type = $assignment->getType()) {
                    return $type->hasRelation();
                }

                return false;
            }
        );
    }
}
