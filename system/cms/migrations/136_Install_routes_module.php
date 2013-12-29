<?php defined('BASEPATH') or exit('No direct script access allowed');

use Pyro\Module\Addons\AbstractModule;
use Pyro\Module\Streams_core\StreamModel;
use Pyro\Module\Streams_core\FieldModel;
use Pyro\Module\Streams_core\SchemaUtility;

class Migration_Install_routes_module extends CI_Migration
{
    public function up()
    {
        /**
         * Add Routes Stream
         */
        StreamModel::addStream(
            $slug = 'routes',
            $namespace = 'routes',
            $name = 'Routes',
            $prefix = '',
            $about = NULL,
            $extra = array('title_column' => 'name')
        );

        
        /**
         * Build the fields
         */
        $fields = array(
            array(
                'name'          => 'lang:routes:module',
                'slug'          => 'module',
                'namespace'     => 'routes',
                'locked'        => true,
                'type'          => 'text',
            ),
            array(
                'name'          => 'lang:routes:name',
                'slug'          => 'name',
                'namespace'     => 'routes',
                'locked'        => true,
                'type'          => 'text',
            ),
            array(
                'name'          => 'lang:routes:route_key',
                'slug'          => 'route_key',
                'namespace'     => 'routes',
                'locked'        => true,
                'type'          => 'text',
            ),
            array(
                'name'          => 'lang:routes:route_value',
                'slug'          => 'route_value',
                'namespace'     => 'routes',
                'locked'        => true,
                'type'          => 'text',
            ),
        );

        // Add all the fields
        FieldModel::addFields($fields, null, 'routes');


        /**
         * Assignments
         */
        FieldModel::assignField('routes', 'routes', 'module', array('instructions' => 'lang:routes:instructions.module'));
        FieldModel::assignField('routes', 'routes', 'name', array('is_unique' => true, 'instructions' => 'lang:routes:instructions.name'));
        FieldModel::assignField('routes', 'routes', 'route_key', array('is_required' => true, 'instructions' => 'lang:routes:instructions.route_key'));
        FieldModel::assignField('routes', 'routes', 'route_value', array('is_required' => true, 'instructions' => 'lang:routes:instructions.route_value'));

        // Good to go
        return true;
    }

    public function down()
    {
        return true;
    }
}