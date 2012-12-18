<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * PyroCMS
 * Русский перевод от Dark Preacher - dark[at]darklab.ru
 *
 * @package		PyroCMS
 * @author		Dark Preacher
 * @link			http://pyrocms.com
 */

$lang['user:add_field']                        	= 'Add User Profile Field'; #translate
$lang['user:profile_delete_success']           	= 'User profile field deleted successfully'; #translate
$lang['user:profile_delete_failure']            = 'There was a problem with deleting your user profile field'; #translate
$lang['profile_user_basic_data_label']  		= 'Basic Data'; #translate
$lang['profile_company']         	  			= 'Company'; #translate
$lang['profile_updated_on']           			= 'Updated On'; #translate
$lang['user:profile_fields_label']	 		 	= 'Profile Fields'; #translate`

$lang['user:register_header']								= 'Регистрация';
$lang['user:register_step1']								= '<strong>Шаг 1:</strong> Регистрация';
$lang['user:register_step2']								= '<strong>Шаг 2:</strong> Активация';

$lang['user:login_header']									= 'Вход';

// заголовки
$lang['user:add_title']											= 'Создать пользователя';
$lang['user:list_title']										= 'Список пользователей';
$lang['user:inactive_title']								= 'Неактивные пользователи';
$lang['user:active_title']									= 'Активные пользователи';
$lang['user:registred_title']								= 'Зарегистрированные пользователи';

// подписи
$lang['user:edit_title']										= 'Редактирование пользователя "%s"';
$lang['user:details_label']									= 'Детали';
$lang['user:first_name_label']							= 'Имя';
$lang['user:last_name_label']								= 'Фамилия';
$lang['user:group_label']										= 'Группа';
$lang['user:activate_label']								= 'Активировать';
$lang['user:password_label']								= 'Пароль';
$lang['user:password_confirm_label']				= 'Подтверждение пароля';
$lang['user:name_label']										= 'Имя';
$lang['user:joined_label']									= 'Зарегистрировался';
$lang['user:last_visit_label']							= 'Последний визит';
$lang['user:never_label']										= 'Никогда';

$lang['user:no_inactives']									= 'Неактивные пользователи отсутствуют.';
$lang['user:no_registred']									= 'Зарегистрированные пользователи отсутствуют.';

$lang['account_changes_saved']							= 'Изменения вашей учётной записи сохранены.';

$lang['indicates_required']									= 'указывают поля, необходимые для заполнения';

// -- Регистрация / Активация / Сброс пароля ----------------------------------------------------------

$lang['user:send_activation_email']            = 'Send Activation Email'; #translate
$lang['user:do_not_activate']                  = 'Inactive'; #translate
$lang['user:register_title']								= 'Регистрация';
$lang['user:activate_account_title']				= 'Активация учётной записи';
$lang['user:activate_label']								= 'Активен';
$lang['user:activated_account_title']				= 'Учётная запись активирована';
$lang['user:reset_password_title']					= 'Сброс пароля';
$lang['user:password_reset_title']					= 'Сброс пароля';

$lang['user:error_username']								= 'Выбранное вами имя пользователя уже занято';
$lang['user:error_email']										= 'Выбранный вами адрес email уже занят';

$lang['user:full_name']											= 'Полное имя';
$lang['user:first_name']										= 'Имя';
$lang['user:last_name']											= 'Фамилия';
$lang['user:username']											= 'Логин';
$lang['user:display_name']									= 'Отображаемое имя';
$lang['user:email_use']											= 'используется для входа на сайт';
$lang['user:remember']											= 'Запомнить меня';
$lang['user:group_id_label']								= 'ID группы';

$lang['user:level']													= 'Уровень пользователя';
$lang['user:active']												= 'Активен';
$lang['user:lang']													= 'Язык';

$lang['user:activation_code']								= 'Код активации';

