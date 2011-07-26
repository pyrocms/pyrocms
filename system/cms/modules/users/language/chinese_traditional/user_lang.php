<?php

$lang['user_register_header'] 			= '註冊';
$lang['user_register_step1'] 			= '<strong>步驟一：</strong> 註冊';
$lang['user_register_step2'] 			= '<strong>步驟二：</strong> 啟動';

$lang['user_login_header'] 				= '登入';

// titles
$lang['user_add_title'] 				= '新增用戶';
$lang['user_list_title'] 				= 'List users'; #translate
$lang['user_inactive_title'] 			= '已禁用用戶';
$lang['user_active_title'] 				= '已啟動用戶';
$lang['user_registred_title'] 			= '已註冊用戶';

// labels
$lang['user_edit_title'] 				= '編輯用戶 "%s"';
$lang['user_details_label'] 			= '內容';
$lang['user_first_name_label'] 			= '大名';
$lang['user_last_name_label'] 			= '姓氏';
$lang['user_email_label'] 				= 'E-mail';
$lang['user_group_label'] 				= '群組';
$lang['user_activate_label'] 			= '啟動';
$lang['user_password_label'] 			= '密碼';
$lang['user_password_confirm_label'] 	= '再次確認密碼';
$lang['user_name_label'] 				= '名稱';
$lang['user_joined_label'] 				= '已加入';
$lang['user_last_visit_label'] 			= '最後訪問';
$lang['user_actions_label'] 			= '操作';
$lang['user_never_label'] 				= '從不';
$lang['user_delete_label'] 				= '刪除';
$lang['user_edit_label'] 				= '編輯';
$lang['user_view_label'] 				= '查看';

$lang['user_no_inactives'] 				= '沒有任何已禁用的用戶';
$lang['user_no_registred'] 				= '沒有任何已註冊的用戶';

$lang['account_changes_saved'] 			= '您的更改的用戶資料已經成功儲存。';

$lang['indicates_required'] 			= '代表必填欄位';

// -- Registration / Activation / Reset Password ----------------------------------------------------------

$lang['user_register_title'] 			= '註冊';
$lang['user_activate_account_title'] 	= '啟動帳號';
$lang['user_activate_label'] 			= '啟動';
$lang['user_activated_account_title'] 	= '已啟動帳號';
$lang['user_reset_password_title'] 		= '重設密碼';
$lang['user_password_reset_title'] 		= '密碼重設';  


$lang['user_error_username'] 			= '您選擇的用戶名已經被使用了。';
$lang['user_error_email'] 				= '您輸入的 email 已經被使用了。';

$lang['user_full_name'] 				= '全名';
$lang['user_first_name'] 				= '大名';
$lang['user_last_name'] 				= '姓氏';
$lang['user_username'] 					= '用戶名稱';
$lang['user_display_name']				= '顯示名稱';
$lang['user_email_use'] 					   = 'used to login'; #translate
$lang['user_email'] 					= 'E-mail';
$lang['user_confirm_email'] 			= '確認 E-mail';
$lang['user_password'] 					= '密碼';
$lang['user_remember'] 					= '記住我';
$lang['user_confirm_password'] 			= '確認密碼';
$lang['user_group_id_label']			= '群組 ID';

$lang['user_level']						= '用戶身分(Role)';
$lang['user_active']					= '啟動';
$lang['user_lang']						= '語言';

$lang['user_activation_code'] 			= '啟動碼';

$lang['user_reset_password_link'] 		= '忘記密碼';

$lang['user_activation_code_sent_notice']	= '內含啟動碼的電子郵件已經寄給您了。';
$lang['user_activation_by_admin_notice'] 	= '您的註冊資料正在等候管理員的審核。';

// -- Settings ---------------------------------------------------------------------------------------------

$lang['user_details_section'] 			= '名稱';
$lang['user_password_section'] 			= '更改密碼';
$lang['user_other_settings_section'] 	= '其他設定';

$lang['user_settings_saved_success'] 	= '您的用戶設定已經儲存。';
$lang['user_settings_saved_error'] 		= '發生了錯誤';

// -- Buttons ----------------------------------------------------------------------------------------------

$lang['user_register_btn']				= '註冊';
$lang['user_activate_btn']				= '啟動';
$lang['user_reset_pass_btn'] 			= '重設密碼';
$lang['user_login_btn'] 				= '登入';
$lang['user_settings_btn'] 				= '儲存設定';

// -- Errors & Messages ------------------------------------------------------------------------------------

// Create
$lang['user_added_and_activated_success'] 		= '新用戶已經建立並啟動';
$lang['user_added_not_activated_success'] 		= '新用戶已經建立，但仍需要被啟動。';

// Edit
$lang['user_edit_user_not_found_error'] 		= '找不到用戶';
$lang['user_edit_success'] 						= '用戶更新成功。';
$lang['user_edit_error'] 						= '更新用戶時發生了問題。';

// Activate
$lang['user_activate_success'] 					= '%s 個用戶已啟動(共選擇 %s 個用戶)';
$lang['user_activate_error'] 					= '請先選擇用戶';

