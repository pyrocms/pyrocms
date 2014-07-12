<?php

use Composer\Autoload\ClassLoader;
use Pyro\Module\Pages\Model\Page;
use Pyro\Module\Streams\Field\FieldAssignmentModel;
use Pyro\Module\Streams\Field\FieldModel;
use Pyro\Module\Streams\FieldType\FieldTypeManager;
use Pyro\Module\Streams\Stream\StreamModel;

class Migration_Polymorphic_keywords extends CI_Migration
{
    public function up()
    {
        FieldTypeManager::registerFolderFieldTypes(realpath(APPPATH) . '/modules/streams_core/field_types/', true);

        $schema = $this->pdb->getSchemaBuilder();

        $loader = new ClassLoader();

        // Register module manager for usage everywhere, its handy
        $loader->add('Pyro\\Module\\Pages', realpath(APPPATH) . '/modules/pages/src/');
        $loader->add('Pyro\\Module\\Keywords', realpath(APPPATH) . '/modules/keywords/src/');

        $loader->register();

        // Add the new columns needed for the polymorphic relation
        $schema->table(
            'keywords_applied',
            function ($table) use ($schema) {
                if (!$schema->hasColumn('keywords_applied', 'entry_id')) {
                    $table->integer('entry_id');
                }
                if (!$schema->hasColumn('keywords_applied', 'entry_type')) {
                    $table->string('entry_type', 150);
                }
            }
        );

        $pageModel = new Page;

        $pages = $pageModel->all();

        foreach ($pages as $page) {
            $this->pdb->table('keywords_applied')->where('hash', $page->entry->meta_keywords)->update(
                array(
                    'entry_id'   => $page->entry->getKey(),
                    'entry_type' => get_class($page->entry)
                )
            );
        }

        // Get the field keys that are of type keywords
        $fieldsKeys = FieldModel::where('field_type', 'keywords')->get()->modelKeys();

        // Get all assignments of this type
        $assignments = FieldAssignmentModel::whereIn('field_id', $fieldsKeys)->get();

        foreach ($assignments as $assignment) {

            // Get the entry model class
            $entryModelClass = StreamModel::getEntryModelClass(
                $assignment->stream->stream_slug,
                $assignment->stream->stream_namespace
            );

            $entryModel = new $entryModelClass;

            $keywordsFieldSlug = $assignment->field->field_slug;

            $entries = $entryModel->whereNotNull($keywordsFieldSlug)->get();

            // Update the applied keywords as a polymorphic relation
            foreach ($entries as $entry) {

                // We must use the extended version of the model if there is one
                if ($entryModelClass == 'Pyro\Module\Streams\Model\BlogsBlogEntryModel') {
                    $entryModelClass = 'Pyro\Module\Blog\BlogEntryModel';
                }

                $this->pdb->table('keywords_applied')->where('hash', $entry->{$keywordsFieldSlug})->update(
                    array(
                        'entry_id'   => $entry->getKey(),
                        'entry_type' => $entryModelClass
                    )
                );
            }

            // Drop columns biatch!
            $schema->table(
                'keywords_applied',
                function ($table) use ($schema) {
                    if ($schema->hasColumn('keywords_applied', 'id')) {
                        $table->dropColumn('id');
                    }
                    if ($schema->hasColumn('keywords_applied', 'hash')) {
                        $table->dropColumn('hash');
                    }
                }
            );

            $schema->table($entryModel->getTable(), function($table) use ($schema, $keywordsFieldSlug){
                    if ($schema->hasColumn($table->getTable(), $keywordsFieldSlug)) {
                        $table->dropColumn($keywordsFieldSlug);
                    }
                });

            // Recompile the entry model by saving the stream
            $assignment->stream->save();
        }
    }

    public function down()
    {
        return true;
    }
}