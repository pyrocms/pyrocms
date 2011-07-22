<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Ion Auth Config
*
* Author: Ben Edmunds
* 		  ben.edmunds@gmail.com
*         @benedmunds
*
* Added Awesomeness: Phil Sturgeon
*
* Location: http://github.com/benedmunds/ion_auth/
*
* Created:  10.01.2009
*
* Description:  Modified auth system based on redux_auth with extensive customization.  This is basically what Redux Auth 2 should be.  Original redux license is below.
* Original Author name has been kept but that does not mean that the method has not been modified.
*
*/

	/**
	 * Tables.
	 **/
	$config['tables']['groups']  = SITE_REF.'_groups';
	$config['tables']['users']   = SITE_REF.'_users';
	$config['tables']['meta']    = SITE_REF.'_profiles';

	/**
	 * Site Title, example.com
	 */
	$config['site_title']		   = "Example.com";

	/**
	 * Admin Email, admin@example.com
	 */
	$config['admin_email']		   = "admin@example.com";

	/**
	 * Default group, use name
	 */
	$config['default_group']       = 'user';

	/**
	 * Default administrators group, use name
	 */
	$config['admin_group']         = 'admin';

	/**
	 * Meta table column you want to join WITH.
	 * Joins from users.id
	 **/
	$config['join']                = 'user_id';

	/**
	 * Columns in your meta table,
	 * id not required.
	 **/
	$config['columns']             = array('display_name', 'first_name', 'last_name', 'company', 'lang', 'bio', 'dob', 'gender', 'phone', 'mobile', 'address_line1', 'address_line2', 'address_line3', 'postcode', 'website', 'msn_handle', 'aim_handle', 'yim_handle', 'gtalk_handle', 'gravatar', 'updated_on', 'twitter_access_token', 'twitter_access_token_secret');

	/**
	 * A database column which is used to
	 * login with.
	 **/
	$config['identity']            = 'email';

	/**
	 * Minimum Required Length of Password
	 **/
	$config['min_password_length'] = 6;

	/**
	 * Maximum Allowed Length of Password
	 **/
	$config['max_password_length'] = 20;

	/**
	 * Email Activation for registration
	 **/
	$config['email_activation']    = true;

	/**
	 * Allow users to be remembered and enable auto-login
	 **/
	$config['remember_users']      = true;

	/**
	 * How long to remember the user (seconds)
	 **/
	$config['user_expire']         = 86500;

	/**
	 * Extend the users cookies everytime they auto-login
	 **/
	$config['user_extend_on_login'] = false;

	/**
	 * Folder where email templates are stored.
     * Default : auth/
	 **/
	$config['email_templates']     = 'emails/';

	/**
	 * activate Account Email Template
     * Default : activate.tpl.php
	 **/
	$config['email_activate']   = 'activation_required.php';

	/**
	 * Forgot Password Email Template
     * Default : forgot_password.tpl.php
	 **/
	$config['email_forgot_password']   = 'forgot_password.tpl.php';

	/**
	 * Forgot Password Complete Email Template
     * Default : new_password.tpl.php
	 **/
	$config['email_forgot_password_complete']   = 'new_password.tpl.php';

	/**
	 * Salt Length
	 **/
	$config['salt_length'] = 5;

	/**
	 * Should the salt be stored in the database?
	 * This will change your password encryption algorithm,
	 * default password, 'password', changes to
	 * fbaa5e216d163a02ae630ab1a43372635dd374c0 with default salt.
	 **/
	$config['store_salt'] = true;

	/**
	 * Message Start Delimiter
	 **/
	$config['message_start_delimiter'] = '<p>';

	/**
	 * Message End Delimiter
	 **/
	$config['message_end_delimiter'] = '</p>';

	/**
	 * Error Start Delimiter
	 **/
	$config['error_start_delimiter'] = '<p>';

	/**
	 * Error End Delimiter
	 **/
	$config['error_end_delimiter'] = '</p>';

/* End of file ion_auth.php */
/* Location: ./system/application/config/ion_auth.php */