<?php
/**
 * Chinese Simpplified translation.
 *
 * @author		Kefeng DENG
 * @package		PyroCMS
 * @subpackage 	Users Module
 * @category	Modules
 * @link		http://pyrocms.com
 * @since		2012-06-22
 * @version		1.0
 */

$lang['user:add_field']                        	= '添加用户简介栏目'; #translate
$lang['user:profile_delete_success']           	= '用户简介栏目删除成功'; #translate
$lang['user:profile_delete_failure']            = '无法删除用户简介栏目'; #translate
$lang['user:profile_user_basic_data_label']  	= '基本资料'; #translate
$lang['user:profile_company']         	  		= '公司'; #translate
$lang['user:profile_updated_on']           		= '最近更新'; #translate
$lang['user:profile_fields_label']	 		 	= '简介栏目'; #translate`

$lang['user:register_header'] 			= '註冊';
$lang['user:register_step1'] 			= '<strong>步骤一：</strong> 注册';
$lang['user:register_step2'] 			= '<strong>步骤二：</strong> 激活';

$lang['user:login_header'] 				= '登入';

// titles
$lang['user:add_title'] 				= '新增用戶';
$lang['user:list_title'] 				= '用戶列表';
$lang['user:inactive_title'] 			= '已禁用用戶';
$lang['user:active_title'] 				= '已啟動用戶';
$lang['user:registred_title'] 			= '已註冊用戶';

// labels
$lang['user:edit_title'] 				= '編輯用戶 "%s"';
$lang['user:details_label'] 			= '內容';
$lang['user:first_name_label'] 			= '大名';
$lang['user:last_name_label'] 			= '姓氏';
$lang['user:group_label'] 				= '群組';
$lang['user:activate_label'] 			= '啟動';
$lang['user:password_label'] 			= '密碼';
$lang['user:password_confirm_label'] 	= '再次確認密碼';
$lang['user:name_label'] 				= '名稱';
$lang['user:joined_label'] 				= '已加入';
$lang['user:last_visit_label'] 			= '最後訪問';
$lang['user:never_label'] 				= '從不';

$lang['user:no_inactives'] 				= '沒有任何已禁用的用戶';
$lang['user:no_registred'] 				= '沒有任何已註冊的用戶';

$lang['account_changes_saved'] 			= '您的更改的用戶資料已經成功儲存。';

$lang['indicates_required'] 			= '代表必填欄位';

// -- Registration / Activation / Reset Password ----------------------------------------------------------

$lang['user:register_title'] 			= '註冊';
$lang['user:activate_account_title'] 	= '啟動帳號';
$lang['user:activate_label'] 			= '啟動';
$lang['user:activated_account_title'] 	= '已啟動帳號';
$lang['user:reset_password_title'] 		= '重設密碼';
$lang['user:password_reset_title'] 		= '密碼重設';

$lang['user:error_username'] 			= '您選擇的用戶名已經被使用了。';
$lang['user:error_email'] 				= '您輸入的 email 已經被使用了。';

$lang['user:full_name'] 				= '全名';
$lang['user:first_name'] 				= '大名';
$lang['user:last_name'] 				= '姓氏';
$lang['user:username'] 					= '用戶名稱';
$lang['user:display_name']				= '顯示名稱';
$lang['user:email_use'] 				= '用來登入';
$lang['user:email'] 					= 'E-mail';
$lang['user:confirm_email'] 			= '確認 E-mail';
$lang['user:password'] 					= '密碼';
$lang['user:remember'] 					= '記住我';
$lang['user:group_id_label']			= '群組 ID';

$lang['user:level']						= '用戶身分(Role)';
$lang['user:active']					= '啟動';
$lang['user:lang']						= '語言';

$lang['user:activation_code'] 			= '啟動碼';

$lang['user:reset_instructions']		= '請輸入您的 email 或 用戶名稱';
$lang['user:reset_password_link'] 		= '忘記密碼';

$lang['user:activation_code_sent_notice']	= '內含啟動碼的電子郵件已經寄給您了。';
$lang['user:activation_by_admin_notice'] 	= '您的註冊資料正在等候管理員的審核。';
$lang['user:registration_disabled']            = '不好意思，本网站不能注册用户。.'; #translate

// -- Settings ---------------------------------------------------------------------------------------------

$lang['user:details_section'] 			= '名稱';
$lang['user:password_section'] 			= '更改密碼';
$lang['user:other_settings_section'] 	= '其他設定';

$lang['user:settings_saved_success'] 	= '您的用戶設定已經儲存。';
$lang['user:settings_saved_error'] 		= '發生了錯誤';

// -- Buttons ----------------------------------------------------------------------------------------------

$lang['user:register_btn']				= '註冊';
$lang['user:activate_btn']				= '啟動';
$lang['user:reset_pass_btn'] 			= '重設密碼';
$lang['user:login_btn'] 				= '登入';
$lang['user:settings_btn'] 				= '儲存設定';

// -- Errors & Messages ------------------------------------------------------------------------------------

// Create
$lang['user:added_and_activated_success'] 		= '新用戶已經建立並啟動';
$lang['user:added_not_activated_success'] 		= '新用戶已經建立，但仍需要被啟動。';

// Edit
$lang['user:edit_user_not_found_error'] 		= '找不到用戶';
$lang['user:edit_success'] 						= '用戶更新成功。';
$lang['user:edit_error'] 						= '更新用戶時發生了問題。';

// Activate
$lang['user:activate_success'] 					= '%s 個用戶已啟動(共選擇 %s 個用戶)';
$lang['user:activate_error'] 					= '請先選擇用戶';

