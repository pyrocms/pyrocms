<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['permissions:group']                  = 'Csoportok';
$lang['permissions:roles']                  = 'Beosztás';
$lang['permissions:module']                      = 'Module'; #translate
$lang['permissions:edit']                   = 'Jogosultságok módosítása';

$lang['permissions:introduction']           = 'Minden felhasználónak egyedi jogosultságot lehet adni azzal, hogy egy egyedi csoporthoz rendeljük őket, ezt a <i>Felhasználók > Felhasználók kezelése</i> menüpont alatt. Ezután módosítani lehet a csoport jogosultságait és meg lehet adni, hogy mik azok a műveletek, amikre a felhasználók jogosultak';

$lang['permissions:message_group_saved_success']    = 'Ennek a csoportnak a jogosultságai, el lettek mentve.';
$lang['permissions:message_group_saved_error']    = 'Sorry, the permissions for this group could not be saved.'; #translate
$lang['permissions:message_no_group_id_provided'] = 'The group id provided was not valid.'; #translate
$lang['permissions:admin_has_all_permissions'] = 'The Admin group has access to everything'; #translate
$lang['permissions:checkbox_tooltip_action_to_all'] = 'Check to give access permission to all modules for this group.'; #translate
$lang['permissions:checkbox_tooltip_give_access_to_module'] = 'Check to give access permission to the &quot;%s&quot; module for this group.'; #translate