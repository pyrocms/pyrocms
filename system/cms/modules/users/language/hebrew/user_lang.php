<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['user:add_field']                        	= 'Add User Profile Field'; #translate
$lang['user:profile_delete_success']           	= 'User profile field deleted successfully'; #translate
$lang['user:profile_delete_failure']            = 'There was a problem with deleting your user profile field'; #translate
$lang['profile_user_basic_data_label']  		= 'Basic Data'; #translate
$lang['profile_company']         	  			= 'Company'; #translate
$lang['profile_updated_on']           			= 'Updated On'; #translate
$lang['user:profile_fields_label']	 		 	= 'Profile Fields'; #translate`

$lang['user:register_header']                  = 'הרשמה';
$lang['user:register_step1']                   = '<strong>שלב 1:</strong> הרשמה';
$lang['user:register_step2']                   = '<strong>שלב 2:</strong> הפעלה';

$lang['user:login_header']                     = 'התחברות';

// titles
$lang['user:add_title']                        = 'הוסף משתמש';
$lang['user:list_title'] 				= 'רשימת משתמשים';
$lang['user:inactive_title']                   = 'משתמשים לא פעילים';
$lang['user:active_title']                     = 'משתמשים פעילים';
$lang['user:registred_title']                  = 'משתמשים רשומים';

// labels
$lang['user:edit_title']                       = 'ערוך משתמש "%s"';
$lang['user:details_label']                    = 'פרטים';
$lang['user:first_name_label']                 = 'שם';
$lang['user:last_name_label']                  = 'משפחה';
$lang['user:group_label']                      = 'קבוצה';
$lang['user:activate_label']                   = 'הפעל';
$lang['user:password_label']                   = 'סיסמה';
$lang['user:password_confirm_label']           = 'וידוי סיסמה';
$lang['user:name_label']                       = 'שם';
$lang['user:joined_label']                     = 'הצתרף';
$lang['user:last_visit_label']                 = 'ביקור אחרון';
$lang['user:never_label']                      = 'אף פעם';

$lang['user:no_inactives']                     = 'אין משתמשים לא פעילים.';
$lang['user:no_registred']                     = 'אין משתמשים רשומים.';

$lang['account_changes_saved']                 = 'שינויים לחשבונך נשמרו בהצלחה.';

$lang['indicates_required']                    = 'מציינת שדות חובה';

// -- Registration / Activation / Reset Password ----------------------------------------------------------

$lang['user:send_activation_email']            = 'Send Activation Email'; #translate
$lang['user:do_not_activate']                  = 'Inactive'; #translate
$lang['user:register_title']                   = 'הרשם';
$lang['user:activate_account_title']           = 'הפעל חשבון';
$lang['user:activate_label']                   = 'הפעל';
$lang['user:activated_account_title']          = 'החשבון הופעל';
$lang['user:reset_password_title']             = 'חדש סיסמה';
$lang['user:password_reset_title']             = 'הסיסמה חודשה';


$lang['user:error_username']                   = 'שם משתמש שבחרתם כבר בשימוש';
$lang['user:error_email']                      = 'כתובת הדואר האלקטרוני שרשמתם כבר בשימוש';

$lang['user:full_name']                        = 'שם מלא';
$lang['user:first_name']                       = 'שם';
$lang['user:last_name']                        = 'משפחה';
$lang['user:username']                         = 'שם משתמש';
$lang['user:display_name']                     = 'הצג שם';
$lang['user:email_use'] 					   = 'used to login'; #translate
$lang['user:remember']                         = 'זכור אותי';
$lang['user:group_id_label']                   = 'ID של הקבוצה'; // #TRANSLATE #TODO: Translate this into Spanish

$lang['user:level']                            = 'תפקיד המשתמש';
$lang['user:active']                           = 'פעיל';
$lang['user:lang']                             = 'שפה';

$lang['user:activation_code']                  = 'קוד הפעלה';

$lang['user:reset_instructions']			   = 'Enter your email address or username'; #translate
$lang['user:reset_password_link']              = 'שכחת סיסמה?';

$lang['user:activation_code_sent_notice']      = 'אימייל עם קוד הפעלה נשלח אליך.';
$lang['user:activation_by_admin_notice']       = 'הרשמתך מחכה לאישורו של המנהל.';
$lang['user:registration_disabled']            = 'Sorry, but the user registration is disabled.'; #translate

// -- Settings ---------------------------------------------------------------------------------------------

$lang['user:details_section']                  = 'שם';
$lang['user:password_section']                 = 'שנה סיסמה';
$lang['user:other_settings_section']           = 'הגדרות אחרות';

$lang['user:settings_saved_success']           = 'הגדרות חשבונך נשמרו בהצלחה.';
$lang['user:settings_saved_error']             = 'אירעה שגיעה.';

// -- Buttons ----------------------------------------------------------------------------------------------

$lang['user:register_btn']                     = 'הרשם';
$lang['user:activate_btn']                     = 'הפעל';
$lang['user:reset_pass_btn']                   = 'חדש סיסמה';
$lang['user:login_btn']                        = 'התחבר';
$lang['user:settings_btn']                     = 'שמור הגדרות';

// -- Errors & Messages ------------------------------------------------------------------------------------

// Create
$lang['user:added_and_activated_success']      = 'משתמש חדש נוצר והופעל בהצלחה.';
$lang['user:added_not_activated_success']      = 'משתמש חדש נוצר אך החשבון מחכה להפעלה.';

// Edit
$lang['user:edit_user_not_found_error']        = 'המשתמש לא נמצא.';
$lang['user:edit_success']                     = 'משתמש חודש בהצלחה.';
$lang['user:edit_error']                       = 'אירעה שגיעה בעת חידוש המשתמש.';

