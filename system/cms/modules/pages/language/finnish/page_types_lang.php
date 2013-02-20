<?php defined('BASEPATH') or exit('No direct script access allowed');

// tabs
$lang['page_types:html_label']                 = 'HTML';
$lang['page_types:css_label']                  = 'CSS';
$lang['page_types:basic_info']                 = 'Perustiedot';

// labels
$lang['page_types:updated_label']              = 'Päivitetty';
$lang['page_types:layout']                     = 'Pohja';
$lang['page_types:auto_create_stream']         = 'Lisää uusi striimi tälle pohjalle';
$lang['page_types:select_stream']              = 'Striimi';
$lang['page_types:theme_layout_label']         = 'Sivupohja';
$lang['page_types:save_as_files']              = 'Tallenna tiedostoina';
$lang['page_types:content_label']              = 'Sisältö välilehti etiketti';
$lang['page_types:title_label']                = 'Otsikko etiketti';
$lang['page_types:sync_files']                 = 'Synkronisoi tiedostot';

// titles
$lang['page_types:list_title']                 = 'Listaa sivupohjat';
$lang['page_types:list_title_sing']            = 'Sivun tyyppi';
$lang['page_types:create_title']               = 'Lisää sivupohja';
$lang['page_types:edit_title']                 = 'Muokkaa sivupohjaa "%s"';

// messages
$lang['page_types:no_pages']                   = 'Sivupohjia ei löytynyt.';
$lang['page_types:create_success_add_fields']  = 'Olet luonut uuden sivutyypin. Voit nyt lisätä siihen omia kenttiä.';
$lang['page_types:create_success']             = 'Sivupohja luotiin onnistuneesti.';
$lang['page_types:success_add_tag']            = 'The page field has been added. However before its data will be output you must insert its tag into the Page Type\'s Layout textarea'; #translate
$lang['page_types:create_error']               = 'Sivupohjaa ei luotu.';
$lang['page_types:page_type.not_found_error']  = 'Sivupohjaa ei löytynyt.';
$lang['page_types:edit_success']               = 'Sivupohja "%s" tallennettiin.';
$lang['page_types:delete_home_error']          = 'Et voi poistaa oletus sivupohjaa.';
$lang['page_types:delete_success']             = 'Sivupohja #%s poistettiin.';
$lang['page_types:mass_delete_success']        = '%s sivupohjaa poistettiin.';
$lang['page_types:delete_none_notice']         = 'Yhtään sivupohjaa ei poistettu.';
$lang['page_types:already_exist_error']        = 'A table with that name already exists. Please choose a different name for this page type.'; #translate
$lang['page_types:_check_pt_slug_msg']         = 'Sivu tyypin polkutunnus tulee olla yksilöllinen.';

$lang['page_types:variable_introduction']      = 'Tässä kentässä on kaksi muuttujaa.';
$lang['page_types:variable_title']             = 'Sisältää sivun otsikko.';
$lang['page_types:variable_body']              = 'Sisältää sivun HTML leipätekstin.';
$lang['page_types:sync_notice']                = 'Tiedostojärjestelmästä vain %s onnistui synkronisoinnissa.';
$lang['page_types:sync_success']               = 'Tiedostot synkronisoitu onnistuneesti.';
$lang['page_types:sync_fail']                  = 'Tiedostoja ei voitu synkronisoida.';

// Instructions
$lang['page_types:stream_instructions']        = 'Tämä striimi ylläpitää kenttiäsi sivutyyppiin. Voit valita uuden striimin tai luoda uuden.';
$lang['page_types:saf_instructions']           = 'Valitsemalla tämän, järjestelmä tallentaa sivupohjan tiedostona. Samalla CSS ja JS tiedostot "assets/page_types" kansioon.';
$lang['page_types:content_label_instructions'] = 'Tämä uudelleennimeää välilehden, jossa on omat kentät.';
$lang['page_types:title_label_instructions']   = 'Tämä uudelleennimeää otsikkokentän toiseksi. Tämä on kätevää esimerkiksi silloin kun "Otsikko" haluttaisiin olevan esimerkiksi "Tuote nimi" tai "Jäsenen nimi".';

// Misc
$lang['page_types:delete_message']             = 'Oletko varma, että haluat poistaa tämän sivutyypin? Tämä poistaa <strong>%s</strong> sivut, jotka käyttävät tätä sivupohjaa. Kaikki tämän sivun alasivut ja niiden striimien liitetyt kentät poistetaan myös. <strong>Tätä toimintoa ei voi perua.</strong> ';

$lang['page_types:delete_streams_message']     = 'Tämä poistaa myös <strong>%s striimin</strong> liitännät tähän sivutyyppiin.'; #translate