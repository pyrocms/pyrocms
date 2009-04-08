<?php

$lang['user_register_header'] 	= 'Registration';
$lang['user_register_step1'] 	= '<strong>Step 1:</strong> Register';
$lang['user_register_step2'] 	= '<strong>Step 2:</strong> Activate';

$lang['user_login_header'] 		= 'Login';

$lang['account_changes_saved'] = 'The changes to your account have been saved successfully.';

$lang['indicates_required'] = 'Indicates required fields';

// -- Registration / Activation / Reset Password ----------------------------------------------------------
$lang['user_full_name'] 	= 'Full Name';
$lang['user_first_name'] 	= 'First Name';
$lang['user_last_name'] 	= 'Last Name';
$lang['user_email'] 		= 'E-mail';
$lang['user_confirm_email'] = 'Confirm E-mail';
$lang['user_password'] 		= 'Password';
$lang['user_confirm_password'] = 'Confirm Password';

$lang['user_level']			= 'User Role';
$lang['user_active']		= 'Active';
$lang['user_lang']			= 'Language';

$lang['user_activation_code'] = 'Activation code';

$lang['user_reset_password_link'] = 'Forgot your password?';

// -- Settings ---------------------------------------------------------------------------------------------

$lang['user_details_section'] = 'Name';
$lang['user_password_section'] = 'Change password';
$lang['user_other_settings_section'] = 'Other settings';

$lang['user_settings_saved'] = 'The settings for your user account have been saved.';

// -- Buttons ----------------------------------------------------------------------------------------------

$lang['user_register_btn']		= 'Register';
$lang['user_activate_btn']		= 'Activate';
$lang['user_reset_pass_btn'] 	= 'Reset Pass';
$lang['user_login_btn'] 		= 'Login';
$lang['user_settings_btn'] 		= 'Save settings';

// -- Errors & Messages ------------------------------------------------------------------------------------

// Register
$lang['user_email_pass_missing'] = 'Email or password fields are not complete.';
$lang['user_email_exists'] = 'The email address you have chosen is already in use with a different user.';
$lang['user_register_reasons'] = 'Join up to access special areas normally restricted. This means your settings will be remembered, more content and less ads.';


// Activation
$lang['user_activation_incorrect']   = 'Activation failed. Please check your details and make sure CAPS LOCK is not on.';
$lang['user_activated_message']   = 'Your account has been activated, you can now log in to your account.';


// Login
$lang['user_already_logged_in'] = 'You are already logged in. Please logout before trying again.';
$lang['user_login_incorrect'] = 'E-mail or password do not match. Please check your login and make sure CAPS LOCK is not on.';
$lang['user_inactive']   = 'The account you are trying to access is currently inactive.<br />Check your e-mail for instructions on how to activate your account - <em>it may be in the junk folder</em>.';


// Logged Out
$lang['user_logged_out']   = 'You have been logged out.';


// Forgot Pass
$lang['user_forgot_incorrect']   = "No account was found with these details.";

$lang['user_password_reset_message']   = "Your password has been reset. You should recieve the email within the next 2 hours. If you don't, it might have gone into your junk mail by accident.";

// Emails ----------------------------------------------------------------------------------------------------

// Activation
$lang['user_activation_email_subject'] = 'Activation Required';
$lang['user_activation_email_body'] = 'Thank you for activting yout account with %s. To log in to the site, please visit the link below:';


$lang['user_activated_email_subject'] = 'Activation Complete';
$lang['user_activated_email_content_line1'] = 'Thank you for registering at %s. Before we can activate your account, please complete the registration process by clicking on the following link:';
$lang['user_activated_email_content_line2'] = 'In case your email program does not recognize the above link as, please direct your browser to the following URL and enter the activation code:';

// Reset Pass
$lang['user_reset_pass_email_subject'] = 'Password Reset';
$lang['user_reset_pass_email_body'] = 'Your password at %s has been reset. If you did not request this change, please email us at %s and we will resolve the situation.';

?>