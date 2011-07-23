<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * PyroCMS
 * Русский перевод от Dark Preacher - dark[at]darklab.ru
 *
 * @package		PyroCMS
 * @author		Dark Preacher
 * @link			http://pyrocms.com
 */

$lang['settings_save_success'] 							= 'Настройки сохранены';
$lang['settings_edit_title']								= 'Редактировать настройки';

// настройки
$lang['settings_site_name']									= 'Имя сайта';
$lang['settings_site_name_desc']							= 'Имя сайта, используется в заголовках страниц и разных местах на сайте.';

$lang['settings_site_slogan']								= 'Слоган сайта';
$lang['settings_site_slogan_desc']						= 'Слоган сайта, используется в заголовках страниц и разных местах на сайте.';

$lang['settings_site_lang']									= 'Язык сайта';
$lang['settings_site_lang_desc']							= 'Родной язык сайта, используется для выбора шаблонов внутренних почтовых уведомлений и получения контактов пользователей, и других вещей, которые не зависят от языка, выбранного пользователем.';

$lang['settings_contact_email']							= 'E-mail для связи';
$lang['settings_contact_email_desc']					= 'Вся почта от пользователей, гостей и самого сайта будет отправляться на этот адрес.';

$lang['settings_server_email']							= 'E-mail сервера';
$lang['settings_server_email_desc']						= 'Вся почта пользователям будет приходить от этого адреса.';

$lang['settings_meta_topic']								= 'Мета-топик';
$lang['settings_meta_topic_desc']							= 'Два-три слова, описывающих компанию/сайт.';

$lang['settings_currency']									= 'Валюта';
$lang['settings_currency_desc']								= 'Символ валюты, используется в продуктах, сервисах и т.п.';

$lang['settings_dashboard_rss']							= 'RSS панели управления';
$lang['settings_dashboard_rss_desc']					= 'Ссылка на новостную ленту, которая будет отображаться на главной странице панели управления.';

$lang['settings_dashboard_rss_count']				= 'Количество записей RSS';
$lang['settings_dashboard_rss_count_desc']		= 'Какое количество записей RSS-ленты отображать на главной странице панели управления?';

$lang['settings_date_format']								= 'Формат даты';
$lang['settings_date_format_desc']						= 'Как будут отображаться даты на сайте и в панели управления? ' .
													'С помощью <a href="http://php.net/manual/ru/function.date.php" target="_black">функции date</a> из PHP - или - ' .
													'Используя <a href="http://php.net/manual/ru/function.strftime.php" target="_black">форматирование строк с датой</a> из PHP.';

$lang['settings_frontend_enabled']					= 'Сайт';
$lang['settings_frontend_enabled_desc']				= 'Используйте эту опцию для контроля активности пользовательской части сайта. Полезно, если вы хотите временно отключить ваш сайт для технического обслуживания.';

$lang['settings_mail_protocol']							= 'Протокол почты';
$lang['settings_mail_protocol_desc']					= 'Выберите предпочтительный почтовый протокол.';

$lang['settings_mail_sendmail_path']				= 'Пусть Sendmail';
$lang['settings_mail_sendmail_path_desc']			= 'Путь к исполнимому файлу sendmail на сервере.';

$lang['settings_mail_smtp_host']						= 'Хост SMTP';
$lang['settings_mail_smtp_host_desc']					= 'Имя хоста вашего SMTP-сервера.';

$lang['settings_mail_smtp_pass']						= 'Пароль SMTP';
$lang['settings_mail_smtp_pass_desc']					= 'Пароль SMTP.';

$lang['settings_mail_smtp_port']						= 'Порт SMTP';
$lang['settings_mail_smtp_port_desc']					= 'Номер порта SMTP.';

$lang['settings_mail_smtp_user']						= 'Имя пользователя SMTP';
$lang['settings_mail_smtp_user_desc']					= 'Имя пользователя SMTP.';

$lang['settings_unavailable_message']				= 'Сообщение о недоступности';
$lang['settings_unavailable_message_desc']		= 'Когда сайт отключен или произошла серьёзная проблема - это сообщение увидят посетители сайта.';

$lang['settings_default_theme']							= 'Тема по-умолчанию';
$lang['settings_default_theme_desc']					= 'Выберите тему оформления, которая будет установлена по-умолчанию для всех пользователей.';

$lang['settings_activation_email']					= 'Активация Email';
$lang['settings_activation_email_desc']				= 'Включение возможности отправки пользователям писем со ссылкой для активации учётной записи, после регистрации. Если вы отключите эту возможность - учётные записи новых пользователей смогут активировать только администраторы.';

