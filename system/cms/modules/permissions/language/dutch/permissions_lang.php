<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['permissions:group']				= 'Groep';
$lang['permissions:roles']           	= 'Rollen';
$lang['permissions:module']                      = 'Module'; #translate
$lang['permissions:edit']				= 'Rechten';

$lang['permissions:introduction'] 		= 'U kunt rechten aanmaken voor verschillende gebruikers door ze aan een groep toe te wijzen in <a href="admin/users/">Beheer gebruikers</a>. Daarna kunt u hier beheren tot welke modules en rollen een groep toegang heeft.';

$lang['permissions:message_group_saved_success'] = 'De rechten voor deze groep zijn opgeslagen.';
$lang['permissions:message_group_saved_error']    = 'Sorry, the permissions for this group could not be saved.'; #translate
$lang['permissions:message_no_group_id_provided'] = 'The group id provided was not valid.'; #translate
$lang['permissions:admin_has_all_permissions'] = 'The Admin group has access to everything'; #translate
$lang['permissions:checkbox_tooltip_action_to_all'] = 'Check to give access permission to all modules for this group.'; #translate
$lang['permissions:checkbox_tooltip_give_access_to_module'] = 'Check to give access permission to the &quot;%s&quot; module for this group.'; #translate