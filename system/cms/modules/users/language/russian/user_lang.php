<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * PyroCMS
 * Русский перевод от Dark Preacher - dark[at]darklab.ru
 *
 * @package		PyroCMS
 * @author		Dark Preacher
 * @link			http://pyrocms.com
 */

$lang['user_register_header']								= 'Регистрация';
$lang['user_register_step1']								= '<strong>Шаг 1:</strong> Регистрация';
$lang['user_register_step2']								= '<strong>Шаг 2:</strong> Активация';

$lang['user_login_header']									= 'Вход';

// заголовки
$lang['user_add_title']											= 'Создать пользователя';
$lang['user_list_title']										= 'Список пользователей';
$lang['user_inactive_title']								= 'Неактивные пользователи';
$lang['user_active_title']									= 'Активные пользователи';
$lang['user_registred_title']								= 'Зарегистрированные пользователи';

// подписи
$lang['user_edit_title']										= 'Редактирование пользователя "%s"';
$lang['user_details_label']									= 'Детали';
$lang['user_first_name_label']							= 'Имя';
$lang['user_last_name_label']								= 'Фамилия';
$lang['user_email_label']										= 'E-mail';
$lang['user_group_label']										= 'Группа';
$lang['user_activate_label']								= 'Активировать';
$lang['user_password_label']								= 'Пароль';
$lang['user_password_confirm_label']				= 'Подтверждение пароля';
$lang['user_name_label']										= 'Имя';
$lang['user_joined_label']									= 'Зарегистрировался';
$lang['user_last_visit_label']							= 'Последний визит';
$lang['user_actions_label']									= 'Действия';
$lang['user_never_label']										= 'Никогда';
$lang['user_delete_label']									= 'Удалить';
$lang['user_edit_label']										= 'Редактировать';
$lang['user_view_label']										= 'Просмотр';

$lang['user_no_inactives']									= 'Неактивные пользователи отсутствуют.';
$lang['user_no_registred']									= 'Зарегистрированные пользователи отсутствуют.';

$lang['account_changes_saved']							= 'Изменения вашей учётной записи сохранены.';

$lang['indicates_required']									= 'указывают поля, необходимые для заполнения';

// -- Регистрация / Активация / Сброс пароля ----------------------------------------------------------

$lang['user_register_title']								= 'Регистрация';
$lang['user_activate_account_title']				= 'Активация учётной записи';
$lang['user_activate_label']								= 'Активен';
$lang['user_activated_account_title']				= 'Учётная запись активирована';
$lang['user_reset_password_title']					= 'Сброс пароля';
$lang['user_password_reset_title']					= 'Сброс пароля';

$lang['user_error_username']								= 'Выбранное вами имя пользователя уже занято';
$lang['user_error_email']										= 'Выбранный вами адрес email уже занят';

$lang['user_full_name']											= 'Полное имя';
$lang['user_first_name']										= 'Имя';
$lang['user_last_name']											= 'Фамилия';
$lang['user_username']											= 'Логин';
$lang['user_display_name']									= 'Отображаемое имя';
$lang['user_email_use']											= 'используется для входа на сайт';
$lang['user_email']													= 'E-mail';
$lang['user_confirm_email']									= 'Подтверждение E-mail';
$lang['user_password']											= 'Пароль';
$lang['user_remember']											= 'Запомнить меня';
$lang['user_confirm_password']							= 'Подтверждение пароля';
$lang['user_group_id_label']								= 'ID группы';

$lang['user_level']													= 'Уровень пользователя';
$lang['user_active']												= 'Активен';
$lang['user_lang']													= 'Язык';

$lang['user_activation_code']								= 'Код активации';

$lang['user_reset_password_link']						= 'Забыли пароль?';

$lang['user_activation_code_sent_notice']		= 'На указанный Вами адрес электронной почты отправлено письмо с кодом активации.';
$lang['user_activation_by_admin_notice']		= 'Ваша регистрация ожидает утверждения администратором.';

// -- Настройки ---------------------------------------------------------------------------------------------

$lang['user_details_section']								= 'Имя';
$lang['user_password_section']							= 'Изменить пароль';
$lang['user_other_settings_section']				= 'Другие настройки';

$lang['user_settings_saved_success']				= 'Настройки учётной записи сохранены.';
$lang['user_settings_saved_error']					= 'Во время сохранения настроек учётной записи произошла ошибка.';

