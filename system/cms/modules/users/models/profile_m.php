<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author 		Phil Sturgeon - PyroCMS Development Team
 * @package 	PyroCMS
 * @subpackage 	Users Module
 * @since		v0.1
 *
 */
class Profile_m extends MY_Model {
	
	/**
	 * Get a user profile
	 *
	 * @access public
	 * @param array $params Parameters used to retrieve the profile
	 * @return object
	 */
	function get_profile($params = array())
	{
		$query = $this->db->get_where('profiles', $params);

		return $query->row();
	}
	
	/**
	 * Update a user's profile
	 *
	 * @access public
	 * @param array $input A mirror of $_POST
	 * @param int $id The ID of the profile to update
	 * @return bool
	 */
	function update_profile($input, $id) {
		
		$this->load->helper('date');
            
		$set = array(
			'gender'		=> 	$input['gender'],
			'bio'			=> 	$input['bio'],

			'phone'			=>	$input['phone'],
			'mobile'		=>	$input['mobile'],
			'address_line1'	=>	$input['address_line1'],
			'address_line2'	=>	$input['address_line2'],
			'address_line3'	=>	$input['address_line3'],
			'postcode'		=>	$input['postcode'],
	 		'website'		=>	$input['website'],
	
			'msn_handle'	=>	$input['msn_handle'],
			'aim_handle'	=>	$input['aim_handle'],
			'yim_handle'	=>	$input['yim_handle'],
			'gtalk_handle'	=>	$input['gtalk_handle'],
			'updated_on'	=>	now()
		);

		if(isset($input['dob_day'])){
			$set['dob'] = mktime(0, 0, 0, $input['dob_month'], $input['dob_day'], $input['dob_year']);
		}

		// Does this user have a profile already?
		if($this->db->get_where('profiles', array('user_id' => $id))->row()):
			$this->db->update('profiles', $set, array('user_id'=>$id));
			
		else:
			$set['user_id'] = $id;
			$this->db->insert('profiles', $set);
		endif;
		
		return TRUE;
	}
}