$lang['user:reset_instructions']			   = 'Enter your email address or username'; #translate
$lang['user:reset_password_link']						= 'Забыли пароль?';

$lang['user:activation_code_sent_notice']		= 'На указанный Вами адрес электронной почты отправлено письмо с кодом активации.';
$lang['user:activation_by_admin_notice']		= 'Ваша регистрация ожидает утверждения администратором.';
$lang['user:registration_disabled']            = 'Sorry, but the user registration is disabled.'; #translate

// -- Настройки ---------------------------------------------------------------------------------------------

$lang['user:details_section']								= 'Имя';
$lang['user:password_section']							= 'Изменить пароль';
$lang['user:other_settings_section']				= 'Другие настройки';

$lang['user:settings_saved_success']				= 'Настройки учётной записи сохранены.';
$lang['user:settings_saved_error']					= 'Во время сохранения настроек учётной записи произошла ошибка.';

// -- Кнопки ----------------------------------------------------------------------------------------------

$lang['user:register_btn']									= 'Регистрация';
$lang['user:activate_btn']									= 'Активация';
$lang['user:reset_pass_btn'] 								= 'Сброс пароля';
$lang['user:login_btn']											= 'Войти';
$lang['user:settings_btn']									= 'Сохранить настройки';

// -- Errors & Messages ------------------------------------------------------------------------------------

// Создание
$lang['user:added_and_activated_success']		= 'Новый пользователь создан и активирован.';
$lang['user:added_not_activated_success']		= 'Новый пользователь создан, учётная запись ожидает активации.';

// Редактирование
$lang['user:edit_user_not_found_error']			= 'Пользователь не найден.';
$lang['user:edit_success']									= 'Пользователь сохранён.';
$lang['user:edit_error']										= 'Во время сохранения пользователя произошла ошибка.';

// Активация
$lang['user:activate_success']							= '%s пользователей из %s активированы.';
$lang['user:activate_error']								= 'Сначала надо выбрать пользователей для активации.';

// Удаление
$lang['user:delete_self_error']							= 'Себя удалять нельзя!';
$lang['user:mass_delete_success']						= '%s пользователей из %s удалены.';
$lang['user:mass_delete_error']							= 'Сначала надо выбрать пользователей для удаления.';

// Регистрация
$lang['user:email_pass_missing']						= 'Поля Email или Пароль не заполнены.';
$lang['user:email_exists']									= 'Указанный Email уже используется другим пользователем.';
$lang['user:register_error']				   = 'We think you are a bot. If we are mistaken please accept our apologies.'; #translate
$lang['user:register_reasons']							= 'Зарегистрируйтесь, чтобы получить доступ к закрытым разделам сайта. Вы сможете сохранять ваши Ваши данные, больше содержимого и меньше рекламы.';


// Активация
$lang['user:activation_incorrect']					= 'Активация не удалась. Пожалуйста, проверьте код ещё раз и убедитесь, что CAPS LOCK выключен.';
$lang['user:activated_message']							= 'Ваша учётная запись активирована, теперь вы можете войти на сайт.';


// Вход
$lang['user:logged_in']											= 'Вы вошли на сайт.';
$lang['user:already_logged_in']							= 'Вы уже вошли на сайт.';
$lang['user:login_incorrect']								= 'E-mail или пароль не подходят. Пожалуйста, проверьте ваш логин и убедитесь, что CAPS LOCK выключен.';
$lang['user:inactive']											= 'Учётная запись, к которой вы пытаетесь получить доступ - не активирована.<br />Проверьте Ваш почтовый ящик, Вам должны были прийти инструкции, объясняющие как вы можете активировать вашу учётную запись - <em>возможно это письмо попало в папку со спамом</em>.';


// Выход
$lang['user:logged_out']										= 'Вы вышли из сайта.';

// Забыл пароль
$lang['user:forgot_incorrect']							= 'Учётная запись, с такими данными, не найдена.';

