<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Increase_mime_length extends CI_Migration
{
    public function up()
    {
        $this->dbforge->modify_column('files', array(
            'mimetype' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => false),
        ));

        $this->db->insert('settings', array(
                'slug' => 'files_s3_geographic_location',
                'title' => 'Amazon S3 Geographic Location',
                'description' => 'Either US or EU. If you change this you must also change the S3 URL.',
                'type' => 'radio',
                'default' => 'US',
                'value' => 'US',
                'options' => 'US=United States|EU=Europe',
                'is_required' => 1,
                'is_gui' => 1,
                'module' => 'files',
                'order' => 991,
            )
        );

        $this->db->where('slug', 'files_s3_url')->update('settings', array(
            'description' => 'Change this if using one of Amazon\'s EU locations or a custom domain.'
            )
        );
    }

    public function down()
    {
        $this->dbforge->modify_column('files', array(
            'mimetype' => array('type' => 'VARCHAR', 'constraint' => 50, 'null' => false),
        ));

        $this->db->where('slug', 'files_s3_geographic_location')->delete('settings');
    }
}