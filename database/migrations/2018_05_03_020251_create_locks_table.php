<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateLocksTable
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class CreateLocksTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'streams_locks',
            function (Blueprint $table) {
                $table->increments('id');
                $table->datetime('locked_at');
                $table->integer('locked_by_id');
                $table->integer('lockable_id')->unsigned();
                $table->string('lockable_type');
                $table->string('session_id');
                $table->string('url');

                $table->index('lockable_id');
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
        Schema::drop('streams_locks');
    }
}
