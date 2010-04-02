<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @name 		Upgrade Controller - Ion Auth Integration
 * @author 		Ben Edmunds - PyroCMS Development Team
 * @package 	PyroCMS
 * @subpackage 	Controllers
 */
class Upgrade extends Controller
{

	private $versions = array('0.9.8-rc1', '0.9.8-rc2');

	function _remap()
	{
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
  			show_error('Looks like the upgrade is already complete, you are already running '.$db_version.'.');
  		}

		// File version is not supported
  		if(!in_array($file_version, $this->versions))
  		{
  			show_error('The upgrade script does not support version '.$file_version.'.');
  		}

		// DB is ahead of files
		else if( $base_db_version > $file_version )
		{
			show_error('The database is expecting '.$db_version.' but the version of PyroCMS you are using is '.$file_version.'. Try downloading a newer version from ' . anchor('http://pyrocms.com/') . '.');
		}

  		while($db_version != $file_version)
  		{
	  		// Find the next version
	  		$pos = array_search($db_version, $this->versions) + 1;
	  		$next_version = $this->versions[$pos];

  			// Run the method to upgrade that specific version
	  		$function = 'upgrade_' . preg_replace('/[^0-9a-z]/i', '', $next_version);

	  		if($this->$function() !== TRUE)
	  		{
	  			show_error('There was an error upgrading to "'.$next_version.'"');
	  		}

	  		$this->settings->set_item('version', $next_version);

			echo "<br/><strong>-- Upgraded to " . $next_version . '--</strong><br/><br/>';

	  		$db_version = $next_version;
  		}
 	}

 	// Upgrade
 	function upgrade_098rc2()
	{
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
		foreach ($profile_result as $profile_data) {
			echo 'Inserting user ' . $profile_data['user_id'] . ' into profiles table...<br/>';

			$this->db->insert('profiles', $profile_data);
		}
		echo '<br/>';

			$this->db->select(array('id, role'));
			$role_user_query = $this->db->get('users');

			$role_user_result = $role_user_query->result_array();

			//update roles to group_id
			echo 'Converting roles to group_ids<br/>';
			foreach ($role_user_result as $role) {
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

		$this->ion_auth->logout();

		return TRUE;
	}
}
?>