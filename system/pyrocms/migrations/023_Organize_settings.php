<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Organize_settings extends Migration {

	function up()
	{

		$this->dbforge->add_column('settings', array(
			'`order`' => array(
				'type'			=> 'int',
				'constraint'	=> 5,
				'null'			=> FALSE,
				'default'		=> 0
			)
		));

		$this->db->where('slug', 'site_name')->update('settings', array('order' => 1000));
		$this->db->where('slug', 'site_slogan')->update('settings', array('order' => 999));
		$this->db->where('slug', 'meta_topic')->update('settings', array('order' => 998));
		$this->db->where('slug', 'site_lang')->update('settings', array('order' => 997));
		$this->db->where('slug', 'date_format')->update('settings', array('order' => 996));
		$this->db->where('slug', 'currency')->update('settings', array('order' => 995));
		$this->db->where('slug', 'records_per_page')->update('settings', array('order' => 994));
		$this->db->where('slug', 'rss_feed_items')->update('settings', array('order' => 993));
		$this->db->where('slug', 'dashboard_rss')->update('settings', array('order' => 992));
		$this->db->where('slug', 'dashboard_rss_count')->update('settings', array('order' => 991));
		$this->db->where('slug', 'frontend_enabled')->update('settings', array('order' => 990));
		$this->db->where('slug', 'unavailable_message')->update('settings', array('order' => 989));
		$this->db->where('slug', 'ga_tracking')->update('settings', array('order' => 988));
		$this->db->where('slug', 'ga_profile')->update('settings', array('order' => 987));
		$this->db->where('slug', 'ga_email')->update('settings', array('order' => 986));
		$this->db->where('slug', 'ga_password')->update('settings', array('order' => 985));
		$this->db->where('slug', 'akismet_api_key')->update('settings', array('order' => 984));
		$this->db->where('slug', 'contact_email')->update('settings', array('module' => 'email', 'order' => 983));
		$this->db->where('slug', 'activation_email')->update('settings', array('module' => 'users', 'order' => 963));
		$this->db->where('slug', 'server_email')->update('settings', array('module' => 'email', 'order' => 981));
		$this->db->where('slug', 'mail_protocol')->update('settings', array('module' => 'email', 'order' => 980));
		$this->db->where('slug', 'mail_smtp_host')->update('settings', array('module' => 'email', 'order' => 979));
		$this->db->where('slug', 'mail_smtp_pass')->update('settings', array('module' => 'email', 'order' => 978, 'type' => 'password'));
		$this->db->where('slug', 'mail_smtp_port')->update('settings', array('module' => 'email', 'order' => 977));
		$this->db->where('slug', 'mail_smtp_user')->update('settings', array('module' => 'email', 'order' => 976));
		$this->db->where('slug', 'mail_sendmail_path')->update('settings', array('module' => 'email', 'order' => 975));
		$this->db->where('slug', 'twitter_blog')->update('settings', array('order' => 974));
		$this->db->where('slug', 'twitter_username')->update('settings', array('order' => 973));
		$this->db->where('slug', 'twitter_feed_count')->update('settings', array('order' => 972));
		$this->db->where('slug', 'twitter_consumer_key')->update('settings', array('order' => 971));
		$this->db->where('slug', 'twitter_consumer_key_secret')->update('settings', array('order' => 970));
		$this->db->where('slug', 'twitter_cache')->update('settings', array('order' => 969));
		$this->db->where('slug', 'enable_comments')->update('settings', array('order' => 968));
		$this->db->where('slug', 'moderate_comments')->update('settings', array('order' => 967));
		$this->db->where('slug', 'comment_order')->update('settings', array('order' => 966));
		$this->db->where('slug', 'enable_profiles')->update('settings', array('order' => 965));
		$this->db->where('slug', 'require_lastname')->update('settings', array('order' => 964, 'module' => 'users'));

	}



	function down()
	{
		$this->dbforge->drop_column('settings', 'order');
	}
}
