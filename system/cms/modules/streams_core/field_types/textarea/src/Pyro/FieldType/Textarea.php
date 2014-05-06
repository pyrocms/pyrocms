<?php namespace Pyro\FieldType;

use Pyro\Module\Streams\FieldType\FieldTypeAbstract;

/**
 * PyroStreams Textarea Field Type
 *
 * @package        PyroCMS\Core\Modules\Streams Core\Field Types
 * @author         Adam Fairholm
 * @copyright      Copyright (c) 2011 - 2012, Adam Fairholm
 */
class Textarea extends FieldTypeAbstract
{
    public $field_type_slug = 'textarea';

    public $db_col_type = 'text';

    public $admin_display = 'full';

    public $version = '1.1.0';

    public $author = array(
        'name' => 'Ryan Thompson - PyroCMS',
        'url'  => 'http://pyrocms.com/'
    );

    public $custom_parameters = array(
        'allow_tags',
        'content_type',
        'placeholder',
    );

    /**
     * Output form input
     *
     * @param    array
     * @param    array
     * @return    string
     */
    public function formInput()
    {
        $options = array(
            'name'        => $this->form_slug,
            'id'          => $this->form_slug,
            'value'       => addslashes($this->value),
            'class'       => 'form-control',
            'placeholder' => $this->getPlaceholder(),
        );

        if ($this->getParameter('content_type') == 'html') {
            $options['data-editor'] = 'html';
        }

        return form_textarea($options);
    }

    /**
     * Pre-Ouput content
     *
     * @return    string
     */
    public function stringOutput()
    {
        $parse_tags   = $this->getParameter('allow_tags', 'n');
        $content_type = $this->getParameter('content_type', 'html');

        // If this is the admin, show only the source
        // @TODO This is hacky, there will be times when the admin wants to see a preview or something
        if (defined('ADMIN_THEME')) {
            return $this->value;
        }

        // If this isn't the admin and we want to allow tags,
        // let it through. Otherwise we will escape them.
        if ($parse_tags == 'y') {
            $content = ci()->parser->parse_string($this->value, ci(), true, false, false);
        } else {
            ci()->load->helper('text');
            $content = escape_tags($this->value);
        }

        // Not that we know what content is there, what format should we treat is as?
        switch ($content_type) {
            case 'md':
                ci()->load->helper('markdown');
                return parse_markdown($content);

            case 'html':
                return $content;

            default:
                return strip_tags($content);
        }

    }

    /**
     * Content Type
     * Is this plain text, HTML or Markdown?
     */
    public function paramContentType($value = null)
    {
        $options = array(
            'text' => lang('global:plain-text'),
            'html' => 'HTML',
            'md'   => 'Markdown',
        );

        // Defaults to Plain Text
        $value or $value = 'text';

        return form_dropdown('content_type', $options, $value);
    }

    /**
     * Default Textarea Value
     *
     * @param    [string - value]
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
