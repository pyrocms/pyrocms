<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Finnish translation.
 *
 * @author Mikael Kundert
 */

// tabs
$lang['page_types.html_label']                     = 'HTML';
$lang['page_types.css_label']                      = 'CSS';

// labels
$lang['page_types.updated_label']                  = 'Päivitetty';
$lang['page_types:auto_create_stream']				= 'Create New Data Stream'; #translate
$lang['page_types:select_stream']					= 'Data Stream'; #translate
$lang['page_types:theme_layout_label']             = 'Sivupohja';

// titles
$lang['page_types.list_title']                     = 'Listaa sivupohjat';
$lang['page_types.create_title']                   = 'Lisää sivupohja';
$lang['page_types.edit_title']                     = 'Muokkaa sivupohjaa "%s"';

// messages
$lang['page_types.no_pages']                       = 'Sivupohjia ei löytynyt.';
$lang['page_types.create_success']                 = 'Sivupohja luotiin onnistuneesti.';
$lang['page_types.create_error']                   = 'Sivupohjaa ei luotu.';
$lang['page_types.page_type.not_found_error']    = 'Sivupohjaa ei löytynyt.';
$lang['page_types.edit_success']                   = 'Sivupohja "%s" tallennettiin.';
$lang['page_types.delete_home_error']              = 'Et voi poistaa oletus sivupohjaa.';
$lang['page_types.delete_success']                 = 'Sivupohja #%s poistettiin.';
$lang['page_types.mass_delete_success']            = '%s sivupohjaa poistettiin.';
$lang['page_types.delete_none_notice']             = 'Yhtään sivupohjaa ei poistettu.';
$lang['page_types.already_exist_error']            = 'A table with that name already exists. Please choose a different name for this page type.'; #translate

$lang['page_types.variable_introduction']          = 'Tässä kentässä on kaksi muuttujaa.';
$lang['page_types.variable_title']                 = 'Sisältää sivun otsikko.';
$lang['page_types.variable_body']                  = 'Sisältää sivun HTML leipätekstin.';