// Delete
$lang['user:delete_self_error'] 				= '不能刪除自己';
$lang['user:mass_delete_success'] 				= '%s 個用戶已刪除(共選擇 %s 個用戶)。';
$lang['user:mass_delete_error'] 				= '請先選擇用戶';

// Register
$lang['user:email_pass_missing'] 				= 'Email 或密碼欄位尚未完成。';
$lang['user:email_exists'] 						= '您選擇的電子郵件已經被另一個用戶所使用。';
$lang['user:register_error']				    = '检测到您在使用机器人注册！如果我们有错，请介绍我们的道歉.'; #translate
$lang['user:register_reasons'] 					= '加入即可存取特定網站專區。這及表示網站將記住您的設定，更多的內容會提供給您。';

// Activation
$lang['user:activation_incorrect']   			= '啟動失敗。請檢查您的資料，並確認大寫鍵沒有被開啟。';
$lang['user:activated_message']   				= '您的帳號已啟動，並可開始登入。';

// Login
$lang['user:logged_in']							= '您已經成功的登入了。';
$lang['user:already_logged_in'] 				= '您已經登入，再試一次前請先登出。';
$lang['user:login_incorrect'] 					= 'E-mail 或密碼沒有匹配。請檢查您的登入資料，並確認大寫鍵沒有被開啟。';
$lang['user:inactive']   						= '您正嘗試使用的帳戶目前沒有啟動。<br />請檢查您的 email 並閱讀關於啟動帳戶的手續。<em>信件有可能被誤分發到垃圾信件夾</em>。';

// Logged Out
$lang['user:logged_out']   						= '您已經登入了。';

// Forgot Pass
$lang['user:forgot_incorrect']   				= "沒有找到和這些資料有關的帳號。";

$lang['user:password_reset_message']   			= "您的密碼已經重新設定。在兩個小時應該會收到電子郵件，如果沒有，也許是被誤認為是垃圾郵件，請也檢查您的垃圾信件夾。";

// Emails ----------------------------------------------------------------------------------------------------

// Activation
$lang['user:activation_email_subject'] 			= '需要啟動您的帳戶';
$lang['user:activation_email_body'] 			= '謝謝您使用 %s 並開始啟動您的帳號。要登入網站，請點選下列連結：';

$lang['user:activated_email_subject'] 			= '帳戶啟動完成';
$lang['user:activated_email_content_line1'] 	= '謝謝您在 %s 註冊成為會員。在啟動您的帳戶以前，請先點選下方連結，以完成註冊的最後程序。';
$lang['user:activated_email_content_line2'] 	= '如果您的收信程式無法辨別上方連結，那麼請使用瀏覽器開啟下方網址，並輸入啟動碼：';

// Reset Pass
$lang['user:reset_pass_email_subject'] 			= '重新設定密碼';
$lang['user:reset_pass_email_body'] 			= '您在 %s 的密碼已重新設定。如果您並沒有請求這項改變，請來信 %s，我們將會為您檢查這個問題。';

// Profile
$lang['user:profile_of_title'] 				= '%s\'s 個人簡介';

$lang['user:profile_user_details_label'] 	= '用戶資訊';
$lang['user:profile_role_label'] 			= '用戶身分';
$lang['user:profile_registred_on_label'] 	= '用戶註冊於';
$lang['user:profile_last_login_label'] 		= '最後登入於';
$lang['user:profile_male_label'] 			= '男性';
$lang['user:profile_female_label'] 			= '女性';

$lang['user:profile_not_set_up'] 			= '此用戶尚未設定個人簡介。';

$lang['user:profile_edit'] 					= '編輯個人簡介';

$lang['user:profile_personal_section'] 		= '個人資訊';

$lang['user:profile_display_name']			= '顯示名稱';
$lang['user:profile_dob']					= '出生日期';
$lang['user:profile_dob_day']				= '日';
$lang['user:profile_dob_month']				= '月';
$lang['user:profile_dob_year']				= '年';
$lang['user:profile_gender']					= '性別';
$lang['user:profile_gender_nt']            = '不想透漏';
$lang['user:profile_gender_male']          = '男性';
$lang['user:profile_gender_female']        = '女性';
$lang['user:profile_bio']					= '關於我';

$lang['user:profile_contact_section'] 		= '聯絡資訊';

$lang['user:profile_phone']					= '電話';
$lang['user:profile_mobile']					= '手機';
$lang['user:profile_address']				= '地址';
$lang['user:profile_address_line1'] 			= '地址 #1';
$lang['user:profile_address_line2'] 			= '地址 #2';
$lang['user:profile_address_line3'] 			= '地址 #3';
$lang['user:profile_address_postcode'] 		= '郵遞區號';
$lang['user:profile_website']				= '網站';

$lang['user:profile_messenger_section'] 		= '即時通訊';

$lang['user:profile_msn_handle'] 			= 'MSN';
$lang['user:profile_aim_handle'] 			= 'AIM';
$lang['user:profile_yim_handle'] 			= 'Yahoo! messenger';
$lang['user:profile_gtalk_handle'] 			= 'GTalk';

$lang['user:profile_avatar_section'] 		= '頭像工具';
$lang['user:profile_social_section'] 		= '社交工具';

$lang['user:profile_gravatar'] 				= 'Gravatar';
$lang['user:profile_twitter'] 				= 'Twitter';

$lang['user:profile_edit_success'] 			= '您的個人簡介已經儲存。';
$lang['user:profile_edit_error'] 			= '發生了問題';

// -- Buttons ------------------------------------------------------------------------------------------------

$lang['user:profile_save_btn'] 				= '儲存個人簡介';