// Delete
$lang['user_delete_self_error'] 				= '不能刪除自己';
$lang['user_mass_delete_success'] 				= '%s 個用戶已刪除(共選擇 %s 個用戶)。';
$lang['user_mass_delete_error'] 				= '請先選擇用戶';

// Register
$lang['user_email_pass_missing'] 				= 'Email 或密碼欄位尚未完成。';
$lang['user_email_exists'] 						= '您選擇的電子郵件已經被另一個用戶所使用。';
$lang['user_register_reasons'] 					= '加入即可存取特定網站專區。這及表示網站將記住您的設定，更多的內容會提供給您。';


// Activation
$lang['user_activation_incorrect']   			= '啟動失敗。請檢查您的資料，並確認大寫鍵沒有被開啟。';
$lang['user_activated_message']   				= '您的帳號已啟動，並可開始登入。';


// Login
$lang['user_logged_in']							= 'You have logged in successfully.'; #translate
$lang['user_already_logged_in'] 				= '您已經登入，再試一次前請先登出。';
$lang['user_login_incorrect'] 					= 'E-mail 或密碼沒有匹配。請檢查您的登入資料，並確認大寫鍵沒有被開啟。';
$lang['user_inactive']   						= '您正嘗試使用的帳戶目前沒有啟動。<br />請檢查您的 email 並閱讀關於啟動帳戶的手續。<em>信件有可能被誤分發到垃圾信件夾</em>。';


// Logged Out
$lang['user_logged_out']   						= '您已經登入了。';

// Forgot Pass
$lang['user_forgot_incorrect']   				= "沒有找到和這些資料有關的帳號。";

$lang['user_password_reset_message']   			= "您的密碼已經重新設定。在兩個小時應該會收到電子郵件，如果沒有，也許是被誤認為是垃圾郵件，請也檢查您的垃圾信件夾。";

// Emails ----------------------------------------------------------------------------------------------------

// Activation
$lang['user_activation_email_subject'] 			= '需要啟動您的帳戶';
$lang['user_activation_email_body'] 			= '謝謝您使用 %s 並開始啟動您的帳號。要登入網站，請點選下列連結：';


$lang['user_activated_email_subject'] 			= '帳戶啟動完成';
$lang['user_activated_email_content_line1'] 	= '謝謝您在 %s 註冊成為會員。在啟動您的帳戶以前，請先點選下方連結，以完成註冊的最後程序。';
$lang['user_activated_email_content_line2'] 	= '如果您的收信程式無法辨別上方連結，那麼請使用瀏覽器開啟下方網址，並輸入啟動碼：';


// Reset Pass
$lang['user_reset_pass_email_subject'] 			= '重新設定密碼';
$lang['user_reset_pass_email_body'] 			= '您在 %s 的密碼已重新設定。如果您並沒有請求這項改變，請來信 %s，我們將會為您檢查這個問題。';

// Profile
$lang['profile_of_title'] 				= '%s\'s 個人簡介';

$lang['profile_user_details_label'] 	= '用戶資訊';
$lang['profile_role_label'] 			= '用戶身分';
$lang['profile_registred_on_label'] 	= '用戶註冊於';
$lang['profile_last_login_label'] 		= '最後登入於';
$lang['profile_male_label'] 			= '男性';
$lang['profile_female_label'] 			= '女性';

$lang['profile_not_set_up'] 			= '此用戶尚未設定個人簡介。';

$lang['profile_edit'] 					= '編輯個人簡介';

$lang['profile_personal_section'] 		= '個人資訊';

$lang['profile_display_name']			= '顯示名稱';  
$lang['profile_dob']					= '出生日期';
$lang['profile_dob_day']				= '日';
$lang['profile_dob_month']				= '月';
$lang['profile_dob_year']				= '年';
$lang['profile_gender']					= '性別';
$lang['profile_gender_nt']            = 'Not Telling'; #translate
$lang['profile_gender_male']          = 'Male'; #translate
$lang['profile_gender_female']        = 'Female'; #translate
$lang['profile_bio']					= '關於我';

$lang['profile_contact_section'] 		= '聯絡資訊';

$lang['profile_phone']					= '電話';
$lang['profile_mobile']					= '手機';
$lang['profile_address']				= '地址';
$lang['profile_address_line1'] 			= '地址 #1';
$lang['profile_address_line2'] 			= '地址 #2';
$lang['profile_address_line3'] 			= '地址 #3';
$lang['profile_address_postcode'] 		= '郵遞區號';
$lang['profile_website']				= '網站';

$lang['profile_messenger_section'] 		= '即時通訊';

$lang['profile_msn_handle'] 			= 'MSN';
$lang['profile_aim_handle'] 			= 'AIM';
$lang['profile_yim_handle'] 			= 'Yahoo! messenger';
$lang['profile_gtalk_handle'] 			= 'GTalk';

$lang['profile_avatar_section'] 		= '頭像工具';
$lang['profile_social_section'] 		= '社交工具';

$lang['profile_gravatar'] 				= 'Gravatar';
$lang['profile_twitter'] 				= 'Twitter';

$lang['profile_edit_success'] 			= '您的個人簡介已經儲存。';
$lang['profile_edit_error'] 			= '發生了問題';

// -- Buttons ------------------------------------------------------------------------------------------------

$lang['profile_save_btn'] 				= '儲存個人簡介';
