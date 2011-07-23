<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['user_register_header']                  = 'Registration';
$lang['user_register_step1']                   = '<strong>Step 1:</strong> Register';
$lang['user_register_step2']                   = '<strong>Step 2:</strong> Activate';

$lang['user_login_header']                     = 'Login';

// titles
$lang['user_add_title']                        = 'Add user';
$lang['user_list_title'] 				= 'List users';
$lang['user_inactive_title']                   = 'Inactive users';
$lang['user_active_title']                     = 'Active users';
$lang['user_registred_title']                  = 'Registered Users';

// labels
$lang['user_edit_title']                       = 'Edit user "%s"';
$lang['user_details_label']                    = 'Details';
$lang['user_first_name_label']                 = 'First Name';
$lang['user_last_name_label']                  = 'Last Name';
$lang['user_email_label']                      = 'E-mail';
$lang['user_group_label']                      = 'Group';
$lang['user_activate_label']                   = 'Activate';
$lang['user_password_label']                   = 'Password';
$lang['user_password_confirm_label']           = 'Confirm Password';
$lang['user_name_label']                       = 'Name';
$lang['user_joined_label']                     = 'Joined';
$lang['user_last_visit_label']                 = 'Last visit';
$lang['user_actions_label']                    = 'Actions';
$lang['user_never_label']                      = 'Never';
$lang['user_delete_label']                     = 'Delete';
$lang['user_edit_label']                       = 'Edit';
$lang['user_view_label']                       = 'View';

$lang['user_no_inactives']                     = 'There are no inactive users.';
$lang['user_no_registred']                     = 'There are no registered users.';

$lang['account_changes_saved']                 = 'The changes to your account have been saved successfully.';

$lang['indicates_required']                    = 'Indicates required fields';

// -- Registration / Activation / Reset Password ----------------------------------------------------------

$lang['user_register_title']                   = 'Register';
$lang['user_activate_account_title']           = 'Activate Account';
$lang['user_activate_label']                   = 'Activate';
$lang['user_activated_account_title']          = 'Activated Account';
$lang['user_reset_password_title']             = 'Reset Password';
$lang['user_password_reset_title']             = 'Password Reset';  


$lang['user_error_username']                   = 'The username you selected is already in use';
$lang['user_error_email']                      = 'The email address you entered is already in use';

$lang['user_full_name']                        = 'Full Name';
$lang['user_first_name']                       = 'First Name';
$lang['user_last_name']                        = 'Last Name';
$lang['user_username']                         = 'Username';
$lang['user_display_name']                     = 'Display Name';
$lang['user_email_use'] 					   = 'used to login';
$lang['user_email']                            = 'E-mail';
$lang['user_confirm_email']                    = 'Confirm E-mail';
$lang['user_password']                         = 'Password';
$lang['user_remember']                         = 'Remember Me';
$lang['user_confirm_password']                 = 'Confirm Password';
$lang['user_group_id_label']                   = 'Group ID';

$lang['user_level']                            = 'User Role';
$lang['user_active']                           = 'Active';
$lang['user_lang']                             = 'Language';

$lang['user_activation_code']                  = 'Activation code';

$lang['user_reset_password_link']              = 'Forgot your password?';

$lang['user_activation_code_sent_notice']      = 'An email has been sent to you with your activation code.';
$lang['user_activation_by_admin_notice']       = 'Your registration is awaiting approval by an administrator.';

// -- Settings ---------------------------------------------------------------------------------------------

$lang['user_details_section']                  = 'Name';
$lang['user_password_section']                 = 'Change password';
$lang['user_other_settings_section']           = 'Other settings';

$lang['user_settings_saved_success']           = 'The settings for your user account have been saved.';
$lang['user_settings_saved_error']             = 'An error occurred.';

// -- Buttons ----------------------------------------------------------------------------------------------

$lang['user_register_btn']                     = 'Register';
$lang['user_activate_btn']                     = 'Activate';
$lang['user_reset_pass_btn']                   = 'Reset Pass';
$lang['user_login_btn']                        = 'Login';
$lang['user_settings_btn']                     = 'Save settings';

// -- Errors & Messages ------------------------------------------------------------------------------------

// Create
$lang['user_added_and_activated_success']      = 'New user has been created and activated.';
$lang['user_added_not_activated_success']      = 'New user has been created, the account needs to be activated.';

