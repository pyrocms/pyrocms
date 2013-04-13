<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * PyroCMS
 * Русский перевод от Dark Preacher - dark[at]darklab.ru
 *
 * @package		PyroCMS
 * @author		Dark Preacher
 * @link			http://pyrocms.com
 */

// настройки
$lang['settings:site_name']									= 'Имя сайта';
$lang['settings:site_name_desc']							= 'Имя сайта, используется в заголовках страниц и разных местах на сайте.';

$lang['settings:site_slogan']								= 'Слоган сайта';
$lang['settings:site_slogan_desc']						= 'Слоган сайта, используется в заголовках страниц и разных местах на сайте.';

$lang['settings:site_lang']									= 'Язык сайта';
$lang['settings:site_lang_desc']							= 'Родной язык сайта, используется для выбора шаблонов внутренних почтовых уведомлений и получения контактов пользователей, и других вещей, которые не зависят от языка, выбранного пользователем.';

$lang['settings:contact_email']							= 'E-mail для связи';
$lang['settings:contact_email_desc']					= 'Вся почта от пользователей, гостей и самого сайта будет отправляться на этот адрес.';

$lang['settings:server_email']							= 'E-mail сервера';
$lang['settings:server_email_desc']						= 'Вся почта пользователям будет приходить от этого адреса.';

$lang['settings:meta_topic']								= 'Мета-топик';
$lang['settings:meta_topic_desc']							= 'Два-три слова, описывающих компанию/сайт.';

$lang['settings:currency']									= 'Валюта';
$lang['settings:currency_desc']								= 'Символ валюты, используется в продуктах, сервисах и т.п.';

$lang['settings:dashboard_rss']							= 'RSS панели управления';
$lang['settings:dashboard_rss_desc']					= 'Ссылка на новостную ленту, которая будет отображаться на главной странице панели управления.';

$lang['settings:dashboard_rss_count']				= 'Количество записей RSS';
$lang['settings:dashboard_rss_count_desc']		= 'Какое количество записей RSS-ленты отображать на главной странице панели управления?';

$lang['settings:date_format']								= 'Формат даты';
$lang['settings:date_format_desc']						= 'Как будут отображаться даты на сайте и в панели управления? ' .
													'С помощью <a href="http://php.net/manual/ru/function.date.php" target="_black">функции date</a> из PHP - или - ' .
													'Используя <a href="http://php.net/manual/ru/function.strftime.php" target="_black">форматирование строк с датой</a> из PHP.';

$lang['settings:frontend_enabled']					= 'Сайт';
$lang['settings:frontend_enabled_desc']				= 'Используйте эту опцию для контроля активности пользовательской части сайта. Полезно, если вы хотите временно отключить ваш сайт для технического обслуживания.';

$lang['settings:mail_protocol']							= 'Протокол почты';
$lang['settings:mail_protocol_desc']					= 'Выберите предпочтительный почтовый протокол.';

$lang['settings:mail_sendmail_path']				= 'Пусть Sendmail';
$lang['settings:mail_sendmail_path_desc']			= 'Путь к исполнимому файлу sendmail на сервере.';

$lang['settings:mail_smtp_host']						= 'Хост SMTP';
$lang['settings:mail_smtp_host_desc']					= 'Имя хоста вашего SMTP-сервера.';

$lang['settings:mail_smtp_pass']						= 'Пароль SMTP';
$lang['settings:mail_smtp_pass_desc']					= 'Пароль SMTP.';

$lang['settings:mail_smtp_port']						= 'Порт SMTP';
$lang['settings:mail_smtp_port_desc']					= 'Номер порта SMTP.';

$lang['settings:mail_smtp_user']						= 'Имя пользователя SMTP';
$lang['settings:mail_smtp_user_desc']					= 'Имя пользователя SMTP.';

$lang['settings:unavailable_message']				= 'Сообщение о недоступности';
$lang['settings:unavailable_message_desc']		= 'Когда сайт отключен или произошла серьёзная проблема - это сообщение увидят посетители сайта.';

$lang['settings:default_theme']							= 'Тема по-умолчанию';
$lang['settings:default_theme_desc']					= 'Выберите тему оформления, которая будет установлена по-умолчанию для всех пользователей.';

$lang['settings:activation_email']					= 'Активация Email';
$lang['settings:activation_email_desc']				= 'Включение возможности отправки пользователям писем со ссылкой для активации учётной записи, после регистрации. Если вы отключите эту возможность - учётные записи новых пользователей смогут активировать только администраторы.';

