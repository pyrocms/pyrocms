<?php namespace Pyro\Module\Streams\FieldType;

use Pyro\Module\Streams\StreamModel;

class FieldTypeParameter
{
    /**
     * Parameter construct
     */
    public function __construct()
    {
        ci()->load->helper('form');
    }

    /**
     * Choose a stream to relate to.. or remote source
     *
     * @param  mixed $value
     *
     * @return string
     */
    public function stream($value = null)
    {
        $options = StreamModel::getStreamAssociativeOptions();

        return form_dropdown('stream', $options, $value);
    }

    /**
     * Maxlength field
     *
     * @param    string
     *
     * @return    string
     */
    public function max_length($value = null)
    {
        $data = array(
            'name'      => 'max_length',
            'id'        => 'max_length',
            'value'     => $value,
            'maxlength' => '100'
        );

        return form_input($data);
    }

    /**
     * Upload location field
     *
     * @param    string
     *
     * @return    string
     */
    public function upload_location($value = null)
    {
        $data = array(
            'name'      => 'upload_location',
            'id'        => 'upload_location',
            'value'     => $value,
            'maxlength' => '255'
        );

        return form_input($data);
    }

    /**
     * Allow tags parameter.
     *
     * Should tags go through or be converted to output?
     */
    public function allow_tags($value = null)
    {
        $options = array(
            'n' => lang('global:no'),
            'y' => lang('global:yes')
        );

        // Defaults to No
        $value or $value = 'n';

        return form_dropdown('allow_tags', $options, $value);
    }

    /**
     * Link URI field
     *
     * @param    string
     *
     * @return    string
     */
    public function link_uri($value = null)
    {
        $data = array(
            'name'      => 'link_uri',
            'id'        => 'link_uri',
            'value'     => $value,
            'maxlength' => '300'
        );

        return form_input($data);
    }

    /**
     * Default default field
     *
     * @param    string
     *
     * @return    string
     */
    public function default_value($value = null)
    {
        $data = array(
            'name'      => 'default_value',
            'id'        => 'default_value',
            'value'     => $value,
            'maxlength' => '255'
        );

        return form_input($data);
    }
}