// -- Кнопки ----------------------------------------------------------------------------------------------

$lang['user_register_btn']									= 'Регистрация';
$lang['user_activate_btn']									= 'Активация';
$lang['user_reset_pass_btn'] 								= 'Сброс пароля';
$lang['user_login_btn']											= 'Войти';
$lang['user_settings_btn']									= 'Сохранить настройки';

// -- Errors & Messages ------------------------------------------------------------------------------------

// Создание
$lang['user_added_and_activated_success']		= 'Новый пользователь создан и активирован.';
$lang['user_added_not_activated_success']		= 'Новый пользователь создан, учётная запись ожидает активации.';

// Редактирование
$lang['user_edit_user_not_found_error']			= 'Пользователь не найден.';
$lang['user_edit_success']									= 'Пользователь сохранён.';
$lang['user_edit_error']										= 'Во время сохранения пользователя произошла ошибка.';

// Активация
$lang['user_activate_success']							= '%s пользователей из %s активированы.';
$lang['user_activate_error']								= 'Сначала надо выбрать пользователей для активации.';

// Удаление
$lang['user_delete_self_error']							= 'Себя удалять нельзя!';
$lang['user_mass_delete_success']						= '%s пользователей из %s удалены.';
$lang['user_mass_delete_error']							= 'Сначала надо выбрать пользователей для удаления.';

// Регистрация
$lang['user_email_pass_missing']						= 'Поля Email или Пароль не заполнены.';
$lang['user_email_exists']									= 'Указанный Email уже используется другим пользователем.';
$lang['user_register_reasons']							= 'Зарегистрируйтесь, чтобы получить доступ к закрытым разделам сайта. Вы сможете сохранять ваши Ваши данные, больше содержимого и меньше рекламы.';


// Активация
$lang['user_activation_incorrect']					= 'Активация не удалась. Пожалуйста, проверьте код ещё раз и убедитесь, что CAPS LOCK выключен.';
$lang['user_activated_message']							= 'Ваша учётная запись активирована, теперь вы можете войти на сайт.';


// Вход
$lang['user_logged_in']											= 'Вы вошли на сайт.';
$lang['user_already_logged_in']							= 'Вы уже вошли на сайт.';
$lang['user_login_incorrect']								= 'E-mail или пароль не подходят. Пожалуйста, проверьте ваш логин и убедитесь, что CAPS LOCK выключен.';
$lang['user_inactive']											= 'Учётная запись, к которой вы пытаетесь получить доступ - не активирована.<br />Проверьте Ваш почтовый ящик, Вам должны были прийти инструкции, объясняющие как вы можете активировать вашу учётную запись - <em>возможно это письмо попало в папку со спамом</em>.';


// Выход
$lang['user_logged_out']										= 'Вы вышли из сайта.';

// Забыл пароль
$lang['user_forgot_incorrect']							= 'Учётная запись, с такими данными, не найдена.';

$lang['user_password_reset_message']				= 'Ваш пароль сброшен. В ближайшее время Вы получите письмо с инструкциями. Если письма долго нет - возможно оно случайно попало в папку со спамом.';

// Emails ----------------------------------------------------------------------------------------------------

// Активация
$lang['user_activation_email_subject']				= 'Необходима активация';
$lang['user_activation_email_body']						= 'Спасибо за активацию Вашей учётной записи на %s. Для входа на сайт - перейдите по ссылке ниже:';


$lang['user_activated_email_subject']					= 'Активация завершена';
$lang['user_activated_email_content_line1']		= 'Спасибо за регистрацию на %s. Перед тем, как мы сможем активировать Вашу учётную запись - пожалуйста, завершите процесс регистрации, перейдя по ссылке ниже:';
$lang['user_activated_email_content_line2']		= 'В случае, если Ваша программа для чтения почты не может распознать ссылку для активации учётной записи, пожалуйста, перейдите по нижеследующему адресу и введите код активации на открывшейся странице:';

// Сброс пароля
$lang['user_reset_pass_email_subject']				= 'Сброс пароля';
$lang['user_reset_pass_email_body']						= 'Ваш пароль на %s был сброшен. Если Вы не запрашивали сброс пароля - пожалуйста, отправьте нам письмо на %s и мы исправим возникшую проблему.';

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
/* Location: ./system/cms/modules/users/language/russian/user_lang.php */
