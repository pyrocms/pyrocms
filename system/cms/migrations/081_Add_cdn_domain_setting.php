<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_cdn_domain_setting extends CI_Migration
{
    public function up()
    {
        $this->db->insert('settings', array(
            'title' => 'CDN Domain',
            'slug' => 'cdn_domain',
            'description' => 'CDN domains allow you to offload static content to various edge servers, like Amazon CloudFront or MaxCDN.',
            'type' => 'text',
            'default' => '',
            'value' => '',
            'options' => '',
            'is_required' => false,
            'is_gui' => true,
            'module' => 'integration',
            'order' => 1000,
        ));
        
    }

    public function down()
    {
        $this->db->where('slug','cdn_domain')->delete('settings');
    }
}