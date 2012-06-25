<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['permissions:group']				= 'Grupo';
$lang['permissions:roles']				= 'Funções';
$lang['permissions:module']                      = 'Module'; #translate
$lang['permissions:edit']				= 'Editar permissões';

$lang['permissions:introduction'] 		= 'Você pode criar permissões personalidadas para usuários diferentes
	atribuindo-lhes a grupos de usuários - Gerenciar usuários. Então você poderá editar as permissões de cada
	grupo e controlar quais módulos e "funções" um grupo pode ter.';

$lang['permissions:message_group_saved_success'] = 'As permissões para este grupo foram salvas.';
$lang['permissions:message_group_saved_error']    = 'Sorry, the permissions for this group could not be saved.'; #translate
$lang['permissions:message_no_group_id_provided'] = 'The group id provided was not valid.'; #translate
$lang['permissions:admin_has_all_permissions'] = 'The Admin group has access to everything'; #translate
$lang['permissions:checkbox_tooltip_action_to_all'] = 'Check to give access permission to all modules for this group.'; #translate
$lang['permissions:checkbox_tooltip_give_access_to_module'] = 'Check to give access permission to the &quot;%s&quot; module for this group.'; #translate