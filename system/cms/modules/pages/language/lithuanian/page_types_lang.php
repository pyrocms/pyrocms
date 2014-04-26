<?php defined('BASEPATH') or exit('No direct script access allowed');

// tabs
$lang['page_types:html_label']                 = 'HTML';
$lang['page_types:css_label']                  = 'CSS';
$lang['page_types:basic_info']                 = 'Pagrindinė informacija';

// labels
$lang['page_types:updated_label']              = 'Atnaujinta';
$lang['page_types:layout']                     = 'Maketas';
$lang['page_types:auto_create_stream']         = 'Sukurti naują srautą šio tipo puslapiams';
$lang['page_types:select_stream']              = 'Srautas';
$lang['page_types:theme_layout_label']         = 'Maketo tema';
$lang['page_types:save_as_files']              = 'Išsaugoti kitu failu';
$lang['page_types:content_label']              = 'Turinio skirtuko etiketė';
$lang['page_types:title_label']                = 'Etiketės pavadinimas';
$lang['page_types:sync_files']                 = 'Sinchronizuoti failus';

// titles
$lang['page_types:list_title']                 = 'Puslapių maketų sarašas';
$lang['page_types:list_title_sing']            = 'Puslapio tipas';
$lang['page_types:create_title']               = 'Pridėti puslapių maketą';
$lang['page_types:edit_title']                 = 'Redaguoti puslapių maketą "%s"';

// messages
$lang['page_types:no_pages']                   = 'Nėra puslapių maketų.';
$lang['page_types:create_success_add_fields']  = 'Sukūrėte naujo tipo puslapį, dabar turite pridėti laukelius, kuriuos norite turėti šio tipos puslapiuose.';
$lang['page_types:create_success']             = 'Maketas sukurtas.';
$lang['page_types:success_add_tag']            = 'The page field has been added. However before its data will be output you must insert its tag into the Page Type\'s Layout textarea'; #translate
$lang['page_types:create_error']               = 'Maketas nesukurtas.';
$lang['page_types:page_type.not_found_error']  = 'Maketas neegzistuoja.';
$lang['page_types:edit_success']               = 'Maketas "%s" išsaugotas.';
$lang['page_types:delete_home_error']          = 'Negalite ištrinti numatytojo maketo.';
$lang['page_types:delete_success']             = 'Maketai #%s buvo ištrinti.';
$lang['page_types:mass_delete_success']        = '%s puslapio maketas išrtintas.';
$lang['page_types:delete_none_notice']         = 'Nėra ištrintų maketų.';
$lang['page_types:already_exist_error']        = 'Lentelė šiuo pavadinimu jau egzistuoja. Parinkite naują vardą šiam puslapio tipui.';
$lang['page_types:_check_pt_slug_msg']         = 'Puslapio interlinija turi būti unikali.';

$lang['page_types:variable_introduction']      = 'Šiame įvedimo lauke yra du prieinami kintamieji';
$lang['page_types:variable_title']             = 'Sudėtyje yra šio puslapio pavadinimas.';
$lang['page_types:variable_body']              = 'Tūri visą HTML body savyje';
$lang['page_types:sync_notice']                = 'Galima tik sinchronizuoti %s iš failų sistemos.';
$lang['page_types:sync_success']               = 'Failai susinchronizuoti sėkmingai.';
$lang['page_types:sync_fail']                  = 'Negalima susinchronizuoti jūsų failų.';

// Instructions
$lang['page_types:stream_instructions']        = 'Šis srautas palaikys reikalingus laukelius jūsų puslapio tipui. Galite pasirinkti naują srautą arba vienas bus sukurtas tau.';
$lang['page_types:saf_instructions']           = 'Checking this will save your page layout file, as well as any custom CSS and JS as flat files in your assets/page_types folder.'; #translate
$lang['page_types:content_label_instructions'] = 'This renames the tab that holds your page type stream fields.'; #translate
$lang['page_types:title_label_instructions']   = 'This renames the page title field from "Title". This is useful if you are using "Title" as something else, like "Product Name" or "Team Member Name".'; #translate

// Misc
$lang['page_types:delete_message']             = 'Ar tikrai norite ištrinti šio puslapio tipą? Tai ištrins <strong>%s</strong> puslapių naudojančiu ši maketą, visus srautus bei puslapio visus įrašus. <strong>Veiksmas negali būti atstatytas.</strong> ';

$lang['page_types:delete_streams_message']     = 'Šis veiksmas taip pat ištrins <strong>srautą %s</strong> susijusi su šiuo puslapio tipu.';