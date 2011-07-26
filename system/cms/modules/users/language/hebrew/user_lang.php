<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['user_register_header']                  = 'הרשמה';
$lang['user_register_step1']                   = '<strong>שלב 1:</strong> הרשמה';
$lang['user_register_step2']                   = '<strong>שלב 2:</strong> הפעלה';

$lang['user_login_header']                     = 'התחברות';

// titles
$lang['user_add_title']                        = 'הוסף משתמש';
$lang['user_list_title'] 				= 'רשימת משתמשים';
$lang['user_inactive_title']                   = 'משתמשים לא פעילים';
$lang['user_active_title']                     = 'משתמשים פעילים';
$lang['user_registred_title']                  = 'משתמשים רשומים';

// labels
$lang['user_edit_title']                       = 'ערוך משתמש "%s"';
$lang['user_details_label']                    = 'פרטים';
$lang['user_first_name_label']                 = 'שם';
$lang['user_last_name_label']                  = 'משפחה';
$lang['user_email_label']                      = 'E-mail';
$lang['user_group_label']                      = 'קבוצה';
$lang['user_activate_label']                   = 'הפעל';
$lang['user_password_label']                   = 'סיסמה';
$lang['user_password_confirm_label']           = 'וידוי סיסמה';
$lang['user_name_label']                       = 'שם';
$lang['user_joined_label']                     = 'הצתרף';
$lang['user_last_visit_label']                 = 'ביקור אחרון';
$lang['user_actions_label']                    = 'פעולות';
$lang['user_never_label']                      = 'אף פעם';
$lang['user_delete_label']                     = 'מחק';
$lang['user_edit_label']                       = 'ערוך';
$lang['user_view_label']                       = 'הצג';

$lang['user_no_inactives']                     = 'אין משתמשים לא פעילים.';
$lang['user_no_registred']                     = 'אין משתמשים רשומים.';

$lang['account_changes_saved']                 = 'שינויים לחשבונך נשמרו בהצלחה.';

$lang['indicates_required']                    = 'מציינת שדות חובה';

// -- Registration / Activation / Reset Password ----------------------------------------------------------

$lang['user_register_title']                   = 'הרשם';
$lang['user_activate_account_title']           = 'הפעל חשבון';
$lang['user_activate_label']                   = 'הפעל';
$lang['user_activated_account_title']          = 'החשבון הופעל';
$lang['user_reset_password_title']             = 'חדש סיסמה';
$lang['user_password_reset_title']             = 'הסיסמה חודשה';  


$lang['user_error_username']                   = 'שם משתמש שבחרתם כבר בשימוש';
$lang['user_error_email']                      = 'כתובת הדואר האלקטרוני שרשמתם כבר בשימוש';

$lang['user_full_name']                        = 'שם מלא';
$lang['user_first_name']                       = 'שם';
$lang['user_last_name']                        = 'משפחה';
$lang['user_username']                         = 'שם משתמש';
$lang['user_display_name']                     = 'הצג שם';
$lang['user_email_use'] 					   = 'used to login'; #translate
$lang['user_email']                            = 'E-mail';
$lang['user_confirm_email']                    = 'וידוי E-mail';
$lang['user_password']                         = 'סיסמה';
$lang['user_remember']                         = 'זכור אותי';
$lang['user_confirm_password']                 = 'וידוי סיסמה';
$lang['user_group_id_label']                   = 'ID של הקבוצה'; // #TRANSLATE #TODO: Translate this into Spanish

$lang['user_level']                            = 'תפקיד המשתמש';
$lang['user_active']                           = 'פעיל';
$lang['user_lang']                             = 'שפה';

$lang['user_activation_code']                  = 'קוד הפעלה';

$lang['user_reset_password_link']              = 'שכחת סיסמה?';

$lang['user_activation_code_sent_notice']      = 'אימייל עם קוד הפעלה נשלח אליך.';
$lang['user_activation_by_admin_notice']       = 'הרשמתך מחכה לאישורו של המנהל.';

// -- Settings ---------------------------------------------------------------------------------------------

$lang['user_details_section']                  = 'שם';
$lang['user_password_section']                 = 'שנה סיסמה';
$lang['user_other_settings_section']           = 'הגדרות אחרות';

$lang['user_settings_saved_success']           = 'הגדרות חשבונך נשמרו בהצלחה.';
$lang['user_settings_saved_error']             = 'אירעה שגיעה.';

// -- Buttons ----------------------------------------------------------------------------------------------

