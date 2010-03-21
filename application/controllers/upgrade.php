<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @name 		Upgrade Controller - Ion Auth Integration
 * @author 		Ben Edmunds - PyroCMS Development Team
 * @package 	PyroCMS
 * @subpackage 	Controllers
 */
class Upgrade extends Controller
{
	function __construct()
	{
  		parent::Controller();
  		$this->load->database();
  		$this->load->dbforge();
 	}

 	// Upgrade
 	function index()
	{
		//if the meta tables doesnt exist lets do some magic
		if (!$this->db->table_exists('meta')) {
			
			//create the meta table
			$this->dbforge->add_field('id');
			$meta_fields = array(
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
	
			$this->dbforge->add_field($meta_fields);
			echo 'creating meta table...<br><br>';
			$this->dbforge->create_table('meta');
			
			
			$this->db->select(array('users.id as user_id, users.first_name, users.last_name, users.lang, profiles.bio, profiles.dob, profiles.gender, profiles.phone, profiles.mobile, profiles.address_line1, profiles.address_line2, profiles.address_line3, profiles.postcode, profiles.msn_handle, profiles.aim_handle, profiles.yim_handle, profiles.gtalk_handle, profiles.gravatar, profiles.updated_on'));
			$this->db->join('profiles', 'profiles.user_id = users.id', 'left');
			$query = $this->db->get('users');
			
			$profile_result = $query->result_array();
						
			//insert the meta data
			foreach ($profile_result as $profile_data) {
				echo 'inserting user ' . $profile_data['user_id'] . ' into meta table...<br>';
			
				$this->db->insert('meta', $profile_data);
			}
			echo '<br><br>';
			
			$this->db->select(array('id, role'));
			$role_user_query = $this->db->get('users');
			
			$role_user_result = $role_user_query->result_array();
			
			//update roles to group_id
			echo 'converting roles to group_ids <br><br>';
			foreach ($role_user_result as $role) {
				$role_query = $this->db->select(array('id'))->where('abbrev', $role['role'])->get('permission_roles');
				$current_role = $role_query->row_array();
				
				$this->db->where('id', $role['id'])->update('users', array('role' => $current_role['id']));
			}
			
			//rename permission_roles table
			echo 'renaming permission_roles to groups <br>';
			$this->dbforge->rename_table('permission_roles', 'groups');
			
			//add new groups field
			echo 'adding columns to groups table <br>';
			$new_groups_fields = array(
	                        'description' => array('type' 	  	=> 'VARCHAR',
	                                               'constraint' => 100,
                                                   'null' 		=> TRUE,
	                                          	  ),
	                );
			$this->dbforge->add_column('groups', $new_groups_fields);
			
			//rename the groups columns
			echo 'renaming the groups columns <br>';
			$modify_groups_fields = array('abbrev' => array('name' 	  => 'name',
                                                 		    'type' 	  => 'VARCHAR',
	                                             		    'constraint' => '100',
                                               			   ),
					 	   );
			$this->dbforge->modify_column('groups', $modify_groups_fields);
			
			//rename the users columns
			echo 'renaming the users columns <br>';
			$modify_user_fields = array('is_active' => array('name' 	  => 'active',
                                                 			 'type' 	  => 'INT',
	                                             			 'constraint' => '1',
                                               				),
                            'ip' => array('name' 	   => 'ip_address',
                                          'type' 	   => 'VARCHAR',
	                                      'constraint' => '16',
                                         ),
                            'activation_code' => array('name' 	    => 'activation_code',
                                          			   'type' 	    => 'VARCHAR',
	                                      			   'constraint' => '40',
                                                 	   'null' 	    => TRUE,
                                         			  ),
                            'role' => array('name' 	     => 'group_id',
                                            'type' 	     => 'INT',
	                                      	'constraint' => '11',
                                            'null' 	     => TRUE,
                                           ),
					 	   );
			$this->dbforge->modify_column('users', $modify_user_fields);
			
			//add new users fields
			echo 'adding columns to users table <br>';
			$new_users_fields = array(
	                        'username' => array('type' 	  	=> 'VARCHAR',
	                                            'constraint' => 20,
                                                'null' 		=> TRUE,
	                                           ),
	                        'forgotten_password_code' => array('type' 	  	=> 'VARCHAR',
	                                                 		   'constraint' => 40,
                                                 	 		   'null' 		=> TRUE,
	                                          				  ),
	                        'remember_code' => array('type' 	  => 'VARCHAR',
	                                                 'constraint' => 40,
                                                 	 'null' 	  => TRUE,
	                                          		),
	                );
			$this->dbforge->add_column('users', $new_users_fields);
			
			//removing columns from users table
			echo 'removing columns from users table <br>';
			$this->dbforge->drop_column('users', 'first_name');
			$this->dbforge->drop_column('users', 'last_name');
			$this->dbforge->drop_column('users', 'lang');
			
			//drop the profiles table
			echo 'dropping the profiles table';
			$this->dbforge->drop_table('profiles');
			
			
		}
	}
     
}
?>
