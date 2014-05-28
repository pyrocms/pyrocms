<?php namespace Pyro\FieldType;

use Illuminate\Support\Str;

use Pyro\Model\Eloquent;
use Pyro\Module\Streams\FieldType\FieldTypeAbstract;
use Pyro\Module\Streams\Entry\EntryModel;
use Pyro\Module\Streams\Field\FieldModel;
use Pyro\Module\Streams\Stream\StreamModel;

/**
 * PyroStreams Relationship Field Type
 *
 * @package        PyroCMS\Core\Modules\Streams Core\Field Types
 * @author         Parse19
 * @copyright      Copyright (c) 2011 - 2012, Parse19
 * @license        http://parse19.com/pyrostreams/docs/license
 * @link           http://parse19.com/pyrostreams
 */
class Relationship extends FieldTypeAbstract
{
    /**
     * Field type slug
     *
     * @var string
     */
    public $field_type_slug = 'relationship';

    /**
     * DB column type
     *
     * @var string
     */
    public $db_col_type = 'string';

    /**
     * Custom parameters
     *
     * @var array
     */
    public $custom_parameters = array(
        'stream',
        'relation_class',
        'scope',
    );

    /**
     * Version
     *
     * @var string
     */
    public $version = '2.0';

    /**
     * Author
     *
     * @var  array
     */
    public $author = array(
        'name' => 'Ryan Thompson - PyroCMS',
        'url'  => 'http://pyrocms.com/'
    );

    /**
     * Relation
     *
     * @return object The relation object
     */
    public function relation()
    {
        return $this->belongsTo($this->getRelationClass());
    }

    /**
     * Output form input
     *
     * @access     public
     * @return    string
     */
    public function formInput()
    {
        $this->isFilter = false;

        $options = $this->getOptions();

        // Return an HTML drop down
        return form_dropdown($this->getFormSlug(), $options, $this->value);
    }

    /**
     * Output the form input for frontend use
     *
     * @return string
     */
    public function publicFormInput()
    {
        $this->isFilter = false;

        return form_dropdown($this->getFormSlug(), $this->getOptions(), $this->value);
    }

    /**
     * Output filter input
     *
     * @access     public
     * @return    string
     */
    public function filterInput()
    {
        $this->isFilter = true;

        $options = $this->getOptions();

        // Return an HTML drop down
        return form_dropdown($this->getFilterSlug('is'), $options, $this->getFilterValue('is'));
    }

    /**
     * String output
     *
     * @return  mixed   null or string
     */
    public function stringOutput()
    {
        if ($relatedModel = $this->getRelationResult()) {
            if (!$relatedModel instanceof RelationshipInterface) {
                throw new ClassNotInstanceOfRelationshipInterfaceException;
            }

            return $relatedModel->getFieldTypeRelationshipTitle();
        }

        return null;
    }

    /**
     * Plugin output
     *
     * @return array
     */
    public function pluginOutput()
    {
        if ($relatedModel = $this->getRelationResult()) {
            return $relatedModel;
        }

        return null;
    }

    /**
     * Data output
     *
     * @return RelationClassModel
     */
    public function dataOutput()
    {
        return $this->pluginOutput();
    }

    /**
     * Choose a stream to relate to.. or remote source
     *
     * @param  mixed $value
     * @return string
     */
    public function paramStream($value = null)
    {
        $options = StreamModel::getStreamAssociativeOptions();

        return form_dropdown('stream', $options, $value);
    }

    /**
     * Options
     *
     * @return array
     */
    public function getOptions()
    {
        if ($relatedClass = $this->getRelationClass()) {

            $relatedModel = new $relatedClass;

            if (!$relatedModel instanceof RelationshipInterface) {
                throw new ClassNotInstanceOfRelationshipInterfaceException;
            }

            return $relatedModel->getFieldTypeRelationshipOptions($this);
        }

        return array();
    }

    /**
     * Get column name
     *
     * @return string
     */
    public function getColumnName()
    {
        return parent::getColumnName() . '_id';
    }

    /**
     * Get placeholder
     * @return string
     */
    public function getPlaceholder($type = null, $default = null)
    {
        return $this->getParameter('placeholder', $this->field->field_name);
    }
}
