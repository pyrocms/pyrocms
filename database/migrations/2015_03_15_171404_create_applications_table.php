<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateApplicationsTable
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class CreateApplicationsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('core')->hasTable('applications')) {
            Schema::connection('core')->create(
                'applications',
                function (Blueprint $table) {

                    $table->increments('id');
                    $table->string('name');
                    $table->string('reference');
                    $table->string('domain');
                    $table->boolean('enabled');

                    $table->unique('reference', 'unique_application_references');
                    $table->unique('domain', 'unique_application_domains');
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
        Schema::connection('core')->dropIfExists('applications');
    }
}