$lang['user_register_btn']                     = 'הרשם';
$lang['user_activate_btn']                     = 'הפעל';
$lang['user_reset_pass_btn']                   = 'חדש סיסמה';
$lang['user_login_btn']                        = 'התחבר';
$lang['user_settings_btn']                     = 'שמור הגדרות';

// -- Errors & Messages ------------------------------------------------------------------------------------

// Create
$lang['user_added_and_activated_success']      = 'משתמש חדש נוצר והופעל בהצלחה.';
$lang['user_added_not_activated_success']      = 'משתמש חדש נוצר אך החשבון מחכה להפעלה.';

// Edit
$lang['user_edit_user_not_found_error']        = 'המשתמש לא נמצא.';
$lang['user_edit_success']                     = 'משתמש חודש בהצלחה.';
$lang['user_edit_error']                       = 'אירעה שגיעה בעת חידוש המשתמש.';

// Activate
$lang['user_activate_success']                 = '%s משתמשים מתוך %s הופעלו בהצלחה.';
$lang['user_activate_error']                   = 'עליך קודם לבחור מחתמשים.';

// Delete
$lang['user_delete_self_error']                = 'לא ניתן למחוק את עצמך!';
$lang['user_mass_delete_success']              = '%s משתמשים מתוך %s נמחקו בהצלחה.';
$lang['user_mass_delete_error']                = 'עליך קודם לבחור משתמשים.';

// Register
$lang['user_email_pass_missing']               = 'חסר שדה אימייל או סיסמה.';
$lang['user_email_exists']                     = 'כתובת האימייל שבחרתם כבר בשימוש.';
$lang['user_register_reasons']                 = 'הצטרף למעלה כדי לגשת אזורים מיוחדים מוגבלים בדרך כלל. משמעות הדבר היא ההגדרות שלך ייזכר, יותר תוכן פחות פרסומת .';


// Activation
$lang['user_activation_incorrect']             = 'ההפעלה נכשלה. אנא בדוק את הפרטים שלך ולוודא CAPS LOCK אינו פועל.';
$lang['user_activated_message']                = 'החשבון שלך הופעל, עכשיו אתה יכול להיכנס לחשבון שלך .';


// Login
$lang['user_logged_in']                        = 'התחברתם בהצלחה.'; # TODO: Translate this in spanish
$lang['user_already_logged_in']                = 'הנכם כבר מחוברים. יש קודם להתנתק ולהתחבר מחדש.';
$lang['user_login_incorrect']                  = 'אימייל או סיסמה אינם מתאימים. אנא בדוק את פרטי הכניסה שלך ולוודא CAPS LOCK אינו פועל.';
$lang['user_inactive']                         = 'את החשבון שאתה מנסה לגשת אינו פעיל כרגע. <br /> בדוק את הדואר האלקטרוני שלך כדי לקבל הוראות כיצד להפעיל את החשבון שלך - <em>זה יכול להיות בתיקיית הזבל</em>.';


// Logged Out
$lang['user_logged_out']                       = 'התנתקתם בהצלחה.';

// Forgot Pass
$lang['user_forgot_incorrect']                 = "אף חשבון לא נמצא עם פרטים הללו.";

$lang['user_password_reset_message']           = "הסיסמה שלך אופסה. אתה אמור לקבל את הדואל בתוך 2 שעות הקרובות. אם לא, זה יכול ללכת לתוך דואר הזבל שלך בטעות.";

// Emails ----------------------------------------------------------------------------------------------------

// Activation
$lang['user_activation_email_subject']         = 'ההפעלה נדרשת';
$lang['user_activation_email_body']            = 'תודה על הפעלת החשבון עם %s. כדי להתחבר לאתר עכוב אחרי הקישור למטה:';


$lang['user_activated_email_subject']          = 'ההפעלה הסתיימה בהצלחה';
$lang['user_activated_email_content_line1']    = 'תודה על הרשמה ל %s. לפני שנוכל להפעיל את החשבון שלך, בבקשה להשלים את הליך הרישום על ידי לחיצה על הקישור הבא:';
$lang['user_activated_email_content_line2']    = 'במקרה של תוכנית הדואל שלך לא מזהה את הקישור לעיל, בבקשה להנחות את הדפדפן שלכם לכתובת הבאה והזן את קוד ההפעלה:';

// Reset Pass
$lang['user_reset_pass_email_subject']         = 'הסיסמה אופסה';
$lang['user_reset_pass_email_body']            = 'סיסמתכם ב %s אופסה. אם לא ביקשת שינוי זה, אנא שלח אימייל ל %s ואנו נפתור את המצב.';

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
/* Location: ./system/cms/modules/users/language/hebrew/user_lang.php */
