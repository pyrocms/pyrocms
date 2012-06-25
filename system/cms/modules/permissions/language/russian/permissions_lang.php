<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * @author Dark Preacher dark[at]darklab.ru
 */
$lang['permissions:group']								= 'Группа';
$lang['permissions:roles']								= 'Права доступа';
$lang['permissions:module']                      = 'Module'; #translate
$lang['permissions:edit']									= 'Редактировать права доступа';

$lang['permissions:introduction']					= 'Вы можете задавать права доступа для разных пользователей путём добавления их в группы в разделе <em>Пользователи > Управление пользователями</em>.<br />Затем вы можете отредактировать разрешения для каждой группы отдельно и указать какие модули, и роли группа может иметь.';

$lang['permissions:message_group_saved_success']	= 'Настройки прав доступа для этой группы сохранены.';
$lang['permissions:message_group_saved_error']    = 'Sorry, the permissions for this group could not be saved.'; #translate
$lang['permissions:message_no_group_id_provided'] = 'The group id provided was not valid.'; #translate
$lang['permissions:admin_has_all_permissions'] = 'The Admin group has access to everything'; #translate
$lang['permissions:checkbox_tooltip_action_to_all'] = 'Check to give access permission to all modules for this group.'; #translate
$lang['permissions:checkbox_tooltip_give_access_to_module'] = 'Check to give access permission to the &quot;%s&quot; module for this group.'; #translate