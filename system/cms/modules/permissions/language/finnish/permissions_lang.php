<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * Finnish translation.
 *
 * @author Mikael Kundert
 */
$lang['permissions:group']                  = 'Ryhmä';
$lang['permissions:roles']                  = 'Roolit';
$lang['permissions:module']                      = 'Module'; #translate
$lang['permissions:edit']                   = 'Muokkaa ryhmän käyttöoikeuksia';

$lang['permissions:introduction']           = 'You can create custom permissions for different users by assigning them to groups in the Users > Manage Users area. Then you can Edit Permissions for each group and control what modules and "roles" a group can have.';
$lang['permissions:introduction']           = 'Voit luoda käyttöoikeuksia eri käyttäjille lisäämällä ne ryhmiin osiossa Käyttäjät > Hallitse käyttäjiä. Sieltä voit muokata käyttöoikeuksia kullekkin ryhmälle ja kontrolloida mitä "rooleja" ryhmä pitää sisällään.';

$lang['permissions:message_group_saved_success']    = 'Ryhmän käyttöoikeudet tallennettiin.';
$lang['permissions:message_group_saved_error']    = 'Sorry, the permissions for this group could not be saved.'; #translate
$lang['permissions:message_no_group_id_provided'] = 'The group id provided was not valid.'; #translate
$lang['permissions:admin_has_all_permissions'] = 'The Admin group has access to everything'; #translate
$lang['permissions:checkbox_tooltip_action_to_all'] = 'Check to give access permission to all modules for this group.'; #translate
$lang['permissions:checkbox_tooltip_give_access_to_module'] = 'Check to give access permission to the &quot;%s&quot; module for this group.'; #translate