<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Pyro\Module\Streams_core\EntryModel;
use Pyro\Module\Streams_core\StreamModel;

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
		// Bind user profiles
		//Events::register('admin_controller', array($this, 'attach_profile'));
		//Events::register('attach_profile', array($this, 'attach_profile'));
		Events::register('public_controller', array($this, 'attach_profile'));
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

		// Get the stream
		$stream = StreamModel::findBySlugAndNamespace('profiles', 'users');

		// Exists? Go for it!
		if ($stream) {

			// Get the profile
			$profile = EntryModel::stream($stream)->select('*')->where('user_id', ci()->current_user->id)->first();

			// If we have a result - use it
			if ($profile)
				ci()->current_user->profile = $profile;
		}
	}
}
