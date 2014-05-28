<?php

use Composer\Autoload\ClassLoader;
use Pyro\Module\Keywords\Model\Keyword;
use Pyro\Module\Pages\Model\Page;
use Pyro\Module\Streams\Field\FieldModel;
use Pyro\Module\Streams\FieldType\FieldTypeManager;
use Pyro\Module\Streams\Stream\StreamSchema;
use Pyro\Module\Users\Model\Group;

class Migration_Convert_page_columns_to_stream_fields extends CI_Migration
{
    public function up()
    {
        FieldTypeManager::registerFolderFieldTypes(realpath(APPPATH) . '/modules/streams_core/field_types/', true);

        $schema = $this->pdb->getSchemaBuilder();

        $loader = new ClassLoader;

        // Register module manager for usage everywhere, its handy
        $loader->add('Pyro\\Module\\Pages', realpath(APPPATH) . '/modules/pages/src/');
        $loader->add('Pyro\\Module\\Keywords', realpath(APPPATH) . '/modules/keywords/src/');

        $loader->register();

        $pages = Page::all();

        $converted = array();

        foreach ($pages as $page) {

            // Check for dirtiness
            if (!$page->entry) {
                continue;
            }

            $stream = $page->entry->getStream();

            $fields = array(
                array(
                    'name'         => 'lang:global:title',
                    'slug'         => 'title',
                    'type'         => 'text',
                    'title_column' => true,
                    'is_required'  => true,
                    'locked'       => true,
                    'extra'        => array(
                        'max_length' => 255
                    ),
                ),
                array(
                    'name'        => 'lang:global:slug',
                    'slug'        => 'slug',
                    'type'        => 'slug',
                    'is_required' => true,
                    'locked'      => true,
                    'extra'       => array(
                        'max_length'     => 255,
                        'namespace'      => $stream->stream_namespace,
                        'slug_field'     => 'title',
                        'form_input_row' => 'module::fields/slug'
                    ),
                ),
                array(
                    'name'  => 'lang:global:class',
                    'slug'  => 'class',
                    'type'  => 'text',
                    'extra' => array(
                        'max_length' => 255
                    ),
                ),
                array(
                    'name'   => 'lang:pages:css_label',
                    'slug'   => 'css',
                    'type'   => 'textarea',
                    'locked' => true,
                ),
                array(
                    'name'   => 'lang:pages:js_label',
                    'slug'   => 'js',
                    'type'   => 'textarea',
                    'locked' => true,
                ),
                array(
                    'name'   => 'lang:pages:meta_title_label',
                    'slug'   => 'meta_title',
                    'type'   => 'text',
                    'locked' => true,
                ),
                array(
                    'name'   => 'lang:pages:meta_keywords_label',
                    'slug'   => 'meta_keywords',
                    'type'   => 'keywords',
                    'locked' => true,
                ),
                array(
                    'name'   => 'lang:pages:meta_desc_label',
                    'slug'   => 'meta_description',
                    'type'   => 'textarea',
                    'locked' => true,
                ),
                array(
                    'name'   => 'lang:pages:meta_robots_no_index_label',
                    'slug'   => 'meta_robots_no_index',
                    'type'   => 'choice',
                    'locked' => true,
                    'extra'  => array(
                        'choice_data' => '1 :  ',
                        'choice_type' => 'checkboxes'
                    ),
                ),
                array(
                    'name'   => 'lang:pages:meta_robots_no_follow_label',
                    'slug'   => 'meta_robots_no_follow',
                    'type'   => 'choice',
                    'locked' => true,
                    'extra'  => array(
                        'choice_data' => '1 :  ',
                        'choice_type' => 'checkboxes'
                    ),
                ),
                array(
                    'name'   => 'lang:pages:rss_enabled_label',
                    'slug'   => 'rss_enabled',
                    'type'   => 'choice',
                    'locked' => true,
                    'extra'  => array(
                        'choice_data' => '1 :  ',
                        'choice_type' => 'checkboxes'
                    ),
                ),
                array(
                    'name'    => 'lang:pages:comments_enabled_label',
                    'slug'    => 'comments_enabled',
                    'type'    => 'choice',
                    'default' => 0,
                    'locked'  => true,
                    'extra'   => array(
                        'choice_data' => '1 :  ',
                        'choice_type' => 'checkboxes'
                    ),
                ),
                array(
                    'name'    => 'lang:pages:status_label',
                    'slug'    => 'status',
                    'type'    => 'choice',
                    'locked'  => true,
                    'default' => 'draft',
                    'extra'   => array(
                        'choice_data' => "draft : lang:pages:draft_label\n
                                        live : lang:pages:live_label\n"
                    ),
                ),
                array(
                    'name'    => 'lang:pages:is_home_label',
                    'slug'    => 'is_home',
                    'type'    => 'choice',
                    'default' => 0,
                    'locked'  => true,
                    'extra'   => array(
                        'choice_data' => '1 :  ',
                        'choice_type' => 'checkboxes'
                    ),
                ),
                array(
                    'name'    => 'lang:pages:strict_uri_label',
                    'slug'    => 'strict_uri',
                    'type'    => 'choice',
                    'default' => 1,
                    'locked'  => true,
                    'extra'   => array(
                        'choice_data' => '1 :  ',
                        'choice_type' => 'checkboxes'
                    ),
                ),
                array(
                    'name'   => 'lang:pages:access_label',
                    'slug'   => 'restricted_to',
                    'type'   => 'multiple',
                    'locked' => true,
                    'extra'  => array(
                        'relation_class' => 'Pyro\Module\Pages\FieldType\GroupModel'
                    ),
                ),
            );

            $streamString = $stream->stream_slug . '.' . $stream->stream_namespace;

            if (!in_array($streamString, $converted)) {
                $converted[$streamString] = $streamString;
                FieldModel::addFields($fields, $stream->stream_slug, $stream->stream_namespace);
            }

            FieldModel::assignField($stream->stream_slug, 'pages', 'title', array('is_required' => true));
            FieldModel::assignField($stream->stream_slug, 'pages', 'slug', array('is_required' => true));
            FieldModel::assignField($stream->stream_slug, 'pages', 'class', array());
            FieldModel::assignField($stream->stream_slug, 'pages', 'css', array());
            FieldModel::assignField($stream->stream_slug, 'pages', 'js', array());
            FieldModel::assignField($stream->stream_slug, 'pages', 'meta_title', array());
            FieldModel::assignField($stream->stream_slug, 'pages', 'meta_keywords', array());
            FieldModel::assignField($stream->stream_slug, 'pages', 'meta_description', array());
            FieldModel::assignField($stream->stream_slug, 'pages', 'meta_robots_no_index', array());
            FieldModel::assignField($stream->stream_slug, 'pages', 'meta_robots_no_follow', array());
            FieldModel::assignField($stream->stream_slug, 'pages', 'rss_enabled', array());
            FieldModel::assignField($stream->stream_slug, 'pages', 'rss_enabled', array());
            FieldModel::assignField($stream->stream_slug, 'pages', 'comments_enabled', array());
            FieldModel::assignField($stream->stream_slug, 'pages', 'status', array());
            FieldModel::assignField($stream->stream_slug, 'pages', 'is_home', array());
            FieldModel::assignField($stream->stream_slug, 'pages', 'strict_uri', array());

            $page->entry->title      = $page->title;
            $page->entry->slug       = $page->slug;
            $page->entry->class      = $page->class;
            $page->entry->css        = $page->css;
            $page->entry->js         = $page->js;
            $page->entry->meta_title = $page->meta_title;

            Keyword::sync($page->meta_keywords, $page->entry, 'metaKeywords');

            $page->entry->meta_description      = $page->meta_description;
            $page->entry->meta_robots_no_index  = $page->meta_robots_no_index;
            $page->entry->meta_robots_no_follow = $page->meta_robots_no_follow;
            $page->entry->rss_enabled           = $page->rss_enabled;
            $page->entry->comments_enabled      = $page->comments_enabled;
            $page->entry->status                = $page->status;
            $page->entry->is_home               = $page->is_home;
            $page->entry->strict_uri            = $page->strict_uri;

            if ($page->restricted_to) {
                // @todo - broken here..
                //$page->entry->restrictedTo()->attach($page->restricted_to);
            }

            $page->entry->skip_validation = true;

            $page->entry->save();
        }

        foreach ($fields as $field) {
            // Add the new columns needed for the polymorphic relation
            $schema->table(
                'pages',
                function ($table) use ($schema, $field) {
                    $skips = array('is_home');
                    if ($schema->hasColumn('pages', $field['slug']) and !in_array($field['slug'], $skips)) {
                        $table->dropColumn($field['slug']);
                    }
                }
            );
        }

        // Convert pages to a stream
        StreamSchema::convertTableToStream('pages', 'pages', null, 'lang:pages:pages');
    }

    public function down()
    {
        return true;
    }
}