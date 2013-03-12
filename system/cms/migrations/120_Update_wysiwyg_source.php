<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_wysiwyg_source extends CI_Migration
{
    public function up()
    {
        $setting = $this->db->select('slug, value')
            ->where('slug', 'ckeditor_config')
            ->get('settings')
            ->row();

        if ($setting)
        {
            $setting->value = preg_replace('@,\r\s+protectedSource:(.*?)'.preg_quote('/{{(\s)?.[^}]+(\s)?}}/g', '/').'@ms', '', $setting->value);

            $setting->value = str_replace('textarea.blog.wysiwyg-simple', 'textarea#intro.wysiwyg-simple', $setting->value);
    
            $this->db->where('slug', $setting->slug)
                ->update('settings', array('value' => $setting->value));
        }
    }

    public function down()
    {
        return true;
    }
}