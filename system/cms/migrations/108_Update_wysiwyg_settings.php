<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_wysiwyg_settings extends CI_Migration
{
    public function up()
    {
        $settings = $this->db->select('slug, value')
            ->where('slug', 'ckeditor_config')
            ->get('settings')
            ->result();

        foreach ($settings as $setting)
        {
            // if they have their own protectedSource settings for CKEditor don't overwrite them
            if (strpos($setting->value, 'protectedSource') === false)
            {
                $setting->value = str_replace("{{ global:current_language }}'", "{{ global:current_language }}',\n\tprotectedSource: /{{(\s)?.[^}]+(\s)?}}/g\n", $setting->value);
        
                $this->db->where('slug', $setting->slug)
                    ->update('settings', array('value' => $setting->value));
            }
        }
    }

    public function down()
    {
        $this->dbforge->modify_column('theme_options', array(
            'options' => array('type' => 'VARCHAR', 'constraint' => 255),
        ));
    }
}