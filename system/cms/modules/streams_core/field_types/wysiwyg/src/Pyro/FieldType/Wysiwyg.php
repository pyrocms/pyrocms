<?php namespace Pyro\FieldType;

use Pyro\Module\Streams\FieldType\FieldTypeAbstract;

/**
 * PyroStreams WYSIWYG Field Type
 *
 * @package        PyroCMS\Core\Modules\Streams Core\Field Types
 * @author         Parse19
 * @copyright      Copyright (c) 2011 - 2012, Parse19
 * @license        http://parse19.com/pyrostreams/docs/license
 * @link           http://parse19.com/pyrostreams
 */
class Wysiwyg extends FieldTypeAbstract
{
    public $field_type_slug = 'wysiwyg';

    public $db_col_type = 'long_text';

    public $admin_display = 'full';

    public $custom_parameters = array('editor_type', 'allow_tags');

    public $version = '1.1.0';

    public $author = array('name' => 'Parse19', 'url' => 'http://parse19.com');

    /**
     * Event
     *
     * Called before the form is built.
     *
     * @return    void
     */
    public function event()
    {
        if (defined('ADMIN_THEME')) {
            $this->appendMetadata($this->view('wysiwyg_admin'));
        } else {
            $this->appendMetadata($this->view('wysiwyg_entry_form'));
        }
    }

    /**
     * Pre-Ouput WYSUWYG content
     *
     * @param    string
     *
     * @return    string
     */
    public function stringOutput()
    {
        // Legacy. This was a temp fix for a few things
        // that I'm sure a few sites are utilizing.
        $input = str_replace('&#123;&#123; url:site &#125;&#125;', site_url() . '/', $this->value);

        $parse_tags = $this->getParameter('allow_tags', 'n');

        // If this isn't the admin and we want to allow tags,
        // let it through. Otherwise we will escape them.
        if (!defined('ADMIN_THEME') and $parse_tags == 'y') {
            return ci()->parser->parse_string($this->value, array(), true);
        } else {
            ci()->load->helper('text');

            return escape_tags($this->value);
        }

    }

    /**
     * Output form input
     *
     * @param    array
     * @param    array
     *
     * @return    string
     */
    public function formInput()
    {
        // Set editor type
        if ($editor_type = $this->getParameter('editor_type')) {
            $options['class'] = 'wysiwyg-' . $editor_type;
        } else {
            $options['class'] = 'wysiwyg-simple';
        }

        $options['name']  = $this->getFormSlug();
        $options['id']    = $this->getFormSlug();
        $options['value'] = $this->value;

        return form_textarea($options);
    }

    /**
     * Editor Type Param
     *
     * Choose the type of editor.
     */
    public function paramEditorType($value = null)
    {
        $types = array(
            'simple'   => lang('streams:wysiwyg.simple'),
            'advanced' => lang('streams:wysiwyg.advanced')
        );

        return form_dropdown('editor_type', $types, $value);
    }

    /**
     * Default Textarea Value
     *
     * @param    [string - value]
     *
     * @return    string
     */
    public function paramDefaultValue($value = null)
    {
        return form_textarea(
            array(
                'name'  => 'default_value',
                'id'    => 'default_value',
                'value' => $value,
            )
        );
    }

}
