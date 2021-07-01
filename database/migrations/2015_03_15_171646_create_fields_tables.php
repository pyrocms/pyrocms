<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

/**
 * Class CreateFieldsTables
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class CreateFieldsTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* @var Builder $schema */
        $schema = app('db')->connection()->getSchemaBuilder();

        if (!$schema->hasTable('streams_fields')) {
            $schema->create(
                'streams_fields',
                function (Blueprint $table) {
                    $table->increments('id');
                    $table->string('namespace', 150);
                    $table->string('slug', 150);
                    $table->string('type');
                    $table->text('config');
                    $table->boolean('locked')->default(0);

                    $table->unique(['namespace', 'slug'], 'unique_fields');
                }
            );
        }

        if (!$schema->hasTable('streams_fields_translations')) {
            $schema->create(
                'streams_fields_translations',
                function (Blueprint $table) {
                    $table->increments('id');
                    $table->integer('field_id');
                    $table->string('locale')->index();
                    $table->string('name')->nullable();
                    $table->string('placeholder')->nullable();
                    $table->string('warning')->nullable();
                    $table->text('instructions')->nullable();
                }
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /* @var Builder $schema */
        $schema = app('db')->connection()->getSchemaBuilder();

        $schema->dropIfExists('streams_fields');
        $schema->dropIfExists('streams_fields_translations');
    }
}
