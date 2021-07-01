<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateVersionsTable
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class CreateVersionsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'streams_versions',
            function (Blueprint $table) {
                $table->increments('version');
                $table->datetime('created_at');
                $table->integer('created_by_id')->nullable();
                $table->integer('versionable_id')->unsigned();
                $table->string('versionable_type');
                $table->string('ip_address');
                $table->longText('model');
                $table->longText('data');

                $table->index('versionable_id');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('streams_versions');
    }
}