$lang['user:password_reset_message']				= 'Ваш пароль сброшен. В ближайшее время Вы получите письмо с инструкциями. Если письма долго нет - возможно оно случайно попало в папку со спамом.';

// Emails ----------------------------------------------------------------------------------------------------

// Активация
$lang['user:activation_email_subject']				= 'Необходима активация';
$lang['user:activation_email_body']						= 'Спасибо за активацию Вашей учётной записи на %s. Для входа на сайт - перейдите по ссылке ниже:';


$lang['user:activated_email_subject']					= 'Активация завершена';
$lang['user:activated_email_content_line1']		= 'Спасибо за регистрацию на %s. Перед тем, как мы сможем активировать Вашу учётную запись - пожалуйста, завершите процесс регистрации, перейдя по ссылке ниже:';
$lang['user:activated_email_content_line2']		= 'В случае, если Ваша программа для чтения почты не может распознать ссылку для активации учётной записи, пожалуйста, перейдите по нижеследующему адресу и введите код активации на открывшейся странице:';

// Сброс пароля
$lang['user:reset_pass_email_subject']				= 'Сброс пароля';
$lang['user:reset_pass_email_body']						= 'Ваш пароль на %s был сброшен. Если Вы не запрашивали сброс пароля - пожалуйста, отправьте нам письмо на %s и мы исправим возникшую проблему.';

// Profile
$lang['profile_of_title'] 						= 'Профиль: %s';

$lang['profile_user_details_label'] 	= 'Детали';
$lang['profile_role_label'] 					= 'Роль';
$lang['profile_registred_on_label'] 	= 'Дата регистрации';
$lang['profile_last_login_label'] 		= 'Последний вход';
$lang['profile_male_label'] 					= 'Мужчина';
$lang['profile_female_label'] 				= 'Женщина';

$lang['profile_not_set_up'] 					= 'Профиль отсутствует.';

$lang['profile_edit'] 								= 'Редактирование профиль';

$lang['profile_personal_section'] 		= 'Личное';

$lang['profile_display_name']					= 'Отображаемое имя';
$lang['profile_dob']									= 'Дата рождения';
$lang['profile_dob_day']							= 'День';
$lang['profile_dob_month']						= 'Месяц';
$lang['profile_dob_year']							= 'Год';
$lang['profile_gender']								= 'Пол';
$lang['profile_gender_nt']						= 'Не скажу';
$lang['profile_gender_male']					= 'Мужской';
$lang['profile_gender_female']				= 'Женский';
$lang['profile_bio']									= 'О себе';

$lang['profile_contact_section'] 			= 'Связь';

$lang['profile_phone']								= 'Телефон';
$lang['profile_mobile']								= 'Моб. телефон';
$lang['profile_address']							= 'Адрес';
$lang['profile_address_line1'] 				= 'Строка #1';
$lang['profile_address_line2'] 				= 'Строка #2';
$lang['profile_address_line3'] 				= 'Строка #3';
$lang['profile_address_postcode'] 		= 'Почтовый индекс';
$lang['profile_website']							= 'Адрес сайта';

$lang['profile_messenger_section'] 		= 'Общение';

$lang['profile_msn_handle'] 					= 'MSN';
$lang['profile_aim_handle'] 					= 'AIM';
$lang['profile_yim_handle'] 					= 'Yahoo! messenger';
$lang['profile_gtalk_handle'] 				= 'GTalk';

$lang['profile_avatar_section'] 			= 'Аватар';
$lang['profile_social_section'] 			= 'Социальное';

$lang['profile_gravatar'] 						= 'Gravatar';
$lang['profile_twitter'] 							= 'Twitter';

$lang['profile_edit_success'] 				= 'Ваш профиль сохранён.';
$lang['profile_edit_error'] 					= 'Во время сохранения профиля произошла ошибка.';

// кнопки
$lang['profile_save_btn'] 						= 'Сохранить профиль';

/* End of file user_lang.php */