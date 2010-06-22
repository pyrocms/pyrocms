<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @name 		Upgrade Controller
 * @author 		PyroCMS Development Team
 * @package 	PyroCMS
 * @subpackage 	Controllers
 */
class Upgrade extends Controller
{
	private $versions = array('0.9.8-rc1', '0.9.8-rc2', '0.9.8', '0.9.9', '0.9.9.1', '0.9.9.2', '0.9.9.3', '1.0.0');

	function _remap()
	{
		// Always log out first, stops any weirdness with the user system
		$this->ion_auth->logout();

  		$this->load->database();
  		$this->load->dbforge();

		// The version of the db is defined by a 'version' setting
		$db_version = $this->settings->item('version');

		// What version is the file system running (this is the target version to upgrade to)
  		$file_version = CMS_VERSION;

		// What is the base version of the db, no rc/beta tags.
		list($base_db_version) = explode('-', $db_version);

		if(!$db_version)
		{
			show_error('We have no idea what version you are using, which means it must be v0.9.8-rc1 or before.
				Please manually upgrade everything to v0.9.8-rc1 then you can use this upgrade script past that. Look at /docs/UPGRADE to see how.');
		}

		// Upgrade is already done
  		if($db_version == $file_version)
  		{
  			show_error('Looks like the upgrade is already complete, you are already running v'.$db_version.'.');
  		}

		// DB is ahead of files
		else if( $base_db_version > $file_version )
		{
			show_error('The database is expecting v'.$db_version.' but the version of PyroCMS you are using is v'.$file_version.'. Try downloading a newer version from ' . anchor('http://pyrocms.com/') . '.');
		}

  		while($db_version != $file_version)
  		{
	  		// Find the next version
	  		$pos = array_search($db_version, $this->versions) + 1;
	  		$next_version = isset($this->versions[$pos]) ? $this->versions[$pos] : NULL;

			// next version is not supported
			$next_version or @show_error('The upgrade script does not support version '.$file_version.'.');

  			// Run the method to upgrade that specific version
	  		$function = 'upgrade_' . preg_replace('/[^0-9a-z]/i', '', $next_version);

			// If a method exists and its false fail. no method = no changes
	  		if(method_exists($this, $function) && $this->$function() !== TRUE)
	  		{
	  			show_error('There was an error upgrading to "'.$next_version.'"');
	  		}

	  		$this->settings->set_item('version', $next_version);

			echo "<p><strong>-- Upgraded to " . $next_version . '--</strong></p>';

	  		$db_version = $next_version;
  		}

		echo "<p>The upgrade is complete, please " . anchor('admin', 'click here') . ' to go back to the Control Panel.</p>';
 	}

	function upgrade_100()
	{
	    // Load the versioning library
	    $this->load->library('versioning');
	    $this->versioning->set_table('pages');

	    // First we need to retrieve the current content from the pages table so no data gets lost
	    $pages = $this->db->get('pages');

	    // We need to make sure no data gets lost, therefore we're renaming the pages table to pages_old
	    $this->dbforge->rename_table('pages', 'pages_old');

	    // We can now recreate the pages table
	    $this->db->query("CREATE TABLE `pages` (
	      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	      `revision_id` int(11) NOT NULL DEFAULT '0',
	      `slug` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
	      `title` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
	      `parent_id` int(11) DEFAULT '0',
	      `layout_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default',
	      `css` text COLLATE utf8_unicode_ci,
	      `meta_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	      `meta_keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	      `meta_description` text COLLATE utf8_unicode_ci NOT NULL,
	      `rss_enabled` int(1) NOT NULL DEFAULT '0',
	      `comments_enabled` int(1) NOT NULL DEFAULT '0',
	      `status` enum('draft','live') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'draft',
	      `created_on` int(11) NOT NULL DEFAULT '0',
	      `updated_on` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
	      PRIMARY KEY (`id`),
	      UNIQUE KEY `Unique` (`slug`,`parent_id`),
	      KEY `slug` (`slug`),
	      KEY `parent` (`parent_id`)
	    ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='User Editable Pages'
	    ");

	    // Now that the new pages table has been created it's time to create the revisions table
	    $this->db->query("CREATE TABLE `revisions` (
	      `id` int(11) NOT NULL AUTO_INCREMENT,
	      `owner_id` int(11) NOT NULL,
	      `table_name` varchar(100) NOT NULL DEFAULT 'pages',
	      `body` text,
	      `revision_date` int(11) NOT NULL,
	      `author_id` int(11) NOT NULL,
	      PRIMARY KEY (`id`),
	      KEY `Owner ID` (`owner_id`)
	    ) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8
	    ");

	    // So far so good, time to migrate the old data back to the new table
	    foreach ($pages->result() as $page)
	    {
	        // First insert the page without the revision ID to use
	        $to_insert = array(
	            'id'                => $page->id,
	            'slug'                 => $page->slug,
	            'title'                => $page->title,
	            'parent_id'         => $page->parent_id,
	            'layout_id'         => $page->layout_id,
	            'css'                => $page->css,
	            'meta_title'        => $page->meta_title,
	            'meta_keywords'     => $page->meta_keywords,
	            'meta_description'    => $page->meta_description,
	            'rss_enabled'        => $page->rss_enabled,
	            'comments_enabled'    => $page->comments_enabled,
	            'status'            => $page->status,
	            'created_on'        => $page->created_on,
	            'updated_on'        => $page->updated_on,
	         );

	        // Inser the page
	        $this->db->insert('pages', $to_insert);
	        $page_insert_id = $this->db->insert_id();

	        // Create the revsion, retrieve the ID and modify the page we added earlier
	        $revision_id    = $this->versioning->create_revision( array('author_id' => 1, 'owner_id' => $page_insert_id, 'body' => $page->body) );

	        // Now we can modify the pages table so that it uses the correct revision id
	        $this->db->where( 'id', $page_insert_id);
	        $this->db->update( 'pages', array('revision_id' => $revision_id) );
	    }

	    // Add the website column to the profiles table
	    $this->dbforge->add_column(array(
	        'website' => array(
	            'type'             => 'varchar',
	            'constraint'     => '255',
	            'null'            => TRUE
	        )
	    ));
	    
	    return TRUE;
	}

	function upgrade_0993()
	{
		$this->db->where('slug', 'dashboard_rss')->update('settings', array('default', 'http://feeds.feedburner.com/pyrocms-installed'));

		echo 'Updated user_id in permission_rules to accept 0 as a value.<br/>';
		$this->db->query('ALTER TABLE permission_rules CHANGE user_id user_id int(11) NOT NULL DEFAULT 0');

		echo 'Adding Twitter token fields to user profiles<br />';
		$this->dbforge->add_column('profiles', array(
			'twitter_access_token' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null' => TRUE
			),
			'twitter_access_token_secret' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null' => TRUE
			),
		));

		echo 'Adding twitter consumer key settings<br />';
		$this->db->insert('settings', array('slug' => 'twitter_consumer_key', 'title' => 'Consumer Key', 'description' => 'Twitter Consumer Key.', 'type' => 'text', 'is_required' => 0, 'is_gui' => 1, 'module' => 'twitter'));
		$this->db->insert('settings', array('slug' => 'twitter_consumer_key_secret', 'title' => 'Consumer Key Secret', 'description' => 'Twitter Consumer Key Secret.', 'type' => 'text', 'is_required' => 0, 'is_gui' => 1, 'module' => 'twitter'));

		return FALSE; // Change this before we go live
	}

	function upgrade_0992()
	{
		echo 'Added missing theme_layout field to page_layouts table.<br />';
		$this->dbforge->add_column('page_layouts', array(
			'theme_layout' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null' => FALSE
			),
		));

		echo 'Adding twitter consumer key settings<br />';
		$this->db->insert('settings', array('slug' => 'twitter_consumer_key', 'title' => 'Consumer Key', 'description' => 'Twitter Consumer Key.', 'type' => 'text', 'is_required' => 0, 'is_gui' => 1, 'module' => 'twitter'));
		$this->db->insert('settings', array('slug' => 'twitter_consumer_key_secret', 'title' => 'Consumer Key Secret', 'description' => 'Twitter Consumer Key Secret.', 'type' => 'text', 'is_required' => 0, 'is_gui' => 1, 'module' => 'twitter'));
		
		return TRUE;
	}

 	// Upgrade
 	function upgrade_099()
	{
		echo "Creating modules table...<br />";
		$this->db->query('DROP TABLE IF EXISTS `modules`');
		$this->db->query('CREATE TABLE `modules` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `name` TEXT NOT NULL,
		  `slug` varchar(50) NOT NULL,
		  `version` varchar(20) NOT NULL,
		  `type` varchar(20) DEFAULT NULL,
		  `description` TEXT DEFAULT NULL,
		  `skip_xss` tinyint(1) NOT NULL,
		  `is_frontend` tinyint(1) NOT NULL,
		  `is_backend` tinyint(1) NOT NULL,
		  `is_backend_menu` tinyint(1) NOT NULL,
		  `enabled` tinyint(1) NOT NULL,
		  `is_core` tinyint(1) NOT NULL,
		  `controllers` text NOT NULL,
		  PRIMARY KEY (`id`),
		  UNIQUE KEY `slug` (`slug`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');

		echo "Importing current modules into database...<br />";

		// Load the module import class
		$this->load->library('module_import');
		$this->module_import->_import();

		echo 'Clearing the module cache...<br/>';
		$this->cache->delete_all('modules_m');

		echo 'Adding comments_enabled field to pages table...<br/>';
		//add display_name to profiles table
		$this->dbforge->add_column('pages', array(
			'comments_enabled' => array(
				'type' 	  	=> 'INT',
				'constraint' => 1,
				'default' => 0,
				'null' 		=> FALSE
			)
        ));

		echo 'Clearing the page cache...<br/>';
		$this->cache->delete_all('pages_m');
		
		echo 'Adding theme_layout field to page_layouts table...<br/>';
		//add display_name to profiles table
		$this->dbforge->add_column('page_layouts', array(
			'theme_layout' => array(
				'type' 	  	=> 'VARCHAR',
				'constraint' => '100',
				'null' 		=> TRUE
			)
        ));

		echo 'Adding display_name field to profiles table...<br/>';
		$this->dbforge->add_column('profiles', array(
			'display_name' => array(
				'type' 	  	=> 'VARCHAR',
				'constraint' => '100',
				'null' 		=> TRUE
			)
        ));

        //get the profiles
        $this->db->select('profiles.id, users.id as user_id, profiles.first_name, profiles.last_name');
		$this->db->join('profiles', 'profiles.user_id = users.id', 'left');
		$profile_result = $this->db->get('users')->result_array();

		//insert the display names into profiles
		foreach ($profile_result as $profile_data)
		{
			echo 'Inserting user ' . $profile_data['user_id'] . ' display_name into profiles table...<br/>';

			$data = array('display_name' => $profile_data['first_name'].' '.$profile_data['last_name']);
			$this->db->where('id', $profile_data['id']);
			$this->db->update('profiles', $data);
			echo '<br/>';
		}

		echo "Changing Forum Tables Collation...<br />";
		$this->db->query("ALTER TABLE  `forums` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci");
		$this->db->query("ALTER TABLE  `forum_posts` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci");
		$this->db->query("ALTER TABLE  `forum_categories` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci");
		$this->db->query("ALTER TABLE  `forum_subscriptions` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci");

		echo "Changing Forum Table Column Collation...<br />";
		$this->db->query("ALTER TABLE  `forums` CHANGE  `title`  `title` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL");
		$this->db->query("ALTER TABLE  `forums` CHANGE  `description`  `description` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  ''");

		$this->db->query("ALTER TABLE  `forum_categories` CHANGE  `title`  `title` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  ''");

		$this->db->query("ALTER TABLE  `forum_posts` CHANGE  `content`  `content` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL");
		$this->db->query("ALTER TABLE  `forum_posts` CHANGE  `title`  `title` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  ''");
		
		return TRUE;
	}

	
	function upgrade_098()
	{
		//rename the users columns
		echo 'Renaming photo description to captions...<br/>';
		$this->dbforge->modify_column('photos', array(
			'description' => array(
				'name' 	  => 'caption',
				'type' 	  => 'VARCHAR',
				'constraint' => 100,
			)
		));

		return TRUE;
	}

 	// Upgrade
 	function upgrade_098rc2()
	{
		echo 'Moving existing "photo" comments to photo-album comments.<br/>';
		$this->db->where('module', 'photos');
		$this->db->update('comments', array('module' => 'photos-album'));

		// Create a "unsorted" widget area
		echo 'Adding unsorted widget area.<br/>';
		$this->db->insert('widget_areas', array('slug' => 'unsorted', 'title' => 'Unsorted'));

		echo 'Adding ip_address to comments.<br/>';
		$this->dbforge->add_column('comments', array(
			'ip_address' => array(
				'type' 	  => 'VARCHAR',
				'constraint' => '15'
			)
		));

		//if the groups tables doesnt exist lets do some magic
		if ( $this->db->table_exists('groups'))
		{
			show_error('The table "groups" already exists.');
		}

		$this->db->select(array('users.id as user_id, users.first_name, users.last_name, users.lang, profiles.bio, profiles.dob, profiles.gender, profiles.phone, profiles.mobile, profiles.address_line1, profiles.address_line2, profiles.address_line3, profiles.postcode, profiles.msn_handle, profiles.aim_handle, profiles.yim_handle, profiles.gtalk_handle, profiles.gravatar, profiles.updated_on'));
		$this->db->join('profiles', 'profiles.user_id = users.id', 'left');
		$profile_result = $this->db->get('users')->result_array();

		//drop the profiles table
		echo 'Dropping the profiles table.<br/>';
		$this->dbforge->drop_table('profiles');

		//create the meta table
		$this->dbforge->add_field('id');
		$profiles_fields = array(
			'user_id' => array(
				'type' 	  	  => 'INT',
				'constraint' 	  => 11,
				'unsigned' 	  => TRUE,
				'auto_increment' => FALSE,
				'null' => FALSE,
			),
				'first_name' => array(
				'type' 	  => 'VARCHAR',
				'constraint' => '50',
				'null' => FALSE,
			),
				'last_name' => array(
				'type' 	  => 'VARCHAR',
				'constraint' => '50',
				'null' => FALSE,
			),
				'company' => array(
				'type' 	  => 'VARCHAR',
				'constraint' => '100',
				'null' => FALSE,
			),
			'lang' => array(
				'type' 	  => 'VARCHAR',
				'constraint' => '2',
				'null' => FALSE,
				'default' => 'en',
			),
			'bio' => array(
				'type' 	  => 'text',
				'null' => TRUE,
			),
			'dob' => array(
				'type' 	  => 'INT',
				'constraint' => '11',
				'null' => TRUE,
			),

			'gender' => array(
				'type' 	  => "set('m','f','')",
				'null' => TRUE,
			),
			'phone' => array(
				'type' 	  => 'VARCHAR',
				'constraint' => '20',
				'null' => TRUE,
			),
			'mobile' => array(
				'type' 	  => 'VARCHAR',
				'constraint' => '20',
				'null' => TRUE,
			),
			'address_line1' => array(
				'type' 	  => 'VARCHAR',
				'constraint' => '255',
				'null' => TRUE,
			),
			'address_line2' => array(
				'type' 	  => 'VARCHAR',
				'constraint' => '255',
				'null' => TRUE,
			),
			'address_line3' => array(
				'type' 	  => 'VARCHAR',
				'constraint' => '255',
				'null' => TRUE,
			),
			'postcode' => array(
				'type' 	  => 'VARCHAR',
				'constraint' => '20',
				'null' => TRUE,
			),
			'msn_handle' => array(
				'type' 	  => 'VARCHAR',
				'constraint' => '100',
				'null' => TRUE,
			),
			'yim_handle' => array(
				'type' 	  => 'VARCHAR',
				'constraint' => '100',
				'null' => TRUE,
			),
			'aim_handle' => array(
				'type' 	  => 'VARCHAR',
				'constraint' => '100',
				'null' => TRUE,
			),
			'gtalk_handle' => array(
				'type' 	  => 'VARCHAR',
				'constraint' => '100',
				'null' => TRUE,
			),
			'gravatar' => array(
				'type' 	  => 'VARCHAR',
				'constraint' => '100',
				'null' => TRUE,
			),
			'updated_on' => array(
				'type' 	  => 'INT',
				'constraint' => '11',
				'unsigned' 	  => TRUE,
				'auto_increment' => FALSE,
			),
		);

		$this->dbforge->add_field($profiles_fields);
		echo 'Creating profiles table...<br/>';
		$this->dbforge->create_table('profiles');

		//insert the profile data
		foreach ($profile_result as $profile_data)
		{
			echo 'Inserting user ' . $profile_data['user_id'] . ' into profiles table...<br/>';

			$this->db->insert('profiles', $profile_data);
		}
		echo '<br/>';

			$this->db->select(array('id, role'));
			$role_user_query = $this->db->get('users');

			$role_user_result = $role_user_query->result_array();

			//update roles to group_id
			echo 'Converting roles to group_ids<br/>';
			foreach ($role_user_result as $role)
			{
				$role_query = $this->db->select(array('id'))->where('abbrev', $role['role'])->get('permission_roles');
				$current_role = $role_query->row_array();

				$this->db->where('id', $role['id'])->update('users', array('role' => $current_role['id']));
			}

			//rename permission_roles table
			echo 'Renaming permission_roles to groups <br/>';
			$this->dbforge->rename_table('permission_roles', 'groups');

			//add new groups field
			echo 'Adding columns to groups table <br />';
			$this->dbforge->add_column('groups', array(
				'description' => array(
					'type' 	  	=> 'VARCHAR',
					'constraint' => 100,
					'null' 		=> TRUE,
				  ),
			));

			//rename the groups columns
			echo 'Renaming the groups columns <br/>';
			$this->dbforge->modify_column('groups', array(
				'abbrev' => array(
					'name' 	  => 'name',
					'type' 	  => 'VARCHAR',
					'constraint' => '100',
				)
			));

			//rename the users columns
			echo 'Renaming the users columns <br/>';
			$this->dbforge->modify_column('users', array(
				'is_active' => array(
					'name' 	  => 'active',
					'type' 	  => 'INT',
					'constraint' => '1',
				),
				'ip' => array(
					'name' 	   => 'ip_address',
					'type' 	   => 'VARCHAR',
					'constraint' => '16',
				 ),
				'activation_code' => array(
					'name' 	    => 'activation_code',
					'type' 	    => 'VARCHAR',
					'constraint' => '40',
					'null' 	    => TRUE
				),
				'role' => array(
					'name' 	     => 'group_id',
					'type' 	     => 'INT',
					'constraint' => '11',
					'null' 	     => TRUE,
				)
			));

			// add new users fields
			echo 'Adding columns to users table <br/>';

		$this->dbforge->add_column('users', array(
			'username' => array(
				'type' 	  	=> 'VARCHAR',
				'constraint' => 20,
				'null' 		=> TRUE,
			),
			'forgotten_password_code' => array(
				'type' => 'VARCHAR',
				'constraint' => 40,
				'null' 		=> TRUE
			),
			'remember_code' => array(
				'type' 	  => 'VARCHAR',
				'constraint' => 40,
				'null' 	  => TRUE
			)
        ));

		//removing columns from users table
		echo 'Removing columns from users table <br/>';
		$this->dbforge->drop_column('users', 'first_name');
		$this->dbforge->drop_column('users', 'last_name');
		$this->dbforge->drop_column('users', 'lang');

		echo 'Creating forum tables...<br/>';

		$this->db->query("CREATE TABLE `forum_categories` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `title` varchar(100) NOT NULL DEFAULT '',
		  `permission` mediumint(2) NOT NULL DEFAULT '0',
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Splits forums into categories'");

		$this->db->query("CREATE TABLE `forum_posts` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `forum_id` int(11) NOT NULL DEFAULT '0',
		  `author_id` int(11) NOT NULL DEFAULT '0',
		  `parent_id` int(11) NOT NULL DEFAULT '0',
		  `title` varchar(100) NOT NULL DEFAULT '',
		  `content` text NOT NULL,
		  `type` tinyint(1) NOT NULL DEFAULT '0',
		  `is_locked` tinyint(1) NOT NULL DEFAULT '0',
		  `is_hidden` tinyint(1) NOT NULL DEFAULT '0',
		  `created_on` int(11) NOT NULL DEFAULT '0',
		  `updated_on` int(11) NOT NULL DEFAULT '0',
		  `view_count` int(11) NOT NULL DEFAULT '0',
		  `sticky` tinyint(1) NOT NULL DEFAULT '0',
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

		$this->db->query("CREATE TABLE `forum_subscriptions` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `topic_id` int(11) NOT NULL DEFAULT '0',
		  `user_id` int(11) NOT NULL DEFAULT '0',
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

		$this->db->query("CREATE TABLE `forums` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `title` varchar(100) NOT NULL DEFAULT '',
		  `description` varchar(255) NOT NULL DEFAULT '',
		  `category_id` int(11) NOT NULL DEFAULT '0',
		  `permission` int(2) NOT NULL DEFAULT '0',
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Forums are the containers for threads and topics.'");

		return TRUE;
	}
}