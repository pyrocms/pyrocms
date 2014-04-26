<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Get rid of old settings
 */
class Migration_Remove_require_last_name_and_twitter extends CI_Migration {

    public function up()
    {
        $this->db->where('slug', 'require_lastname')
            ->or_where('slug', 'twitter_cache')
            ->or_where('slug', 'twitter_feed_count')
            ->or_where('slug', 'twitter_username')
            ->delete('settings');
    }

    public function down()
    {
		
    }
}