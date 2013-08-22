<?php namespace Pyro\Module\Users\Model; 

use Pyro\Module\Streams_core\Core\Model\Entry as StreamEntry;

/**
 * Profile model for the users module.
 * 
 * @author      PyroCMS Dev Team
 * @package     PyroCMS\Core\Modules\User\Models
 */
class Profile extends StreamEntry
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $stream_slug = 'profiles';

    protected $stream_namespace = 'users';

    /**
     * Disable updated_at and created_at on table
     *
     * @var boolean
     */
    public $timestamps = false;

	/**
	 * Update a user's profile
	 *
	 *
	 * @param array $input A mirror of $_POST
	 * @param int $id The ID of the profile to update
	 * @return bool
	 */
	public function update_profile($input, $id)
	{
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
			'updated_on'	=>	now()
		);

		if (isset($input['dob_day'])) {
			$set['dob'] = mktime(0, 0, 0, $input['dob_month'], $input['dob_day'], $input['dob_year']);
		}

		// Does this user have a profile already?
		if ($this->db->get_where('profiles', array('user_id' => $id))->row()) {
			$this->db->update('profiles', $set, array('user_id'=>$id));
		} else {
			$set['user_id'] = $id;
			$this->db->insert('profiles', $set);
		}

		return true;
	}
}
