<?php defined('BASEPATH') OR exit('No direct script access allowed');

// General
$lang['files:files_title']					= 'Failai';
$lang['files:fetching']						= 'Siunčiama informacija...';
$lang['files:fetch_completed']				= 'Baigta';
$lang['files:save_failed']					= 'Dėje nustatymai nebuvo išsaugoti';
$lang['files:item_created']					= '"%s" sukurtas';
$lang['files:item_updated']					= '"%s" atnaujinas';
$lang['files:item_deleted']					= '"%s" ištrintas';
$lang['files:item_not_deleted']				= '"%s" nebuvo ištrintas';
$lang['files:item_not_found']				= 'Atleiskite, tačiau "%s" nebuvo rastas';
$lang['files:sort_saved']					= 'Rušiavimo eileškumas išsaugotas';
$lang['files:no_permissions']				= 'Neturite teisių šimtam veiksmui atlikti';

// Labels
$lang['files:activity']						= 'Aktyvumas';
$lang['files:places']						= 'Vietos';
$lang['files:back']							= 'Atgal';
$lang['files:forward']						= 'Pirmyn';
$lang['files:start']						= 'Pradėti įkęlimą';
$lang['files:details']						= 'Informacija';
$lang['files:id']							= 'ID'; #translate
$lang['files:name']							= 'Pavadinimas';
$lang['files:slug']							= 'Slug';
$lang['files:path']							= 'Kelias (path)';
$lang['files:added']						= 'Įkėlimo data';
$lang['files:width']						= 'Plotis';
$lang['files:height']						= 'Aukštis';
$lang['files:ratio']						= 'Ratio';
$lang['files:alt_attribute']				= 'alt Attribute'; #translate
$lang['files:full_size']					= 'Failo pilnas dydis';
$lang['files:filename']						= 'Failo pavadinimas';
$lang['files:filesize']						= 'Failo dydis';
$lang['files:download_count']				= 'Atsiuntimų kiekis';
$lang['files:download']						= 'Atsiūsti';
$lang['files:location']						= 'Vieta';
$lang['files:keywords']						= 'Keywords'; #translate
$lang['files:toggle_data_display']			= 'Toggle Data Display'; #translate
$lang['files:description']					= 'Aprašymas';
$lang['files:container']					= 'Konteineris';
$lang['files:bucket']						= 'Bucketas';
$lang['files:check_container']				= 'Patikrinti';
$lang['files:search_message']				= 'Įrašyk ir spasuk ENTER';
$lang['files:search']						= 'Ieškok';
$lang['files:synchronize']					= 'Sinchronizuok';
$lang['files:uploader']						= 'Imesk čia failus <br />arba<br />spausk, kad išsirinkti failą';
$lang['files:replace_file']					= 'Replace file'; #translate

// Context Menu
$lang['files:refresh']						= 'Refresh'; #translate
$lang['files:open']							= 'Atidaryti';
$lang['files:new_folder']					= 'Naujas katalogas';
$lang['files:upload']						= 'Įkelti';
$lang['files:rename']						= 'Pervadinti';
$lang['files:replace']	  					= 'Replace'; # translate
$lang['files:delete']						= 'Ištrinti';
$lang['files:edit']							= 'Tvarkyti';
$lang['files:details']						= 'Informacija';

// Folders

$lang['files:no_folders']					= 'Failai ir aplankai tvarkomi panašių principu kaip jųsu darbastalyje. Dešinių peles paspaudimu sukuriate aplanką. Vėliau dešinių pėlės paspaudimu ant aplanko, tam kad jį pervadinti, ištrinti arba įkelti failus į jį.';
$lang['files:no_folders_places']			= 'Sukurti aplankai bus rodomi čia. Juos galima atverti ir užverti.';
$lang['files:no_folders_wysiwyg']			= 'Dar nebuvo sukurta aplankų';
$lang['files:new_folder_name']				= 'Neužvadintas aplankas';
$lang['files:folder']						= 'Aplankas';
$lang['files:folders']						= 'Aplankai';
$lang['files:select_folder']				= 'Išsirink aplanką';
$lang['files:subfolders']					= 'Subaplankai';
$lang['files:root']							= 'Pagrindinis';
$lang['files:no_subfolders']				= 'Nėra subalankų';
$lang['files:folder_not_empty']				= 'Turite iš pradžiu išrtinti viską iš "%s"';
$lang['files:mkdir_error']					= 'Negalėjome sukurti %s. Turite padaryti tai patys';
$lang['files:chmod_error']					= 'Įkėlimų direktorijos įrašymas negalimas. Atribūtai turi buti 0777';
$lang['files:location_saved']				= 'Aplanko kelias išsaugotas';
$lang['files:container_exists']				= '"%s" egzistuoja. Išsaugok, tam kad sujungti jo turinį su šiuo katalogų';
$lang['files:container_not_exists']			= '"%s" nėra sukurtas tavo paskyroje. Išsaugos, ir mes pabandysime jį sukurti';
$lang['files:error_container']				= '"%s" negalėjo būti sukrutas, tačiau ir klaidą nėra žinoma';
$lang['files:container_created']			= '"%s" buvo sukurtas ir sijungtas su šituo katalogu';
$lang['files:unwritable']					= '"%s" neturi įrašymo teisiu, pakeiskite teises į 0777';
$lang['files:specify_valid_folder']			= 'Privalote nurodyti aplanką į kūrį įkelti failus';
$lang['files:enable_cdn']					= 'Privalai įjungti CDS palaikyma "%s" per tavo Rackspace valdymo panele prieš sinchronizuojant';
$lang['files:synchronization_started']		= 'Sinchronizacija pradėta';
$lang['files:synchronization_complete']		= 'Sinchronizacija "%s" baigta';
$lang['files:untitled_folder']				= 'Neužvadintas aplankas';

// Files
$lang['files:no_files']						= 'Failų nerasta';
$lang['files:file_uploaded']				= '"%s" buvo įkeltas';
$lang['files:unsuccessful_fetch']			= 'Negalėjome atsiūsti "%s". Ar esate tiktas kad tai viešai pasiekiamas failas?';
$lang['files:invalid_container']			= '"%s" pasirodo yra kalidingas containeris.';
$lang['files:no_records_found']				= 'Nerasta įrašų';
$lang['files:invalid_extension']			= '"%s" turi neleistina failo išplėtimą';
$lang['files:upload_error']					= 'Failo įkelimas nesėkmingas';
$lang['files:description_saved']			= 'Failo aprašymas išsaugotas';
$lang['files:alt_saved']					= 'The image alt attribute has been saved'; #translate
$lang['files:file_moved']					= '"%s" buvo sėkmingai perkeltas';
$lang['files:exceeds_server_setting']		= 'Sėrveris negali apdoroti tokio didelio failo';
$lang['files:exceeds_allowed']				= 'Failas viršija maksimalų failo dydį';
$lang['files:file_type_not_allowed']		= 'Šis failo tipas nėra leistinas';
$lang['files:replace_warning']				= 'Warning: Do not replace a file with a file of a different type (e.g. .jpg with .png)'; #translate
$lang['files:type_a']						= 'Audio';
$lang['files:type_v']						= 'Video';
$lang['files:type_d']						= 'Dokumentai';
$lang['files:type_i']						= 'Nuotraukos';
$lang['files:type_o']						= 'Kiti';

/* End of file files_lang.php */