<?php

use Anomaly\Streams\Platform\Application\Application;
use Anomaly\Streams\Platform\Database\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

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
     * The streams application.
     *
     * @param Application
     */
    protected $application;

    /**
     * The streams application.
     *
     * @param Application $application
     */
    function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* @var Builder $schema */
        $schema = app('db')->connection()->getSchemaBuilder();

        $schema->getConnection()->getSchemaGrammar()->setTablePrefix(null);
        $schema->getConnection()->setTablePrefix(null);

        if ($schema->hasTable('applications')) {
            $schema->create(
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

        $schema->getConnection()->getSchemaGrammar()->setTablePrefix($this->application->getReference() . '_');
        $schema->getConnection()->setTablePrefix($this->application->getReference() . '_');
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

        $schema->getConnection()->getSchemaGrammar()->setTablePrefix(null);
        $schema->getConnection()->setTablePrefix(null);

        $schema->dropIfExists('applications');

        $schema->getConnection()->getSchemaGrammar()->setTablePrefix($this->application->getReference() . '_');
        $schema->getConnection()->setTablePrefix($this->application->getReference() . '_');
    }
}
