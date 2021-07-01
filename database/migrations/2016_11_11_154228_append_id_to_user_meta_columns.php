<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class AppendIdToUserMetaColumns
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AppendIdToUserMetaColumns extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* @var StreamInterface $stream */
        foreach ($this->streams()->all() as $stream) {

            if ($this->schema()->hasColumn($stream->getEntryTableName(), 'created_by')) {

                $this->schema()->table(
                    $stream->getEntryTableName(),
                    function (Blueprint $table) {
                        $table->renameColumn('created_by', 'created_by_id');
                        $table->renameColumn('updated_by', 'updated_by_id');
                    }
                );

                if ($stream->isTranslatable()) {

                    $this->schema()->table(
                        $stream->getEntryTranslationsTableName(),
                        function (Blueprint $table) {
                            $table->renameColumn('created_by', 'created_by_id');
                            $table->renameColumn('updated_by', 'updated_by_id');
                        }
                    );
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /* @var StreamInterface $stream */
        foreach ($this->streams()->all() as $stream) {

            if ($this->schema()->hasColumn($stream->getEntryTableName(), 'created_by_id')) {

                $this->schema()->table(
                    $stream->getEntryTableName(),
                    function (Blueprint $table) {
                        $table->renameColumn('created_by_id', 'created_by');
                        $table->renameColumn('updated_by_id', 'updated_by');
                    }
                );

                if ($stream->isTranslatable()) {

                    $this->schema()->table(
                        $stream->getEntryTranslationsTableName(),
                        function (Blueprint $table) {
                            $table->renameColumn('created_by_id', 'created_by');
                            $table->renameColumn('updated_by_id', 'updated_by');
                        }
                    );
                }
            }
        }
    }
}