$lang['settings_records_per_page']					= 'Записей на странице';
$lang['settings_records_per_page_desc']				= 'Какое количество записей на страницах панели управления будет отображаться?';

$lang['settings_rss_feed_items']						= 'Кол-во записей в лентах';
$lang['settings_rss_feed_items_desc']					= 'Какое количество записей выводить в RSS лентах/новостях?';

$lang['settings_require_lastname']					= 'Требовать фамилию?';
$lang['settings_require_lastname_desc']				= 'В некоторых случаях фамилия может быть ненужна. Вы хотите требовать от регистрирующихся пользователей ввода фамилии?';

$lang['settings_enable_profiles']						= 'Разрешить профили';
$lang['settings_enable_profiles_desc']				= 'Разрешить пользователям добавлять и редактировать профили.';

$lang['settings_ga_email']									= 'E-mail Google Analytic';
$lang['settings_ga_email_desc']								= 'Адрес E-mail для Google Analytics, нужно указать, если вы хотите видеть график посещаемости на главной странице панели администратора.';

$lang['settings_ga_password']								= 'Пароль Google Analytic';
$lang['settings_ga_password_desc']						= 'Пароль Google Analytics. Тоже нужно указать, для отображения графика.';

$lang['settings_ga_profile']								= 'Профиль Google Analytic';
$lang['settings_ga_profile_desc']							= 'ID профиля этого сайта в Google Analytics.';

$lang['settings_ga_tracking'] 							= 'Код отслеживания Google Tracking';
$lang['settings_ga_tracking_desc']						= 'Укажите код отслеживания Google Analytic для активации учёта посетителей вашего сайта. Например: UA-19483569-6';

$lang['settings_twitter_username']					= 'Логин';
$lang['settings_twitter_username_desc']				= 'Имя пользователя Twitter.';

$lang['settings_twitter_consumer_key']			= 'Ключ пользователя';
$lang['settings_twitter_consumer_key_desc']		= 'Ключ пользователя Twitter.';

$lang['settings_twitter_consumer_key_secret']			= 'Секретный ключ пользователя';
$lang['settings_twitter_consumer_key_secret_desc']	= 'Секретный ключ пользователя Twitter.';

$lang['settings_twitter_blog']							= 'Интеграция Twitter и Новостей.';
$lang['settings_twitter_blog_desc']						= 'Вы желаете отправлять ссылки на новые новости сайта в Twitter?';

$lang['settings_twitter_feed_count']				= 'Кол-во записей';
$lang['settings_twitter_feed_count_desc']			= 'Какое количество твитов должно быть показано в блоке фидов Твиттера?';

$lang['settings_twitter_cache']							= 'Время кэширования';
$lang['settings_twitter_cache_desc']					= 'На какое количество минут кэшировать ваши твиты?';

$lang['settings_akismet_api_key']						= 'API-ключ Akismet';
$lang['settings_akismet_api_key_desc']				= 'Akismet - это система блокирования спама от комманды WordPress. Она держит спам под контролем, без необходимости ввода пользователями капчи.';

$lang['settings_comment_order'] 						= 'Сортировка комментариев';
$lang['settings_comment_order_desc']					= 'Порядок сортировки комментариев.';

$lang['settings_moderate_comments']					= 'Модерация комментариев';
$lang['settings_moderate_comments_desc']			= 'Администратор будет просматривать и утверждать комментарии, перед тем, как они появятся на сайте.';

$lang['settings_version']										= 'Версия';
$lang['settings_version_desc']								= '';

// заголовки
$lang['settings_section_general']							= 'Основные';
$lang['settings_section_integration']					= 'Интеграция';
$lang['settings_section_comments']						= 'Комментарии';
$lang['settings_section_users']								= 'Пользователи';
$lang['settings_section_statistics']					= 'Статистика';
$lang['settings_section_twitter']							= 'Twitter';

// чекбоксы и прочая фигня
$lang['settings_form_option_Open']						= 'Работает';
$lang['settings_form_option_Closed']					= 'Закрыт';
$lang['settings_form_option_Enabled']					= 'Включено';
$lang['settings_form_option_Disabled']				= 'Выключено';
$lang['settings_form_option_Required']				= 'Требуется';
$lang['settings_form_option_Optional']				= 'Рекомендуется';
$lang['settings_form_option_Oldest First']		= 'Старые сначала';
$lang['settings_form_option_Newest First']		= 'Новые сначала';

/* End of file settings_lang.php */
/* Location: ./system/cms/modules/settings/language/russian/settings_lang.php */
