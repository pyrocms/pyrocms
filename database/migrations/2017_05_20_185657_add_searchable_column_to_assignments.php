<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class AddSearchableColumnToAssignments
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AddSearchableColumnToAssignments extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema()->table(
            'streams_assignments',
            function (Blueprint $table) {
                $table->boolean('searchable')->default(0)->after('required');
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
        $this->schema()->table(
            'streams_assignments',
            function (Blueprint $table) {
                $table->dropColumn('searchable');
            }
        );
    }
}
