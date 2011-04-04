<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Finnish translation.
 * 
 * @author Mikael Kundert <mikael@kundert.fi>
 * @date 07.02.2011
 * @version 1.0.3
 */

// labels
$lang['nav_title_label']                        = 'Otsikko';
$lang['nav_target_label']                       = 'Kohde';
$lang['nav_class_label']                        = 'Luokka';
$lang['nav_url_label']                          = 'URL';
$lang['nav_actions_label']                      = 'Toiminnot';
$lang['nav_details_label']                      = 'Tiedot';
$lang['nav_text_label']                         = 'Teksti';
$lang['nav_group_label']                        = 'Ryhmä';
$lang['nav_location_label']                     = 'Sijainti';
$lang['nav_type_label']                         = 'Linkin tyyppi';
$lang['nav_uri_label']                          = 'Sivuston linkki (URI)';
$lang['nav_page_label']                         = 'Sivu';
$lang['nav_module_label']                       = 'Moduuli';
$lang['nav_abbrev_label']                       = 'Lyhennys';
$lang['nav_edit_label']                         = 'Muokkaa';
$lang['nav_delete_label']                       = 'Poista';
$lang['nav_group_delete_label']                 = 'Poista ryhmä';

$lang['nav_link_target_self']                   = 'Sama ikkuna (oletus)';
$lang['nav_link_target_blank']                  = 'Uusi ikkuna (_blank)';

// titles
$lang['nav_link_create_title']                  = 'Lisää navigointi linkki';
$lang['nav_group_create_title']                 = 'Lisää ryhmä';
$lang['nav_link_edit_title']                    = 'Muokkaa navigointi linkkiä "%s"';
$lang['nav_link_list_title']                    = 'Listaa linkit';

// messages
$lang['nav_group_no_links']                     = 'Tässä ryhmässä ei ole linkkejä.';
$lang['nav_no_groups']                          = 'Navigointi ryhmiä ei ole.';
$lang['nav_group_delete_confirm']               = 'Oletko varma, että haluat poistaa navigointi ryhmän? Tämä poistaa KAIKKI linkit kyseisestä navigointi ryhmästä ja lisäksi teemasta pitäisi poistaa sitä käyttävät koodin pätkät';
$lang['nav_group_add_success']                  = 'Navigointi ryhmä on luotu.';
$lang['nav_group_add_error']                    = 'Tapahtui virhe.';
$lang['nav_group_mass_delete_success']          = 'Navigointi ryhmä poistettiin.';
$lang['nav_link_add_success']                   = 'Navigointi linkki lisättiin.';
$lang['nav_link_add_error']                     = 'Tapahtui odottamaton virhe.';
$lang['nav_link_not_exist_error']               = 'Tätä navigointi linkkiä ei ole olemassa.';
$lang['nav_link_edit_success']                  = 'Navigointi linkki tallennetiin.';
$lang['nav_link_delete_success']                = 'Navigointi linkki poistettiin.';

$lang['nav_link_type_desc']                     = 'Valitse linkin tyyppi, jotta saat lisävalintoja linkkiin koskien.';