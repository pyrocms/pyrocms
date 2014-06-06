<?php

use Pyro\Module\Streams\Stream\StreamModel;
use Pyro\Module\Streams\Field\FieldModel;
use Pyro\Module\Streams\FieldType\FieldTypeManager;
use Pyro\Module\Streams\Stream\StreamSchema;

class Migration_Convert_redirects_to_streams extends CI_Migration
{
    public function up()
    {
        if (!$stream = StreamModel::findBySlugAndNamespace('redirects', 'redirects')) {

            FieldTypeManager::registerFolderFieldTypes(realpath(APPPATH) . '/modules/streams_core/field_types/', true);

            // Convert Redirects to a stream
            StreamSchema::convertTableToStream(
                $streamSlug = 'redirects',
                $namespace = 'redirects',
                $streamPrefix = null,
                $streamName = 'lang:redirects.stream.redirects.name',
                $about = null,
                $titleColumn = null,
                $viewOptions = array('from', 'to', 'type')
            );

            // Convert from column to url
            StreamSchema::convertColumnToField(
                $streamSlug = 'redirects',
                $namespace = 'redirects',
                $fieldName = 'lang:redirects:from',
                $fieldSlug = 'from',
                $fieldType = 'url',
                $extra = array(
                    'is_locked' => true,
                ),
                $assignData = array(
                    'is_required' => true,
                )
            );

            // Convert to column to url
            StreamSchema::convertColumnToField(
                $streamSlug = 'redirects',
                $namespace = 'redirects',
                $fieldName = 'lang:redirects:to',
                $fieldSlug = 'to',
                $fieldType = 'url',
                $extra = array(
                    'is_locked' => true,
                ),
                $assignData = array(
                    'is_required' => true,
                )
            );

            // Convert type column to choice
            StreamSchema::convertColumnToField(
                $streamSlug = 'redirects',
                $namespace = 'redirects',
                $fieldName = 'lang:redirects:type',
                $fieldSlug = 'type',
                $fieldType = 'choice',
                $extra = array(
                    'choice_type'   => 'dropdown',
                    'choice_data'   => '301 : lang:redirects:301' . "\n"
                        . '302 : lang:redirects:302',
                    'default_value' => '301',
                ),
                $assignData = array(
                    'is_required' => true,
                )
            );

            return true;
        }
        return false;
    }

    public function down()
    {
        return true;
    }
}