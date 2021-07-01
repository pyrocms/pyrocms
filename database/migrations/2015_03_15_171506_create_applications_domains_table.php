<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateApplicationsDomainsTable
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class CreateApplicationsDomainsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('core')->hasTable('applications_domains')) {
            Schema::connection('core')->create(
                'applications_domains',
                function (Blueprint $table) {

                    $table->increments('id');
                    $table->integer('application_id');
                    $table->string('domain');
                    $table->string('locale');

                    $table->unique('domain', 'unique_application_aliases');
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
        Schema::connection('core')->dropIfExists('applications_domains');
    }
}
