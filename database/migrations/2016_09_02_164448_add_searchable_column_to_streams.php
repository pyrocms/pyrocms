<?php

use Illuminate\Database\Schema\Blueprint;
use Anomaly\Streams\Platform\Database\Migration\Migration;

/**
 * Class AddSearchableColumnToStreams
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AddSearchableColumnToStreams extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema()->table(
            'streams_streams',
            function (Blueprint $table) {
                $table->boolean('searchable')->default(0)->after('sortable');
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
            'streams_streams',
            function (Blueprint $table) {
                $table->dropColumn('searchable');
            }
        );
    }
}
