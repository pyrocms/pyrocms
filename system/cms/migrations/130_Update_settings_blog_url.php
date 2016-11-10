<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_settings_blog_url extends CI_Migration {

    public function up() {
        $setting = array(
            'slug' => 'blog_uses_dates',
            'title' => 'Use dates in the Blog URL?',
            'description' => 'Would you like to use the date in the URL for a blog post? Ex: blog/2014/05/slug or would you preffer to leave it like blog/slug',
            'type' => 'select',
            '`default`' => true,
            'value' => '1',
            'options' => '0=Disabled|1=Enabled',
            'is_required' => false,
            'is_gui' => true,
            'module' => 'blog',
            'order' => 1000,
        );
        if (!$this->db->insert('settings', $setting)) {
            log_message('debug', '-- -- could not install ' . $setting['slug']);
            return false;
        }
    }

    public function down() {
        $this->db->where('slug', 'blog_uses_dates')->delete('settings');
    }

}
