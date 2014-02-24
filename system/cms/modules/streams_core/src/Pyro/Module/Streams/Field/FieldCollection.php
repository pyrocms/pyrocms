<?php namespace Pyro\Module\Streams\Field;

use Pyro\Model\EloquentCollection;
use Pyro\Module\Streams\FieldType\FieldTypeCollection;
use Pyro\Module\Streams\Stream\StreamModel;

class FieldCollection extends EloquentCollection
{
    /**
     * By slug
     *
     * @var array
     */
    protected $by_slug = null;

    /**
     * The array of Types
     *
     * @var array
     */
    protected $types = array();

    /**
     * Set stream
     *
     * @param StreamModel $stream
     *
     * @return  object
     */
    public function setStream(StreamModel $stream)
    {
        $this->each(
            function ($field) use ($stream) {
                $field->setStream($stream);
            }
        );

        return $this;
    }

    /**
     * Find a field by slug
     *
     * @param  string $field_slug
     *
     * @return object
     */
    public function findBySlug($field_slug = null)
    {
        return $this->findByAttribute($field_slug, 'field_slug');
    }

    /**
     * Get associative field slugs
     *
     * @return array
     */
    public function getAssociativeFieldSlugs()
    {
        return $this->lists('field_slug', 'field_slug');
    }

    /**
     * Get field slugs
     *
     * @param  array $columns
     *
     * @return array
     */
    public function getFieldSlugsExclude(array $columns = array())
    {
        $all = array_merge($this->getStandardColumns(), $this->getFieldSlugs());

        return array_diff($all, $columns);
    }

    /**
     * Get field slugs
     *
     * @return array
     */
    public function getFieldSlugs()
    {
        return array_values($this->lists('field_slug'));
    }

    /**
     * Get array indexed by slug
     *
     * @return array
     */
    public function getArrayIndexedBySlug()
    {
        $fields = array();

        foreach ($this->items as $field) {
            $fields[$field->field_slug] = $field;
        }

        return $fields;
    }

    /**
     * Get an array of field types
     *
     * @param  Pyro\Module\Streams\Entry\EntryModel $entry An optional entry to instantiate the field types
     *
     * @return array The array of field types
     */
    public function getTypes($entry = null)
    {
        $types = array();

        foreach ($this->items as $field) {
            $types[$field->field_type] = $field->getType($entry);
        }

        return new FieldTypeCollection($types);
    }

    /**
     * Field namespace options
     *
     * @return array The array of field namespaces
     */
    public function getFieldNamespaceOptions()
    {
        $options = array();

        foreach ($this->items as $field) {
            $options[$field->field_namespace] = humanize($field->field_namespace);
        }

        return $options;
    }
}
