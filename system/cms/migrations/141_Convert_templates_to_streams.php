<?php

use Pyro\Module\Streams\Stream\StreamModel;
use Pyro\Module\Streams\Field\FieldModel;
use Pyro\Module\Streams\FieldType\FieldTypeManager;
use Pyro\Module\Streams\Stream\StreamSchema;

class Migration_Convert_templates_to_streams extends CI_Migration
{
    public function up()
    {
        if (!$stream = StreamModel::findBySlugAndNamespace('templates', 'templates')) {
            FieldTypeManager::registerFolderFieldTypes(realpath(APPPATH) . '/modules/streams_core/field_types/', true);

            $schema = $this->pdb->getSchemaBuilder();

            $prefixedTable = ci()->pdb->getQueryGrammar()->getTablePrefix() . 'email_templates';

            // Convert Templates to a stream
            StreamSchema::convertTableToStream(
                $streamSlug = 'templates',
                $namespace = 'templates',
                $streamPrefix = 'email_',
                $streamName = 'lang:templates.stream.templates.name',
                $about = null,
                $titleColumn = 'name',
                $viewOptions = array('name')
            );

            // Convert name column to text
            StreamSchema::convertColumnToField(
                $streamSlug = 'templates',
                $namespace = 'templates',
                $fieldName = 'lang:name_label',
                $fieldSlug = 'name',
                $fieldType = 'text',
                $extra = array(
                    'is_locked' => true
                ),
                $assignData = array(
                    'is_required' => true
                )
            );

            // Convert slug column to slug
            StreamSchema::convertColumnToField(
                $streamSlug = 'templates',
                $namespace = 'templates',
                $fieldName = 'lang:global:slug',
                $fieldSlug = 'slug',
                $fieldType = 'slug',
                $extra = array(
                    'is_locked'  => true,
                    'slug_field' => 'name'
                ),
                $assignData = array(
                    'is_required' => true
                )
            );

            // Convert description column to text
            StreamSchema::convertColumnToField(
                $streamSlug = 'templates',
                $namespace = 'templates',
                $fieldName = 'lang:desc_label',
                $fieldSlug = 'description',
                $fieldType = 'text',
                $extra = array(
                    'is_locked' => true
                ),
                $assignData = array(
                    'is_required' => true
                )
            );

            // Convert subject column to text
            StreamSchema::convertColumnToField(
                $streamSlug = 'templates',
                $namespace = 'templates',
                $fieldName = 'lang:templates:subject_label',
                $fieldSlug = 'subject',
                $fieldType = 'text',
                $extra = array(
                    'is_locked' => true
                ),
                $assignData = array(
                    'is_required' => true
                )
            );

            // Convert body column to wysiwyg
            StreamSchema::convertColumnToField(
                $streamSlug = 'templates',
                $namespace = 'templates',
                $fieldName = 'lang:templates:body_label',
                $fieldSlug = 'body',
                $fieldType = 'wysiwyg',
                $extra = array(
                    'is_locked'   => true,
                    'editor_type' => 'advanced',
                    'allow_tags'  => 'y'
                ),
                $assignData = array(
                    'is_required' => true
                )
            );

            // Convert lang column to pyro_lang
            StreamSchema::convertColumnToField(
                $streamSlug = 'templates',
                $namespace = 'templates',
                $fieldName = 'templates:language_label',
                $fieldSlug = 'lang',
                $fieldType = 'pyro_lang',
                $extra = array(
                    'is_locked' => true
                ),
                $assignData = array(
                    'is_required' => true
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