// Activate
$lang['user:activate_success']                 = '%s משתמשים מתוך %s הופעלו בהצלחה.';
$lang['user:activate_error']                   = 'עליך קודם לבחור מחתמשים.';

// Delete
$lang['user:delete_self_error']                = 'לא ניתן למחוק את עצמך!';
$lang['user:mass_delete_success']              = '%s משתמשים מתוך %s נמחקו בהצלחה.';
$lang['user:mass_delete_error']                = 'עליך קודם לבחור משתמשים.';

// Register
$lang['user:email_pass_missing']               = 'חסר שדה אימייל או סיסמה.';
$lang['user:email_exists']                     = 'כתובת האימייל שבחרתם כבר בשימוש.';
$lang['user:register_error']				   = 'We think you are a bot. If we are mistaken please accept our apologies.'; #translate
$lang['user:register_reasons']                 = 'הצטרף למעלה כדי לגשת אזורים מיוחדים מוגבלים בדרך כלל. משמעות הדבר היא ההגדרות שלך ייזכר, יותר תוכן פחות פרסומת .';


// Activation
$lang['user:activation_incorrect']             = 'ההפעלה נכשלה. אנא בדוק את הפרטים שלך ולוודא CAPS LOCK אינו פועל.';
$lang['user:activated_message']                = 'החשבון שלך הופעל, עכשיו אתה יכול להיכנס לחשבון שלך .';


// Login
$lang['user:logged_in']                        = 'התחברתם בהצלחה.'; # TODO: Translate this in spanish
$lang['user:already_logged_in']                = 'הנכם כבר מחוברים. יש קודם להתנתק ולהתחבר מחדש.';
$lang['user:login_incorrect']                  = 'אימייל או סיסמה אינם מתאימים. אנא בדוק את פרטי הכניסה שלך ולוודא CAPS LOCK אינו פועל.';
$lang['user:inactive']                         = 'את החשבון שאתה מנסה לגשת אינו פעיל כרגע. <br /> בדוק את הדואר האלקטרוני שלך כדי לקבל הוראות כיצד להפעיל את החשבון שלך - <em>זה יכול להיות בתיקיית הזבל</em>.';


// Logged Out
$lang['user:logged_out']                       = 'התנתקתם בהצלחה.';

// Forgot Pass
$lang['user:forgot_incorrect']                 = "אף חשבון לא נמצא עם פרטים הללו.";

$lang['user:password_reset_message']           = "הסיסמה שלך אופסה. אתה אמור לקבל את הדואל בתוך 2 שעות הקרובות. אם לא, זה יכול ללכת לתוך דואר הזבל שלך בטעות.";

// Emails ----------------------------------------------------------------------------------------------------

// Activation
$lang['user:activation_email_subject']         = 'ההפעלה נדרשת';
$lang['user:activation_email_body']            = 'תודה על הפעלת החשבון עם %s. כדי להתחבר לאתר עכוב אחרי הקישור למטה:';


$lang['user:activated_email_subject']          = 'ההפעלה הסתיימה בהצלחה';
$lang['user:activated_email_content_line1']    = 'תודה על הרשמה ל %s. לפני שנוכל להפעיל את החשבון שלך, בבקשה להשלים את הליך הרישום על ידי לחיצה על הקישור הבא:';
$lang['user:activated_email_content_line2']    = 'במקרה של תוכנית הדואל שלך לא מזהה את הקישור לעיל, בבקשה להנחות את הדפדפן שלכם לכתובת הבאה והזן את קוד ההפעלה:';

// Reset Pass
$lang['user:reset_pass_email_subject']         = 'הסיסמה אופסה';
$lang['user:reset_pass_email_body']            = 'סיסמתכם ב %s אופסה. אם לא ביקשת שינוי זה, אנא שלח אימייל ל %s ואנו נפתור את המצב.';

// Profile
$lang['profile_of_title']             = 'הפרופיל של %s';

$lang['profile_user_details_label']   = 'פרטי משתמש';
$lang['profile_role_label']           = 'תפקיד';
$lang['profile_registred_on_label']   = 'נרשם ב';
$lang['profile_last_login_label']     = 'תאריך כניסה אחרונה';
$lang['profile_male_label']           = 'זכר';
$lang['profile_female_label']         = 'נקבה';

$lang['profile_not_set_up']           = 'אין סט אפ למשתמש זה';

$lang['profile_edit']                 = 'ערוך פרופיל';

$lang['profile_personal_section']     = 'אישי';

$lang['profile_display_name']         = 'הצג שם';
$lang['profile_dob']                  = 'תאריך לידה';
$lang['profile_dob_day']              = 'יום';
$lang['profile_dob_month']            = 'חודש';
$lang['profile_dob_year']             = 'שנה';
$lang['profile_gender']               = 'מין';
$lang['profile_gender_nt']            = 'Not Telling'; #translate
$lang['profile_gender_male']          = 'Male'; #translate
$lang['profile_gender_female']        = 'Female'; #translate
$lang['profile_bio']                  = 'קצי עלי';

$lang['profile_contact_section']      = 'יצירת קשר';

$lang['profile_phone']                = 'טלפון';
$lang['profile_mobile']               = 'נייד';
$lang['profile_address']              = 'כתובת';
$lang['profile_address_line1']        = 'שורה #1';
$lang['profile_address_line2']        = 'שורה #2';
$lang['profile_address_line3']        = 'שורה #3';
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

$lang['profile_edit_success']         = 'הפרופיל נשמר בהצלחה.';
$lang['profile_edit_error']           = 'אירעה שגיאה. הפרופיל לא נשמר.';

// -- Buttons ------------------------------------------------------------------------------------------------

$lang['profile_save_btn']             = 'שמור פרופיל';

/* End of file user_lang.php */