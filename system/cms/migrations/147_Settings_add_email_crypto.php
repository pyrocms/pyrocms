<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Settings_add_email_crypto extends CI_Migration
{
  public function up()
    {
        $this->db->insert('settings', array(
                'slug' => 'mail_smtp_crypto',
                'title' => 'SMTP Encryption',
                'description' => 'SMTP Encryption used for sending emails.',
                'type' => 'select',
                '`default`' => '',
                'value' => '',
                '`options`' => '=None|ssl=SSL|tls=TLS',
                'is_required' => false,
                'is_gui' => true,
                'module' => 'email',
                'order' => 920,
        ));
    }
    
    public function down()
    {
        $this->db->where('slug', 'mail_smtp_crypto')
            ->delete('settings');
    }
}