$lang['settings:records_per_page']					= 'Записей на странице';
$lang['settings:records_per_page_desc']				= 'Какое количество записей на страницах панели управления будет отображаться?';

$lang['settings:rss_feed_items']						= 'Кол-во записей в лентах';
$lang['settings:rss_feed_items_desc']					= 'Какое количество записей выводить в RSS лентах/новостях?';


$lang['settings:enable_profiles']						= 'Разрешить профили';
$lang['settings:enable_profiles_desc']				= 'Разрешить пользователям добавлять и редактировать профили.';

$lang['settings:ga_email']									= 'E-mail Google Analytic';
$lang['settings:ga_email_desc']								= 'Адрес E-mail для Google Analytics, нужно указать, если вы хотите видеть график посещаемости на главной странице панели администратора.';

$lang['settings:ga_password']								= 'Пароль Google Analytic';
$lang['settings:ga_password_desc']						= 'Пароль Google Analytics. Тоже нужно указать, для отображения графика.';

$lang['settings:ga_profile']								= 'Профиль Google Analytic';
$lang['settings:ga_profile_desc']							= 'ID профиля этого сайта в Google Analytics.';

$lang['settings:ga_tracking'] 							= 'Код отслеживания Google Tracking';
$lang['settings:ga_tracking_desc']						= 'Укажите код отслеживания Google Analytic для активации учёта посетителей вашего сайта. Например: UA-19483569-6';

$lang['settings:twitter_username']					= 'Логин';
$lang['settings:twitter_username_desc']				= 'Имя пользователя Twitter.';

$lang['settings:twitter_feed_count']				= 'Кол-во записей';
$lang['settings:twitter_feed_count_desc']			= 'Какое количество твитов должно быть показано в блоке фидов Твиттера?';

$lang['settings:twitter_cache']							= 'Время кэширования';
$lang['settings:twitter_cache_desc']					= 'На какое количество минут кэшировать ваши твиты?';

$lang['settings:akismet_api_key']						= 'API-ключ Akismet';
$lang['settings:akismet_api_key_desc']				= 'Akismet - это система блокирования спама от комманды WordPress. Она держит спам под контролем, без необходимости ввода пользователями капчи.';

$lang['settings:comment_order'] 						= 'Сортировка комментариев';
$lang['settings:comment_order_desc']					= 'Порядок сортировки комментариев.';

$lang['settings:moderate_comments']					= 'Модерация комментариев';
$lang['settings:moderate_comments_desc']			= 'Администратор будет просматривать и утверждать комментарии, перед тем, как они появятся на сайте.';

$lang['settings:version']										= 'Версия';
$lang['settings:version_desc']								= '';

$lang['settings:ckeditor_config']               = 'CKEditor Config'; #translate
$lang['settings:ckeditor_config_desc']          = 'You can find a list of valid configuration items in <a target="_blank" href="http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html">CKEditor\'s documentation.</a>'; #translate

$lang['settings:enable_registration']           = 'Enable user registration'; #translate
$lang['settings:enable_registration_desc']      = 'Allow users to register in your site.'; #translate

$lang['settings:profile_visibility']            = 'Profile Visibility'; #translate
$lang['settings:profile_visibility_desc']       = 'Specify who can view user profiles on the public site'; #translate

$lang['settings:cdn_domain']                    = 'CDN Domain'; #translate
$lang['settings:cdn_domain_desc']               = 'CDN domains allow you to offload static content to various edge servers, like Amazon CloudFront or MaxCDN.'; #translate

// заголовки
$lang['settings:section_general']							= 'Основные';
$lang['settings:section_integration']					= 'Интеграция';
$lang['settings:section_comments']						= 'Комментарии';
$lang['settings:section_users']								= 'Пользователи';
$lang['settings:section_statistics']					= 'Статистика';
$lang['settings:section_twitter']							= 'Twitter';

// чекбоксы и прочая фигня
$lang['settings:form_option_Open']						= 'Работает';
$lang['settings:form_option_Closed']					= 'Закрыт';
$lang['settings:form_option_Enabled']					= 'Включено';
$lang['settings:form_option_Disabled']				= 'Выключено';
$lang['settings:form_option_Required']				= 'Требуется';
$lang['settings:form_option_Optional']				= 'Рекомендуется';
$lang['settings:form_option_Oldest First']		= 'Старые сначала';
$lang['settings:form_option_Newest First']		= 'Новые сначала';

// titles
$lang['settings:edit_title']								= 'Редактировать настройки';

// messages
$lang['settings:no_settings']					= 'There are currently no settings.'; #translate
$lang['settings:save_success'] 							= 'Настройки сохранены';

/* End of file settings_lang.php */