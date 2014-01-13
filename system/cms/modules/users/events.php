<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Pyro\Module\Streams_core\EntryModel;
use Pyro\Module\Streams_core\StreamModel;
use Pyro\Module\Users\Model\Profile;

/**
 * Users Events Class
 * 
 * @package			CMS
 * @subpackage    	Users Module
 * @category    	Events
 * @author        	Ryan Thompson - AI Web Systems, Inc.
 * @website       	http://aiwebsystems.com
 */
class Events_Users {

	public function __construct()
	{
		// Bind user profile
		Events::register('public_controller', array($this, 'attach_profile'));
		Events::register('send_activation_email', array($this, 'send_activation_email'));
	}

	/**
	 *	Bind a users profile to current_user
	 *
	 *	params void
	 *	return void
	 */
	public function attach_profile()
	{
		// Got a user?
		if (! isset(ci()->current_user->id)) return false;

		// Ajax?
		if (ci()->input->is_ajax_request()) return false;

		// Not already attached
		if (isset(ci()->current_user->profile)) return false;

		// Get the profile
		$profile = Profile::where('user_id', ci()->current_user->id)->first();

		// If we have a result - use it
		if ($profile) {
			ci()->current_user->profile = $profile;
		}
	}

	/**
	 * Send an activation code for the user
	 * @param  Pyro\Module\Users\Model\User $user
	 * @return boolean
	 */
	public function send_activation_email($user)
	{
		if ($user) {

			// This creates teh activation code in the DB too
			$activation_code = $user->getActivationCode();

			// Add in some extra details
			$data['subject']			= Settings::get('site_name') . ' - Account Activation';
			$data['slug'] 				= 'activation';
			$data['to'] 				= $user->email;
			$data['from'] 				= Settings::get('server_email');
			$data['name']				= Settings::get('site_name');
			$data['reply-to']			= Settings::get('contact_email');
			$data['activation_code']	= $activation_code;
			$data['user']				= $user;
			
			// send the email using the template event found in system/cms/templates/
			return (bool) Events::trigger('email', $data, 'array');
		}

		return false;
	}
}
