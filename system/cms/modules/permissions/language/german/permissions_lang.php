<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['permissions:group']                    = 'Gruppe';
$lang['permissions:roles']                  = 'Rollen';
$lang['permissions:module']                      = 'Module'; #translate
$lang['permissions:edit']                    = 'Zugriffsrechte berarbeiten';

$lang['permissions:introduction']            = 'Du kannst eigene Zugriffsrechte f&uuml;r unterschiedliche Benutzer anlegen indem du ihnen in "Benutzer" > "Benutzer verwalten" Gruppen zuweist. Danach kannst du unterschiedliche Zugriffsrechte f&uuml;r die jeweiligen Gruppen festlegen. Dabei kannst du festlegen, welche Module und Rollen eine Gruppe erh&auml;lt.';

$lang['permissions:message_group_saved_success']    = 'Die Zugriffsrechte f&uuml;r diese Gruppe wurden gespeichert.';
$lang['permissions:message_group_saved_error']    = 'Sorry, the permissions for this group could not be saved.'; #translate
$lang['permissions:message_no_group_id_provided'] = 'The group id provided was not valid.'; #translate
$lang['permissions:admin_has_all_permissions'] = 'The Admin group has access to everything'; #translate
$lang['permissions:checkbox_tooltip_action_to_all'] = 'Check to give access permission to all modules for this group.'; #translate
$lang['permissions:checkbox_tooltip_give_access_to_module'] = 'Check to give access permission to the &quot;%s&quot; module for this group.'; #translate