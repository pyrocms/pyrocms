<?php

use Pyro\Module\Streams\Stream\StreamModel;
use Pyro\Module\Streams\Field\FieldModel;
use Pyro\Module\Streams\FieldType\FieldTypeManager;
use Pyro\Module\Streams\Stream\StreamSchema;

class Migration_Convert_variables_to_streams extends CI_Migration
{
    public function up()
    {
        if (! $stream = StreamModel::findBySlugAndNamespace('variables', 'variables'))
        {
            FieldTypeManager::registerFolderFieldTypes(realpath(APPPATH).'/modules/streams_core/field_types/', true);

            $schema = $this->pdb->getSchemaBuilder();

            $prefixedTable = ci()->pdb->getQueryGrammar()->getTablePrefix().'variables';

            // Convert Variables to a stream
            StreamSchema::convertTableToStream('variables', 'variables', null, 'lang:variables:variables', null, 'name', array('name', 'data', 'syntax'));
            
            // Convert name column to Slug field
            StreamSchema::convertColumnToField('variables', 'variables', 'lang:variables:name_label', 'name', 'slug', array('max_length' => 100, 'space_type' => null, 'slug_field' => null, 'is_locked' => true), array('is_required' => true, 'is_unique' => true));
            
            // Convert data column to Field field - @todo - don't convert, add field, modify character limit and add data_field_slug
            StreamSchema::convertColumnToField('variables', 'variables', 'lang:variables:data_label', 'data', 'field', array('namespace' => 'variables', 'storage' => 'default', 'field_slug' => 'data', 'is_locked' => true), array(), false);

            $this->pdb->statement("ALTER TABLE `{$prefixedTable}` CHANGE COLUMN `name` `name` VARCHAR(100)");
            $this->pdb->statement("ALTER TABLE `{$prefixedTable}` CHANGE COLUMN `data` `data` TEXT");

            // Add the data_field_slug column that the Field field type needs to store the field slug
            $schema->table('variables', function($table) use ($schema, $prefixedTable) {
                if (! $schema->hasColumn('variables', 'data_field_slug')) {
                    $table->string('data_field_slug', 100)->default('text');    
                }
            });

            // Create the Variables folder. For the image field
            $folder_id = $this->pdb->table('file_folders')->insertGetId(array(
                'parent_id' => 0,
                'slug' => 'variables',
                'name' => 'lang:variables:variables',
                'location' => 'local',
                'remote_container' => '',
                'date_added' => time(),
                'sort' => time(),
                'hidden' => 1,
            ));
            
            $fields = array(
                // A default set of selectable fields
                array('namespace' => 'variables','name' => 'lang:streams:country.name','slug' => 'country','type' => 'country'),
                array('namespace' => 'variables','name' => 'lang:streams:datetime.name','slug' => 'datetime','type' => 'datetime', 'extra' => array('use_time' => 'no', 'storage' => 'datetime', 'input_type' => 'dropdown')),
                array('namespace' => 'variables','name' => 'lang:streams:email.name','slug' => 'email','type' => 'email'),
                array('namespace' => 'variables','name' => 'lang:streams:encrypt.name','slug' => 'encrypt','type' => 'encrypt', 'extra' => array('hide_typing' => 'yes')),
                array('namespace' => 'variables','name' => 'lang:streams:image.name','slug' => 'image','type' => 'image', 'extra' => array('folder' => $folder_id)),
                array('namespace' => 'variables','name' => 'lang:streams:integer.name','slug' => 'number','type' => 'integer'),
                array('namespace' => 'variables','name' => 'lang:streams:keywords.name','slug' => 'keywords','type' => 'keywords'),
                array('namespace' => 'variables','name' => 'lang:streams:pyro_lang.name','slug' => 'pyro_lang','type' => 'pyro_lang'),
                array('namespace' => 'variables','name' => 'lang:streams:state.name','slug' => 'state','type' => 'state'),
                array('namespace' => 'variables','name' => 'lang:streams:text.name','slug' => 'text','type' => 'text'),
                array('namespace' => 'variables','name' => 'lang:streams:textarea.name','slug' => 'textarea','type' => 'textarea', 'extra' => array('allow_tags' => 'yes', 'content_type' => 'md')),
                array('namespace' => 'variables','name' => 'lang:streams:url.name','slug' => 'url','type' => 'url'),
                array('namespace' => 'variables','name' => 'lang:streams:user.name','slug' => 'user','type' => 'user'),
                array('namespace' => 'variables','name' => 'lang:streams:wysiwyg.name','slug' => 'wysiwyg','type' => 'wysiwyg', 'extra' => array('editor_type' => 'advanced', 'allow_tags' => 'y')),
            );

            FieldModel::addFields($fields, null, 'variables');

            return true;
        }
        return false;
    }

    public function down()
    {
        return true;
    }
}