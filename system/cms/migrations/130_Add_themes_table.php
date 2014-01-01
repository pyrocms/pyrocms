<?php

class Migration_Add_themes_table extends CI_Migration
{
    public function up()
    {
        $schema = $this->pdb->getSchemaBuilder();

        if ( ! $schema->hasTable('themes')) {
            $schema->create('themes', function($table) {
                $table->increments('id');
                $table->integer('site_id')->nullable();
                $table->string('slug');
                $table->string('name');
                $table->text('description');
                $table->string('author')->nullable();
                $table->string('author_website')->nullable();
                $table->string('website')->nullable();
                $table->string('version')->default('1.0.0');
                $table->boolean('enabled')->default(true);
                $table->integer('order')->default(0);
                $table->integer('created_on');
                $table->integer('updated_on')->nullable();
            });
        }

        $schema->table('theme_options', function($table) {
            $table->integer('theme_id')->nullable();
        });

        $prefix = $this->pdb->getQueryGrammar()->getTablePrefix();

        $theme_order = 0;
        foreach ($this->template->theme_locations() as $location) {
            if ( ! $themes = glob($location.'*', GLOB_ONLYDIR)) {
                continue;
            }

            foreach ($themes as $path) {

                if (( ! is_file($path.'/theme.php'))) {
                    continue;
                }

                $slug = basename($path);
                $is_core = strpos($path, APPPATH) !== false;
                $is_shared = strpos($path, SHARED_ADDONPATH) !== false;

                include "{$path}/theme.php";

                // Now call the details class
                $class = 'Theme_'.ucfirst(strtolower($slug));

                // Now we need to talk to it
                if ( ! class_exists($class)) {
                    continue;
                }

                $theme = new $class;

                $theme_id = $this->pdb
                    ->table('themes')
                    ->insertGetId(array(
                        'slug'           => $slug,
                        'name'           => $theme->name,
                        'description'    => $theme->description,
                        'author'         => $theme->author,
                        'author_website' => $theme->author_website,
                        'website'        => $theme->website,
                        'version'        => $theme->version,
                        'enabled'        => 1,
                        'order'          => ++$theme_order,
                        'created_on'     => time(),
                    ));

                if ($is_core === false and $is_shared === false) {
                    $this->pdb->statement("
                        UPDATE {$prefix}themes t 
                        JOIN core_sites s ON s.ref = '".SITE_REF."'
                        SET t.site_id = s.id 
                    ");
                }

                
            }
        }

        $this->pdb->statement("
            UPDATE {$prefix}theme_options `to` 
            JOIN {$prefix}themes t 
                ON CONVERT(`to`.theme USING utf8) = CONVERT(`to`.theme USING utf8)
            SET `to`.theme_id = t.id 
        ");

        $schema->table('theme_options', function($table) {
            $table->dropColumn('theme')->nullable();
        });

        return true;
    }

    public function down()
    {
        $schema = $this->pdb->getSchemaBuilder();

        $schema->drop('themes');

        return true;
    }
}