<?php defined('BASEPATH') OR exit('No direct script access allowed');

// General
$lang['files:files_title']					= 'Tiedostot';
$lang['files:fetching']						= 'Vastaanotetaan dataa...';
$lang['files:fetch_completed']				= 'Valmis';
$lang['files:save_failed']					= 'Pahoittelut. Muutoksia ei voitu tallentaa';
$lang['files:item_created']					= '"%s" luotiin';
$lang['files:item_updated']					= '"%s" päivitettiin';
$lang['files:item_deleted']					= '"%s" poistettiin';
$lang['files:item_not_deleted']				= '"%s" ei voitu poistaa';
$lang['files:item_not_found']				= 'Pahoittelut. "%s" ei löytynyt';
$lang['files:sort_saved']					= 'Järjestys tallennettu';
$lang['files:no_permissions']				= 'Sinulla ei ole tarpeeksi oikeuksia';

// Labels
$lang['files:activity']						= 'Activity'; # translate
$lang['files:places']						= 'Paikat';
$lang['files:back']							= 'Takaisin';
$lang['files:forward']						= 'Eteenpäin';
$lang['files:start']						= 'Aloita lataus';
$lang['files:details']						= 'Tiedot';
$lang['files:id']							= 'ID';
$lang['files:name']							= 'Nimi';
$lang['files:slug']							= 'Polkutunnus';
$lang['files:path']							= 'Polku';
$lang['files:added']						= 'Lisätty';
$lang['files:width']						= 'Leveys';
$lang['files:height']						= 'Korkeus';
$lang['files:ratio']						= 'Suhde';
$lang['files:alt_attribute']				= 'Alt attribuutti';
$lang['files:full_size']					= 'Täysi koko';
$lang['files:filename']						= 'Tiedostonimi';
$lang['files:filesize']						= 'Tiedostokoko';
$lang['files:download_count']				= 'Ladattu kpl';
$lang['files:download']						= 'Lataa';
$lang['files:location']						= 'Sijainti';
$lang['files:keywords']						= 'Avainsanat';
$lang['files:toggle_data_display']			= 'Näytä/piilota tiedot';
$lang['files:description']					= 'Kuvaus';
$lang['files:container']					= 'Container'; # translate
$lang['files:bucket']						= 'Bucket'; # translate
$lang['files:check_container']				= 'Tarkista oikeellisuus';
$lang['files:search_message']				= 'Kirjoita hakusana';
$lang['files:search']						= 'Etsi';
$lang['files:synchronize']					= 'Synkronisoi';
$lang['files:uploader']						= 'Vedä tiedostot tähän <br />tai<br />Klikkaa valitaksesi tiedostot';
$lang['files:replace_file']					= 'Korvaa tiedosto';

// Context Menu
$lang['files:refresh']						= 'Päivitä';
$lang['files:open']							= 'Avaa';
$lang['files:new_folder']					= 'Uusi kansio';
$lang['files:upload']						= 'Siirrä tiedosto palvelimelle';
$lang['files:rename']						= 'Nimeä uudelleen';
$lang['files:replace']						= 'Korvaa';
$lang['files:delete']						= 'Poista';
$lang['files:edit']							= 'Muokkaa';
$lang['files:details']						= 'Tiedot';

// Folders

$lang['files:no_folders']					= 'Tiedostoja ja kansioita hallinoidaan kuten työpöydälläkin. Klikkaa oikealla hiiren napilla alhaalta lisätäksesi kansioita. Sitten klikkaa oikealla hiiren napilla nimetäksesi uudelleen, poistaa, siirtää palvelimelle tiedostoja tai muuttaa sen tietoja.';
$lang['files:no_folders_places']			= 'Kansiot ilmestyvät tähän. Voit avata ja sulkea kansipuuta. Klikkaa "Paikat" valitaksesi juurikansion.';
$lang['files:no_folders_wysiwyg']			= 'Kansioita ei luotu vielä';
$lang['files:new_folder_name']				= 'Nimetön kansio';
$lang['files:folder']						= 'Kansio';
$lang['files:folders']						= 'Kansiot';
$lang['files:select_folder']				= 'Valitse kansio';
$lang['files:subfolders']					= 'Alakansiot';
$lang['files:root']							= 'Juuri';
$lang['files:no_subfolders']				= 'Ei alakansioita';
$lang['files:folder_not_empty']				= 'Sinun tulee poistaa kansion "%s" sisältö ensin';
$lang['files:mkdir_error']					= 'Kansiota %s ei voitu luoda. Sinun tulee lisätä se manuaalisesti';
$lang['files:chmod_error']					= 'Palvelimen kansioon ei voida kirjoittaa. Sen tulee olla 0777';
$lang['files:location_saved']				= 'Kansion sijainti on tallennettu';
$lang['files:container_exists']				= '"%s" exists. Save to link its contents to this folder';  # translate
$lang['files:container_not_exists']			= '"%s" does not exist in your account. Save and we will try to create it';  # translate
$lang['files:error_container']				= '"%s" could not be created and we could not determine the reason';  # translate
$lang['files:container_created']			= '"%s" has been created and is now linked to this folder';  # translate
$lang['files:unwritable']					= '"%s":n ei voida kirjoittaa, aseta sille 0777 oikeudet';
$lang['files:specify_valid_folder']			= 'Sinun tulee määrittää kelpo kansio, jotta voit siirtää siihen tiedostoja';
$lang['files:enable_cdn']					= 'Sinun tulee laittaa CDN päälle "%s" varten Rackspace hallintapaneelista ennen kuin voit synkronisoida';
$lang['files:synchronization_started']		= 'Aloitetaan synkronisointi';
$lang['files:synchronization_complete']		= 'Synkronisointi "%s" on valmis';
$lang['files:untitled_folder']				= 'Nimetön kansio';

// Files
$lang['files:no_files']						= 'Ei tiedostoja';
$lang['files:file_uploaded']				= '"%s" on siiretty palvelimelle';
$lang['files:unsuccessful_fetch']			= '"%s" ei voitu hakea. Oletko varma, että se on julkinen tiedosto?';
$lang['files:invalid_container']			= '"%s" does not appear to be a valid container.'; # translate
$lang['files:no_records_found']				= 'Ei merkintöjä';
$lang['files:invalid_extension']			= '"%s" tiedostopääte ei kelpaa';
$lang['files:upload_error']					= 'Tiedoston siirtäminen palvelimelle epäonnistui';
$lang['files:description_saved']			= 'Tiedoston tiedot on tallennettu';
$lang['files:alt_saved']					= 'Kuvan ALT attribuutti on tallennettu';
$lang['files:file_moved']					= '"%s" siirettiin onnistuneesti';
$lang['files:exceeds_server_setting']		= 'Palvelin ei voi käsitellä näin isoa tiedostoa';
$lang['files:exceeds_allowed']				= 'Tiedosto ylittää tiedostokoko rajoitukset';
$lang['files:file_type_not_allowed']		= 'Tämän tyyppinen tiedosto ei ole sallittu';
$lang['files:replace_warning']				= 'Varoitus: Älä korvaa tiedostoa toisella tyypillä (esim. .jpg tiedosto .png:llä)';
$lang['files:type_a']						= 'Audio';
$lang['files:type_v']						= 'Video';
$lang['files:type_d']						= 'Dokumentti';
$lang['files:type_i']						= 'Kuva';
$lang['files:type_o']						= 'Muu';

/* End of file files_lang.php */