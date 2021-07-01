<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class AddSortOrderColumnToStreams
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AddSortOrderColumnToStreams extends Migration
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
                $table->integer('sort_order')
                    ->after('id')
                    ->nullable();
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
                $table->dropColumn('sort_order');
            }
        );
    }
}
