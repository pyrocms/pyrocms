<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This changes the user 
 */
class Migration_Convert_user_profiles_table extends CI_Migration {

    public function up()
    {
        if (defined('PYROPATH'))
        {
            $this->load->add_package_path(PYROPATH.'modules/streams_core');
        }

    	$this->load->language('users/user');
    	$this->load->library('settings/Settings');

    	// Load up the streams driver and convert the profiles table
    	// into a stream.
    	$this->load->driver('Streams');

    	$this->streams->utilities->convert_table_to_stream('profiles', 'users', null, 'lang:user_profile_fields_label', 'Profiles for users module', 'display_name', array('display_name'));

    	// Go ahead and convert our standard user fields:
    	$columns = array(
			'first_name' => array(
    			'field_name' => 'lang:user:first_name_label',
    			'field_type' => 'text',
    			'extra'		 => array('max_length' => 50),
    			'assign'	 => array('required' => true)
    		),
			'last_name' => array(
    			'field_name' => 'lang:user:last_name_label',
    			'field_type' => 'text',
    			'extra'		 => array('max_length' => 50, 'required' => false)
    		),
    		'company' => array(
    			'field_name' => 'lang:profile_company',
    			'field_slug' => 'company',
    			'field_type' => 'text',
    			'extra'		 => array('max_length' => 100)
    		),
 			'bio' => array(
    			'field_name' => 'lang:profile_bio',
    			'field_type' => 'textarea'
    		),
            'lang' => array(
                'field_name' => 'lang:user:lang',
                'field_type' => 'pyro_lang',
                'extra'      => array('filter_theme' => 'yes')
            ),
			'dob' => array(
    			'field_name' => 'lang:profile_dob',
    			'field_type' => 'datetime',
    			'extra'		 => array(
                    'use_time'      => 'no',
                    'storage'       => 'unix',
                    'input_type'    => 'dropdown',
                    'start_date'    => '-100Y'
                )
    		),
    		'gender' => array(
    			'field_name' => 'lang:profile_gender',
    			'field_type' => 'choice',
    			'extra'		 => array(
                    'choice_type' => 'dropdown',
                    'choice_data' => " : Not Telling\nm : Male\nf : Female"
                )
    		),
     		'phone' => array(
    			'field_name' => 'lang:profile_phone',
    			'field_type' => 'text',
    			'extra'		 => array('max_length' => 20)
    		),
     		'mobile' => array(
    			'field_name' => 'lang:profile_mobile',
    			'field_type' => 'text',
    			'extra'		 => array('max_length' => 20)
    		),
      		'address_line1' => array(
    			'field_name' => 'lang:profile_address_line1',
    			'field_type' => 'text'
    		),
      		'address_line2' => array(
    			'field_name' => 'lang:profile_address_line2',
    			'field_type' => 'text'
    		),
    		'address_line3' => array(
    			'field_name' => 'lang:profile_address_line3',
    			'field_type' => 'text'
    		),
    		'postcode' => array(
    			'field_name' => 'lang:profile_address_postcode',
    			'field_type' => 'text',
    			'extra'		 => array('max_length' => 20)
    		),
     		'website' => array(
    			'field_name' => 'lang:profile_website',
    			'field_type' => 'url'
    		)
        );

		// Special case: Do we require the last name?
		if (Settings::get('require_lastname'))
		{
			$fields['last_name']['assign'] = array('required' => true);
		}
        else
        {
            // To be complete 
            $ls_update = array(
                'last_name'         => array(
                    'null'          => true,
                    'type'          => 'VARCHAR',
                    'constraint'    => 50
                )
            );
            $this->dbforge->modify_column('profiles', $ls_update);
        }

		// Here we go...
		// Run through each column and add the field
		// metadata to it.
    	foreach($columns as $field_slug => $column)
    	{
    		// We only want fields that actually exist in the
    		// DB. The user could have deleted some of them.
    		if ($this->db->field_exists($field_slug, 'profiles'))
    		{
	    		$extra = array();
	    		$assign = array();

	    		if (isset($column['extra']))
	    		{
	    			$extra = $column['extra'];
	    		}

	    		if (isset($column['assign']))
	    		{
	    			$assign = $column['assign'];
	    		}

	    		$this->streams->utilities->convert_column_to_field('profiles', 'users', $column['field_name'], $field_slug, $column['field_type'], $extra, $assign);

	    		unset($extra);
	    		unset($assign);
    		}
    	}

    }

    public function down()
    {
		
    }
}