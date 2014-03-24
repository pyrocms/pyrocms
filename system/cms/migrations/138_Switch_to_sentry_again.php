<?php defined('BASEPATH') or exit('No direct script access allowed');

/*
    This migration should have run back in 127, but in some instances seems to not have run.
    So, if the password_old field is not there, this all needs to run again.
*/

class Migration_Switch_to_sentry_again extends CI_Migration
{
    public function up()
    {
        $schema = $this->pdb->getSchemaBuilder();

        // You were lucky, it has run before
        if ($schema->hasColumn('users', 'password_old')) {
            return true;
        }

        // Add the new fields for Sentry
        $schema->table('users', function($table) {
            $table->boolean('is_activated')->default(false);
            $table->string('persist_code')->nullable();
            $table->string('reset_password_code', 40)->nullable();
            $table->text('permissions')->nullable();
            $table->string('password_old', 40);
        });

        $prefix = $this->pdb->getQueryGrammar()->getTablePrefix();

        $this->pdb->update('UPDATE '.$prefix.'users SET 
            is_activated = active, 
            reset_password_code = forgotten_password_code, 
            password_old = password 
        ');
        
        // Grab all the users for later
        $users = $this->pdb->table('users')->select('id', 'password')->get();

        // Drop old fields no longer required
        $schema->table('users', function($table) {
            $table->dropColumn('password');
            $table->dropColumn('active');
            $table->dropColumn('forgotten_password_code');
            $table->dropColumn('remember_code');
        });

        $schema->table('users', function($table) {
            $table->string('password', 255);
        });

        $hasher = new Cartalyst\Sentry\Hashing\NativeHasher;

        foreach ($users as $user) {
            $this->pdb
                ->table('users')
                ->where('id', $user->id)
                ->update(array(
                    'password' => $hasher->hash($user->password)
                ));
        }

    }

    public function down()
    {
        return true;
    }
}