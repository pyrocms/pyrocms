<?php namespace Pyro\FieldType;

use Pyro\Module\Streams\Field\FieldModel;
use Pyro\Module\Streams\FieldType\FieldTypeAbstract;

/**
 * PyroStreams Slug Field Type
 *
 * @package        PyroCMS\Core\Modules\Streams Core\Field Types
 * @author         Parse19
 * @copyright      Copyright (c) 2011 - 2012, Parse19
 * @license        http://parse19.com/pyrostreams/docs/license
 * @link           http://parse19.com/pyrostreams
 */
class Slug extends FieldTypeAbstract
{
    public $field_type_slug = 'slug';

    public $db_col_type = 'string';

    public $custom_parameters = array('space_type', 'slug_field');

    public $version = '1.0.0';

    public $author = array('name' => 'Parse19', 'url' => 'http://parse19.com');

    // --------------------------------------------------------------------------

    /**
     * Event
     *
     * Add the slugify plugin
     *
     * @return    void
     */
    public function event()
    {
        if (!defined('ADMIN_THEME')) {
            $this->js('jquery.slugify.js');
        }
    }

    // --------------------------------------------------------------------------

    /**
     * Pre Save
     *
     * No PyroCMS tags in slug fields.
     *
     * @return string
     */
    public function preSave()
    {
        ci()->load->helper('text');

        return escape_tags($this->value);
    }

    // --------------------------------------------------------------------------

    /**
     * Pre Output
     *
     * No PyroCMS tags in slugs.
     *
     * @return string
     */
    public function stringOutput()
    {
        ci()->load->helper('text');

        return escape_tags($this->value);
    }

    // --------------------------------------------------------------------------

    /**
     * Output form input
     *
     * @param    array
     *
     * @return    string
     */
    public function formInput()
    {
        $options['name']         = $this->getFormSlug();
        $options['id']           = $this->getFormSlug();
        $options['value']        = $this->value;
        $options['autocomplete'] = 'off';
        $jquery                  = null;

        $namespace = $this->field->field_namespace;
        $slug_field = FieldModel::findBySlugAndNamespace($this->getParameter('slug_field'), $namespace);

        if ($slug_field) {
            $field_type = $slug_field->getType($this->entry);

            $jquery = "<script>(function($) {
                $(function(){
                        pyro.generate_slug('#{$field_type->getFormSlug(
            )}', '#{$this->getFormSlug()}', '{$this->getParameter('space_type')}');
                });
            })(jQuery);
            </script>";
        }

        return form_input($options) . "\n" . $jquery;
    }

    // --------------------------------------------------------------------------

    /**
     * Dash or Underscore?
     */
    public function paramSpaceType($value = null)
    {
        $options = array(
            '-' => lang('streams:slug.dash'),
            '_' => lang('streams:slug.underscore')
        );

        return form_dropdown('space_type', $options, $value);
    }

    // --------------------------------------------------------------------------

    /**
     * What field to slugify?
     */
    public function paramSlugField($value = null)
    {
        $field_slug = null;

        if ($this->field) {
            $field_slug = $this->field->field_slug;
        }

        // Get all the fields
        $options = FieldModel::getFieldOptions($field_slug);

        return form_dropdown('slug_field', $options, $value);
    }
}
