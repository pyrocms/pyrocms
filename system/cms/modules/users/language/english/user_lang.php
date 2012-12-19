<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['user:add_field']                        	= 'Add User Profile Field';
$lang['user:profile_delete_success']           	= 'User profile field deleted successfully';
$lang['user:profile_delete_failure']            = 'There was a problem with deleting your user profile field';
$lang['profile_user_basic_data_label']  		= 'Basic Data';
$lang['profile_company']         	  			= 'Company'; 
$lang['profile_updated_on']           			= 'Updated On';
$lang['user:profile_fields_label']	 		 	= 'Profile Fields';

$lang['user:register_header']                  = 'Registration';
$lang['user:register_step1']                   = '<strong>Step 1:</strong> Register';
$lang['user:register_step2']                   = '<strong>Step 2:</strong> Activate';

$lang['user:login_header']                     = 'Login';

// titles
$lang['user:add_title']                        = 'Add User';
$lang['user:list_title'] 					   = 'Users';
$lang['user:inactive_title']                   = 'Inactive Users';
$lang['user:active_title']                     = 'Active Users';
$lang['user:registred_title']                  = 'Registered Users';

// labels
$lang['user:edit_title']                       = 'Edit User "%s"';
$lang['user:details_label']                    = 'Details';
$lang['user:first_name_label']                 = 'First Name';
$lang['user:last_name_label']                  = 'Last Name';
$lang['user:group_label']                      = 'Group';
$lang['user:activate_label']                   = 'Activate';
$lang['user:password_label']                   = 'Password';
$lang['user:password_confirm_label']           = 'Confirm Password';
$lang['user:name_label']                       = 'Name';
$lang['user:joined_label']                     = 'Joined';
$lang['user:last_visit_label']                 = 'Last visit';
$lang['user:never_label']                      = 'Never';

$lang['user:no_inactives']                     = 'There are no inactive users.';
$lang['user:no_registred']                     = 'There are no registered users.';

$lang['account_changes_saved']                 = 'The changes to your account have been saved successfully.';

$lang['indicates_required']                    = 'Indicates required fields';

// -- Registration / Activation / Reset Password ----------------------------------------------------------

$lang['user:send_activation_email']            = 'Send Activation Email';
$lang['user:do_not_activate']                  = 'Inactive';
$lang['user:register_title']                   = 'Register';
$lang['user:activate_account_title']           = 'Activate Account';
$lang['user:activate_label']                   = 'Activate';
$lang['user:activated_account_title']          = 'Activated Account';
$lang['user:reset_password_title']             = 'Reset Password';
$lang['user:password_reset_title']             = 'Password Reset';


$lang['user:error_username']                   = 'The username you selected is already in use.';
$lang['user:error_email']                      = 'The email address you entered is already in use.';

$lang['user:full_name']                        = 'Full Name';
$lang['user:first_name']                       = 'First Name';
$lang['user:last_name']                        = 'Last Name';
$lang['user:username']                         = 'Username';
$lang['user:display_name']                     = 'Display Name';
$lang['user:email_use'] 					   = 'used to login';
$lang['user:remember']                         = 'Remember Me';
$lang['user:group_id_label']                   = 'Group ID';

$lang['user:level']                            = 'User Role';
$lang['user:active']                           = 'Active';
$lang['user:lang']                             = 'Language';

$lang['user:activation_code']                  = 'Activation code';

$lang['user:reset_instructions']			   = 'Enter your email address or username';
$lang['user:reset_password_link']              = 'Forgot your password?';

$lang['user:activation_code_sent_notice']      = 'An email has been sent to you with your activation code.';
$lang['user:activation_by_admin_notice']       = 'Your registration is awaiting approval by an administrator.';
$lang['user:registration_disabled']            = 'Sorry, but the user registration is disabled.';

// -- Settings ---------------------------------------------------------------------------------------------

$lang['user:details_section']                  = 'Name';
$lang['user:password_section']                 = 'Change password';
$lang['user:other_settings_section']           = 'Other settings';

$lang['user:settings_saved_success']           = 'The settings for your user account have been saved.';
$lang['user:settings_saved_error']             = 'An error occurred.';

// -- Buttons ----------------------------------------------------------------------------------------------

$lang['user:register_btn']                     = 'Register';
$lang['user:activate_btn']                     = 'Activate';
$lang['user:reset_pass_btn']                   = 'Reset Pass';
$lang['user:login_btn']                        = 'Login';
$lang['user:settings_btn']                     = 'Save settings';

// -- Errors & Messages ------------------------------------------------------------------------------------

// Create
$lang['user:added_and_activated_success']      = 'New user has been created and activated.';
$lang['user:added_not_activated_success']      = 'New user has been created, the account needs to be activated.';

