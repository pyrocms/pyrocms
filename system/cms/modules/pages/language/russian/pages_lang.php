<?php defined('BASEPATH') or exit('No direct script access allowed');

$lang['pages:page']                     = 'Страница';
$lang['pages:pages']                    = 'Русский';

// tabs
$lang['pages:details_label']            = 'Page Details'; #translate
$lang['pages:content_label']            = 'Содержимое';
$lang['pages:meta_label']               = 'Мета-данные';
$lang['pages:design_label']             = 'Оформление';
$lang['pages:script_label']             = 'Скрипты';
$lang['pages:options_label']            = 'Опции';
$lang['pages:detail_label']             = 'Детали';

// label
$lang['pages:add_page_chunk']           = 'Добавить кусок страницы';
$lang['pages:page_chunk']               = 'Кусок страницы';
$lang['pages:language_label']           = 'Язык';
$lang['pages:updated_label']            = 'Обновлено';
$lang['pages:unknown_label']            = 'Неизвестно';
$lang['pages:navigation_label']         = 'Добавить в Навигацию';
$lang['pages:body_label']               = 'Описание';
$lang['pages:meta_title_label']         = 'Заголовок';
$lang['pages:meta_keywords_label']      = 'Ключевые слова';
$lang['pages:meta_robots_no_index_label']	= 'Robots: Don\'t index this page:'; #translate
$lang['pages:meta_robots_no_follow_label']	= 'Robots: Don\'t follow links on this page:'; #translate
$lang['pages:meta_desc_label']          = 'Описание';
$lang['pages:type_id_label']            = 'Макет страницы';
$lang['pages:css_label']                = 'CSS';
$lang['pages:js_label']                 = 'JavaScript';
$lang['pages:access_label']             = 'Доступ';
$lang['pages:rss_enabled_label']        = 'Включить RSS';
$lang['pages:comments_enabled_label']   = 'Разрешить комментарии';
$lang['pages:is_home_label']            = 'Это страница по-умолчанию (главная)?';
$lang['pages:strict_uri_label']         = 'Require an exact uri match?'; #translate

$lang['pages:status_label']             = 'Статус';
$lang['pages:draft_label']              = 'Черновик';
$lang['pages:live_label']               = 'Опубликовано';
$lang['pages:revisions_label']          = 'Revisions'; #translate
$lang['pages:compare_label']            = 'Compare'; #translate
$lang['pages:preview_label']            = 'Просмотр';
$lang['pages:current_label']            = 'Текущая версия';
$lang['pages:view_label']               = 'Просмотр';
$lang['pages:create_label']             = 'Создать потомка';
$lang['pages:duplicate_label']          = 'Duplicate'; #translate

// title
$lang['pages:create_title']             = 'Создать страницу';
$lang['pages:edit_title']               = 'Редактирование страницы "%s"';
$lang['pages:list_title']               = 'Список страниц';
$lang['pages:types_create_title']       = 'Создать макет';
$lang['pages:types_list_title']         = 'Список макетов';

// messages
$lang['pages:no_pages']                 = 'Страницы отсутствуют';
$lang['pages:create_success']           = 'Страница добавлена.';
$lang['pages:create_error']             = 'Во время добавления страницы произошла ошибка.';
$lang['pages:page_not_found_error']     = 'Выбранная страница не существует.';
$lang['pages:edit_success']             = 'Страница "%s" сохранена.';
$lang['pages:delete_home_error']        = 'Невозможно удалить главную страницу!';
$lang['pages:delete_success']           = 'Страница #%s удалена.';
$lang['pages:mass_delete_success']      = '%s страницы удалены.';
$lang['pages:delete_none_notice']       = 'Ни одной страницы не удалено.';
$lang['pages:page_already_exist_error'] = 'Страница с адресом "%s" уже существует в %s.';
$lang['pages:parent_not_exist_error']   = 'Выбранная родительская страница не существует.';
$lang['pages:chunk_slug_length']        = 'Page Chunk slugs may be no more than 30 characters in length.'; #translate
$lang['pages:root_folder']              = 'the top level'; #translate

$lang['pages:tree_explanation_title']   = 'Explanation'; #translate
$lang['pages:tree_explanation']         = 'Список слева содержит все страницы вашего сайта. Нажмите знак "+" для отображения потомков выбранной страницы. При нажатии на страницу - в этом блоке будет выведена полезная информация.';
$lang['pages:rss_explanation']          = 'При активировании RSS для этой страницы у пользователей появится возможность подписаться на все страницы-потомки, добавляемые к этой странице.';