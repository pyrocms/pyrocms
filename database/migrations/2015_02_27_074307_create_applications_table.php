<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateApplicationsTable
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
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
