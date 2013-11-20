<?php defined('BASEPATH') or exit('No direct script access allowed');

use Pyro\Module\Addons\ThemeManager;
use Pyro\Module\Addons\ThemeModel;

class Migration_Add_type_column_to_themes extends CI_Migration
{
    public function up()
    {
        $schema = ci()->pdb->getSchemaBuilder();

        $this->themeManager = new ThemeManager;

        $this->themeManager->setLocations(array(
            APPPATH.'themes/',
            SHARED_ADDONPATH . 'themes/'
        ));

        $schema->table('themes', function($table) {
            $table->string('type')->nullable();
        });

        $models = ThemeModel::all();

        foreach ($models as $model) {
            if ($theme = $this->themeManager->locate($model->slug)) {
                $model->type = $theme->type;
                $model->save();                    
            }
        }

            return true;
    }

    public function down()
    {
        return true;
    }
}