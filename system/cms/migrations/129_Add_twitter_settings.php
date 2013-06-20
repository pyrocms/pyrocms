<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Migration 129: Add twitter 1.1 settings
 *
 * This will allow site owners to add the new twitter settings
 * required to use the 1.1 api.
 * 
 * Added June 19th, 2013
 */
class Migration_Add_twitter_settings extends CI_Migration
{
  	public function up()
	{
        $this->db->where_in('slug', array(
            'twitter_username',
            'twitter_feed_count',
            'twitter_cache'
        ))->delete('settings');

        $this->db->insert('settings', array(
            'slug'        => 'twitter_username',
            'title'       => 'Twitter username.',
            'description' => '',
            'default'     => '',
            'value'       => '',
            'type'        => 'text',
            'options'     => '',
            'is_required' => 0,
            'is_gui'      => 1,
            'module'      => 'twitter'
        ));

        $this->db->insert('settings', array(
            'slug'        => 'twitter_feed_count',
            'title'       => 'Feed Count',
            'description' => 'How many tweets should be returned to the Twitter feed block?',
            'default'     => '5',
            'value'       => '5',
            'type'        => 'text',
            'options'     => '',
            'is_required' => 0,
            'is_gui'      => 1,
            'module'      => 'twitter'
        ));

        $this->db->insert('settings', array(
            'slug'        => 'twitter_cache',
            'title'       => 'Cache time',
            'description' => 'How many seconds should your Tweets be stored?',
            'default'     => '300',
            'value'       => '300',
            'type'        => 'text',
            'options'     => '',
            'is_required' => 0,
            'is_gui'      => 1,
            'module'      => 'twitter'
        ));

        $this->db->insert('settings', array(
            'slug'        => 'twitter_oauth_access_token',
            'title'       => 'OAuth Access Token',
            'description' => '',
            'default'     => '',
            'value'       => '',
            'type'        => 'text',
            'options'     => '',
            'is_required' => 0,
            'is_gui'      => 1,
            'module'      => 'twitter'
        ));

        $this->db->insert('settings', array(
            'slug'        => 'twitter_oauth_token_secret',
            'title'       => 'OAuth Token Secret',
            'description' => '',
            'default'     => '',
            'value'       => '',
            'type'        => 'text',
            'options'     => '',
            'is_required' => 0,
            'is_gui'      => 1,
            'module'      => 'twitter'
        ));

        $this->db->insert('settings', array(
            'slug'        => 'twitter_consumer_key',
            'title'       => 'Consumer Key',
            'description' => '',
            'default'     => '',
            'value'       => '',
            'type'        => 'text',
            'options'     => '',
            'is_required' => 0,
            'is_gui'      => 1,
            'module'      => 'twitter'
        ));

        $this->db->insert('settings', array(
            'slug'        => 'twitter_consumer_secret',
            'title'       => 'Consumer Secret',
            'description' => '',
            'default'     => '',
            'value'       => '',
            'type'        => 'text',
            'options'     => '',
            'is_required' => 0,
            'is_gui'      => 1,
            'module'      => 'twitter'
        ));
	}
	
	public function down()
	{
        $this->db->where_in('slug', array(
            'twitter_username',
            'twitter_feed_count',
            'twitter_cache',
            'twitter_oauth_access_token',
            'twitter_oauth_token_secret',
            'twitter_consumer_key',
            'twitter_consumer_secret'
        ))->delete('settings');
	}
}