// Edit
$lang['user:edit_user_not_found_error']        = 'User not found.';
$lang['user:edit_success']                     = 'User successfully updated.';
$lang['user:edit_error']                       = 'Error occurred when trying to update user.';

// Activate
$lang['user:activate_success']                 = '%s users out of %s successfully activated.';
$lang['user:activate_error']                   = 'You need to select users first.';

// Delete
$lang['user:delete_self_error']                = 'You cannot delete yourself!';
$lang['user:mass_delete_success']              = '%s users out of %s successfully deleted.';
$lang['user:mass_delete_error']                = 'You need to select users first.';

// Register
$lang['user:email_pass_missing']               = 'Email or password fields are not complete.';
$lang['user:email_exists']                     = 'The email address you have chosen is already in use with a different user.';
$lang['user:register_error']				   = 'We think you are a bot. If we are mistaken please accept our apologies.';
$lang['user:register_reasons']                 = 'Join up to access special areas normally restricted. This means your settings will be remembered, more content and less ads.';


// Activation
$lang['user:activation_incorrect']             = 'Activation failed. Please check your details and make sure CAPS LOCK is not on.';
$lang['user:activated_message']                = 'Your account has been activated, you can now log in to your account.';


// Login
$lang['user:logged_in']                        = 'You have logged in successfully.'; # TODO: Translate this in spanish
$lang['user:already_logged_in']                = 'You are already logged in. Please logout before trying again.';
$lang['user:login_incorrect']                  = 'E-mail or password do not match. Please check your login and make sure CAPS LOCK is not on.';
$lang['user:inactive']                         = 'The account you are trying to access is currently inactive.<br />Check your e-mail for instructions on how to activate your account - <em>it may be in the junk folder</em>.';


// Logged Out
$lang['user:logged_out']                       = 'You have been logged out.';

// Forgot Pass
$lang['user:forgot_incorrect']                 = "No account was found with these details.";

$lang['user:password_reset_message']           = "Your password has been reset. You should recieve the email within the next 2 hours. If you don't, it might have gone into your junk mail by accident.";


// Emails ----------------------------------------------------------------------------------------------------

// Activation
$lang['user:activation_email_subject']         = 'Activation Required';
$lang['user:activation_email_body']            = 'Thank you for activting your account with %s. To log in to the site, please visit the link below:';


$lang['user:activated_email_subject']          = 'Activation Complete';
$lang['user:activated_email_content_line1']    = 'Thank you for registering at %s. Before we can activate your account, please complete the registration process by clicking on the following link:';
$lang['user:activated_email_content_line2']    = 'In case your email program does not recognize the above link as, please direct your browser to the following URL and enter the activation code:';

// Reset Pass
$lang['user:reset_pass_email_subject']         = 'Password Reset';
$lang['user:reset_pass_email_body']            = 'Your password at %s has been reset. If you did not request this change, please email us at %s and we will resolve the situation.';

// Profile
$lang['profile_of_title']             = '%s\'s Profile';

$lang['profile_user_details_label']   = 'User Details';
$lang['profile_role_label']           = 'Role';
$lang['profile_registred_on_label']   = 'Registered on';
$lang['profile_last_login_label']     = 'Last login';
$lang['profile_male_label']           = 'Male';
$lang['profile_female_label']         = 'Female';
$lang['user:profile_fields_label']	  = 'Profile Fields';

$lang['profile_not_set_up']           = 'This user does not have a profile set up.';

$lang['profile_edit']                 = 'Edit your profile';

$lang['profile_personal_section']     = 'Personal';

$lang['profile_display_name']         = 'Display Name';
$lang['profile_dob']                  = 'Date of Birth';
$lang['profile_dob_day']              = 'Day';
$lang['profile_dob_month']            = 'Month';
$lang['profile_dob_year']             = 'Year';
$lang['profile_gender']               = 'Gender';
$lang['profile_gender_nt']            = 'Not Telling';
$lang['profile_gender_male']          = 'Male';
$lang['profile_gender_female']        = 'Female';
$lang['profile_bio']                  = 'About me';

$lang['profile_contact_section']      = 'Contact';

$lang['profile_phone']                = 'Phone';
$lang['profile_mobile']               = 'Mobile';
$lang['profile_address']              = 'Address';
$lang['profile_address_line1']        = 'Line #1';
$lang['profile_address_line2']        = 'Line #2';
$lang['profile_address_line3']        = 'Town/City';
$lang['profile_address_postcode']     = 'Post/Zip Code';
$lang['profile_website']              = 'Website';

$lang['profile_api_section']     	  = 'API Access';

$lang['profile_edit_success']         = 'Your profile has been saved.';
$lang['profile_edit_error']           = 'An error occurred.';

// -- Buttons ------------------------------------------------------------------------------------------------

$lang['profile_save_btn']             = 'Save profile';
/* End of file user_lang.php */