// Edit
$lang['user_edit_user_not_found_error']        = 'User not found.';
$lang['user_edit_success']                     = 'User successfully updated.';
$lang['user_edit_error']                       = 'Error occurred when trying to update user.';

// Activate
$lang['user_activate_success']                 = '%s users out of %s successfully activated.';
$lang['user_activate_error']                   = 'You need to select users first.';

// Delete
$lang['user_delete_self_error']                = 'You cannot delete yourself!';
$lang['user_mass_delete_success']              = '%s users out of %s successfully deleted.';
$lang['user_mass_delete_error']                = 'You need to select users first.';

// Register
$lang['user_email_pass_missing']               = 'Email or password fields are not complete.';
$lang['user_email_exists']                     = 'The email address you have chosen is already in use with a different user.';
$lang['user_register_reasons']                 = 'Join up to access special areas normally restricted. This means your settings will be remembered, more content and less ads.';


// Activation
$lang['user_activation_incorrect']             = 'Activation failed. Please check your details and make sure CAPS LOCK is not on.';
$lang['user_activated_message']                = 'Your account has been activated, you can now log in to your account.';


// Login
$lang['user_logged_in']                        = 'You have logged in successfully.'; # TODO: Translate this in spanish
$lang['user_already_logged_in']                = 'You are already logged in. Please logout before trying again.';
$lang['user_login_incorrect']                  = 'E-mail or password do not match. Please check your login and make sure CAPS LOCK is not on.';
$lang['user_inactive']                         = 'The account you are trying to access is currently inactive.<br />Check your e-mail for instructions on how to activate your account - <em>it may be in the junk folder</em>.';


// Logged Out
$lang['user_logged_out']                       = 'You have been logged out.';

// Forgot Pass
$lang['user_forgot_incorrect']                 = "No account was found with these details.";

$lang['user_password_reset_message']           = "Your password has been reset. You should recieve the email within the next 2 hours. If you don't, it might have gone into your junk mail by accident.";

// Emails ----------------------------------------------------------------------------------------------------

// Activation
$lang['user_activation_email_subject']         = 'Activation Required';
$lang['user_activation_email_body']            = 'Thank you for activting your account with %s. To log in to the site, please visit the link below:';


$lang['user_activated_email_subject']          = 'Activation Complete';
$lang['user_activated_email_content_line1']    = 'Thank you for registering at %s. Before we can activate your account, please complete the registration process by clicking on the following link:';
$lang['user_activated_email_content_line2']    = 'In case your email program does not recognize the above link as, please direct your browser to the following URL and enter the activation code:';

// Reset Pass
$lang['user_reset_pass_email_subject']         = 'Password Reset';
$lang['user_reset_pass_email_body']            = 'Your password at %s has been reset. If you did not request this change, please email us at %s and we will resolve the situation.';

// Profile
$lang['profile_of_title']             = '%s\'s Profile';

$lang['profile_user_details_label']   = 'User Details';
$lang['profile_role_label']           = 'Role';
$lang['profile_registred_on_label']   = 'Registered on';
$lang['profile_last_login_label']     = 'Last login';
$lang['profile_male_label']           = 'Male';
$lang['profile_female_label']         = 'Female';

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
$lang['profile_address_line3']        = 'Line #3';
$lang['profile_address_postcode']     = 'Post/Zip Code';
$lang['profile_website']              = 'Website';

$lang['profile_messenger_section']    = 'Instant messengers';

$lang['profile_msn_handle']           = 'MSN';
$lang['profile_aim_handle']           = 'AIM';
$lang['profile_yim_handle']           = 'Yahoo! messenger';
$lang['profile_gtalk_handle']         = 'GTalk';

$lang['profile_avatar_section']       = 'Avatar';
$lang['profile_social_section']       = 'Social';

$lang['profile_gravatar']             = 'Gravatar';
$lang['profile_twitter']              = 'Twitter';

$lang['profile_edit_success']         = 'Your profile has been saved.';
$lang['profile_edit_error']           = 'An error occurred.';

// -- Buttons ------------------------------------------------------------------------------------------------

$lang['profile_save_btn']             = 'Save profile';
/* End of file user_lang.php */
/* Location: ./system/cms/modules/users/language/english/user_lang.php */
