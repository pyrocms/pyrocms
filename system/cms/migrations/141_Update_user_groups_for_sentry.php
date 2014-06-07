<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_user_groups_for_sentry extends CI_Migration
{
    public function up()
    {
        $schema = ci()->pdb->getSchemaBuilder();

        // You were lucky, you have new sentry table (alpha user?)
        if (!$schema->hasColumn('groups', 'permissions')) {

            $schema->table(
                'groups',
                function ($table) {
                    $table->text('permissions')->nullable();
                    $table->dateTime('created_at');
                    $table->dateTime('updated_at')->nullable();
                    $table->unique('name');
                }
            );

            ci()->pdb->table('groups')->where('name', '=', 'admin')->update(
                array(
                    'permissions' => json_encode(array('admin' => 1)),
                    'created_at'  => date('Y-m-d H:i:s')
                )
            );

            ci()->pdb->table('groups')->where('name', '=', 'user')->update(
                array(
                    'created_at' => date('Y-m-d H:i:s')
                )
            );
        }

        if (!$schema->hasTable('users_groups')) {
            // Make the new user table
            $schema->create(
                'users_groups',
                function ($table) {
                    $table->integer('user_id')->unsigned();
                    $table->integer('group_id')->unsigned();

                    // We'll need to ensure that MySQL uses the InnoDB engine to
                    // support the indexes, other engines aren't affected.
                    $table->engine = 'InnoDB';
                    $table->primary(array('user_id', 'group_id'));
                }
            );

            ci()->pdb->statement(
                '
                    INSERT INTO default_users_groups (user_id, group_id)
                    SELECT id, group_id FROM default_users
                '
            );
        }

        return true;
    }

    public function down()
    {
        return true;
    }
}