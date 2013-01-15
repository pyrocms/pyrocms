<?php defined('BASEPATH') or exit('No direct script access allowed');


class Migration_Switch_to_sentry extends CI_Migration
{
    public function up()
    {
        $schema = $this->pdb->getSchemaBuilder();

        // Add the new fields for Sentry
        $schema->create('users', function($table) {
            $table->boolean('is_activated')->default(false);
            $table->text('permissions')->nullable();
        });

        $prefix = $this->pdb->getQueryGrammar()->getTablePrefix();

        $this->pdb->update('UPDATE '.$prefix.'users SET 
            is_activated = active, 
            activation_hash = activation_code, 
            reset_password_hash = forgotten_password_code, 
        ');

        // Drop old fields no longer required
        $schema->create('users', function($table) {
            $table->dropColumn('active');
            $table->dropColumn('activation_hash');
            $table->dropColumn('reset_password_hash');
            $table->dropColumn('remember_code');
        });

    }

    public function down()
    {
        return true;
    }
}